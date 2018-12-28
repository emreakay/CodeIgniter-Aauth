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
use App\Libraries\Aauth;
use App\Models\Aauth\UserModel;

/**
 * Aauth Accont/Home Controller
 *
 * @package CodeIgniter-Aauth
 */
class Home extends Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->aauth = new Aauth();
		helper('aauth');

		if (! $this->aauth->isLoggedIn())
		{
			redirect()->to('/');
		}
	}

	/**
	 * Index
	 *
	 * @return void
	 */
	public function index()
	{
		$data['user'] = $this->aauth->getUser();

		echo view('Templates/Header');
		echo view('Account/Home', $data);
		echo view('Templates/Footer');
	}
}
