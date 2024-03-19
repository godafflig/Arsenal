<?php


session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Controller/HomeController.php';
require_once __DIR__ . '/src/Controller/RegisterController.php';

if (isset($_SESSION['username'])) {
    echo "Username: " . $_SESSION['username'];
    $isConnected = true;
    $twig->addGlobal('isConnected', $isConnected);
} else {
    $isConnected = false;
    $twig->addGlobal('isConnected', $isConnected);
    echo "Le username n'est pas défini dans la session.";
}

$routes = [
    '' => ['controller' => 'App\\Controller\\HomeController'],
    'register' => ['controller' => 'App\\Controller\\RegisterController'],
    'login' => ['controller' => 'App\\Controller\\LoginController'],
];


$request = $_SERVER['REQUEST_URI'];
$request2 = isset($_GET['action']) ? $_GET['action'] : "";
if (array_key_exists($request2, $routes)) {
    $controllerName = $routes[$request2]['controller'];
    $controller = new $controllerName();
    if (isset($routes[$request2]['method']) && is_string($routes[$request2]['method'])) {
        $methodName = $routes[$request2]['method'];
        $controller->$methodName();
    } else {
        if (method_exists($controller, 'index')) {
            $controller->index();
        } else {
            http_response_code(404);
        }
    }
} else {
    http_response_code(404);
}
