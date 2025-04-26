<?php
session_start();
require_once __DIR__ . '/../config/usuarios.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? null;

if ($acao === 'login') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email) {
            if ($senha === $usuario['senha']) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'tipo' => $usuario['tipo']
                ];
                header('Location: /index.php');
                exit;
            }
        }
    }

    header('Location: /views/login.php?erro=1');
    exit;
}

if ($acao === 'logout') {
    session_destroy();
    header('Location: /views/auth/login.php');
    exit;
}
