<?php
session_start();
require_once __DIR__ . '/../../controllers/EventController.php';

$eventId = $_GET['id'] ?? null;
$eventController = new EventController();
$evento = $eventController->getEventById($eventId);

if (!$evento) {
    echo "Evento não encontrado.";
    exit;
}

// Corrige o número de participantes inscritos buscando do banco
$participantesInscritos = $eventController->getNumeroInscritos($evento->getId());

// Verifica se o usuário está logado e se já está inscrito
$usuarioInscrito = false;
$vagasDisponiveis = $evento->getCapacidade() - $participantesInscritos;
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id'])) {
    $eventosInscritos = $eventController->getEventosInscritosUsuario($_SESSION['usuario']['id']);
    $usuarioInscrito = in_array($evento->getId(), $eventosInscritos);
}
$status = $usuarioInscrito ? 'Inscrito' : ($vagasDisponiveis > 0 ? 'Disponível' : 'Esgotado');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
    <style>
        body {
            background: linear-gradient(120deg, #f8fafc 0%, #e3e6f0 100%);
        }
        .details-container {
            background: #fff;
            border-radius: 16px;
            padding: 32px 32px 24px 32px;
            box-shadow: 0 8px 32px rgba(80, 80, 160, 0.10);
            max-width: 600px;
            margin: 0 auto;
            margin-top: 40px;
            animation: fadeIn 0.7s;
        }
        .details-container h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: #3a3a5a;
        }
        .details-list {
            list-style: none;
            padding: 0;
            margin-bottom: 24px;
        }
        .details-list li {
            margin-bottom: 10px;
            font-size: 1.08rem;
        }
        .badge-status {
            font-size: 1rem;
            padding: 0.5em 1em;
            border-radius: 20px;
            margin-bottom: 18px;
        }
        .btn-inscrever {
            font-size: 1.1rem;
            padding: 0.6em 2em;
            border-radius: 30px;
            margin-right: 10px;
        }
        .btn-back {
            margin-top: 20px;
            border-radius: 30px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php include(__DIR__ . '/../common/Alert.php'); ?>
    <div class="container">
        <div class="details-container shadow animated fade-in">
            <h1><?php echo htmlspecialchars($evento->getTitulo()); ?></h1>
            <span class="badge badge-status bg-<?php echo $status === 'Inscrito' ? 'success' : ($status === 'Disponível' ? 'primary' : 'secondary'); ?>">Status: <?php echo $status; ?></span>
            <ul class="details-list">
                <li><strong>Data:</strong> <?php echo htmlspecialchars($evento->getDataHora()); ?></li>
                <li><strong>Número Máximo de Participantes:</strong> <?php echo htmlspecialchars($evento->getCapacidade()); ?></li>
                <li><strong>Participantes Inscritos:</strong> <?php echo htmlspecialchars($participantesInscritos); ?></li>
            </ul>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] !== 'admin'): ?>
                <?php if ($usuarioInscrito): ?>
                    <button class="btn btn-success btn-inscrever" disabled>Inscrito</button>
                <?php elseif ($vagasDisponiveis > 0): ?>
                    <form method="POST" action="/controllers/inscricaoController.php?id=<?php echo htmlspecialchars($evento->getId()); ?>" style="display: inline;">
                        <button type="submit" class="btn btn-primary btn-inscrever">Inscrever-se</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary btn-inscrever" disabled>Esgotado</button>
                <?php endif; ?>
            <?php endif; ?>
            <a href="/views/dashboard/dashboardUsuario.php" class="btn btn-outline-dark btn-back">Voltar</a>
        </div>
    </div>
</body>
</html>