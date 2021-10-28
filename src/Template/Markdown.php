<?php

namespace ahmetbarut\LaravelRouteDocs\Template;

use ahmetbarut\LaravelRouteDocs\Template\ITemplate;

class Markdown implements ITemplate
{
    protected $path;

    protected array $text = [];

    private string $stubText = "### {{route_name}}\n**{{uri}}**\n**{{method}}**\n\n{{description}}\n<hr>\n\n";

    public function write($data, $path = './docs/routes.md')
    {
        $allText = '';
        foreach ($data as $key => $rp)
        {
            $text = $this->stubText;
            $text = $this->replaceRouteName($rp['name'] ?? 'Undefined', $text);
            $text = $this->replaceRouteUri($rp['uri'], $text);
            $text = $this->replaceRouteMethod(implode(', ', $rp['methods']), $text);
            $text = $this->replaceRouteDescription($rp['comment'], $text);

            $allText .= $text;
         }
        file_put_contents($path, $allText);
    }

    public function replaceRouteName($replace, $text, $search = '{{route_name}}')
    {
        return str_replace($search, $replace, $text);
    }

    public function replaceRouteUri($replace, $text, $search = '{{uri}}')
    {
        return str_replace($search, $replace, $text);
    }

    public function replaceRouteDescription($replace, $text, $search = '{{description}}')
    {
        return str_replace($search, $replace, $text);
    }

    public function replaceRouteMethod($replace, $text, $search = '{{method}}')
    {
        return str_replace($search, $replace, $text);
    }
}
