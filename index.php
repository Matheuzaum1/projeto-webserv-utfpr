<?php
// index.php - Front Controller para rotas amigáveis

// Remove query string e barra final
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
if ($uri === '') $uri = '/';

// --- TRATA LOGOUT ANTES DE TUDO ---
if ($uri === '/logout') {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
}

// Mapeamento de rotas amigáveis para arquivos PHP
$routes = [
    '/login' => 'views/auth/Login.php',
    '/register' => 'views/auth/Register.php',
    '/admin' => 'views/dashboard/dashboardAdmin.php',
    '/DashboardUsuario' => 'views/dashboard/dashboardUsuario.php',
    '/dashboardAdmin' => 'views/dashboard/dashboardAdmin.php',
    // Adicione outras rotas conforme necessário
];

if ($uri === '/') {
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
        exit;
    }
    if ($_SESSION['usuario']['tipo'] === 'admin') {
        header('Location: /dashboardAdmin');
        exit;
    } else {
        header('Location: /DashboardUsuario');
        exit;
    }
}

if (isset($routes[$uri])) {
    require_once __DIR__ . '/' . $routes[$uri];
    exit;
}

// Rotas dinâmicas para eventos (exemplo: /evento/123)
if (preg_match('#^/evento/(\d+)$#', $uri, $matches)) {
    $_GET['id'] = $matches[1];
    require_once __DIR__ . '/views/gerenciamentoEventos/Details.php';
    exit;
}

// 404
http_response_code(404);
echo "Página não encontrada";
