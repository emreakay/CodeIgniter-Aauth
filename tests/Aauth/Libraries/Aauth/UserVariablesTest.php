<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;
use App\Models\Aauth\UserVariableModel;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class UserVariablesTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->library = new Aauth(null, null);
		$this->config  = new AauthConfig();
		$_COOKIE       = [];
		$_SESSION      = [];
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

	public function testSetUserVar()
	{
		$this->assertTrue($this->library->setUserVar('test_var', 'test', 1));
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);

		$this->assertTrue($this->library->setUserVar('test_var', 'test2'));
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test2',
		]);

		$this->assertFalse($this->library->setUserVar('test_var', 'test', 99));
	}

	public function testUnsetUserVar()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$this->assertTrue($this->library->unsetUserVar('test_var', 1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);

		$this->assertTrue($this->library->unsetUserVar('test_var'));

		$this->assertFalse($this->library->unsetUserVar('test_var', 99));
	}

	public function testGetUserVar()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$this->assertEquals('test', $this->library->getUserVar('test_var', 1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);

		$this->assertEquals('test', $this->library->getUserVar('test_var'));

		$this->assertFalse($this->library->getUserVar('test_var_99', 1));

		$this->assertFalse($this->library->getUserVar('test_var', 99));
	}

	public function testGetUserVars()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var2',
			'data_value' => 'test2',
		]);

		$this->assertCount(2, $this->library->listUserVars(1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);

		$this->assertCount(2, $this->library->listUserVars());

		$this->assertFalse($this->library->listUserVars(99));
	}

	public function testListUserVarKeys()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test_var2',
			'data_value' => 'test2',
		]);

		$this->assertCount(2, $this->library->getUserVarKeys(1));
		$this->assertEquals([['key' => 'test_var'], ['key' => 'test_var2']], $this->library->getUserVarKeys(1));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id' => 1,
		]);

		$this->assertCount(2, $this->library->getUserVarKeys());

		$this->assertFalse($this->library->getUserVarKeys(99));
	}
}
