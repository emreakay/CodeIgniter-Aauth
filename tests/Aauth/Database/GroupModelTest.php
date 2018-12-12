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

	public function testDummy()
	{
		$groups = $this->model->findAll();
		$this->assertCount(3, $groups);
	}
}
