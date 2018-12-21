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
 * Aauth Admin/Migrate Controller
 *
 * @package CodeIgniter-Aauth
 */
class Migrate extends Controller
{
	/**
	 * Index
	 *
	 * @return void
	 */
	public function index()
	{
		helper('aauth');
		$config  = new \Config\Aauth();
		$migrate = \Config\Services::migrations();

		try
		{
			$migrated = $migrate->latest('App', $config->dbProfile);
		}
		catch (\Exception $e)
		{
			// Do something with the error here...
		}

		echo view('Templates/Header');
		echo view('Admin/Migrate');
		echo view('Templates/Footer');
	}
}
