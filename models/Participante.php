<?php


class Participante extends Usuario {
    private $cpf, $dataNascimento;

    public function __construct($id = null, $nome = null, $email = null, $senha = null, $cpf = null, $dataNascimento = null) {
        parent::__construct($id, $nome, $email, $senha, 'participante');
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }
}