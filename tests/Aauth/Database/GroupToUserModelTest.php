<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupToUserModel;

class GroupToUserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

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
		$groupToGroup = $this->model->insert(1, 2);
		$this->seeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
	}

	public function testExists()
	{
		$this->assertFalse($this->model->exists(1, 2));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$this->assertTrue($this->model->exists(1, 2));
	}

	public function testFindAllByUserId()
	{
		$this->assertCount(1, $this->model->findAllByUserId(2));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$this->assertCount(2, $this->model->findAllByUserId(2));
	}

	public function testFindAllByGroupId()
	{
		$this->assertCount(1, $this->model->findAllByGroupId(1));

		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$this->assertCount(2, $this->model->findAllByGroupId(1));
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$criteria = [
			'group_id' => 1,
			'user_id'  => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupToUser, $criteria);
		$this->model->delete(1, 2);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$criteria = [
			'group_id' => 1,
		];
		$this->seeNumRecords(2, $this->config->dbTableGroupToUser, $criteria);
		$this->model->deleteAllByGroupId(1);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testDeleteAllByUserId()
	{
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$criteria = [
			'user_id' => 2,
		];
		$this->seeNumRecords(2, $this->config->dbTableGroupToUser, $criteria);
		$this->model->deleteAllByUserId(2);
		$this->seeNumRecords(0, $this->config->dbTableGroupToUser, $criteria);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupToUserModel();
		$this->hasInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);
		$groupToUsers = $this->model->findAllByUserId(2);
		$this->assertCount(2, $groupToUsers);
	}
}
