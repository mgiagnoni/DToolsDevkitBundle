devkit:create-fixture
=====================

The ``devkit:create-fixture`` command creates the skeleton of a fixture
loader class for a given entity inside a bundle. Currently only Doctrine
ORM is supported.

Examples
--------

::

    ./app/console devkit:create-fixture AcmeMyBundle User

This command generates the following file::

    src
     Acme
      MyBundle
       DataFixtures
        ORM
         > LoadUserData.php

With the ``--class`` option you can specify a custom name for the loader class::

    ./app/console devkit:create-fixture AcmeMyBundle User --class=MyLoaderClass

This command generates the following file::

    src
     Acme
      MyBundle
       DataFixtures
        ORM
         > MyLoaderClass.php

For help on how to use a fixture loader class, see
`How to create Fixtures in Symfony2 <http://symfony.com/doc/2.0/cookbook/doctrine/doctrine_fixtures.html>`_
in official *Symfony2 Cookbook*.

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/fixture``

#. **default**

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/fixture``
