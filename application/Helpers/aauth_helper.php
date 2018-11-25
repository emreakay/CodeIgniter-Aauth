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

use App\Libraries\Aauth;

/**
 * Aauth Helper
 *
 * @package CodeIgniter-Aauth
 */
if (! function_exists('is_loggedin'))
{
	/**
	 * Is logged in
	 *
	 * @return boolean
	 */
	function is_loggedin()
	{
		$aauth = new Aauth();
		return $aauth->isLoggedIn();
	}
}
