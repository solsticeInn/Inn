<?php

namespace Inn\App\Routing;

use ReflectionClass;
use Inn\App\Attributes\Route;
use ReflectionException;

class RouteRegistrar
{
    protected Router $router;
    protected array $controllers = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @throws ReflectionException
     */
    public function registerControllers(): void
    {
        $this->prepareFolderScanning();

        foreach ($this->controllers as $controller) {
            $this->registerController($controller);
        }
    }

    protected function prepareFolderScanning(): void
    {
        $rootNamespace = "Inn\\App\\Controllers\\";

        $pattern = __DIR__ . "/../Controllers/";

        $folderElements = scandir($pattern);

        $this->collectControllers($folderElements, $pattern, $rootNamespace);

    }

    protected function collectControllers(array $folderElements, string $pattern, string $namespace): void
    {
        foreach ($folderElements as $folderElement) {
            if ($folderElement === '.' || $folderElement === '..') {
                continue;
            }

            $folderElementPath = $pattern . $folderElement;

            if (is_file($folderElementPath)) {
                $this->controllers[] = $namespace . basename($folderElement, '.php');
            }

            if (is_dir($folderElementPath)) {
                $namespaceElement = $namespace . $folderElement  . "\\";

                $folderElements = scandir($folderElementPath . '/');

                $this->collectControllers($folderElements, $folderElementPath . '/', $namespaceElement);
            }
        }
    }

    /**
     * @throws ReflectionException
     */
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