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

The `devkit:create-controller` command generates a controller class, based on a
customizable template, inside a bundle.

Examples:

    ./app/console devkit:create-controller AcmeMyBundle Default

Creates a controller class `DefaultController` with a sample method `indexAction`
in `AcmeMyBundle` using default template.

    ./app/console devkit:create-controller AcmeMyBundle Main --action=show --template=container_aware

Creates a controller class `MainController` with a sample method `showAction` in
`AcmeMyBundle` using `container_aware` template.

Sample templates are in `DTools/DevkitBundle/Resources/skeleton/controller` and
can be customized by copying them to `app/Resources/DtoolsDevkitBundle/skeleton/controller`

Generate CLI command classes
----------------------------

The `devkit:create-command` command generates a console command class, based on
a customizable template, inside a bundle.

Examples:

    ./app/console devkit:create-command AcmeMyBundle my:task

Creates a command class `MyTaskCommand` in `AcmeMyBundle` using default template.

The class is named after the command name, use the `--class` switch to set a
different name.

Sample templates are in `DTools/DevkitBundle/Resources/skeleton/command` and can
be customized by copying them to `app/Resources/DtoolsDevkitBundle/skeleton/command`

Project informations
--------------------

The command `devkit:project:info` displays basic informations about current
project and lists all configured Dbal connections. Each connection is probed and
errors reported. This command is currently incomplete: informations about
additional services will be displayed and more tests performed.

     ../app/console devkit:project:info

Contact me
==========

I'm @mgiagnoni on both GitHub and Twitter, my contact email is in the source
code. Bug reports and suggestions are welcome.

