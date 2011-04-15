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
        $commandTester = $this->getCommandTester(new InitTestsCommand());
        $params = array(
            'command' => 'devkit:init-tests',
            'bundle' => 'DToolsTestDummyBundle'
        );

        $commandTester->execute($params);

        $this->assertFileExists($this->getDummyDir() . '/phpunit.xml.dist');
        $bootstrapFile = $this->getDummyDir() . '/Tests/bootstrap.php';
        $this->assertFileExists($bootstrapFile);

        $content = file_get_contents($bootstrapFile);
        $this->assertRegExp('/DToolsTest\\\\{2}DummyBundle\\\\{2}/', $content);
    }
}
