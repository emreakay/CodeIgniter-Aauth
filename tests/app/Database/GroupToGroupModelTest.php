<?php namespace App\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupToGroupModel;

class GroupToGroupModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = APPPATH . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->model  = new GroupToGroupModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testInsert()
	{
		$groupToGroup = $this->model->insert(1, 2);
		$this->seeInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
	}

	public function testExists()
	{
		$this->assertFalse($this->model->exists(1, 2));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$this->assertTrue($this->model->exists(1, 2));
	}

	public function testFindAllBySubgroupId()
	{
		$this->assertCount(0, $this->model->findAllBySubgroupId(2));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$this->assertCount(1, $this->model->findAllBySubgroupId(2));
	}

	public function testFindAllByGroupId()
	{
		$this->assertCount(0, $this->model->findAllByGroupId(1));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$this->assertCount(1, $this->model->findAllByGroupId(1));
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$criteria = [
			'group_id'    => 1,
			'subgroup_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->delete(1, 2);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$criteria = [
			'group_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllByGroupId(1);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllBySubgroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$criteria = [
			'subgroup_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllBySubgroupId(2);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToGroupModel();
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 2,
			'subgroup_id' => 2,
		]);
		$groupsToGroup = $this->model->findAllBySubgroupId(2);
		$this->assertCount(2, $groupsToGroup);
	}
}
