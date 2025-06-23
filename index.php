<?php
// index.php - sistema de roteamento centralizado

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

// Carrega as rotas do arquivo web.php
$routes = require __DIR__ . '/routes/web.php';

// Define a ação padrão
$defaultAction = 'showLogin';
$action = $_GET['action'] ?? $defaultAction;

if (isset($routes[$action])) {
    list($controllerName, $methodName) = $routes[$action];
    $controllerFile = __DIR__ . "/controllers/" . strtolower($controllerName) . ".php";
    
    if (!file_exists($controllerFile)) {
        http_response_code(500);
        error_log("Arquivo do Controller não encontrado: " . $controllerFile);
        echo "Erro interno no servidor (R1). Por favor, tente novamente mais tarde.";
        exit;
    }
    
    require_once $controllerFile;
    
    if (!class_exists($controllerName)) {
        http_response_code(500);
        error_log("Classe Controller '" . $controllerName . "' não encontrada no arquivo '" . $controllerFile . "'.");
        echo "Erro interno no servidor (R2). Por favor, tente novamente mais tarde.";
        exit;
    }
    
    $controller = new $controllerName();
    
    if (!method_exists($controller, $methodName)) {
        http_response_code(500);
        error_log("Método '" . $methodName . "' não encontrado no controller '" . $controllerName . "'.");
        echo "Erro interno no servidor (R3). Por favor, tente novamente mais tarde.";
        exit;
    }
    
    // Chama o método do controller
    $controller->$methodName();
    exit;
} else {
    // Rota não encontrada
    http_response_code(404);
    echo "Rota não encontrada.";
    exit;
}
