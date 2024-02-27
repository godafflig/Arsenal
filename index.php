<?php


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Controller/HomeController.php';


$routes = [
    '' => ['controller' => 'App\\Controller\\HomeController'],
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
