<?php namespace Tests\Aauth\Libraries\Aauth;

use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use App\Libraries\Aauth;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class InfosTest extends \CIUnitTestCase
{
    public function setUp()
    {
        parent::setUp();

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

	public function testInfos()
	{
	    $this->library = new Aauth(NULL, TRUE);
		$this->assertCount(0, $this->library->getInfosArray());
		$this->library->info('test message 1');
		$this->assertEquals(['test message 1'], $this->library->getInfosArray());
	}

	public function testInfosArray()
	{
	    $this->library = new Aauth(NULL, TRUE);
		$this->assertCount(0, $this->library->getInfosArray());
		$this->library->info(['test message 1','test message 2']);
		$this->assertEquals(['test message 1','test message 2'], $this->library->getInfosArray());
	}

	public function testPrintInfosReturn()
	{
	    $this->library = new Aauth(NULL, TRUE);
		$this->library->info('test message 1');
		$this->assertEquals('test message 1', $this->library->printInfos('<br />', true));
		$this->library->info('test message 2');
		$this->assertEquals('test message 1<br />test message 2', $this->library->printInfos('<br />', true));
	}

	public function testPrintInfosEcho()
	{
	    $this->library = new Aauth(NULL, TRUE);
		$this->library->info('test message 1');
 		$this->library->printInfos('<br />');
 		$this->expectOutputString('test message 1');
	}

	public function testClearInfos()
	{
        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$this->library->info('test message 1', true);
		$this->assertEquals(['test message 1'], $session->get('infos'));
		$this->library->clearInfos();
		$this->assertNull($session->get('infos'));
	}

	public function testInfosFlash()
	{
        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$this->assertNull($session->get('infos'));
		$this->library->info('test message 1', true);
		$this->assertEquals(['test message 1'], $session->get('infos'));
	}

	public function testInfosFlashArray()
	{
        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$this->assertNull($session->get('infos'));
		$this->library->info(['test message 1','test message 2'], true);
		$this->assertEquals(['test message 1','test message 2'], $session->get('infos'));
	}
}
