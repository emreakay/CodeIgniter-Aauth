<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\App;
use Config\Logger;
use Tests\Support\Log\TestLogger;
use Tests\Support\HTTP\MockResponse;
use Tests\Support\Session\MockSession;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;

class AccessTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		Services::injectMock('response', new MockResponse(new App()));
		$this->response = service('response');
		$this->request  = new IncomingRequest(new App(), new URI(), null, new UserAgent());
		Services::injectMock('request', $this->request);

		$this->library = new Aauth(null, true);
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

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsLoggedIn()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isLoggedIn());
		$session->remove('user');
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsMember()
	{
		$config = new AauthConfig();
		$this->assertTrue($this->library->isMember($config->groupDefault, 1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isMember($config->groupDefault));
		$session->remove('user');
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsAdmin()
	{
		$this->assertTrue($this->library->isAdmin(1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isAdmin());
		$session->remove('user');
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsAllowed()
	{
		$config = new AauthConfig();
		$this->hasInDatabase($config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$this->assertTrue($this->library->isAllowed('testPerm1', 1));
		$this->assertFalse($this->library->isAllowed('testPerm1', 2));

		$this->hasInDatabase($config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 1,
		]);
		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->isAllowed('testPerm1', 2));

		$this->hasInDatabase($config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 2,
			'state'   => 1,
		]);
		$this->assertTrue($this->library->isAllowed('testPerm1', 2));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isAllowed('testPerm1'));
		$session->remove('user');

		$this->assertFalse($this->library->isAllowed('testPerm99', 2));
		$this->assertFalse($this->library->isAllowed('testPerm1', 99));
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsGroupAllowed()
	{
		$config = new AauthConfig();
		$this->hasInDatabase($config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);

		$this->assertTrue($this->library->isGroupAllowed('testPerm1', $config->groupAdmin));

		$session->set('user', [
			'id'       => 2,
			'loggedIn' => true,
		]);
		$this->assertFalse($this->library->isGroupAllowed('testPerm1'));
		$session->remove('user');

		$this->hasInDatabase($config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 1,
		]);
		$this->assertTrue($this->library->isGroupAllowed('testPerm1', 2));

		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isGroupAllowed('testPerm1'));
		$session->remove('user');

		$session->set('user', [
			'id'       => 2,
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isGroupAllowed('testPerm1'));
		$session->remove('user');

		$this->assertFalse($this->library->isGroupAllowed('testPerm1'));
		$this->assertFalse($this->library->isGroupAllowed('testPerm1', 3));
		$this->assertFalse($this->library->isGroupAllowed('testPerm99', 2));
		$this->assertFalse($this->library->isGroupAllowed('testPerm1', 99));
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsGroupAllowedSubgroup()
	{
		$config = new AauthConfig();
		$this->hasInDatabase($config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroups1',
			'definition' => 'Test Group 1',
		]);
		$this->hasInDatabase($config->dbTableGroupToGroup, [
			'group_id'    => 2,
			'subgroup_id' => 4,
		]);
		$this->hasInDatabase($config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 4,
			'state'    => 1,
		]);

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->isGroupAllowed('testPerm1', 2));
	}
}
