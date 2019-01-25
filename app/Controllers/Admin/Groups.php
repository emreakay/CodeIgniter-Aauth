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
use App\Libraries\Aauth;
use Config\Services;

/**
 * Aauth Admin/Groups Controller
 *
 * @package CodeIgniter-Aauth
 */
class Groups extends Controller
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
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
		$data = $this->aauth->listGroupsPaginated();

		$data['cssFiles'] = [
			'/assets/css/admin/groups/index.css'
		];

		echo view('Templates/HeaderAdmin', $data);
		echo view('Admin/Groups/Home', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * New
	 *
	 * @return void
	 */
	public function new()
	{
		$data['groups'] = $this->aauth->listGroups();
		$data['perms']  = $this->aauth->listPerms();
		echo view('Templates/HeaderAdmin');
		echo view('Admin/Groups/New', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Create
	 *
	 * @return void
	 */
	public function create()
	{
		$name       = $this->request->getPost('name');
		$definition = $this->request->getPost('definition');
		$subGroups  = $this->request->getPost('sub_groups');
		$perms      = $this->request->getPost('perms');

		if (! $groupId = $this->aauth->createGroup($name, $definition))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		foreach ($subGroups as $subgroupId => $state)
		{
			if ($state === 1)
			{
				$this->aauth->addSubgroup($groupId, $subgroupId);
			}
		}

		foreach ($perms as $permId => $state)
		{
			if ($state === 1)
			{
				$this->aauth->allowGroup($permId, $groupId);
			}
		}

		return redirect()->to('/admin/groups');
	}

	/**
	 * Edit
	 *
	 * @return void
	 */
	public function edit($groupId)
	{
		$data['group']        = $this->aauth->getGroup($groupId);
		$data['groups']       = $this->aauth->listGroups();
		$data['perms']        = $this->aauth->listPerms();
		$data['activeGroups'] = $this->aauth->getSubgroups($groupId);
		$data['activePerms']  = $this->aauth->getGroupPerms($groupId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Groups/Edit', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Update
	 *
	 * @return void
	 */
	public function update($groupId)
	{
		$name       = $this->request->getPost('name');
		$definition = $this->request->getPost('definition');
		$subGroups  = $this->request->getPost('sub_groups');
		$perms      = $this->request->getPost('perms');

		if (! $this->aauth->updateGroup($groupId, empty($name) ? null : $name, empty($definition) ? null : $definition))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		$activeSubGroups = $this->aauth->getSubgroups($groupId);
		$activePerms     = $this->aauth->getGroupPerms($groupId, 1);

		foreach ($subGroups as $subgroupId => $state)
		{
			if (! in_array(['subgroup_id' => $subgroupId], $activeSubGroups) && $state === 1)
			{
				$this->aauth->addSubgroup($groupId, $subgroupId);
			}
			else if (in_array(['subgroup_id' => $subgroupId], $activeSubGroups) && $state === 0)
			{
				$this->aauth->removeSubgroup($groupId, $subgroupId);
			}
		}

		foreach ($perms as $permId => $state)
		{
			if (! in_array(['perm_id' => $permId], $activePerms) && $state === 1)
			{
				$this->aauth->allowGroup($permId, $groupId);
			}
			else if (! in_array(['perm_id' => $permId], $activePerms) && $state === 0)
			{
				$this->aauth->denyGroup($permId, $groupId);
			}
		}

		return redirect()->to('/admin/groups/edit/' . $groupId);
	}

	/**
	 * Show
	 *
	 * @return void
	 */
	public function show($groupId)
	{
		$data['group']        = $this->aauth->getGroup($groupId);
		$data['groups']       = $this->aauth->listGroups();
		$data['perms']        = $this->aauth->listPerms();
		$data['activeGroups'] = $this->aauth->getSubgroups($groupId);
		$data['activePerms']  = $this->aauth->getGroupPerms($groupId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Groups/Show', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Delete
	 *
	 * @return void
	 */
	public function delete($groupId)
	{
		if (! $this->aauth->getGroup($groupId))
		{
			return redirect()->to('/admin/groups');
		}

		$id = $this->request->getPost('id');
		if ($groupId === $id)
		{
			if ($this->aauth->deleteGroup($groupId))
			{
				return redirect()->to('/admin/groups');
			}
		}

		$data['group']        = $this->aauth->getGroup($groupId);
		$data['groups']       = $this->aauth->listGroups();
		$data['perms']        = $this->aauth->listPerms();
		$data['activeGroups'] = $this->aauth->getSubgroups($groupId);
		$data['activePerms']  = $this->aauth->getGroupPerms($groupId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Groups/Delete', $data);
		echo view('Templates/FooterAdmin');
	}

}
