<?php namespace App\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;
use App\Models\Aauth\UserModel;
use App\Models\Aauth\UserVariableModel;
use OTPHP\TOTP;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class TOTPTest extends CIDatabaseTestCase
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

	public function testLogin()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$session             = $this->getInstance();
		$this->library       = new Aauth($config, $session);

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'totp_secret',
			'data_value' => 'JBSWY3DPEHPK3PXP',
			'system'     => true,
		]);

		$this->assertTrue($this->library->login('admin@example.com', 'password123456'));

		$config->totpLogin = true;
		$this->library     = new Aauth($config, $session);

		$this->assertFalse($this->library->login('admin@example.com', 'password123456', null, '000001'));
		$this->assertEquals(lang('Aauth.invalidTOTPCode'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth($config, $session);
		$this->assertFalse($this->library->login('admin@example.com', 'password123456', null));
		$this->assertEquals(lang('Aauth.requiredTOTPCode'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth($config, $session);

		$totp     = TOTP::create('JBSWY3DPEHPK3PXP');
		$totpCode = $totp->now();
		$this->assertTrue($this->library->login('admin@example.com', 'password123456', null, $totpCode));

		$userModel = new UserModel();
		$userModel->protect(false)->update(1, ['last_ip_address' => '99.99.99.99']);

		$config->totpOnIpChange = true;

		$this->assertFalse($this->library->login('admin@example.com', 'password123456', null, '000001'));
		$this->assertEquals(lang('Aauth.invalidTOTPCode'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth($config, $session);
		$this->assertFalse($this->library->login('admin@example.com', 'password123456', null));
		$this->assertEquals(lang('Aauth.requiredTOTPCode'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth($config, $session);

		$this->library = new Aauth($config, $session);
		$totp          = TOTP::create('JBSWY3DPEHPK3PXP');
		$totpCode      = $totp->now();
		$this->assertTrue($this->library->login('admin@example.com', 'password123456', null, $totpCode));

		$userModel->protect(false)->update(1, ['last_ip_address' => '99.99.99.99']);
		$config->totpOnIpChange = true;
		$config->totpLogin      = false;
		$this->library          = new Aauth($config, $session);

		$this->assertTrue($this->library->login('admin@example.com', 'password123456'));
	}

	public function testUpdateUserTotpSecret()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, null);

		$this->assertTrue($this->library->updateUserTotpSecret(2, 'TESTSECRET99'));
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 2,
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
		$this->library       = new Aauth($config, null);

		$this->assertInternalType('string', $this->library->generateUniqueTotpSecret());
	}

	public function testGenerateTotpQrCode()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, null);

		$this->assertInternalType('string', $this->library->generateTotpQrCode('testsecret'));
	}

	public function testVerifyUserTotpCode()
	{
		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->totpEnabled = true;
		$this->library       = new Aauth($config, $session);

		$session       = $this->getInstance();
		$this->library = new Aauth($config, $session);
		$session->set('user', [
			'id'            => 1,
			'loggedIn'      => true,
			'totp_required' => true,
		]);

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'totp_secret',
			'data_value' => 'JBSWY3DPEHPK3PXP',
			'system'     => true,
		]);
		$this->assertFalse($this->library->verifyUserTotpCode('999000', 1));

		$totp     = TOTP::create('JBSWY3DPEHPK3PXP');
		$totpCode = $totp->now();

		$this->assertTrue($this->library->verifyUserTotpCode($totpCode));
		$this->assertTrue($this->library->verifyUserTotpCode($totpCode, 1));
	}

	public function testIsTotpRequired()
	{
		$config              = new AauthConfig();
		$config->totpEnabled = true;
		$this->library       = new Aauth($config, null);

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
