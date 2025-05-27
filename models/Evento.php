<?php
class Evento {
    private $id, $titulo, $dataHora, $capacidade, $status, $idAdmin;

    public function __construct($id, $titulo, $dataHora, $capacidade, $status, $idAdmin) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->dataHora = $dataHora;
        $this->capacidade = $capacidade;
        $this->status = $status;
        $this->idAdmin = $idAdmin;
    }
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getCapacidade() {
        return $this->capacidade;
    }

    public function getStatus() {
        return $this->status;
    }
    public function getIdAdmin() {
        return $this->idAdmin;
    }

    public function getDataHora(){
        return $this->dataHora;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setIdAdmin($idAdmin) {
        $this->idAdmin = $idAdmin;
    }

}