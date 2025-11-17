<?php
require 'vendor/autoload.php';

use Inn\App;

$router = new App\Routing\Router();

$routes = require __DIR__ . '/src/Routing/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);

// 3. learn about router recompilation
