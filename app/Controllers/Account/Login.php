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
 * Aauth Accont/Login Controller
 *
 * @package CodeIgniter-Aauth
 */
class Login extends Controller
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
	 * @return void
	 */
	public function index()
	{
		if ($input = $this->request->getPost())
		{
			$identifier = ($this->config->loginUseUsername ? $input['username'] : $input['email']);

			if (! $this->aauth->login($identifier, $input['password'], (isset($input['remember']) ? true : false)))
			{
				$data['errors'] = $this->aauth->printErrors('<br />', true);
			}
			else
			{
				$this->response->redirect(site_url('/account'));
			}
		}

		if (session('errors'))
		{
			$data['errors'] = isset($data['errors']) ? $data['errors'] . '<br />' . session('errors') : session('errors');
		}

		$data['useUsername'] = $this->config->loginUseUsername;
		$data['cssFiles']    = [
			'/assets/css/login.css'
		];

		echo view('Account/Login', $data);
	}
}
