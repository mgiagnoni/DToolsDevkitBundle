<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Tests\Command;

use DTools\DevkitBundle\Test\CommandTestCase;
use DTools\DevkitBundle\Command\CreateCommandCommand;

class CreateCommandCommandTest extends CommandTestCase
{
    public function testCreateCommand()
    {
        $this->setSourceDirExpects('command');

        $this->setFilenamesExpects(array(
            '_command.tpl' => 'MyTestCommand.php'
        ));

        $this->setParametersExpects(array(
            'namespace' => 'DToolsTest\DummyBundle',
            'class' => 'MyTest',
            'command' => 'my:test',
            'bundle' => 'DummyBundle'
        ));

        $commandTester = $this->executeCommand();

        $this->assertRegExp("/my:test(.*?)MyTestCommand(.*?)DummyBundle/", $commandTester->getDisplay());
    }

    public function testCreateCommandClass()
    {
        $this->setSourceDirExpects('command');

        $this->setFilenamesExpects(array(
            '_command.tpl' => 'MyClassCommand.php'
        ));

        $this->setParametersExpects(array(
            'namespace' => 'DToolsTest\DummyBundle',
            'class' => 'MyClass',
            'command' => 'my:test',
            'bundle' => 'DummyBundle'
        ));

        $commandTester = $this->executeCommand(array('--class' => 'MyClass'));

        $this->assertRegExp("/my:test(.*?)MyClassCommand(.*?)DummyBundle/", $commandTester->getDisplay());
    }

    public function testCreateCommandResourceExists()
    {
        $this->setExpectedException('RuntimeException');
        $this->executeCommand(array('bundle' => 'DummyBundle2'));
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:create-command',
            'cmd' => 'my:test',
            'bundle' => 'DummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new CreateCommandCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
