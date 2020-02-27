<?php namespace App\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;
use App\Models\Aauth\UserVariableModel;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class PermTest extends CIDatabaseTestCase
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

	public function testCreatePerm()
	{
		$this->library->createPerm('testPerm1', 'Test Perm 1');
		$this->seeInDatabase($this->config->dbTablePerms, [
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$this->assertFalse($this->library->createPerm('testPerm1'));
		$this->assertEquals(lang('Aauth.existsAlreadyPerm'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->createPerm(''));
		$this->assertEquals(lang('Aauth.requiredPermName'), $this->library->getErrorsArray()[0]);
	}

	public function testUpdatePerm()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->library = new Aauth(null, null);
		$this->library->updatePerm('testPerm1', 'testPerm1N', 'Test Perm 1 New');
		$this->seeInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1N',
			'definition' => 'Test Perm 1 New',
		]);

		$this->assertFalse($this->library->updatePerm('testPerm1N', 'testPerm2'));
		$this->assertEquals(lang('Aauth.existsAlreadyPerm'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->updatePerm('testPerm1'));
		$this->assertCount(0, $this->library->getErrorsArray());

		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->updatePerm(99, ''));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->updatePerm('testPerm99', ''));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
	}

	public function testDeletePerm()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->deletePerm('testPerm1'));
		$this->dontSeeInDatabase($this->config->dbTablePerms, [
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
			'deleted_at' => null,
		]);

		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->deletePerm(99));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->deletePerm('testPerm99'));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
	}

	public function testListPerms()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$perms = $this->library->listPerms();
		$this->assertCount(2, $perms);
		$this->assertEquals('testPerm1', $perms[0]['name']);
		$this->assertEquals('testPerm2', $perms[1]['name']);
	}

	public function testListPermsPaginated()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);

		$perms = $this->library->listPermsPaginated();
		$this->assertTrue(isset($perms['pager']));
		$this->assertCount(2, $perms['perms']);
		$this->assertEquals('testPerm1', $perms['perms'][0]['name']);
		$this->assertEquals('testPerm2', $perms['perms'][1]['name']);

		$permsOrderBy = $this->library->listPermsPaginated(10, 'id DESC');
		$this->assertEquals('testPerm2', $permsOrderBy['perms'][0]['name']);
		$this->assertEquals('testPerm1', $permsOrderBy['perms'][1]['name']);
	}

	public function testGetUserPerms()
	{
		$this->assertCount(0, $this->library->getUserPerms(1, 1));

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 1,
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 2,
			'user_id' => 1,
			'state'   => 0,
		]);

		$this->assertCount(1, $this->library->getUserPerms(1, 1));
		$this->assertCount(1, $this->library->getUserPerms(1, 0));
		$this->assertCount(2, $this->library->getUserPerms(1));
		$this->assertFalse($this->library->getUserPerms(99, 1));
	}

	public function testListUserPerms()
	{
		$perms = $this->library->listUserPerms(1);
		$this->assertCount(0, $perms);

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 1,
		]);

		$perms = $this->library->listUserPerms(1);
		$this->assertCount(1, $perms);
		$this->assertEquals('testPerm1', $perms[0]['name']);

		$this->assertFalse($this->library->listUserPerms(99));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);

		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);

		$perms = $this->library->listUserPerms();
		$this->assertCount(1, $perms);
	}

	public function testListUserPermsPaginated()
	{
		$perms = $this->library->listUserPermsPaginated(1);
		$this->assertCount(0, $perms['perms']);

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 1,
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 2,
			'user_id' => 1,
			'state'   => 1,
		]);

		$this->assertFalse($this->library->listUserPermsPaginated(99));

		$perms = $this->library->listUserPermsPaginated(1);
		$this->assertTrue(isset($perms['pager']));
		$this->assertCount(2, $perms['perms']);
		$this->assertEquals('testPerm1', $perms['perms'][0]['name']);
		$this->assertEquals('testPerm2', $perms['perms'][1]['name']);

		$permsOrderBy = $this->library->listUserPermsPaginated(1, 10, 'id DESC');
		$this->assertEquals('testPerm2', $permsOrderBy['perms'][0]['name']);
		$this->assertEquals('testPerm1', $permsOrderBy['perms'][1]['name']);

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$perms = $this->library->listUserPermsPaginated();
		$this->assertCount(2, $perms['perms']);
	}

	public function testGetPermId()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);

		$this->assertEquals(1, $this->library->getPermId('testPerm1'));
		$this->assertEquals(1, $this->library->getPermId(1));
		$this->assertFalse($this->library->getPermId('testPerm99'));
	}

	public function testGetPerm()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);

		$perm = $this->library->getPerm('testPerm1');
		$this->assertEquals(1, $perm['id']);
		$perm = $this->library->getPerm(1);
		$this->assertEquals('testPerm1', $perm['name']);
		$this->assertFalse($this->library->getPerm('testPerm99'));
		$this->assertFalse($this->library->getPerm(99));
	}

	public function testAllowUser()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->allowUser(1, 1));
		$this->seeInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 1,
		]);

		$this->assertTrue($this->library->allowUser(1, 1));
		$this->assertFalse($this->library->allowUser(99, 1));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->allowUser(1, 99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testDenyUser()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->denyUser(1, 1));
		$this->seeInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 0,
		]);

		$this->assertTrue($this->library->denyUser(1, 1));
		$this->assertFalse($this->library->denyUser(99, 1));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->denyUser(1, 99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testAllowGroup()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->allowGroup(1, 1));
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 1,
			'state'    => 1,
		]);

		$this->assertTrue($this->library->allowGroup(1, 1));
		$this->assertFalse($this->library->allowGroup(99, 1));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->allowGroup(1, 99));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);
	}

	public function testDenyGroup()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->denyGroup(1, 1));
		$this->seeInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 1,
			'state'    => 0,
		]);

		$this->assertTrue($this->library->denyGroup(1, 1));
		$this->assertFalse($this->library->denyGroup(99, 1));
		$this->assertEquals(lang('Aauth.notFoundPerm'), $this->library->getErrorsArray()[0]);
		$this->library = new Aauth(null, null);
		$this->assertFalse($this->library->denyGroup(1, 99));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);
	}

	public function testGetGroupPerms()
	{
		$this->assertCount(0, $this->library->getGroupPerms(1, 1));

		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 1,
			'state'    => 1,
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 2,
			'group_id' => 1,
			'state'    => 0,
		]);

		$this->assertCount(1, $this->library->getGroupPerms(1, 1));
		$this->assertCount(1, $this->library->getGroupPerms(1, 0));
		$this->assertCount(2, $this->library->getGroupPerms(1));
		$this->assertFalse($this->library->getGroupPerms(99, 1));
	}

	public function testListGroupPerms()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 0,
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 2,
			'group_id' => 2,
			'state'    => 1,
		]);

		$groupPerms = $this->library->listGroupPerms($this->config->groupDefault);

		$this->assertCount(2, $groupPerms);
		$this->assertEquals('testPerm1', $groupPerms[0]['name']);
		$this->assertEquals('0', $groupPerms[0]['state']);
		$this->assertEquals('testPerm2', $groupPerms[1]['name']);
		$this->assertEquals('1', $groupPerms[1]['state']);

		$this->assertFalse($this->library->listGroupPerms(99));
	}

	public function testListGroupPermsPaginated()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 2,
			'name'       => 'testPerm2',
			'definition' => 'Test Perm 2',
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 2,
			'state'    => 0,
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 2,
			'group_id' => 2,
			'state'    => 1,
		]);

		$groupPerms = $this->library->listGroupPermsPaginated(2);
		$this->assertTrue(isset($groupPerms['pager']));
		$this->assertCount(2, $groupPerms['perms']);
		$this->assertEquals('testPerm1', $groupPerms['perms'][0]['name']);
		$this->assertEquals('0', $groupPerms['perms'][0]['state']);
		$this->assertEquals('testPerm2', $groupPerms['perms'][1]['name']);
		$this->assertEquals('1', $groupPerms['perms'][1]['state']);

		$groupPermsOrderBy = $this->library->listGroupPermsPaginated(2, 10, 'id DESC');
		$this->assertEquals('testPerm2', $groupPermsOrderBy['perms'][0]['name']);
		$this->assertEquals('testPerm1', $groupPermsOrderBy['perms'][1]['name']);

		$this->assertFalse($this->library->listGroupPermsPaginated(99));
	}

	public function testRemoveUserPerm()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePermToUser, [
			'perm_id' => 1,
			'user_id' => 1,
			'state'   => 1,
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->removeUserPerm(1, 1));
		$this->assertFalse($this->library->removeUserPerm(99, 1));
		$this->assertFalse($this->library->removeUserPerm(1, 99));
	}

	public function testRemoveGroupPerm()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->hasInDatabase($this->config->dbTablePermToGroup, [
			'perm_id'  => 1,
			'group_id' => 1,
			'state'    => 1,
		]);
		$this->library = new Aauth(null, null);
		$this->assertTrue($this->library->removeGroupPerm(1, 1));
		$this->assertFalse($this->library->removeGroupPerm(99, 1));
		$this->assertFalse($this->library->removeGroupPerm(1, 99));
	}
}
