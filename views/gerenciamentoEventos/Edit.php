<?php
require_once __DIR__ . '/../../controllers/EventController.php';

$eventId = $_GET['id'] ?? null;
$eventController = new EventController();
$evento = $eventController->getEventById($eventId);

if (!$evento) {
    echo "Evento não encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data = $_POST['data'] ?? '';
    $participantes = $_POST['participantes'] ?? 0;

    if (!empty($nome) && !empty($data)) {
        $eventController->updateEvent($eventId, $nome, $data, $participantes);
        header('Location: /views/dashboard/dashboardAdmin.php');
        exit;
    } else {
        $erro = 'Preencha todos os campos obrigatórios!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Evento</h1>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Evento:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($evento['nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" id="data" name="data" class="form-control" value="<?php echo htmlspecialchars($evento['data']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="participantes" class="form-label">Número de Participantes:</label>
                <input type="number" id="participantes" name="participantes" class="form-control" value="<?php echo htmlspecialchars($evento['participantes']); ?>" min="0">
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/views/dashboard/dashboardAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>