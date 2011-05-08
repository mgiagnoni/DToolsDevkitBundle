<?php

namespace DTools\DevkitBundle\Tests\Fixtures\DummyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DummyBundle extends Bundle
{
    public function getNamespace()
    {
        return 'DToolsTest\DummyBundle';
    }

}