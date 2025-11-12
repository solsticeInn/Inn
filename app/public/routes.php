<?php

return function (\Inn\App\Router $router) {
    $router->get("/", "index.php");
    $router->get("/about", "about.php");
};