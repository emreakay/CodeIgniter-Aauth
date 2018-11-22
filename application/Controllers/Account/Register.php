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
 * @copyright 2014-2017 Emre Akay
 * @copyright 2018 Magefly
 * @license   https://opensource.org/licenses/MIT	MIT License
 * @link      https://github.com/magefly/CodeIgniter-Aauth
 */

namespace App\Controllers\Account;

use CodeIgniter\Controller;
use Config\Aauth as AauthConfig;
use App\Libraries\Aauth;
use App\Models\Aauth\UserVariableModel as UserVariableModel;
use Config\Services;

/**
 * Aauth Accont/Register Controller
 *
 * @package CodeIgniter-Aauth
 */
class Register extends Controller
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
		if ($input = $this->request->getVar())
		{
			if (! $this->aauth->createUser($input['email'], $input['password'], $input['username']))
			{
				$data['errors'] = $this->aauth->printErrors('<br />', true);
			}
			else
			{
				$data['info'] = $this->aauth->printInfos('<br />', true);
			}
		}

		$data['useUsername'] = $this->config->loginUseUsername;
		$data['cssFiles']    = [
			'/assets/css/login.css'
		];

		echo view('Templates/HeaderBlank', $data);
		echo view('Account/Register', $data);
		echo view('Templates/FooterBlank', $data);
	}
}
