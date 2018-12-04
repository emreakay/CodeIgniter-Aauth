<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\UserModel as UserModel;

class UserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
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
		$this->assertTrue((strtotime("-5 seconds") < strtotime($user['last_login']) && strtotime("+5 seconds") > strtotime($user['last_login'])) && strtotime("-5 seconds") < strtotime($user['last_activity']) && strtotime("+5 seconds") > strtotime($user['last_activity']));
	}

	public function testUpdateLastActivity()
	{
		$this->model->updateLastActivity(1);
		$user = $this->model->asArray()->find(1);
		$this->assertTrue(strtotime("-5 seconds") < strtotime($user['last_activity']) && strtotime("+5 seconds") > strtotime($user['last_activity']));
	}

	public function testUpdateBannedTrue()
	{
		$this->model->updateBanned(1, TRUE);
		$this->assertTrue($this->model->isBanned(1));
	}

	public function testUpdateBannedFalse()
	{
		$this->model->updateBanned(1, FALSE);
		$this->assertFalse($this->model->isBanned(1));
	}

	public function testExistsByIdTrue()
	{
		$this->assertTrue($this->model->existsById(1));
	}

	public function testExistsByIdFalse()
	{
		$this->assertFalse($this->model->existsById(0));
	}

	public function testExistsByEmailTrue()
	{
		$this->assertTrue($this->model->existsByEmail("admin@example.com"));
	}

	public function testExistsByEmailFalse()
	{
		$this->assertFalse($this->model->existsByEmail(""));
	}

	public function testExistsByUsernameTrue()
	{
		$this->assertTrue($this->model->existsByUsername("admin"));
	}

	public function testExistsByUsernameFalse()
	{
		$this->assertFalse($this->model->existsByUsername(""));
	}

	public function testHashPasswordFilled()
	{
		$userOld = $this->model->asArray()->find(1);
		$this->model->update(1, ['id' => 1, 'password' => 'password123456']);
		$userNew = $this->model->asArray()->find(1);
		$this->assertTrue($userOld['password'] != $userNew['password'] && $userNew['password'] != 'password123456');
	}

	public function testHashPasswordNotSet()
	{
		$userOld = $this->model->asArray()->find(1);
		$this->model->update(1, ['id' => 1, 'username' => 'admin']);
		$userNew = $this->model->asArray()->find(1);
		$this->assertEquals($userOld['password'], $userNew['password']);
	}

	public function testLoginUseUsernameDummy()
	{
		$config = new \Config\Aauth();
		$config->loginUseUsername = TRUE;

		$this->model = new UserModel($this->db, null, $config);
		$newUser = $this->model->insert(['email' => 'test@test.local', 'password' => 'password123456']);
		$this->assertFalse($newUser);
	}
}
