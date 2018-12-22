<?php
declare(strict_types=1);

namespace Fwless\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParameterExampleAction
{
    public function __invoke(ServerRequestInterface $request, array $vars): ResponseInterface
    {
        $identifier = $vars["id"];
        return new Response(
            200,
            ["Content-Type" => "application/json"],
            json_encode(["this is an" => "example{$identifier}"]
            )
        );
    }
}
