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
    $max_participantes = intval($_POST['max_participantes'] ?? 0);

    // Validação: Número máximo de participantes não pode ser menor que o número de participantes já inscritos
    if ($max_participantes < $evento['participantes']) {
        $erro = "O número máximo de participantes não pode ser menor do que o número de participantes já inscritos ({$evento['participantes']}).";
    } elseif (!empty($nome) && !empty($data) && $max_participantes > 0) {
        try {
            $eventController->updateEvent($eventId, $nome, $data, $max_participantes);
            header('Location: /views/dashboard/dashboardAdmin.php?success=evento_atualizado');
            exit;
        } catch (Exception $e) {
            $erro = 'Erro ao atualizar o evento: ' . $e->getMessage();
        }
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
                <label for="max_participantes" class="form-label">Número Máximo de Participantes:</label>
                <input type="number" id="max_participantes" name="max_participantes" class="form-control" value="<?php echo htmlspecialchars($evento['max_participantes']); ?>" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/views/dashboard/dashboardAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>