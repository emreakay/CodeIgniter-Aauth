<?php namespace Tests\Aauth\Database;

use Config\Services;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Database;
use \App\Models\Aauth\UserModel as UserModel;

class UserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = APPPATH . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new UserModel();
	}

	//--------------------------------------------------------------------

	public function testFindReturnsRow()
	{
		$user = $this->model->find(1);
		$this->assertEquals('admin', $user['username']);
	}

}
