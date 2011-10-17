<?php

{% include 'header.twig' %}

namespace {{ namespace }}\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use {{ namespace }}\Entity\{{ entity }};

class {{ class }} implements FixtureInterface
{
    public function load($manager)
    {
        $entry = new {{ entity }}();
        // $entry->setPropName('PropValue');
        $manager->persist($entry);

        // Create other entries here

        $manager->flush();
    }
}
