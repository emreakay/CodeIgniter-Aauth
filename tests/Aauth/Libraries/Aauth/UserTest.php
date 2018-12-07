<?php namespace Tests\Aauth\Libraries\Aauth;

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

    }

    public function tearDown()
    {

    }

	//--------------------------------------------------------------------

	public function testUpdateUser()
	{
	    $this->library = new Aauth(null, true);
	    $userPre = $this->library->getUser(2);
    	$this->library->updateUser(2, 'user1@example.com', 'password987654', 'user1');
    	$user = $this->library->getUser(2);
    	$this->assertNotEquals($userPre['email'], $user['email']);
    	$this->assertNotEquals($userPre['username'], $user['username']);
    	$this->library->updateUser(2, null, null, 'user1');
    	$userAfter = $this->library->getUser(2);
    	$this->assertEquals($user['username'], $userAfter['username']);
	}

	public function testDeleteUser()
	{
	    $this->library = new Aauth(null, true);
	    $users = $this->library->listUsers();
		$this->assertCount(2, $users);
		$this->library->deleteUser(2);
	    $users = $this->library->listUsers();
		$this->assertCount(1, $users);
		$this->assertFalse($this->library->deleteUser(99));
	}

	public function testListUsers()
	{
	    $this->library = new Aauth(null, true);
	    $users = $this->library->listUsers();
		$this->assertCount(2, $users);
	}

	public function testGetUser()
	{
	    $this->library = new Aauth(null, true);
	    $user = $this->library->getUser(1);
		$this->assertEquals('1', $user['id']);
		$this->assertEquals('admin', $user['username']);
		$this->assertEquals('admin@example.com', $user['email']);
	}

	public function testGetUserUserVars()
	{
	    $this->library = new Aauth(null, true);
	    $user = $this->library->getUser(1, true);
		$this->assertInternalType('array', $user['variables']);
	}

	public function testGetUserId()
	{
	    $this->library = new Aauth(null, true);
	    $userIdEmail = $this->library->getUserId('admin@example.com');
		$this->assertEquals('1', $userIdEmail);
	    // $userIdNone = $this->library->getUserId();
		// $this->assertEquals('1', $userIdNone);
	}

	public function testBanUser()
	{
	    $this->library = new Aauth(null, true);
		$this->assertFalse($this->library->isBanned(1));
	    $this->library->banUser(1);
		$this->assertTrue($this->library->isBanned(1));
	}

	public function testUnbanUser()
	{
	    $this->library = new Aauth(null, true);
	    $this->library->banUser(1);
		$this->assertTrue($this->library->isBanned(1));
	    $this->library->unbanUser(1);
		$this->assertFalse($this->library->isBanned(1));
	}
}
