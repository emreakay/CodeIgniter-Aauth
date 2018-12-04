<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupToUserModel;

class GroupToUserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new GroupToUserModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testExistsFalse()
	{
		$groupToUser = $this->model->exists(99, 99);
		$this->assertFalse($groupToUser);
	}

	public function testExistsTrue()
	{
		$this->model->insert(99, 99);
		$groupToUser = $this->model->exists(99, 99);
		$this->assertTrue($groupToUser);
	}

	public function testFindAllByUserId()
	{
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(0, $groupToUsers);
		$this->model->insert(99, 99);
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(1, $groupToUsers);
	}

	public function testFindAllByGroupId()
	{
		$groupToUsers = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $groupToUsers);
		$this->model->insert(99, 99);
		$groupToUsers = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $groupToUsers);
	}

	public function testDelete()
	{
		$this->model->insert(99, 99);
		$groupToUser = $this->model->exists(99, 99);
		$this->assertTrue($groupToUser);
		$this->model->delete(99, 99);
		$groupToUser = $this->model->exists(99, 99);
		$this->assertFalse($groupToUser);
	}

	public function testDeleteAllByGroupId()
	{
		$this->model->insert(99, 99);
		$groupToUsers = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $groupToUsers);
		$this->model->deleteAllByGroupId(99);
		$groupToUsers = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $groupToUsers);
	}

	public function testDeleteAllByUserId()
	{
		$this->model->insert(99, 99);
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(1, $groupToUsers);
		$this->model->deleteAllByUserId(99);
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(0, $groupToUsers);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToUserModel();
		$this->model->insert(99, 99);
		$this->model->insert(98, 99);
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(2, $groupToUsers);
	}
}
