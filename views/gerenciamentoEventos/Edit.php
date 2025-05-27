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
    $descricao = $_POST['descricao'] ?? '';
    $local = $_POST['local'] ?? '';
    $data = $_POST['data'] ?? '';
    $duracao = $_POST['duracao'] ?? '';
    $max_participantes = intval($_POST['max_participantes'] ?? 0);
    $categoria = $_POST['categoria'] ?? '';
    $preco = $_POST['preco'] ?? '';

    if ($max_participantes < $evento->getParticipantes()) {
        $erro = "O número máximo de participantes não pode ser menor do que o número de participantes já inscritos ({$evento->getParticipantes()}).";
    } elseif (!empty($nome) && !empty($data) && $max_participantes > 0) {
        try {
            $eventController->updateEvent(
                $eventId,
                $nome,
                $descricao,
                $local,
                $data,
                $duracao,
                $max_participantes,
                $categoria,
                $preco
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
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required><?php echo htmlspecialchars($evento->getDescricao()); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="local" class="form-label">Local:</label>
                <input type="text" id="local" name="local" class="form-control" value="<?php echo htmlspecialchars($evento->getLocal()); ?>" required>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração (em minutos):</label>
                <input type="number" id="duracao" name="duracao" class="form-control" value="<?php echo htmlspecialchars($evento->getDuracao()); ?>" min="1" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo htmlspecialchars($evento->getCategoria()); ?>" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" step="0.01" id="preco" name="preco" class="form-control" value="<?php echo htmlspecialchars($evento->getPreco()); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/views/dashboard/dashboardAdmin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>