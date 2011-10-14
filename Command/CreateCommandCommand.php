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
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Command class template', 'default'),
                new InputOption('class', null, InputOption::VALUE_OPTIONAL, 'Command class name (without Command suffix)'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-command</info> command generates a console command class, based on a customizable template, inside a bundle.

Examples:

<info>./app/console devkit:create-command AcmeMyBundle my:task</info>

Creates a command class <info>MyTaskCommand</info> in <info>AcmeMyBundle</info> using default template.

The class is named after the command name, use the <info>--class</info> switch to set a different name.

Sample templates are in <info>DTools/DevkitBundle/Resources/skeleton/command</info> and can be customized by copying them to <info>app/Resources/DtoolsDevkitBundle/skeleton/command</info>
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('cmd');

        if (preg_match('/[^A-Za-z0-9\:\-]/', $command)) {
            throw new \InvalidArgumentException('The command name contains invalid characters (only letters, numbers "-", ":" are allowed).');
        }
        if (!$class = $input->getOption('class')) {
            $class = str_replace(array(':', '-'), ' ', $command);
            $class = str_replace(' ', '', ucwords($class));
        }

        $commandFile =  $class . 'Command.php';

        if ($this->resourceExists($this->bundle, '/Command/' . $commandFile)) {
            throw new \RuntimeException(sprintf('A command class "%sCommand" already exists in bundle "%s".', $class, $this->bundle->getName()));
        }

        $this->getContainer()->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('command'))
            ->setFileNames(array('_command.tpl' => $commandFile))
            ->setParameters(array(
                'namespace' => $this->bundle->getNamespace(),
                'class' => $class,
                'command' => $command,
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A console command <info>%s</info> (class <info>%sCommand</info>) has been successfully created in bundle <info>%s</info>', $command, $class, $this->bundle->getName()));
    }
}
