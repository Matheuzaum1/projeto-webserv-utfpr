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
    <style>
        body[data-theme='dark'] {
            background-color: #181a1b;
            color: #e0e0e0;
        }
        body[data-theme='dark'] .navbar,
        body[data-theme='dark'] .navbar-light,
        body[data-theme='dark'] .navbar-light .navbar-nav .nav-link,
        body[data-theme='dark'] .navbar-light .navbar-brand {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
        }
        body[data-theme='dark'] .table {
            background-color: #23272b !important;
            color: #e0e0e0;
        }
        body[data-theme='dark'] .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #23272b;
        }
        body[data-theme='dark'] .table-striped > tbody > tr:nth-of-type(even) {
            background-color: #181a1b;
        }
        body[data-theme='dark'] .table-light th {
            background-color: #343a40 !important;
            color: #e0e0e0 !important;
        }
        body[data-theme='dark'] .form-select,
        body[data-theme='dark'] .form-control {
            background-color: #23272b;
            color: #e0e0e0;
            border-color: #444;
        }
        body[data-theme='dark'] .form-select:focus,
        body[data-theme='dark'] .form-control:focus {
            background-color: #23272b;
            color: #fff;
            border-color: #0d6efd;
        }
        body[data-theme='dark'] .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
        body[data-theme='dark'] .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        body[data-theme='dark'] .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        body[data-theme='dark'] .btn-outline-primary {
            color: #0d6efd;
            border-color: #0d6efd;
            background: transparent;
        }
        body[data-theme='dark'] .btn-outline-primary:hover {
            background: #0d6efd;
            color: #fff;
        }
        body[data-theme='dark'] .btn-outline-secondary {
            color: #adb5bd;
            border-color: #adb5bd;
            background: transparent;
        }
        body[data-theme='dark'] .btn-outline-secondary:hover {
            background: #adb5bd;
            color: #23272b;
        }
        body[data-theme='dark'] .badge.bg-success {
            background-color: #198754 !important;
            color: #fff;
        }
        body[data-theme='dark'] .alert {
            background-color: #23272b;
            color: #e0e0e0;
            border-color: #444;
        }
        body[data-theme='dark'] a,
        body[data-theme='dark'] a.text-decoration-underline {
            color: #7ecbff;
        }
        body[data-theme='dark'] h1,
        body[data-theme='dark'] h2,
        body[data-theme='dark'] th,
        body[data-theme='dark'] label,
        body[data-theme='dark'] .form-label {
            color: #fafafa !important;
        }
        body[data-theme='dark'] .badge,
        body[data-theme='dark'] .btn,
        body[data-theme='dark'] .form-select,
        body[data-theme='dark'] .form-control {
            font-weight: 500;
        }
        .accessibility-bar {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }
        .accessibility-bar button {
            min-width: 40px;
        }
        .focus-visible {
            outline: 2px solid #0d6efd !important;
            outline-offset: 2px;
        }
    </style>
</head>
<body data-theme="light">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" aria-label="Menu principal">
        <div class="container">
            <a class="navbar-brand" href="#">Projeto Web UTFPR</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="/index.php?action=logout" class="btn btn-danger" tabindex="0">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="flex-grow-1" tabindex="-1">
    <div class="container mt-5">
        <div class="accessibility-bar" aria-label="Barra de acessibilidade">
            <button id="increase-font" class="btn btn-outline-primary" aria-label="Aumentar fonte" tabindex="0">A+</button>
            <button id="decrease-font" class="btn btn-outline-primary" aria-label="Diminuir fonte" tabindex="0">A-</button>
            <button id="toggle-theme" class="btn btn-outline-secondary" aria-label="Alternar modo escuro/claro" tabindex="0">🌙/☀️</button>
        </div>
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário'); ?>!</h1>
        <?php echo $alerta; ?>

        <script>
            // Acessibilidade: foco visível
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('user-is-tabbing');
                }
            });
            document.addEventListener('mousedown', function() {
                document.body.classList.remove('user-is-tabbing');
            });
            document.querySelectorAll('a, button, select, input').forEach(function(el) {
                el.addEventListener('focus', function() {
                    if(document.body.classList.contains('user-is-tabbing')) {
                        el.classList.add('focus-visible');
                    }
                });
                el.addEventListener('blur', function() {
                    el.classList.remove('focus-visible');
                });
            });
            // Aumentar/diminuir fonte
            let fontSize = 1;
            document.getElementById('increase-font').onclick = function() {
                fontSize += 0.1;
                document.body.style.fontSize = fontSize + 'em';
            };
            document.getElementById('decrease-font').onclick = function() {
                fontSize = Math.max(0.8, fontSize - 0.1);
                document.body.style.fontSize = fontSize + 'em';
            };
            // Alternar tema escuro/claro
            document.getElementById('toggle-theme').onclick = function() {
                const theme = document.body.getAttribute('data-theme');
                document.body.setAttribute('data-theme', theme === 'dark' ? 'light' : 'dark');
            };
        </script>

        <h2 class="mt-5">Eventos Disponíveis</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <label for="filter" class="form-label me-2">Filtrar por:</label>
            <select id="filter" class="form-select w-auto" onchange="filterEvents()" aria-label="Filtrar eventos">
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

        <table class="table table-striped table-hover" aria-label="Tabela de eventos">
            <thead class="table-light">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Data</th>
                    <th scope="col">Vagas Disponíveis</th>
                    <th scope="col">Ação</th>
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
                            <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento->getId(); ?>" class="text-decoration-underline" tabindex="0" aria-label="Detalhes do evento <?php echo htmlspecialchars($evento->getTitulo() ?? ''); ?>">
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
                                        <button type="submit" class="btn btn-danger btn-sm" aria-label="Desinscrever-se do evento <?php echo htmlspecialchars($evento->getTitulo() ?? ''); ?>">Desinscrever-se</button>
                                    </form>
                                </div>
                            <?php elseif ($vagasDisponiveis > 0): ?>
                                <div style="min-width: 220px;">
                                    <form method="POST" action="/controllers/inscricaoController.php?id=<?php echo htmlspecialchars($evento->getId()); ?>" style="display: inline; width: 100%;">
                                        <button type="submit" class="btn btn-primary btn-sm w-100" aria-label="Inscrever-se no evento <?php echo htmlspecialchars($evento->getTitulo() ?? ''); ?>">Inscrever-se</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div style="min-width: 220px;">
                                    <button class="btn btn-secondary btn-sm w-100" disabled aria-label="Evento esgotado">Esgotado</button>
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