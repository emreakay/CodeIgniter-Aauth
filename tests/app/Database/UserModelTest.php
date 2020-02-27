<?php namespace App\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\UserModel;

class UserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->model = new UserModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testFindReturnsRow()
	{
		$user = $this->model->find(1);
		$this->assertEquals('admin', $user['username']);
	}

	public function testUpdateLastLogin()
	{
		$this->model->updateLastLogin(1);
		$user = $this->model->asArray()->find(1);
		$this->assertCloseEnough(strtotime('now'), strtotime($user['last_login']), '', 5);
		$this->assertCloseEnough(strtotime('now'), strtotime($user['last_activity']), '', 5);
	}

	public function testUpdateLastActivity()
	{
		$this->model->updateLastActivity(1);
		$user = $this->model->asArray()->find(1);
		$this->assertCloseEnough(strtotime('now'), strtotime($user['last_activity']), '', 5);
	}

	public function testUpdateBanned()
	{
		$this->assertFalse($this->model->isBanned(1));

		$this->model->updateBanned(1, true);
		$this->assertTrue($this->model->isBanned(1));
	}

	public function testExistsById()
	{
		$this->assertTrue($this->model->existsById(1));

		$this->assertFalse($this->model->existsById(0));
	}

	public function testExistsByEmail()
	{
		$this->assertTrue($this->model->existsByEmail('admin@example.com'));

		$this->assertFalse($this->model->existsByEmail(''));
	}

	public function testExistsByUsername()
	{
		$this->assertTrue($this->model->existsByUsername('admin'));

		$this->assertFalse($this->model->existsByUsername(''));
	}

	public function testHashPasswordFilled()
	{
		$userOld = $this->model->asArray()->find(1);
		$this->model->update(1, ['id' => 1, 'password' => 'password123456']);
		$userNew = $this->model->asArray()->find(1);
		$this->assertNotEquals($userOld['password'], $userNew['password']);
		$this->assertNotEquals('password123456', $userNew['password']);

		$userOld = $this->model->asArray()->find(1);
		$this->model->update(1, ['id' => 1, 'username' => 'admin']);
		$userNew = $this->model->asArray()->find(1);
		$this->assertEquals($userOld['password'], $userNew['password']);
	}

	public function testLoginUseUsernameDummy()
	{
		$config = new AauthConfig();

		$config->loginUseUsername = true;

		$this->model = new UserModel($this->db, null, $config);
		$this->assertFalse($this->model->insert(['email' => 'test@test.local', 'password' => 'password123456', 'username' => '']));
	}
}
