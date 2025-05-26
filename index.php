<?php
require_once __DIR__ . '/controllers/authController.php';
require_once __DIR__ . '/controllers/eventController.php';
require_once __DIR__ . '/vendor/autoload.php';

// Carrega as rotas
$routes = require __DIR__ . '/routes/web.php';

$action = $_GET['action'] ?? 'home';

if (isset($routes[$action])) {
    list($controllerName, $method) = $routes[$action];
    if (!class_exists($controllerName)) {
        require_once __DIR__ . "/controllers/" . strtolower($controllerName) . ".php";
    }
    $controller = new $controllerName();
    if (isset($_GET['id'])) {
        $controller->$method($_GET['id']);
    } else {
        $controller->$method();
    }
} else {
    header('Location: /views/auth/login.php');
    exit;
}
