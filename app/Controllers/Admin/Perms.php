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
		$data = $this->aauth->listPermsPaginated();

		$data['cssFiles'] = [
			'/assets/css/admin/perms/index.css'
		];

		echo view('Templates/HeaderAdmin', $data);
		echo view('Admin/Perms/Home', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * New
	 *
	 * @return void
	 */
	public function new()
	{
		echo view('Templates/HeaderAdmin');
		echo view('Admin/Perms/New');
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

		if (! $this->aauth->createPerm($name, $definition))
		{
			return redirect()->back()->with('errors', $this->aauth->getErrorsArray());
		}

		return redirect()->to('/admin/perms');
	}

	/**
	 * Edit
	 *
	 * @return void
	 */
	public function edit($permId)
	{
		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Perms/Edit', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Update
	 *
	 * @return void
	 */
	public function update($permId)
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
	 * @return void
	 */
	public function show($permId)
	{
		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Perms/Show', $data);
		echo view('Templates/FooterAdmin');
	}

	/**
	 * Delete
	 *
	 * @return void
	 */
	public function delete($permId)
	{
		if (! $this->aauth->getPerm($permId))
		{
			return redirect()->to('/admin/perms');
		}

		$id = $this->request->getPost('id');
		if ($permId === $id)
		{
			if ($this->aauth->deletePerm($permId))
			{
				return redirect()->to('/admin/perms');
			}
		}

		$data['perm'] = $this->aauth->getPerm($permId);

		echo view('Templates/HeaderAdmin');
		echo view('Admin/Perms/Delete', $data);
		echo view('Templates/FooterAdmin');
	}

}
