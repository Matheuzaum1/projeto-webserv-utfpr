<?php
// Exibe alertas de sucesso ou erro, se existirem
if (isset($erro) && $erro) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($erro) . '</div>';
}
if (isset($success) && $success) {
    echo '<div class="alert alert-success">' . htmlspecialchars($success) . '</div>';
}
// Também suporta mensagens via GET
if (isset($_GET['success'])) {
    $msg = $_GET['success'];
    // Mensagens customizadas podem ser tratadas aqui
    switch ($msg) {
        case 'evento_criado':
            $msg = 'Evento criado com sucesso!';
            break;
        case 'evento_atualizado':
            $msg = 'Evento atualizado com sucesso!';
            break;
        case 'evento_deletado':
            $msg = 'Evento deletado com sucesso!';
            break;
        case 'inscricao_realizada':
            $msg = 'Inscrição realizada com sucesso!';
            break;
        case 'usuario_cadastrado':
            $msg = 'Usuário cadastrado com sucesso!';
            break;
        default:
            // Mantém o texto original
            break;
    }
    echo '<div class="alert alert-success">' . htmlspecialchars($msg) . '</div>';
}
if (isset($_GET['erro'])) {
    $msg = $_GET['erro'];
    switch ($msg) {
        case 'acesso_negado':
            $msg = 'Você não tem permissão para acessar esta página. Faça login primeiro.';
            break;
        case 'campos_vazios':
            $msg = 'Preencha todos os campos.';
            break;
        case 'senha_incorreta':
            $msg = 'Senha incorreta. Tente novamente.';
            break;
        case 'usuario_nao_encontrado':
            $msg = 'Usuário não encontrado.';
            break;
        case 'email_invalido':
            $msg = 'E-mail inválido.';
            break;
        case 'email_ja_cadastrado':
            $msg = 'E-mail já cadastrado.';
            break;
        case 'senha_curta':
            $msg = 'A senha deve ter pelo menos 6 caracteres.';
            break;
        case 'nome_curto':
            $msg = 'O nome deve ter pelo menos 3 caracteres.';
            break;
        default:
            // Mantém o texto original
            break;
    }
    echo '<div class="alert alert-danger">' . htmlspecialchars($msg) . '</div>';
}
