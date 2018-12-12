<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
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

		$this->model  = new PermToGroupModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------
	public function testInsert()
	{
		$permToGroup = $this->model->insert(99, 99);
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
	}

	public function testExists()
	{
		$permToGroup = $this->model->exists(99, 99);
		$this->assertFalse($permToGroup);

		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$permToGroup = $this->model->exists(99, 99);
		$this->assertTrue($permToGroup);
	}

	public function testFindAllByGroupId()
	{
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $permsToGroup);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(1, $permsToGroup);
	}

	public function testFindAllByPermId()
	{
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(0, $permToGroups);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$permToGroups = $this->model->findAllByPermId(99);
		$this->assertCount(1, $permToGroups);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$criteria = [
			'perm_id'  => 99,
			'group_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->delete(99, 99);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testDeleteAllByPermId()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$criteria = [
			'perm_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->deleteAllByPermId(99);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$criteria = [
			'group_id' => 99,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->deleteAllByGroupId(99);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToGroupModel();
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 98,
			'group_id' => 99,
		]);
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(2, $permsToGroup);
	}
}
