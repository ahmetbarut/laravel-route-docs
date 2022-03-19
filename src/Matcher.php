<?php

namespace AhmetBarut\LaravelRouteDocs;

use Illuminate\Routing\Router;
use ReflectionMethod;
use ReflectionParameter;

class Matcher
{
    public Router $route;

    public array $requestMethods = [];

    private string $resolveMethod = "";
    private string $resolveController = "";

    public function __construct(Router $route)
    {
        $this->route = $route;
    }

    /**
     * @throws \ReflectionException
     */
    public function getDetails(): array
    {
        $array = [];

        foreach ($this->route->getRoutes()->getRoutes() as $route) {

            if ($route->getPrefix() !== '_ignition') {
                if ($route->getAction('controller') === null) {
                    $reflection = new \ReflectionFunction($route->getAction('uses'));
                } else {
                    $this->resolve($route->getAction('uses'));
                    $reflection = new \ReflectionMethod(new $this->resolveController, $this->resolveMethod);
                }
                $array[] = [
                    'name' => $route->getName(),
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'isCallback' => ($route->getAction('controller') === null),
                    'action' => [
                        'middleware' => $route->gatherMiddleware(),
                        'uses' => $route->getAction('uses'),
                        'prefix' => $route->getAction('prefix'),
                    ],
                    'comment' => $this->getDocComment($reflection->getDocComment()),
                    'method' => [
                        'name' => $reflection->getName(),
                        'parameters' => $this->getParameters($reflection->getParameters()),
                        'return' => $reflection->getReturnType(),
                    ],
                ];
            }
        }
        return $array;
    }

    public function getDocComment($text)
    {
        preg_match_all('/[a-zA-Z0-9öÖçÇğĞİşŞüÜı\@\-_\\\\]+/mu', $text, $res);
        return preg_replace_callback('#@route-doc(.*)@end-doc#', function ($matched) {
            return ($matched[1]);
        }, implode(' ', $res[0]));
    }

    public function resolve(string $namespace)
    {
        $explode = explode('@', $namespace);
        $this->resolveController = $explode[0];
        $this->resolveMethod = $explode[1];
    }

    public function getParameters(array $parameters): array
    {
        $array = [];
        foreach ($parameters as $parameter) {
            $array[] = [
                'name' => $parameter->getName(),
                'type' => $parameter->getType()->getName(),
                'isOptional' => $parameter->isOptional(),
                'default' => $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null,
            ];
        }
        return $array;
    }

    public function getReturn($reflection): array
    {
        return [
            'type' => $reflection->getName(),
        ];
    }
}
