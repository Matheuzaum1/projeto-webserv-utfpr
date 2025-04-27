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
</head>
<body>
    <h1>Editar Evento</h1>
    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="nome">Nome do Evento:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $evento['nome']; ?>" required><br>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" value="<?php echo $evento['data']; ?>" required><br>

        <label for="participantes">Número de Participantes:</label>
        <input type="number" id="participantes" name="participantes" value="<?php echo $evento['participantes']; ?>" min="0"><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>