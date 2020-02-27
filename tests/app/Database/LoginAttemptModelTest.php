<?php namespace App\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use Config\Aauth;
use Config\App;
use App\Models\Aauth\LoginAttemptModel;

class LoginAttemptModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = APPPATH . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->response = new \CodeIgniter\HTTP\Response(new App());

		$this->model = new LoginAttemptModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testFind()
	{
		$loginAttempt = $this->model->find();
		$this->assertEquals(0, $loginAttempt);
	}

	public function testSave()
	{
		$this->assertTrue($this->model->save());
		$this->assertEquals(1, $this->model->find());

		$this->assertTrue($this->model->save());
		$this->assertEquals(2, $this->model->find());

		$this->model->save();
		$this->model->save();
		$this->model->save();
		$this->model->save();
		$this->model->save();
		$this->model->save();
		$this->model->save();
		$this->assertFalse($this->model->save());
	}

	public function testDelete()
	{
		$this->model->save();
		$this->assertEquals(1, $this->model->find());

		$this->model->delete();
		$this->assertEquals(0, $this->model->find());
	}

	public function testFindCookie()
	{
		$config                     = new \Config\Aauth();
		$config->loginAttemptCookie = true;
		$this->model                = new LoginAttemptModel($this->db, $config);
		$this->assertEquals(0, $this->model->find());

		$this->model->save();
		$this->assertEquals(1, $this->model->find());
	}

	public function testSaveCookie()
	{
		$config                     = new \Config\Aauth();
		$config->loginAttemptCookie = true;
		$this->model                = new LoginAttemptModel($this->db, $config, $this->response);

		$this->assertTrue($this->model->save());
		$this->assertEquals(1, $this->model->find());

		$this->assertTrue($this->model->save());

		$this->response = new \CodeIgniter\HTTP\Response(new App());
		$this->response->setCookie('logins', 10, 4000);
		$this->model = new LoginAttemptModel($this->db, $config, $this->response);
		$this->assertFalse($this->model->save());
	}

	public function testDeleteCookie()
	{
		$config                     = new Aauth();
		$config->loginAttemptCookie = true;
		$this->model                = new LoginAttemptModel($this->db, $config, $this->response);

		$this->model->save();
		$this->assertEquals(1, $this->model->find());

		$this->model->delete();
		$this->assertEquals(0, $this->model->find());
	}

	public function testConfigDBGroup()
	{
		$this->model = new LoginAttemptModel();
		$this->model->save();
		$this->assertEquals(1, $this->model->find());
	}
}
