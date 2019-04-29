<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Application extends BaseApplication
{
    public function __construct(ContainerInterface $container, string $version)
    {
        parent::__construct('code-climate-merger', $version);

        $this->add($container->get('command.merge'));
    }
}
