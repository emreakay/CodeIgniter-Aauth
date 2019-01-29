<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like grouping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Emre Akay
 * @author    Raphael "REJack" Jackstadt
 * @copyright 2014-2019 Emre Akay
 * @license   https://opensource.org/licenses/MIT   MIT License
 * @link      https://github.com/emreakay/CodeIgniter-Aauth
 */

namespace App\Libraries;

use \App\Models\Aauth\UserModel;
use \App\Models\Aauth\UserVariableModel;
use \App\Models\Aauth\UserSessionModel;
use \App\Models\Aauth\LoginAttemptModel;
use \App\Models\Aauth\LoginTokenModel;
use \App\Models\Aauth\GroupModel;
use \App\Models\Aauth\GroupToGroupModel;
use \App\Models\Aauth\GroupToUserModel;
use \App\Models\Aauth\GroupVariableModel;
use \App\Models\Aauth\PermModel;
use \App\Models\Aauth\PermToGroupModel;
use \App\Models\Aauth\PermToUserModel;

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
	protected $config;

	/**
	 * Variable for loading the app config array into
	 *
	 * @var \Config\App
	 */
	protected $configApp;

	/**
	 * Variable for loading the session service into
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Array to store error messages
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Local temporary storage for current flash errors
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 *
	 * @var array
	 */
	protected $flashErrors = [];

	/**
	 * Array to store info messages
	 *
	 * @var array
	 */
	protected $infos = [];

	/**
	 * Local temporary storage for current flash infos
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 *
	 * @var array
	 */
	protected $flashInfos = [];

	/**
	 * Array to cache permission-ids.
	 *
	 * @var array
	 */
	protected $cachePermIds;

	/**
	 * Array to cache group-ids.
	 *
	 * @var array
	 */
	protected $cacheGroupIds;

	/**
	 * Constructor
	 *
	 * Prepares config & session variable.
	 */
	public function __construct($config = null, $session = null)
	{
		if (is_null($config))
		{
			$config = new \Config\Aauth();
		}

		if (is_null($session))
		{
			$session = \Config\Services::session();
		}

		$this->configApp = new \Config\App();
		$this->config    = $config;
		$this->session   = $session;

		$this->cachePermIds  = [];
		$this->cacheGroupIds = [];

		$this->precachePerms();
		$this->precacheGroups();
	}

	//--------------------------------------------------------------------
	// Caching Functions
	//--------------------------------------------------------------------

	/**
	 * PreCache Perms
	 *
	 * Caches all permission IDs for later use.
	 */
	private function precachePerms()
	{
		$permModel = new PermModel();

		foreach ($permModel->asArray()->findAll() as $perm)
		{
			$key                      = str_replace(' ', '', trim(strtolower($perm['name'])));
			$this->cachePermIds[$key] = $perm['id'];
		}
	}

	/**
	 * PreCache Groups
	 *
	 * Caches all group IDs for later use.
	 */
	private function precacheGroups()
	{
		$groupModel = new GroupModel();

		foreach ($groupModel->asArray()->findAll() as $group)
		{
			$key                       = str_replace(' ', '', trim(strtolower($group['name'])));
			$this->cacheGroupIds[$key] = $group['id'];
		}
	}

	//--------------------------------------------------------------------
	// Login Functions
	//--------------------------------------------------------------------

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
	 * @return boolean
	 */
	public function login(string $identifier, string $password, bool $remember = null, string $totpCode = null)
	{
		helper('cookie');
		delete_cookie($this->config->loginRememberCookie);

		$userModel         = new UserModel();
		$loginAttemptModel = new LoginAttemptModel();
		$userVariableModel = new UserVariableModel();

		if ($this->config->loginProtection && ! $loginAttemptModel->save())
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
				$this->error(lang('Aauth.loginFailedUsername'));

				return false;
			}

			if (! $user = $userModel->where('username', $identifier)->asArray()->first())
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

			if (! $user = $userModel->where('email', $identifier)->asArray()->first())
			{
				$this->error(lang('Aauth.notFoundUser'));

				return false;
			}
		}

		if (! empty($userVariableModel->find($user['id'], 'verification_code', true)))
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

		if (password_verify($password, $user['password']))
		{
			$loginTokenModel = new LoginTokenModel();

			if ($this->config->loginSingleMode)
			{
				$loginTokenModel->deleteAll($user['id']);
				$userSessionModel = new UserSessionModel();
				foreach ($userSessionModel->findAll() as $userSessionRow)
				{
					$result      = $matches = [];
					$sessionData = ';' . $userSessionRow['data'];
					$keyreg      = '/;([^|{}"]+)\|/';

					preg_match_all($keyreg, $sessionData, $matches);

					if (isset($matches[1]))
					{
						$keys   = $matches[1];
						$values = preg_split($keyreg, $sessionData);

						if (count($values) > 1)
						{
							array_shift($values);
						}

						$result      = array_combine($keys, $values);
						$userSession = unserialize($result['user']);

						if ($userSession['id'] === $user['id'])
						{
							$userSessionModel->delete($userSessionRow['id']);
						}
					}
				}
			}

			$data['id']       = $user['id'];
			$data['username'] = $user['username'];
			$data['email']    = $user['email'];
			$data['loggedIn'] = true;
			$this->session->set('user', $data);

			if ($remember)
			{
				helper('text');
				$expire         = $this->config->loginRemember;
				$userId         = base64_encode($user['id']);
				$randomString   = random_string('alnum', 32);
				$selectorString = random_string('alnum', 16);

				$cookieData['name']   = $this->config->loginRememberCookie;
				$cookieData['value']  = $userId . ';' . $randomString . ';' . $selectorString;
				$cookieData['expire'] = YEAR;

				$tokenData['user_id']       = $user['id'];
				$tokenData['random_hash']   = password_hash($randomString, PASSWORD_DEFAULT);
				$tokenData['selector_hash'] = password_hash($selectorString, PASSWORD_DEFAULT);
				$tokenData['expires_at']    = date('Y-m-d H:i:s', strtotime($expire));

				set_cookie($cookieData);
				$loginTokenModel->insert($tokenData);
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
			if ($this->config->loginAccurateErrors)
			{
				if ($this->config->loginUseUsername)
				{
					$this->error(lang('Aauth.loginFailedUsername'));
				}
				else
				{
					$this->error(lang('Aauth.loginFailedEmail'));
				}
			}
			else
			{
				$this->error(lang('Aauth.loginFailedAll'));
			}
			return false;
		}
	}

	/**
	 * Logout
	 *
	 * Deletes session and cookie
	 *
	 * @return void
	 */
	public function logout()
	{
		helper('cookie');
		set_cookie($this->config->loginRememberCookie, '', -3600);
		$this->session->remove('user');
		@$this->session->destroy();
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
	protected function loginFast(int $userId)
	{
		$userModel = new UserModel();
		$userModel->select('id, email, username');
		$userModel->where('id', $userId);
		$userModel->where('banned', 0);

		if (! $user = $userModel->asArray()->first())
		{
			return false;
		}

		$this->session->set('user', [
			'id'       => $user['id'],
			'username' => $user['username'],
			'email'    => $user['email'],
			'loggedIn' => true,
		]);

		return true;
	}

	//--------------------------------------------------------------------
	// Access Functions
	//--------------------------------------------------------------------

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

		if (isset($this->session->get('user')['loggedIn']))
		{
			return true;
		}
		else if ($cookie = get_cookie($this->config->loginRememberCookie))
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
				$loginTokens     = $loginTokenModel->findAllByUserId($cookie[0]);

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
							$loginTokenModel->deleteExpired($cookie[0]);
							delete_cookie($this->config->loginRememberCookie);
						}
					}
				}
			}
		}

		return false;
	}

	/**
	 * Is member
	 *
	 * @param integer|string $groupPar Group id or name to check
	 * @param integer        $userId   User id, if not given current user
	 *
	 * @return boolean
	 */
	public function isMember($groupPar, int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$groupToUserModel = new GroupToUserModel();

		$groupId = $this->getGroupId($groupPar);

		return $groupToUserModel->exists($groupId, $userId);
	}

	/**
	 * Is admin
	 *
	 * @param integer $userId User id to check, if it is not given checks current user
	 *
	 * @return boolean
	 */
	public function isAdmin(int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		return $this->isMember($this->config->groupAdmin, $userId);
	}

	/**
	 * Is user allowed
	 *
	 * Check if user allowed to do specified action, admin always allowed
	 * first checks user permissions then check group permissions
	 *
	 * @param integer|string $permPar Permission id or name to check
	 * @param integer|null   $userId  User id to check, or if false checks current user
	 *
	 * @return boolean
	 */
	public function isAllowed($permPar, int $userId = null)
	{
		// if($this->CI->session->userdata('totp_required')){
		// 	$this->error($this->CI->lang->line('aauth_error_totp_verification_required'));
		// 	redirect($this->config_vars['totp_two_step_login_redirect']);
		// }

		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return false;
		}
		else if ($this->isAdmin($userId))
		{
			return true;
		}
		else
		{
			if (! $permId = $this->getPermId($permPar))
			{
				return false;
			}

			$permToUserModel = new PermToUserModel();

			if ($permToUserModel->allowed($permId, $userId))
			{
				return true;
			}
			else
			{
				$groupAllowed = false;

				foreach ($this->listUserGroups($userId) as $group)
				{
					if ($this->isGroupAllowed($permId, $group['id']))
					{
						$groupAllowed = true;
						break;
					}
				}

				return $groupAllowed;
			}
		}
	}

	/**
	 * Is Group allowed
	 *
	 * Check if group is allowed to do specified action, admin always allowed
	 *
	 * @param integer        $permPar  Permission id or name to check
	 * @param integer|string $groupPar Group id or name to check, or if false checks all user groups
	 *
	 * @return boolean
	 */
	public function isGroupAllowed($permPar, $groupPar = null)
	{
		if (! $permId = $this->getPermId($permPar))
		{
			return false;
		}

		if ($groupPar)
		{
			if (strcasecmp($groupPar, $this->config->groupAdmin) === 0)
			{
				return true;
			}

			$permToGroupModel = new PermToGroupModel();
			$groupId          = $this->getGroupId($groupPar);
			$groupAllowed     = false;

			if ($subgroups = $this->getSubgroups($groupId))
			{
				foreach ($subgroups as $group)
				{
					if (! $groupAllowed)
					{
						if ($this->isGroupAllowed($permId, $group['subgroup_id']))
						{
							$groupAllowed = true;
						}
					}
				}
			}

			if ($groupAllowed || $permToGroupModel->allowed($permId, $groupId))
			{
				return true;
			}
			else if (! $groupAllowed)
			{
				return false;
			}
		}
		else
		{
			if ($this->isAdmin() || $this->isGroupAllowed($permId, $this->config->groupPublic))
			{
				return true;
			}
			else if (! $this->isLoggedIn())
			{
				return false;
			}

			foreach ($this->listUserGroups() as $group)
			{
				if ($this->isGroupAllowed($permId, $group['id']))
				{
					return true;
				}
			}
		}

		return false;
	}

	//--------------------------------------------------------------------
	// User Functions
	//--------------------------------------------------------------------

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
			$this->error(array_values($userModel->errors()));

			return false;
		}

		// if ($this->config->userVerification)
		// {
		// 	$this->sendVerification($userId, $email);
		// 	$this->info(lang('Aauth.infoCreateVerification'));

		// 	return $userId;
		// }

		$this->info(lang('Aauth.infoCreateSuccess'));

		return $userId;
	}

	/**
	 * Update user
	 *
	 * Updates existing user details
	 *
	 * @param integer        $userId   User id to update
	 * @param string|boolean $email    User's email address, or false if not to be updated
	 * @param string|boolean $password User's password, or false if not to be updated
	 * @param string|boolean $username User's name, or false if not to be updated
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
		else if (is_null($email) && is_null($password) && is_null($username))
		{
			return true;
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

		if (! $userModel->update($userId, $data))
		{
			$this->error(array_values($userModel->errors()));

			return false;
		}

		$this->info(lang('Aauth.infoUpdateSuccess'));

		return true;
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
		$userModel        = new UserModel();
		$groupToUserModel = new GroupToUserModel();
		$permToUserModel  = new PermToUserModel();

		if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		$userModel->transStart();
		$groupToUserModel->deleteAllByUserId($userId);
		$permToUserModel->deleteAllByUserId($userId);
		$userModel->delete($userId);
		$userModel->transComplete();

		if ($userModel->transStatus() === false)
		{
			$userModel->transRollback();

			return false;
		}
		else
		{
			$userModel->transCommit();

			return true;
		}
	}

	/**
	 * List users
	 *
	 * Return users as an object array
	 *
	 * @param string|integer $groupPar       Specify group id to list group or null for all users
	 * @param integer        $limit          Limit of users to be returned
	 * @param integer        $offset         Offset for limited number of users
	 * @param boolean        $includeBanneds Include banned users
	 * @param string         $orderBy        Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listUsers($groupPar = null, int $limit = 0, int $offset = 0, bool $includeBanneds = null, string $orderBy = null)
	{
		$userModel = new UserModel();
		$userModel->limit($limit, $offset);

		$userModel->select('id, email, username, banned, created_at, updated_at, last_activity, last_ip_address, last_login');

		if ($groupPar && $groupId = $this->getGroupId($groupPar))
		{
			$userModel->join($this->config->dbTableGroupToUser, $this->config->dbTableGroupToUser . '.user_id = ' . $this->config->dbTableUsers . '.id');
			$userModel->where($this->config->dbTableGroupToUser . '.group_id', $groupId);
		}

		if (is_null($includeBanneds))
		{
			$userModel->where('banned', 0);
		}

		if (! is_null($orderBy))
		{
			$userModel->orderBy($orderBy);
		}

		return $userModel->findAll();
	}

	/**
	 * List users with paginate
	 *
	 * Return users as an object array
	 *
	 * @param string|integer $groupPar       Specify group id to list group or null for all users
	 * @param integer        $limit          Limit of users to be returned
	 * @param integer        $offset         Offset for limited number of users
	 * @param boolean        $includeBanneds Include banned users
	 * @param string         $orderBy        Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listUsersPaginated($groupPar = null, int $limit = 10, bool $includeBanneds = null, string $orderBy = null)
	{
		$userModel = new UserModel();

		$userModel->select('id, email, username, banned, created_at, updated_at, last_activity, last_ip_address, last_login');

		if ($groupPar && $groupId = $this->getGroupId($groupPar))
		{
			$userModel->join($this->config->dbTableGroupToUser, $this->config->dbTableGroupToUser . '.user_id = ' . $this->config->dbTableUsers . '.id');
			$userModel->where($this->config->dbTableGroupToUser . '.group_id', $groupId);
		}

		if (is_null($includeBanneds))
		{
			$userModel->where('banned', 0);
		}

		if (! is_null($orderBy))
		{
			$userModel->orderBy($orderBy);
		}

		return [
			'users' => $userModel->paginate($limit),
			'pager' => $userModel->pager,
		];
	}

	/**
	 * Send verification email
	 *
	 * Sends a verification email based on user id
	 *
	 * @param integer $userId User id to send verification email to
	 * @param string  $email  Email to send verification email to
	 *
	 * @return boolean
	 */
	// protected function sendVerification(int $userId, string $email)
	// {
	// 	helper('text');
	// 	$userVariableModel = new UserVariableModel();
	// 	$emailService      = \Config\Services::email();
	// 	$verificationCode  = sha1(strtotime('now'));

	// 	$userVariableModel->save($userId, 'verification_code', $verificationCode, true);

	// 	$messageData['code'] = $verificationCode;
	// 	$messageData['link'] = site_url($this->config->linkVerification . '/' . $userId . '/' . $verificationCode);

	// 	$emailService->initialize(isset($this->config->emailConfig) ? $this->config->emailConfig : []);
	// 	$emailService->setFrom($this->config->emailFrom, $this->config->emailFromName);
	// 	$emailService->setTo($email);
	// 	$emailService->setSubject(lang('Aauth.subjectVerification'));
	// 	$emailService->setMessage(view('Aauth/Verification', $messageData));

	// 	return $emailService->send();
	// }

	/**
	 * Verify user
	 *
	 * Activates user account based on verification code
	 *
	 * @param string $verificationCode Code to validate against
	 *
	 * @return boolean Activation fails/succeeds
	 */
	public function verifyUser(string $verificationCode)
	{
		$userVariableModel = new UserVariableModel();
		$userVariable      = [
			'data_key'   => 'verification_code',
			'data_value' => $verificationCode,
			'system'     => 1,
		];

		if (! $verificationCodeStored = $userVariableModel->where($userVariable)->asArray()->first())
		{
			$this->error(lang('Aauth.invalidVerficationCode'));

			return false;
		}

		$userVariableModel->delete($verificationCodeStored['user_id'], 'verification_code', true);
		$this->info(lang('Aauth.infoVerification'));

		return true;
	}

	/**
	 * Get user
	 *
	 * Get user information
	 *
	 * @param integer|boolean $userId        User id to get or false for current user
	 * @param boolean         $withVariables Whether to get user variables
	 * @param boolean         $inclSystem    Whether to get system user variables
	 *
	 * @return object|boolean User information or false if user not found
	 */
	public function getUser(int $userId = null, bool $withVariables = false, bool $inclSystem = false)
	{
		$userModel         = new UserModel();
		$userVariableModel = new UserVariableModel();

		$userModel->select('id, email, username, banned, created_at, updated_at, last_activity, last_ip_address, last_login');

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $user = $userModel->find($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		if ($withVariables)
		{
			$userVariableModel->select('data_key, data_value' . ($inclSystem ? ', system' : ''));
			$variables = $userVariableModel->findAll($userId, $inclSystem);

			$user['variables'] = $variables;
		}

		return $user;
	}

	/**
	 * Get user id
	 *
	 * Get user id from email address, if par. not given, return current user's id
	 *
	 * @param string|boolean $email Email address for user,
	 *
	 * @return object|boolean User information or false if user not found
	 */
	public function getUserId(string $email = null)
	{
		$userModel = new UserModel();

		if (! $email)
		{
			$where = ['id' => $this->session->user['id']];
		}
		else
		{
			$where = ['email' => $email];
		}

		if (! $user = $userModel->where($where)->asArray()->first())
		{
			return false;
		}

		return $user['id'];
	}

	/**
	 * Get active users count
	 *
	 * @return integer Count of active users
	 */
	public function getActiveUsersCount()
	{
		$userSessionModel = new UserSessionModel();

		return count($userSessionModel->findAll());
	}

	/**
	 * List active users
	 *
	 * Return users as an object array
	 *
	 * @return array Array of active users
	 */
	public function listActiveUsers()
	{
		$userSessionModel = new UserSessionModel();

		$usersIds = [];

		foreach ($userSessionModel->findAll() as $userSession)
		{
			$result = $matches = [];
			$data   = ';' . $userSession['data'];
			$keyreg = '/;([^|{}"]+)\|/';

			preg_match_all($keyreg, $data, $matches);

			if (isset($matches[1]))
			{
				$keys   = $matches[1];
				$values = preg_split($keyreg, $data);

				if (count($values) > 1)
				{
					array_shift($values);
				}

				$result = array_combine($keys, $values);
			}

			$user       = unserialize($result['user']);
			$usersIds[] = $user['id'];
		}

		if (count($usersIds) === 0)
		{
			return [];
		}

		$userModel = new UserModel();

		$userModel->select('id, email, username, banned, created_at, updated_at, last_activity, last_ip_address, last_login');

		$userModel->whereIn('id', $usersIds);

		return $userModel->findAll();
	}

	/**
	 * Is banned
	 *
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean
	 */
	public function isBanned(int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return true;
		}

		return $userModel->isBanned($userId);
	}

	/**
	 * Ban User
	 *
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean
	 */
	public function banUser(int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		return $userModel->updateBanned($userId, 1);
	}

	/**
	 * Unban User
	 *
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean
	 */
	public function unbanUser(int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		return $userModel->updateBanned($userId, 0);
	}

	/**
	 * Remind password
	 *
	 * Emails user with link to reset password
	 *
	 * @param string $email Email for account to remind
	 *
	 * @return boolean Remind fails/succeeds
	 */
	public function remindPassword(string $email)
	{
		$userModel = new UserModel();

		if (! $user = $userModel->where('email', $email)->getFirstRow('array'))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		$userVariableModel = new UserVariableModel();
		$emailService      = \Config\Services::email();
		$resetCode         = sha1(strtotime('now'));
		$userVariableModel->save($user['id'], 'verification_code', $resetCode, true);

		$messageData['code'] = $resetCode;
		$messageData['link'] = site_url($this->config->linkResetPassword . '/' . $resetCode);

		$emailService->initialize(isset($this->config->emailConfig) ? $this->config->emailConfig : []);
		$emailService->setFrom($this->config->emailFrom, $this->config->emailFromName);
		$emailService->setTo($user['email']);
		$emailService->setSubject(lang('Aauth.subjectReset'));
		$emailService->setMessage(view('Aauth/RemindPassword', $messageData));

		if (! $email = $emailService->send())
		{
			$this->error(explode('<br />', $emailService->printDebugger([])));

			return false;
		}

		$this->info(lang('Aauth.infoRemindSuccess'));

		return $email;
	}

	/**
	 * Reset password
	 *
	 * Generate new password and email it to the user
	 *
	 * @param string $resetCode Verification code for account
	 *
	 * @return boolean Password reset fails/succeeds
	 */
	public function resetPassword(string $resetCode)
	{
		$userVariableModel = new UserVariableModel();
		$variable          = [
			'data_key'   => 'verification_code',
			'data_value' => $resetCode,
			'system'     => 1,
		];

		if (! $userVariable = $userVariableModel->where($variable)->getFirstRow('array'))
		{
			$this->error(lang('Aauth.invalidVerficationCode'));

			return false;
		}

		helper('text');
		$userModel = new UserModel();
		$password  = random_string('alnum', $this->config->passwordMin);

		if (! $user = $userModel->find($userVariable['user_id']))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}

		$emailService = \Config\Services::email();

		$data['id']       = $user['id'];
		$data['password'] = $password;

		$userModel->update($user['id'], $data);
		$userVariableModel->delete($user['id'], 'verification_code', true);

		if ($this->config->totpEnabled && $this->config->totpResetPassword)
		{
			$userVariableModel->delete($user['id'], 'totp_secret', true);
		}

		$messageData['password'] = $password;

		$emailService->initialize(isset($this->config->emailConfig) ? $this->config->emailConfig : []);
		$emailService->setFrom($this->config->emailFrom, $this->config->emailFromName);
		$emailService->setTo($user['email']);
		$emailService->setSubject(lang('Aauth.subjectResetSuccess'));
		$emailService->setMessage(view('Aauth/ResetPassword', $messageData));

		if (! $email = $emailService->send())
		{
			$this->error(explode('<br />', $emailService->printDebugger([])));

			return false;
		}

		$this->info(lang('Aauth.infoResetSuccess'));

		return $email;
	}

	/**
	 * Set User Variable as key value
	 *
	 * if variable not set before, it will be set
	 * if set, overwrites the value
	 *
	 * @param string  $key
	 * @param string  $value
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean
	 */
	public function setUserVar(string $key, string $value, int $userId = null)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$userVariableModel = new UserVariableModel();

		return $userVariableModel->save($userId, $key, $value);
	}

	/**
	 * Unset User Variable as key value
	 *
	 * @param string  $key
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean
	 */
	public function unsetUserVar(string $key, int $userId = null)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$userVariableModel = new UserVariableModel();

		return $userVariableModel->delete($userId, $key);
	}

	/**
	 * Get User Variable by key
	 *
	 * @param string  $key    Variable Key
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean|string false if var is not set, the value of var if set
	 */
	public function getUserVar(string $key, int $userId = null)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$userVariableModel = new UserVariableModel();

		if (! $variable = $userVariableModel->find($userId, $key))
		{
			return false;
		}

		return $variable;
	}

	/**
	 * Get User Variables by user id
	 *
	 * Return array with all user keys & variables
	 *
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean|array , false if var is not set, the value of var if set
	 */
	public function getUserVars(int $userId = null)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$userVariableModel = new UserVariableModel();

		return $userVariableModel->findAll($userId);
	}

	/**
	 * List User Variable Keys by UserId
	 *
	 * Return array of variable keys or false
	 *
	 * @param integer $userId User id, can be null to use session user
	 *
	 * @return boolean|array
	 */
	public function listUserVarKeys(int $userId = null)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$userVariableModel = new UserVariableModel();
		$userVariableModel->select('data_key as key');

		return $userVariableModel->findAll($userId);
	}

	//--------------------------------------------------------------------
	// Group Functions
	//--------------------------------------------------------------------

	/**
	 * Create group
	 *
	 * @param string $groupName  New group name
	 * @param string $definition Description of the group
	 *
	 * @return integer|boolean Group id or false on fail
	 */
	public function createGroup(string $name, string $definition = '')
	{
		$groupModel = new GroupModel();

		$data['name']       = $name;
		$data['definition'] = $definition;

		if (! $groupId = $groupModel->insert($data))
		{
			$this->error(array_values($groupModel->errors()));

			return false;
		}

		$this->precacheGroups();

		return $groupId;
	}

	/**
	 * Update group
	 *
	 * @param string|integer $groupPar   Group id or name
	 * @param string         $name       New group name
	 * @param string         $definition New group definition
	 *
	 * @return boolean Update success/failure
	 */
	public function updateGroup($groupPar, string $name = null, string $definition = null)
	{
		$groupModel = new GroupModel();

		if (is_null($name) && is_null($definition))
		{
			return true;
		}
		else if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}

		$data['id'] = $groupId;

		if (! is_null($name))
		{
			$data['name'] = $name;
		}

		if (! is_null($definition))
		{
			$data['definition'] = $definition;
		}

		if (! $groupModel->update($groupId, $data))
		{
			$this->error(array_values($groupModel->errors()));

			return false;
		}

		$this->precacheGroups();

		return true;
	}

	/**
	 * Delete group
	 *
	 * @param string|integer $groupPar Group id or name
	 *
	 * @return boolean Delete success/failure
	 */
	public function deleteGroup($groupPar)
	{
		$groupModel        = new GroupModel();
		$groupToGroupModel = new GroupToGroupModel();
		$groupToUserModel  = new GroupToUserModel();
		$permToGroupModel  = new PermToGroupModel();

		if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}

		$groupModel->transStart();
		$groupToGroupModel->deleteAllByGroupId($groupId);
		$groupToGroupModel->deleteAllBySubgroupId($groupId);
		$groupToUserModel->deleteAllByGroupId($groupId);
		$permToGroupModel->deleteAllByGroupId($groupId);
		$groupModel->delete($groupId);
		$groupModel->transComplete();

		if ($groupModel->transStatus() === false)
		{
			$groupModel->transRollback();

			return false;
		}
		else
		{
			$groupModel->transCommit();
			$this->precacheGroups();

			return true;
		}
	}

	/**
	 * Add member to group
	 *
	 * @param integer        $userId   User id to add to group
	 * @param integer|string $groupPar Group id or name to add user to
	 *
	 * @return boolean Add success/failure
	 */
	public function addMember($groupPar, int $userId)
	{
		$userModel        = new UserModel();
		$groupToUserModel = new GroupToUserModel();

		if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}
		else if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}
		else if ($groupToUserModel->exists($groupId, $userId))
		{
			$this->info(lang('Aauth.alreadyMemberGroup'));

			return true;
		}

		return $groupToUserModel->insert($groupId, $userId);
	}

	/**
	 * Remove member from group
	 *
	 * @param integer        $userId   User id to remove from group
	 * @param integer|string $groupPar Group id or name to remove user from
	 *
	 * @return boolean Remove success/failure
	 */
	public function removeMember($groupPar, int $userId)
	{
		$groupToUserModel = new GroupToUserModel();

		$groupId = $this->getGroupId($groupPar);

		return $groupToUserModel->delete($groupId, $userId);
	}

	/**
	 * Get User Groups
	 *
	 * @param integer|string $userId User id
	 *
	 * @return object Array of group_id's
	 */
	public function getUserGroups($userId)
	{
		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$groupToUserModel = new GroupToUserModel();

		return $groupToUserModel->findAllByUserId($userId);
	}

	/**
	 * Get User Perms
	 *
	 * @param integer|string $userId User id
	 *
	 * @return object Array of perm_id's
	 */
	public function getUserPerms($userId, $state = null)
	{
		$userModel = new UserModel();

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$permToUserModel = new PermToUserModel();

		return $permToUserModel->findAllByUserId($userId, $state);
	}

	/**
	 * Add subgroup to group
	 *
	 * @param integer|string $groupPar    Group id
	 * @param integer|string $subgroupPar Subgroup id or name to add to group
	 *
	 * @return boolean Add success/failure
	 */
	public function addSubgroup($groupPar, $subgroupPar)
	{
		$groupModel        = new GroupModel();
		$groupToGroupModel = new GroupToGroupModel();

		if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}
		else if (! $subgroupId = $this->getGroupId($subgroupPar))
		{
			$this->error(lang('Aauth.notFoundSubgroup'));

			return false;
		}
		else if ($groupId === $subgroupId)
		{
			return false;
		}
		else if ($groupToGroupModel->exists($groupId, $subgroupId))
		{
			$this->info(lang('Aauth.alreadyMemberSubgroup'));

			return true;
		}

		if ($groupGroups = $groupToGroupModel->findAllByGroupId($groupId))
		{
			foreach ($groupGroups as $item)
			{
				if ($item['subgroup_id'] === $subgroupId)
				{
					return false;
				}
			}
		}

		if ($subgroupGroups = $groupToGroupModel->findAllByGroupId($subgroupId))
		{
			foreach ($subgroupGroups as $item)
			{
				if ($item['subgroup_id'] === $groupId)
				{
					return false;
				}
			}
		}

		return $groupToGroupModel->insert($groupId, $subgroupId);
	}

	/**
	 * Remove subgroup from group
	 *
	 * @param integer|string $groupPar    Group id or name to remove
	 * @param integer|string $subgroupPar Sub-Group id or name to remove
	 *
	 * @return boolean Remove success/failure
	 */
	public function removeSubgroup($groupPar, $subgroupPar)
	{
		$groupToGroupModel = new GroupToGroupModel();
		$groupId           = $this->getGroupId($groupPar);
		$subgroupId        = $this->getGroupId($subgroupPar);

		return $groupToGroupModel->delete($groupId, $subgroupId);
	}

	/**
	 * Get subgroups
	 *
	 * @param integer|string $groupPar Group id or name to get
	 *
	 * @return object Array of subgroup_id's
	 */
	public function getSubgroups($groupPar)
	{
		$groupModel = new GroupModel();

		if (! $groupId = $this->getGroupId($groupPar))
		{
			return false;
		}

		$groupToGroupModel = new GroupToGroupModel();

		return $groupToGroupModel->findAllByGroupId($groupId);
	}

	/**
	 * Get group perms
	 *
	 * @param integer|string $groupPar Group id or name to get
	 * @param integer        $state    State (1 = allowed, 0 = denied)
	 *
	 * @return object Array of subgroup_id's
	 */
	public function getGroupPerms($groupPar, int $state = null)
	{
		if (! $groupId = $this->getGroupId($groupPar))
		{
			return false;
		}

		$permToGroupModel = new PermToGroupModel();

		return $permToGroupModel->findAllByGroupId($groupId, $state);
	}

	/**
	 * Remove member from all groups
	 *
	 * @param integer $userId User id to remove from all groups
	 *
	 * @return boolean Remove success/failure
	 */
	public function removeMemberFromAll(int $userId)
	{
		$groupToUserModel = new GroupToUserModel();

		return $groupToUserModel->deleteAllByUserId($userId);
	}

	/**
	 * List all groups
	 *
	 * @return object Array of groups
	 */
	public function listGroups()
	{
		$groupModel = new GroupModel();

		return $groupModel->findAll();
	}

	/**
	 * List groups with paginate
	 *
	 * Return groups as an object array
	 *
	 * @param integer $limit   Limit of users to be returned
	 * @param string  $orderBy Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of groups
	 */
	public function listGroupsPaginated(int $limit = 10, string $orderBy = null)
	{
		$groupModel = new GroupModel();

		if (! is_null($orderBy))
		{
			$groupModel->orderBy($orderBy);
		}

		return [
			'groups' => $groupModel->paginate($limit),
			'pager'  => $groupModel->pager,
		];
	}

	/**
	 * Get group name
	 *
	 * @param integer $groupId Group id to get
	 *
	 * @return string Group name
	 */
	public function getGroupName($groupId)
	{
		$groupModel = new GroupModel();

		if (! $group = $groupModel->find($groupId))
		{
			return false;
		}

		return $group['name'];
	}

	/**
	 * Get group id
	 *
	 * @param integer|string $groupPar Group id or name to get
	 *
	 * @return integer Group id
	 */
	public function getGroupId($groupPar)
	{
		if (is_numeric($groupPar))
		{
			if (array_search($groupPar, $this->cacheGroupIds))
			{
				return $groupPar;
			}
		}
		else
		{
			$groupPar = str_replace(' ', '', trim(strtolower($groupPar)));

			if (isset($this->cacheGroupIds[$groupPar]))
			{
				return $this->cacheGroupIds[$groupPar];
			}
		}

		return false;
	}

	/**
	 * Get group
	 *
	 * @param integer|string $groupPar Group id or name to get
	 *
	 * @return integer Group id
	 */
	public function getGroup($groupPar)
	{
		$groupModel = new GroupModel();

		if (! $groupId = $this->getGroupId($groupPar))
		{
			return false;
		}

		return $groupModel->asArray()->find($groupId);
	}

	/**
	 * List user groups
	 *
	 * @param integer|null $userId User id to get or false for current user
	 *
	 * @return integer Group id
	 */
	public function listUserGroups(int $userId = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$groupModel = new GroupModel();

		$groupModel->select('id, name, definition');
		$groupModel->join($this->config->dbTableGroupToUser, $this->config->dbTableGroups . '.id = ' . $this->config->dbTableGroupToUser . '.group_id');
		$groupModel->where($this->config->dbTableGroupToUser . '.user_id', $userId);

		return $groupModel->get()->getResult('array');
	}

	/**
	 * List user groups with paginate
	 *
	 * Return users as an object array
	 *
	 * @param integer|null $userId  User id to get or false for current user
	 * @param integer      $limit   Limit of users to be returned
	 * @param string       $orderBy Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listUserGroupsPaginated(int $userId = null, int $limit = 10, string $orderBy = null)
	{
		$userModel = new UserModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$groupModel = new GroupModel();

		$groupModel->select('id, name, definition');
		$groupModel->join($this->config->dbTableGroupToUser, $this->config->dbTableGroups . '.id = ' . $this->config->dbTableGroupToUser . '.group_id');
		$groupModel->where($this->config->dbTableGroupToUser . '.user_id', $userId);

		if (! is_null($orderBy))
		{
			$groupModel->orderBy($orderBy);
		}

		return [
			'groups' => $groupModel->paginate($limit),
			'pager'  => $groupModel->pager,
		];
	}

	/**
	 * Set Group Variable as key value
	 *
	 * if variable not set before, it will be set
	 * if set, overwrites the value
	 *
	 * @param string  $key
	 * @param string  $value
	 * @param integer $groupId Group id
	 *
	 * @return boolean
	 */
	public function setGroupVar(string $key, string $value, int $groupId)
	{
		$groupModel = new GroupModel();

		if (! $groupModel->existsById($groupId))
		{
			return false;
		}

		$groupVariableModel = new GroupVariableModel();

		return $groupVariableModel->save($groupId, $key, $value);
	}

	/**
	 * Unset Group Variable as key value
	 *
	 * @param string  $key
	 * @param integer $groupId Group id
	 *
	 * @return boolean
	 */
	public function unsetGroupVar(string $key, int $groupId)
	{
		$groupModel = new GroupModel();

		if (! $groupModel->existsById($groupId))
		{
			return false;
		}

		$groupVariableModel = new GroupVariableModel();

		return $groupVariableModel->delete($groupId, $key);
	}

	/**
	 * Get Group Variable by key
	 *
	 * @param string  $key     Variable Key
	 * @param integer $groupId Group id
	 *
	 * @return boolean|string false if var is not set, the value of var if set
	 */
	public function getGroupVar(string $key, int $groupId)
	{
		$groupModel = new GroupModel();

		if (! $groupModel->existsById($groupId))
		{
			return false;
		}

		$groupVariableModel = new GroupVariableModel();

		if (! $variable = $groupVariableModel->find($groupId, $key))
		{
			return false;
		}

		return $variable;
	}

	/**
	 * Get Group Variables by group id
	 *
	 * Return array with all group keys & variables
	 *
	 * @param integer $groupId Group id
	 *
	 * @return array
	 */
	public function getGroupVars(int $groupId = null)
	{
		$groupModel = new GroupModel();

		if (! $groupModel->existsById($groupId))
		{
			return false;
		}

		$groupVariableModel = new GroupVariableModel();

		return $groupVariableModel->findAll($groupId);
	}

	/**
	 * List Group Variable Keys by GroupId
	 *
	 * Return array of variable keys or false
	 *
	 * @param integer $groupId Group id
	 *
	 * @return boolean|array
	 */
	public function listGroupVarKeys(int $groupId = null)
	{
		$groupModel = new GroupModel();

		if (! $groupModel->existsById($groupId))
		{
			return false;
		}

		$groupVariableModel = new GroupVariableModel();
		$groupVariableModel->select('data_key as key');

		return $groupVariableModel->findAll($groupId);
	}

	//--------------------------------------------------------------------
	// Perm Functions
	//--------------------------------------------------------------------

	/**
	 * Create permission
	 *
	 * Creates a new permission type
	 *
	 * @param string $name       New permission name
	 * @param string $definition Permission description
	 *
	 * @return integer|boolean Permission id or false on fail
	 */
	public function createPerm(string $name, string $definition = '')
	{
		$permModel = new PermModel();

		$data['name']       = $name;
		$data['definition'] = $definition;

		if (! $permId = $permModel->insert($data))
		{
			$this->error(array_values($permModel->errors()));

			return false;
		}

		$this->precachePerms();

		return $permId;
	}

	/**
	 * Update permission
	 *
	 * Updates permission name and description
	 *
	 * @param integer|string $permPar    Permission id or permission name
	 * @param string         $name       New permission name
	 * @param string         $definition Permission description
	 *
	 * @return boolean Update success/failure
	 */
	public function updatePerm($permPar, string $name = null, string $definition = null)
	{
		$permModel = new PermModel();

		if (is_null($name) && is_null($definition))
		{
			return true;
		}
		else if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}

		$data['id'] = $permId;

		if (! is_null($name))
		{
			$data['name'] = $name;
		}

		if (! is_null($definition))
		{
			$data['definition'] = $definition;
		}

		if (! $permModel->update($permId, $data))
		{
			$this->error(array_values($permModel->errors()));

			return false;
		}

		$this->precachePerms();

		return true;
	}

	/**
	 * Delete permission
	 *
	 * Delete a permission from database. WARNING Can't be undone
	 *
	 * @param integer|string $permPar Permission id or perm name
	 *
	 * @return boolean Delete success/failure
	 */
	public function deletePerm($permPar)
	{
		$permModel        = new PermModel();
		$permToGroupModel = new PermToGroupModel();
		$permToUserModel  = new PermToUserModel();

		if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}

		$permModel->transStart();
		$permToGroupModel->deleteAllByPermId($permId);
		$permToUserModel->deleteAllByPermId($permId);
		$permModel->delete($permId);
		$permModel->transComplete();

		if ($permModel->transStatus() === false)
		{
			$permModel->transRollback();

			return false;
		}
		else
		{
			$permModel->transCommit();
			$this->precachePerms();

			return true;
		}
	}

	/*$userId User id to allow
	 *
	 * @return bool Allow success/failure
	 */
	public function allowUser($permPar, int $userId)
	{
		$userModel       = new UserModel();
		$permToUserModel = new PermToUserModel();

		if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}
		else if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}
		else if ($permToUserModel->allowed($permId, $userId))
		{
			return true;
		}

		return $permToUserModel->save($permId, $userId, 1);
	}

	/*$userId User id to deny
	 *
	 * @return bool Deny success/failure
	 */
	public function denyUser($permPar, int $userId)
	{
		$userModel       = new UserModel();
		$permToUserModel = new PermToUserModel();

		if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}
		else if (! $userModel->existsById($userId))
		{
			$this->error(lang('Aauth.notFoundUser'));

			return false;
		}
		else if ($permToUserModel->denied($permId, $userId))
		{
			return true;
		}

		return $permToUserModel->save($permId, $userId, 0);
	}

	/**
	 * Allow Group
	 *
	 * Add group to permission
	 *
	 * @param integer|string $permPar  Permission id or perm name
	 * @param integer|string $groupPar Group id or name to allow
	 *
	 * @return boolean Allow success/failure
	 */
	public function allowGroup($permPar, $groupPar)
	{
		$permToGroupModel = new PermToGroupModel();

		if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}
		if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}
		else if ($permToGroupModel->allowed($permId, $groupId))
		{
			return true;
		}

		return $permToGroupModel->save($permId, $groupId, 1);
	}

	/**
	 * Deny Group
	 *
	 * Remove group from permission
	 *
	 * @param integer|string $permPar  Permission id or perm name
	 * @param integer|string $groupPar Group id or name to deny
	 *
	 * @return boolean Deny success/failure
	 */
	public function denyGroup($permPar, $groupPar)
	{
		$permToGroupModel = new PermToGroupModel();

		if (! $permId = $this->getPermId($permPar))
		{
			$this->error(lang('Aauth.notFoundPerm'));

			return false;
		}
		if (! $groupId = $this->getGroupId($groupPar))
		{
			$this->error(lang('Aauth.notFoundGroup'));

			return false;
		}
		else if ($permToGroupModel->denied($permId, $groupId))
		{
			return true;
		}

		return $permToGroupModel->save($permId, $groupId, 0);
	}

	/**
	 * List Permissions
	 * List all permissions
	 *
	 * @return object Array of permissions
	 */
	public function listPerms()
	{
		$permModel = new PermModel();

		return $permModel->findAll();
	}

	/**
	 * List perms with paginate
	 *
	 * Return perms as an object array
	 *
	 * @param integer $limit   Limit of users to be returned
	 * @param string  $orderBy Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of perms
	 */
	public function listPermsPaginated(int $limit = 10, string $orderBy = null)
	{
		$permModel = new PermModel();

		if (! is_null($orderBy))
		{
			$permModel->orderBy($orderBy);
		}

		return [
			'perms' => $permModel->paginate($limit),
			'pager' => $permModel->pager,
		];
	}

	/**
	 * Get permission id
	 *
	 * @param integer|string $permPar Permission id or name to get
	 *
	 * @return integer Permission id or NULL if perm does not exist
	 */
	public function getPermId($permPar)
	{
		if (is_numeric($permPar))
		{
			if (array_search($permPar, $this->cachePermIds))
			{
				return $permPar;
			}
		}
		else
		{
			$permPar = str_replace(' ', '', trim(strtolower($permPar)));

			if (isset($this->cachePermIds[$permPar]))
			{
				return $this->cachePermIds[$permPar];
			}
		}

		return false;
	}

	/**
	 * Get permission
	 * Get permission from permisison name or id
	 *
	 * @param  integer|string $permPar Permission id or name to get
	 * @return integer Permission id or NULL if perm does not exist
	 */
	public function getPerm($permPar)
	{
		$permModel = new PermModel();

		if (! $permId = $this->getPermId($permPar))
		{
			return false;
		}

		return $permModel->asArray()->find($permId);
	}

	/**
	 * List group permissions
	 *
	 * @param integer|string $groupPar Group id or name to get
	 *
	 * @return integer Group id
	 */
	public function listGroupPerms($groupPar)
	{
		if (! $groupId = $this->getGroupId($groupPar))
		{
			return false;
		}

		$permModel = new PermModel();

		$permModel->select('id, name, definition, state');
		$permModel->join($this->config->dbTablePermToGroup, $this->config->dbTablePerms . '.id = ' . $this->config->dbTablePermToGroup . '.perm_id');
		$permModel->where($this->config->dbTablePermToGroup . '.group_id', $groupId);

		return $permModel->get()->getResult('array');
	}

	/**
	 * List users with paginate
	 *
	 * Return users as an object array
	 *
	 * @param integer $limit          Limit of users to be returned
	 * @param integer $offset         Offset for limited number of users
	 * @param boolean $includeBanneds Include banned users
	 * @param string  $orderBy        Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listGroupPermsPaginated(int $groupId, int $limit = 10, string $orderBy = null)
	{
		$permModel = new PermModel();

		$permModel->select('id, name, definition, state');
		$permModel->join($this->config->dbTablePermToGroup, $this->config->dbTablePerms . '.id = ' . $this->config->dbTablePermToGroup . '.perm_id');
		$permModel->where($this->config->dbTablePermToGroup . '.group_id', $groupId);

		if (! is_null($orderBy))
		{
			$permModel->orderBy($orderBy);
		}

		return [
			'perms' => $permModel->paginate($limit),
			'pager' => $permModel->pager,
		];
	}

	/**
	 * List user permissions
	 *
	 * @param integer|string $groupPar Group id or name to get
	 *
	 * @return integer Group id
	 */
	public function listUserPerms(int $userId = null)
	{
		$userModel  = new UserModel();
		$groupModel = new GroupModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$permModel = new PermModel();

		$permModel->select('id, name, definition, state');
		$permModel->join($this->config->dbTablePermToUser, $this->config->dbTablePerms . '.id = ' . $this->config->dbTablePermToUser . '.perm_id');
		$permModel->where($this->config->dbTablePermToUser . '.user_id', $userId);

		return $permModel->get()->getResult('array');
	}

	/**
	 * List users with paginate
	 *
	 * Return users as an object array
	 *
	 * @param integer $limit          Limit of users to be returned
	 * @param integer $offset         Offset for limited number of users
	 * @param boolean $includeBanneds Include banned users
	 * @param string  $orderBy        Order by MYSQL string (e.g. 'name ASC', 'email DESC')
	 *
	 * @return array Array of users
	 */
	public function listUserPermsPaginated(int $userId = null, int $limit = 10, string $orderBy = null)
	{
		$userModel  = new UserModel();
		$groupModel = new GroupModel();

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (! $userModel->existsById($userId))
		{
			return false;
		}

		$permModel = new PermModel();

		$permModel->select('id, name, definition, state');
		$permModel->join($this->config->dbTablePermToUser, $this->config->dbTablePerms . '.id = ' . $this->config->dbTablePermToUser . '.perm_id');
		$permModel->where($this->config->dbTablePermToUser . '.user_id', $userId);

		if (! is_null($orderBy))
		{
			$permModel->orderBy($orderBy);
		}

		return [
			'perms' => $permModel->paginate($limit),
			'pager' => $permModel->pager,
		];
	}

	//--------------------------------------------------------------------
	// Error Functions
	//--------------------------------------------------------------------

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

			$this->session->setFlashdata('errors', $this->flashErrors);
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
			$flashErrorsOld    = $this->session->getFlashdata('errors');
			$this->flashErrors = array_merge((is_array($flashErrorsOld) ? $flashErrorsOld : []), $this->errors);
			$this->session->setFlashdata('errors', $this->flashErrors);
		}
		else
		{
			$this->session->keepFlashdata('errors');
		}
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
		$this->errors      = [];
		$this->flashErrors = [];
		$this->session->remove('errors');
	}

	//--------------------------------------------------------------------
	// Info Functions
	//--------------------------------------------------------------------

	/**
	 * Info
	 *
	 * Add message to info array and set flash data
	 *
	 * @param string|array $message   Message to add to infos array
	 * @param boolean      $flashdata Whether add $message to CI flashdata (deflault: false)
	 *
	 * @return void
	 */
	public function info($message, bool $flashdata = null)
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

			$this->session->setFlashdata('infos', $this->flashInfos);
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
			$flashInfosOld    = $this->session->getFlashdata('infos');
			$this->flashInfos = array_merge((is_array($flashInfosOld) ? $flashInfosOld : []), $this->infos);
			$this->session->setFlashdata('infos', $this->flashInfos);
		}
		else
		{
			$this->session->keepFlashdata('infos');
		}
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
		$this->infos      = [];
		$this->flashInfos = [];
		$this->session->remove('infos');
	}
}
