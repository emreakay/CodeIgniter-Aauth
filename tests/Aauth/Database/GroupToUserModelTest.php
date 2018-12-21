<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
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

		$this->model  = new GroupToUserModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testInsert()
	{
		$groupToGroup = $this->model->insert(99, 99);
		$this->seeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
	}

	public function testExists()
	{
		$this->assertFalse($this->model->exists(99, 99));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$this->assertTrue($this->model->exists(99, 99));
	}

	public function testFindAllByUserId()
	{
		$this->assertCount(0, $this->model->findAllByUserId(99));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$this->assertCount(1, $this->model->findAllByUserId(99));
	}

	public function testFindAllByGroupId()
	{
		$this->assertCount(0, $this->model->findAllByGroupId(99));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$this->assertCount(1, $this->model->findAllByGroupId(99));
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$criteria = [
			'group_id' => 99,
			'user_id'  => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToUser, $criteria);
		$this->model->delete(99, 99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$criteria = [
			'group_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToUser, $criteria);
		$this->model->deleteAllByGroupId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testDeleteAllByUserId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$criteria = [
			'user_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToUser, $criteria);
		$this->model->deleteAllByUserId(99);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToUserModel();
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 99,
			'user_id'  => 99,
		]);
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 98,
			'user_id'  => 99,
		]);
		$groupToUsers = $this->model->findAllByUserId(99);
		$this->assertCount(2, $groupToUsers);
	}
}
