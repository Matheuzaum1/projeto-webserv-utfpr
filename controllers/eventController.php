<?php
require_once 'models/Evento.php'; 

class EventController {
    private $evento;  

    public function __construct($db) {
        $this->evento = new Evento($db);  
    }

    // Função para criar um novo evento
    public function createEvent($name, $description, $date) {
        $this->evento->name = $name;  
        $this->evento->description = $description;
        $this->evento->date = $date;
        return $this->evento->create();  
    }

    // Função para listar eventos
    public function listEvents() {
        return $this->evento->read(); 
    }
}
?>
