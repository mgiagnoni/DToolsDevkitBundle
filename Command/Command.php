<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as BaseCommand;
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
            $alias = $this->getContainer()->getParameter('d_tools_devkit.alias');

            if (isset($alias[$bundleName])) {
                $bundleName = $alias[$bundleName];
            }

            $this->bundle = $this->getContainer()->get('kernel')
                ->getBundle($bundleName);

            $this->getContainer()->get('d_tools_devkit.generator')
                ->setDestinationDir($this->bundle->getPath())
                ->setCommonDir($this->getTemplatePath('_common', true));
        }
    }

    protected function getTemplatePath($folder, $noTemplate = false)
    {
        $resource = sprintf('@DToolsDevkitBundle/Resources/skeleton/%s/%s', $folder, $noTemplate ? '' : $this->template);
        $rootDir  = $this->getContainer()->get('kernel')->getRootDir() . '/Resources';

        return $this->getContainer()->get('kernel')->locateResource($resource, $rootDir);
    }

    protected function resourceExists($bundle, $resource)
    {
        if ('/' !== substr($resource, 0, 1)) {
            $resource = '/' . $resource;
        }

        try {
            $this->getContainer()->get('kernel')
                ->locateResource('@' . $bundle->getName() . $resource);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }
}
