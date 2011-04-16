<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command as BaseCommand;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;

abstract class Command extends BaseCommand
{
    protected function getTemplatePath($folder, $template)
    {
        $resource = sprintf('@DToolsDevkitBundle/Resources/skeleton/%s/%s', $folder, $template);
        $rootDir  = $this->container->get('kernel')->getRootDir() . '/Resources';

        return $this->container->get('kernel')->locateResource($resource, $rootDir);
    }

    protected function renderTemplate($templateFolder, $template, $destFolder, $renderFolder, $params)
    {
        $templatePath = $this->getTemplatePath($templateFolder, $template);

        $filesystem = $this->container->get('filesystem');
        $filesystem->mirror($templatePath, $destFolder);

        Mustache::renderDir($renderFolder, $params);
    }
}
