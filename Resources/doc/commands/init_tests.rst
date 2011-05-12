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

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/tests``

#. **default**

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/tests``
