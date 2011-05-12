devkit:add-license
==================

The ``devkit:add-license`` command creates a LICENSE file for a bundle.

Example
-------

::

    ./app/console devkit:add-license AcmeMyBundle --author="Your Name"

This command generates the following file::

    src
     Acme
      MyBundle
       Resources
        meta
         > LICENSE

If ``--author`` option is omitted, the value of parameter ``d_tools_devkit.author.name``
as set in :doc:`bundle configuration<../configuration>` is used.

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/license``

#. **default**: creates a **MIT** license file.

Templates for other licenses can be created in ``app/Resources/DToolsDevkitBundle/skeleton/license``.