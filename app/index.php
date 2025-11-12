<?php
require 'vendor/autoload.php';
use Inn\App;

//    const BASE_PATH = __DIR__.'/../';
//    echo BASE_PATH . '<br><br><br><br>';

//    Own-written class autoloader
//    spl_autoload_register(function ($class_name) {
//        $class_path = __DIR__ . "/" . str_replace('\\', '/',$class_name) . '.php';
//        include $class_path;
//    });

$router = new App\Router();

$load_routes = require __DIR__ . '/public/routes.php';
$load_routes($router);

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);