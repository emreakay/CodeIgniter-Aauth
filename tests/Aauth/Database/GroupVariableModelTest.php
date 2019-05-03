<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupVariableModel;

class GroupVariableModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model  = new GroupVariableModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testFind()
	{
		$groupVariable = $this->model->find(1, 'test');
		$this->assertFalse($groupVariable);

		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$groupVariable = $this->model->find(1, 'test');
		$this->assertEquals('TRUE', $groupVariable);
	}

	public function testFindAll()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$groupVariables = $this->model->findAll(1);
		$this->assertCount(1, $groupVariables);
	}

	public function testSave()
	{
		$this->model->save(1, 'test', 'TRUE');
		$this->seeInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);

		$this->model->save(1, 'test', 'TRUE2');
		$this->seeInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE2',
		]);
	}

	public function testDelete()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$criteria = [
			'group_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupVariables, $criteria);
		$this->model->delete(1, 'test');
		$this->seeNumRecords(0, $this->config->dbTableGroupVariables, $criteria);
	}

	public function testDeleteAllByGroupId()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$criteria = [
			'group_id' => 1,
		];
		$this->seeNumRecords(1, $this->config->dbTableGroupVariables, $criteria);
		$this->model->deleteAllByGroupId(1);
		$this->seeNumRecords(0, $this->config->dbTableGroupVariables, $criteria);
	}

	public function testAsArrayFirst()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$groupVariable = $this->model->asArray()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('array', $groupVariable);
	}

	public function testAsObjectFirst()
	{
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$groupVariable = $this->model->asObject()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('object', $groupVariable);
	}

	public function testConfigDBGroup()
	{
		$this->model = new GroupVariableModel();
		$this->hasInDatabase($this->config->dbTableGroupVariables, [
			'group_id'   => 1,
			'data_key'   => 'test',
			'data_value' => 'TRUE',
		]);
		$groupVariable = $this->model->asObject()->where(['data_key' => 'test', 'data_value' => 'TRUE'])->first();
		$this->assertInternalType('object', $groupVariable);
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
