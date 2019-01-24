<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\LoginAttemptModel;

class LoginAttemptModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

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

	public function testConfigDBGroup()
	{
		$this->model = new LoginAttemptModel();
		$this->model->save();
		$this->assertEquals(1, $this->model->find());
	}
}
