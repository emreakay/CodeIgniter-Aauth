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

		$this->config = new AauthConfig();

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$this->model = new PermToGroupModel($this->db);
	}

	//--------------------------------------------------------------------
	public function testSave()
	{
		$this->model->save(1, 2, 1);
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 1,
		]);

		$this->model->save(1, 2, 0);
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 0,
		]);
	}

	public function testAllowed()
	{
		$this->assertFalse($this->model->allowed(1, 2));

		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 1,
		]);
		$this->assertTrue($this->model->allowed(1, 2));
	}

	public function testDenied()
	{
		$this->assertFalse($this->model->denied(1, 2));

		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 0,
		]);
		$this->assertTrue($this->model->denied(1, 2));
	}

	public function testFindAllByGroupId()
	{
		$permsToGroup = $this->model->findAllByGroupId(2);
		$this->assertCount(0, $permsToGroup);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 1,
		]);
		$permsToGroup = $this->model->findAllByGroupId(2, 1);
		$this->assertCount(1, $permsToGroup);

		$permsToGroup = $this->model->findAllByGroupId(2, 0);
		$this->assertCount(0, $permsToGroup);
	}

	public function testFindAllByPermId()
	{
		$permToGroups = $this->model->findAllByPermId(1);
		$this->assertCount(0, $permToGroups);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
		]);
		$permToGroups = $this->model->findAllByPermId(1);
		$this->assertCount(1, $permToGroups);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
		]);
		$criteria = [
			'perm_id'  => 1,
			'group_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->delete(1, 2);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testDeleteAllByPermId()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
		]);
		$criteria = [
			'perm_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->deleteAllByPermId(1);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
		]);
		$criteria = [
			'group_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToGroup, $criteria);
		$this->model->deleteAllByGroupId(2);
		$this->seeNumRecords(0, $this->config->dbTablePermToGroup, $criteria);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToGroupModel();
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
		]);
		$permsToGroup = $this->model->findAllByGroupId(2);
		$this->assertCount(1, $permsToGroup);
	}
}
