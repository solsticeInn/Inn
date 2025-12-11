<?php

declare(strict_types=1);

namespace Inn\App\Routing;

class Router
{
    public RouteStorage $route;

    public function __construct(RouteStorage $route, string $greetsFromRouter)
    {
        $this->route = $route;

//        echo $greetsFromRouter . '<br>';
    }

    public function add(string $uri, callable|array $controller, string $method): void
    {
        $this->route->addRoute($uri, $controller, $method);
    }

    public function post(string $uri, callable|array $controller): void
    {
        $this->add($uri, $controller, 'POST');
    }

    public function get(string $uri, callable|array $controller): void
    {
        $this->add($uri, $controller, 'GET');
    }

    public function patch(string $uri, callable|array $controller): void
    {
        $this->add($uri, $controller, 'PATCH');
    }

    public function put(string $uri, callable|array $controller): void
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function delete(string $uri, callable|array $controller): void
    {
        $this->add($uri, $controller, 'DELETE');
    }

    public function route(string $uri, string $method): string
    {
        $controller = $this->route->getRoute($uri, $method);

        if (!$controller) {
            $this->abort();
        }

        return $controller;
    }

    protected function abort($code = 404): void
    {
        http_response_code($code);

        die();
    }
}
