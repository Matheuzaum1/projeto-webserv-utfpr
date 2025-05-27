<?php
session_start();
$eventos = require __DIR__ . '/../../config/eventos.php';
include(__DIR__ . '/../common/Header.php');
?>
<div class="container mt-5">
    <h1 class="mb-4">Lista de Eventos</h1>
    <div class="row">
        <?php if (empty($eventos)): ?>
            <div class="col-12">
                <div class="alert alert-info">Nenhum evento disponível no momento.</div>
            </div>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($evento['nome']); ?></h5>
                            <p class="card-text"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['data'])); ?></p>
                            <p class="card-text"><strong>Participantes:</strong> <?php echo $evento['participantes']; ?> / <?php echo $evento['max_participantes']; ?></p>
                            <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento['id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include(__DIR__ . '/../common/Footer.php'); ?>
<?php include(__DIR__ . '/../common/Alert.php'); ?>
