<?php namespace Tests\Aauth\Database;

use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\PermModel;

class PermModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = TESTPATH . '../application' . 'Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model = new PermModel($this->db);
	}

	//--------------------------------------------------------------------

	public function testDummy()
	{
		$perms = $this->model->findAll();
		$this->assertCount(0, $perms);
	}
}
