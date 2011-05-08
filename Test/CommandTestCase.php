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
                ->getMock();

            //Default expectations to mock generator fluent interface

            $this->generator->expects($this->any())
                ->method('setDestinationDir')
                ->will($this->returnValue($this->generator));

            $this->generator->expects($this->any())
                ->method('setSourceDir')
                ->will($this->returnValue($this->generator));

            $this->generator->expects($this->any())
                ->method('setParameters')
                ->will($this->returnValue($this->generator));

            $this->generator->expects($this->any())
                ->method('setFilenames')
                ->will($this->returnValue($this->generator));

        }
        return $this->generator;
    }

    protected function setSourceDirExpects($skeletonFolder, $template = 'default')
    {
        $generator = $this->getMockGenerator();
        $base = realpath(__DIR__ . '/../');

        $generator->expects($this->once())
            ->method('setSourceDir')
            ->with($this->equalTo(
                sprintf('%s/Resources/skeleton/%s/%s', $base, $skeletonFolder, $template)
            ))
            ->will($this->returnValue($generator));
    }

    protected function setParametersExpects($params)
    {
        $generator = $this->getMockGenerator();

        $generator->expects($this->once())
            ->method('setParameters')
            ->with($this->equalTo($params))
            ->will($this->returnValue($generator));
    }

    protected function setFilenamesExpects($files)
    {
        $generator = $this->getMockGenerator();

        $generator->expects($this->once())
            ->method('setFilenames')
            ->with($this->equalTo($files))
            ->will($this->returnValue($generator));
    }

    protected function getCommandTester($command)
    {
        $application = new Application($this->getMockKernel());
        $command->setApplication($application);

        return new CommandTester($command);
    }
}
