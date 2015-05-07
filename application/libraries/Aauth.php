<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Aauth is a User Authorization Library for CodeIgniter 2.x, which aims to make 
 * easy some essential jobs such as login, permissions and access operations. 
 * Despite ease of use, it has also very advanced features like private messages, 
 * groupping, access management, public access etc..
 *
 * @author		Emre Akay <emreakayfb@hotmail.com>
 * @contributor Jacob Tomlinson
 * @contributor Tim Swagger (Renowne, LLC) <tim@renowne.com>
 *
 * @copyright 2014 Emre Akay
 *
 * @version 2.0
 *
 * @license LGPL
 * @license http://opensource.org/licenses/LGPL-3.0 Lesser GNU Public License
 *
 * The latest version of Aauth can be obtained from:
 * https://github.com/emreakay/CodeIgniter-Aauth
 *
 * @todo separate (on some level) the unvalidated users from the "banned" users
 * @todo remove requirement for unique name/username (or default it to use email address, perhaps via config file).	 OR remove altogether as login uses email address
 * @todo add configuration to not use cookies if sessions are enabled.
 */
class Aauth {

	/**
	 * The CodeIgniter object variable
	 * @access public
	 * @var object
	 */
	public $CI;

	/**
	 * Variable for loading the config array into
	 * @access public
	 * @var array
	 */
	public $config_vars;

	/**
	 * Array to store error messages
	 * @access public
	 * @var array
	 */
	public $errors = array();

	/**
	 * Array to store info messages
	 * @access public
	 * @var array
	 */
	public $infos = array();
	
	/**
	 * Local temporary storage for current flash errors
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 * @access public
	 * var array
	 */
	public $flash_errors = array();

	/**
	 * Local temporary storage for current flash infos
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 * @access public
	 * var array
	 */
	public $flash_infos = array();


	########################
	# Base Functions
	########################

	/**
	 * Constructor
	 */
	public function __construct() {

		// get main CI object
		$this->CI = & get_instance();

		// Dependancies
		if(CI_VERSION >= 2.2){
			$this->CI->load->library('driver');
		}
		$this->CI->load->library('session');
		$this->CI->load->library('email');
		$this->CI->load->database();
		$this->CI->load->helper('url');
		$this->CI->load->helper('string');
		$this->CI->load->helper('email');
		$this->CI->load->helper('language');
		$this->CI->load->helper('recaptchalib');
		$this->CI->lang->load('aauth');


		// config/aauth.php
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		
		// load error and info messages from flashdata (but don't store back in flashdata)
		$this->errors = $this->CI->session->flashdata('errors');
		$this->infos = $this->CI->session->flashdata('infos');
	}


	########################
	# Login Functions
	########################

	//tested
	/**
	 * Login user
	 * Check provided details against the database. Add items to error array on fail, create session if success
	 * @param string $email
	 * @param string $pass
	 * @param bool $remember
	 * @return bool Indicates successful login.
	 */
	public function login($email, $pass, $remember = FALSE) {

		// Remove cookies first
		$cookie = array(
			'name'	 => 'user',
			'value'	 => '',
			'expire' => time()-3600,
			'path'	 => '/',
		);

		$this->CI->input->set_cookie($cookie);

 
		/*
		*
		* User Verification
		*
		* Removed or !ctype_alnum($pass) from the IF statement
		* It was causing issues with special characters in passwords
		* and returning FALSE even if the password matches.
		*/
		if( !valid_email($email) OR strlen($pass) < 5 OR strlen($pass) > $this->config_vars['max'] )
		{
			$this->error($this->CI->lang->line('aauth_error_login_failed'));
			return FALSE;
		}


		$query = null;
		$query = $this->CI->db->where('email', $email);
		$query = $this->CI->db->get($this->config_vars['users']);
		$row = $query->row();

		// only email found and login attempts exceeded
		if ($query->num_rows() > 0 && $this->config_vars['ddos_protection'] && ! $this->update_login_attempts($row->email)) {

			$this->error($this->CI->lang->line('aauth_error_login_attempts_exceeded'));
			return FALSE;
		}

		//recaptcha login_attempts check
		$query = null;
		$query = $this->CI->db->where('email', $email);
		$query = $this->CI->db->get($this->config_vars['users']);
		$row = $query->row();
		if($query->num_rows() > 0 && $this->config_vars['ddos_protection'] && $this->config_vars['recaptcha_active'] && $row->login_attempts >= $this->config_vars['recaptcha_login_attempts']){
			$reCAPTCHA_cookie = array(
				'name'	 => 'reCAPTCHA',
				'value'	 => 'true',
				'expire' => time()+7200,
				'path'	 => '/',
			);
			$this->CI->input->set_cookie($reCAPTCHA_cookie);
		}

		// if user is not verified
		$query = null;
		$query = $this->CI->db->where('email', $email);
		$query = $this->CI->db->where('banned', 1);
		$query = $this->CI->db->where('verification_code !=', '');
		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() > 0) {
			$this->error($this->CI->lang->line('aauth_error_account_not_verified'));
			return FALSE;
		}

		// to find user id, create sessions and cookies
		$query = $this->CI->db->where('email', $email);
		$query = $this->CI->db->get($this->config_vars['users']);
		
		if($query->num_rows() == 0){
			$this->error($this->CI->lang->line('aauth_error_login_failed'));
			return FALSE;
		}
		
		$user_id = $query->row()->id;
		
		$query = null;
		$query = $this->CI->db->where('email', $email);

		// Database stores pasword hashed password
		$query = $this->CI->db->where('pass', $this->hash_password($pass, $user_id));
		$query = $this->CI->db->where('banned', 0);

		$query = $this->CI->db->get($this->config_vars['users']);

		$row = $query->row();
		if($this->CI->input->cookie('reCAPTCHA', TRUE) == 'true'){
			$reCaptcha = new ReCaptcha( $this->config_vars['recaptcha_secret']);
			$resp = $reCaptcha->verifyResponse( $this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response") );

			if(!$resp->success){
				$this->error($this->CI->lang->line('aauth_error_recaptcha_not_correct'));
				return FALSE;
			}
		}
	 
		// if email and pass matches and not banned
		if ( $query->num_rows() > 0 ) {

			// If email and pass matches
			// create session
			$data = array(
				'id' => $row->id,
				'name' => $row->name,
				'email' => $row->email,
				'loggedin' => TRUE
			);

			$this->CI->session->set_userdata($data);

			// if remember selected
			if ( $remember ){
				$expire = $this->config_vars['remember'];
				$today = date("Y-m-d");
				$remember_date = date("Y-m-d", strtotime($today . $expire) );
				$random_string = random_string('alnum', 16);
				$this->update_remember($row->id, $random_string, $remember_date );

				$cookie = array(
					'name'	 => 'user',
					'value'	 => $row->id . "-" . $random_string,
					'expire' => time() + 99*999*999,
					'path'	 => '/',
				);

				$this->CI->input->set_cookie($cookie);
			}

			$reCAPTCHA_cookie = array(
				'name'	 => 'reCAPTCHA',
				'value'	 => 'false',
				'expire' => time()-3600,
				'path'	 => '/',
			);
			$this->CI->input->set_cookie($reCAPTCHA_cookie);

			// update last login
			$this->update_last_login($row->id);
			$this->update_activity();
			$this->reset_login_attempts($row->id);
			
			return TRUE;
		}
		// if not matches
		else {

			$this->error($this->CI->lang->line('aauth_error_login_failed'));
			return FALSE;
		}
	}

	//tested
	/**
	 * Check user login
	 * Checks if user logged in, also checks remember.
	 * @return bool
	 */
	public function is_loggedin() {

		if ( $this->CI->session->userdata('loggedin') )
		{ return TRUE; }

		// cookie control
		else {
			if( ! $this->CI->input->cookie('user', TRUE) ){
				return FALSE;
			} else {
				$cookie = explode('-', $this->CI->input->cookie('user', TRUE));
				if(!is_numeric( $cookie[0] ) OR strlen($cookie[1]) < 13 ){return FALSE;}
				else{
					$query = $this->CI->db->where('id', $cookie[0]);
					$query = $this->CI->db->where('remember_exp', $cookie[1]);
					$query = $this->CI->db->get($this->config_vars['users']);

					$row = $query->row();

					if ($query->num_rows() < 1) {
						$this->update_remember($cookie[0]);
						return FALSE;
					}else{

						if(strtotime($row->remember_time) > strtotime("now") ){
							$this->login_fast($cookie[0]);
							return TRUE;
						}
						// if time is expired
						else {
							return FALSE;
						}
					}
				}

			}
		}

		return FALSE;
	}

	/**
	 * Controls if a logged or public user has permission
	 * 
	 * If user does not have permission to access page, it stops script and gives
	 * error message, unless 'no_permission' value is set in config.  If 'no_permission' is
	 * set in config it redirects user to the set url and passes the 'no_access' error message.
	 * It also updates last activity every time function called.
	 *
	 * @param bool $perm_par If not given just control user logged in or not
	 */
	public function control( $perm_par = FALSE ){

		$perm_id = $this->get_perm_id($perm_par);
		$this->update_activity();

		// if user or user's group not allowed
		if ( ! $this->is_allowed($perm_id) OR ! $this->is_group_allowed($perm_id) ){
			if( $this->config_vars['no_permission'] ) {
				$this->error($this->CI->lang->line('aauth_error_no_access'));
				redirect($this->config_vars['no_permission']);
			}
			else {
				echo $this->CI->lang->line('aauth_error_no_access');
				die();
			}
		}
	}

	//tested
	/**
	 * Logout user
	 * Destroys the CodeIgniter session and remove cookies to log out user.
	 * @return bool If session destroy successful
	 */
	public function logout() {

		$cookie = array(
			'name'	 => 'user',
			'value'	 => '',
			'expire' => time()-3600,
			'path'	 => '/',
		);

		$this->CI->input->set_cookie($cookie);

		return $this->CI->session->sess_destroy();
	}

	//tested
	/**
	 * Fast login
	 * Login with just a user id
	 * @param int $user_id User id to log in
	 * @return bool TRUE if login successful.
	 */
	public function login_fast($user_id){

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->where('banned', 0);
		$query = $this->CI->db->get($this->config_vars['users']);

		$row = $query->row();

		if ($query->num_rows() > 0) {

			// if id matches
			// create session
			$data = array(
				'id' => $row->id,
				'name' => $row->name,
				'email' => $row->email,
				'loggedin' => TRUE
			);

			$this->CI->session->set_userdata($data);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Reset last login attempts
	 * Sets a users 'last login attempts' to null
	 * @param int $user_id User id to reset
	 * @return bool Reset fails/succeeds
	 */
	public	function reset_login_attempts($user_id) {

		$data['login_attempts'] = null;
		$this->CI->db->where('id', $user_id);
		return $this->CI->db->update($this->config_vars['users'], $data);
	}

	/**
	 * Remind password
	 * Emails user with link to reset password
	 * @param string $email Email for account to remind
	 */
	public function remind_password($email){

		$query = $this->CI->db->where( 'email', $email );
		$query = $this->CI->db->get( $this->config_vars['users'] );

		if ($query->num_rows() > 0){
			$row = $query->row();

			$ver_code = random_string('alnum', 16);

			$data['verification_code'] = $ver_code;

			$this->CI->db->where('email', $email);
			$this->CI->db->update($this->config_vars['users'], $data);

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($row->email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_reset_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_reset_link') . $row->id . '/' . $ver_code );
			$this->CI->email->send();
		}
	}

	/**
	 * Reset password
	 * Generate new password and email it to the user
	 * @param int $user_id User id to reset password for
	 * @param string $ver_code Verification code for account
	 * @return bool Password reset fails/succeeds
	 */
	public function reset_password($user_id, $ver_code){

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->where('verification_code', $ver_code);
		$query = $this->CI->db->get( $this->config_vars['users'] );

		$pass = random_string('alnum',8);

		if( $query->num_rows() > 0 ){

			$data =	 array(
				'verification_code' => '',
				'pass' => $this->hash_password($pass, $user_id)
			);

			$row = $query->row();
			$email = $row->email;

			$this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'] , $data);

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_reset_success_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_reset_success_new_password') . $pass);
			$this->CI->email->send();

			return TRUE;
		}

		return FALSE;
	}

	//tested
	/**
	 * Update last login
	 * Update user's last login date
	 * @param int|bool $user_id User id to update or FALSE for current user
	 * @return bool Update fails/succeeds
	 */
	public function update_last_login($user_id = FALSE) {

		if ($user_id == FALSE)
			$user_id = $this->CI->session->userdata('id');

		$data['last_login'] = date("Y-m-d H:i:s");
		$data['ip_address'] = $this->CI->input->ip_address();

		$this->CI->db->where('id', $user_id);
		return $this->CI->db->update($this->config_vars['users'], $data);
	}


	//tested
	/**
	 * Update login attempt and if exceeds return FALSE
	 * Update user's last login attemp date and number date
	 * @param string $email User email
	 * @return bool
	 */
	public function update_login_attempts($email) {

		$user_id = $this->get_user_id($email);

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->get( $this->config_vars['users'] );
		$row = $query->row();


		$data = array();

		if ( strtotime($row->last_login_attempt) == strtotime(date("Y-m-d H:0:0"))) {
			$data['login_attempts'] = $row->login_attempts + 1;

			$query = $this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'], $data);

		} else {

			$data['last_login_attempt'] = date("Y-m-d H:0:0");
			$data['login_attempts'] = 1;

			$this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'], $data);

		}

		if ( $data['login_attempts'] > $this->config_vars['max_login_attempt'] ) {
			return FALSE;
		} else {
			return TRUE;
		}

	}

	/**
	 * Update remember
	 * Update amount of time a user is remembered for
	 * @param int $user_id User id to update 
	 * @param int $expression
	 * @param int $expire 
	 * @return bool Update fails/succeeds
	 */
	public function update_remember($user_id, $expression=null, $expire=null) {

		$data['remember_time'] = $expire;
		$data['remember_exp'] = $expression;

		$query = $this->CI->db->where('id',$user_id);
		return $this->CI->db->update($this->config_vars['users'], $data);
	}


	########################
	# User Functions
	########################

	//tested
	/**
	 * Create user
	 * Creates a new user
	 * @param string $email User's email address
	 * @param string $pass User's password
	 * @param string $name User's name
	 * @return int|bool False if create fails or returns user id if successful
	 */
	public function create_user($email, $pass, $name) {

		$valid = TRUE;

		// if email is already exist
		if ($this->user_exsist_by_email($email)) {
			$this->error($this->CI->lang->line('aauth_error_email_exists'));
			$valid = FALSE;
		}
		if ($this->user_exsist_by_name($name)) {
			$this->error($this->CI->lang->line('aauth_error_username_exists'));
			$valid = FALSE;
		}

		if ( ! valid_email($email)){
			$this->error($this->CI->lang->line('aauth_error_email_invalid'));
			$valid = FALSE;
		}
		if ( strlen($pass) < 5 OR strlen($pass) > $this->config_vars['max'] ){
			$this->error($this->CI->lang->line('aauth_error_password_invalid'));
			$valid = FALSE;
		}
		if ($name !='' && !ctype_alnum(str_replace($this->config_vars['valid_chars'], '', $name))){
			$this->error($this->CI->lang->line('aauth_error_username_invalid'));
			$valid = FALSE;
		}
		if (empty($name)){
			$this->error($this->CI->lang->line('aauth_error_username_required'));
			$valid = FALSE;
		}

		if (!$valid) {
			return FALSE; }

		$data = array(
			'email' => $email,
			'pass' => $this->hash_password($pass, 0), // Password cannot be blank but user_id required for salt, setting bad password for now
			'name' => $name,
		);

		if ( $this->CI->db->insert($this->config_vars['users'], $data )){

			$user_id = $this->CI->db->insert_id();

			// set default group
			$this->add_member($user_id, $this->config_vars['default_group']);

			// if verification activated
			if($this->config_vars['verification']){
				$data = null;
				$data['banned'] = 1;

				$this->CI->db->where('id', $user_id);
				$this->CI->db->update($this->config_vars['users'], $data);

				// sends verifition ( !! e-mail settings must be set)
				$this->send_verification($user_id);
			}

			// Update to correct salted password
			$data = null;
			$data['pass'] = $this->hash_password($pass, $user_id);
			$this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'], $data);

			return $user_id;

		} else {
			return FALSE;
		}
	}

	//tested
	/**
	 * Update user
	 * Updates existing user details
	 * @param int $user_id User id to update
	 * @param string|bool $email User's email address, or FALSE if not to be updated
	 * @param string|bool $pass User's password, or FALSE if not to be updated
	 * @param string|bool $name User's name, or FALSE if not to be updated
	 * @return bool Update fails/succeeds
	 */
	public function update_user($user_id, $email = FALSE, $pass = FALSE, $name = FALSE) {

		$data = array();

		if ($email != FALSE) {
			$data['email'] = $email;
		}

		if ($pass != FALSE) {
			$data['pass'] = $this->hash_password($pass, $user_id);
		}

		if ($name != FALSE) {
			$data['name'] = $name;
		}

		$this->CI->db->where('id', $user_id);
		return $this->CI->db->update($this->config_vars['users'], $data);
	}

	//tested
	/**
	 * List users
	 * Return users as an object array
	 * @param bool|int $group_par Specify group id to list group or FALSE for all users
	 * @param string $limit Limit of users to be returned
	 * @param bool $offset Offset for limited number of users
	 * @param bool $include_banneds Include banned users
	 * @return array Array of users
	 */
	public function list_users($group_par = FALSE, $limit = FALSE, $offset = FALSE, $include_banneds = FALSE) {

		// if group_par is given
		if ($group_par != FALSE) {

			$group_par = $this->get_group_id($group_par);
			$this->CI->db->select('*')
				->from($this->config_vars['users'])
				->join($this->config_vars['user_to_group'], $this->config_vars['users'] . ".id = " . $this->config_vars['user_to_group'] . ".user_id")
				->where($this->config_vars['user_to_group'] . ".group_id", $group_par);

			// if group_par is not given, lists all users
		} else {

			$this->CI->db->select('*')
				->from($this->config_vars['users']);
		}

		// banneds
		if (!$include_banneds) {
			$this->CI->db->where('banned != ', 1);
		}

		// limit
		if ($limit) {

			if ($offset == FALSE)
				$this->CI->db->limit($limit);
			else
				$this->CI->db->limit($limit, $offset);
		}

		$query = $this->CI->db->get();

		return $query->result();
	}

	//tested
	/**
	 * Get user
	 * Get user information
	 * @param int|bool $user_id User id to get or FALSE for current user
	 * @return object User information
	 */
	public function get_user($user_id = FALSE) {

		if ($user_id == FALSE)
			$user_id = $this->CI->session->userdata('id');

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() <= 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return FALSE;
		}
		return $query->row();
	}

	/**
	 * Verify user
	 * Activates user account based on verification code
	 * @param int $user_id User id to activate
	 * @param string $ver_code Code to validate against
	 * @return bool Activation fails/succeeds
	 */
	public function verify_user($user_id, $ver_code){

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->where('verification_code', $ver_code);
		$query = $this->CI->db->get( $this->config_vars['users'] );

		// if ver code is TRUE
		if( $query->num_rows() > 0 ){

			$data =	 array(
				'verification_code' => '',
				'banned' => 0
			);

			$this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'] , $data);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Send verification email
	 * Sends a verification email based on user id
	 * @param int $user_id User id to send verification email to
	 * @todo return success indicator
	 */
	public function send_verification($user_id){

		$query = $this->CI->db->where( 'id', $user_id );
		$query = $this->CI->db->get( $this->config_vars['users'] );

		if ($query->num_rows() > 0){
			$row = $query->row();

			$ver_code = random_string('alnum', 16);

			$data['verification_code'] = $ver_code;

			$this->CI->db->where('id', $user_id);
			$this->CI->db->update($this->config_vars['users'], $data);

			$this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
			$this->CI->email->to($row->email);
			$this->CI->email->subject($this->CI->lang->line('aauth_email_verification_subject'));
			$this->CI->email->message($this->CI->lang->line('aauth_email_verification_code') . $ver_code .
				$this->CI->lang->line('aauth_email_verification_link') . $user_id . '/' . $ver_code );
			$this->CI->email->send();
		}
	}

	//not tested excatly
	/**
	 * Delete user
	 * Delete a user from database. WARNING Can't be undone
	 * @param int $user_id User id to delete
	 */
	public function delete_user($user_id) {

		$this->CI->db->where('id', $user_id);
		$this->CI->db->delete($this->config_vars['users']);

		// delete from perm_to_user
		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->delete($this->config_vars['perm_to_user']);

		// delete from user_to_group
		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->delete($this->config_vars['user_to_group']);

		// delete user vars
		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->delete($this->config_vars['user_variables']);
	}

	//tested
	/**
	 * Ban user
	 * Bans a user account
	 * @param int $user_id User id to ban
	 * @return bool Ban fails/succeeds
	 */
	public function ban_user($user_id) {

		$data = array(
			'banned' => 1,
			'verification_code' => ''
		);

		$this->CI->db->where('id', $user_id);

		return $this->CI->db->update($this->config_vars['users'], $data);
	}

	//tested
	/**
	 * Unban user
	 * Activates user account
	 * Same with unlock_user()
	 * @param int $user_id User id to activate
	 * @return bool Activation fails/succeeds
	 */
	public function unban_user($user_id) {

		$data = array(
			'banned' => 0
		);

		$this->CI->db->where('id', $user_id);

		return $this->CI->db->update($this->config_vars['users'], $data);
	}

	//tested
	/**
	 * Check user banned
	 * Checks if a user is banned
	 * @param int $user_id User id to check
	 * @return bool False if banned, True if not
	 */
	public function is_banned($user_id) {

		$query = $this->CI->db->where('id', $user_id);
		$query = $this->CI->db->where('banned', 1);

		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * user_exsist_by_id
	 * Check if user exist by user id
	 * @param $user_id
	 *
	 * @return bool
	 */
	public function user_exsist_by_id( $user_id ) {
		$query = $this->CI->db->where('id', $user_id);

		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * user_exsist_by_name
	 * Check if user exist by name
	 * @param $user_id
	 *
	 * @return bool
	 */
	public function user_exsist_by_name( $name ) {
		$query = $this->CI->db->where('name', $name);

		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * user_exsist_by_email
	 * Check if user exsist by user email
	 * @param $user_email
	 *
	 * @return bool
	 */
	public function user_exsist_by_email( $user_email ) {
		$query = $this->CI->db->where('email', $user_email);

		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * Get user id
	 * Get user id from email address, if par. not given, return current user's id
	 * @param string|bool $email Email address for user
	 * @return int User id
	 */
	public function get_user_id($email=FALSE) {

		if( ! $email){
			$query = $this->CI->db->where('id', $this->CI->session->userdata('id'));
		} else {
			$query = $this->CI->db->where('email', $email);
		}

		$query = $this->CI->db->get($this->config_vars['users']);

		if ($query->num_rows() <= 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return FALSE;
		}
		return $query->row()->id;
	}

	/**
	 * Get user groups
	 * Get groups a user is in
	 * @param int|bool $user_id User id to get or FALSE for current user
	 * @return array Groups
	 */
	public function get_user_groups($user_id = FALSE){

		if ($user_id==FALSE) { $user_id = $this->CI->session->userdata('id'); }

		$this->CI->db->select('*');
		$this->CI->db->from($this->config_vars['user_to_group']);
		$this->CI->db->join($this->config_vars['groups'], "id = group_id");
		$this->CI->db->where('user_id', $user_id);

		return $query = $this->CI->db->get()->result();
	}

	//tested
	/**
	 * Update activity
	 * Update user's last activity date
	 * @param int|bool $user_id User id to update or FALSE for current user
	 * @return bool Update fails/succeeds
	 */
	public function update_activity($user_id = FALSE) {

		if ($user_id == FALSE)
			$user_id = $this->CI->session->userdata('id');

		if($user_id==FALSE){return FALSE;}

		$data['last_activity'] = date("Y-m-d H:i:s");

		$query = $this->CI->db->where('id',$user_id);
		return $this->CI->db->update($this->config_vars['users'], $data);
	}

	//tested
	/**
	 * Hash password
	 * Hash the password for storage in the database
	 * (thanks to Jacob Tomlinson for contribution)
	 * @param string $pass Password to hash
	 * @param $userid
	 * @return string Hashed password
	 */
	function hash_password($pass, $userid) {

		$salt = md5($userid);
		return hash('sha256', $salt.$pass);
	}

	########################
	# Group Functions
	########################

	//tested
	/**
	 * Create group
	 * Creates a new group
	 * @param string $group_name New group name
	 * @return int|bool Group id or FALSE on fail
	 */
	public function create_group($group_name) {

		$query = $this->CI->db->get_where($this->config_vars['groups'], array('name' => $group_name));

		if ($query->num_rows() < 1) {

			$data = array(
				'name' => $group_name
			);
			$this->CI->db->insert($this->config_vars['groups'], $data);
			return $this->CI->db->insert_id();
		}

		$this->info($this->CI->lang->line('aauth_info_group_exists'));
		return FALSE;
	}

	//tested
	/**
	 * Update group
	 * Change a groups name
	 * @param int $group_id Group id to update
	 * @param string $group_name New group name
	 * @return bool Update success/failure
	 */
	public function update_group($group_par, $group_name) {

		$group_id = $this->get_group_id($group_par);

		$data['name'] = $group_name;

		$this->CI->db->where('id', $group_id);
		return $this->CI->db->update($this->config_vars['groups'], $data);
	}

	//tested
	/**
	 * Delete group
	 * Delete a group from database. WARNING Can't be undone
	 * @param int $group_id User id to delete
	 * @return bool Delete success/failure
	 */
	public function delete_group($group_par) {

		$group_id = $this->get_group_id($group_par);
		
	$this->CI->db->where('id',$group_id);
	$query = $this->CI->db->get($this->config_vars['groups']);
	if ($query->num_rows() == 0){
		return FALSE;
	}

		// bug fixed
		// now users are deleted from user_to_group table
		$this->CI->db->where('group_id', $group_id);
		$this->CI->db->delete($this->config_vars['user_to_group']);

		$this->CI->db->where('id', $group_id);
		return $this->CI->db->delete($this->config_vars['groups']);
	}

	//tested
	/**
	 * Add member
	 * Add a user to a group
	 * @param int $user_id User id to add to group
	 * @param int|string $group_par Group id or name to add user to
	 * @return bool Add success/failure
	 */
	public function add_member($user_id, $group_par) {

		$group_id = $this->get_group_id($group_par);

		if( ! $group_id ) {

			$this->error( $this->CI->lang->line('aauth_error_no_group') );
			return FALSE;
		}

		$query = $this->CI->db->where('user_id',$user_id);
		$query = $this->CI->db->where('group_id',$group_id);
		$query = $this->CI->db->get($this->config_vars['user_to_group']);

		if ($query->num_rows() < 1) {
			$data = array(
				'user_id' => $user_id,
				'group_id' => $group_id
			);

			return $this->CI->db->insert($this->config_vars['user_to_group'], $data);
		}
		$this->info($this->CI->lang->line('aauth_info_already_member'));
		return TRUE;
	}

	//tested
	/**
	 * Remove member
	 * Remove a user from a group
	 * @param int $user_id User id to remove from group
	 * @param int|string $group_par Group id or name to remove user from
	 * @return bool Remove success/failure
	 */
	public function remove_member($user_id, $group_par) {

		$group_par = $this->get_group_id($group_par);
		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->where('group_id', $group_par);
		return $this->CI->db->delete($this->config_vars['user_to_group']);
	}

	//tested
	/**
	 * Is member
	 * Check if current user is a member of a group
	 * @param int|string $group_par Group id or name to check
	 * @param int|bool $user_id User id, if not given current user
	 * @return bool
	 */
	public function is_member( $group_par, $user_id = FALSE ) {

		// if user_id FALSE (not given), current user
		if( ! $user_id){
			$user_id = $this->CI->session->userdata('id');
		}

		$group_id = $this->get_group_id($group_par);

		$query = $this->CI->db->where('user_id', $user_id);
		$query = $this->CI->db->where('group_id', $group_id);
		$query = $this->CI->db->get($this->config_vars['user_to_group']);

		$row = $query->row();

		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//tested
	/**
	 * Is admin
	 * Check if current user is a member of the admin group
	 * @param int $user_id User id to check, if it is not given checks current user
	 * @return bool
	 */
	public function is_admin( $user_id = FALSE ) {

		return $this->is_member($this->config_vars['admin_group'], $user_id);
	}

	//tested
	/**
	 * List groups
	 * List all groups
	 * @return object Array of groups
	 */
	public function list_groups() {

		$query = $this->CI->db->get($this->config_vars['groups']);
		return $query->result();
	}


	//tested
	/**
	 * Get group name
	 * Get group name from group id
	 * @param int $group_id Group id to get
	 * @return string Group name
	 */
	public function get_group_name($group_id) {

		$query = $this->CI->db->where('id', $group_id);
		$query = $this->CI->db->get($this->config_vars['groups']);

		if ($query->num_rows() == 0)
			return FALSE;

		$row = $query->row();
		return $row->name;
	}

	//tested
	/**
	 * Get group id
	 * Get group id from group name or id ( ! Case sensitive)
	 * @param int|string $group_par Group id or name to get
	 * @return int Group id
	 */
	public function get_group_id ( $group_par ) {

		if( is_numeric($group_par) ) { return $group_par; }

		$query = $this->CI->db->where('name', $group_par);
		$query = $this->CI->db->get($this->config_vars['groups']);

		if ($query->num_rows() == 0)
			return FALSE;

		$row = $query->row();
		return $row->id;
	}

	########################
	# Permission Functions
	########################

	//tested
	/**
	 * Create permission
	 * Creates a new permission type
	 * @param string $perm_name New permission name
	 * @param string $definition Permission description
	 * @return int|bool Permission id or FALSE on fail
	 */
	public function create_perm($perm_name, $definition='') {

		$query = $this->CI->db->get_where($this->config_vars['perms'], array('name' => $perm_name));

		if ($query->num_rows() < 1) {

			$data = array(
				'name' => $perm_name,
				'definition'=> $definition
			);
			$this->CI->db->insert($this->config_vars['perms'], $data);
			return $this->CI->db->insert_id();
		}
		$this->info($this->CI->lang->line('aauth_info_perm_exists'));
		return FALSE;
	}

	//tested
	/**
	 * Update permission
	 * Updates permission name and description
	 * @param int|string $perm_par Permission id or permission name
	 * @param string $perm_name New permission name
	 * @param string $definition Permission description
	 * @return bool Update success/failure
	 */
	public function update_perm($perm_par, $perm_name=FALSE, $definition=FALSE) {

		$perm_id = $this->get_perm_id($perm_par);

		if ($perm_name != FALSE)
			$data['name'] = $perm_name;

		if ($definition != FALSE)
			$data['definition'] = $definition;

		$this->CI->db->where('id', $perm_id);
		return $this->CI->db->update($this->config_vars['perms'], $data);
	}

	//not ok
	/**
	 * Delete permission
	 * Delete a permission from database. WARNING Can't be undone
	 * @param int|string $perm_par Permission id or perm name to delete
	 * @return bool Delete success/failure
	 */
	public function delete_perm($perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		// deletes from perm_to_gropup table
		$this->CI->db->where('perm_id', $perm_id);
		$this->CI->db->delete($this->config_vars['perm_to_group']);

		// deletes from perm_to_user table
		$this->CI->db->where('perm_id', $perm_id);
		$this->CI->db->delete($this->config_vars['perm_to_group']);

		// deletes from permission table
		$this->CI->db->where('id', $perm_id);
		return $this->CI->db->delete($this->config_vars['perms']);
	}

	/**
	 * Is user allowed
	 * Check if user allowed to do specified action, admin always allowed
	 * first checks user permissions then check group permissions
	 * @param int $perm_par Permission id or name to check
	 * @param int|bool $user_id User id to check, or if FALSE checks current user
	 * @return bool
	 */
	public function is_allowed($perm_par, $user_id=FALSE){

		$perm_id = $this->get_perm_id($perm_par);

		if( $user_id == FALSE){
			$user_id = $this->CI->session->userdata('id');
		}

		$query = $this->CI->db->where('perm_id', $perm_id);
		$query = $this->CI->db->where('user_id', $user_id);
		$query = $this->CI->db->get( $this->config_vars['perm_to_user'] );

		if( $query->num_rows() > 0){
			return TRUE;
		} elseif ($this->is_group_allowed($perm_id)) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	/**
	 * Is Group allowed
	 * Check if group is allowed to do specified action, admin always allowed
	 * @param int $perm_par Permission id or name to check
	 * @param int|string|bool $group_par Group id or name to check, or if FALSE checks all user groups
	 * @return bool
	 */
	public function is_group_allowed($perm_par, $group_par=FALSE){

		$perm_id = $this->get_perm_id($perm_par);

		// if group par is given
		if($group_par != FALSE){

			$group_par = $this->get_group_id($group_par);

			$query = $this->CI->db->where('perm_id', $perm_id);
			$query = $this->CI->db->where('group_id', $group_par);
			$query = $this->CI->db->get( $this->config_vars['perm_to_group'] );

			if( $query->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		// if group par is not given
		// checks current user's all groups
		else {
			// if public is allowed or he is admin
			if ( $this->is_admin( $this->CI->session->userdata('id')) OR
				$this->is_group_allowed($perm_id, $this->config_vars['public_group']) )
			{return TRUE;}

			// if is not login
			if (!$this->is_loggedin()){return FALSE;}

			$group_pars = $this->get_user_groups();

			foreach ($group_pars as $g ){
				if($this->is_group_allowed($perm_id, $g -> id)){
					return TRUE;
				}
			}
			return FALSE;
		}
	}

	//tested
	/**
	 * Allow User
	 * Add User to permission
	 * @param int $user_id User id to deny
	 * @param int $perm_par Permission id or name to allow
	 * @return bool Allow success/failure
	 */
	public function allow_user($user_id, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		$query = $this->CI->db->where('user_id',$user_id);
		$query = $this->CI->db->where('perm_id',$perm_id);
		$query = $this->CI->db->get($this->config_vars['perm_to_user']);

		// if not inserted before
		if ($query->num_rows() < 1) {

			$data = array(
				'user_id' => $user_id,
				'perm_id' => $perm_id
			);

			return $this->CI->db->insert($this->config_vars['perm_to_user'], $data);
		}
		return TRUE;
	}

	//tested
	/**
	 * Deny User
	 * Remove user from permission
	 * @param int $user_id User id to deny
	 * @param int $perm_par Permission id or name to deny
	 * @return bool Deny success/failure
	 */
	public function deny_user($user_id, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);

		$this->CI->db->where('user_id', $user_id);
		$this->CI->db->where('perm_id', $perm_id);

		return $this->CI->db->delete($this->config_vars['perm_to_user']);
	}

	//tested
	/**
	 * Allow Group
	 * Add group to permission
	 * @param int|string|bool $group_par Group id or name to allow
	 * @param int $perm_par Permission id or name to allow
	 * @return bool Allow success/failure
	 */
	public function allow_group($group_par, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);
		$group_id = $this->get_group_id($group_par);

		$query = $this->CI->db->where('group_id',$group_id);
		$query = $this->CI->db->where('perm_id',$perm_id);
		$query = $this->CI->db->get($this->config_vars['perm_to_group']);

		if ($query->num_rows() < 1) {

			$data = array(
				'group_id' => $group_id,
				'perm_id' => $perm_id
			);

			return $this->CI->db->insert($this->config_vars['perm_to_group'], $data);
		}

		return TRUE;
	}

	//tested
	/**
	 * Deny Group
	 * Remove group from permission
	 * @param int|string|bool $group_par Group id or name to deny
	 * @param int $perm_par Permission id or name to deny
	 * @return bool Deny success/failure
	 */
	public function deny_group($group_par, $perm_par) {

		$perm_id = $this->get_perm_id($perm_par);
		$group_id = $this->get_group_id($group_par);

		$this->CI->db->where('group_id', $group_id);
		$this->CI->db->where('perm_id', $perm_id);

		return $this->CI->db->delete($this->config_vars['perm_to_group']);
	}

	//tested
	/**
	 * List Permissions
	 * List all permissions
	 * @return object Array of permissions
	 */
	public function list_perms() {

		$query = $this->CI->db->get($this->config_vars['perms']);
		return $query->result();
	}

	//tested
	/**
	 * Get permission id
	 * Get permission id from permisison name or id
	 * @param int|string $perm_par Permission id or name to get
	 * @return int Permission id or NULL if perm does not exist
	 */
	public function get_perm_id($perm_par) {

		if( is_numeric($perm_par) ) { return $perm_par; }

		$query = $this->CI->db->where('name', $perm_par);
		$query = $this->CI->db->get($this->config_vars['perms']);

		if ($query->num_rows() == 0)
			return NULL;

		$row = $query->row();
		return $row->id;
	}

	########################
	# Private Message Functions
	########################

	//tested
	/**
	 * Send Private Message
	 * Send a private message to another user
	 * @param int $sender_id User id of private message sender
	 * @param int $receiver_id User id of private message receiver
	 * @param string $title Message title/subject
	 * @param string $message Message body/content
	 * @return bool Send successful/failed
	 */
	public function send_pm( $sender_id, $receiver_id, $title, $message ){

		if ( !is_numeric($receiver_id) OR $sender_id == $receiver_id ){
			$this->error($this->CI->lang->line('aauth_error_self_pm'));
			return FALSE;
		}

		$query = $this->CI->db->where('id', $receiver_id);
		$query = $this->CI->db->where('banned', 0);

		$query = $this->CI->db->get( $this->config_vars['users'] );

		// if user not exist or banned
		if ( $query->num_rows() < 1 ){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return FALSE;
		}

		$query = $this->CI->db->where('id', $sender_id);
		$query = $this->CI->db->where('banned', 0);

		$query = $this->CI->db->get( $this->config_vars['users'] );

		// if user not exist or banned
		if ( $query->num_rows() < 1 ){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return FALSE;
		}


		$data = array(
			'sender_id' => $sender_id,
			'receiver_id' => $receiver_id,
			'title' => $title,
			'message' => $message,
			'date' => date('Y-m-d H:i:s')
		);

		return $query = $this->CI->db->insert( $this->config_vars['pms'], $data );
	}

	//tested
	/**
	 * List Private Messages
	 * If receiver id not given retruns current user's pms, if sender_id given, it returns only pms from given sender
	 * @param int $limit Number of private messages to be returned
	 * @param int $offset Offset for private messages to be returned (for pagination)
	 * @param int $sender_id User id of private message sender
	 * @param int $receiver_id User id of private message receiver
	 * @return object Array of private messages
	 */
	public function list_pms($limit=5, $offset=0, $receiver_id = FALSE, $sender_id=FALSE){

		$query='';

		if ( $receiver_id != FALSE){
			$query = $this->CI->db->where('receiver_id', $receiver_id);
		}

		if( $sender_id != FALSE ){
			$query = $this->CI->db->where('sender_id', $sender_id);
		}

		$query = $this->CI->db->order_by('id','DESC');
		$query = $this->CI->db->get( $this->config_vars['pms'], $limit, $offset);
		return $query->result();
	}

	//tested
	/**
	 * Get Private Message
	 * Get private message by id
	 * @param int $pm_id Private message id to be returned
	 * @param bool $set_as_read Whether or not to mark message as read
	 * @return object Private message
	 */
	public function get_pm($pm_id, $set_as_read = TRUE){

		$query = $this->CI->db->where('id', $pm_id);
		$query = $this->CI->db->get( $this->config_vars['pms'] );

		if ($query->num_rows() < 1) {
			$this->error( $this->CI->lang->line('aauth_error_no_pm') );
		}

		if ($set_as_read) $this->set_as_read_pm($pm_id);

		return $query->result();
	}

	//tested
	/**
	 * Delete Private Message
	 * Delete private message by id
	 * @param int $pm_id Private message id to be deleted
	 * @return bool Delete success/failure
	 */
	public function delete_pm($pm_id){
		
		return $this->CI->db->delete( $this->config_vars['pms'], array('id' => $pm_id) );
	}

	//tested
	/**
	 * Count unread Private Message
	 * Count number of unread private messages
	 * @param int|bool $receiver_id User id for message receiver, if FALSE returns for current user
	 * @return int Number of unread messages
	 */
	public function count_unread_pms($receiver_id=FALSE){

		if(!$receiver_id){
			$receiver_id = $this->CI->session->userdata('id');
		}

		$query = $this->CI->db->where('receiver_id', $receiver_id);
		$query = $this->CI->db->where('read', 0);
		$query = $this->CI->db->get( $this->config_vars['pms'] );

		return $query->num_rows();
	}

	//tested
	/**
	 * Set Private Message as read
	 * Set private message as read
	 * @param int $pm_id Private message id to mark as read
	 */
	public function set_as_read_pm($pm_id){

		$data = array(
			'read' => 1,
		);

		$this->CI->db->update( $this->config_vars['pms'], $data, "id = $pm_id");
	}

	########################
	# Error / Info Functions
	########################

	/**
	 * Error
	 * Add message to error array and set flash data
	 * @param string $message Message to add to array
	 * @param boolean $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function error($message = '', $flashdata = FALSE){
		$this->errors[] = $message;
		if($flashdata)
		{
			$this->flash_errors[] = $message;
			$this->CI->session->set_flashdata('errors', $this->flash_errors);
		}
	}

	/**
	 * Keep Errors
	 *
	 * Keeps the flashdata errors for one more page refresh.  Optionally adds the default errors into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all errors and not let them expire as intended.
	 * Benefitial when using Ajax Requests
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 * @param boolean $include_non_flash TRUE if it should stow basic errors as flashdata (default = FALSE)
	 */
	public function keep_errors($include_non_flash = FALSE)
	{
		// NOTE: keep_flashdata() overwrites anything new that has been added to flashdata so we are manually reviving flash data
		// $this->CI->session->keep_flashdata('errors');

		if($include_non_flash)
		{
			$this->flash_errors = array_merge($this->flash_errors, $this->errors);
		}
		$this->flash_errors = array_merge($this->flash_errors, (array)$this->CI->session->flashdata('errors'));
		$this->CI->session->set_flashdata('errors', $this->flash_errors);
	}

	//tested
	/**
	 * Get Errors Array
	 * Return array of errors
	 * @return array Array of messages, empty array if no errors
	 */
	public function get_errors_array()
	{

		if (!count($this->errors)==0)
		{
			return $this->errors;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Print Errors
	 * 
	 * Prints string of errors separated by delimiter
	 * @param string $divider Separator for errors
	 */
	public function print_errors($divider = '<br />')
	{
		$msg = '';
		$msg_num = count($this->errors);
		$i = 1;
		foreach ($this->errors as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}
	
	/**
	 * Clear Errors
	 * 
	 * Removes errors from error list and clears all associated flashdata
	 */
	public function clear_errors()
	{
		$this->errors = [];
		$this->CI->session->set_flashdata('errors', $this->errors);
	}

	/**
	 * Info
	 *
	 * Add message to info array and set flash data
	 * 
	 * @param string $message Message to add to infos array
	 * @param boolean $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function info($message = '', $flashdata = FALSE)
	{
		$this->infos[] = $message;
		if($flashdata)
		{
			$this->flash_infos[] = $message;
			$this->CI->session->set_flashdata('infos', $this->flash_infos);
		}
	}

	/**
	 * Keep Infos
	 *
	 * Keeps the flashdata infos for one more page refresh.  Optionally adds the default infos into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all infos and not let them expire as intended.
	 * Benefitial by using Ajax Requests
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 * @param boolean $include_non_flash TRUE if it should stow basic infos as flashdata (default = FALSE)
	 */
	public function keep_infos($include_non_flash = FALSE)
	{
		// NOTE: keep_flashdata() overwrites anything new that has been added to flashdata so we are manually reviving flash data
		// $this->CI->session->keep_flashdata('infos');

		if($include_non_flash)
		{
			$this->flash_infos = array_merge($this->flash_infos, $this->infos);
		}
		$this->flash_infos = array_merge($this->flash_infos, (array)$this->CI->session->flashdata('infos'));
		$this->CI->session->set_flashdata('infos', $this->flash_infos);
	}

	/**
	 * Get Info Array
	 *
	 * Return array of infos
	 * @return array Array of messages, empty array if no errors
	 */
	public function get_infos_array()
	{
		if (!count($this->infos)==0)
		{
			return $this->infos;
		}
		else
		{
			return array();
		}
	}


	/**
	 * Print Info
	 *
	 * Print string of info separated by delimiter
	 * @param string $divider Separator for info
	 *
	 */
	public function print_infos($divider = '<br />')
	{

		$msg = '';
		$msg_num = count($this->infos);
		$i = 1;
		foreach ($this->infos as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}
	
	/**
	 * Clear Info List
	 * 
	 * Removes info messages from info list and clears all associated flashdata
	 */
	public function clear_infos()
	{
		$this->infos = [];
		$this->CI->session->set_flashdata('infos', $this->infos);
	}

	########################
	# User Variables
	########################

	//tested
	/**
	 * Set User Variable as key value
	 * if variable not set before, it will ve set
	 * if set, overwrites the value
	 * @param string $key
	 * @param string $value
	 * @param int $user_id ; if not given current user
	 * @return bool
	 */
	public function set_user_var( $key, $value, $user_id = FALSE ) {

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return FALSE;
		}

		// if var not set, set
		 if ($this->get_user_var($key,$user_id) ===FALSE) {

			$data = array(
				'key' => $key,
				'value' => $value,
				'user_id' => $user_id
			);

			return $this->CI->db->insert( $this->config_vars['user_variables'] , $data);
		}
		// if var already set, overwrite
		else {

			$data = array(
				'key' => $key,
				'value' => $value,
				'user_id' => $user_id
			);

			$this->CI->db->where( 'key', $key );
			$this->CI->db->where( 'user_id', $user_id);

			return $this->CI->db->update( $this->config_vars['user_variables'], $data);
		}
	}

	//tested
	/**
	 * Unset User Variable as key value
	 * @param string $key
	 * @param int $user_id ; if not given current user
	 * @return bool
	 */
	public function unset_user_var( $key, $user_id = FALSE ) {

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return FALSE;
		}

		$this->CI->db->where('key', $key);
		$this->CI->db->where('user_id', $user_id);

		return $this->CI->db->delete( $this->config_vars['user_variables'] );
	}

	//tested
	/**
	 * Get User Variable by key
	 * Return string of variable value or FALSE
	 * @param string $key
	 * @param int $user_id ; if not given current user
	 * @return bool|string , FALSE if var is not set, the value of var if set
	 */
	public function get_user_var( $key, $user_id = FALSE){

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return FALSE;
		}

		$query = $this->CI->db->where('user_id', $user_id);
		$query = $this->CI->db->where('key', $key);

		$query = $this->CI->db->get( $this->config_vars['user_variables'] );

		// if variable not set
		if ($query->num_rows() < 1) { return FALSE;}

		else {

			$row = $query->row();
			return $row->value;
		}

	}
	
   
	/**
	 * List User Variable Keys by UserID
	 * Return array of variable keys or FALSE
	 * @param int $user_id ; if not given current user
	 * @return bool|array, FALSE if no user vars, otherwise array
	 */
	public function list_user_var_keys($user_id = FALSE){

		if ( ! $user_id ){
			$user_id = $this->CI->session->userdata('id');
		}

		// if specified user is not found
		if ( ! $this->get_user($user_id)){
			return FALSE;
		}
		$query = $this->CI->db->select('key');

		$query = $this->CI->db->where('user_id', $user_id);

		$query = $this->CI->db->get( $this->config_vars['user_variables'] );

		// if variable not set
		if ($query->num_rows() < 1) { return FALSE;}
		else {
			$key_list = array();
			foreach( $query->result() as $row) {
				$key_list[] = $row->key;
			}
			return $key_list;
		}
	}

	########################
	# Aauth System Variables
	########################

	//tested
	/**
	 * Set Aauth System Variable as key value
	 * if variable not set before, it will be set
	 * if set, overwrites the value
	 * @param string $key
	 * @param string $value
	 * @return bool
	 */
	public function set_system_var( $key, $value ) {

		// if var not set, set
		if ( ! $this->get_system_var($key) ) {

			$data = array(
				'key' => $key,
				'value' => $value,
			);

			return $this->CI->db->insert( $this->config_vars['system_variables'] , $data);

		}
		// if var already set, overwrite
		else {

			$data = array(
				'key' => $key,
				'value' => $value,
			);

			$this->CI->db->where( 'key', $key );
			return $this->CI->db->update( $this->config_vars['system_variables'], $data);
		}

	}

	//tested
	/**
	 * Unset Aauth System Variable as key value
	 * @param string $key
	 * @return bool
	 */
	public function unset_system_var( $key	) {

		$this->CI->db->where('key', $key);

		return $this->CI->db->delete( $this->config_vars['system_variables'] );
	}

	//tested
	/**
	 * Get Aauth System Variable by key
	 * Return string of variable value or FALSE
	 * @param string $key
	 * @return bool|string , FALSE if var is not set, the value of var if set
	 */
	public function get_system_var( $key ){

		$query = $this->CI->db->where('key', $key);

		$query = $this->CI->db->get( $this->config_vars['system_variables'] );

		// if variable not set
		if ($query->num_rows() < 1) { return FALSE;}

		else {

			$row = $query->row();
			return $row->value;
		}
	}
	
	 /**
	 * List System Variable Keys
	 * Return array of variable keys or FALSE
	 * @return bool|array , FALSE if var is not set, the value of var if set
	 */

	public function list_system_var_keys(){
		$query = $this->CI->db->select('key');
		$query = $this->CI->db->get( $this->config_vars['system_variables'] );
		// if variable not set
		if ($query->num_rows() < 1) { return FALSE;}
		else {
			return $query->result();
		}
	}

	public function generate_recaptcha_field(){
		$content = '';
		if($this->config_vars['ddos_protection'] && $this->config_vars['recaptcha_active'] && $this->CI->input->cookie('reCAPTCHA', TRUE) == 'true'){
			$content .= "<script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>";
			$siteKey = $this->config_vars['recaptcha_siteKey'];
			$content .= "<div class='g-recaptcha' data-sitekey='{$siteKey}'></div>";
		}
		return $content;
	}

} // end class

// $this->CI->session->userdata('id')

/* coming with v3
----------------
 * captcha (hmm bi bakalım)
 * parametre olarak array alma
 * stacoverflow
 * public id sini 0 a eşitleyip öyle kontrol yapabilirdik (oni boşver uşağum)
 * lock_user (until parametrsi)
 * unlock_user
 * send_pm() in errounda receiver ve sender için ayrı errorlar olabilür
 * ddos protect olayını daha mantıklı hale getür
 * geçici ban ve e-mail ile tkrar aktifleştime olayı
*/

/**
 * Coming with v2
 * -------------
 *
 * tmam // permission id yi permission parametre yap
 * mail fonksiyonları imtihanı
 * tamam // login e ip aderesi de eklemek lazım
 * list_users da grup_par verilirse ve adamın birden fazla grubu varsa nolurkun? // bi denemek lazım belki distinct ile düzelir
 * tamam // eğer grup silinmişse kullanıcıları da o gruptan sil (fire)
 * tamam //	 ismember la is admine 2. parametre olarak user id ekle
 * tamam // kepp infos errors die bişey yap ajax requestlerinde silinir errorlar
 * tmam // user variables
 * tamam // sistem variables
 * tmam // user perms
 * tamam gibi // 4mysql index fulltext index??
 * tamam //delete_user dan sonra grup ve perms ler de silinmeli
 * login() içinde login'i doğru şekilde olsa da yine de login attempt artıyo kesin düzeltilecek
 * keep_errors ve keep_infos calismiyor
 *
 *
 *
 * -----------
 * ok
 *
 * unban_user() added // unlock_user
 * remove member added // fire_member
 * allow() changed to allow_group
 * deny() changed to deny_group
 * is member a yeni parametre eklendi
 * allow_user() added
 * deny_user() added
 * keep_infos() added
 * kepp_errors() added
 * get_errors() changed to print_errors()
 * get_infos() changed to print_infos()
 * User and Aauth System Variables.
set_user_var( $key, $value, $user_id = FALSE )
get_user_var( $key, $user_id = FALSE)
unset
set_system_var( $key, $value, $user_id = FALSE )
get_system_var( $key, $user_id = FALSE)
unset
functions added
 *
 *
 *
 *
 *
 * Done staff v1
 * -----------
 * tamam hacı // control die bi fonksiyon yazıp adam önce login omuşmu sonra da yetkisi var mı die kontrol et. yetkisi yoksa yönlendir ve aktivitiyi güncelle
 * tamam hacı // grupları yetkilendirme, yetki ekleme, alma alow deny
 * tamam gibi // Email and pass validation with form helper
 * biraz oldu // laguage file support
 * tamam // forget pass
 * tamam // yetkilendirme sistemi
 * tamam // Login e remember eklencek
 * tamam // şifremi unuttum ve random string
 * sanırım şimdi tamam // hatalı girişde otomatik süreli kilit
 * ??  tamam heral // mail ile bilgilendirme
 * tamam heral // activasyon emaili
 * tamam gibi // yerine email check // username check
 * tamamlandı // public erişimi
 * tamam // Private messsages
 * tamam össen // errorlar düzenlenecek hepisiiii
 * tamam ama engelleme ve limit olayı koymadım. // pm için okundu ve göster, sil, engelle? die fonksiyonlar eklencek , gönderilen pmler, alınan pmler, arasındaki pmler,
 * tamm// already existedleri info yap onlar error değil hacım
 *




/*
// if user's email is found
if ($query->num_rows() > 0) {
$row = $query->row();

// DDos protection
if ( $this->config_vars['dos_protection'] and $row->last_login_attempt != '' and
(strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($row->last_login_attempt) ) {
$this->error($this->CI->lang->line('exceeded'));
return FALSE;
}
}
 */



/* End of file Aauth.php */
/* Location: ./application/libraries/Aauth.php */