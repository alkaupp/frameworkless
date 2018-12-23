<?php
declare(strict_types=1);

return [
    ["GET", "/example", \Fwless\Controller\ExampleAction::class],
    ["GET", "/example/{id:\d+}", \Fwless\Controller\ParameterExampleAction::class]
];