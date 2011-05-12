devkit:create-command
=====================

The ``devkit:create-command`` command generates a console command class, based
on a customizable template, inside a bundle.

Examples
--------

::

    ./app/console devkit:create-command AcmeMyBundle my:task

Creates a command class ``MyTaskCommand`` in ``AcmeMyBundle`` using default
template.

This command generates the following file::

    src
     Acme
      MyBundle
       Command
        > MyTaskCommand.php

The class is named after the command name, use the ``--class`` option to set a
different name::

    ./app/console devkit:create-command AcmeMyBundle my:task --class=MyClass

This command generates the following file::

    src
     Acme
      MyBundle
       Command
        > MyClassCommand.php

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/command``

#. **default**

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/command``
