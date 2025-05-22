<?php
require_once __DIR__ . '/../models/Evento.php';

class EventController {
    private $eventos;

    public function __construct() {
        $this->eventos = include __DIR__ . '/../config/eventos.php';
    }

    public function listEvents() {
        $inscricoes = include __DIR__ . '/../config/inscricoes.php';
        if (!is_array($inscricoes)) {
            $inscricoes = [];
        }

        foreach ($this->eventos as &$evento) {
            $evento['participantes'] = count(array_filter($inscricoes, function($inscricao) use ($evento) {
                return $inscricao['evento_id'] == $evento['id'];
            }));
        }

        return $this->eventos;
    }

    public function getEventById($id) {
        return Evento::getById($id);
    }

    public function createEvent($nome = null, $data = null, $max_participantes = null) {
        // Se os dados não vierem por parâmetro, tenta pegar do POST
        if ($nome === null) $nome = trim($_POST['nome'] ?? '');
        if ($data === null) $data = trim($_POST['data'] ?? '');
        if ($max_participantes === null) $max_participantes = intval($_POST['max_participantes'] ?? 0);

        // Validação dos inputs
        if (empty($nome) || empty($data) || $max_participantes < 1) {
            header('Location: /views/gerenciamentoEventos/Create.php?erro=campos_invalidos');
            exit;
        }
        if (strlen($nome) < 3) {
            header('Location: /views/gerenciamentoEventos/Create.php?erro=nome_curto');
            exit;
        }
        if (!preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $data)) {
            header('Location: /views/gerenciamentoEventos/Create.php?erro=data_invalida');
            exit;
        }
        if ($max_participantes > 10000) {
            header('Location: /views/gerenciamentoEventos/Create.php?erro=max_participantes_excedido');
            exit;
        }

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

        $inscricoes = include __DIR__ . '/../config/inscricoes.php';
        if (!is_array($inscricoes)) {
            $inscricoes = [];
        }

        $inscricoes = array_filter($inscricoes, function($inscricao) use ($id) {
            return $inscricao['evento_id'] != $id;
        });

        file_put_contents(__DIR__ . '/../config/inscricoes.php', '<?php return ' . var_export($inscricoes, true) . ';');
    }

    public function updateEvent($id, $nome = null, $data = null, $max_participantes = null) {
        if ($nome === null) $nome = trim($_POST['nome'] ?? '');
        if ($data === null) $data = trim($_POST['data'] ?? '');
        if ($max_participantes === null) $max_participantes = intval($_POST['max_participantes'] ?? 0);

        // Validação dos inputs
        if (empty($nome) || empty($data) || $max_participantes < 1) {
            throw new Exception('Preencha todos os campos obrigatórios!');
        }
        if (strlen($nome) < 3) {
            throw new Exception('O nome do evento deve ter pelo menos 3 caracteres.');
        }
        if (!preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $data)) {
            throw new Exception('Data inválida. Use o formato AAAA-MM-DD.');
        }
        if ($max_participantes > 10000) {
            throw new Exception('Número máximo de participantes muito alto.');
        }

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
                    $this->saveEvents();
                    return;
                } else {
                    throw new Exception('Número máximo de participantes atingido.');
                }
            }
        }
        throw new Exception('Evento não encontrado.');
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
        header('Location: /views/auth/login.php?erro=acesso_negado');
        exit;
    }

    $eventController = new EventController();
    try {
        $eventController->deleteEvent($_GET['id']);
        header('Location: /views/dashboard/dashboardAdmin.php?success=evento_deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /views/dashboard/dashboardAdmin.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'register' && isset($_GET['id'])) {
    if (!isset($_SESSION['usuario'])) {
        http_response_code(403);
        header('Location: /views/auth/login.php?erro=acesso_negado');
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
