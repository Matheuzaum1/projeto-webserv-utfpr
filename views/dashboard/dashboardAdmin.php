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
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .actions button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="actions">
            <button onclick="createEvent()">Criar Evento</button>
            <button onclick="deleteEvent()">Excluir Evento</button>
            <button onclick="modifyEvent()">Modificar Evento</button>
            <button onclick="readEvent()">Ler Evento</button>
            <button onclick="logout()">Logout</button>
        </div>
        <h2>Dados do Evento</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Evento</th>
                    <th>Data</th>
                    <th>Número de Participantes</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($eventos as $evento): ?>
<tr>
    <td><?php echo $evento['id']; ?></td>
    <td><?php echo $evento['nome']; ?></td>
    <td><?php echo $evento['data']; ?></td>
    <td><?php echo $evento['participantes']; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
        </table>
    </div>

    <script>
        function createEvent() {
            alert('Função para criar evento');
        }

        function deleteEvent() {
            alert('Função para excluir evento');
        }

        function modifyEvent() {
            alert('Função para modificar evento');
        }

        function readEvent() {
            alert('Função para ler evento');
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