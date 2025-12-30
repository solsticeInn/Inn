<?php

declare(strict_types=1);

namespace Inn\App\Container;

use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;
use Inn\App\Attributes\Env;

class Container
{
    protected array $instances = [];
    protected array $parameters = [];

    public function get(string $className): object
    {
        if ($this->has($className)) {
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
            $envAttributes = $parameter->getAttributes(Env::class);

            $parameterType = $parameter->getType();

            if (!empty($envAttributes)) {
                $envInstance = $envAttributes[0]->newInstance();

                $envValue =  $_ENV[$envInstance->key] ?? getenv($envInstance->key);

                if ($envValue !== false && isset($envValue)) {
                    $dependencies[] = $this->castType($envValue, $parameterType);
                } else {
                    $dependencies[] = $this->castType($envInstance->default, $parameterType);
                }

                continue;
            }

            if ($parameterType && !$parameterType->isBuiltin()) {
                $dependencies[] = $this->get($parameterType->getName());
                continue;
            }

            if (array_key_exists($parameter->getName(), $this->parameters)) {
                $dependencies[] = $this->parameters[$parameter->getName()];
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            throw new Exception("Unresolved situation with parameter: " . $parameter->getName());
        }

        $object = $reflector->newInstanceArgs($dependencies);
        $this->instances[$className] = $object;

        foreach ($reflector->getProperties() as $property) {
            $envAttributes = $property->getAttributes(Env::class);

            if (!empty($envAttributes)) {
                $envInstance = $envAttributes[0]->newInstance();

                $envValue =  $_ENV[$envInstance->key] ?? getenv($envInstance->key);

                if ($envValue === false || $envValue === null) {
                    $envValue = $envInstance->default;
                }

                $castedEnvValue = $this->castType($envValue, $property->getType());

                $property->setValue($object, $castedEnvValue);
            }
        }

        return $object;
    }

    public function has(string $dependency): bool
    {
        return isset($this->instances[$dependency]);
    }

    private function castType(mixed $value, ?ReflectionType $type): mixed
    {
        if (!($type instanceof ReflectionNamedType) || !$type->isBuiltin()) {
            return $value;
        }

        return match ($type->getName()) {
            'int' => (int) $value,
            'float' => (float) $value,
            'bool' => filter_var($value, FILTER_VALIDATE_BOOL),
            'string' => (string) $value,
            default => $value,
        };
    }
}
