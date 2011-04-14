<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Tests\Command;

use DTools\DevkitBundle\Test\CommandTestCase;
use DTools\DevkitBundle\Command\CreateControllerCommand;

class CreateControllerCommandTest extends CommandTestCase
{
    public function testCreateController()
    {
        $commandTester = $this->executeCommand();

        $controllerFile = $this->getDummyDir() . '/Controller/DefaultController.php';
        $this->assertFileExists($controllerFile);

        $this->assertRegExp("/DefaultController(.*?)DToolsTestDummyBundle/", $commandTester->getDisplay());

        $content = file_get_contents($controllerFile);
        $this->assertRegExp('/DefaultController extends Controller/', $content);
        $this->assertRegExp('/public function indexAction()/', $content);

        $this->setExpectedException('RuntimeException');
        $this->executeCommand();
    }

    public function testCreateContainerAwareController()
    {
        $this->executeCommand(array('--template' => 'container_aware'));

        $controllerFile = $this->getDummyDir() . '/Controller/DefaultController.php';
        $this->assertFileExists($controllerFile);

        $content = file_get_contents($controllerFile);
        $this->assertRegExp('/DefaultController extends ContainerAware/', $content);
    }

    public function testCreateControllerAction()
    {
        $this->executeCommand(array('--action' => 'show'));

        $controllerFile = $this->getDummyDir() . '/Controller/DefaultController.php';
        $this->assertFileExists($controllerFile);

        $content = file_get_contents($controllerFile);
        $this->assertRegExp('/public function showAction()/', $content);
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:create-controller',
            'controller' => 'default',
            'bundle' => 'DToolsTestDummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new CreateControllerCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
