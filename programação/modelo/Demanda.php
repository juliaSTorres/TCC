<?php
    require_once("modelo/Banco.php");

    class Demanda implements JsonSerializable{
        private $id;
        private $titulo;
        private $descricao;
        private $data_criacao;
        private $data_vencimento;
        private $status;
        private $posicao_lista;
        private $id_lista_trello;
        private $responsavel_id;

        public function jsonSerialize(){
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

        public function create(){
            $conexao = Banco::getConexao();
            $sql = "INSERT INTO demandas (
                titulo,
                descricao,
                data_vencimento,
                status,
                posicao_lista,
                id_lista_trello,
                responsavel_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
        }

        
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of titulo
         */ 
        public function getTitulo()
        {
                return $this->titulo;
        }

        /**
         * Set the value of titulo
         *
         * @return  self
         */ 
        public function setTitulo($titulo)
        {
                $this->titulo = $titulo;

                return $this;
        }

        /**
         * Get the value of descricao
         */ 
        public function getDescricao()
        {
                return $this->descricao;
        }

        /**
         * Set the value of descricao
         *
         * @return  self
         */ 
        public function setDescricao($descricao)
        {
                $this->descricao = $descricao;

                return $this;
        }

        /**
         * Get the value of data_criacao
         */ 
        public function getData_criacao()
        {
                return $this->data_criacao;
        }

        /**
         * Set the value of data_criacao
         *
         * @return  self
         */ 
        public function setData_criacao($data_criacao)
        {
                $this->data_criacao = $data_criacao;

                return $this;
        }

        /**
         * Get the value of data_vencimento
         */ 
        public function getData_vencimento()
        {
                return $this->data_vencimento;
        }

        /**
         * Set the value of data_vencimento
         *
         * @return  self
         */ 
        public function setData_vencimento($data_vencimento)
        {
                $this->data_vencimento = $data_vencimento;

                return $this;
        }

        /**
         * Get the value of status
         */ 
        public function getStatus()
        {
                return $this->status;
        }

        /**
         * Set the value of status
         *
         * @return  self
         */ 
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        /**
         * Get the value of posicao_lista
         */ 
        public function getPosicao_lista()
        {
                return $this->posicao_lista;
        }

        /**
         * Set the value of posicao_lista
         *
         * @return  self
         */ 
        public function setPosicao_lista($posicao_lista)
        {
                $this->posicao_lista = $posicao_lista;

                return $this;
        }

        /**
         * Get the value of id_lista_trello
         */ 
        public function getId_lista_trello()
        {
                return $this->id_lista_trello;
        }

        /**
         * Set the value of id_lista_trello
         *
         * @return  self
         */ 
        public function setId_lista_trello($id_lista_trello)
        {
                $this->id_lista_trello = $id_lista_trello;

                return $this;
        }

        /**
         * Get the value of responsavel_id
         */ 
        public function getResponsavel_id()
        {
                return $this->responsavel_id;
        }

        /**
         * Set the value of responsavel_id
         *
         * @return  self
         */ 
        public function setResponsavel_id($responsavel_id)
        {
                $this->responsavel_id = $responsavel_id;

                return $this;
        }
    }
?>
