<?php
require 'vendor/autoload.php';

use Inn\App;

$route = new App\Routing\RouteStorage();

$router = new App\Routing\Router($route);

$routes = require __DIR__ . '/src/Routing/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);