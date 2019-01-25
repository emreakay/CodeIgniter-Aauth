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
		$this->config  = new AauthConfig();
		$this->aauth   = new Aauth();
		$this->request = Services::request();
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

		$data['cssFiles'] = [
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
		$data['useUsername'] = $this->config->loginUseUsername;
		$data['groups']      = $this->aauth->listGroups();
		$data['perms']       = $this->aauth->listPerms();

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Users/New', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Create
	 *
	 * @return void
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
	 * @return void
	 */
	public function edit($userId)
	{
		$data['useUsername'] = $this->config->loginUseUsername;
		$data['user']        = $this->aauth->getUser($userId);
		$data['groups']      = $this->aauth->listGroups();
		$data['perms']       = $this->aauth->listPerms();

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Users/Edit', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Update
	 *
	 * @return void
	 */
	public function update($userId)
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

			if (! in_array(['group_id' => $groupId], $activeGroups) && $state === 1)
			{
				$this->aauth->addMember($groupId, $userId);
			}
			else if (in_array(['group_id' => $groupId], $activeGroups) && $state === 0)
			{
				$this->aauth->removeMember($groupId, $userId);
			}
		}

		foreach ($perms as $permId => $state)
		{
			if (! in_array(['perm_id' => $permId], $activePerms) && $state === 1)
			{
				$this->aauth->allowUser($permId, $userId);
			}
			else if (in_array(['perm_id' => $permId], $activePerms) && $state === 0)
			{
				$this->aauth->denyUser($permId, $userId);
			}
		}

		return redirect()->to('/admin/users/edit/' . $userId);
	}

	/**
	 * Show
	 *
	 * @return void
	 */
	public function show($userId)
	{
		$data['user']   = $this->aauth->getUser($userId);
		$data['groups'] = $this->aauth->listGroups();
		$data['perms']  = $this->aauth->listPerms();

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Users/Show', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Delete
	 *
	 * @return void
	 */
	public function delete($userId)
	{
		if (! $this->aauth->getUser($userId))
		{
			return redirect()->to('/admin/users');
		}

		$id = $this->request->getPost('id');
		if ($userId === $id)
		{
			if ($this->aauth->deleteUser($userId))
			{
				return redirect()->to('/admin/users');
			}
		}

		$data['user']   = $this->aauth->getUser($userId);
		$data['groups'] = $this->aauth->listGroups();
		$data['perms']  = $this->aauth->listPerms();

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Users/Delete', $data);
		echo view('Templates/FooterAdmin');
	}

}
