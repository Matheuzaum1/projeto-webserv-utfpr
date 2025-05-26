<?php


class Admin extends Usuario {
    private $cargo, $dataContratacao;

    public function __construct($id = null, $nome = null, $email = null, $senha = null, $cargo = null, $dataContratacao = null) {
        parent::__construct($id, $nome, $email, $senha, 'admin');
        $this->cargo = $cargo;
        $this->dataContratacao = $dataContratacao;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function getDataContratacao() {
        return $this->dataContratacao;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function setDataContratacao($dataContratacao) {
        $this->dataContratacao = $dataContratacao;
    }
}