<?php

declare(strict_types=1);

namespace Inn\App\Container;

use Exception;
use ReflectionClass;

class Container
{
    protected array $instances = [];

    public function get(string $className): object
    {
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }

        if (!class_exists($className)) {
            throw new Exception("Class $className is not defined.");
        }

        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        if (!$constructor || $constructor->getNumberOfParameters() === 0) {
            $object = new $className();
            $this->instances[$className] = $object;

            return $object;
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterType = $parameter->getType();

            if ($parameterType && !$parameterType->isBuiltin()) {
                $dependencies[] = $this->get($parameterType->getName());
            } else {
                throw new Exception("Unresolved situation with parameter: " . $parameter->getName());
            }
        }

        $object = $reflector->newInstanceArgs($dependencies);
        $this->instances[$className] = $object;

        return $object;
    }
}
