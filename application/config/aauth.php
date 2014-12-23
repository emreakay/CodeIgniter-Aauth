<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  |  Aauth Config
  | -------------------------------------------------------------------
  | A library Basic Authorization for CodeIgniter 2.x
 */


// Config variables

$config['aauth'] = array(
    'login_page' => '/login',
    // if user don't have permisssion to see the page he will be
    // redirected the page spesificed below
    'no_permission' => '/',
    //name of admin group
    'admin_group' => 'admin',
    //name of default group, the new user is added in it
    'default_group' => 'default',
    // public group , people who not logged in
    'public_group' => 'public',
    // The table which contains users
    'users' => 'aauth_users',
    // the group table
    'groups' => 'aauth_groups',
    // 
    'user_to_group' => 'aauth_user_to_group',
    // permitions
    'perms' => 'aauth_perms',
    // perms to group
    'perm_to_group' => 'aauth_perm_to_group',
    // perms to group
    'perm_to_user' => 'aauth_perm_to_user',
    // pm table
    'pms' => 'aauth_pms',
    // system variables
    'system_variables' => 'aauth_system_variables',
    // user variables
    'user_variables' => 'aauth_user_variables',

    // remember time
    'remember' => ' +3 days',

    // pasword maximum char long (min is 4)
    'max' => 13,

    // non alphanumeric characters that are allowed in a name
    'valid_chars' => array(' ', '\''),

    // ddos protection,
    //if it is true, the user will be banned temporary when he exceed the login 'try'
    'ddos_protection' => true,

    'recaptcha_active' => false, 
    'recaptcha_login_attempts' => 4,
    'recaptcha_siteKey' => '', 
    'recaptcha_secret' => '', 

    // login attempts time interval
    // default 20 times in one hour
    'max_login_attempt' => 10,

    // to register email verifitaion need? true / false
    'verification' => false,

    // system email.
    'email' => 'admin@admin.com',
    'name' => 'Emre Akay'
    
);


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */
