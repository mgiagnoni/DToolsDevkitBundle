<?php

{% include 'header.twig' %}

namespace {{ namespace }}\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

class {{ controller }}Controller extends ContainerAware
{
    /**
     * {{ action }}Action
     */
    public function {{ action }}Action()
    {

        return $this->container->get('templating')->renderResponse('{{ bundle }}:{{ controller }}:{{ action }}.html.twig');
    }
}
