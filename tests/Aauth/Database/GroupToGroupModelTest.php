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

		$this->model  = new GroupToGroupModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testInsert()
	{
		$groupToGroup = $this->model->insert(99, 99);
		$this->seeInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
	}

	public function testExists()
	{
		$this->assertFalse($this->model->exists(99, 99));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$this->assertTrue($this->model->exists(99, 99));
	}

	public function testFindAllBySubgroupId()
	{
		$this->assertCount(0, $this->model->findAllBySubgroupId(99));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$this->assertCount(1, $this->model->findAllBySubgroupId(99));
	}

	public function testFindAllByGroupId()
	{
		$this->assertCount(0, $this->model->findAllByGroupId(99));

		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$this->assertCount(1, $this->model->findAllByGroupId(99));
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$criteria = [
			'group_id'    => 99,
			'subgroup_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->delete(99, 99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$criteria = [
			'group_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllByGroupId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testDeleteAllBySubgroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$criteria = [
			'subgroup_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToGroup, $criteria);
		$this->model->deleteAllBySubgroupId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToGroup, $criteria);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToGroupModel();
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 99,
			'subgroup_id' => 99,
		]);
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 98,
			'subgroup_id' => 99,
		]);
		$groupsToGroup = $this->model->findAllBySubgroupId(99);
		$this->assertCount(2, $groupsToGroup);
	}
}
