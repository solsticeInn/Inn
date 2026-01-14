<?php

declare(strict_types=1);

namespace Inn\App\Routing;

class RouteStorage
{
    protected array $routes = [];

    public function addRoute(string $uri, callable|array $controller, string $method): void
    {
        $this->routes[$method][$uri] = $controller;
    }

    public function getRoute(string $uri, string $method): ?array
    {
        return $this->routes[$method][$uri] ?? null;
    }
}
