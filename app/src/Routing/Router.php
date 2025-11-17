<?php

namespace Inn\App\Routing;

class Router
{

    protected $routes = [];

    public function add($uri, $controller, $method)
    {
        $this->routes[$uri] = [
                'controller' => $controller,
                'method' => $method
        ];
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
        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            if ($route['method'] === strtoupper($method)) {
                return require 'src/Controllers/'  . $route['controller'];
            }
        }
        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        die();
    }

}
