CREATE DATABASE IF NOT EXISTS sistema_demandas;
USE sistema_demandas;

-- Tabela de membros responsáveis
CREATE TABLE membros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    trello_id VARCHAR(255)
);

-- Tabela de rótulos (labels)
CREATE TABLE rotulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(30)
);

-- Tabela principal de demandas
CREATE TABLE demandas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_vencimento DATE,
    status ENUM('pendente', 'aceito', 'cancelado') DEFAULT 'pendente',
    posicao_lista VARCHAR(50),
    id_lista_trello VARCHAR(255),
    responsavel_id INT,
    FOREIGN KEY (responsavel_id) REFERENCES membros(id)
);

-- Tabela de relação N:N entre demandas e membros
CREATE TABLE demandas_membros (
    id_demanda INT,
    id_membro INT,
    PRIMARY KEY (id_demanda, id_membro),
    FOREIGN KEY (id_demanda) REFERENCES demandas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membro) REFERENCES membros(id) ON DELETE CASCADE
);

-- Tabela de relação N:N entre demandas e rótulos
CREATE TABLE demandas_rotulos (
    id_demanda INT,
    id_rotulo INT,
    PRIMARY KEY (id_demanda, id_rotulo),
    FOREIGN KEY (id_demanda) REFERENCES demandas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_rotulo) REFERENCES rotulos(id) ON DELETE CASCADE
);
