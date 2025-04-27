<?php
require_once __DIR__ . '/controllers/authController.php';
require_once __DIR__ . '/controllers/eventController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'login':
        $authController = new AuthController();
        $authController->login();
        break;
    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;
    case 'listEvents':
        $eventController = new EventController();
        $eventController->listEvents();
        break;
    case 'register':
        $authController = new AuthController();
        $authController->register();
        break;
    case 'createEvent':
        $eventController = new EventController();
        $eventController->createEvent();
        break;
    case 'deleteEvent':
        $eventController = new EventController();
        $eventController->deleteEvent($_GET['id'] ?? null);
        break;
    default:
        header('Location: /views/auth/login.php');
        break;
}
