<?php

use League\Route\Http\Exception\NotFoundException;
use League\Route\Router;
use Fwless\Controller\ExampleAction;
use Fwless\Controller\ParameterExampleAction;
use Fwless\Server\RequestSender;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7Server\ServerRequestCreator;

require __DIR__ . "/vendor/autoload.php";

$requestCreator = new ServerRequestCreator(
    new Psr17Factory(),
    new Psr17Factory(),
    new Psr17Factory(),
    new Psr17Factory()
);
try {
    $router = new Router();
    $router->get("/example", ExampleAction::class);
    $router->get("/example/{id:\d+}", ParameterExampleAction::class);
    $response = $router->dispatch($requestCreator->fromGlobals());
} catch (NotFoundException $e) {
    $response = new Response(404, ["Content-Type" => "application/json"], json_encode(["status" => 404, "error" => $e->getMessage()]));
}
(new RequestSender())->send($response);
