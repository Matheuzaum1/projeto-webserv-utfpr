<?php
// Router para PHP built-in server - suporta URLs amigáveis
// Use: php -S localhost:8000 router.php

// Se o arquivo solicitado existe e não é o index.php, serve-o diretamente
$requestUri = $_SERVER['REQUEST_URI'];
$filePath = __DIR__ . $requestUri;

// Parse a query string
$queryString = parse_url($requestUri, PHP_URL_QUERY);
if ($queryString) {
    parse_str($queryString, $queryParams);
    foreach ($queryParams as $key => $value) {
        $_GET[$key] = $value;
    }
    
    // Remove query string da URI para processamento de rota
    $requestUri = str_replace('?' . $queryString, '', $requestUri);
}

// Verifica primeiro se é uma pasta ou arquivo estático existente
if (file_exists($filePath) && !is_dir($filePath) && $requestUri !== '/') {
    // Deixa o PHP lidar com os arquivos existentes
    return false;
}

// Ignora as pastas public e vendor (para CSS, JS, imagens, etc)
if (preg_match('/^\/(public|vendor)\//', $requestUri)) {
    return false;
}

// Extrai o caminho a partir da URI
$path = parse_url($requestUri, PHP_URL_PATH);
$path = ltrim($path, '/');
$path = explode('/', $path);

// Rota padrão para a raiz
if (empty($path[0])) {
    $_GET['action'] = '';
    require __DIR__ . '/index.php';
    exit;
}

// URL com três segmentos: /gerenciar/evento/editar
if (isset($path[0]) && isset($path[1]) && isset($path[2])) {
    $_GET['controller'] = $path[0];
    $_GET['tipo'] = $path[1];
    $_GET['action'] = $path[2];
    require __DIR__ . '/index.php';
    exit;
}

// URL com dois segmentos e o segundo é numérico: /evento/1
if (isset($path[0]) && isset($path[1]) && is_numeric($path[1])) {
    $_GET['action'] = $path[0];
    $_GET['id'] = $path[1];
    require __DIR__ . '/index.php';
    exit;
}

// URL com um segmento: /login, /dashboard, etc.
if (isset($path[0])) {
    $_GET['action'] = $path[0];
}

// Inclui o index.php, que vai processar a rota
require __DIR__ . '/index.php';
