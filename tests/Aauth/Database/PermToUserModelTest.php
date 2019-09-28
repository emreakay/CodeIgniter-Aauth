<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\PermToUserModel;

class PermToUserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->config = new AauthConfig();

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$this->model = new PermToUserModel($this->db);
	}

	//--------------------------------------------------------------------
	public function testSave()
	{
		$this->model->save(1, 2, 1);
		$this->seeInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 1,
		]);

		$this->model->save(1, 2, 0);
		$this->seeInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 0,
		]);
	}

	public function testAllowed()
	{
		$this->assertFalse($this->model->allowed(1, 2));

		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 1,
		]);
		$this->assertTrue($this->model->allowed(1, 2));
	}

	public function testDenied()
	{
		$this->assertFalse($this->model->denied(1, 2));

		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 0,
		]);
		$this->assertTrue($this->model->denied(1, 2));
	}

	public function testFindAllByUserId()
	{
		$permsToUser = $this->model->findAllByUserId(2);
		$this->assertCount(0, $permsToUser);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 1,
		]);
		$permsToUser = $this->model->findAllByUserId(2, 1);
		$this->assertCount(1, $permsToUser);

		$permsToUser = $this->model->findAllByUserId(2, 0);
		$this->assertCount(0, $permsToUser);
	}

	public function testFindAllByPermId()
	{
		$permToUsers = $this->model->findAllByPermId(1);
		$this->assertCount(0, $permToUsers);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
		]);
		$permToUsers = $this->model->findAllByPermId(1);
		$this->assertCount(1, $permToUsers);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
		]);
		$criteria = [
			'perm_id' => 1,
			'user_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->delete(1, 2);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testDeleteAllByPermId()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
		]);
		$criteria = [
			'perm_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->deleteAllByPermId(1);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testDeleteAllByUserId()
	{
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
		]);
		$criteria = [
			'user_id' => 2,
		];
		$this->seeNumRecords(1, $this->config->dbTablePermToUser, $criteria);
		$this->model->deleteAllByUserId(2);
		$this->seeNumRecords(0, $this->config->dbTablePermToUser, $criteria);
	}

	public function testConfigDBPerm()
	{
		$this->model = new PermToUserModel();
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
		]);
		$permsToUser = $this->model->findAllByUserId(2);
		$this->assertCount(1, $permsToUser);
	}
}
