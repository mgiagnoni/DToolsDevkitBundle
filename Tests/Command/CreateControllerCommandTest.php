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
        $this->setTargetExpects(array(
            'Controller/TestController.php' => "/namespace DToolsTest\\\\DummyBundle\\\\Controller(.*?)class TestController/s"
        ));

        $commandTester = $this->executeCommand();

        $this->assertRegExp("/TestController(.*?)DummyBundle/", $commandTester->getDisplay());
    }

    public function testCreateControllerResourceExists()
    {
        $this->setExpectedException('RuntimeException');
        $this->executeCommand(array('bundle' => 'DummyBundle2'));
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:create-controller',
            'controller' => 'test',
            'bundle' => 'DummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new CreateControllerCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
