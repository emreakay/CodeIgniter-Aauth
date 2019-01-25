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

class GroupTest extends CIDatabaseTestCase
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

		$this->config  = new AauthConfig();
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

	public function testCreateGroup()
	{
		$this->library->createGroup('testGroup1', 'Test Group 1');
		$this->seeInDatabase($this->config->dbTableGroups, [
			'name'       => 'testGroup1',
			'definition' => 'Test Group 1',
		]);

		$this->assertFalse($this->library->createGroup('admin'));
		$this->assertEquals(lang('Aauth.existsAlreadyGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->createGroup(''));
		$this->assertEquals(lang('Aauth.requiredGroupName'), $this->library->getErrorsArray()[0]);
	}

	public function testUpdateGroup()
	{
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1',
			'definition' => 'Test Group 1',
		]);
		$this->library->updateGroup('testGroup1', 'testGroup1N', 'Test Group 1 New');
		$this->seeInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1N',
			'definition' => 'Test Group 1 New',
		]);

		$this->assertFalse($this->library->updateGroup($this->config->groupAdmin, $this->config->groupDefault));
		$this->assertEquals(lang('Aauth.existsAlreadyGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->updateGroup($this->config->groupAdmin));
		$this->assertCount(0, $this->library->getErrorsArray());

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->updateGroup(99, ''));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->updateGroup('testGroup99	', ''));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);
	}

	public function testDeleteGroup()
	{
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1',
			'definition' => 'Test Group 1',
		]);
		$this->assertTrue($this->library->deleteGroup('testGroup1'));
		$this->dontSeeInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1N',
			'definition' => 'Test Group 1 New',
		]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->deleteGroup(99, ''));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->deleteGroup('testGroup99	', ''));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);
	}

	public function testAddMember()
	{
		$this->assertTrue($this->library->addMember(1, 2));
		$this->seeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 2,
		]);

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->addMember(2, 2));
		$this->assertEquals(lang('Aauth.alreadyMemberGroup'), $this->library->getInfosArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->addMember(99, 2));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->addMember(2, 99));
		$this->assertEquals(lang('Aauth.notFoundUser'), $this->library->getErrorsArray()[0]);
	}

	public function testRemoveMember()
	{
		$this->assertTrue($this->library->removeMember(1, 1));
		$this->dontSeeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 1,
		]);
	}

	public function testAddSubgroup()
	{
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1',
			'definition' => 'Test Group 1',
		]);
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 5,
			'name'       => 'testGroup2',
			'definition' => 'Test Group 2',
		]);
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 6,
			'name'       => 'testGroup3',
			'definition' => 'Test Group 3',
		]);

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->addSubgroup('testGroup1', 'testGroup2'));
		$this->assertTrue($this->library->addSubgroup('testGroup1', 'testGroup3'));
		$this->assertFalse($this->library->addSubgroup('testGroup2', 'testGroup1'));

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->addSubgroup(4, 5));
		$this->assertEquals(lang('Aauth.alreadyMemberSubgroup'), $this->library->getInfosArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->addSubgroup(99, 1));
		$this->assertEquals(lang('Aauth.notFoundGroup'), $this->library->getErrorsArray()[0]);

		$this->library = new Aauth(null, true);
		$this->assertFalse($this->library->addSubgroup(1, 99));
		$this->assertEquals(lang('Aauth.notFoundSubgroup'), $this->library->getErrorsArray()[0]);
	}

	public function testRemoveSubgroup()
	{
		$this->hasInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
		$this->assertTrue($this->library->removeSubgroup(1, 2));
		$this->dontSeeInDatabase($this->config->dbTableGroupToGroup, [
			'group_id'    => 1,
			'subgroup_id' => 2,
		]);
	}

	public function testRemoveMemberFromAll()
	{
		$this->assertTrue($this->library->removeMemberFromAll(1));
		$this->dontSeeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 1,
			'user_id'  => 1,
		]);
		$this->dontSeeInDatabase($this->config->dbTableGroupToUser, [
			'group_id' => 2,
			'user_id'  => 1,
		]);
	}

	public function testListGroups()
	{
		$groups = $this->library->listGroups();
		$this->assertCount(3, $groups);
		$this->assertEquals($this->config->groupAdmin, $groups[0]['name']);
		$this->assertEquals($this->config->groupDefault, $groups[1]['name']);
	}

	public function testListGroupsPaginated()
	{
		$groups = $this->library->listGroupsPaginated();
		$this->assertTrue(isset($groups['pager']));
		$this->assertCount(3, $groups['groups']);
		$this->assertEquals($this->config->groupAdmin, $groups['groups'][0]['name']);
		$this->assertEquals($this->config->groupDefault, $groups['groups'][1]['name']);

		$groupsOrderBy = $this->library->listGroupsPaginated(10, 'id DESC');
		$this->assertEquals($this->config->groupPublic, $groupsOrderBy['groups'][0]['name']);
		$this->assertEquals($this->config->groupDefault, $groupsOrderBy['groups'][1]['name']);
	}

	public function testListUserGroups()
	{
		$groups = $this->library->listUserGroups(1);
		$this->assertCount(2, $groups);
		$this->assertEquals($this->config->groupAdmin, $groups[0]['name']);
		$this->assertEquals($this->config->groupDefault, $groups[1]['name']);

		$this->assertFalse($this->library->listUserGroups(99));
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testListUserGroupsPaginated()
	{
		$groups = $this->library->listUserGroupsPaginated(1);
		$this->assertTrue(isset($groups['pager']));
		$this->assertCount(2, $groups['groups']);
		$this->assertEquals($this->config->groupAdmin, $groups['groups'][0]['name']);
		$this->assertEquals($this->config->groupDefault, $groups['groups'][1]['name']);

		$groupsOrderBy = $this->library->listUserGroupsPaginated(1, 10, 'id DESC');
		$this->assertEquals($this->config->groupDefault, $groupsOrderBy['groups'][0]['name']);
		$this->assertEquals($this->config->groupAdmin, $groupsOrderBy['groups'][1]['name']);

		$this->assertFalse($this->library->listUserGroupsPaginated(99));

		$session       = $this->getInstance();
		$this->library = new Aauth(null, $session);
		$session->set('user', [
			'id'       => 1,
			'loggedIn' => true,
		]);
		$groups = $this->library->listUserGroupsPaginated();
		$this->assertCount(2, $groups['groups']);
	}

	public function testGetGroupName()
	{
		$this->assertEquals($this->config->groupAdmin, $this->library->getGroupName(1));
		$this->assertFalse($this->library->getGroupName(99));
	}

	public function testGetGroupId()
	{
		$this->assertEquals(1, $this->library->getGroupId($this->config->groupAdmin));
		$this->assertEquals(1, $this->library->getGroupId(1));
		$this->assertFalse($this->library->getGroupId('testGroup99'));
	}

	public function testGetGroup()
	{
		$group = $this->library->getGroup($this->config->groupAdmin);
		$this->assertEquals(1, $group['id']);
		$group = $this->library->getGroup(1);
		$this->assertEquals($this->config->groupAdmin, $group['name']);
		$this->assertFalse($this->library->getGroup('testGroup99'));
		$this->assertFalse($this->library->getGroup(99));
	}

	public function testGetSubgroups()
	{
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 4,
			'name'       => 'testGroup1',
			'definition' => 'Test Group 1',
		]);
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 5,
			'name'       => 'testGroup2',
			'definition' => 'Test Group 2',
		]);
		$this->hasInDatabase($this->config->dbTableGroups, [
			'id'         => 6,
			'name'       => 'testGroup3',
			'definition' => 'Test Group 3',
		]);

		$this->library = new Aauth(null, true);
		$this->assertTrue($this->library->addSubgroup('testGroup1', 'testGroup2'));
		$this->assertTrue($this->library->addSubgroup('testGroup1', 'testGroup3'));

		$subgroups = $this->library->getSubgroups(4);

		$this->assertCount(2, $subgroups);
		$this->assertEquals([['subgroup_id' => '5'], ['subgroup_id' => '6']], $subgroups);
		$this->assertFalse($this->library->getSubgroups('testGroup99'));
		$this->assertFalse($this->library->getSubgroups(99));
	}
}
