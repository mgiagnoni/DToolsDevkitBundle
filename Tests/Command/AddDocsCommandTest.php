<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Tests\Command;

use DTools\DevkitBundle\Test\CommandTestCase;
use DTools\DevkitBundle\Command\AddDocsCommand;

class AddDocsCommandTest extends CommandTestCase
{
    public function testAddDocs()
    {
        $this->setSourceDirExpects('doc');

        $this->setParametersExpects(array(
            'namespace' => 'DToolsTest\DummyBundle',
            'bundle' => 'DummyBundle'
        ));

        $commandTester = $this->executeCommand();

        $this->assertRegExp("/DummyBundle/", $commandTester->getDisplay());
    }

    public function testAddDocsResourceExists()
    {
        $this->setExpectedException('RuntimeException');
        $this->executeCommand(array('bundle' => 'DummyBundle2'));
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:add-docs',
            'bundle' => 'DummyBundle'
        ), $extra);

        $commandTester = $this->getCommandTester(new AddDocsCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
