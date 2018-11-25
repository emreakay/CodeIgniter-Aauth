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
		$this->config = new AauthConfig();
		$this->user   = new UserModel();
		$this->aauth  = new Aauth();

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
		// print_r($this->aauth->session);
		// print_r($this->aauth->login("admin@example.com", "password123456"));
		// print_r($this->aauth->deleteUser(4));
		// print_r($this->aauth->updateUser(1, "admin@example.com", "password", 'Admines'));
		// print_r($this->aauth->createUser("admin@example.coma", 'asdasasdasdsd'));

		echo $this->aauth->printErrors('<br />', true);
	}
}
