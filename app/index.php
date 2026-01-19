<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Inn\App\Routing\Router;
use Inn\App\Routing\RouteRegistrar;
use Inn\App\Container\Container;
use Inn\App\Routing\RequestHandler;
use Inn\App\Logger\Logger;
use Dotenv\Dotenv;
use Nyholm\Psr7\Request;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();

try {
    $logger = $container->get(Logger::class);

    $router = $container->get(Router::class);
    $registrar = $container->get(RouteRegistrar::class);
    $handler = $container->get(RequestHandler::class);

    $registrar->registerControllers();

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    $request = new Request($method, $uri);

    $response = $handler->handleRequest($request);

    echo $response->getBody();
} catch (Exception $e) {
    echo "Error while building container: " . $e->getMessage() . " in file: " . $e->getFile() . " on line: " . $e->getLine() . "\n";
}
