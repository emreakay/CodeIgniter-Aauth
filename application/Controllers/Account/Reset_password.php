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
 * Aauth Accont/Reset_password Controller
 *
 * @package CodeIgniter-Aauth
 */
class Reset_password extends Controller
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
	 * @param string $verificationCode Verification Code
	 *
	 * @return void
	 */
	public function index(string $verificationCode = '')
	{
		if ($input = $this->request->getPost())
		{
			if (! $this->aauth->resetPassword($input['verification_code']))
			{
				$data['errors'] = $this->aauth->printErrors('<br />', true);
			}
			else
			{
				$data['infos'] = $this->aauth->printInfos('<br />', true);
			}
		}

		$data['verificationCode'] = $verificationCode;
		$data['cssFiles']         = [
			'/assets/css/login.css'
		];

		echo view('Templates/HeaderBlank', $data);
		echo view('Account/ResetPassword', $data);
		echo view('Templates/FooterBlank', $data);
	}
}
