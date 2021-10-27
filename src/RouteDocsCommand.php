<?php

namespace ahmetbarut\LaravelRouteDocs;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class RouteDocsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate route documentation';

    public $routes;

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
        dd($this->routes->getDetails());
        return 0;
    }
}
