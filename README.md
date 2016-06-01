[![Stories in Ready](https://badge.waffle.io/emreakay/CodeIgniter-Aauth.png?label=ready&title=Ready)](https://waffle.io/emreakay/CodeIgniter-Aauth)
<p align="center">
<img src="https://cloud.githubusercontent.com/assets/2417212/8925689/add409ea-34be-11e5-8e50-845da8f5b1b0.png" height="320">
</p>

***
Aauth is a User Authorization Library for CodeIgniter 2.x and 3.x, which aims to make easy some essential jobs such as login, permissions and access operations. Despite its ease of use, it has also very advanced features like private messages, groupping, access management, and public access.

**This is Quick Start page. You can also take a look at the [detailed Documentation Wiki](https://github.com/emreakay/CodeIgniter-Aauth/wiki/_pages) to learn about other great Features**

### Features 
***
* User Management and Operations (login, logout, register, verification via e-mail, forgotten password, user ban, login DDoS protection)
* Group Operations (creating/deleting groups, membership management)
* Admin and Public Group support (Public permissions)
* Permission Management (creating/deleting permissions, allow/deny groups, public permissions, permission checking)
* Group Permissions
* User Permissions
* User and System Variables
* Login DDoS Protection
* Private Messages (between users)
* Error Messages and Validations
* Langugage and config file support
* Flexible implementation

### What is new in Version 2
***
* User Permissions
* User and System Variables
* Login DDoS Protection
* Updated functions (check documentation for details)
* Bugs fixes
* TOTP (Time-based One-time Password)

### Migration
***
* If you are currently using Version 1, take a look at the [v1 to v2 migration page.](https://github.com/emreakay/CodeIgniter-Aauth/wiki/1%29-Migration-from-V1).

### Quick Start 
***
Let's get started :)
First, we will load the Aauth Library into the system
```php
$this->load->library("Aauth");
```

That was easy!

Now let's create two new users, `Frodo` and `Legolas`.

```php
$this->aauth->create_user('frodo@example.com','frodopass','FrodoBaggins');
$this->aauth->create_user('legolas@example.com','legolaspass','Legolas');
```
   
We now we have two users.

OK, now we can create two groups, `hobbits` and `elves`.
```php
$this->aauth->create_group('hobbits');
$this->aauth->create_group('elves');
```  

Now, let's create a user with power, Gandalf (for our example, let's assume he was given the `id` of 12).
```php
$this->aauth->create_user('gandalf@example.com', 'gandalfpass', 'GandalfTheGray');
```  

OK, now we have two groups and three users.

Let's create two permissions `walk_unseen` and `immortality` 

```php
$this->aauth->create_perm('walk_unseen');
$this->aauth->create_perm('immortality');
```  

Ok, now let's give accesses to our groups.  The Hobbits seem to have ability to walk unseen, so we will assign that privilage to them. The Elves have imortality, so we will assign that privilage to them.
We will assign access with `allow_group()` function.

```php
$this->aauth->allow_group('hobbits','walk_unseen');
$this->aauth->allow_group('elves','immortality');
  
  
$this->aauth->allow_group('hobbits','immortality');
``` 

Wait a minute! Hobbits should not have `immortality`. We need to fix this, we can use `deny_group()` to remove the permission.

```php
$this->aauth->deny_group('hobbits','immortality');
``` 

Gandalf can also live forever.

```php
$this->aauth->allow_user(12,'immortality');
``` 

Ok now let's check if Hobbits have `immortality`.

```php
if($this->aauth->is_group_allowed('hobbits','immortality')){
	echo "Hobbits are immortal";
} else {
	echo "Hobbits are NOT immortal";
}
```
Results:
```
Hobbits are NOT immortal
```

Does Gandalf have the ability to live forever?

```php
if($this->aauth->is_allowed(12,'immortality')){
	echo "Gandalf is immortal";
} else {
	echo "Gandalf is NOT immortal";
}
``` 
Results:
```
Gandalf is immortal
```

Since we don't accually live in Middle Earth, we are not aware of actual immortality.  Alas, we must delete the permission.

```php
$this->aauth->delete_perm('immortality');
``` 
It is gone.

#### Un-authenticated Users

So, how about un-authenticated users?  In Aauth they are part of the `public` group. Let's give them permissions to `travel`.
We will assume we already have a permission set up named `travel`.

```php
$this->aauth->allow_group('public','travel');
``` 

#### Admin Users
What about the Admin users? The `Admin` user and any member of the `Admin` group is a superuser who had access everthing, There is no need to grant additional permissions.
  
#### User Parameters/Variables
For each user, variables can be defined as individual key/value pairs.

```php
$this->aauth->set_user_var("key","value");
``` 

For example, if you want to store a user's phone number.
```php
$this->aauth->set_user_var("phone","1-507-555-1234");
``` 

To retreive value you will use `get_user_var()`:
```php
$this->aauth->get_user_var("key");
``` 

Aauth also permits you to define System Variables.  These can be which can be accesed by all users in the system.
```php
$this->aauth->set_system_var("key","value");
$this->aauth->get_system_var("key");
``` 

#### Private Messages
OK, let's look at private messages. Frodo (`id` = 3) will send a PM to Legolas (`id` = 4);

```php
$this->aauth->send_pm(3,4,'New cloaks','These new cloaks are fantastic!')
``` 

#### Banning users

Frodo has broke the rules and will now need to be banned from the system.
```php
$this->aauth->ban_user(3);
``` 

You have reached the end of the Quick Start Guide, but please take a look at the [detailed Documentation Wiki](https://github.com/emreakay/CodeIgniter-Aauth/wiki/_pages) for additional information.


Don't forget to keep and eye on Aauth, we are constantly improving the system.
You can also contribute and help me out. :)
