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

header('Location: /views/auth/login.php');
exit;
