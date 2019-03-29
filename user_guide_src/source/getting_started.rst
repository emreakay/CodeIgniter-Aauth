Getting Started
###############

.. contents::
    :local:
    :depth: 1

Load the Aauth Library
======================
Let's get started

First, we will load the Aauth Library into the system::

    $aauth = new \App\Libraries\Aauth();

That was easy!

Create Users
============
Now let's create two new users, Frodo and Legolas. ::

    $aauth->createUser('frodo@example.com','frodopass','Frodo Baggins');
    $aauth->createUser('legolas@example.com','legolaspass','Legolas');

We now we have two users.

Create Groups
=============
OK, now we can create two groups, hobbits and elves. ::

    $aauth->createGroup('hobbits');
    $aauth->createGroup('elves');

Now, let's create a user with power, Gandalf (for our example, let's assume he was given the id of 12). ::

    $aauth->createUser('gandalf@example.com', 'gandalfpass', 'Gandalf the Gray');

OK, now we have two groups and three users.


Create Perms
============
Let's create two permissions walk_unseen and immortality. ::

    $aauth->createPerm('walk_unseen');
    $aauth->createPerm('immortality');


Allow Perms to Groups
=====================
Ok, now let's give accesses to our groups. The Hobbits seem to have ability to walk unseen, so we will assign that privilage to them. The Elves have imortality, so we will assign that privilage to them. We will assign access with allow_group() function. ::

    $aauth->allowGroup('hobbits','walk_unseen');
    $aauth->allowGroup('elves','immortality');


    $aauth->allowGroup('hobbits','immortality');


Deny Perms to Groups
====================
Wait a minute! Hobbits should not have immortality. We need to fix this, we can use deny() to remove the permission. ::

    $aauth->deny('hobbits','immortality');


Allow Perms to Users
====================
Gandalf can also live forever. ::

    $aauth->allowUser(12,'immortality');

Check if Perms is Allowed to Groups
===================================
Ok now let's check if Hobbits have immortality. ::

  if($aauth->isGroupAllowed('hobbits','immortality')){
    echo "Hobbits are immortal";
  } else {
    echo "Hobbits are NOT immortal";
  }

Results::

  Hobbits are NOT immortal

Check if Perms is Allowed to Users
==================================
Does Gandalf have the ability to live forever? ::

    if($aauth->isAllowed(12,'immortality')){
      echo "Gandalf is immortal";
    } else {
      echo "Gandalf is NOT immortal";
    }

Results::

  Gandalf is immortal

Deny Perms to Users
===================
Frodo and Legolas are 100% not allowed to live forever so we deny immortality. ::

    $aauth->denyUser(3,'immortality');
    $aauth->denyUser(4,'immortality');


Delete Perms
============
Since we don't accually live in Middle Earth, we are not aware of actual immortality. Alas, we must delete the permission. ::

    $aauth->deletePerm('immortality');

It is gone.


Un-authenticated Users
======================

So, how about un-authenticated users? In Aauth they are part of the public group. Let's give them permissions to travel. We will assume we already have a permission set up named travel. ::

    $aauth->allowGroup('public','travel');


Admin Users
============

What about the Admin users? The Admin user and any member of the Admin group is a superuser who had access everthing, There is no need to grant additional permissions.


User Parameters/Variables
=========================

For each user, variables can be defined as individual key/value pairs. ::

    $aauth->setUserVar("key","value", $userID);

For example, if you want to store a user's phone number. ::

    $aauth->setUserVar("phone","1-507-555-1234", $userID);

To retreive value you will use get_user_var(): ::

    $aauth->getUserVar("key");

Aauth also permits you to define System Variables. These can be which can be accesed by all users in the system. ::

    $aauth->setSystemVar("key","value");
    $aauth->getSystemVar("key");


Banning users
=============

Frodo has broke the rules and will now need to be banned from the system. ::

    $aauth->banUser(3);



You have reached the end of the Quick Start Guide, but please take a look at the detailed Documentation Wiki for additional information.

Don't forget to keep and eye on Aauth, we are constantly improving the system. You can also contribute and help me out.
