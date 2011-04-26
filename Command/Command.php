<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends BaseCommand
{
    protected $bundle;
    protected $template;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        if ($input->hasOption('template')) {
            $this->template = $input->getOption('template');
        }

        if ($input->hasArgument('bundle')) {
            $bundleName = $input->getArgument('bundle');
            $alias = $this->container->getParameter('d_tools_devkit.alias');

            if (isset($alias[$bundleName])) {
                $bundleName = $alias[$bundleName];
            }

            $this->bundle = $this->container->get('kernel')
                ->getBundle($bundleName);

            $this->container->get('d_tools_devkit.generator')
                ->setDestinationDir($this->bundle->getPath());
        }
    }

    protected function getTemplatePath($folder)
    {
        $resource = sprintf('@DToolsDevkitBundle/Resources/skeleton/%s/%s', $folder, $this->template);
        $rootDir  = $this->container->get('kernel')->getRootDir() . '/Resources';

        return $this->container->get('kernel')->locateResource($resource, $rootDir);
    }

    protected function resourceExists($bundle, $resource)
    {
        if ('/' !== substr($resource, 0, 1)) {
            $resource = '/' . $resource;
        }

        try {
            $this->container->get('kernel')
                ->locateResource('@' . $bundle->getName() . $resource);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }
}
