<?php

namespace Inn\App\Routing;

class RequestHandler
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handleRequest(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $response = $this->router->route($uri, $method);

        echo $response;
    }
}