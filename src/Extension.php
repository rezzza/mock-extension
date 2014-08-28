<?php

namespace Rezzza\MockExtension;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Extension implements ExtensionInterface
{
    public function getConfigKey()
    {
        return 'mocker';
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/Resources'));
        $loader->load('services.xml');
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    public function process(ContainerBuilder $container)
    {
    }
}

