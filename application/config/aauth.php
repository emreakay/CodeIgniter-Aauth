<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  |  Aauth Config
  | -------------------------------------------------------------------
  | A library Basic Authorization for CodeIgniter 2.x
 */


// Config variables

// if user don't have permisssion to see the page he will be
// redirected the page spesificed below
$config['aauth']['no_permission'] = '/';
//name of admin group
$config['aauth']['admin_group'] = 'admin';
//name of default group, the new user is added in it
$config['aauth']['default_group'] = 'default';
// public group , people who not logged in
$config['aauth']['public_group'] = 'public';
// The table which contains users
$config['aauth']['db_profile'] = 'default';

$config['aauth']['users'] = 'aauth_users';
// the group table
$config['aauth']['groups'] = 'aauth_groups';
// 
$config['aauth']['user_to_group'] = 'aauth_user_to_group';
// permitions
$config['aauth']['perms'] = 'aauth_perms';
// perms to group
$config['aauth']['perm_to_group'] = 'aauth_perm_to_group';
// perms to group
$config['aauth']['perm_to_user'] = 'aauth_perm_to_user';
// pm table
$config['aauth']['pms'] = 'aauth_pms';
// system variables
$config['aauth']['system_variables'] = 'aauth_system_variables';
// user variables
$config['aauth']['user_variables'] = 'aauth_user_variables';

// remember time
$config['aauth']['remember'] = ' +3 days';

// pasword maximum char long (min is 4)
$config['aauth']['max'] = 13;

// non alphanumeric characters that are allowed in a name
$config['aauth']['valid_chars'] = array(' ', '\'');

// ddos protection,
//if it is true, the user will be banned temporary when he exceed the login 'try'
$config['aauth']['ddos_protection'] = true;

$config['aauth']['recaptcha_active'] = false;
$config['aauth']['recaptcha_login_attempts'] = 4;
$config['aauth']['recaptcha_siteKey'] = '';
$config['aauth']['recaptcha_secret'] = '';

// login attempts time interval
// default 20 times in one hour
$config['aauth']['max_login_attempt'] = 10;

// to register email verifitaion need? true / false
$config['aauth']['verification'] = false;

$config['aauth']['login_with_name'] = false;

// system email.
$config['aauth']['email'] = 'admin@admin.com';
$config['aauth']['name'] = 'Emre Akay';

// Link for verification without site_url or base_url
$config['aauth']['verification_link'] = '/account/verification/';
// Link for reset_password without site_url or base_url
$config['aauth']['reset_password_link'] = '/account/reset_password/';

/* End of file aauth.php */
/* Location: ./application/config/aauth.php */
