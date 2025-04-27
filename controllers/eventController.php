<?php
require_once __DIR__ . '/../config/eventos.php';

class EventController {
    private $eventos;

    public function __construct() {
        $this->eventos = include __DIR__ . '/../config/eventos.php';
    }

    // Função para listar eventos
    public function listEvents() {
        return $this->eventos;
    }
}
?>
