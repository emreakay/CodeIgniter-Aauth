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

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Aauth Home Controller
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
		echo view('Templates/Header');
		echo view('Home');
		echo view('Templates/Footer');
	}
}
