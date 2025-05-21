<?php
require_once("modelo/Banco.php");

class Demanda implements JsonSerializable
{
    private $id;
    private $titulo;
    private $descricao;
    private $data_criacao;
    private $data_vencimento;
    private $status;
    private $posicao_lista;
    private $id_lista_trello;
    private $responsavel_id;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id = $this->id;
        $obj->titulo = $this->titulo;
        $obj->descricao = $this->descricao;
        $obj->data_criacao = $this->data_criacao;
        $obj->data_vencimento = $this->data_vencimento;
        $obj->status = $this->status;
        $obj->posicao_lista = $this->posicao_lista;
        $obj->id_lista_trello = $this->id_lista_trello;
        $obj->responsavel_id = $this->responsavel_id;
        return $obj;
    }

    public function create()
    {
        $con = Banco::getConexao();
        $sql = "INSERT INTO demandas 
            (titulo, descricao, data_criacao, data_vencimento, status, posicao_lista, id_lista_trello, responsavel_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "sssssssi",
            $this->titulo,
            $this->descricao,
            $this->data_criacao,
            $this->data_vencimento,
            $this->status,
            $this->posicao_lista,
            $this->id_lista_trello,
            $this->responsavel_id
        );
        $executou = $stmt->execute();
        $this->id = $con->insert_id;
        return $executou;
    }

    public function update()
    {
        $con = Banco::getConexao();
        $sql = "UPDATE demandas SET 
            titulo = ?, descricao = ?, data_criacao = ?, data_vencimento = ?, status = ?, 
            posicao_lista = ?, id_lista_trello = ?, responsavel_id = ? 
            WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "sssssssii",
            $this->titulo,
            $this->descricao,
            $this->data_criacao,
            $this->data_vencimento,
            $this->status,
            $this->posicao_lista,
            $this->id_lista_trello,
            $this->responsavel_id,
            $this->id
        );
        return $stmt->execute();
    }

    public function delete()
    {
        $con = Banco::getConexao();
        $sql = "DELETE FROM demandas WHERE id = ?;";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function readAll()
    {
        $con = Banco::getConexao();
        $sql = "SELECT * FROM demandas ORDER BY data_criacao DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($row = $result->fetch_object()) {
            $d = new Demanda();
            $d->setFromRow($row);
            $lista[] = $d;
        }
        return $lista;
    }

    public function readById()
    {
        $con = Banco::getConexao();
        $sql = "SELECT * FROM demandas WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($row = $result->fetch_object()) {
            $d = new Demanda();
            $d->setFromRow($row);
            $lista[] = $d;
        }
        return $lista;
    }

    private function setFromRow($row)
    {
        $this->id = $row->id;
        $this->titulo = $row->titulo;
        $this->descricao = $row->descricao;
        $this->data_criacao = $row->data_criacao;
        $this->data_vencimento = $row->data_vencimento;
        $this->status = $row->status;
        $this->posicao_lista = $row->posicao_lista;
        $this->id_lista_trello = $row->id_lista_trello;
        $this->responsavel_id = $row->responsavel_id;
    }

    // Getters e Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }

    public function getDescricao() { return $this->descricao; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }

    public function getDataCriacao() { return $this->data_criacao; }
    public function setDataCriacao($data) { $this->data_criacao = $data; }

    public function getDataVencimento() { return $this->data_vencimento; }
    public function setDataVencimento($data) { $this->data_vencimento = $data; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getPosicaoLista() { return $this->posicao_lista; }
    public function setPosicaoLista($posicao) { $this->posicao_lista = $posicao; }

    public function getIdListaTrello() { return $this->id_lista_trello; }
    public function setIdListaTrello($idLista) { $this->id_lista_trello = $idLista; }

    public function getResponsavelId() { return $this->responsavel_id; }
    public function setResponsavelId($idResponsavel) { $this->responsavel_id = $idResponsavel; }
}
?>
