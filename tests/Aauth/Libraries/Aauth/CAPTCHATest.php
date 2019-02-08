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

	public function testGenerateCaptchaHtml()
	{
		$config                 = new AauthConfig();
		$config->captchaEnabled = true;
		$this->library          = new Aauth($config, true);

		$this->assertEquals('', $this->library->generateCaptchaHtml());

		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');
		$this->library->login('admina@example.com', 'password123456');

		$this->assertContains('https://www.google.com/recaptcha', $this->library->generateCaptchaHtml());

		$config->captchaType = 'hcaptcha';
		$this->library       = new Aauth($config, true);

		$this->assertContains('https://hcaptcha.com/1', $this->library->generateCaptchaHtml());
	}

	public function testVerifyResponse()
	{
		$config                 = new AauthConfig();
		$config->captchaEnabled = true;
		$this->library          = new Aauth($config, true);

		$this->assertContains('missing-input', $this->library->verifyResponse(null)['errorCodes']);
		$this->assertContains('invalid-input-response', $this->library->verifyResponse('0123456789')['errorCodes']);

		$config->captchaType = 'hcaptcha';
		$this->library       = new Aauth($config, true);
		$this->assertContains('invalid-input-response', $this->library->verifyResponse('0123456789')['errorCodes']);
	}
}
