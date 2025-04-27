<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'usuario') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}

$eventos = require_once __DIR__ . '/../../config/eventos.php';
$inscricoes = require_once __DIR__ . '/../../config/inscricoes.php';
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
    <?php include(__DIR__ . '/../common/Header.php'); ?>

    <main class="flex-grow-1">
        <div class="container mt-5">
            <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
            <a href="/index.php?action=logout" class="btn btn-danger mt-3">Logout</a>

        <h2 class="mt-5">Eventos Disponíveis</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                switch ($_GET['success']) {
                    case 'inscricao_realizada':
                        echo 'Inscrição realizada com sucesso!';
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

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
                    $vagasDisponiveis = $evento['max_participantes'] - $evento['participantes'];
                    $usuarioJaInscrito = false;
                    foreach ($inscricoes as $inscricao) {
                        if ($inscricao['usuario_id'] === $_SESSION['usuario']['id'] && $inscricao['evento_id'] == $evento['id']) {
                            $usuarioJaInscrito = true;
                            break;
                        }
                    }

                    $status = $usuarioJaInscrito ? 'inscrito' : ($vagasDisponiveis > 0 ? 'disponivel' : 'esgotado');
                    ?>
                    <tr data-status="<?php echo $status; ?>">
                        <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                        <td><?php echo htmlspecialchars($evento['data']); ?></td>
                        <td><?php echo $vagasDisponiveis > 0 ? $vagasDisponiveis : 'Esgotado'; ?></td>
                        <td>
                            <?php if ($usuarioJaInscrito): ?>
                                <button class="btn btn-success btn-sm" disabled>Já inscrito</button>
                            <?php elseif ($vagasDisponiveis > 0): ?>
                                <form method="POST" action="/controllers/inscricaoController.php?id=<?php echo htmlspecialchars($evento['id']); ?>" style="display: inline;">
                                    <button type="submit" class="btn btn-primary btn-sm">Inscrever-se</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Esgotado</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include(__DIR__ . '/../common/Footer.php'); ?>
</body>
</html>