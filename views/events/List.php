<!-- /views/events/list.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos - Projeto Web UTFPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../common/header.php'); ?>

    <div class="container mt-5">
        <h2>Eventos</h2>
        <a href="create.php" class="btn btn-success mb-3">Criar Novo Evento</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exemplo de iteração nos eventos
                foreach ($events as $event) {
                    echo "<tr>";
                    echo "<td>" . $event['id'] . "</td>";
                    echo "<td>" . $event['name'] . "</td>";
                    echo "<td>" . $event['description'] . "</td>";
                    echo "<td>" . $event['date'] . "</td>";
                    echo "<td><a href='edit.php?id=" . $event['id'] . "' class='btn btn-warning'>Editar</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include('../common/footer.php'); ?>
</body>
</html>
