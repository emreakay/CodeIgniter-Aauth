<?php
/**
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like groupping,
 * access management, public access etc..
 *
 * @package    Aauth
 * @author     Magefly Team
 * @author     Jacob Tomlinson
 * @author     Tim Swagger (Renowne, LLC) <tim@renowne.com>
 * @author     Raphael Jackstadt <info@rejack.de>
 *
 * @copyright  2014-2017 Emre Akay
 * @copyright  2018 Magefly
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/magefly/CodeIgniter-Aauth
 * @version    3.0.0-pre
 */

namespace App\Libraries;
use \App\Models\Aauth\UserModel as UserModel;
use \App\Models\Aauth\LoginAttemptModel as LoginAttemptModel;
use \App\Models\Aauth\LoginTokenModel as LoginTokenModel;
use \App\Models\Aauth\UserVariableModel as UserVariableModel;
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
	function __construct()
	{
		$this->config = new \Config\Aauth();
		$this->session = \Config\Services::session();
	}

	/**
	 * Create user
	 *
	 * Creates a new user
	 *
	 * @param string $email User's email address
	 * @param string $password User's password
	 * @param string $username User's username
	 *
	 * @return int|bool False if create fails or returns user id if successful
	 */
	public function createUser($email, $password, $username = null)
	{
		$userModel = new UserModel();

		$data['email'] = $email;
		$data['password'] = $password;

		if ( ! is_null($username))
		{
			$data['username'] = $username;
		}

		if ($userId = $userModel->insert($data))
		{
			return $userId;
		}

		$this->error($userModel->errors());
		return false;
	}

	/**
	 * Update user
	 *
	 * Updates existing user details
	 *
	 * @param int $user_id User id to update
	 * @param string|bool $email User's email address, or FALSE if not to be updated
	 * @param string|bool $password User's password, or FALSE if not to be updated
	 * @param string|bool $name User's name, or FALSE if not to be updated
	 *
	 * @return bool Update fails/succeeds
	 */
	public function updateUser($userId, $email = null, $password = null, $username = null)
	{
		$userModel = new UserModel();
		$data = [];

		if ( ! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));
			return false;
		}
		else if ( ! is_null($email) && ! is_null($password) && ! is_null($username))
		{
			return false;
		}

		$data['id'] = $userId;

		if ( ! is_null($email))
		{
			$data['email'] = $email;
		}

		if ( ! is_null($password))
		{
			$data['password'] = $password;
		}

		if ( ! is_null($username))
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
	 * @param intger $userId User id to delete
	 *
	 * @return boolen Indicates successful delete
	 */
	public function deleteUser(int $userId)
	{
		$userModel = new UserModel();
		$data = [];

		if ( ! $userModel->existsById($userId))
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
	 * @todo bool|int $group_par Specify group id to list group or FALSE for all users
	 *
	 * @param string $limit Limit of users to be returned
	 * @param bool $offset Offset for limited number of users
	 * @param bool $include_banneds Include banned users
	 * @param string $sort Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listUsers($limit = 0, $offset = 0, $includeBanneds = null, $orderBy = null)
	{
		$userModel = new UserModel();
		$options = [];
		$user = $userModel->limit($limit, $offset);

		// bool $group_par = null,

		if (is_null($includeBanneds))
		{
			$user->where('banned', 0);
		}

		if ( ! is_null($orderBy))
		{
			$user->orderBy($orderBy[0], $orderBy[1]);
		}

		return $user->findAll();
	}


	/**
	 * Login user
	 *
	 * Check provided details against the database. Add items to error array on fail, create session if success
	 *
	 * @todo add TOTP
	 * @todo add reCAPTCHA
	 *
	 * @param string $email
	 * @param string $pass
	 * @param bool $remember
	 * @param bool $totpCode
	 *
	 * @return bool Indicates successful login.
	 */
	public function login(string $identifier, string $password, bool $remember = null, bool $totpCode = null)
	{
		$userModel = new UserModel();
		$loginAttemptModel = new LoginAttemptModel();
		$userVariableModel = new UserVariableModel();
		helper('cookie');
		delete_cookie('user');

		if ($this->config->loginProtection && ! $loginAttemptModel->update())
		{
			$this->error(lang('Aauth.loginAttemptsExceeded'));
			return false;
		}

		// if($this->config->ddos_protection && $this->config->recaptcha_active && $loginAttempts->get() > $this->config->recaptcha_login_attempts){
		// 	$this->CI->load->helper('recaptchalib');
		// 	$reCaptcha = new ReCaptcha( $this->config->recaptcha_secret);
		// 	$resp = $reCaptcha->verifyResponse( $this->CI->input->server("REMOTE_ADDR"), $this->CI->input->post("g-recaptcha-response") );
		// 	if( ! $resp->success){
		// 		$this->error($this->CI->lang->line('aauth_error_recaptcha_not_correct'));
		// 		return false;
		// 	}
		// }

		if ($this->config->loginUseUsername)
		{
			if ( ! $identifier OR strlen($password) < $this->config->passwordMin OR strlen($password) > $this->config->passwordMax)
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

			if ( ! $validation->check($identifier, 'valid_email') OR strlen($password) < $this->config->passwordMin OR strlen($password) > $this->config->passwordMax)
			{
				$this->error(lang('Aauth.loginFailedEmail'));
				return false;
			}

			if ( ! $user = $userModel->where('email', $identifier)->first())
			{
				$this->error(lang('Aauth.notFoundUser'));
				return false;
			}
		}


		if ($user['banned'] && ! empty($userVariableModel->get($user['id'], 'verification_code', true)))
		{
			$this->error(lang('Aauth.notVerified'));
			return false;
		}
		else if ($user['banned'])
		{
			$this->error(lang('Aauth.invalidUserBanned'));
			return false;
		}

		if ($this->config->totpEnabled && ! $this->config->totpOnIpChange && $this->config->totpLogin)
		{
			if ($this->config->totpLogin == true)
			{
				$this->session->set('totp_required', true);
			}

			$totp_secret =  $userVariableModel->get($user['id'], 'totp_secret', true);
			if ( ! empty($totp_secret) && ! $totp_code) {
				$this->error(lang('Aauth.requiredTOTPCode'));
				return false;
			} else {
				if( ! empty($totp_secret)){
					$this->CI->load->helper('googleauthenticator');
					$ga = new PHPGangsta_GoogleAuthenticator();
					$checkResult = $ga->verifyCode($totp_secret, $totp_code, 0);
					if ( ! $checkResult) {
						$this->error(lang('Aauth.invalidTOTPCode'));
						return false;
					}
				}
			}
		}
		else if ($this->config->totpEnabled && $this->config->totpOnIpChange)
		{
			$query = null;
			$query = $this->aauth_db->where($db_identifier, $identifier);
			$query = $this->aauth_db->get($this->config->users);
			$totp_secret =  $query->row()->totp_secret;
			$ip_address = $query->row()->ip_address;
			$current_ip_address = $this->CI->input->ip_address();
			if ($query->num_rows() > 0 AND !$totp_code) {
				if($ip_address != $current_ip_address ){
					if($this->config->totpLogin == false){
						$this->error($this->CI->lang->line('aauth_error_totp_code_required'));
						return false;
					} else if($this->config->totpLogin == true){
						$this->session->set('totp_required', true);
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
							return false;
						}
					}
				}
			}
		}

		if ( ! $user['banned'] && password_verify($password, $user['password']))
		{
			$data = [
				'id' => $user['id'],
				'username' => $user['username'],
				'email' => $user['email'],
				'loggedIn' => true
			];
			$this->session->set($data);

			if ($remember)
			{
				$loginTokenModel = new LoginTokenModel();
				helper('text');
				$expire = $this->config->loginRemember;
				$userId = base64_encode($user['id']);
				$randomString = random_string('alnum', 32);
				$selectorString = random_string('alnum', 16);
				$cookieData = [
					'name'	 => 'remember',
					'value'	 => $userId.';'.$randomString.';'.$selectorString,
					'expire' => YEAR,
				];
				$tokenData = [
					'user_id' => $user['id'],
					'random_hash' => password_hash($randomString, PASSWORD_DEFAULT),
					'selector_hash' => password_hash($selectorString, PASSWORD_DEFAULT),
					'expires_at' => date("Y-m-d H:i:s", strtotime($expire)),
				];

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
	 * @param int $userId User id to log in
	 *
	 * @return bool TRUE if login successful.
	 */
	private function loginFast($userId)
	{
		$userModel = new UserModel();
		$userModel->select('id, email, username');
		$userModel->where('id', $userId);
		$userModel->where('banned', 0);

		if ($user = $userModel->get()->getFirstRow())
		{
			$this->session->set([
				'id' => $user->id,
				'username' => $user->username,
				'email' => $user->email,
				'loggedIn' => true,
			]);

			return true;
		}

		return false;
	}

	/**
	 * Check user login
	 * Checks if user logged in, also checks remember.
	 * @return bool
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
			$cookie = explode(';', $cookie);
			$cookie[0] = base64_decode($cookie[0]);

			if ( ! is_numeric($cookie[0]) OR strlen($cookie[1]) != 32 OR strlen($cookie[2]) != 16)
			{
				return false;
			}
			else
			{
				$loginTokenModel = new LoginTokenModel();
				$loginTokens = $loginTokenModel->getAllByUserId($cookie[0]);

				foreach ($loginTokens as $loginToken)
				{
					if (password_verify($cookie[1], $loginToken['random_hash']) && password_verify($cookie[2], $loginToken['selector_hash']))
					{
						if (strtotime($loginToken['expires_at']) > strtotime("now"))
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
	 * @param string $message Message to add to array
	 * @param bool $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function error($message = '', $flashdata = null)
	{
		$this->errors[] = $message;

		if ($flashdata)
		{
			$this->flashErrors[] = $message;
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
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 *
	 * @param bool $include_non_flash TRUE if it should stow basic errors as flashdata (default = FALSE)
	 */
	public function keepErrors($includeNonFlash = null)
	{
		if ($includeNonFlash)
			$this->flashErrors = array_merge($this->flashErrors, $this->errors);

		$this->flashErrors = array_merge($this->flashErrors, (array)$this->session->getFlashdata('errors'));
		$this->session->set('errors', $this->flashErrors);
		$this->session->setFlashdata('errors');
	}

	/**
	 * Get Errors Array
	 *
	 * Return array of errors
	 *
	 * @return array Array of messages, empty array if no errors
	 */
	public function getErrorsArray()
	{
		return $this->errors;
	}

	/**
	 * Print Errors
	 *
	 * Prints string of errors separated by delimiter
	 *
	 * @param string $divider Separator for errors
	 */
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

	/**
	 * Clear Errors
	 *
	 * Removes errors from error list and clears all associated flashdata
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
	 * @param string $message Message to add to infos array
	 * @param boolean $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function info($message = '', $flashdata = null)
	{
		$this->infos[] = $message;

		if ($flashdata)
		{
			$this->flashInfos[] = $message;
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
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 *
	 * @param boolean $include_non_flash TRUE if it should stow basic infos as flashdata (default = FALSE)
	 */
	public function keepInfos($includeNonFlash = null)
	{
		if ($includeNonFlash)
			$this->flashInfos = array_merge($this->flashInfos, $this->infos);

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
	 * Print Info
	 *
	 * Print string of info separated by delimiter
	 *
	 * @param string $divider Separator for info
	 *
	 */
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

	/**
	 * Clear Info List
	 *
	 * Removes info messages from info list and clears all associated flashdata
	 */
	public function clearInfos()
	{
		$this->infos = [];
		$this->session->remove('infos');
	}
}
