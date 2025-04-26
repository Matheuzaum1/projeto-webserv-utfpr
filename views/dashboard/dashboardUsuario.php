<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'usuario') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .sidebar {
            width: 200px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bem-vindo à Dashboard</h1>
    </div>
    <div class="sidebar">
        <h3>Menu</h3>
        <a href="#">Início</a>
        <a href="#">Perfil</a>
        <a href="#">Configurações</a>
        <a href="#">Sair</a>
    </div>
    <div class="content">
        <h2>Visão Geral</h2>
        <div class="card">
            <h3>Usuários Ativos</h3>
            <p>150</p>
        </div>
        <div class="card">
            <h3>Novas Mensagens</h3>
            <p>23</p>
        </div>
        <div class="card">
            <h3>Notificações</h3>
            <p>5</p>
        </div>
    </div>
</body>
</html>