<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}
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
    $capacidade = intval($_POST['capacidade'] ?? 0);
    $dataHora = $_POST['data_hora'] ?? '';

    if ($capacidade < $eventController->getNumeroInscritos($evento->getId())) {
        $erro = "O número máximo de participantes não pode ser menor do que o número de participantes já inscritos ({$eventController->getNumeroInscritos($evento->getId())})";
    } elseif (!empty($nome) && !empty($dataHora) && $capacidade > 0) {
        try {
            $eventController->updateEvent(
                $eventId,
                $nome,
                $dataHora,
                $capacidade
            );
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
        <?php include(__DIR__ . '/../common/Alert.php'); ?>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Evento:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($evento->getTitulo()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade do evento:</label> 
                <input type="text" class="form-control" name="capacidade" value ="<?php echo htmlspecialchars($evento->getCapacidade()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="dataHora" class="form-label">Data e hora:</label>
                <input type="datetime-local" id="dataHora" name="data_hora" class="form-control" value="<?php echo htmlspecialchars($evento->getDataHora()); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/admin" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>