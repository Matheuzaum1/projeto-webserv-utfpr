<?php
class Evento {
    private $id, $titulo, $descricao, $local, $dataHora, $duracao, $capacidade, $status, $categoria, $preco, $idAdmin, $participantes;

    public function __construct($id = null, $titulo, $descricao, $local, $dataHora, $duracao, $capacidade, $status, $categoria, $preco, $idAdmin, $participantes = 0) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->local = $local;
        $this->dataHora = $dataHora;
        $this->duracao = $duracao;
        $this->capacidade = $capacidade;
        $this->status = $status;
        $this->categoria = $categoria;
        $this->preco = $preco;
        $this->idAdmin = $idAdmin;
        $this->participantes = $participantes;
    }
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getLocal() {
        return $this->local;
    }

    public function getDataHora() {
        return $this->dataHora;
    }

    public function getDuracao() {
        return $this->duracao;
    }

    public function getCapacidade() {
        return $this->capacidade;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getIdAdmin() {
        return $this->idAdmin;
    }

    public function getParticipantes() {
        return $this->participantes;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setLocal($local) {
        $this->local = $local;
    }

    public function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

    public function setDuracao($duracao) {
        $this->duracao = $duracao;
    }

    public function setCapacidade($capacidade) {
        $this->capacidade = $capacidade;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function setIdAdmin($idAdmin) {
        $this->idAdmin = $idAdmin;
    }

    public function setParticipantes($participantes) {
        $this->participantes = $participantes;
    }
}