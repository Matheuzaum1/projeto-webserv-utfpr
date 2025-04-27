<?php
require_once __DIR__ . '/../models/Evento.php';

class EventController {
    private $eventos;

    public function __construct() {
        $this->eventos = include __DIR__ . '/../config/eventos.php';
    }

    public function listEvents() {
        return Evento::getAll();
    }

    public function getEventById($id) {
        return Evento::getById($id);
    }

    public function createEvent($nome, $data, $max_participantes) {
        $novoEvento = [
            'id' => count($this->eventos) + 1,
            'nome' => $nome,
            'data' => $data,
            'participantes' => 0, 
            'max_participantes' => $max_participantes,
        ];
        $this->eventos[] = $novoEvento;

        $this->saveEvents();
    }

    public function deleteEvent($id) {
        $this->eventos = array_filter($this->eventos, function($evento) use ($id) {
            return $evento['id'] != $id;
        });

        $this->eventos = array_values($this->eventos);
        foreach ($this->eventos as $index => &$evento) {
            $evento['id'] = $index + 1;
        }

        $this->saveEvents();
    }

    public function updateEvent($id, $nome, $data, $max_participantes) {
        foreach ($this->eventos as &$evento) {
            if ($evento['id'] == $id) {
                $evento['nome'] = $nome;
                $evento['data'] = $data;
                $evento['max_participantes'] = $max_participantes;
                break;
            }
        }
        $this->saveEvents();
    }

    public function registerUser($id) {
        foreach ($this->eventos as &$evento) {
            if ($evento['id'] == $id) {
                if ($evento['participantes'] < $evento['max_participantes']) {
                    $evento['participantes']++;
                } else {
                    throw new Exception('Número máximo de participantes atingido.');
                }
                break;
            }
        }
        $this->saveEvents();
    }

    private function saveEvents() {
        file_put_contents(__DIR__ . '/../config/eventos.php', '<?php return ' . var_export($this->eventos, true) . ';');
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
        http_response_code(403);
        echo "Acesso negado. Apenas administradores podem realizar esta ação.";
        exit;
    }

    $eventController = new EventController();
    $eventController->deleteEvent($_GET['id']);
    http_response_code(200);
    echo "Evento deletado com sucesso.";
    exit;
}
if (isset($_GET['action']) && $_GET['action'] === 'register' && isset($_GET['id'])) {
    if (!isset($_SESSION['usuario'])) {
        http_response_code(403);
        echo "Acesso negado. Faça login para se inscrever.";
        exit;
    }

    $eventController = new EventController();
    try {
        $eventController->registerUser($_GET['id']);
        header('Location: /views/dashboard/dashboardUsuario.php?success=inscricao_realizada');
        exit;
    } catch (Exception $e) {
        header('Location: /views/dashboard/dashboardUsuario.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
