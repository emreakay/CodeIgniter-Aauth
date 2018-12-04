<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\PermToGroupModel;

class PermToGroupModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new PermToGroupModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testExistsFalse()
	{
		$permToGroup = $this->model->exists(99, 99);
		$this->assertFalse($permToGroup);
	}

	public function testExistsTrue()
	{
		$this->model->insert(99, 99);
		$permToGroup = $this->model->exists(99, 99);
		$this->assertTrue($permToGroup);
	}

	public function testFindAllByGroupId()
	{
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $permsToGroup);
		$this->model->insert(99, 99);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $permsToGroup);
	}

	public function testFindAllByPermId()
	{
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToGroups);
		$this->model->insert(99, 99);
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToGroups);
	}

	public function testDelete()
	{
		$this->model->insert(99, 99);
		$permToGroup = $this->model->exists(99, 99);
		$this->assertTrue($permToGroup);
		$this->model->delete(99, 99);
		$permToGroup = $this->model->exists(99, 99);
		$this->assertFalse($permToGroup);
	}

	public function testDeleteAllByPermId()
	{
		$this->model->insert(99, 99);
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToGroups);
		$this->model->deleteAllByPermId(99);
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToGroups);
	}

	public function testDeleteAllByGroupId()
	{
		$this->model->insert(99, 99);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $permsToGroup);
		$this->model->deleteAllByGroupId(99);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $permsToGroup);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToGroupModel();
		$this->model->insert(99, 99);
		$this->model->insert(98, 99);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(2, $permsToGroup);
	}
}
