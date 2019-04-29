<?php
declare(strict_types=1);

namespace Paysera\Component\CodeClimateMerger\Console;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Main
{
    private $version;
    private $baseDir;

    public function __construct(string $version, string $baseDir)
    {
        $this->version = $version;
        $this->baseDir = $baseDir;
    }

    public function createApplication()
    {
        $container = $this->buildContainer();
        $application = new Application($container, $this->version);

        return $application;
    }

    private function buildContainer(): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $xmlLoader = new XmlFileLoader($containerBuilder, new FileLocator($this->baseDir . '/config'));
        $xmlLoader->load('container.xml');

        $containerBuilder->setParameter('version', $this->version);
        $containerBuilder->setParameter('root_dir', $this->baseDir);

        $containerBuilder->compile();

        return $containerBuilder;
    }
}
