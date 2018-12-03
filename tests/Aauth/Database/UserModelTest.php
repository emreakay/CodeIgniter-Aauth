<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use \App\Models\Aauth\UserModel as UserModel;

class UserModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new UserModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testFindReturnsRow()
	{
		$user = $this->model->find(1);
		$this->assertEquals('admin', $user['username']);
	}

}
