<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Tests\Command;

use DTools\DevkitBundle\Test\CommandTestCase;
use DTools\DevkitBundle\Command\InitTestsCommand;

class InitTestsCommandTest extends CommandTestCase
{
    public function testInitTests()
    {
        $this->setTargetExpects(array(
            'phpunit.xml.dist' => '/./',
            'Tests/bootstrap.php' => "/DToolsTest\\\\{2}DummyBundle/"
        ));
        $this->executeCommand();
    }

    public function testInitTestsResourceExists()
    {
        $this->setExpectedException('RuntimeException');
        $this->executeCommand(array('bundle' => 'DummyBundle2'));
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:init-tests',
            'bundle' => 'DummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new InitTestsCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
