<!-- /views/events/create.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Evento - Projeto Web UTFPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../common/header.php'); ?>

    <div class="container mt-5">
        <h2>Criar Novo Evento</h2>
        <form action="/controllers/EventController.php?action=create" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nome do Evento</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Data do Evento</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-success">Criar Evento</button>
        </form>
    </div>

    <?php include('../common/footer.php'); ?>
</body>
</html>
