<?php
session_start();
require_once __DIR__ . '/../config/usuarios.php';

$acao = $_POST['acao'] ?? $_GET['action'] ?? null;

if ($acao === 'login') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header('Location: /views/auth/login.php?erro=campos_vazios');
        exit;
    }

    $usuarioEncontrado = false;
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email) {
            $usuarioEncontrado = true;
            if ($senha === $usuario['senha']) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'tipo' => $usuario['tipo']
                ];

                // Redirecionar para a dashboard correta com base no tipo de usuário
                if ($usuario['tipo'] === 'admin') {
                    header('Location: /views/dashboard/dashboardAdmin.php');
                } else {
                    header('Location: /views/dashboard/dashboardUsuario.php');
                }
                exit;
            } else {
                header('Location: /views/auth/login.php?erro=senha_incorreta');
                exit;
            }
        }
    }

    if (!$usuarioEncontrado) {
        header('Location: /views/auth/login.php?erro=usuario_nao_encontrado');
        exit;
    }
}

if ($acao === 'logout') {
    session_destroy();
    header('Location: /views/auth/login.php');
    exit;
}
