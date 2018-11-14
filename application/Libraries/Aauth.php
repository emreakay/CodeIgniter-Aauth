<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like groupping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Magefly Team
 * @author    Jacob Tomlinson
 * @author    Tim Swagger (Renowne, LLC) <tim@renowne.com>
 * @author    Raphael Jackstadt <info@rejack.de>
 * @copyright 2014-2017 Emre Akay
 * @copyright 2018 Magefly
 * @license   https://opensource.org/licenses/MIT	MIT License
 * @link      https://github.com/magefly/CodeIgniter-Aauth
 */

namespace App\Libraries;

use \App\Models\Aauth\UserModel as UserModel;
use \App\Models\Aauth\LoginAttemptModel as LoginAttemptModel;
use \App\Models\Aauth\LoginTokenModel as LoginTokenModel;
use \App\Models\Aauth\UserVariableModel as UserVariableModel;

/**
 * Aauth Library
 *
 * @package CodeIgniter-Aauth
 */
class Aauth
{
	/**
	 * Variable for loading the config array into
	 *
	 * @var \Config\Aauth
	 */
	private $config;

	/**
	 * Variable for loading the session service into
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	private $session;

	/**
	 * Array to store error messages
	 *
	 * @var array
	 */
	private $errors = [];

	/**
	 * Local temporary storage for current flash errors
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 *
	 * @var array
	 */
	private $flashErrors = [];

	/**
	 * Array to store info messages
	 *
	 * @var array
	 */
	private $infos = [];

	/**
	 * Local temporary storage for current flash infos
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 *
	 * @var array
	 */
	private $flashInfos = [];

	/**
	 * Array to cache permission-ids.
	 *
	 * @var array
	 */
	private $cachePermId = [];

	/**
	 * Array to cache group-ids.
	 *
	 * @var array
	 */
	private $cacheGroupId = [];

	/**
	 * Constructor
	 *
	 * Prepares config & session variable.
	 */
	public function __construct()
	{
		$this->config  = new \Config\Aauth();
		$this->session = \Config\Services::session();
	}

	/**
	 * Create user
	 *
	 * Creates a new user
	 *
	 * @param string         $email    User's email address
	 * @param string         $password User's password
	 * @param string|boolean $username User's username
	 *
	 * @return integer|boolean
	 */
	public function createUser(string $email, string $password, string $username = null)
	{
		$userModel = new UserModel();

		$data['email']    = $email;
		$data['password'] = $password;

		if (! is_null($username))
		{
			$data['username'] = $username;
		}

		if (! $userId = $userModel->insert($data))
		{
			$this->error($userModel->errors());

			return false;
		}

		if ($this->config->userVerification)
		{
			$this->sendVerification($userId, $email);
			$this->info(lang('Aauth.infoCreateVerification'));

			return $userId;
		}

		$this->info(lang('Aauth.infoCreateSuccess'));

		return $userId;
	}

	/**
	 * Send verification email
	 *
	 * Sends a verification email based on user id
	 *
	 * @param integer $userId User id to send verification email to
	 * @param string  $email  Email to send verification email to
	 *
	 * @todo return boolean success indicator
	 *
	 * @return boolean
	 */
	public function sendVerification(int $userId, string $email)
	{
		helper('text');
		$userModel         = new UserModel();
		$userVariableModel = new UserVariableModel();
		$emailService      = \Config\Services::email();
		$verificationCode  = random_string('alnum', 16);

		$userModel->skipValidation()->protect(false)->update($userId, ['banned' => 1]);
		$userVariableModel->save($userId, 'verification_code', $verificationCode, true);

		$messageData['code'] = $verificationCode;
		$messageData['link'] = site_url($this->config->linkVerification . '/' . $userId . '/' . $verificationCode);

		$message = view('Aauth/Verification', $messageData);

		$emailService->initialize(isset($this->config->emailConfig) ? $this->config->emailConfig : []);
		$emailService->setFrom($this->config->emailFrom, $this->config->emailFromName);
		$emailService->setTo($email);
		$emailService->setSubject(lang('Aauth.subjectVerification'));
		$emailService->setMessage($message);

		return $emailService->send();
	}

	/**
	 * Update user
	 *
	 * Updates existing user details
	 *
	 * @param integer        $userId   User id to update
	 * @param string|boolean $email    User's email address, or FALSE if not to be updated
	 * @param string|boolean $password User's password, or FALSE if not to be updated
	 * @param string|boolean $username User's name, or FALSE if not to be updated
	 *
	 * @return boolean
	 */
	public function updateUser(int $userId, $email = null, string $password = null, string $username = null)
	{
		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));
			return false;
		}
		else if (! is_null($email) && ! is_null($password) && ! is_null($username))
		{
			return false;
		}

		$data['id'] = $userId;

		if (! is_null($email))
		{
			$data['email'] = $email;
		}

		if (! is_null($password))
		{
			$data['password'] = $password;
		}

		if (! is_null($username))
		{
			$data['username'] = $username;
		}

		if ($userModel->update($userId, $data))
		{
			return true;
		}

		$this->error($userModel->errors());

		return false;
	}

	/**
	 * Delete user
	 *
	 * @param integer $userId User id to delete
	 *
	 * @return boolen
	 */
	public function deleteUser(int $userId)
	{
		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));
			return false;
		}
		else if ($userModel->delete($userId))
		{
			return true;
		}
	}

	/**
	 * List users
	 *
	 * Return users as an object array
	 *
	 * @param integer $limit          Limit of users to be returned
	 * @param integer $offset         Offset for limited number of users
	 * @param boolean $includeBanneds Include banned users
	 * @param string  $orderBy        Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @todo bool|integer $group_par Specify group id to list group or FALSE for all users
	 *
	 * @return array Array of users
	 */
	public function listUsers(int $limit = 0, int $offset = 0, bool $includeBanneds = null, string $orderBy = null)
	{
		$userModel = new UserModel();
		$user      = $userModel->limit($limit, $offset);
		// eanbool $group_par = null,

		if (is_null($includeBanneds))
		{
			$user->where('banned', 0);
		}

		if (! is_null($orderBy))
		{
			$user->orderBy($orderBy[0], $orderBy[1]);
		}

		return $user->findAll();
	}

	/**
	 * Login user
	 *
	 * Check provided details against the database. Add items to error array on fail
	 *
	 * @param string  $identifier Identifier
	 * @param string  $password   Password
	 * @param boolean $remember   Whether to remember login
	 * @param string  $totpCode   TOTP Code
	 *
	 * @todo add TOTP
	 * @todo add reCAPTCHA
	 *
	 * @return boolean
	 */
	public function login(string $identifier, string $password, bool $remember = null, string $totpCode = null)
	{
		helper('cookie');
		delete_cookie('user');

		$userModel         = new UserModel();
		$loginAttemptModel = new LoginAttemptModel();
		$userVariableModel = new UserVariableModel();

		if ($this->config->loginProtection && ! $loginAttemptModel->update())
		{
			$this->error(lang('Aauth.loginAttemptsExceeded'));
			return false;
		}

		// if ($this->config->ddos_protection && $this->config->recaptcha_active && $loginAttempts->get() > $this->config->recaptcha_login_attempts){
		// 	$this->CI->load->helper('recaptchalib');
		// 	$reCaptcha = new ReCaptcha( $this->config->recaptcha_secret);
		// 	$resp      = $reCaptcha->verifyResponse( $this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response") );
		// 	if( ! $resp->success){
		// 		$this->error(lang('Aauth.aauth_error_recaptcha_not_correct'));
		// 		return false;
		// 	}
		// }

		if ($this->config->loginUseUsername)
		{
			if (! $identifier || strlen($password) < $this->config->passwordMin || strlen($password) > $this->config->passwordMax)
			{
				$this->error(lang('Aauth.loginFailedName'));
				return false;
			}

			if ($user = $userModel->where('username', $identifier)->first())
			{
				$this->error(lang('Aauth.notFoundUser'));
				return false;
			}
		}
		else
		{
			$validation = \Config\Services::validation();

			if (! $validation->check($identifier, 'valid_email') || strlen($password) < $this->config->passwordMin || strlen($password) > $this->config->passwordMax)
			{
				$this->error(lang('Aauth.loginFailedEmail'));
				return false;
			}

			if (! $user = $userModel->where('email', $identifier)->first())
			{
				$this->error(lang('Aauth.notFoundUser'));
				return false;
			}
		}

		if ($user['banned'] && ! empty($userVariableModel->find($user['id'], 'verification_code', true)))
		{
			$this->error(lang('Aauth.notVerified'));
			return false;
		}
		else if ($user['banned'])
		{
			$this->error(lang('Aauth.invalidUserBanned'));
			return false;
		}

		// if ($this->config->totpEnabled && ! $this->config->totpOnIpChange && $this->config->totpLogin)
		// {
		// 	if ($this->config->totpLogin == true)
		// 	{
		// 		$this->session->set('totp_required', true);
		// 	}

		// 	$totp_secret =  $userVariableModel->find($user['id'], 'totp_secret', true);
		// 	if ( ! empty($totp_secret) && ! $totp_code) {
		// 		$this->error(lang('Aauth.requiredTOTPCode'));
		// 		return false;
		// 	} else {
		// 		if( ! empty($totp_secret)){
		// 			$this->CI->load->helper('googleauthenticator');
		// 			$ga = new PHPGangsta_GoogleAuthenticator();
		// 			$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
		// 			if ( ! $checkResult) {
		// 				$this->error(lang('Aauth.invalidTOTPCode'));
		// 				return false;
		// 			}
		// 		}
		// 	}
		// }
		// else if ($this->config->totpEnabled && $this->config->totpOnIpChange)
		// {
		// 	$query = null;
		// 	$query = $this->aauth_db->where($db_identifier, $identifier);
		// 	$query = $this->aauth_db->get($this->config->users);
		// 	$totp_secret =  $query->row()->totp_secret;
		// 	$ip_address = $query->row()->ip_address;
		// 	$current_ip_address = $this->CI->input->ip_address();
		// 	if ($query->num_rows() > 0 AND !$totp_code) {
		// 		if($ip_address != $current_ip_address ){
		// 			if($this->config->totpLogin == false){
		// 				$this->error(lang('Aauth.aauth_error_totp_code_required'));
		// 				return false;
		// 			} else if($this->config->totpLogin == true){
		// 				$this->session->set('totp_required', true);
		// 			}
		// 		}
		// 	}else {
		// 		if(!empty($totp_secret)){
		// 			if($ip_address != $current_ip_address ){
		// 				$this->CI->load->helper('googleauthenticator');
		// 				$ga = new PHPGangsta_GoogleAuthenticator();
		// 				$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
		// 				if (!$checkResult) {
		// 					$this->error(lang('Aauth.aauth_error_totp_code_invalid'));
		// 					return false;
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		if (! $user['banned'] && password_verify($password, $user['password']))
		{
			$data['id']       = $user['id'];
			$data['username'] = $user['username'];
			$data['email']    = $user['email'];
			$data['loggedIn'] = true;
			$this->session->set($data);

			if ($remember)
			{
				helper('text');
				$loginTokenModel = new LoginTokenModel();
				$expire          = $this->config->loginRemember;
				$userId          = base64_encode($user['id']);
				$randomString    = random_string('alnum', 32);
				$selectorString  = random_string('alnum', 16);

				$cookieData['name']   = 'remember';
				$cookieData['value']  = $userId . ';' . $randomString . ';' . $selectorString;
				$cookieData['expire'] = YEAR;

				$tokenData['user_id']       = $user['id'];
				$tokenData['random_hash']   = password_hash($randomString, PASSWORD_DEFAULT);
				$tokenData['selector_hash'] = password_hash($selectorString, PASSWORD_DEFAULT);
				$tokenData['expires_at']    = date('Y-m-d H:i:s', strtotime($expire));

				$loginTokenModel->insert($tokenData);
				set_cookie($cookieData);
			}

			$userModel->updateLastLogin($user['id']);

			if ($this->config->loginAttemptRemoveSuccessful)
			{
				$loginAttemptModel->delete();
			}

			return true;
		}
		else
		{
			$this->error(lang('Aauth.loginFailedAll'));
			return false;
		}
	}

	/**
	 * Fast login
	 *
	 * Login with just a user id
	 *
	 * @param integer $userId User id
	 *
	 * @return boolean
	 */
	private function loginFast(int $userId)
	{
		$userModel = new UserModel();
		$userModel->select('id, email, username');
		$userModel->where('id', $userId);
		$userModel->where('banned', 0);

		if ($user = $userModel->get()->getFirstRow())
		{
			$this->session->set([
				'id'       => $user->id,
				'username' => $user->username,
				'email'    => $user->email,
				'loggedIn' => true,
			]);

			return true;
		}

		return false;
	}

	/**
	 * Check user login
	 *
	 * Checks if user logged in, also checks remember.
	 *
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		helper('cookie');

		if (session('loggedIn'))
		{
			return true;
		}
		else if ($cookie = get_cookie('remember'))
		{
			$cookie    = explode(';', $cookie);
			$cookie[0] = base64_decode($cookie[0]);

			if (! is_numeric($cookie[0]) || strlen($cookie[1]) !== 32 || strlen($cookie[2]) !== 16)
			{
				return false;
			}
			else
			{
				$loginTokenModel = new LoginTokenModel();
				$loginTokens     = $loginTokenModel->getAllByUserId($cookie[0]);

				foreach ($loginTokens as $loginToken)
				{
					if (password_verify($cookie[1], $loginToken['random_hash']) && password_verify($cookie[2], $loginToken['selector_hash']))
					{
						if (strtotime($loginToken['expires_at']) > strtotime('now'))
						{
							$loginTokenModel->update($loginToken['id']);

							return $this->loginFast($loginToken['user_id']);
						}
						else
						{
							$loginTokenModel->delete($cookie[0]);
							delete_cookie('remember');
						}
					}
				}
			}
		}

		return false;
	}

	/**
	 * Error
	 *
	 * Add message to error array and set flash data
	 *
	 * @param string|array $message   Message to add to array
	 * @param boolean      $flashdata Whether to add $message to session flashdata
	 *
	 * @return void
	 */
	public function error($message, bool $flashdata = null)
	{
		if (is_array($message))
		{
			$this->errors = array_merge($this->errors, $message);
		}
		else
		{
			$this->errors[] = $message;
		}

		if ($flashdata)
		{
			if (is_array($message))
			{
				$this->flashErrors = array_merge($this->flashErrors, $message);
			}
			else
			{
				$this->flashErrors[] = $message;
			}

			$this->session->set('errors', $this->flashErrors);
			$this->session->setFlashdata('errors');
		}
	}

	/**
	 * Keep Errors
	 *
	 * Keeps the flashdata errors for one more page refresh.  Optionally adds the default errors into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all errors and not let them expire as intended.
	 * Benefitial when using Ajax Requests
	 *
	 * @param boolean $includeNonFlash Wheter to store basic errors as flashdata
	 *
	 * @return void
	 */
	public function keepErrors(bool $includeNonFlash = null)
	{
		if ($includeNonFlash)
		{
			$this->flashErrors = array_merge($this->flashErrors, $this->errors);
		}

		$this->flashErrors = array_merge($this->flashErrors, (array)$this->session->getFlashdata('errors'));
		$this->session->set('errors', $this->flashErrors);
		$this->session->setFlashdata('errors');
	}

	/**
	 * Get Errors Array
	 *
	 * Return array of errors
	 *
	 * @return array
	 */
	public function getErrorsArray()
	{
		return $this->errors;
	}

	/**
	 * Printeger Errors
	 *
	 * Prints string of errors separated by delimiter
	 *
	 * @param string  $divider Separator for error
	 * @param boolean $return  Whether to return instead of echoing
	 *
	 * @return void|string
	 */
	public function printErrors(string $divider = '<br />', bool $return = null)
	{
		$msg = implode($divider, $this->errors);

		if ($return)
		{
			return $msg;
		}

		echo $msg;
	}

	/**
	 * Clear Errors
	 *
	 * Removes errors from error list and clears all associated flashdata
	 *
	 * @return void
	 */
	public function clearErrors()
	{
		$this->errors = [];
		$this->session->remove('errors');
	}

	/**
	 * Info
	 *
	 * Add message to info array and set flash data
	 *
	 * @param string  $message   Message to add to infos array
	 * @param boolean $flashdata Whether add $message to CI flashdata (deflault: FALSE)
	 *
	 * @return void
	 */
	public function info(string $message, bool $flashdata = null)
	{
		if (is_array($message))
		{
			$this->infos = array_merge($this->infos, $message);
		}
		else
		{
			$this->infos[] = $message;
		}

		if ($flashdata)
		{
			if (is_array($message))
			{
				$this->flashInfos = array_merge($this->flashInfos, $message);
			}
			else
			{
				$this->flashInfos[] = $message;
			}

			$this->session->set('infos', $this->flashInfos);
			$this->session->setFlashdata('infos');
		}
	}

	/**
	 * Keep Infos
	 *
	 * Keeps the flashdata infos for one more page refresh.  Optionally adds the default infos into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all infos and not let them expire as intended.
	 * Benefitial by using Ajax Requests
	 *
	 * @param boolean $includeNonFlash Wheter to store basic errors as flashdata
	 *
	 * @return void
	 */
	public function keepInfos(bool $includeNonFlash = null)
	{
		if ($includeNonFlash)
		{
			$this->flashInfos = array_merge($this->flashInfos, $this->infos);
		}

		$this->flashInfos = array_merge($this->flashInfos, (array)$this->session->getFlashdata('infos'));
		$this->session->set('infos', $this->flashInfos);
		$this->session->setFlashdata('infos');
	}

	/**
	 * Get Info Array
	 *
	 * Return array of infos
	 *
	 * @return array Array of messages, empty array if no errors
	 */
	public function getInfosArray()
	{
		return $this->infos;
	}

	/**
	 * Printeger Info
	 *
	 * Printeger string of info separated by delimiter
	 *
	 * @param string  $divider Separator for info
	 * @param boolean $return  Whether to return instead of echoing
	 *
	 * @return string|void
	 */
	public function printInfos(string $divider = '<br />', bool $return = null)
	{
		$msg = implode($divider, $this->infos);

		if ($return)
		{
			return $msg;
		}

		echo $msg;
	}

	/**
	 * Clear Info List
	 *
	 * Removes info messages from info list and clears all associated flashdata
	 *
	 * @return void
	 */
	public function clearInfos()
	{
		$this->infos = [];
		$this->session->remove('infos');
	}
}
