<?php
require_once __DIR__ . '/../../config/eventos.php';
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

if (!isset($_SESSION['inscricoes'])) {
    $_SESSION['inscricoes'] = [];
}

if (in_array($eventoId, $_SESSION['inscricoes'])) {
    header('Location: /views/dashboard/dashboardUsuario.php?error=voce_ja_esta_inscrito');
    exit;
}

try {
    $eventController->registerUser($eventoId);
    $_SESSION['inscricoes'][] = $eventoId;
    header('Location: /views/dashboard/dashboardUsuario.php?success=inscricao_realizada');
    exit;
} catch (Exception $e) {
    header('Location: /views/dashboard/dashboardUsuario.php?error=' . urlencode($e->getMessage()));
    exit;
}