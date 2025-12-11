<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Inn\App\Routing\Router;
use Inn\App\Routing\RouteRegistrar;
use Inn\App\Container\Container;
use Inn\App\Routing\RequestHandler;

$container = new Container();

try {
    $container->addParameter('greetsFromRouter', 'Greets!');

    $router = $container->get(Router::class);
    $registrar = $container->get(RouteRegistrar::class);
    $handler = $container->get(RequestHandler::class);

    $controllers = [
        \Inn\App\Controllers\HomeController::class,
    ];

    $registrar->registerControllers($controllers);

    $handler->handleRequest();
} catch (Exception $e) {
    echo "Error while building container: " . $e->getMessage();
}
