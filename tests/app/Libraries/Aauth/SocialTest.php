<?php namespace App\Libraries;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use CodeIgniter\Test\TestLogger;
use CodeIgniter\Test\Mock\MockSession;
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
class SocialTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = APPPATH . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->config = new AauthConfig();

		$this->config->socialEnabled = true;

		$this->library = new Aauth($this->config, null);
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

	public function testUnlinkSocial()
	{
		$testArray = ['facebook.expires_at' => strtotime('+1 hour')];
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_storage',
			'data_value' => json_encode($testArray),
			'system'     => true,
		]);
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_facebook',
			'data_value' => 'testing00testing00testing',
			'system'     => true,
		]);

		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->socialEnabled   = true;
		$config->socialProviders = [
			'Facebook' => [
				'enabled' => true,
				'keys'    => [
					'id'     => 'testing',
					'secret' => 'testing00testing00testing',
				],
			],
		];

		$this->library = new Aauth($config, $session);
		$this->library->unlinkSocial(1, 'Facebook');

		$this->dontSeeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_storage',
			'data_value' => json_encode($testArray),
			'system'     => true,
		]);
		$this->dontSeeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_facebook',
			'data_value' => 'testing00testing00testing',
			'system'     => true,
		]);

		$this->assertFalse(isset($_SESSION['HYBRIDAUTH::STORAGE']));
	}

	public function testGetSocialUserId()
	{
		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->socialEnabled = true;
		$this->library         = new Aauth($config, $session);

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_testing',
			'data_value' => 'testingidentifier',
			'system'     => true,
		]);
		$this->assertEquals(1, $this->library->getSocialUserId('testing', 'testingidentifier'));
		$this->assertFalse($this->library->getSocialUserId('testing', 'none'));
	}

	public function testGetSocialIdentifier()
	{
		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->socialEnabled = true;
		$this->library         = new Aauth($config, $session);

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_testing',
			'data_value' => 'testingidentifier',
			'system'     => true,
		]);
		$this->assertEquals('testingidentifier', $this->library->getSocialIdentifier('testing', 1));
		$this->assertFalse($this->library->getSocialIdentifier('testing99', 1));
	}

	public function testGetProviders()
	{
		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->socialProviders = [
			'Facebook' => [
				'enabled' => true,
				'keys'    => [
					'id'     => 'testing',
					'secret' => 'testing00testing00testing',
				],
			],
		];

		$config->socialEnabled = true;
		$this->library         = new Aauth($config, $session);

		$this->assertEquals(['Facebook'], $this->library->getProviders());
	}

	public function testRebuildSocialStorage()
	{
		$testArray = ['facebook.expires_at' => strtotime('+1 hour')];
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'social_storage',
			'data_value' => json_encode($testArray),
			'system'     => true,
		]);

		$config  = new AauthConfig();
		$session = $this->getInstance();

		$config->socialEnabled   = true;
		$config->socialProviders = [
			'Facebook' => [
				'enabled' => true,
				'keys'    => [
					'id'     => 'testing',
					'secret' => 'testing00testing00testing',
				],
			],
		];

		$this->library = new Aauth($config, $session);
		$this->library->rebuildSocialStorage(1);

		$this->assertTrue(isset($_SESSION['HYBRIDAUTH::STORAGE']));
		$this->assertEquals($testArray, $_SESSION['HYBRIDAUTH::STORAGE']);
	}
}
