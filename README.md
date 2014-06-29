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
    # he name of the id attribute of your users table
    followable_id_attribute_name: "id"
    # The name of your users table
    users_table_name: "users"
    # The name of the joint table used for the ManyToMany relationships
    joint_table_name: "follows"
    # The name of the column that refers to the follower inside your joint table
    joint_table_follower_column_name: "follower_id"
    # The name of the column that refers to the followee inside your joint table
    joint_table_followee_column_name: "followee_id"
```

3) Import the joint table definition
-------------------------------------
This bundle comes with a command `paco:followable:create-table` you must use to autamatically setup the joint table deinition inside your database.
Using the Symfony2 console,  enter this command:
```bash
paco:followable:create-table
```

### That was it!

4) Using the Followable behaviour
---------------------------------
This bundle setup a dynamic Doctrine ManyToMany relationship between your user class and itself.

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

Your user class have access to theses following attributes :
- `followers` : this collection store people that followed you
- `followees` : this collection store people you followed
and theses following methods :
- `getFollowers()` : return all your followers
- `setFollowers(ArrayCollection $followers)`
- `getFollowees()` : returns all people you followed 
- `setFollowees(ArrayCollection $followees)`
- `addFollower(FollowableBehaviorInterface $follower)` : add someone as your follower
- `addFollowee(FollowableBehaviorInterface $followee)` : follow someone
- `removeFollower(FollowableBehaviorInterface $follower)` : remove someone as your follower. It does not delete the user.
- `removeFollowee(FollowableBehaviorInterface $followee)` : unfollow someone
By default when you delete a user, all relationships (not the related users) are also deleted.  

