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
        $bundle = $this->findBundle($input->getArgument('bundle'));

        $bundleFolder = $bundle->getPath() . '/';
        $testsFolder = $bundleFolder . '/Tests/';

        if (file_exists($bundleFolder . '/phpunit.xml.dist')) {
            throw new \RuntimeException(sprintf('A "phpunit.xml.dist" file already exists in "%s" folder.', $bundle->getName()));
        }

        if (file_exists($testsFolder . '/bootstrap.php')) {
            throw new \RuntimeException(sprintf('A "bootstrap.php" file already exists in "%s" "Tests" folder.', $bundle->getName()));
        }

        $this->renderTemplate('tests', $input->getOption('template'), $bundleFolder, $testsFolder, array(
            'namespace' => addslashes($bundle->getNamespace()),
            'ct_namespace' => count(explode('\\', $bundle->getNamespace()))
        ));

        Mustache::renderFile($bundleFolder . '_phpunit.xml.dist.tpl', array(
            'bundle' => $bundle->getName()
        ));

        rename($bundleFolder . '_phpunit.xml.dist.tpl', $bundleFolder . 'phpunit.xml.dist');
        rename($testsFolder . '_bootstrap.tpl', $testsFolder . 'bootstrap.php');
        $output->writeln(sprintf('A <info>phpunit.xml.dist</info> and <info>Tests/bootstrap.php</info> files have been generated for bundle <info>%s</info>.', $bundle->getName()));
    }
}
