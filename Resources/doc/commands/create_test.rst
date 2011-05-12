devkit:create-test
==================

The ``devkit:create-test`` command creates a **PhpUnit** test case class inside
a bundle.

Example
-------

::

    ./app/console devkit:create-test AcmeMyBundle "Model\Article"

The class name is relative to bundle namespace. Note that the name must be
double quoted because of backslash.

This command generates the following file::

    src
     Acme
      MyBundle
       Tests
        Model
         > ArticleTest.php

Test case class is named after the class you are writing the test for, use the
``--test-class`` option to specify a different name.

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/test``

#. **default**: generates a standard unit test (the test case class extends
   ``\PHPUnit_Framework_TestCase``).

#. **functional**: generates a functional test (the test case class extends
   ``Symfony\Bundle\FrameworkBundle\Test\WebTestCase``).

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/test``
