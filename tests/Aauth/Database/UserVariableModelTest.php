<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\UserVariableModel;

class UserVariableModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
	    parent::setUp();

		$this->model = new UserVariableModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testFindFalse()
	{
		$userVariable = $this->model->find(1, 'test');
		$this->assertFalse($userVariable);
	}

	public function testFindReturn()
	{
		$this->model->save(1, 'test', 'TRUE');
		$userVariable = $this->model->find(1, 'test');
		$this->assertEquals('TRUE', $userVariable);
	}

	public function testFindAll()
	{
		$this->model->save(1, 'test', 'TRUE');
		$userVariables = $this->model->findAll(1);
		$this->assertCount(1, $userVariables);
	}

	public function testSaveUpdate()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->model->save(1, 'test', 'TRUE2');
		$userVariable = $this->model->find(1, 'test');
		$this->assertEquals('TRUE2', $userVariable);
	}

	public function testDelete()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->model->delete(1, 'test');
		$userVariables = $this->model->findAll(1);
		$this->assertCount(0, $userVariables);
	}

	public function testAsArrayFirst()
	{
		$this->model->save(1, 'test', 'TRUE');
		$userVariable = $this->model->asArray()->where(['data_key'=>'test', 'data_value'=>'TRUE'])->first();
		$this->assertInternalType('array', $userVariable);
	}

	public function testAsObjectFirst()
	{
		$this->model->save(1, 'test', 'TRUE');
		$userVariable = $this->model->asObject()->where(['data_key'=>'test', 'data_value'=>'TRUE'])->first();
		$this->assertInternalType('object', $userVariable);
	}

	public function testConfigDBGroup()
	{
		$this->model = new UserVariableModel();
		$this->model->save(1, 'test', 'TRUE');
		$userVariable = $this->model->asObject()->where(['data_key'=>'test', 'data_value'=>'TRUE'])->first();
		$this->assertInternalType('object', $userVariable);
	}

	public function testDBCallEmpty()
	{
		$this->assertEquals(0, $this->model->insertID());
	}

	public function testDBCall()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->assertEquals(1, $this->model->insertID());
	}

}
