<?php
require_once __DIR__ . '/../../controllers/EventController.php';

$eventId = $_GET['id'] ?? null;
$eventController = new EventController();
$evento = $eventController->getEventById($eventId);

if (!$evento) {
    echo "Evento não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
</head>
<body>
    <h1>Detalhes do Evento</h1>
    <p><strong>ID:</strong> <?php echo $evento['id']; ?></p>
    <p><strong>Nome:</strong> <?php echo $evento['nome']; ?></p>
    <p><strong>Data:</strong> <?php echo $evento['data']; ?></p>
    <p><strong>Número de Participantes:</strong> <?php echo $evento['participantes']; ?></p>
    <a href="/views/dashboard/dashboardAdmin.php">Voltar</a>
</body>
</html>