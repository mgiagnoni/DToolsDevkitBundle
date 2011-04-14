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
        $commandTester = $this->executeCommand();

        $commandFile = $this->getDummyDir() . '/Command/MyTestCommand.php';
        $this->assertFileExists($commandFile);

        $this->assertRegExp("/my:test(.*?)MyTestCommand(.*?)DToolsTestDummyBundle/", $commandTester->getDisplay());

        $content = file_get_contents($commandFile);
        $this->assertRegExp('/MyTestCommand extends Command/', $content);
        $this->assertRegExp('/setName\(\'my:test\'\)/', $content);
        $this->setExpectedException('RuntimeException');
        $this->executeCommand();
    }

    public function testCreateCommandClass()
    {
        $commandTester = $this->executeCommand(array('--class' => 'MyClass'));

        $commandFile = $this->getDummyDir() . '/Command/MyClassCommand.php';
        $this->assertFileExists($commandFile);

        $this->assertRegExp("/my:test(.*?)MyClassCommand(.*?)DToolsTestDummyBundle/", $commandTester->getDisplay());

        $content = file_get_contents($commandFile);
        $this->assertRegExp('/MyClassCommand extends Command/', $content);
        $this->assertRegExp('/setName\(\'my:test\'\)/', $content);
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:create-command',
            'cmd' => 'my:test',
            'bundle' => 'DToolsTestDummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new CreateCommandCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
