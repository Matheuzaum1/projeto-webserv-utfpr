<?php
require_once __DIR__ . '/../../controllers/EventController.php';

$eventController = new EventController();
$eventos = $eventController->listEvents();

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="actions">
            <a href="/views/gerenciamentoEventos/Create.php">Criar Evento</a>
            <button onclick="logout()">Logout</button>
        </div>

        <div class="quick-actions">
            <h3>Ações Rápidas</h3>
            <form id="quickActionForm" onsubmit="handleQuickAction(event)">
                <label for="eventId">ID do Evento:</label>
                <input type="number" id="eventId" name="eventId" required>

                <select id="actionType" name="actionType" required>
                    <option value="edit">Editar</option>
                    <option value="details">Detalhes</option>
                    <option value="delete">Excluir</option>
                </select>

                <button type="submit">Executar</button>
            </form>
        </div>

        <h2>Lista de Eventos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Número de Participantes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo $evento['id']; ?></td>
                        <td><?php echo $evento['nome']; ?></td>
                        <td><?php echo $evento['data']; ?></td>
                        <td><?php echo $evento['participantes']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="/views/gerenciamentoEventos/Edit.php?id=<?php echo $evento['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento['id']; ?>" class="btn btn-info btn-sm">Detalhes</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function handleQuickAction(event) {
            event.preventDefault();
            const eventId = document.getElementById('eventId').value;
            const actionType = document.getElementById('actionType').value;

            if (actionType === 'edit') {
                window.location.href = `/views/gerenciamentoEventos/Edit.php?id=${eventId}`;
            } else if (actionType === 'details') {
                window.location.href = `/views/gerenciamentoEventos/Details.php?id=${eventId}`;
            } else if (actionType === 'delete') {
                if (confirm('Tem certeza que deseja excluir este evento?')) {
                    fetch(`/controllers/EventController.php?action=delete&id=${eventId}`, {
                        method: 'POST'
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Evento excluído com sucesso!');
                            location.reload();
                        } else {
                            alert('Erro ao excluir o evento.');
                        }
                    });
                }
            }
        }

        function logout() {
            fetch('/controllers/authController.php?action=logout')
                .then(() => {
                    window.location.href = '/index.php';
                });
        }
    </script>
</body>
</html>