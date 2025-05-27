<?php
// Arquivo de funções relacionadas às inscrições
require_once __DIR__ . '/../database/Conexao.php';

function buscarInscricoesPorUsuario($usuarioId) {
    $con = Conexao::get();
    $stmt = $con->prepare('SELECT * FROM inscricoes WHERE usuario_id = :usuario_id');
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Adicione outras funções relacionadas às inscrições conforme necessário.
