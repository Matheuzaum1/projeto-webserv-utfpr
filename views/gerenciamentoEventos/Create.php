<?php
require_once __DIR__ . '/../../controllers/EventController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('Formulário enviado para criar evento.');
    $nome = trim($_POST['nome'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $participantes = intval($_POST['participantes'] ?? 0);

    if (!empty($nome) && !empty($data)) {
        $eventController = new EventController();
        try {
            $eventController->createEvent($nome, $data, $participantes);
            header('Location: /views/dashboard/dashboardAdmin.php?success=evento_criado');
            exit;
        } catch (Exception $e) {
            $erro = 'Erro ao criar o evento: ' . $e->getMessage();
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
    <title>Criar Evento</title>
</head>
<body>
    <h1>Criar Evento</h1>
    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="nome">Nome do Evento:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required><br>

        <label for="participantes">Número de Participantes:</label>
        <input type="number" id="participantes" name="participantes" min="0"><br>

        <button type="submit">Criar</button>
    </form>
</body>
</html>
