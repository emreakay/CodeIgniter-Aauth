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
 * @since     3.0.0
 */

namespace App\Libraries\Aauth;

/**
 * Aauth Social
 *
 * Class for handling social logins
 *
 * @package CodeIgniter-Aauth
 */
class Social extends \App\Libraries\Aauth
{

	/**
	 * Variable to load HybridAuth config array
	 *
	 * @var array
	 */
	protected $configHybridAuth = [];

	/**
	 * Variable to store HybridAuths storage name
	 *
	 * @var string
	 */
	protected $storageHybridAuth = 'HYBRIDAUTH::STORAGE';

	/**
	 * Constructor
	 *
	 * Prepares config & session variable.
	 *
	 * @param \Config\Aauth                $config  Config Object
	 * @param \CodeIgniter\Session\Session $session Session Class
	 *
	 * @return void
	 */
	public function __construct(\Config\Aauth $config = null, \CodeIgniter\Session\Session $session = null)
	{
		parent::__construct($config, $session);

		$this->configHybridAuth['providers'] = $config->socialProviders;
		$this->configHybridAuth['callback']  = site_url();
	}

	/**
	 * Login Social
	 *
	 * @param string $provider Provider Name
	 *
	 * @return boolean|object
	 */
	public function loginSocial(string $provider = null)
	{
		$userProfile = $this->getSocialDetails($provider);

		if ($userId = $this->getSocialUserId($provider, $userProfile->identifier))
		{
			$session = service('session');
			$storage = $session->get($this->storageHybridAuth);

			$this->updateSocialProviderIdentifier($userId, 'storage', json_encode($storage));

			if ($this->config->socialRemember)
			{
				$expires = $this->config->socialRemember;

				if ($expires === true)
				{
					$expires = $storage[strtolower($provider) . '.expires_at'];
				}

				$this->generateRemember($userId, $expires);
			}
			return $this->loginFast($userId);
		}

		return false;
	}

	/**
	 * Link Social
	 *
	 * @param integer $userId   User Id
	 * @param string  $provider Provider Name
	 *
	 * @return boolean
	 */
	public function linkSocial(int $userId, string $provider)
	{
		$userProfile = $this->getSocialDetails($provider);
		$this->updateSocialStorage($userId);

		return $this->updateSocialProviderIdentifier($userId, $provider, $userProfile->identifier);
	}

	/**
	 * Unlink Social
	 *
	 * @param integer $userId   User Id
	 * @param string  $provider Provider Name
	 *
	 * @return boolean
	 */
	public function unlinkSocial(int $userId, string $provider)
	{
		$session = service('session');
		$session->remove($this->storageHybridAuth);

		$userVariableModel = $this->getModel('UserVariable');
		$userVariableModel->delete($userId, 'social_storage', true);

		return $userVariableModel->delete($userId, 'social_' . strtolower($provider), true);
	}

	/**
	 * Rebuild Social Storage
	 *
	 * @param integer $userId User Id
	 *
	 * @return void
	 */
	public function rebuildSocialStorage(int $userId)
	{
		$userVariableModel = $this->getModel('UserVariable');
		$providers         = $this->getProviders();

		if ($storedData = $userVariableModel->find($userId, 'social_storage', true))
		{
			$storedData = json_decode($storedData, true);

			foreach ($providers as $provider)
			{
				if ($storedData[strtolower($provider) . '.expires_at'] > time())
				{
					$session = service('session');
					$session->set($this->storageHybridAuth, $storedData);
				}
			}
		}
	}

	/**
	 * Get Social User Id
	 *
	 * @param string $provider   Provider Name
	 * @param string $identifier Identifier
	 *
	 * @return integer|boolean
	 */
	public function getSocialUserId(string $provider, string $identifier)
	{
		$userVariableModel = $this->getModel('UserVariable');
		$whereArray        = [
			'data_key'   => 'social_' . strtolower($provider),
			'data_value' => $identifier,
			'system'     => 1,
		];

		if ($user = $userVariableModel->select('user_id')->where($whereArray)->first())
		{
			return (int) $user['user_id'];
		}

		return false;
	}

	/**
	 * Get Social Identifier
	 *
	 * @param string  $provider Provider Name
	 * @param integer $userId   User Id
	 *
	 * @return integer|boolean
	 */
	public function getSocialIdentifier(string $provider, int $userId)
	{
		$userVariableModel = $this->getModel('UserVariable');
		$whereArray        = [
			'data_key' => 'social_' . strtolower($provider),
			'user_id'  => $userId,
			'system'   => 1,
		];

		if ($user = $userVariableModel->select('data_value')->where($whereArray)->first())
		{
			return $user['data_value'];
		}

		return false;
	}

	/**
	 * Get Social Details
	 *
	 * @param string $provider Provider Name
	 *
	 * @return \Hybridauth\User\Profile
	 */
	public function getSocialDetails(string $provider)
	{
		$hybridauth = new \Hybridauth\Hybridauth($this->configHybridAuth);

		$adapter = $hybridauth->getAdapter($provider);

		return $adapter->getUserProfile();
	}

	/**
	 * Get Providers
	 *
	 * @return array
	 */
	public function getProviders()
	{
		$hybridauth = new \Hybridauth\Hybridauth($this->configHybridAuth);

		return $hybridauth->getProviders();
	}

	/**
	 * Authenticate Provider
	 *
	 * @param string $provider    Provider Name
	 * @param string $callbackUrl Callback Link
	 *
	 * @return \Hybridauth\Adapter\AdapterInterface
	 */
	public function authenticateProvider(string $provider, string $callbackUrl)
	{
		$this->configHybridAuth['callback'] = site_url($callbackUrl);

		$hybridauth = new \Hybridauth\Hybridauth($this->configHybridAuth);
		$adapter    = $hybridauth->authenticate($provider);

		return $adapter;
	}

	/**
	 * Update Social Storage
	 *
	 * @param integer $userId User Id
	 *
	 * @return void
	 */
	private function updateSocialStorage(int $userId)
	{
		$session = service('session');
		$storage = $session->get($this->storageHybridAuth);

		$this->updateSocialProviderIdentifier($userId, 'storage', json_encode($storage));
	}

	/**
	 * Update Social Provider Identifier
	 *
	 * @param integer $userId     User Id
	 * @param string  $provider   Provider Name
	 * @param string  $identifier Identifier
	 *
	 * @return boolean
	 */
	private function updateSocialProviderIdentifier(int $userId, string $provider, string $identifier)
	{
		$userVariableModel = $this->getModel('UserVariable');

		return $userVariableModel->save($userId, 'social_' . strtolower($provider), $identifier, true);
	}
}
