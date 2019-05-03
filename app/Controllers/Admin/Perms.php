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
 * Aauth Admin/Perms Controller
 *
 * @package CodeIgniter-Aauth
 */
class Perms extends Controller
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
		$data = $this->aauth->listPermsPaginated();

		$data['pagerLinks'] = $data['pager']->links();
		$data['cssFiles']   = [
			'/assets/css/admin/perms/index.css'
		];

		echo view('Admin/Perms/Home', $data);
	}

	/**
	 * New
	 *
	 * @return void
	 */
	public function new()
	{
		echo view('Admin/Perms/New');
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

		if (! $this->aauth->createPerm($name, $definition))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		return redirect()->to('/admin/perms');
	}

	/**
	 * Edit
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return redirect|void
	 */
	public function edit(int $permId)
	{
		if (! $this->aauth->getPerm($permId))
		{
			return redirect()->to('/admin/perms');
		}

		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Admin/Perms/Edit', $data);
	}

	/**
	 * Update
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return redirect
	 */
	public function update(int $permId)
	{
		$name       = $this->request->getPost('name');
		$definition = $this->request->getPost('definition');

		if (! $this->aauth->updatePerm($permId, empty($name) ? null : $name, empty($definition) ? null : $definition))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		return redirect()->to('/admin/perms/edit/' . $permId);
	}

	/**
	 * Show
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return redirect|void
	 */
	public function show(int $permId)
	{
		if (! $this->aauth->getPerm($permId))
		{
			return redirect()->to('/admin/perms');
		}

		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Admin/Perms/Show', $data);
	}

	/**
	 * Delete
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return redirect|void
	 */
	public function delete(int $permId)
	{
		if (! $this->aauth->getPerm($permId))
		{
			return redirect()->to('/admin/perms');
		}

		if ($permId === $this->request->getPost('id'))
		{
			if ($this->aauth->deletePerm($permId))
			{
				return redirect()->to('/admin/perms');
			}
		}

		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Admin/Perms/Delete', $data);
	}

}
