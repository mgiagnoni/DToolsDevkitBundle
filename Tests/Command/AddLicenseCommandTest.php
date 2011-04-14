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
        $commandTester = $this->getCommandTester(new AddLicenseCommand());
        $params = array(
            'command' => 'devkit:add-license',
            'bundle' => 'DToolsTestDummyBundle'
        );
        $commandTester->execute($params);

        $this->assertFileExists($this->getDummyDir() . '/Resources/meta/LICENSE');
        $this->assertRegExp("/DToolsTestDummyBundle/", $commandTester->getDisplay());

        $this->setExpectedException('RuntimeException');
        $commandTester->execute($params);

    }
}
