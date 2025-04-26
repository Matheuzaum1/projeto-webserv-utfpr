<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /views/auth/login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo - Gerenciador de Eventos</title>
</head>
<body>
    <h2>Olá, <?php echo htmlspecialchars($usuario['nome']); ?>!</h2>

    <p>Tipo de usuário: <?php echo htmlspecialchars($usuario['tipo']); ?></p>

    <a href="/controllers/authController.php?acao=logout">Sair</a>
</body>
</html>
