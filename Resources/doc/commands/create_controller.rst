devkit:create-controller
========================

The ``devkit:create-controller`` command generates a controller class, based
on a customizable template, inside a bundle.

Examples
--------

::

    ./app/console devkit:create-controller AcmeMyBundle Default

This command generates the following file::

    src
     Acme
      MyBundle
       Controller
        > DefaultController.php

Generated file contains a ``DefaultController`` class with a sample method
``indexAction``.

::

    ./app/console devkit:create-controller AcmeMyBundle Main --action=show --template=container_aware

This command generates the following file::

    src
     Acme
      MyBundle
       Controller
        > MainController.php

Generated file contains a ``MainController`` class with a sample method
``showAction``.

Templates
---------

Templates used by this command are in ``DTools/DevkitBundle/Resources/skeleton/controller``

#. **default**: controller class extends ``Symfony\Bundle\FrameworkBundle\Controller\Controller``.
#. **container_aware**: controller class extends ``Symfony\Component\DependencyInjection\ContainerAware``

Templates can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/controller``
