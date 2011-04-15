<?php

require_once $_SERVER['SYMFONY'].'/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace('Symfony', $_SERVER['SYMFONY']);
$loader->register();

spl_autoload_register(function($class)
{
    if (0 === strpos($class, '{{ namespace }}\\')) {
        $path = implode('/', array_slice(explode('\\', $class), {{ ct_namespace }})).'.php';
        require_once __DIR__.'/../'.$path;
        return true;
    }
});