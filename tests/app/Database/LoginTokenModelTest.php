<?php namespace App\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\LoginTokenModel;

class LoginTokenModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = APPPATH . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->model = new LoginTokenModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testInsert()
	{
		$this->model->insert(['user_id' => 1, 'random_hash' => 'random_hash11']);
		$loginTokens = $this->model->findAllByUserId(1);
		$this->assertCount(1, $loginTokens);
	}

	public function testUpdate()
	{
		$this->model->insert(['user_id' => 1, 'random_hash' => 'random_hash11']);
		$oldLoginTokens = $this->model->findAllByUserId(1);
		sleep(2);
		$this->model->update($oldLoginTokens[0]['id']);
		$loginTokens = $this->model->findAllByUserId(1);
		$this->assertNotEquals($oldLoginTokens[0]['expires_at'], $loginTokens[0]['expires_at']);
	}

	public function testDeleteExpired()
	{
		$this->model->insert(['user_id' => 1, 'random_hash' => 'random_hash11']);
		sleep(2);
		$this->model->deleteExpired(1);
		$this->assertCount(0, $this->model->findAllByUserId(1));
	}

	public function testDeleteAll()
	{
		$this->model->insert(['user_id' => 1, 'random_hash' => 'random_hash11']);
		$this->model->deleteAll(1);
		$this->assertCount(0, $this->model->findAllByUserId(1));
	}

	public function testConfigDBGroup()
	{
		$this->model = new LoginTokenModel();
		$this->model->insert(['user_id' => 1, 'random_hash' => 'random_hash11']);
		$loginTokens = $this->model->findAllByUserId(1);
		$this->assertCount(1, $loginTokens);
	}
}
