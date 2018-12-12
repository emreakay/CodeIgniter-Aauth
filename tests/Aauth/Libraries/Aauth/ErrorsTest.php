<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use App\Libraries\Aauth;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class ErrorsTest extends \CIUnitTestCase
{
	public function setUp()
	{
		parent::setUp();

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

	public function testErrors()
	{
		$this->assertCount(0, $this->library->getErrorsArray());
		$this->library->error('test message 1');
		$this->assertEquals(['test message 1'], $this->library->getErrorsArray());
	}

	public function testErrorsArray()
	{
		$this->assertCount(0, $this->library->getErrorsArray());
		$this->library->error(['test message 1', 'test message 2']);
		$this->assertEquals(['test message 1', 'test message 2'], $this->library->getErrorsArray());
	}

	public function testPrintErrors()
	{
		$this->library->error('test message 1');
		$this->assertEquals('test message 1', $this->library->printErrors('<br />', true));
		$this->library->error('test message 2');
		$this->assertEquals('test message 1<br />test message 2', $this->library->printErrors('<br />', true));

		$this->library->printErrors('<br />');
		$this->expectOutputString('test message 1<br />test message 2');
	}

	public function testClearErrors()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$this->library->error('test message 1', true);
		$this->assertEquals(['test message 1'], $session->getFlashdata('errors'));
		$this->library->clearErrors();
		$this->assertEquals([], $this->library->getErrorsArray());
		$this->assertNull($session->getFlashdata('errors'));
	}

	public function testErrorsFlash()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$this->assertNull($session->getFlashdata('errors'));
		$this->library->error('test message 1', true);
		$session->start();
		$this->assertEquals(['test message 1'], $session->getFlashdata('errors'));

		$this->library = new Aauth(null, $session);
		$this->library->error(['test message 1', 'test message 2'], true);
		$session->start();
		$this->assertEquals(['test message 1', 'test message 2'], $session->getFlashdata('errors'));
	}

	public function testErrorsFlashKeep()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$this->assertNull($session->getFlashdata('errors'));
		$this->library->error('test message 1 Flash', true);
		$session->start();
		$this->library->keepErrors();
		$session->start();
		$this->assertEquals(['test message 1 Flash'], $session->getFlashdata('errors'));
		$this->library = new Aauth(null, $session);
		$this->library->error('test message 1 NonFlash');
		$this->library->keepErrors(true);
		$session->start();
		$this->assertEquals(['test message 1 Flash', 'test message 1 NonFlash'], $session->getFlashdata('errors'));
	}
}
