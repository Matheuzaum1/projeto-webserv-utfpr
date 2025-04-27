<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $tipo = $_SESSION['usuario']['tipo'];
    if ($tipo === 'admin') {
        header('Location: /views/dashboard/dashboardAdmin.php');
    } else {
        header('Location: /views/dashboard/dashboardUsuario.php');
    }
    exit;
}

if (isset($_COOKIE['user_token'])) {
    $usuario = json_decode(base64_decode($_COOKIE['user_token']), true);
    if ($usuario && isset($usuario['tipo'])) {
        $_SESSION['usuario'] = $usuario;
        if ($usuario['tipo'] === 'admin') {
            header('Location: /views/dashboard/dashboardAdmin.php');
        } else {
            header('Location: /views/dashboard/dashboardUsuario.php');
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Projeto Web UTFPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
</head>
<body>
    <?php include(__DIR__ . '/../common/Header.php'); ?>

    <main class="flex-grow-1">
        <div class="container mt-5">
            <h1 class="text-center">Login</h1>
            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger">
                <?php
                switch ($_GET['erro']) {
                    case 'campos_vazios':
                        echo 'Por favor, preencha todos os campos.';
                        break;
                    case 'senha_incorreta':
                        echo 'Senha incorreta. Tente novamente.';
                        break;
                    case 'usuario_nao_encontrado':
                        echo 'Usuário não encontrado. Verifique o e-mail digitado.';
                        break;
                    case 'acesso_negado':
                        echo 'Acesso negado, você não tem permissão para acessar esta página.';
                        break;
                    case 'email_ja_cadastrado':
                        echo 'Este e-mail já está cadastrado. Tente outro ou faça login.';
                        break;
                    default:
                        echo 'Ocorreu um erro. Tente novamente.';
                }
                ?>
                </div>
            <?php endif; ?>
            <form action="/index.php?action=login" method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" id="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <p class="mt-3 text-center">Ainda não tem uma conta? <a href="register.php">Cadastre-se</a></p>
        </div>
    </main>

    <?php include(__DIR__ . '/../common/Footer.php'); ?>
</body>
</html>