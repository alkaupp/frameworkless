<?php
declare(strict_types=1);

namespace Fwless\Configuration;

use HaydenPierce\ClassFinder\ClassFinder;
use Psr\Container\ContainerInterface;

class AppConfiguration implements Configuration
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function configure(): void
    {
        $configurations = ClassFinder::getClassesInNamespace(__NAMESPACE__);
        foreach ($configurations as $config) {
            if ($config === self::class) {
                continue;
            }
            $this->applyConfiguration($this->container->get($config));
        }
    }

    private function applyConfiguration(Configuration $configuration): void
    {
        $configuration->configure();
    }
}
