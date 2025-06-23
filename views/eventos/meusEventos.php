<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /login?erro=acesso_negado');
    exit;
}

require_once __DIR__ . '/../../controllers/eventController.php';
$eventController = new EventController();
$eventos = $eventController->listEvents();
$eventosInscritos = $eventController->getEventosInscritosUsuario($_SESSION['usuario']['id']);
$usuarioId = $_SESSION['usuario']['id'];
include(__DIR__ . '/../common/Header.php');

// Filtra eventos em que o usuário está inscrito
$meusEventos = array();
foreach ($eventos as $evento) {
    if (in_array($evento->getId(), $eventosInscritos)) {
        $meusEventos[] = $evento;
    }
}
?>
<div class="container mt-5">
    <h1 class="mb-4">Meus Eventos</h1>
    <div class="row">
        <?php if (empty($meusEventos)): ?>
            <div class="col-12">
                <div class="alert alert-info">Você não está inscrito em nenhum evento.</div>
            </div>
        <?php else: ?>            <?php foreach ($meusEventos as $evento): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($evento->getTitulo()); ?></h5>
                            <p class="card-text"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento->getDataHora())); ?></p>
                            <p class="card-text"><strong>Local:</strong> <?php echo htmlspecialchars($evento->getLocal()); ?></p>
                            <p class="card-text"><strong>Participantes:</strong> <?php echo $evento->getParticipantes(); ?> / <?php echo $evento->getCapacidade(); ?></p>
                            <a href="/evento?id=<?php echo $evento->getId(); ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include(__DIR__ . '/../common/Footer.php'); ?>
<?php include(__DIR__ . '/../common/Alert.php'); ?>
