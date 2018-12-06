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
class ErrorsTest extends \CIUnitTestCase
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

	public function testErrors()
	{
        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$this->assertCount(0, $this->library->getErrorsArray());
		$this->library->error('test message 1');
		$this->assertCount(1, $this->library->getErrorsArray());
	}

	public function testErrorsFlash()
	{
        $session = $this->getInstance();
	    $this->library = new Aauth(NULL, $session);
		$this->assertCount(0, $this->session->errors);
		$this->library->error('test message 1', true);
		$this->assertCount(1, $this->session->errors);
	}
}
