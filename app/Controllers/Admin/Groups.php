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
		helper('aauth');

		if (! is_admin())
		{
			return service('response')->redirect('/');
		}

		$this->aauth   = new Aauth();
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
		$data = $this->aauth->listGroupsPaginated();

		$data['pagerLinks'] = $data['pager']->links();
		$data['cssFiles']   = [
			'/assets/css/admin/groups/index.css'
		];

		echo view('Admin/Groups/Home', $data);
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
		echo view('Admin/Groups/New', $data);
	}

	/**
	 * Create
	 *
	 * @return redirect
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
			if ((int) $state === 1)
			{
				$this->aauth->addSubgroup($groupId, $subgroupId);
			}
		}

		foreach ($perms as $permId => $state)
		{
			if ((int) $state === 1)
			{
				$this->aauth->allowGroup($permId, $groupId);
			}
		}

		return redirect()->to('/admin/groups');
	}

	/**
	 * Edit
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return redirect|void
	 */
	public function edit(int $groupId)
	{
		if (! $this->aauth->getGroup($groupId))
		{
			return redirect()->to('/admin/groups');
		}

		$data['group']  = $this->aauth->getGroup($groupId);
		$data['groups'] = $this->aauth->listGroupSubgroups($groupId);
		$data['perms']  = $this->aauth->listGroupPerms($groupId);

		echo view('Admin/Groups/Edit', $data);
	}

	/**
	 * Update
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return redirect
	 */
	public function update(int $groupId)
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
		$activePerms     = $this->aauth->getGroupPerms($groupId);
		foreach ($subGroups as $subgroupId => $state)
		{
			if (! in_array(['subgroup_id' => $subgroupId], $activeSubGroups) && (int) $state === 1)
			{
				$this->aauth->addSubgroup($groupId, $subgroupId);
			}
			else if (in_array(['subgroup_id' => $subgroupId], $activeSubGroups) && (int) $state === 0)
			{
				$this->aauth->removeSubgroup($groupId, $subgroupId);
			}
		}
		foreach ($perms as $permId => $state)
		{
			if (! in_array(['perm_id' => $permId, 'state' => '1'], $activePerms) && (int) $state === 1)
			{
				$this->aauth->allowGroup($permId, $groupId);
			}
			else if (! in_array(['perm_id' => $permId, 'state' => '0'], $activePerms) && (int) $state === 0)
			{
				$this->aauth->denyGroup($permId, $groupId);
			}
			else if ((in_array(['perm_id' => $permId, 'state' => '0'], $activePerms) || in_array(['perm_id' => $permId, 'state' => '1'], $activePerms)) && (int) $state === -1)
			{
				$this->aauth->removeGroupPerm($permId, $groupId);
			}
		}

		return redirect()->to('/admin/groups/edit/' . $groupId);
	}

	/**
	 * Show
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return redirect|void
	 */
	public function show(int $groupId)
	{
		if (! $this->aauth->getGroup($groupId))
		{
			return redirect()->to('/admin/groups');
		}

		$data['group']  = $this->aauth->getGroup($groupId);
		$data['groups'] = $this->aauth->listGroupSubgroups($groupId);
		$data['perms']  = $this->aauth->listGroupPerms($groupId);

		echo view('Admin/Groups/Show', $data);
	}

	/**
	 * Delete
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return redirect|void
	 */
	public function delete(int $groupId)
	{
		if (! $this->aauth->getGroup($groupId))
		{
			return redirect()->to('/admin/groups');
		}

		if ($groupId === $this->request->getPost('id'))
		{
			if ($this->aauth->deleteGroup($groupId))
			{
				return redirect()->to('/admin/groups');
			}
		}

		$data['group']  = $this->aauth->getGroup($groupId);
		$data['groups'] = $this->aauth->listGroupSubgroups($groupId);
		$data['perms']  = $this->aauth->listGroupPerms($groupId);

		echo view('Admin/Groups/Delete', $data);
	}

}
