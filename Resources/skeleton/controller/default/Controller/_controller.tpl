<?php

{% include 'header.twig' %}

namespace {{ namespace }}\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class {{ controller }}Controller extends Controller
{
    /*
     * {{ action }}Action
     */
    public function {{ action }}Action()
    {

        return $this->render('{{ bundle }}:{{ controller }}:{{ action }}.html.twig');
    }
}
