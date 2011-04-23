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

Configure bundle
----------------

    # app/config.yml
    #...
    d_tools_devkit:
        author
            name:  Your Name
            email: youremail@yoursite.com

Both parameters are optional, if included they will be used by some commands (for
example to create a license file or a copyright header).

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

Generate sample documentation
-----------------------------

The `devkit:add-docs` command creates sample documentation inside the `Resources/doc/`
folder of a given bundle.

    ./app/console devkit:add-docs AcmeMyBundle

Add a LICENSE file
------------------

The `devkit:add-license` adds a LICENSE file inside the `Resources/doc/meta`
folder of a given bundle.

    ./app/console devkit:add-license AcmeMyBundle --author="Your Name"

If `--author` option is omitted, value of `d_tools_devkit.author.name` as set in
configuration is used.

The default template adds a MIT license, templates for other licenses can be
created in `app/Resources/DToolsDevkitBundle/skeleton/license`.

Initialize tests bootstrap
--------------------------

The `devkit:init-tests` creates a default PhpUnit configuration file and a
bootstrap script to run tests directly from bundle folder.

    ./app/console devkit:init-tests AcmeMyBundle

This command will generate two files: `Acme/MyBundle/phpunit.xml.dist` and
`Acme/MyBundle/Tests/bootstrap.php`.

Generate PhpUnit tests
----------------------

The `devkit:create-test` creates a PhpUnit test case class inside a bundle.

    ./app/console devkit:create-test AcmeMyBundle "Model\Article"

This command creates a test case class `Acme\MyBundle\Tests\Model\ArticleTest`.

The class name is relative to bundle namespace. Note that the name must be
double quoted because of backslash.

Test case class is named after the class you are writing the test for, use the
`--test-class` option to specify a different name.

The `default` template generates a standard unit test, if you want a functional
test case, use `functional` template.

Generate a sample Dependency Injection extension
------------------------------------------------

The command `devkit:create-config` creates the basic skeleton of a Dependency
Injection extension with a Configuration class for a given bundle. A
configuration file with some sample parameters is also generated.

    app/console devkit:create-config AcmeMyBundle parameters.xml

This command creates `AcmeMyExtension.php` and `Configuration.php` files in
`Acme/MyBundle/DependencyInjection` folder and `parameters.xml` file in
`Acme/MyBundle/Resources/config`.

Edit your application `config.yml` file to set values for sample parameters.

    # app/config.yml

    acme_my:
        param1: myvalue1
        param2:
            key1: myvalue2

Then you can access a parameter value through the Dependency Injection container,
for example in a controller action.

    // returns 'myvalue1'
    $param = $this->container->getParameter('acme_my.param1');

    // returns 'myvalue2'
    $param = $this->container->getParameter('acme_my.param2.key1');

    // no value set in app/config.yml so it returns default value 'value2-2'
    $param = $this->container->getParameter('acme_my.param2.key2');

Project informations
--------------------

The command `devkit:project:info` displays basic informations about current
project and lists all configured Dbal connections. Each connection is probed and
errors reported. This command is currently incomplete: informations about
additional services will be displayed and more tests performed.

     ./app/console devkit:project:info

Contact me
==========

I'm @mgiagnoni on both GitHub and Twitter, my contact email is in the source
code. Bug reports and suggestions are welcome.

