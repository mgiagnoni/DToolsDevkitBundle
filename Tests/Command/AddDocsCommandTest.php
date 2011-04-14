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
        $commandTester = $this->getCommandTester(new AddDocsCommand());
        $params = array(
            'command' => 'devkit:add-docs',
            'bundle' => 'DToolsTestDummyBundle'
        );
        $commandTester->execute($params);

        $this->assertFileExists($this->getDummyDir() . '/Resources/doc/index.rst');
        $this->assertRegExp("/DToolsTestDummyBundle/", $commandTester->getDisplay());

        $this->setExpectedException('RuntimeException');
        $commandTester->execute($params);

    }
}
