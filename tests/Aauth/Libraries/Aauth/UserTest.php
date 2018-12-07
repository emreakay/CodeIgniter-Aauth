<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
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
        $_COOKIE = [];
        $_SESSION = [];
    }

    public function tearDown()
    {

    }

    protected function getInstance($options=[])
    {
        $defaults = [
			'sessionDriver' => 'CodeIgniter\Session\Handlers\FileHandler',
			'sessionCookieName' => 'ci_session',
			'sessionExpiration' => 7200,
			'sessionSavePath' => 'null',
			'sessionMatchIP' => false,
			'sessionTimeToUpdate' => 300,
			'sessionRegenerateDestroy' => false,
			'cookieDomain' => '',
			'cookiePrefix' => '',
			'cookiePath' => '/',
			'cookieSecure' => false,
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
	    $userPre = $this->library->getUser(2);
    	$this->library->updateUser(2, 'user1@example.com', 'password987654', 'user1');
    	$user = $this->library->getUser(2);
    	$this->assertNotEquals($userPre['email'], $user['email']);
    	$this->assertNotEquals($userPre['username'], $user['username']);
    	$this->library->updateUser(2, null, null, 'user1');
    	$userAfter = $this->library->getUser(2);
    	$this->assertEquals($user['username'], $userAfter['username']);
    	$this->assertFalse($this->library->updateUser(2, 'asasdfasd'));
    	$this->assertFalse($this->library->updateUser(2));
	}

	public function testDeleteUser()
	{
	    $users = $this->library->listUsers();
		$this->assertCount(2, $users);
		$this->library->deleteUser(2);
	    $users = $this->library->listUsers();
		$this->assertCount(1, $users);
		$this->assertFalse($this->library->deleteUser(99));
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
		$this->assertFalse($this->library->getUser(99));

	    $userVar = $this->library->getUser(1, true);
		$this->assertInternalType('array', $userVar['variables']);

        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$session->set('user', [
			'id'       => 1,
		]);
	    $userIdNone = $this->library->getUser();
		$this->assertEquals('admin', $userIdNone['username']);
	}

	public function testGetUserId()
	{
	    $userIdEmail = $this->library->getUserId('admin@example.com');
		$this->assertEquals('1', $userIdEmail);

        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$session->set('user', [
			'id'       => 1,
		]);
	    $userIdNone = $this->library->getUserId();
		$this->assertEquals('1', $userIdNone);
	}

	public function testBanUser()
	{
		$this->assertFalse($this->library->isBanned(1));
	    $this->library->banUser(1);
		$this->assertTrue($this->library->isBanned(1));
	}

	public function testUnbanUser()
	{
	    $this->library->banUser(1);
		$this->assertTrue($this->library->isBanned(1));
	    $this->library->unbanUser(1);
		$this->assertFalse($this->library->isBanned(1));
	}
}
