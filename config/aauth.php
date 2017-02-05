<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config_aauth = array();


$config_aauth = array(
	'database' => array(
		'_profile'							=> 'default',
		'users'								=> 'aauth_users',
		'login_attempts'					=> 'aauth_login_attempts',
		'user_variables'					=> 'aauth_user_variables',
		'groups'							=> 'aauth_groups',
		'group_to_user'						=> 'aauth_user_to_group',
		'group_to_subgroup'					=> 'aauth_group_to_group',
		'permissions'						=> 'aauth_perms',
		'permission_to_user'				=> 'aauth_perm_to_user',
		'permission_to_group'				=> 'aauth_perm_to_group',
	),

	'group' => array(
		'admin'								=> 'admin',
		'default'							=> 'default',
		'public'							=> 'public',
	),

	'login' => array(
		'remember_time'						=> '3 days',
		'use_username'						=> FALSE,
	),

	'username' => array(
		'additional_valid_chars'			=> array(),
	),

	'password' => array(
		'min_length'						=> 5,
		'max_length'						=> 13,
		'hash_algo'							=> PASSWORD_DEFAULT,
		'hash_options'						=> array(),
	),

	'email' => array(
		'email'								=> 'admin@admin.com',
		'name'								=> 'Emre Akay',
	),

	'ddos_protection' => array(
		'enabled'							=> TRUE,
		'time_period'						=> '5 minutes',
		'max_attempts'						=> 10,
		'remove_successful_attempts'		=> TRUE,
	),

	'totp' => array(
		'enabled'							=> FALSE,
		'only_on_ip_change'					=> FALSE,
		'reset_over_reset_password'			=> FALSE,
		'two_step_login_active'				=> FALSE,
	),

	'recaptcha' => array(
		'enabled'							=> FALSE,
		'login_attempts'					=> 4,
		'site_key'							=> '',
		'secret'							=> '',
	),

	'redirect' => array(
		'no_permission'						=> FALSE,
	),

	'link' => array(
		'verification'						=> '/account/verification/',
		'reset_password'					=> '/account/reset_password/',
		'two_step_login'					=> '/account/twofactor_verification/',
	),
);



$config['aauth'] = $config_aauth;
