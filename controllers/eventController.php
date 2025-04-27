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

    public function getEventById($id) {
        foreach ($this->eventos as $evento) {
            if ($evento['id'] == $id) {
                return $evento;
            }
        }
        return null;
    }

    public function createEvent($nome, $data, $participantes) {
        $novoEvento = [
            'id' => count($this->eventos) + 1,
            'nome' => $nome,
            'data' => $data,
            'participantes' => $participantes
        ];
        $this->eventos[] = $novoEvento;

        // Salvar no arquivo eventos.php
        $conteudo = '<?php return ' . var_export($this->eventos, true) . ';';
        if (file_put_contents(__DIR__ . '/../config/eventos.php', $conteudo) === false) {
            throw new Exception('Erro ao salvar o evento no arquivo. Verifique as permissões.');
        }
    }

    public function deleteEvent($id) {
        $this->eventos = array_filter($this->eventos, function($evento) use ($id) {
            return $evento['id'] != $id;
        });

        // Reindexar IDs
        $this->eventos = array_values($this->eventos);
        foreach ($this->eventos as $index => &$evento) {
            $evento['id'] = $index + 1;
        }

        // Salvar no arquivo eventos.php
        file_put_contents(__DIR__ . '/../config/eventos.php', '<?php return ' . var_export($this->eventos, true) . ';');
    }

    public function updateEvent($id, $nome, $data, $participantes) {
        foreach ($this->eventos as &$evento) {
            if ($evento['id'] == $id) {
                $evento['nome'] = $nome;
                $evento['data'] = $data;
                $evento['participantes'] = $participantes;
                break;
            }
        }

        // Salvar no arquivo eventos.php
        file_put_contents(__DIR__ . '/../config/eventos.php', '<?php return ' . var_export($this->eventos, true) . ';');
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $eventController = new EventController();
    $eventController->deleteEvent($_GET['id']);
    http_response_code(200);
    exit;
}
