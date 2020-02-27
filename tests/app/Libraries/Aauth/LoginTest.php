<?php namespace App\Libraries\Aauth;

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
use App\Models\Aauth\UserVariableModel;
use App\Models\Aauth\LoginTokenModel;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class LoginTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		Services::injectMock('response', new MockResponse(new App()));
		$this->response = service('response');
		$this->request  = new IncomingRequest(new App(), new URI(), null, new UserAgent());
		Services::injectMock('request', $this->request);

		$this->library = new Aauth(null);
		$_COOKIE       = [];
		$_SESSION      = [];
	}

	public function invokeMethod(&$object, $methodName, array $parameters = [])
	{
		$reflection = new \ReflectionClass(get_class($object));
		$method     = $reflection->getMethod($methodName);
		$method->setAccessible(true);
		return $method->invokeArgs($object, $parameters);
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

	public function testLogin()
	{
		$session                  = $this->getInstance();
		$config                   = new AauthConfig();
		$config->loginUseUsername = true;

		$this->library = new Aauth($config, $session);
		$this->assertTrue($this->library->login('admin', 'password123456'));

		$this->assertTrue($this->library->login('admin', 'password123456', true));
		$this->seeInDatabase($config->dbTableLoginTokens, [
			'user_id' => 1,
		]);

		$this->assertTrue($this->response->hasCookie('remember'));

		$this->hasInDatabase($config->dbTableUserSessions, [
			'id'         => md5(time()),
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => '__ci_last_regenerate|i:' . time() . ';user|a:4:{s:2:"id";s:1:"1";s:8:"username";s:5:"admin";s:5:"email";s:17:"admin@example.com";s:8:"loggedIn";b:1;}',
			'data'       => '__ci_last_regenerate|i:1551553466;user|a:4:{s:2:"id";s:1:"1";s:8:"username";s:5:"admin";s:5:"email";s:17:"admin@example.com";s:8:"loggedIn";b:1;}',
		]);

		$config->loginSingleMode = true;
		$this->library           = new Aauth($config, $session);

		$this->assertTrue($this->library->login('admin', 'password123456'));

		$config->loginSingleMode = false;
		$this->library           = new Aauth($config, $session);

		$this->assertFalse($this->library->login('admin', 'passwor'));
		$this->assertEquals(lang('Aauth.loginFailedUsername'), $this->library->getErrorsArray()[0]);

		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin', 'password1234'));
		$this->assertEquals(lang('Aauth.loginFailedAll'), $this->library->getErrorsArray()[0]);

		$config->loginSingleMode     = false;
		$config->loginAccurateErrors = true;
		$this->library               = new Aauth($config, $session);
		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin', 'password1234'));
		$this->assertEquals(lang('Aauth.loginFailedUsername'), $this->library->getErrorsArray()[0]);

		$this->library->clearErrors();
		$this->assertFalse($this->library->login('user99', 'password123456'));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, $session);
		$this->assertTrue($this->library->login('admin@example.com', 'password123456'));

		$this->assertFalse($this->library->login('adminaexample.com', 'password123456'));
		$this->assertEquals(lang('Aauth.loginFailedEmail'), $this->library->getErrorsArray()[0]);

		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin@example.com', 'passwor'));
		$this->assertEquals(lang('Aauth.loginFailedEmail'), $this->library->getErrorsArray()[0]);

		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admina@example.com', 'password123456'));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);

		$config                      = new AauthConfig();
		$config->loginAccurateErrors = true;
		$this->library               = new Aauth($config, $session);
		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin@example.com', 'password1234567'));
		$this->assertEquals(lang('Aauth.loginFailedEmail'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth(null, $session);

		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin@example.com', 'password1234567'));
		$this->assertEquals(lang('Aauth.loginFailedAll'), $this->library->getErrorsArray()[0]);

		$this->library->banUser(1);
		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin@example.com', 'password123456'));
		$this->assertEquals(lang('Aauth.invalidUserBanned'), $this->library->getErrorsArray()[0]);

		$userVariableModel = new UserVariableModel();
		$userVariableModel->save(1, 'verification_code', '12345678', true);
		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admin@example.com', 'password123456'));
		$this->assertEquals(lang('Aauth.notVerified'), $this->library->getErrorsArray()[0]);

		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->clearErrors();
		$this->assertFalse($this->library->login('admina@example.com', 'password123456'));
		$this->assertEquals(lang('Aauth.loginAttemptsExceeded'), $this->library->getErrorsArray()[0]);
	}

	public function testIsLoggedInCookie()
	{
		helper('text');
		$session        = $this->getInstance();
		$this->library  = new Aauth(null, $session);
		$config         = new AauthConfig();
		$randomString   = random_string('alnum', 32);
		$selectorString = random_string('alnum', 16);

		$_COOKIE[$config->loginRememberCookie] = base64_encode(1) . ';' . $randomString . ';' . $selectorString;

		$this->hasInDatabase($config->dbTableLoginTokens, [
			'user_id'       => 1,
			'random_hash'   => password_hash($randomString, PASSWORD_DEFAULT),
			'selector_hash' => password_hash($selectorString, PASSWORD_DEFAULT),
			'expires_at'    => date('Y-m-d H:i:s', strtotime('+1 week')),
		]);
		$this->assertTrue($this->library->isLoggedIn());
		$this->library->logout();
	}

	public function testIsLoggedInCookieInvalidUser()
	{
		helper('text');
		$session        = $this->getInstance();
		$this->library  = new Aauth(null, $session);
		$config         = new AauthConfig();
		$randomString   = random_string('alnum', 32);
		$selectorString = random_string('alnum', 16);
		$this->hasInDatabase($config->dbTableLoginTokens, [
			'user_id'       => 1,
			'random_hash'   => password_hash($randomString, PASSWORD_DEFAULT),
			'selector_hash' => password_hash($selectorString, PASSWORD_DEFAULT),
			'expires_at'    => date('Y-m-d H:i:s', strtotime('+1 week')),
		]);

		$_COOKIE['remember'] = base64_encode(2) . ';' . $randomString . ';' . $selectorString;

		$this->assertFalse($this->library->isLoggedIn());
		unset($_COOKIE);
	}

	public function testIsLoggedInCookieInvalidCookie($value = '')
	{
		helper('text');
		$session        = $this->getInstance();
		$this->library  = new Aauth(null, $session);
		$config         = new AauthConfig();
		$randomString   = random_string('alnum', 32);
		$selectorString = random_string('alnum', 16);

		$_COOKIE['remember'] = base64_encode(1) . ';' . $selectorString . ';' . $randomString;

		$this->assertFalse($this->library->isLoggedIn());
		unset($_COOKIE['remember']);
	}

	public function testIsLoggedInCookieExpired($value = '')
	{
		helper('text');
		$session        = $this->getInstance();
		$this->library  = new Aauth(null, $session);
		$config         = new AauthConfig();
		$randomString   = random_string('alnum', 32);
		$selectorString = random_string('alnum', 16);
		$this->hasInDatabase($config->dbTableLoginTokens, [
			'user_id'       => 1,
			'random_hash'   => password_hash($randomString, PASSWORD_DEFAULT),
			'selector_hash' => password_hash($selectorString, PASSWORD_DEFAULT),
			'expires_at'    => date('Y-m-d H:i:s', strtotime('-1 week')),
		]);
		$_COOKIE['remember'] = base64_encode(1) . ';' . $randomString . ';' . $selectorString;

		$this->assertFalse($this->library->isLoggedIn());
		unset($_COOKIE['remember']);
	}

	public function testLogout()
	{
		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'loggedIn' => true,
		]);
		$this->assertTrue($this->library->isLoggedIn());
		$this->library->logout();
		$this->library = new Aauth(null, $session);
		$this->assertFalse($this->library->isLoggedIn());
	}
}
