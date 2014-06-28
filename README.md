PacoFollowabeBundle
========================
This bundle defines a Behavior for your User class to your users instances to follow each others just like inside a social network. 

This document contains information on how to download, install, and start
using the PacoFollowableBundle inside your Symfony project.

1) Installing the Bundle
----------------------------------

As Symfony uses [Composer](http://getcomposer.org/) to manage its dependencies, the recommended way to install this bundle is to use it.

### Install PacoFollowableBundle


If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `require` command to add the bundle to your project dependencies:

    php composer.phar require papepapes/pacofollowablebundle "dev-master"

### Enable the bundle
Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Paco\Bundle\PacoFollowableBundle(),
    );
}
```


2) Configuration
-------------------------------------

Before using the bundle, make sure that you add the proper configuration to  your `app/config/config.yml`:

```yaml
paco_followable:
    #The origin to allow, Set to '*' for a public acccess your service endpoints
    user_class_name: "*"
    # Coma separated list of HTTP allowed methods
    allowed_methods: "*"
    # Coma separated list of HTTP allowed headers
    allowed_headers: "*"
    # Number of seconds used to cache CORS preflighr OPTIONS requests
    max_age: ~
    # Coma separated list of additional custom headers you want the client browser to have access to
    exposed_headers: ~
```

### That was it!

3) Using the Followable behaviour
---------------------------------
This bundle setup a dynamic Doctrine ManyToMany relationship between your user class and itself using an [event susbscriber on loadClassMetaData]().

It comes with:
- a trait that contains properties followers, followees and their getters/setters
- an interface to ease the usage of this behaviour to any type that implements that interface

Fisrt implements that interface and use also the trait inside your user class:
``` php
<?php
// 
class User implements FollowableBehaviourInterface
{
    use FollowableBehaviourTrait;
    ....
}
```



Enjoy!

[1]:  http://symfony.com/doc/2.4/book/installation.html
[2]:  http://getcomposer.org/
[3]:  http://symfony.com/download
[4]:  http://symfony.com/doc/2.4/quick_tour/the_big_picture.html
[5]:  http://symfony.com/doc/2.4/index.html
[6]:  http://symfony.com/doc/2.4/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/2.4/book/doctrine.html
[8]:  http://symfony.com/doc/2.4/book/templating.html
[9]:  http://symfony.com/doc/2.4/book/security.html
[10]: http://symfony.com/doc/2.4/cookbook/email.html
[11]: http://symfony.com/doc/2.4/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/2.4/cookbook/assetic/asset_management.html
[13]: http://symfony.com/doc/2.4/bundles/SensioGeneratorBundle/index.html
