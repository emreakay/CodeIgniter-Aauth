<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\LoginAttemptModel;

class LoginAttemptModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

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
		$loginAttempt = $this->model->find();
		$this->assertEquals(1, $loginAttempt);

		$this->assertTrue($this->model->save());
		$loginAttempt = $this->model->find();
		$this->assertEquals(2, $loginAttempt);

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
		$loginAttempt = $this->model->find();
		$this->assertEquals(1, $loginAttempt);
		$this->model->delete();
		$loginAttempt = $this->model->find();
		$this->assertEquals(0, $loginAttempt);
	}

	public function testConfigDBGroup()
	{
		$this->model = new LoginAttemptModel();
		$this->model->save();
		$groupsToGroup = $this->model->find();
		$this->assertEquals(1, $groupsToGroup);
	}
}
