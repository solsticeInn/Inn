<?php

namespace Inn\App\Routing;

use ReflectionClass;
use Inn\App\Attributes\Route;

class RouteRegistrar
{
    protected Router $router;
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function registerControllers(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $this->registerController($controller);
        }
    }

    protected function registerController(string $controller): void
    {
        $reflection = new ReflectionClass($controller);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(Route::class);

            foreach ($attributes as $attribute) {
                $attributeInstance = $attribute->newInstance();

                $this->router->add(
                    $attributeInstance->path,
                    [$controller, $method->getName()],
                    $attributeInstance->method);
            }
        }
    }
}