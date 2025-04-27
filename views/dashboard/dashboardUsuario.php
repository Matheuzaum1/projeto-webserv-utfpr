<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'usuario') {
    header('Location: /views/auth/login.php?erro=acesso_negado');
    exit;
}

$eventos = require_once __DIR__ . '/../../config/eventos.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
        <a href="/index.php?action=logout" class="btn btn-danger mt-3" style="font-size: 1rem; padding: 10px 20px; border-radius: 5px;">Sair</a>

        <h2 class="mt-5">Eventos Disponíveis</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                        <td><?php echo htmlspecialchars($evento['data']); ?></td>
                        <td>
                            <form method="POST" action="/controllers/eventController.php" style="display: inline;">
                                <input type="hidden" name="evento_id" value="<?php echo htmlspecialchars($evento['id']); ?>">
                                <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.9rem; padding: 8px 15px; border-radius: 5px;">Inscrever-se</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Meus Eventos</h2>
        <p>Você ainda não está participando de nenhum evento.</p>
    </div>
</body>
</html>