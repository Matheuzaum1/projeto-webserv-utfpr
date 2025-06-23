<?php
require_once __DIR__ . '/../config/config.php';

echo "Iniciando configuração do banco de dados...\n";

try {
    // Conectar ao MySQL sem selecionar banco de dados
    $pdo = new PDO("mysql:host=".DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar o banco de dados se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS ".DB_DATABASE." CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "Banco de dados ".DB_DATABASE." criado ou já existe.\n";
    
    // Selecionar o banco de dados
    $pdo->exec("USE ".DB_DATABASE);

    // Criar tabelas
    echo "Criando tabelas...\n";
    
    // Tabela usuario
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `usuario` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `nome_completo` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `senha` varchar(255) NOT NULL,
          `tipo_usuario` enum('admin','participante') NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    // Tabela admin
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admin` (
          `id` int(11) NOT NULL,
          `cargo` varchar(255) DEFAULT NULL,
          `data_contratacao` date DEFAULT NULL,
          PRIMARY KEY (`id`),
          CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    // Tabela participante
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `participante` (
          `id` int(11) NOT NULL,
          `data_nascimento` date DEFAULT NULL,
          `cpf` char(14) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `unique_cpf` (`cpf`),
          CONSTRAINT `participante_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    // Tabela evento
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `evento` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `titulo` varchar(255) NOT NULL,
          `descricao` varchar(500) NOT NULL,
          `data_hora` datetime NOT NULL,
          `duracao` time NOT NULL,
          `local` varchar(200) NOT NULL,
          `capacidade` int(11) NOT NULL,
          `categoria` varchar(25) NOT NULL,
          `preco` decimal(10,2) NOT NULL,
          `organizador` int(11) NOT NULL,
          `status` varchar(25) NOT NULL,
          PRIMARY KEY (`id`),
          CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`organizador`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    // Tabela inscricao
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `inscricao` (
          `id_evento` int(11) NOT NULL,
          `id_usuario` int(11) NOT NULL,
          `status` varchar(25) NOT NULL CHECK (`status` in ('ativa','cancelada','pendente de pagamento')),
          `presenca` tinyint(1) NOT NULL DEFAULT 0,
          `data_inscricao` date NOT NULL DEFAULT (CURRENT_DATE),
          PRIMARY KEY (`id_evento`,`id_usuario`),
          CONSTRAINT `inscricao_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE,
          CONSTRAINT `inscricao_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    echo "Tabelas criadas com sucesso.\n";
    
    // Carregar e executar o script para popular o banco
    echo "Populando o banco de dados com dados de teste...\n";
    $populate = file_get_contents(__DIR__ . '/populate.sql');
    
    // Executar o script por partes para evitar problemas com DELIMITER e outros comandos
    $commands = explode(';', $populate);
    foreach ($commands as $command) {
        $command = trim($command);
        if (!empty($command) && strpos($command, '--') !== 0) {
            try {
                $pdo->exec($command);
            } catch (PDOException $e) {
                echo "Erro ao executar comando: " . $command . "\n";
                echo "Mensagem: " . $e->getMessage() . "\n";
                // Continue mesmo se um comando falhar
            }
        }
    }
    
    echo "Banco de dados configurado e populado com sucesso!\n";
    
} catch (PDOException $e) {
    echo "Erro ao configurar o banco de dados: " . $e->getMessage() . "\n";
    exit(1);
}
