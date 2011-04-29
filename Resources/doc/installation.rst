Installation
============

Follow the usual procedure to install and enable a Symfony2 bundle.

#. To install bundle source code ``cd`` to your project directory and run::

        $ git clone git://github.com/mgiagnoni/DToolsDevkitBundle.git src/DTools/DevkitBundle

#. Add the DTools namespace to your autoloader::

        // app/autoload.php

        $loader->registerNamespaces(array(
            /* ... */
            'DTools' => __DIR__.'/../src',
        );

#. Add bundle to your application kernel::

        // app/AppKernel.php

        public function registerBundles()
        {
            return array(
                /* ... */
                new DTools\DevkitBundle\DToolsDevkitBundle(),
            );
        }
