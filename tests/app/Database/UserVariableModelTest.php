<?php namespace App\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\UserVariableModel;

class UserVariableModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp(): void
	{
		parent::setUp();

		$this->model  = new UserVariableModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testFind()
	{
		$userVariable = $this->model->find(1, 'test');
		$this->assertFalse($userVariable);

		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$userVariable = $this->model->find(1, 'test');
		$this->assertEquals('TRUE', $userVariable);
	}

	public function testFindAll()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$userVariables = $this->model->findAll(1);
		$this->assertCount(1, $userVariables);
	}

	public function testSave()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);

		$this->model->save(1, 'test', 'TRUE2');
		$this->seeInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE2',
		]);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$criteria = [
			'user_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTableUserVariables, $criteria);
		$this->model->delete(1, 'test');
		$this->seeNumRecords(0, $this->config->dbTableUserVariables, $criteria);
	}

	public function testDeleteAllByUserId()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$criteria = [
			'user_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTableUserVariables, $criteria);
		$this->model->deleteAllByUserId(1);
		$this->seeNumRecords(0, $this->config->dbTableUserVariables, $criteria);
	}

	public function testAsArrayFirst()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$userVariable = $this->model->asArray()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('array', $userVariable);
	}

	public function testAsObjectFirst()
	{
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$userVariable = $this->model->asObject()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('object', $userVariable);
	}

	public function testConfigDBGroup()
	{
		$this->model = new UserVariableModel();
		$this->hasInDatabase($this->config->dbTableUserVariables, [
			'user_id'    => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$userVariable = $this->model->asObject()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('object', $userVariable);
	}

	public function testDBCall()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->assertEquals(1, $this->model->insertID());
	}

}
