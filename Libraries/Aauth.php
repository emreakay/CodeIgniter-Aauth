<?php namespace Magefly\Aauth\Libraries;

class Aauth {

	public $errors = array();
	public $infos = array();
	public $flash_errors = array();
	public $flash_infos = array();

	function __construct() {
		$this->config = new Magefly\Aauth\Config\Aauth();
		$this->session = \Config\Services::session();
	}

	public function createUser($email, $password, $username = null)
	{
		$user = new \Magefly\Aauth\Models\UserModel();

		$data['email'] = $email;
		$data['password'] = $password;

		if ($username)
		{
			$data['username'] = $username;
		}

		if ($user_id = $user->insert($data))
		{
			return $user_id;
		}

		$this->error($user->errors());
		return false;
	}

	public function updateUser($user_id, $email = null, $password = null, $username = null)
	{
		$user = new \Magefly\Aauth\Models\UserModel();
		$data = [];

		if ( ! $user->exists($user_id))
		{
			$this->error(lang('Aauth.notFoundUser'));
			return false;
		}

		if ( ! $email && ! $password && ! $username)
		{
			 return false;
		}

		$data['id'] = $user_id;

		if ($email)
		{
			$data['email'] = $email;
		}

		if ($password)
		{
			$data['password'] = $password;
		}

		if ($username)
		{
			$data['username'] = $username;
		}

		if ($user->update($user_id, $data))
		{
			return $user_id;
		}

		$this->error($user->errors());
		return false;
	}

	public function deleteUser(int $user_id)
	{
		$user = new \Magefly\Aauth\Models\UserModel();
		$data = [];

		if ( ! $user->exists($user_id))
		{
			$this->error(lang('Aauth.notFoundUser'));
			return false;
		}

		if ($user->delete($user_id))
		{
			return true;
		}
	}

	public function listUsers(int $limit = 0, int $offset = 0, bool $include_banneds = null, array $order_by = null)
	{
		$user = new \Magefly\Aauth\Models\UserModel();
		$options = [];

		// bool $group_par = null,

		if ( ! $include_banneds)
		{
			$options['where'] = ['banned' => 0];
		}

		if ($order_by)
		{
			$options['order_by'] = $order_by;
		}

		return $user->findAllExtra($limit, $offset, $options);
	}

	public function login(string $identifier, string $password, bool $remember = null, bool $totp_code = null)
	{
		$user = new \Magefly\Aauth\Models\UserModel();
		$loginAttempt = new \Magefly\Aauth\Models\LoginAttemptModel();
		helper('cookie');
		delete_cookie('user');


		if ($this->config->loginProtection && ! $loginAttempt->update())
		{
			$this->error(lang('Aauth.loginAttemptsExceeded'));
			return false;
		}

		// if($this->config_vars['ddos_protection'] && $this->config_vars['recaptcha_active'] && $loginAttempt->get() > $this->config_vars['recaptcha_login_attempts']){
		// 	$this->CI->load->helper('recaptchalib');
		// 	$reCaptcha = new ReCaptcha( $this->config_vars['recaptcha_secret']);
		// 	$resp = $reCaptcha->verifyResponse( $this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response") );
		// 	if( ! $resp->success){
		// 		$this->error($this->CI->lang->line('aauth_error_recaptcha_not_correct'));
		// 		return FALSE;
		// 	}
		// }
 		if ($this->config->loginUseUsername)
 		{
			if ( ! $identifier OR strlen($password) < $this->config->passwordMin OR strlen($password) > $this->config->passwordMax)
			{
				$this->error(lang('Aauth.loginFailedName'));
				return FALSE;
			}

			$db_identifier = 'username';

 		}else{
			$validation =  \Config\Services::validation();

			if( ! $validation->check($identifier, 'valid_email') OR strlen($password) < $this->config->passwordMin OR strlen($password) > $this->config->passwordMax)
			{
				$this->error(lang('Aauth.loginFailedEmail'));
				return FALSE;
			}
			$db_identifier = 'email';
 		}

		$query = null;
		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->where('banned', 1);
		$query = $this->aauth_db->where('verification_code !=', '');
		$query = $this->aauth_db->get($this->config_vars['users']);
		if ($query->num_rows() > 0) {
			$this->error($this->CI->lang->line('aauth_error_account_not_verified'));
			return FALSE;
		}
		// to find user id, create sessions and cookies
		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->get($this->config_vars['users']);
		if($query->num_rows() == 0){
			$this->error($this->CI->lang->line('aauth_error_no_user'));
			return FALSE;
		}
		if($this->config_vars['totp_active'] == TRUE AND $this->config_vars['totp_only_on_ip_change'] == FALSE AND $this->config_vars['totp_two_step_login_active'] == TRUE){
			if($this->config_vars['totp_two_step_login_active'] == TRUE){
				$this->CI->session->set_userdata('totp_required', true);
			}
			$query = null;
			$query = $this->aauth_db->where($db_identifier, $identifier);
			$query = $this->aauth_db->get($this->config_vars['users']);
			$totp_secret =  $query->row()->totp_secret;
			if ($query->num_rows() > 0 AND !$totp_code) {
				$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
				return FALSE;
			}else {
				if(!empty($totp_secret)){
					$this->CI->load->helper('googleauthenticator');
					$ga = new PHPGangsta_GoogleAuthenticator();
					$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
					if (!$checkResult) {
						$this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
						return FALSE;
					}
				}
			}
	 	}
	 	if($this->config_vars['totp_active'] == TRUE AND $this->config_vars['totp_only_on_ip_change'] == TRUE){
			$query = null;
			$query = $this->aauth_db->where($db_identifier, $identifier);
			$query = $this->aauth_db->get($this->config_vars['users']);
			$totp_secret =  $query->row()->totp_secret;
			$ip_address = $query->row()->ip_address;
			$current_ip_address = $this->CI->input->ip_address();
			if ($query->num_rows() > 0 AND !$totp_code) {
				if($ip_address != $current_ip_address ){
					if($this->config_vars['totp_two_step_login_active'] == FALSE){
						$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
						return FALSE;
					} else if($this->config_vars['totp_two_step_login_active'] == TRUE){
						$this->CI->session->set_userdata('totp_required', true);
					}
				}
			}else {
				if(!empty($totp_secret)){
					if($ip_address != $current_ip_address ){
						$this->CI->load->helper('googleauthenticator');
						$ga = new PHPGangsta_GoogleAuthenticator();
						$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
						if (!$checkResult) {
							$this->error($this->CI->lang->line('aauth_error_totp_code_invalid'));
							return FALSE;
						}
					}
				}
			}
	 	}
		$query = null;
		$query = $this->aauth_db->where($db_identifier, $identifier);
		$query = $this->aauth_db->where('banned', 0);
		$query = $this->aauth_db->get($this->config_vars['users']);
		$row = $query->row();
		// if email and pass matches and not banned
		$password = ($this->config_vars['use_password_hash'] ? $password : $this->hash_password($password, $row->id));
		if ( $query->num_rows() != 0 && $this->verify_password($password, $row->password) ) {
			// If email and pass matches
			// create session
			$data = array(
				'id' => $row->id,
				'username' => $row->username,
				'email' => $row->email,
				'loggedin' => TRUE
			);
			$this->CI->session->set_userdata($data);
			if ( $remember ){
				$this->CI->load->helper('string');
				$expire = $this->config_vars['remember'];
				$today = date("Y-m-d");
				$remember_date = date("Y-m-d", strtotime($today . $expire) );
				$random_string = random_string('alnum', 16);
				$this->update_remember($row->id, $random_string, $remember_date );
				$cookie = array(
					'name'	 => 'user',
					'value'	 => $row->id . "-" . $random_string,
					'expire' => 99*999*999,
					'path'	 => '/',
				);
				$this->CI->input->set_cookie($cookie);
			}
			// update last login
			$this->update_last_login($row->id);
			$this->update_activity();
			if($this->config_vars['remove_successful_attempts'] == TRUE){
				$this->reset_login_attempts();
			}
			return TRUE;
		}
		// if not matches
		else {
			$this->error($this->CI->lang->line('aauth_error_login_failed_all'));
			return FALSE;
		}
	}


	public function error($message = '', $flashdata = null)
	{
		$this->errors[] = $message;

		if ($flashdata)
		{
			$this->flash_errors[] = $message;
			$this->session->set('errors', $this->flash_errors);
			$this->session->setFlashdata('errors');
		}
	}

	public function keepErrors($includeNonFlash = null)
	{
		if ($includeNonFlash)
			$this->flash_errors = array_merge($this->flash_errors, $this->errors);

		$this->flash_errors = array_merge($this->flash_errors, (array)$this->session->getFlashdata('errors'));
		$this->session->set('errors', $this->flash_errors);
		$this->session->setFlashdata('errors');
	}

	public function getErrorsArray()
	{
		return $this->errors;
	}

	public function printErrors($divider = '<br />', $return = null)
	{
		$msg = '';
		$msg_num = count($this->errors);
		$i = 1;

		foreach ($this->errors as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
				$msg .= $divider;

			$i++;
		}

		if ($return)
			return $msg;

		echo $msg;
	}

	public function clearErrors()
	{
		$this->errors = array();
		$this->session->remove('errors');
	}

	public function info($message = '', $flashdata = null)
	{
		$this->infos[] = $message;

		if ($flashdata)
		{
			$this->flash_infos[] = $message;
			$this->session->set('infos', $this->flash_infos);
			$this->session->setFlashdata('infos');
		}
	}

	public function keepInfos($includeNonFlash = null)
	{
		if ($includeNonFlash)
			$this->flash_infos = array_merge($this->flash_infos, $this->infos);

		$this->flash_infos = array_merge($this->flash_infos, (array)$this->session->getFlashdata('infos'));
		$this->session->set('infos', $this->flash_infos);
		$this->session->setFlashdata('infos');
	}

	public function getInfosArray()
	{
		return $this->infos;
	}

	public function printInfos($divider = '<br />', $return = null)
	{
		$msg = '';
		$msg_num = count($this->infos);
		$i = 1;

		foreach ($this->infos as $e)
		{
			$msg .= $e;
			if ($i != $msg_num)
				$msg .= $divider;
			$i++;
		}

		if ($return)
			return $msg;

		echo $msg;
	}

	public function clearInfos()
	{
		$this->infos = array();
		$this->session->remove('infos');
	}
}
