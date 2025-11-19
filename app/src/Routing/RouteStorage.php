<?php

namespace Inn\App\Routing;

class RouteStorage
{

    protected array $routes = [];

    public function addRoute($uri, $controller, $method)
    {
        $this->routes[$method][$uri] = $controller;
    }

    public function getRoute($uri, $method)
    {

        $controller = $this->routes[$method][$uri] ?? null;
        if (isset($controller)) {
            return 'src/Controllers/'  . $controller;
        }
        return null;
    }

}