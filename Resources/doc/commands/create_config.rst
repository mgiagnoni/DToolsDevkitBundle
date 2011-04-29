devkit:create-config
====================

The ``devkit:create-config`` command creates the basic skeleton of a
**Dependency Injection** extension with a **Configuration** class for a given
bundle. A configuration file with some sample parameters is also generated.

Example
-------

::

    app/console devkit:create-config AcmeMyBundle parameters.xml

This command generates the following files::

    src
     Acme
      MyBundle
       DependencyInjection
        > AcmeMyExtension.php
        > Configuration.php
       Resources
        config
         > parameters.xml

Edit your application ``config.yml`` file to set values for sample parameters::

    # app/config.yml

    acme_my:
        param1: myvalue1
        param2:
            key1: myvalue2

Then you can access a parameter value through the **Dependency Injection** container,
for example in a controller action::

    // returns 'myvalue1'
    $param = $this->container->getParameter('acme_my.param1');

    // returns 'myvalue2'
    $param = $this->container->getParameter('acme_my.param2.key1');

    // no value set in app/config.yml so it returns default value 'value2-2'
    $param = $this->container->getParameter('acme_my.param2.key2');