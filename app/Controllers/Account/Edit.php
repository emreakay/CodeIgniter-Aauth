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
use Config\Services;

/**
 * Aauth Accont/Edit Controller
 *
 * @package CodeIgniter-Aauth
 */
class Edit extends Controller
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
		helper('aauth');
	}

	/**
	 * Index
	 *
	 * @return void
	 */
	public function index()
	{
		$userId = $this->aauth->getUserId();

		if ($input = $this->request->getPost())
		{
			$email = $password = $username = null;

			if (! empty($input['email']))
			{
				$email = $input['email'];
			}

			if (! empty($input['password']))
			{
				$password = $input['password'];
			}

			if (! empty($input['username']))
			{
				$username = $input['username'];
			}

			if (! $this->aauth->updateUser($userId, $email, $password, $username))
			{
				$data['errors'] = $this->aauth->printErrors('<br />', true);
			}
			else
			{
				$data['infos'] = $this->aauth->printInfos('<br />', true);
			}
		}

		$data['useUsername'] = $this->config->loginUseUsername;

		echo view('Templates/Header', $data);
		echo view('Account/Edit', $data);
		echo view('Templates/Footer', $data);
	}
}
