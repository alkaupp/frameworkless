<?php

use DI\ContainerBuilder;
use Fwless\Route\RouteConfiguration;
use League\Route\Router;
use Fwless\Server\RequestSender;
use Nyholm\Psr7\Response;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;

require __DIR__ . "/vendor/autoload.php";

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . "/config/dependency-injection.php");
try {
    $container = $containerBuilder->build();
    $routeBuilder = $container->get(RouteConfiguration::class);
    $router = $container->get(Router::class);
    $routeBuilder->configure($router);
    $requestCreator = $container->get(ServerRequestCreatorInterface::class);
    $response = $router->dispatch($requestCreator->fromGlobals());
} catch (\League\Route\Http\Exception\NotFoundException $e) {
    $response = new Response(404, ["Content-Type" => "application/json"], json_encode(["status" => 404, "error" => $e->getMessage()]));
} catch (\DI\NotFoundException $e) {
    $response = new Response(500, ["Content-Type" => "application/json"], json_encode(["status" => 500, "error" => $e->getMessage()]));
} catch (\Exception $e) {
    $response = new Response(500, ["Content-Type" => "application/json"], json_encode(["status" => 500, "error" => $e->getMessage()]));
}
(new RequestSender())->send($response);
