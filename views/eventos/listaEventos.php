<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controllers/eventController.php';
$eventController = new EventController();
$eventos = $eventController->listEvents();
include(__DIR__ . '/../common/Header.php');
?>
<div class="container mt-5">
    <h1 class="mb-4">Lista de Eventos</h1>
    <div class="row">
        <?php if (empty($eventos)): ?>
            <div class="col-12">
                <div class="alert alert-info">Nenhum evento disponível no momento.</div>
            </div>
        <?php else: ?>            <?php foreach ($eventos as $evento): ?>
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
