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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .details-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .details-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        .details-container p {
            font-size: 1rem;
            margin-bottom: 10px;
        }
        .details-container p strong {
            color: #495057;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="details-container">
            <h1>Detalhes do Evento</h1>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($evento['id']); ?></p>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($evento['nome']); ?></p>
            <p><strong>Data:</strong> <?php echo htmlspecialchars($evento['data']); ?></p>
            <p><strong>Número Máximo de Participantes:</strong> <?php echo htmlspecialchars($evento['max_participantes']); ?></p>
            <a href="/views/dashboard/dashboardAdmin.php" class="btn btn-secondary btn-back">Voltar</a>
        </div>
    </div>
</body>
</html>