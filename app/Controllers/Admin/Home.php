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

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

/**
 * Aauth Admin/Home Controller
 *
 * @package CodeIgniter-Aauth
 */
class Home extends Controller
{
	/**
	 * Index
	 *
	 * @return void
	 */
	public function index()
	{
		helper('aauth');
		echo view('Templates/HeaderAdmin');
		echo view('Admin/Home');
		echo view('Templates/FooterAdmin');
	}
}
