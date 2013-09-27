***
Aauth is a User Authorization Library for CodeIgniter 2.x, which aims to make easy some essential jobs such as login, permissions and access operations. Despite ease of use, it has also very advanced features like private messages, groupping, access management, public access etc..

After Quick Start, Take a look [detailed Documentation from wiki](https://github.com/emreakay/CodeIgniter-Aauth/wiki/_pages)  

## Quick Start 
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
$this->aauth->create_user('commons');
```  

ok now we have two groups.

Lets create a permissions 'incrase_tax' and 'change_government' 

```php
$this->aauth->create_perm('increase_tax');
$this->aauth->create_perm('change_government');
```  

Ok, now lets give accesses. logically 'governors' will have 'increase_tax' permission and 'commons' will have 'change_government' access.  
ok lets give proper access with _alow()_ function

```php
$this->aauth->allow('governors','increase_tax');
$this->aauth->allow('commons','change_government');
  
  
$this->aauth->allow('commons','increase_tax');
``` 

Ops wait a minute.  commons cannot 'increase_tax'. we need to fix it, we will use deny() to take back permission.

```php
$this->aauth->deny('commons','increase_tax');
``` 


Ok now lets check if commons can 'increase_tax'

```php
if($this->aauth->is_allowed('commons','increase_tax')){
    // i dont think so
} else {
   // do sth in the middle
}
``` 

i think 'increse_tax' must have never been created. delete it

```php
$this->aauth->delete_perm('increase_tax');
``` 
now better.  
  
So what about public people? (public means not logged users). can public people travel? Lets assume we have permissions namely 'travel' , of course.


> $this->aauth->allow('public','travel')

  
So Admin? what can he do? He can access everthing, You dont need to give permiision ( allow() ) him, he already has.  
  
  
ok lets lokk at private messages. John (his id=3) will send pm to Ali(id=4)

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
