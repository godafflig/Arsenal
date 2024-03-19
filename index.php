<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Controller/HomeController.php';
require_once __DIR__ . '/src/Controller/RegisterController.php';
require_once __DIR__ . '/src/Controller/DeconnectionController.php';


$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/vue');
$twig = new \Twig\Environment($loader);

if (isset($_SESSION['username'])) {
    $isConnected = true;
   
}
$twig->addGlobal('isConnected', $isConnected);

$routes = [
    '' => ['controller' => 'App\\Controller\\HomeController'],
    'register' => ['controller' => 'App\\Controller\\RegisterController'],
    'login' => ['controller' => 'App\\Controller\\LoginController'],
    // 'logout' => ['controller' => 'App\\Controller\\DeconnectionController', 'method' => 'logout'],
];

$request = $_SERVER['REQUEST_URI'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if (array_key_exists($action, $routes)) {
    $controllerName = $routes[$action]['controller'];
    $controller = new $controllerName();
    
    $method = $routes[$action]['method'] ?? 'index';
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        http_response_code(404);
        // Render a 404 page using Twig
    }
} else {
    http_response_code(404);
    // Render a 404 page using Twig
}
