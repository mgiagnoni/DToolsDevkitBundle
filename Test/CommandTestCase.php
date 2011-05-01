<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Test;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected $tmpDir;
    protected $kernel;

    public function setup()
    {
        $this->registerTestNamespace();
        $this->mirrorConfiguration();
        $this->mirrorDummyBundle();
    }

    public function tearDown()
    {
        $this->deleteTmpDir();
    }

    protected function getKernel()
    {
        if (null === $this->kernel)
        {
            $this->createKernel();
        }
        return $this->kernel;
    }

    protected function createKernel()
    {
        $this->kernel = new Kernel($this->getTmpDir());
        $this->kernel->boot();
    }

    protected function getCommandTester($command)
    {
        $kernel = $this->getKernel();
        $application = new Application($kernel);
        $command->setApplication($application);

        return new CommandTester($command);
    }

    protected function getTmpDir()
    {
        if (!$this->tmpDir) {
            $tmpDir = sys_get_temp_dir().'/d_tools';
            if (!is_dir($tmpDir)) {
                if (false === @mkdir($tmpDir)) {
                    die(sprintf('Unable to create a temporary directory (%s)', $tmpDir));
                }
            } elseif (!is_writable($tmpDir)) {
                die(sprintf('Unable to write in a temporary directory (%s)', $tmpDir));
            }
            $this->tmpDir = $tmpDir;
        }
        return $this->tmpDir;
    }

    protected function getDummyDir()
    {
        return $this->getTmpDir() . '/src/DToolsTest/DummyBundle';
    }

    protected function deleteTmpDir()
    {
        if ($this->tmpDir) {
            $fs = new Filesystem();
            $fs->remove($this->tmpDir);
        }
    }

    protected function registerTestNamespace() {
        $loader = new UniversalClassLoader();
        $loader->registerNamespace('DToolsTest', $this->getTmpDir() . '/src');
        $loader->register();
    }

    protected function mirrorDummyBundle()
    {
        $fs = new Filesystem();
        $fs->mirror(__DIR__ . '/../Tests/Fixtures/bundle', $this->getTmpDir() . '/src');
    }

    protected function deleteDummyBundle()
    {
        $fs = new Filesystem();
        $fs->remove($this->getTmpDir() . '/src');
    }

    protected function mirrorConfiguration()
    {
        $fs = new Filesystem();
        $fs->mirror(__DIR__ . '/../Tests/Fixtures/configuration', $this->getTmpDir());
    }
}
