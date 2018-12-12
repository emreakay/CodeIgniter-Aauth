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

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Aauth as AauthConfig;
use App\Libraries\Aauth;

/**
 * Aauth Admin/Users Controller
 *
 * @package CodeIgniter-Aauth
 */
class Users extends Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->aauth   = new Aauth();
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
		$data = $this->aauth->listUsersPaginated();

		$data['cssFiles']    = [
			'/assets/css/admin/users/index.css'
		];

		echo view('Templates/HeaderAdmin', $data);
		echo view('Admin/Users/Home', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * New
	 *
	 * @return void
	 */
	public function new()
	{
		$data = $this->aauth->listUsersPaginated();

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Users/New', $data);
		echo view('Templates/FooterAdmin');
	}
}
