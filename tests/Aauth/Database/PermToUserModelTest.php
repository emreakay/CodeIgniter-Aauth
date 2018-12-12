<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
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

		$this->model  = new PermToUserModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------
	public function testInsert()
	{
		$permToUser = $this->model->insert(99, 99);
		$this->seeInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
	}

	public function testExists()
	{
		$permToUser = $this->model->exists(99, 99);
		$this->assertFalse($permToUser);

		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$permToUser = $this->model->exists(99, 99);
		$this->assertTrue($permToUser);
	}

	public function testFindAllByUserId()
	{
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(0, $permsToUser);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(1, $permsToUser);
	}

	public function testFindAllByPermId()
	{
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToUsers);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$permToUsers = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToUsers);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$criteria = [
			'perm_id' => 99,
			'user_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->delete(99, 99);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testDeleteAllByPermId()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$criteria = [
			'perm_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->deleteAllByPermId(99);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testDeleteAllByUserId()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$criteria = [
			'user_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->deleteAllByUserId(99);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToUserModel();
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 99,
			'user_id' => 99,
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 98,
			'user_id' => 99,
		]);
		$permsToUser = $this->model->findAllByUserId(99);
		$this->assertCount(2, $permsToUser);
	}
}
