Configuration
=============

::

    # app/config.yml
    #...
    d_tools_devkit:
        author
            name:  Your Name
            email: youremail@yoursite.com
        alias:
            my: AcmeMyBundle
            hello: FooAppsHelloBundle

Author informations
-------------------

Both ``email`` and ``name`` parameters are optional, if included they will be used
by some commands (for example to create a license file or a copyright header).

Bundle alias
------------

As almost every command requires a bundle name as argument and bundle names
can be quite long, you will be able to save some keystrokes by configuring
an **alias** for your most frequently used bundles.

Once you have set ``my`` as alias of ``AcmeMyBundle`` (see the configuration
example above), the following two commands become equivalent::

    ./app/console devkit:add-docs AcmeMyBundle

    ./app/console devkit:add-docs my
