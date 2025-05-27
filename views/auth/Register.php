<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {
    header('Location: /views/dashboard/dashboardUsuario.php');
    exit;
}

require_once __DIR__ . '/../../controllers/authController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($authController->register()) {
        header('Location: /views/auth/login.php?success=registrado');
        exit;
    } else {
        $erro = 'Erro ao registrar. Tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrar</h1>
        <?php include(__DIR__ . '/../common/Alert.php'); ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de perfil</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_usuario" id="participante" value="participante" checked>
                    <label class="form-check-label" for="participante">Usuário</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_usuario" id="admin" value="admin">
                    <label class="form-check-label" for="admin">Organizador</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
        <p class="text-center mt-3">
            Já tem uma conta? <a href="/login">Faça login</a>
        </p>
    </div>
</body>
</html>
