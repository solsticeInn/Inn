<?php

declare(strict_types=1);

namespace Inn\App\Routing;

class RouteStorage
{
    protected array $routes = [];

    public function addRoute(string $uri, string $controller, string $method): void
    {
        $this->routes[$method][$uri] = $controller;
    }

    public function getRoute(string $uri, string $method): string|null
    {

        $controller = $this->routes[$method][$uri] ?? null;
        if (isset($controller)) {
            return 'src/Controllers/'  . $controller;
        }
        return null;
    }

}