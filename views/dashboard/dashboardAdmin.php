<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #444;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-around;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        main {
            padding: 2rem;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1rem;
            margin: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </nav>
    <main>
        <h2>Welcome, Admin!</h2>
        <div class="card">
            <h3>Statistics</h3>
            <p>Users: 120</p>
            <p>Active Sessions: 15</p>
        </div>
        <div class="card">
            <h3>Recent Activity</h3>
            <ul>
                <li>User John updated profile</li>
                <li>New user registered: Jane</li>
                <li>System settings updated</li>
            </ul>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Admin Dashboard</p>
    </footer>
</body>
</html>