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

namespace App\Controllers\Account;

use CodeIgniter\Controller;
use Config\Aauth as AauthConfig;
use App\Libraries\Aauth;
use Config\Services;

/**
 * Aauth Accont/Social Controller
 *
 * @package CodeIgniter-Aauth
 */
class Social extends Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->config  = new AauthConfig();
		$this->aauth   = new Aauth();
		$this->request = Services::request();
		helper('form');
	}

	/**
	 * Index
	 *
	 * @param string $provider Provider Name
	 *
	 * @return redirect
	 */
	public function connect(string $provider = null)
	{
		if ($provider)
		{
			session()->setFlashdata('social_provider', $provider);
		}
		else
		{
			$provider = session('social_provider');
		}

		if ($userId = $this->aauth->getUserId())
		{
			if ($this->aauth->authenticateProvider($provider, 'account/social/connect/'))
			{
				if ($userId = $this->aauth->getUserId())
				{
					helper('text');
					$userProfile = $this->aauth->getSocialDetails($provider);
					$password    = random_string('alnum', (config('Aauth')->passwordMin + 2));
					$username    = preg_replace('/[^A-Za-z0-9]/', '', $userProfile->displayName);

					$this->aauth->linkSocial($userId, $provider);
				}
			}

			return redirect()->to(site_url('/account'));
		}

		return redirect()->to('/');
	}
	/**
	 * Index
	 *
	 * @param string $provider Provider Name
	 *
	 * @return redirect
	 */
	public function disconnect(string $provider)
	{
		if ($userId = $this->aauth->getUserId())
		{
			$this->aauth->unlinkSocial($userId, $provider);

			return redirect()->to(site_url('/account'));
		}

		return redirect()->to('/');
	}

	/**
	 * Index
	 *
	 * @param string $provider Provider Name
	 *
	 * @return redirect
	 */
	public function login(string $provider = null)
	{
		if ($provider)
		{
			session()->setFlashdata('social_provider', $provider);
		}
		else
		{
			$provider = session('social_provider');
		}

		if ($this->aauth->authenticateProvider($provider, 'account/social/login/'))
		{
			if ($this->aauth->loginSocial($provider))
			{
				return redirect()->to(site_url('/account'));
			}
		}

		return redirect()->to(site_url('/account/login'))->with('errors', lang('Aauth.notFoundUser'));
	}

	/**
	 * Index
	 *
	 * @param string $provider Provider Name
	 *
	 * @return redirect
	 */
	public function register(string $provider = null)
	{
		if ($provider)
		{
			session()->setFlashdata('social_provider', $provider);
		}
		else
		{
			$provider = session('social_provider');
		}

		if ($this->aauth->authenticateProvider($provider, 'account/social/register/'))
		{
			if (! $this->aauth->loginSocial($provider))
			{
				helper('text');
				$userProfile = $this->aauth->getSocialDetails($provider);
				$password    = random_string('alnum', (config('Aauth')->passwordMin + 2));
				$username    = preg_replace('/[^A-Za-z0-9]/', '', $userProfile->displayName);

				if ($userId = $this->aauth->createUser($userProfile->email, $password, $username))
				{
					$this->aauth->linkSocial($userId, $provider);
					$this->aauth->loginSocial($provider);

					return redirect()->to(site_url('/account'));
				}

				return redirect()->to(site_url('/account/register'))->with('errors', $this->aauth->printErrors('<br />', true));
			}

			return redirect()->to(site_url('/account'));
		}
	}
}
