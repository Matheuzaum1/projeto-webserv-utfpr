<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}

require_once __DIR__ . '/../../controllers/EventController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $max_participantes = intval($_POST['max_participantes'] ?? 0);

    if (!empty($nome) && !empty($data) && $max_participantes > 0) {
        $eventController = new EventController();
        try {
            $eventController->createEvent($nome, $data, $max_participantes);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        .form-container .btn-primary {
            width: 100%;
        }
        .form-container .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mx-auto col-md-6">
            <h1>Criar Evento</h1>
            <?php include(__DIR__ . '/../common/Alert.php'); ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Evento:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" id="data" name="data" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="max_participantes" class="form-label">Número Máximo de Participantes:</label>
                    <input type="number" id="max_participantes" name="max_participantes" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Criar</button>
                <a href="/views/dashboard/dashboardAdmin.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
