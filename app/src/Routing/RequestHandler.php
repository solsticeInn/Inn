<?php

namespace Inn\App\Routing;

use Inn\App\Container\Container;
use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

class RequestHandler
{
    private Router $router;
    private Container $container;

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * @throws ReflectionException
     */
    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();

        $routeInfo = $this->router->route($uri, $method);

        if (!$routeInfo) {
            return new Response(404, [], 'Not Found');
        }

        [$controllerClass, $methodName] = $routeInfo;

        $controller = $this->container->get($controllerClass);

        return $controller->$methodName($request);
    }
}