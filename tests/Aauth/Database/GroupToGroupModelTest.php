<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
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
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testExistsFalse()
	{
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertFalse($groupToGroup);
	}

	public function testExistsTrue()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$groupToGroup = $this->model->exists(99, 99);
		$this->assertTrue($groupToGroup);
	}

	public function testFindAllBySubgroupId()
	{
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(0, $groupsToGroup);
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(1, $groupsToGroup);
	}

	public function testFindAllByGroupId()
	{
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $groupToGroups);
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$groupToGroups = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $groupToGroups);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$criteria = [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->delete(99, 99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$criteria = [
		    'group_id' => 99
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllByGroupId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllBySubgroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$criteria = [
		    'subgroup_id' => 99
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllBySubgroupId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToGroupModel();
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 99,
		    'subgroup_id' => 99,
		]);
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
		    'group_id' => 98,
		    'subgroup_id' => 99,
		]);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(2, $groupsToGroup);
	}
}
