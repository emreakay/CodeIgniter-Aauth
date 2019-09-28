<?php namespace Tests\Aauth\Libraries\Aauth;

use App\Libraries\Aauth;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class UtilityTest extends \CIUnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();

		$this->library = new Aauth(null, null);
	}

	//--------------------------------------------------------------------

	public function testFailModel()
	{
		$this->assertInstanceOf('\App\Models\Aauth\GroupToUserModel', $this->library->getModel('group to user'));
		$this->assertInstanceOf('\App\Models\Aauth\GroupToUserModel', $this->library->getModel('group_to_user'));
		$this->assertFalse($this->library->getModel('NotExisting'));
	}

	public function testFailCall()
	{
		$this->expectException('ErrorException');
		$this->library->getNotExistingFunc();
	}
}
