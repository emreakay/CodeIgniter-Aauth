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
 * @since     3.0.0
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

if (! function_exists('is_admin'))
{
	/**
	 * Is member
	 *
	 * @param integer $userId User Id
	 *
	 * @return boolean
	 */
	function is_admin(int $userId = null)
	{
		$aauth = new Aauth();
		return $aauth->isAdmin($userId);
	}
}

if (! function_exists('is_member'))
{
	/**
	 * Is member
	 *
	 * @param integer|string $groupPar Group Name or Id
	 * @param integer        $userId   User Id
	 *
	 * @return boolean
	 */
	function is_member($groupPar, int $userId = null)
	{
		$aauth = new Aauth();

		return $aauth->isMember($groupPar, $userId);
	}
}

if (! function_exists('is_allowed'))
{
	/**
	 * Is allowed
	 *
	 * @param integer|string $permPar Perm Name or Id
	 * @param integer        $userId  User Id
	 *
	 * @return boolean
	 */
	function is_allowed($permPar, int $userId = null)
	{
		$aauth = new Aauth();

		return $aauth->isAllowed($permPar, $userId);
	}
}

if (! function_exists('is_denied'))
{
	/**
	 * Is denied
	 *
	 * @param integer|string $permPar Perm Name or Id
	 * @param integer        $userId  User Id
	 *
	 * @return boolean
	 */
	function is_denied($permPar, int $userId = null)
	{
		$aauth = new Aauth();

		return $aauth->isDenied($permPar, $userId);
	}
}

if (! function_exists('get_subgroups'))
{
	/**
	 * Get Sub-Groups by Group Name/Id
	 *
	 * @param integer|string $groupPar Group Name or Id
	 *
	 * @return array
	 */
	function get_subgroups($groupPar)
	{
		$aauth = new Aauth();

		return $aauth->getSubgroups($groupPar);
	}
}

if (! function_exists('get_user_perms'))
{
	/**
	 * Get User Groups
	 *
	 * @param integer $userId User Id
	 *
	 * @return array
	 */
	function get_user_groups(int $userId = null)
	{
		$aauth = new Aauth();

		return $aauth->getUserGroups($userId);
	}
}

if (! function_exists('get_user_perms'))
{
	/**
	 * Get Group Perms by Group Name/Id
	 *
	 * @param integer $userId User Id
	 * @param integer $state  State (0 disabled, 1 enabled)
	 *
	 * @return array
	 */
	function get_user_perms(int $userId = null, int $state = null)
	{
		$aauth = new Aauth();

		return $aauth->getUserPerms($userId, $state);
	}
}

if (! function_exists('get_group_perms'))
{
	/**
	 * Get Group Perms by Group Name/Id
	 *
	 * @param integer|string $groupPar Group Name or Id
	 * @param integer        $state    State (0 disabled, 1 enabled)
	 *
	 * @return array
	 */
	function get_group_perms($groupPar, int $state = null)
	{
		$aauth = new Aauth();

		return $aauth->getGroupPerms($groupPar, $state);
	}
}
