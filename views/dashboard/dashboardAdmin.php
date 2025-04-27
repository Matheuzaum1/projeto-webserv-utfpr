<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}

require_once __DIR__ . '/../../controllers/eventController.php';

$eventController = new EventController();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $eventController->deleteEvent($_GET['id']);
    header('Location: /views/dashboard/dashboardAdmin.php?success=evento_deletado');
    exit;
}

$eventos = $eventController->listEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
</head>
<body>
    <?php include(__DIR__ . '/../common/Header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
        <a href="/index.php?action=logout" class="btn btn-danger mt-3" style="font-size: 1rem; padding: 10px 20px; border-radius: 5px;">Logout</a>
        <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <?php
        switch ($_GET['success']) {
            case 'evento_deletado':
                echo 'Evento deletado com sucesso!';
                break;
            case 'evento_criado':
                echo 'Evento criado com sucesso!';
                break;
            case 'evento_atualizado':
                echo 'Evento atualizado com sucesso!';
                break;
            default:
                echo 'Operação realizada com sucesso!';
                break;
        }
        ?>
    </div>
<?php endif; ?>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2>Gerenciamento de Eventos</h2>
            <a href="/views/gerenciamentoEventos/Create.php" class="btn btn-success">Criar Evento</a>
        </div>

        <div class="card mt-4" data-aos="fade-up">
            <h2 class="text-center">Gerenciamento Rápido</h2>
            <form method="GET" action="" class="row g-3" onsubmit="return handleAction(event)">
                <div class="col-md-6">
                    <label for="eventId" class="form-label">ID do Evento:</label>
                    <input type="number" id="eventId" name="id" class="form-control" placeholder="Digite o ID do evento" required>
                </div>
                <div class="col-md-6">
                    <label for="action" class="form-label">Ação:</label>
                    <select id="action" name="action" class="form-select" required>
                        <option value="/views/gerenciamentoEventos/Edit.php">Editar</option>
                        <option value="/views/gerenciamentoEventos/Details.php">Detalhes</option>
                        <option value="delete">Excluir</option>
                    </select>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-3">Executar</button>
                </div>
            </form>
        </div>
        <h2 class="mt-5">Lista de Eventos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Número de Participantes</th>
                    <th>Máximo de Participantes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['id']); ?></td>
                        <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                        <td><?php echo htmlspecialchars($evento['data']); ?></td>
                        <td><?php echo htmlspecialchars($evento['participantes']); ?></td>
                        <td><?php echo htmlspecialchars($evento['max_participantes']); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="/views/gerenciamentoEventos/Edit.php?id=<?php echo $evento['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento['id']; ?>" class="btn btn-info btn-sm">Detalhes</a>
                                <a href="/views/dashboard/dashboardAdmin.php?action=delete&id=<?php echo $evento['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<?php include(__DIR__ . '/../common/Footer.php'); ?>
<script>
    function handleAction(event) {
        const action = document.getElementById('action').value;
        const eventId = document.getElementById('eventId').value;

        if (action === 'delete') {
            window.location.href = `/views/dashboard/dashboardAdmin.php?action=delete&id=${eventId}`;
        } else {
            window.location.href = `${action}?id=${eventId}`;
        }

        event.preventDefault();
    }
</script>
</html>