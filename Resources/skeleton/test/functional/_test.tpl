<?php

{% include 'header.twig' %}

namespace {{ namespace }};

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class {{ test_class }} extends WebTestCase
{
    public function {{ test_method }}()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');

        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
