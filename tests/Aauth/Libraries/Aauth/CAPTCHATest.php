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
use App\Models\Aauth\UserVariableModel;
use App\Models\Aauth\LoginTokenModel;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class CAPTCHATest extends CIDatabaseTestCase
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

		$this->library = new Aauth(null, null);
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

	public function testGenerateCaptchaHtml()
	{
		$config                 = new AauthConfig();
		$config->captchaEnabled = true;
		$this->library          = new Aauth($config, null);

		$this->assertEquals('', $this->library->generateCaptchaHtml());

		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$_POST['g-recaptcha-response'] = '0123456789';
		$this->library->login('admina@example.com', 'password123456');

		$this->assertContains('https://www.google.com/recaptcha', $this->library->generateCaptchaHtml());

		$config->captchaType           = 'hcaptcha';
		$this->library                 = new Aauth($config, null);
		$_POST['h-recaptcha-response'] = '0123456789';
		$this->library->login('admina@example.com', 'password123456');
		$this->assertEquals(lang('Aauth.invalidCaptcha'), $this->library->getErrorsArray()[0]);
		$this->assertContains('https://hcaptcha.com/1', $this->library->generateCaptchaHtml());
	}

	public function testVerifyCaptchaResponse()
	{
		$config                 = new AauthConfig();
		$config->captchaEnabled = true;
		$this->library          = new Aauth($config, null);

		$this->assertContains('missing-input', $this->library->verifyCaptchaResponse('')['errorCodes']);
		$this->assertContains('invalid-input-response', $this->library->verifyCaptchaResponse('0123456789')['errorCodes']);

		// $config->captchaType    = 'hcaptcha';
		// $config->captchaSiteKey = '10000000-ffff-ffff-ffff-000000000001';
		// $config->captchaSecret  = '0x0000000000000000000000000000000000000000';
		// $this->library          = new Aauth($config, null);

		// $this->assertContains('invalid-input-response', $this->library->verifyCaptchaResponse('0123456789')['errorCodes']);
		// $this->assertTrue($this->library->verifyCaptchaResponse('testing')['success']);
	}
}
