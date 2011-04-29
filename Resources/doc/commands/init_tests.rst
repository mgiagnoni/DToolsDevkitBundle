devkit:init-tests
=================

The ``devkit:init-tests`` command creates a default **PhpUnit** configuration
file and a bootstrap script to run tests directly from a bundle folder.

Example
-------

::

    ./app/console devkit:init-tests AcmeMyBundle

This command generates the following files::

    src
     Acme
      MyBundle
       Tests
        > bootstrap.php
      > phpunit.xml.dist