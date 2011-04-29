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

``DefaultController`` class extends ``Symfony\Bundle\FrameworkBundle\Controller\Controller``
and contains a sample method ``indexAction``.

::

    ./app/console devkit:create-controller AcmeMyBundle Main --action=show --template=container_aware

This command generates the following file::

    src
     Acme
      MyBundle
       Controller
        > MainController.php

``MainController`` class extends ``Symfony\Component\DependencyInjection\ContainerAware``
and contains a sample method ``showAction``.

Sample templates are in ``DTools/DevkitBundle/Resources/skeleton/controller``
and can be customized by copying them to ``app/Resources/DToolsDevkitBundle/skeleton/controller``
