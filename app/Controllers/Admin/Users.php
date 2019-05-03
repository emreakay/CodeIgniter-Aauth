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

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Aauth as AauthConfig;
use App\Libraries\Aauth;
use Config\Services;

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
		helper('aauth');

		if (! is_admin())
		{
			return service('response')->redirect('/');
		}

		$this->aauth   = new Aauth();
		$this->config  = new AauthConfig();
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
		$data = $this->aauth->listUsersPaginated();

		$data['pagerLinks'] = $data['pager']->links();
		$data['cssFiles']   = [
			'/assets/css/admin/users/index.css'
		];

		echo view('Admin/Users/Home', $data);
	}

	/**
	 * New
	 *
	 * @return void
	 */
	public function new()
	{
		$data['useUsername'] = $this->config->loginUseUsername;
		$data['groups']      = $this->aauth->listGroups();
		$data['perms']       = $this->aauth->listPerms();

		echo view('Admin/Users/New', $data);
	}

	/**
	 * Create
	 *
	 * @return redirect
	 */
	public function create()
	{
		$email    = $this->request->getPost('email');
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		if (! $this->aauth->createUser($email, $password, empty($username) ? null : $username))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		return redirect()->to('/admin/users');
	}

	/**
	 * Edit
	 *
	 * @param integer $userId User Id
	 *
	 * @return redirect|void
	 */
	public function edit(int $userId)
	{
		if (! $this->aauth->getUser($userId))
		{
			return redirect()->to('/admin/users');
		}

		$data['useUsername'] = $this->config->loginUseUsername;
		$data['user']        = $this->aauth->getUser($userId);
		$data['groups']      = $this->aauth->listUserGroups($userId);
		$data['perms']       = $this->aauth->listUserPerms($userId);

		echo view('Admin/Users/Edit', $data);
	}

	/**
	 * Update
	 *
	 * @param integer $userId User Id
	 *
	 * @return redirect
	 */
	public function update(int $userId)
	{
		$email    = $this->request->getPost('email');
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');
		$groups   = $this->request->getPost('groups');
		$perms    = $this->request->getPost('perms');

		if (! $this->aauth->updateUser($userId, empty($email) ? null : $email, empty($password) ? null : $password, empty($username) ? null : $username))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		$activeGroups = $this->aauth->getUserGroups($userId);
		$activePerms  = $this->aauth->getUserPerms($userId, 1);

		foreach ($groups as $groupId => $state)
		{
			if ($groupId === 2)
			{
				continue;
			}

			if (! in_array(['group_id' => $groupId], $activeGroups) && (int) $state === 1)
			{
				$this->aauth->addMember($groupId, $userId);
			}
			else if (in_array(['group_id' => $groupId], $activeGroups) && (int) $state === 0)
			{
				$this->aauth->removeMember($groupId, $userId);
			}
		}

		foreach ($perms as $permId => $state)
		{
			if (! in_array(['perm_id' => $permId], $activePerms) && (int) $state === 1)
			{
				$this->aauth->allowUser($permId, $userId);
			}
			else if (in_array(['perm_id' => $permId], $activePerms) && (int) $state === 0)
			{
				$this->aauth->denyUser($permId, $userId);
			}
		}

		return redirect()->to('/admin/users/edit/' . $userId);
	}

	/**
	 * Show
	 *
	 * @param integer $userId User Id
	 *
	 * @return redirect|void
	 */
	public function show(int $userId)
	{
		if (! $this->aauth->getUser($userId))
		{
			return redirect()->to('/admin/users');
		}

		$data['user']   = $this->aauth->getUser($userId);
		$data['groups'] = $this->aauth->listUserGroups($userId);
		$data['perms']  = $this->aauth->listUserPerms($userId);

		echo view('Admin/Users/Show', $data);
	}

	/**
	 * Delete
	 *
	 * @param integer $userId User Id
	 *
	 * @return redirect|void
	 */
	public function delete(int $userId)
	{
		if (! $this->aauth->getUser($userId))
		{
			return redirect()->to('/admin/users');
		}

		if ($userId === $this->request->getPost('id'))
		{
			if ($this->aauth->deleteUser($userId))
			{
				return redirect()->to('/admin/users');
			}
		}

		$data['user']   = $this->aauth->getUser($userId);
		$data['groups'] = $this->aauth->listGroups();
		$data['perms']  = $this->aauth->listPerms();

		echo view('Admin/Users/Delete', $data);
	}

}
