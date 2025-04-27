<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
        http_response_code(403);
        echo "Acesso negado. Apenas administradores podem realizar esta ação.";
        exit;
    }

    $eventController = new EventController();
    $eventController->deleteEvent($_GET['id']);
    http_response_code(200);
    echo "Evento deletado com sucesso.";
    exit;
}
require_once __DIR__ . '/../../controllers/EventController.php';

$eventController = new EventController();
$eventos = $eventController->listEvents();


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
    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
        <a href="/index.php?action=logout" class="btn btn-danger mt-3" style="font-size: 1rem; padding: 10px 20px; border-radius: 5px;">Sair</a>

        <div class="card mb-4 p-4 shadow-sm" style="border-radius: 10px; background-color: #f8f9fa;">
            <h2 class="text-center" style="color: #343a40;">Gerenciar Evento</h2>
            <form method="GET" action="/views/gerenciamentoEventos/" class="row g-3">
                <div class="col-md-6">
                    <label for="eventId" class="form-label" style="font-weight: bold;">ID do Evento:</label>
                    <input type="number" id="eventId" name="id" class="form-control" placeholder="Digite o ID do evento" style="border: 2px solid #ced4da; border-radius: 8px; padding: 10px;" required>
                </div>
                <div class="col-md-6">
                    <label for="action" class="form-label" style="font-weight: bold;">Ação:</label>
                    <select id="action" name="action" class="form-select" style="border: 2px solid #ced4da; border-radius: 8px; padding: 10px;" required>
                        <option value="Edit.php">Editar</option>
                        <option value="Details.php">Detalhes</option>
                        <option value="delete">Excluir</option>
                    </select>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-3" style="padding: 12px 25px; font-size: 1rem; border-radius: 8px;">Executar</button>
                </div>
            </form>
        </div>

        <h2 class="mt-5">Gerenciamento de Eventos</h2>
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
                        <td><?php echo htmlspecialchars(htmlspecialchars($evento['nome'])); ?></td>
                        <td><?php echo htmlspecialchars(htmlspecialchars($evento['data'])); ?></td>
                        <td><?php echo htmlspecialchars(htmlspecialchars($evento['participantes'])); ?></td>
                        <td><?php echo htmlspecialchars($evento['max_participantes']); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="/views/gerenciamentoEventos/Edit.php?id=<?php echo $evento['id']; ?>" class="btn btn-warning btn-sm" style="font-size: 0.9rem; padding: 8px 15px; border-radius: 5px;">Editar</a>
                                <a href="/views/gerenciamentoEventos/Details.php?id=<?php echo $evento['id']; ?>" class="btn btn-info btn-sm" style="font-size: 0.9rem; padding: 8px 15px; border-radius: 5px;">Detalhes</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>