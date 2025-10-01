<?php
// index.php
// Configurações para depuração (ATIVAR PARA VER ERROS DETALHADOS, DESATIVAR EM PRODUÇÃO!)
ini_set('display_errors', 1); // ATIVA A EXIBIÇÃO DE ERROS NO NAVEGADOR
ini_set('display_startup_errors', 1); // ATIVA ERROS DE INICIALIZAÇÃO
error_reporting(E_ALL); // Reporta todos os tipos de erros para o log

// Set headers for JSON API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin (for development)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclua os controladores necessários
require_once __DIR__ . '/api/controllers/SolicitacaoController.php';
require_once __DIR__ . '/api/controllers/ClienteController.php';

// Obtém a URI da requisição e o método
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// IMPORTANT: Ajuste esta linha para o caminho do seu projeto no servidor web
$basePath = '/solicitacoes_mvc';
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// Instancie os controladores com verificação de existência da classe
if (class_exists('SolicitacaoController')) {
    $solicitacaoController = new SolicitacaoController();
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno: Classe SolicitacaoController não encontrada. Verifique api/controllers/SolicitacaoController.php']);
    exit();
}

if (class_exists('ClienteController')) {
    $clienteController = new ClienteController();
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno: Classe ClienteController não encontrada. Verifique api/controllers/ClienteController.php ou suas dependências.']);
    exit();
}


// Roteamento
switch ($requestUri) {
    case '/api/solicitacoes':
        if ($requestMethod === 'GET') {
            $solicitacaoController->getAll();
        } elseif ($requestMethod === 'POST') {
            $solicitacaoController->create();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes']);
        }
        break;
    case '/api/solicitacoes/upload_image':
        if ($requestMethod === 'POST') {
            $solicitacaoController->uploadImage();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/upload_image']);
        }
        break;
    // Rota para atualizar o ID do card do Trello e o Status (nome da lista)
    case '/api/solicitacoes/update_trello_card_id': 
        if ($requestMethod === 'POST') {
            $solicitacaoController->updateTrelloInfo();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/update_trello_card_id']);
        }
        break;
    // Nova rota para buscar solicitação pelo Trello Card ID (para a página do cliente)
    case '/api/solicitacoes/by_trello_card_id':
        if ($requestMethod === 'POST') { // Usamos POST para enviar o ID no corpo
            $solicitacaoController->getSolicitacaoByTrelloCardId();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/by_trello_card_id']);
        }
        break;

    
    // **NOVA ROTA**: para atualizar o status. Deve vir ANTES da rota genérica abaixo.
    case (preg_match('/^\/api\/solicitacoes\/(\d+)\/status$/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        if ($requestMethod === 'PUT') {
            $solicitacaoController->updateStatus($id);
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido.']);
        }
        break;

    case (preg_match('/^\/api\/solicitacoes\/(\d+)$/', $requestUri, $matches) ? true : false): // Rota com ID para PUT (atualização completa)
        $id = $matches[1];
        if ($requestMethod === 'PUT') {
            $solicitacaoController->update($id);
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/{id}']);
        }
        break;
    case '/api/dashboard':
        if ($requestMethod === 'GET') {
            $solicitacaoController->getDashboardMetrics();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/dashboard']);
        }
        break;
        
     case '/api/solicitacoes/historico':
        if ($requestMethod === 'GET') {
            $solicitacaoController->getHistory();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/historico']);
        } 
        break;

    case (preg_match('/^\/api\/clientes\/(\d+)$/', $requestUri, $matches) ? true : false): // Rota com ID para PUT/DELETE
        $id = $matches[1];
        if ($requestMethod === 'PUT') {
            $clienteController->update($id);
        } elseif ($requestMethod === 'DELETE') {
            $clienteController->delete($id);
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/clientes/{id}']);
        }
        break;

        
    case '/api/clientes': // Rota para GET/POST sem ID
        if ($requestMethod === 'GET') {
            $clienteController->getAll();
        } elseif ($requestMethod === 'POST') {
            $clienteController->create();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/clientes']);
        }
        break;

         case (preg_match('/^\/api\/solicitacoes\/by_client\/?$/', $requestUri, $matches) ? true : false):
        if ($requestMethod === 'POST') {
            $solicitacaoController->getSolicitacoesByClientEmail();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método Não Permitido para /api/solicitacoes/by_client']);
        }
        break;

        

    default:
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'message' => 'Endpoint não encontrado.']);
        break;
}