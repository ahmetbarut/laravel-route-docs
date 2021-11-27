<?php

namespace AhmetBarut\LaravelRouteDocs\Template;

use AhmetBarut\LaravelRouteDocs\Template\ITemplate;

class Markdown implements ITemplate
{
    protected string $path = __DIR__;

    protected array $text = [];

    public function write($data, $path = './docs/routes.md')
    {
        $stubText = file_get_contents(dirname($this->path) . '/stubs.md');
        $allText = '';
        foreach ($data as $route)
        {
            $text = $stubText;
            $text = $this->replaceRouteName(trim($route['name']) ?? 'Undefined', $text);
            $text = $this->replaceRouteUri(trim($route['uri']), $text);
            $text = $this->replaceRouteRequestMethod(trim(implode(', ', $route['methods'])), $text);
            $text = $this->replaceRouteDescription(trim($route['comment']), $text);
            $text = $this->replaceMethod($route['method']['name'], $text);
            $text = $this->replaceParameter($route['method']['parameters'], $text);
            $text = $this->replaceReturnType($route['method']['return'], $text);
            $allText .= $text;
         }
        file_put_contents($path, $allText);
    }

    /**
     * Replace route name.
     * @param $replace
     * @param $text
     * @param string $search
     * @return array|string|string[]
     */
    public function replaceRouteName($replace, $text, string $search = '{{route_name}}')
    {
        return str_replace($search, $replace, $text);
    }

    /**
     * Replace route uri.
     * @param $replace
     * @param $text
     * @param string $search
     * @return array|string|string[]
     */
    public function replaceRouteUri($replace, $text, string $search = '{{uri}}')
    {
        return str_replace($search, $replace, $text);
    }

    /**
     * Replace route description.
     * @param $replace
     * @param $text
     * @param string $search
     * @return array|string|string[]
     */
    public function replaceRouteDescription($replace, $text, string $search = '{{description}}')
    {
        return str_replace($search, $replace, $text);
    }

    /**
     * Replace route methods.
     * @param $replace
     * @param $text
     * @param string $search
     * @return array|string|string[]
     */
    public function replaceRouteRequestMethod($replace, $text, string $search = '{{RequestMethod}}')
    {
        return str_replace($search, $replace, $text);
    }

    public function replaceMethod($replace, $text, string $search = '{{method}}')
    {
        return str_replace($search, $replace, $text);
    }

    public function replaceParameter($replace, $text, string $search = '{{parameters}}')
    {
        $param = "";
        foreach ($replace as $parameter) {
            $param = "({$parameter['type']} \${$parameter['name']})";
        }
        return str_replace($search, $param, $text);
    }

    public function replaceReturnType($replace, $text, string $search = '{{return_type}}')
    {
        if ($replace !== null) {
            return str_replace($search, ': ' . $replace, $text);
        }
        return str_replace($search, $replace, $text);
    }
}
