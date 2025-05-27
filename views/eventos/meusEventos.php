<?php
session_start();
$eventos = require __DIR__ . '/../../config/eventos.php';
$inscricoes = require __DIR__ . '/../../config/inscricoes.php';
$usuarioId = $_SESSION['usuario']['id'] ?? null;
include(__DIR__ . '/../common/Header.php');
// Filtra eventos em que o usuário está inscrito
$meusEventos = array();
if ($usuarioId) {
    foreach ($inscricoes as $inscricao) {
        if ($inscricao['usuario_id'] == $usuarioId) {
            foreach ($eventos as $evento) {
                if ($evento['id'] == $inscricao['evento_id']) {
                    $meusEventos[] = $evento;
                }
            }
        }
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
        <?php else: ?>
            <?php foreach ($meusEventos as $evento): ?>
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
