<?php namespace Tests\Aauth\Libraries;

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
class AauthTest extends \CIUnitTestCase
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

        var_dump($_SESSION);

        return $session;
    }

	//--------------------------------------------------------------------

	public function testIsLoggedIn()
	{
        $session = $this->getInstance();

	    $this->library = new Aauth(NULL, $session);

		$this->assertFalse($this->library->isLoggedIn());
	}

	public function testTest()
	{
        $session = $this->getInstance();
        $session->start();

        $session->set('foo', 'bar');

        $this->assertEquals('bar', $_SESSION['foo']);
	}
}
