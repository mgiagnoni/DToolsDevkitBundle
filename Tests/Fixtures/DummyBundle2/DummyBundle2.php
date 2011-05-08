<?php

namespace DTools\DevkitBundle\Tests\Fixtures\DummyBundle2;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Console\Application;

class DummyBundle2 extends Bundle
{
    public function getNamespace()
    {
        return 'DToolsTest\DummyBundle2';
    }
    public function registerCommands(Application $application)
    {
        
    }

}