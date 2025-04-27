<?php
require_once __DIR__ . '/../models/Evento.php';

class EventController {
    public function listEvents() {
        return Evento::getAll();
    }

    public function getEventById($id) {
        return Evento::getById($id);
    }

    public function createEvent($nome, $data, $participantes) {
        Evento::create($nome, $data, $participantes);
    }

    public function deleteEvent($id) {
        Evento::delete($id);
    }

    public function updateEvent($id, $nome, $data, $participantes) {
        Evento::update($id, $nome, $data, $participantes);
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $eventController = new EventController();
    $eventController->deleteEvent($_GET['id']);
    http_response_code(200);
    exit;
}
