<?php

{% include 'header.twig' %}

namespace {{ namespace }};

use {{ use }};

class {{ test_class }} extends \PHPUnit_Framework_TestCase
{
    public function {{ test_method }}()
    {
        $test = new {{ class }}();

        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
