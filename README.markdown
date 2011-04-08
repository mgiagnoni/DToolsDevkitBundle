DToolsDevkitBundle
==================

This bundle provides a set of console commands to facilitate the development and
debugging of Symfony2 applications.

This bundle is under development and I plan to quickly add more commands and tools.

Installation
============

Follow the usual procedure to install and enable a Symfony2 bundle.

Install bundle source code
--------------------------

From your project directory run

    $ git clone git://github.com/mgiagnoni/DToolsDevkitBundle.git src/DTools/DevkitBundle

Add the DTools namespace to your autoloader
-------------------------------------------

    // app/autoload.php

    $loader->registerNamespaces(array(
        /* ... */
        'DTools' => __DIR__.'/../src',
    );

Add bundle to your application kernel
-------------------------------------

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            /* ... */
            new DTools\DevkitBundle\DToolsDevkitBundle(),
        );
    }

Commands
========

Generate controller classes
---------------------------

The `devkit:controller:create` command generates a controller class, based on a
customizable template, inside a bundle.

Examples:

    ./app/console devkit:controller:create AcmeMyBundle Default

Creates a controller class `DefaultController` with a sample method `indexAction`
in `AcmeMyBundle` using default template.

   ./app/console devkit:controller:create AcmeMyBundle Main --action=show --template=container_aware

Creates a controller class `MainController` with a sample method `showAction` in
`AcmeMyBundle` using `container_aware` template.

Sample templates are in `DTools/DevkitBundle/Resources/skeleton/controller` and
can be customized by copying them to `app/Resources/DtoolsDevkitBundle/skeleton/controller`

Project informations
--------------------

The command `devkit:project:info` dispalys basic informations about current
project and list all configured Dbal connections. Each connection is probed and
errors reported. This command is currently incomplete: informations about
additional services will be displayed and more tests performed.

     ../app/console devkit:project:info

Contact me
==========

I'm @mgiagnoni on both GitHub and Twitter, my contact email is in the source
code. Bug reports and suggestions are welcome.

