<?php
session_start();

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['tipo'], ['usuario', 'participante'])) {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}

require_once __DIR__ . '/../../controllers/eventController.php';
$eventController = new EventController();
$eventos = $eventController->listEvents();
$eventosInscritos = $eventController->getEventosInscritosUsuario($_SESSION['usuario']['id']);

// Removido require de inscricoes.php pois agora tudo é feito via banco de dados
$inscricoes = [];

$alerta = '';
if (isset($_GET['success']) && $_GET['success'] === 'inscricao') {
    $alerta = '<div class="alert alert-success alert-dismissible fade show" role="alert">Inscrição realizada com sucesso!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
} elseif (isset($_GET['success']) && $_GET['success'] === 'desinscricao') {
    $alerta = '<div class="alert alert-warning alert-dismissible fade show" role="alert">Você se desinscreveu do evento.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
} elseif (isset($_GET['info']) && $_GET['info'] === 'ja_inscrito') {
    $alerta = '<div class="alert alert-info alert-dismissible fade show" role="alert">Você já está inscrito neste evento.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Projeto Web UTFPR</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="/index.php?action=logout" class="btn btn-danger">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="flex-grow-1">
    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário'); ?>!</h1>
        <?php echo $alerta; ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.alert .btn-close').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var alert = btn.closest('.alert');
                        if (alert) alert.remove();
                    });
                });
            });
        </script>

        <h2 class="mt-5">Eventos Disponíveis</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <label for="filter" class="form-label me-2">Filtrar por:</label>
            <select id="filter" class="form-select w-auto" onchange="filterEvents()">
                <option value="all">Todos</option>
                <option value="inscrito">Inscritos</option>
                <option value="disponivel">Disponíveis</option>
                <option value="esgotado">Esgotados</option>
            </select>
        </div>

        <script>
            function filterEvents() {
                const filter = document.getElementById('filter').value;
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (filter === 'all' || filter === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        </script>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Vagas Disponíveis</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <?php
                    $vagasDisponiveis = $evento->getCapacidade() - $evento->getParticipantes();
                    $usuarioJaInscrito = in_array($evento->getId(), $eventosInscritos);
                    $status = $usuarioJaInscrito ? 'inscrito' : ($vagasDisponiveis > 0 ? 'disponivel' : 'esgotado');
                    $rowClass = '';
                    if ($vagasDisponiveis <= 0) {
                        $rowClass = $usuarioJaInscrito ? 'table-success' : 'table-danger';
                    }
                    ?>
                    <tr data-status="<?php echo $status; ?>" class="<?php echo $rowClass; ?>">
                        <td>
                            <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento->getId(); ?>" class="text-decoration-underline">
                                <?php echo htmlspecialchars($evento->getTitulo() ?? ''); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($evento->getDataHora() ?? ''); ?></td>
                        <td><?php echo $vagasDisponiveis > 0 ? $vagasDisponiveis : 'Esgotado'; ?></td>
                        <td>
                            <?php if ($usuarioJaInscrito): ?>
                                <div class="d-flex align-items-center gap-2" style="min-width: 220px;">
                                    <span class="badge bg-success">Inscrito</span>
                                    <form method="POST" action="/controllers/inscricaoController.php?id=<?php echo htmlspecialchars($evento->getId()); ?>&action=cancelar" onsubmit="return confirm('Tem certeza que deseja se desinscrever deste evento?');">
                                        <button type="submit" class="btn btn-danger btn-sm">Desinscrever-se</button>
                                    </form>
                                </div>
                            <?php elseif ($vagasDisponiveis > 0): ?>
                                <div style="min-width: 220px;">
                                    <form method="POST" action="/controllers/inscricaoController.php?id=<?php echo htmlspecialchars($evento->getId()); ?>" style="display: inline; width: 100%;">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">Inscrever-se</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div style="min-width: 220px;">
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Esgotado</button>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include(__DIR__ . '/../common/Footer.php'); ?>
</body>
</html>