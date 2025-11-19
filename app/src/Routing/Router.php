<?php

namespace Inn\App\Routing;

class Router
{

    protected RouteStorage $route;

    public function __construct(RouteStorage $route)
    {
        $this->route = $route;
    }

    public function add($uri, $controller, $method)
    {
        $this->route->addRoute($uri, $controller, $method);
    }

    public function post($uri, $controller)
    {
        $this->add($uri, $controller, 'POST');
    }

    public function get($uri, $controller)
    {
        $this->add($uri, $controller, 'GET');
    }

    public function patch($uri, $controller)
    {
        $this->add($uri, $controller, 'PATCH');
    }

    public function put($uri, $controller)
    {
        $this->add($uri, $controller, 'PUT');
    }

    public function delete($uri, $controller)
    {
        $this->add($uri, $controller, 'DELETE');
    }

    public function route($uri, $method)
    {
        $controller = $this->route->getRoute($uri, $method);
        if (isset($controller)){
            return require $controller;
        }
        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        die();
    }

}
