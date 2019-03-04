<?php namespace Tests\Aauth\Libraries\Aauth;

use App\Libraries\Aauth;

class CallTest extends \CIUnitTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->library = new Aauth();
	}

	//--------------------------------------------------------------------

	public function testFailCall()
	{
		$this->expectException('ErrorException'); // Or whichever exception it is
		$this->library->getNotExistingFunc();
	}
}
