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
use Symfony\Bundle\FrameworkBundle\Util\Mustache;

class InitTestsCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:init-tests')
            ->setDescription('Initializes tests bootstrap.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Bootstrap template', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:init-tests</info> creates a bootstrap script to run PhpUnit tests directly from bundle folder.
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->resourceExists($this->bundle, '/phpunit.xml.dist')) {
            throw new \RuntimeException(sprintf('A "phpunit.xml.dist" file already exists in "%s" folder.', $this->bundle->getName()));
        }

        if ($this->resourceExists($this->bundle, '/Tests/bootstrap.php')) {
            throw new \RuntimeException(sprintf('A "bootstrap.php" file already exists in "%s" "Tests" folder.', $this->bundle->getName()));
        }

        $this->container->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('tests'))
            ->setFileNames(array(
                '_phpunit.xml.dist.tpl' => 'phpunit.xml.dist',
                '_bootstrap.tpl' => 'bootstrap.php'
             ))
            ->setParameters(array(
                'namespace' => addslashes($this->bundle->getNamespace()),
                'ct_namespace' => count(explode('\\', $this->bundle->getNamespace())),
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A <info>phpunit.xml.dist</info> and <info>Tests/bootstrap.php</info> files have been generated for bundle <info>%s</info>.', $this->bundle->getName()));
    }
}
