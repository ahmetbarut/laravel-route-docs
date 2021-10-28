<?php

namespace ahmetbarut\LaravelRouteDocs;

use App\Console\Commands\RouteCommand;
use Illuminate\Routing\Router;

class Matcher
{
    public \Illuminate\Routing\Router $route;

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


            if ($route->getPrefix() !== '_ignition')
            {
                if ($route->getAction('controller') === null)
                {
                    $reflection = new \ReflectionFunction($route->getAction('uses'));

                }else{
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
                ];
            }
        }
        return $array;
    }

    public function getDocComment($text): mixed
    {
        preg_match_all('/[a-zA-Z0-9\@\-_\\\\]+/mu', $text, $res);

        return preg_replace_callback('#@route-doc(.*)@end-doc#', function ($matched){
            return($matched[1]);
        }, implode(' ', $res[0]));
    }

    public function resolve(string $namespace)
    {
        $explode = explode('@', $namespace);
        $this->resolveController = $explode[0];
        $this->resolveMethod = $explode[1];
    }

}
