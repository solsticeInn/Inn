<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Inn\App\Routing\Router;
use Inn\App\Routing\RouteRegistrar;
use Inn\App\Container\Container;
use Inn\App\Routing\RequestHandler;
use Dotenv\Dotenv;
use Inn\App\Logger\Logger;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();

try {
    $logger = new Logger();

    $router = $container->get(Router::class);
    $registrar = $container->get(RouteRegistrar::class);
    $handler = $container->get(RequestHandler::class);

    $registrar->registerControllers();

    $handler->handleRequest();
} catch (Exception $e) {
    echo "Error while building container: " . $e->getMessage() . "\n";
    echo "in file: " . $e->getFile() . "\n";
    echo "on line: " . $e->getLine() . "\n";
}
