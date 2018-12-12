<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class UserTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->library = new Aauth(null, true);
		$this->config  = new AauthConfig();
		$_COOKIE       = [];
		$_SESSION      = [];
	}

	public function tearDown()
	{
	}

	protected function getInstance($options = [])
	{
		$defaults = [
			'sessionDriver'            => 'CodeIgniter\Session\Handlers\FileHandler',
			'sessionCookieName'        => 'ci_session',
			'sessionExpiration'        => 7200,
			'sessionSavePath'          => 'null',
			'sessionMatchIP'           => false,
			'sessionTimeToUpdate'      => 300,
			'sessionRegenerateDestroy' => false,
			'cookieDomain'             => '',
			'cookiePrefix'             => '',
			'cookiePath'               => '/',
			'cookieSecure'             => false,
		];

		$config = (object)$defaults;

		$session = new MockSession(new FileHandler($config, Services::request()->getIPAddress()), $config);
		$session->setLogger(new TestLogger(new Logger()));
		$session->start();

		return $session;
	}

	//--------------------------------------------------------------------

	public function testUpdateUser()
	{
		$this->library = new Aauth(null, true);
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'       => 2,
			'email'    => 'user@example.com',
			'username' => 'user',
		]);
		$this->library->updateUser(2, 'user1@example.com', 'password987654', 'user1');
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'       => 2,
			'email'    => 'user1@example.com',
			'username' => 'user1',
		]);
		$this->assertEquals(lang('Aauth.infoUpdateSuccess'), $this->library->getInfosArray()[0]);

		// moved to UserModelTest, not working here :/
		// $this->assertFalse($this->library->updateUser(2, 'admin@example.com', null, null));
		// $this->assertEquals(lang('Aauth.existsAlreadyEmail'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2, 'adminexample.com', null, null));
		// $this->assertEquals(lang('Aauth.invalidEmail'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2, null, 'pass', null));
		// $this->assertEquals(lang('Aauth.invalidPassword'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2, null, 'password12345678901011121314151617', null));
		// $this->assertEquals(lang('Aauth.invalidPassword'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2, null, null, 'admin'));
		// $this->assertEquals(lang('Aauth.existsAlreadyUsername'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2, null, null, 'user+'));
		// $this->assertEquals(lang('Aauth.invalidUsername'), $this->library->getErrorsArray()[0]);

		// $this->assertFalse($this->library->updateUser(2));
		// $this->assertCount(0, $this->library->getErrorsArray());

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->updateUser(99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testDeleteUser()
	{
		$this->seeNumRecords(2, $this->config->dbTableUsers, ['deleted' => 0]);
		$this->library->deleteUser(2);
		$this->seeNumRecords(1, $this->config->dbTableUsers, ['deleted' => 0]);

		$this->assertFalse($this->library->deleteUser(99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testListUsers()
	{
		$users = $this->library->listUsers();
		$this->assertCount(2, $users);
		$this->assertEquals('admin', $users[0]['username']);
		$this->assertEquals('user', $users[1]['username']);

		$usersOrderBy = $this->library->listUsers(0, 0, null, 'id DESC');
		$this->assertEquals('user', $usersOrderBy[0]['username']);
		$this->assertEquals('admin', $usersOrderBy[1]['username']);
	}

	public function testGetUser()
	{
		$user = $this->library->getUser(1);
		$this->assertEquals('1', $user['id']);
		$this->assertEquals('admin', $user['username']);
		$this->assertEquals('admin@example.com', $user['email']);

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);
		$userIdNone = $this->library->getUser();
		$this->assertEquals('admin', $userIdNone['username']);

		$userVar = $this->library->getUser(1, true);
		$this->assertInternalType('array', $userVar['variables']);

		$this->assertFalse($this->library->getUser(99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testGetUserId()
	{
		$userIdEmail = $this->library->getUserId('admin@example.com');
		$this->assertEquals('1', $userIdEmail);

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);
		$userIdNone = $this->library->getUserId();
		$this->assertEquals('1', $userIdNone);

		$this->assertFalse($this->library->getUserId('none@example.com'));
	}

	public function testBanUser()
	{
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 0,
		]);
		$this->library->banUser(1);
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 1,
		]);

		$this->assertFalse($this->library->banUser(99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testUnbanUser()
	{
		$this->library->banUser(1);
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 1,
		]);
		$this->library->unbanUser(1);
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 0,
		]);

		$this->assertFalse($this->library->unbanUser(99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testBanUnbanUserSession()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);
		$this->library->banUser();
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 1,
		]);
		$this->library->unbanUser();
		$this->seeInDatabase($this->config->dbTableUsers, [
			'id'     => 1,
			'banned' => 0,
		]);
	}

	public function testIsBanned()
	{
		$this->assertFalse($this->library->isBanned(1));

		$this->library->banUser(1);
		$this->assertTrue($this->library->isBanned(1));

		$this->assertTrue($this->library->isBanned(99));
	}
}
