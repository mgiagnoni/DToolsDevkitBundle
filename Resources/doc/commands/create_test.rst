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

The ``default`` template generates a standard unit test (i.e the test case class
``Acme\MyBundle\Tests\Model\ArticleTest`` extends ``\PHPUnit_Framework_TestCase``),
if you want a functional test case, use ``functional`` template.