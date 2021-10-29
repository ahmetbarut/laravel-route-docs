<?php

namespace AhmetBarut\LaravelRouteDocs;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use AhmetBarut\LaravelRouteDocs\Template\Markdown;

class RouteDocsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:docs {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate route documentation';

    public Matcher $routes;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $route)
    {
        $this->routes = new Matcher($route);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \ReflectionException
     */
    public function handle()
    {
        $path = $this->argument('path') ?? './docs/routes.md';

        $matcher = new Markdown();
        $matcher->write($this->routes->getDetails(), $path);

        return 0;
    }
}
