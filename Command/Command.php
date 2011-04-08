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
    protected function findBundle($bundleName)
    {
        $found = false;

        foreach ($this->container->get('kernel')->getBundles() as $bundle) {
            if ($bundleName === $bundle->getName()) {
                $found = $bundle;
                break;
            }
        }

        if (!$found)
        {
            throw new \RuntimeException('The bundle "' . $bundleName . '" doesn\'t exist or is not enabled.');
        }

        return $found;
    }

    protected function getTemplatePath($folder, $template)
    {
        $paths = array(
            $this->container->get('kernel')->getRootDir() . '/Resources/DToolsDevkitBundle/',
            __DIR__.'/../Resources/',
        );

        $templatePath = null;
        foreach ($paths as $p) {
            $path = $p . 'skeleton/' . $folder . '/'. $template;
            if (file_exists($path)) {
                $templatePath = $path;
                break;
            }
        }

        if (null === $templatePath) {
            throw new \RuntimeException(sprintf('Template "%s" doesn\'t exist.', $template));
        }

        return $templatePath;
    }

    protected function renderTemplate($templateFolder, $template, $destFolder, $renderFolder, $params)
    {
        $templatePath = $this->getTemplatePath($templateFolder, $template);

        $filesystem = $this->container->get('filesystem');
        $filesystem->mirror($templatePath, $destFolder);

        Mustache::renderDir($renderFolder, $params);
    }
}
