<?php
declare(strict_types=1);

use function DI\create;
use function DI\get;

return [
    \League\Route\Strategy\ApplicationStrategy::class => create(\League\Route\Strategy\ApplicationStrategy::class),
    \League\Route\Router::class => create(\League\Route\Router::class)
        ->method("setStrategy", get(\League\Route\Strategy\ApplicationStrategy::class)),
    \Fwless\Configuration\RouteConfiguration::class => create(\Fwless\Configuration\RouteConfiguration::class)
        ->constructor(__DIR__ . "/routes.php"),
    \Nyholm\Psr7Server\ServerRequestCreatorInterface::class => create(\Nyholm\Psr7Server\ServerRequestCreator::class)
        ->constructor(
            new \Nyholm\Psr7\Factory\Psr17Factory(),
            new \Nyholm\Psr7\Factory\Psr17Factory(),
            new \Nyholm\Psr7\Factory\Psr17Factory(),
            new \Nyholm\Psr7\Factory\Psr17Factory()
        )
];