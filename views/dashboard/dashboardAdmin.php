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
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }
    .container {
        width: 90%;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        color: #343a40;
    }
    .actions {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .actions a, .actions button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
    }
    .actions a:hover, .actions button:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table th, table td {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: left;
    }
    table th {
        background-color: #007BFF;
        color: white;
    }
    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
        border-radius: 4px;
        margin-right: 5px;
    }
    .btn-warning {
        background-color: #ffc107;
        color: #212529;
        border: none;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-info {
        background-color: #17a2b8;
        color: #fff;
        border: none;
    }
    .btn-info:hover {
        background-color: #138496;
    }
    .btn-group {
        display: flex;
        justify-content: flex-start;
    }
    </style>
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