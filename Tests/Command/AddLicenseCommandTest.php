<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Tests\Command;

use DTools\DevkitBundle\Test\CommandTestCase;
use DTools\DevkitBundle\Command\AddLicenseCommand;

class AddLicenseCommandTest extends CommandTestCase
{
    public function testAddLicense()
    {
        $this->setTargetExpects(array(
            'Resources/meta/LICENSE' => "/Copyright \(c\) ".date('Y')." Test/"
        ));

        $commandTester = $this->executeCommand();

        $this->assertRegExp("/DummyBundle/", $commandTester->getDisplay());
    }

    public function testAddLicenseResourceExists()
    {
        $this->setExpectedException('RuntimeException');
        $this->executeCommand(array('bundle' => 'DummyBundle2'));
    }

    protected function executeCommand($extra = array())
    {
        $params = array_merge(array(
            'command' => 'devkit:add-license',
            'bundle' => 'DummyBundle',
            '--author' => 'Test'
        ), $extra);

        $commandTester = $this->getCommandTester(new AddLicenseCommand());
        $commandTester->execute($params);

        return $commandTester;
    }
}
