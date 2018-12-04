<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\PermToUserModel;

class PermToUserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new PermToUserModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testExistsFalse()
	{
		$permToUser = $this->model->exists(99, 99);
		$this->assertFalse($permToUser);
	}

	public function testExistsTrue()
	{
		$this->model->insert(99, 99);
		$permToUser = $this->model->exists(99, 99);
		$this->assertTrue($permToUser);
	}

	public function testFindAllByUserId()
	{
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(0, $permsToUser);
		$this->model->insert(99, 99);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(1, $permsToUser);
	}

	public function testFindAllByPermId()
	{
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToUsers);
		$this->model->insert(99, 99);
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToUsers);
	}

	public function testDelete()
	{
		$this->model->insert(99, 99);
		$permToUser = $this->model->exists(99, 99);
		$this->assertTrue($permToUser);
		$this->model->delete(99, 99);
		$permToUser = $this->model->exists(99, 99);
		$this->assertFalse($permToUser);
	}

	public function testDeleteAllByPermId()
	{
		$this->model->insert(99, 99);
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToUsers);
		$this->model->deleteAllByPermId(99);
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToUsers);
	}

	public function testDeleteAllByUserId()
	{
		$this->model->insert(99, 99);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(1, $permsToUser);
		$this->model->deleteAllByUserId(99);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(0, $permsToUser);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToUserModel();
		$this->model->insert(99, 99);
		$this->model->insert(98, 99);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(2, $permsToUser);
	}
}
