<?php
session_start();


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/controller/HomeController.php';
require_once __DIR__ . '/src/controller/RegisterController.php';
require_once __DIR__ . '/src/controller/DeconnectionController.php';
require_once __DIR__ . '/src/controller/ProfileController.php';



$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/vue');
$twig = new \Twig\Environment($loader, ['cache' => false]);


if (!empty($_SESSION['sessionTicket'])) {
    $isConnected = true;
} else {
    $isConnected = false;
}
$twig->addGlobal('isConnected', $isConnected);


$routes = [
    '' => ['controller' => 'App\\Controller\\HomeController'],
    'register' => ['controller' => 'App\\Controller\\RegisterController'],
    'login' => ['controller' => 'App\\controller\\LoginController', 'method' => 'showLoginForm'], // Afficher le formulaire de connexion
    'processLogin' => ['controller' => 'App\\controller\\LoginController', 'method' => 'processLogin'], // Traiter la connexion
    'logout' => ['controller' => 'App\\controller\\DeconnectionController', 'method' => 'logout'],
    'profil' => ['controller' => 'App\\controller\\ProfileController','method' => 'showProfile'],
];

$request = $_SERVER['REQUEST_URI'];

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (array_key_exists($action, $routes)) {
    $controllerName = $routes[$action]['controller'];
    $controller = new $controllerName($twig);

    $method = $routes[$action]['method'] ?? 'index';
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}
