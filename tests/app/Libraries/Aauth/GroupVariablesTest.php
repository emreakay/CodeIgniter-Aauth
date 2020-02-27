<?php namespace App\Libraries\Aauth;

use Config\Aauth as AauthConfig;
use Config\Logger;
use Config\Services;
use Tests\Support\Log\TestLogger;
use Tests\Support\Session\MockSession;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Libraries\Aauth;
use App\Models\Aauth\GroupVariableModel;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class GroupVariablesTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->library = new Aauth(null, null);
		$this->config  = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testSetGroupVar()
	{
		$this->assertTrue($this->library->setGroupVar('test_var', 'test', 1));
		$this->seeInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$this->assertFalse($this->library->setGroupVar('test_var', 'test', 99));
	}

	public function testUnsetGroupVar()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$this->assertTrue($this->library->unsetGroupVar('test_var', 1));

		$this->assertFalse($this->library->unsetGroupVar('test_var', 99));
	}

	public function testGetGroupVar()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);

		$this->assertEquals('test', $this->library->getGroupVar('test_var', 1));

		$this->assertFalse($this->library->getGroupVar('test_var_99', 1));

		$this->assertFalse($this->library->getGroupVar('test_var', 99));
	}

	public function testGetGroupVars()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var2',
			'data_value' => 'test2',
		]);

		$this->assertCount(2, $this->library->listGroupVars(1));

		$this->assertFalse($this->library->listGroupVars(99));
	}

	public function testListGroupVarKeys()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var',
			'data_value' => 'test',
		]);
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test_var2',
			'data_value' => 'test2',
		]);

		$this->assertCount(2, $this->library->getGroupVarKeys(1));
		$this->assertEquals([['key' => 'test_var'], ['key' => 'test_var2']], $this->library->getGroupVarKeys(1));

		$this->assertFalse($this->library->getGroupVarKeys(99));
	}
}
