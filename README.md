***
Aauth is a User Authorization Library for CodeIgniter 2.x, which aims to make easy some essential jobs such as login, permissions and access operations. Despite ease of use, it has also very advanced features like private messages, groupping, access management, public access etc..

After Quick Start, Take a look [detailed Documentation from wiki](https://github.com/emreakay/CodeIgniter-Aauth/wiki/_pages)  

### Features 
***
* User Management and Operations (login, logout, register, vertification via e-mail, forgoten password, ban management, login ddos protection)
* Group Operations (Creaing, deleting groups, membership management)
* Admin and Public Group support (Public permissions)
Permission Management (creating,deleting permissons, allow, deny groups, public permissions, permission checking)
* Group Permissions 
* User Permissions (new)
* User and System Variables (new)
* Login Ddos Protection (new)
* Private Messages (pm between users)
* Error Mesages and Validations
* Langugage and config file support
* Flexible

### What is new in Version 2
***
* User Permissions
* User and System Variables
* Login Ddos Protection
* Some functions has changed
* Some bugs fixed

### Migration
***
* if you have been using Version 1 before, take a look at Migration Page from here.

### Quick Start 
***
Let's start :)  
Firstly we will load Aauth Library to system
```php
$this->load->library("Aauth");
```
  
thats OK.  

Now we will create 2 new users, Ali and John  

```php
$this->aauth->create_user('ali@ali.com','alispass','Ali Akay');
$this->aauth->create_user('john@john.com','johnspass','John Button');
```
   
thats it. now we have two users.

Lets Create two group governors and commons :)
```php
$this->aauth->create_group('governors');
$this->aauth->create_group('commons');
```  

Then, Lets Create a User with power whic is Obama (having id=12)
```php
$this->aauth->create_user('obama@usa.gov', 'pass-cia-fbi', 'Barrack Obama');
```  

ok now we have two groups and one user.

Lets create a permissions 'incrase_tax' and 'change_government' 

```php
$this->aauth->create_perm('increase_tax');
$this->aauth->create_perm('change_government');
```  

Ok, now lets give accesses. logically 'governors' will have 'increase_tax' permission and 'commons' will have 'change_government' access.  
ok lets give proper access with _alow_group()_ function

```php
$this->aauth->allow_group('governors','increase_tax');
$this->aauth->allow_group('commons','change_government');
  
  
$this->aauth->allow_group('commons','increase_tax');
``` 

Ops wait a minute.  commons cannot 'increase_tax'. we need to fix it, we will use deny() to take back permission.

```php
$this->aauth->deny('commons','increase_tax');
``` 

Obama also can increse tax ha?

```php
$this->aauth->allow_user(12,'increase_tax');
``` 


Ok now lets check if commons can 'increase_tax'

```php
if($this->aauth->is_group_allowed('commons','increase_tax')){
    // i dont think so
} else {
   // do sth in the middle
}
``` 

Can Obama increase_tax ? Let's check it.

```php
if($this->aauth->is_allowed(15,'increase_tax')){
    // i guess so
} else {
   // piece of code
}
``` 


i think 'increse_tax' must have never been created. just delete it

```php
$this->aauth->delete_perm('increase_tax');
``` 
now better.  
  
So what about public people? (public means not logged users). Can public people travel? Lets assume we have permissions namely 'travel' , of course.

```php
$this->aauth->allow_group('public','travel');
``` 
  
So Admin? what can he do? He can access everthing, You dont need to give permiision ( using allow_group() or allow_user() ) him, he already has.  
  
What about User Variables?
for every individual user, variables can be defined as key-value.

this is a simple example to set a variable.
```php
$this->aauth->set_user_var("key","value");
``` 

For example if you want to keep users phones
```php
$this->aauth->set_user_var("phone","0216 313 23 33");
``` 

to get the variable
```php
$this->aauth->set_user_var("key");
``` 

Aauth also permits you to define System Variables which can be accesed by every user in the system.
```php
$this->aauth->set_system_var("key","Value");
$this->aauth->set_system_var("key");
``` 

ok lets look at private messages. John (his id=3) will send pm to Ali(id=4)

```php
$this->aauth->send_pm(3,4,'Hi bro. i need you',' can you gimme your credit card?')
``` 
  
sorry John you will be banned :(

```php
$this->aauth->ban_user(3);
``` 
 
Quick Start is done but thats not the end  
Take a look [detailed Documentation from wiki](https://github.com/emreakay/CodeIgniter-Aauth/wiki/_pages)   

Dont forget to watch Aauth.  
You can also contribute and help me :)
