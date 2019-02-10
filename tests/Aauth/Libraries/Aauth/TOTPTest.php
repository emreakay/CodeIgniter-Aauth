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
use OTPHP\TOTP;

class TOTPTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->library = new Aauth(null, true);
		$this->config  = new AauthConfig();
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
	public function testUpdateUserTotpSecret()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, true);

		$this->assertTrue($this->library->updateUserTotpSecret(99, 'TESTSECRET99'));
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 99,
			'data_key'   => 'totp_secret',
			'data_value' => 'TESTSECRET99',
			'system'     => true,
		]);

		$session       = $this->getInstance();
		$this->library = new Aauth($config, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);

		$this->assertTrue($this->library->updateUserTotpSecret(null, 'TESTSECRET1'));
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'totp_secret',
			'data_value' => 'TESTSECRET1',
			'system'     => true,
		]);
	}

	public function testGenerateUniqueTotpSecret()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, true);

		$this->assertInternalType('string', $this->library->generateUniqueTotpSecret());
	}

	public function testGenerateTotpQrCode()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, true);

		$this->assertInternalType('string', $this->library->generateTotpQrCode('testsecret'));
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testVerifyUserTotpCode()
	{
		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->totpEnabled = true;
		$this->library       = new Aauth($config, $session);

		$this->assertTrue($this->library->verifyUserTotpCode('999000', 1));

		$this->library = new Aauth($config, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);

		$this->assertTrue($this->library->verifyUserTotpCode('999000'));

		$session       = $this->getInstance();
		$this->library = new Aauth($config, $session);
		$session->set('user', [
			'id'            => 1,
			'loggedIn'      => true,
			'totp_required' => true,
		]);

		$this->assertTrue($this->library->verifyUserTotpCode('999000'));
		$this->assertTrue($this->library->verifyUserTotpCode('999000', 1));

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'totp_secret',
			'data_value' => 'JBSWY3DPEHPK3PXP',
			'system'     => true,
		]);
		$this->assertFalse($this->library->verifyUserTotpCode('999000', 1));

		$totp     = TOTP::create('JBSWY3DPEHPK3PXP');
		$totpCode = $totp->now();
		usleep(1000);

		$this->assertTrue($this->library->verifyUserTotpCode($totpCode, 1));
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testIsTotpRequired()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, true);

		$this->assertFalse($this->library->isTotpRequired());

		$session       = $this->getInstance();
		$this->library = new Aauth($config, $session);
		$session->set('user', [
			'id'            => 1,
			'loggedIn'      => true,
			'totp_required' => true,
		]);
		$this->assertTrue($this->library->isTotpRequired());
	}
}
