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

class AddDocsCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:add-docs')
            ->setDescription('Creates sample documentation inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Documentation template', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:add-docs</info> command creates sample documentation inside the <info>Resources/doc/</info> folder of a given bundle.
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->resourceExists($this->bundle, '/Resources/doc/index.rst')) {
            throw new \RuntimeException(sprintf('A documentation index file already exists in bundle "%s".', $this->bundle->getName()));
        }

        $this->getContainer()->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('doc'))
            ->setFileNames(array('_index.tpl' => 'index.rst'))
            ->setParameters(array(
                'namespace' => $this->bundle->getNamespace(),
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('Sample documentation file has been added in <info>Resources/doc</info> folder of bundle <info>%s</info>', $this->bundle->getName()));
    }
}
