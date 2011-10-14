<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\DependencyInjection\Container;

class CreateConfigCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:create-config')
            ->setDescription('Creates a Dependency Injection extension and a configuration class for a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputArgument('config', InputArgument::OPTIONAL, 'Configuration file', 'config.xml'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Template name', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-config</info> command creates a bundle Dependency Injection extension and a configuration class with some sample parameters.

Examples:

./app/console devkit:create-config AcmeMyBundle parameters.xml
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getArgument('config');

        if (preg_match('/[^A-Za-z0-9_\.]/', $configFile)) {
            throw new \InvalidArgumentException('Invalid configuration file name: only letters, numbers ".", "_" are allowed.');
        }

        if ('.xml' != substr($configFile, -4)) {
            throw new \InvalidArgumentException("Use '.xml' as configuration file extension (other formats are currently not supported)");
        }

        $extensionClass = preg_replace('/Bundle$/', '', $this->bundle->getName()) . 'Extension';

        $resources = array(
            'DependencyInjection/' . $extensionClass . '.php',
            'DependencyInjection/Configuration.php',
            'Resources/config/' . $configFile,
        );
        foreach ($resources as $resource) {
            if ($this->resourceExists($this->bundle, $resource)) {
                throw new \RuntimeException(sprintf('A "%s" file already exists in "%s".', $resource, $this->bundle->getName()));
            }
        }
        $alias = Container::underscore(str_replace('Bundle', '', $this->bundle->getName()));

        $this->getContainer()->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('config'))
            ->setFileNames(array(
                '_extension.tpl' => $extensionClass . '.php',
                '_configuration.tpl' => 'Configuration.php',
                '_config.tpl' => $configFile
             ))
            ->setParameters(array(
                'namespace' => $this->bundle->getNamespace(),
                'class' => $extensionClass,
                'alias' => Container::underscore(str_replace('Bundle', '', $this->bundle->getName())),
                'config' => $configFile,
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A Dependency Injection extension has been successfully created for bundle <info>"%s"</info>', $this->bundle->getName()));
    }
}
