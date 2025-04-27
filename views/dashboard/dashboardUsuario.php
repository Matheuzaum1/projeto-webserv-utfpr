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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
</head>
<body>
    <?php include(__DIR__ . '/../common/Header.php'); ?>

    <main class="flex-grow-1">
        <div class="container mt-5">
            <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
            <a href="/index.php?action=logout" class="btn btn-danger mt-3">Logout</a>

            <h2 class="mt-5">Eventos Disponíveis</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Vagas Disponíveis</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventos as $evento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                            <td><?php echo htmlspecialchars($evento['data']); ?></td>
                            <td>
                                <?php
                                $vagasDisponiveis = $evento['max_participantes'] - $evento['participantes'];
                                echo $vagasDisponiveis > 0 ? $vagasDisponiveis : 'Esgotado';
                                ?>
                            </td>
                            <td>
                                <?php if ($vagasDisponiveis > 0): ?>
                                    <form method="POST" action="/controllers/eventController.php?action=register&id=<?php echo htmlspecialchars($evento['id']); ?>" style="display: inline;">
                                        <button type="submit" class="btn btn-primary btn-sm">Inscrever-se</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>Esgotado</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include(__DIR__ . '/../common/Footer.php'); ?>
</body>
</html>