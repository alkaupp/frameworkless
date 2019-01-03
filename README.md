Frameworkless app-template
==========================

The purpose of this application template is to allow building an application relying solely on single-purpose libraries.

These libraries implement various PSRs (PSR-7, PSR-17, PSR-15 to name a few) which will combine into a working application with interchangeable components.

*WIP*

Running the application
-----------------------

```
docker-compose up
```

Open browser in http://localhost:8080/example or /example/123456.

Create a controller action
--------------------------

Define route in `app/config/routes.php`:

```php
<?php

return [
    //...
    ["GET", "/path", \MyNameSpace\MyAction::class],
    ["GET", "/anotherpath", function (\Psr\Http\Message\ServerRequestInterface): \Psr\Http\Message\ResponseInterface { //... }]
];
```

Route definition consists of three arguments: HTTP method, path and request handler. To learn more about routes check
documentation of [FastRoute](https://github.com/nikic/FastRoute) or [route component by League](https://route.thephpleague.com/).

Then define your request handler. Request handler has to a callable. It can be a function or a class with `__invoke()` method.

```php
<?php

namespace MyNameSpace;

use MyService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;

class MyAction
{
    private $myService;
    
    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
    }
    
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $result = $this->myService->fetchSomething();
        // Use any PSR-7 Response implementation you like
        return new Response(
            200,
            ["Content-Type" => "application/json"],
            json_encode(["results" => $result])
        );
    }
}
```

Use dependency injection if you need to inject something to your request handler:

Dependency injection container is built based on `app/config/dependency-injection.php`. Router will automatically query
the container for classes. If your class doesn't have any constructor arguments you don't need to use the container as
the router will be able to handle instantiating the request handler.

```php
<?php
declare(strict_types=1);

use function DI\create;
use function DI\get;

return [
    //...
    \MyNameSpace\MyService::class => create(\MyNameSpace\MyService::class),
    \MyNameSpace\MyAction::class => create(\MyNameSpace\MyAction::class)
        ->constructor(get(\MyNameSpace\MyService::class))
];
```