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
    // pm table
    'pms' => 'aauth_pms',


    // remember time
    'remember' => ' +3 days',

    // pasword maximum char long (min is 4)
    'max' => 13,

    // non alphanumeric characters that are allowed in a name
    'valid_chars' => array(' ', '\''),

    // it limits login attempts
    'dos_protection' => true,

    // login attempts time interval
    // default 10 times in one minute
    'try' => 10,

    // to register email verifitaion need? true / false
    'verification' => false,

    // system email.
    'email' => 'admin@admin.com',
    'name' => 'Emre Akay',
    'subject' => 'Account Vertification',
    'reset' => 'Pasword Reset',


    // error mesages
    // change to your language

    'email_taken' => 'E-mail is already taken',
    'email_invalid' => 'E-mail invalid',
    'pass_invalid' => 'Password invalid',
    'name_invalid' => 'Name invalid',
    'code' => 'Your code is: ',
    'link' => ' or you can copy and paste falowing link http://localhost/vert/',

    'remind' => 'If you want to reset your password click the copy and go the link below http://localhost/reset/',
    'new_password' => 'Your new password is : ',

    // no access
    'no_access' => 'You dont have access.',

    //
    'wrong' => 'E-mail or Password is wrong.',
    'exceeded' => 'Login try limit exceeded.',
    'no_user' => 'User not Exist',
    'not_verified' => 'Please verify your account.',
    'group_exist' => 'Group already exists',
    'self_pm' => 'It is not reasonable to send pm to yourself :)',
    'no_pm' => 'Pm not found',

    //info
    'already_member' => 'User already member of group',
    'already_perm' => 'Permission name already existed'
    
);


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */