<?php

declare(strict_types=1);

namespace Inn\App\Routing;

class Router
{
    public RouteStorage $route;

    public function __construct(RouteStorage $route)
    {
        $this->route = $route;
    }

    public function add(string $uri, string $controller, string $method): void
    {
        $this->route->addRoute($uri,  $controller, $method);
    }

    public function post(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'POST');
    }

    public function get(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'GET');
    }

    public function patch(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'PATCH');
    }

    public function put(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function delete(string $uri, string $controller): void
    {
        $this->add($uri, $controller, 'DELETE');
    }

    public function route(string $uri, string $method)
    {
        $controller = $this->route->getRoute($uri, $method);

        if (isset($controller)) {
            return require $controller;
        }

        $this->abort();
    }

    protected function abort($code = 404): void
    {
        http_response_code($code);

        die();
    }
}
