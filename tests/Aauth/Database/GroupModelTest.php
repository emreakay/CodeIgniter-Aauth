<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\GroupModel;

class GroupModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model = new GroupModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testExistsById()
	{
		$this->assertTrue($this->model->existsById(1));
		$this->assertFalse($this->model->existsById(99));
	}

	public function testGetByName()
	{
		$this->assertEquals(1, $this->model->getByName('admin')['id']);
		$this->assertFalse($this->model->getByName('test_group'));
	}
}
