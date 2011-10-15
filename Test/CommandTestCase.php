<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    protected $kernel;
    protected $container;
    protected $generator;

    protected function getMockKernel()
    {
        if (null === $this->kernel) {

            $this->kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\Kernel')
                    ->disableOriginalConstructor()
                    ->setMethods(array(
                        'getContainer',
                        'registerBundles',
                        'registerContainerConfiguration',
                        'initializeContainer'
                    ))
                    ->getMock();

            $this->kernel->expects($this->once())
                ->method('registerBundles')
                ->will($this->returnValue(array(
                    new \DTools\DevkitBundle\DToolsDevkitBundle(),
                    new \DTools\DevkitBundle\Tests\Fixtures\DummyBundle\DummyBundle(),
                    new \DTools\DevkitBundle\Tests\Fixtures\DummyBundle2\DummyBundle2()
                )));

            $this->kernel->expects($this->any())
                ->method('getContainer')
                ->will($this->returnValue($this->getMockContainer()));
        }
        $this->kernel->boot();
        return $this->kernel;
    }

    protected function getMockContainer()
    {
        if (null === $this->container) {

            $services = array(
                'kernel' => $this->getMockKernel(),
                'filesystem' => $this->getMock('Symfony\Component\HttpKernel\Util\Filesystem'),
                'd_tools_devkit.generator' => $this->getMockGenerator()
            );

            $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');

            $this->container->expects($this->any())
                ->method('get')
                ->will($this->returnCallBack( function($arg) use ($services) {
                    if (isset($services[$arg])) {
                        return $services[$arg];
                    }
                }));
        }

        return $this->container;
    }

    protected function getMockGenerator()
    {
        if (null === $this->generator) {
            $this->generator = $this->getMockBuilder('DTools\DevkitBundle\Generator\DefaultGenerator')
                ->disableOriginalConstructor()
                ->setMethods(array(
                    'saveFile'
                ))
                ->getMock();
        }
        return $this->generator;
    }

    protected function setTargetExpects($files)
    {
        $base = realpath(__DIR__ . '/../Tests/Fixtures/DummyBundle');
        $at = 0;
        $generator = $this->getMockGenerator();

        foreach ($files as $file => $content) {
            $generator->expects($this->at($at))
                ->method('saveFile')
                ->with($this->equalTo($base.'/'.$file), $this->matchesRegularExpression($content));
            $at++;
        }
    }

    protected function getCommandTester($command)
    {
        $application = new Application($this->getMockKernel());
        $command->setApplication($application);

        return new CommandTester($command);
    }
}
