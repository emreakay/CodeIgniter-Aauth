<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupToGroupModel;

class GroupToGroupModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new GroupToGroupModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testExistsFalse()
	{
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertFalse($groupToGroup);
	}

	public function testExistsTrue()
	{
		$this->model->insert(99, 99);
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertTrue($groupToGroup);
	}

	public function testFindAllBySubgroupId()
	{
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(0, $groupsToGroup);
		$this->model->insert(99, 99);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(1, $groupsToGroup);
	}

	public function testFindAllByGroupId()
	{
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $groupToGroups);
		$this->model->insert(99, 99);
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $groupToGroups);
	}

	public function testDelete()
	{
		$this->model->insert(99, 99);
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertTrue($groupToGroup);
		$this->model->delete(99, 99);
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertFalse($groupToGroup);
	}

	public function testDeleteAllByGroupId()
	{
		$this->model->insert(99, 99);
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $groupToGroups);
		$this->model->deleteAllByGroupId(99);
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $groupToGroups);
	}

	public function testDeleteAllBySubgroupId()
	{
		$this->model->insert(99, 99);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(1, $groupsToGroup);
		$this->model->deleteAllBySubgroupId(99);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(0, $groupsToGroup);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToGroupModel();
		$this->model->insert(99, 99);
		$this->model->insert(98, 99);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(2, $groupsToGroup);
	}
}
