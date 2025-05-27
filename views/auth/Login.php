<?php include(__DIR__ . '/../common/Header.php'); ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario']['tipo'] === 'admin') {
        header('Location: /dashboardAdmin');
        exit;
    } else {
        header('Location: /DashboardUsuario');
        exit;
    }
}

require_once __DIR__ . '/../../controllers/authController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($authController->login()) {
        if ($_SESSION['usuario']['tipo'] === 'admin') {
            header('Location: /dashboardAdmin');
            exit;
        } else {
            header('Location: /DashboardUsuario');
            exit;
        }
    } else {
        $erro = 'Credenciais inválidas. Tente novamente.';
    }
}

if (isset($_GET['erro'])) {
    switch ($_GET['erro']) {
        case 'acesso_negado':
            $erro = 'Você não tem permissão para acessar esta página. Faça login primeiro.';
            break;
        case 'campos_vazios':
            $erro = 'Preencha todos os campos.';
            break;
        case 'senha_incorreta':
            $erro = 'Senha incorreta. Tente novamente.';
            break;
        case 'usuario_nao_encontrado':
            $erro = 'Usuário não encontrado.';
            break;
        default:
            $erro = 'Ocorreu um erro. Tente novamente.';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
<main>
    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger" role="alert"><?php echo $erro; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="text-center mt-3">
            Não tem uma conta? <a href="/register">Registre-se</a>
        </p>
    </div>
</main>
</body>
</html>

<?php include(__DIR__ . '/../common/Footer.php'); ?>