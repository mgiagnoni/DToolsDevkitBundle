<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Test;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends BaseKernel
{
    protected $tmpDir;

    public function __construct($rootDir)
    {
        $this->tmpDir = $rootDir;
        parent::__construct('test', true);
    }

    public function getRootDir()
    {
        return $this->tmpDir;
    }

    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \DTools\DevkitBundle\DToolsDevkitBundle(),
            new \DToolsTest\DummyBundle\DToolsTestDummyBundle()
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->tmpDir.'/config/config.yml');
    }
}
