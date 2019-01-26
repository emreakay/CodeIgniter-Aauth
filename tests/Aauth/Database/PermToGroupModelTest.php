<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\PermToGroupModel;

class PermToGroupModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model  = new PermToGroupModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------
	public function testSave()
	{
		$this->model->save(99, 99, 1);
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
			'state'    => 1,
		]);

		$this->model->save(99, 99, 0);
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
			'state'    => 0,
		]);
	}

	public function testAllowed()
	{
		$this->assertFalse($this->model->allowed(99, 99));

		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
			'state'    => 1,
		]);
		$this->assertTrue($this->model->allowed(99, 99));
	}

	public function testDenied()
	{
		$this->assertFalse($this->model->denied(99, 99));

		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
			'state'    => 0,
		]);
		$this->assertTrue($this->model->denied(99, 99));
	}

	public function testFindAllByGroupId()
	{
		$permsToGroup = $this->model->findAllByGroupId(99);
		$this->assertCount(0, $permsToGroup);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 99,
			'group_id' => 99,
			'state'    => 1,
		]);
		$permsToGroup = $this->model->findAllByGroupId(99, 1);
		$this->assertCount(1, $permsToGroup);

		$permsToGroup = $this->model->findAllByGroupId(99, 0);
		$this->assertCount(0, $permsToGroup);
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
