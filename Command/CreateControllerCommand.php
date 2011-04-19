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

class CreateControllerCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:create-controller')
            ->setDescription('Creates a controller class inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputArgument('controller', InputArgument::REQUIRED, 'Controller name (without Controller suffix)'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Controller class template', 'default'),
                new InputOption('action', null, InputOption::VALUE_OPTIONAL, 'Name of skeleton action (without Action suffix)', 'index')
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-controller</info> command generates a controller class based on a customizable template inside a bundle.

Examples:

<info>./app/console devkit:create-controller AcmeMyBundle Default</info>

Creates a controller class <info>DefaultController</info> with a sample method <info>indexAction</info> in <info>AcmeMyBundle</info> using default template.

<info>./app/console devkit:create-controller AcmeMyBundle Main --action=show --template=container_aware</info>

Creates a controller class <info>MainController</info> with a sample method <info>showAction</info> in <info>AcmeMyBundle</info> using <info>container_aware</info> template.

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
        $controllerName = ucfirst($input->getArgument('controller'));
        $controllerFile = $controllerName . 'Controller.php';

        if ($this->resourceExists($this->bundle, '/Controller/' . $controllerFile)) {
            throw new \RuntimeException(sprintf('A controller "%s" already exists in bundle "%s".', $controllerName, $this->bundle->getName()));
        }

        $this->container->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('controller'))
            ->setFileNames(array('_controller.tpl' => $controllerFile))
            ->setParameters(array(
                'namespace' => $this->bundle->getNamespace(),
                'controller' => $controllerName,
                'action' => $input->getOption('action'),
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A controller <info>%sController</info> has been successfully created in bundle <info>%s</info>', $controllerName, $this->bundle->getName()));
    }
}
