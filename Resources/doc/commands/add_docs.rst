devkit:add-docs
===============

The ``devkit:add-docs`` command creates sample documentation for a bundle.

Example
-------

::

    ./app/console devkit:add-docs AcmeMyBundle

This command generates the following files::

    src
     Acme
      MyBundle
       Resources
        doc
         > index.rst

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/doc``

#. **default**: creates a sample documentation index file.

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/doc``
