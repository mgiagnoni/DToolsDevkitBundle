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

class CreateCommandCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('devkit:create-command')
            ->setDescription('Creates a console command class inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputArgument('cmd', InputArgument::REQUIRED, 'Command name (exactly as you would execute it from console)'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Controller class template', 'default'),
                new InputOption('class', null, InputOption::VALUE_OPTIONAL, 'Command class name (without Command suffix)'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-command</info> command generates a console command class, based on a customizable template, inside a bundle.

Examples:

<info>./app/console devkit:create-command AcmeMyBundle my:task</info>

Creates a command class <info>MyTaskCommand</info> in <info>AcmeMyBundle</info> using default template.

The class is named after the command name, use the <info>--class</info> switch to set a different name.

Sample templates are in <info>DTools/DevkitBundle/Resources/skeleton/controller</info> and can be customized by copying them to <info>app/Resources/DtoolsDevkitBundle/skeleton/controller</info>
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
        $command = $input->getArgument('cmd');

        if (preg_match('/[^A-Za-z0-9\:\-]/', $command)) {
            throw new \InvalidArgumentException('The command name contains invalid characters (only letters, numbers "-", ":" are allowed).');
        }
        if (!$class = $input->getOption('class')) {
            $class = str_replace(array(':', '-'), ' ', $command);
            $class = str_replace(' ', '', ucwords($class));
        }

        $commandFolder = $bundle->getPath() . '/Command/';
        $commandFile = $commandFolder . $class . 'Command.php';

        if (file_exists($commandFile)) {
            throw new \RuntimeException(sprintf('A command class "%s" already exists in bundle "%s".', $class, $bundleName));
        }

        $this->renderTemplate('command', $input->getOption('template'), $bundle->getPath(), $commandFolder, array(
            'namespace' => $bundle->getNamespace(),
            'class' => $class,
            'command' => $command,
            'bundle' => $bundle->getName()
        ));

        rename($commandFolder . '_command.tpl', $commandFile);
        $output->writeln(sprintf('A console command <info>%s</info> (class <info>%sCommand</info>) has been successfully created in bundle <info>%s</info>', $command, $class, $bundle->getName()));
    }
}
