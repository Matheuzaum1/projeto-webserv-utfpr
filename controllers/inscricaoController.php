<?php
require_once __DIR__ . '/../config/eventos.php';
require_once __DIR__ . '/../config/inscricoes.php';
require_once __DIR__ . '/eventController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo "Acesso negado. Faça login para se inscrever.";
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];
$eventoId = $_GET['id'] ?? null;

if (!$eventoId) {
    http_response_code(400);
    echo "ID do evento não fornecido.";
    exit;
}

$eventController = new EventController();
$evento = $eventController->getEventById($eventoId);

if (!$evento) {
    http_response_code(404);
    echo "Evento não encontrado.";
    exit;
}

$inscricoes = include __DIR__ . '/../config/inscricoes.php';

if (!is_array($inscricoes)) {
    $inscricoes = [];
}

foreach ($inscricoes as $inscricao) {
    if ($inscricao['usuario_id'] === $usuarioId && $inscricao['evento_id'] == $eventoId) {
        header('Location: /views/dashboard/dashboardUsuario.php?error=voce_ja_esta_inscrito');
        exit;
    }
}

if ($evento['participantes'] >= $evento['max_participantes']) {
    header('Location: /views/dashboard/dashboardUsuario.php?error=evento_lotado');
    exit;
}

try {
    $eventController->registerUser($eventoId);

    $inscricoes[] = [
        'usuario_id' => $usuarioId,
        'evento_id' => $eventoId
    ];

    if (file_put_contents(__DIR__ . '/../config/inscricoes.php', '<?php return ' . var_export($inscricoes, true) . ';') === false) {
        throw new Exception('Erro ao salvar a inscrição.');
    }

    header('Location: /views/dashboard/dashboardUsuario.php?success=inscricao_realizada');
    exit;
} catch (Exception $e) {
    header('Location: /views/dashboard/dashboardUsuario.php?error=' . urlencode($e->getMessage()));
    exit;
}