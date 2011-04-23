<?php

namespace {{ namespace }}\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class {{ class }} extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('{{ config }}');

        $container->setParameter('{{ alias }}.param1', $config['param1']);
        $container->setParameter('{{ alias }}.param2.key1', $config['param2']['key1']);
        $container->setParameter('{{ alias }}.param2.key2', $config['param2']['key2']);
    }
}