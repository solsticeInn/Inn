<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Inn\App\Routing\Router;
use Inn\App\Container\Container;

$container = new Container();

try {
    $router = $container->get(Router::class);

    $routes = require __DIR__ . '/src/Routing/routes.php';

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $method = $_SERVER['REQUEST_METHOD'];

    $router->route($uri, $method);
} catch (Exception $e) {
    echo "Error in the container : " . $e->getMessage();
}
