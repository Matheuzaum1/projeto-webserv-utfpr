<?php

class Inscricao {
    private $idEvento, $idParticipante, $dataInscricao, $status, $presenca;

    public function __construct($idEvento = null, $idParticipante = null, $dataInscricao = null, $status = null, $presenca = false) {
        $this->idEvento = $idEvento;
        $this->idParticipante = $idParticipante;
        $this->dataInscricao = $dataInscricao;
        $this->status = $status;
        $this->presenca = $presenca;
    }

    public function getIdEvento() {
        return $this->idEvento;
    }

    public function getIdParticipante() {
        return $this->idParticipante;
    }

    public function getDataInscricao() {
        return $this->dataInscricao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function isPresenca() {
        return $this->presenca;
    }

    public function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    public function setIdParticipante($idParticipante) {
        $this->idParticipante = $idParticipante;
    }

    public function setDataInscricao($dataInscricao) {
        $this->dataInscricao = $dataInscricao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setPresenca($presenca) {
        $this->presenca = $presenca;
    }
}