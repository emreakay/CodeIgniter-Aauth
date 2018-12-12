<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\LoginTokenModel;

class LoginTokenModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

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
		$oldLoginToken  = $oldLoginTokens[0];
		sleep(5);
		$this->model->update($oldLoginToken['id']);
		$loginTokens = $this->model->findAllByUserId(99);
		$loginToken  = $loginTokens[0];
		$this->assertNotEquals($oldLoginToken['expires_at'], $loginToken['expires_at']);
	}

	public function testDeleteExpired()
	{
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		sleep(5);
		$this->model->deleteExpired(99);
		$loginTokens = $this->model->findAllByUserId(99);
		$this->assertCount(0, $loginTokens);
	}

	public function testConfigDBGroup()
	{
		$this->model = new LoginTokenModel();
		$this->model->insert(['user_id' => 99, 'random_hash' => 'random_hash9999']);
		$loginTokens = $this->model->findAllByUserId(99);
		$this->assertCount(1, $loginTokens);
	}
}
