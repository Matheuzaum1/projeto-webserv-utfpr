<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header('Location: /login?erro=acesso_negado');
    exit;
}

$eventos = []; // Inicializa a variável $eventos como um array vazio
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css?v=1.0">
</head>
<body>
    <?php include(__DIR__ . '/../common/Header.php'); ?>
    <?php include(__DIR__ . '/../common/Alert.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?>!</h1>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2>Gerenciamento de Eventos</h2>
            <a href="/criarEvento" class="btn btn-success">Criar Evento</a>
        </div>

        <div class="card mt-4" data-aos="fade-up">
            <h2 class="text-center">Gerenciamento Rápido</h2>
            <form method="GET" action="" class="row g-3" onsubmit="return handleAction(event)">
                <div class="col-md-6">
                    <label for="eventId" class="form-label">ID do Evento:</label>
                    <input type="number" id="eventId" name="id" class="form-control" placeholder="Digite o ID do evento" required>
                </div>
                <div class="col-md-6">
                    <label for="action" class="form-label">Ação:</label>
                    <select id="action" name="action" class="form-select" required>                        <option value="/editarEvento">Editar</option>
                        <option value="/evento">Detalhes</option>
                        <option value="/excluirEvento">Excluir</option>
                    </select>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-3">Executar</button>
                </div>
            </form>
        </div>
        <h2 class="mt-5">Lista de Eventos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Número de Participantes</th>
                    <th>Máximo de Participantes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento->getId()); ?></td>
                        <td><?php echo htmlspecialchars($evento->getTitulo()); ?></td>
                        <td><?php echo htmlspecialchars($evento->getDataHora()); ?></td>
                        <td><?php echo htmlspecialchars($evento->getParticipantes()); ?></td>
                        <td><?php echo htmlspecialchars($evento->getCapacidade()); ?></td>
                        <td>
                            <div class="btn-group">                                <a href="/editarEvento/<?php echo $evento->getId(); ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/evento/<?php echo $evento->getId(); ?>" class="btn btn-info btn-sm">Detalhes</a>
                                <a href="/excluirEvento/<?php echo $evento->getId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este evento?');">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; 2025 Projeto Webserv UTFPR</span>
        </div>
    </footer>
</body>
<script>    function handleAction(event) {
        const action = document.getElementById('action').value;
        const eventId = document.getElementById('eventId').value;
        
        window.location.href = `${action}/${eventId}`;
        }

        event.preventDefault();
    }
</script>
</html>