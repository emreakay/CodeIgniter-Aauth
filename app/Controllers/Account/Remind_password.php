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
use App\Libraries\Aauth;
use Config\Services;

/**
 * Aauth Accont/Remind_password Controller
 *
 * @package CodeIgniter-Aauth
 */
class Remind_password extends Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
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
			if (! $this->aauth->remindPassword($input['email']))
			{
				$data['errors'] = $this->aauth->printErrors('<br />', true);
			}
			else
			{
				$data['infos'] = $this->aauth->printInfos('<br />', true);
			}
		}

		$data['cssFiles'] = [
			'/assets/css/login.css'
		];

		echo view('Templates/HeaderBlank', $data);
		echo view('Account/RemindPassword', $data);
		echo view('Templates/FooterBlank', $data);
	}
}
