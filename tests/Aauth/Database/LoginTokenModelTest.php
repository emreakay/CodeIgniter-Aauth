<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\LoginTokenModel;

class LoginTokenModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model = new LoginTokenModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testInsert()
	{
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		$loginTokens = $this->model->findAllByUserId(99);
		$this->assertCount(1, $loginTokens);
	}

	public function testUpdate()
	{
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		$oldLoginTokens = $this->model->findAllByUserId(99);
		sleep(2);
		$this->model->update($oldLoginTokens[0]['id']);
		$loginTokens = $this->model->findAllByUserId(99);
		$this->assertNotEquals($oldLoginTokens[0]['expires_at'], $loginTokens[0]['expires_at']);
	}

	public function testDeleteExpired()
	{
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		sleep(2);
		$this->model->deleteExpired(99);
		$this->assertCount(0, $this->model->findAllByUserId(99));
	}

	public function testConfigDBGroup()
	{
		$this->model = new LoginTokenModel();
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		$loginTokens = $this->model->findAllByUserId(99);
		$this->assertCount(1, $loginTokens);
	}
}
