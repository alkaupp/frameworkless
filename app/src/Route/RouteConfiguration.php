<?php
declare(strict_types=1);

namespace Fwless\Route;

use League\Route\Router;

class RouteConfiguration
{
    private $routeConfigPath;

    public function __construct(string $routeConfigPath)
    {
        $this->routeConfigPath = $routeConfigPath;
    }

    public function configure(Router $router): void
    {
        $routeConfig = require($this->routeConfigPath);
        foreach ($routeConfig as $config) {
            [$method, $path, $handler] = $config;
            $this->mapRoute($router, $method, $path, $handler);
        }
    }

    private function mapRoute(Router $router, string $method, string $path, string $handler): void
    {
        $router->map($method, $path, $handler);
    }
}
