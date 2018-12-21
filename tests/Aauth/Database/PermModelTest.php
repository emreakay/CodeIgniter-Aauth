<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
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

		$this->model  = new PermModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testExistsById()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);
		$this->assertTrue($this->model->existsById(1));
		$this->assertFalse($this->model->existsById(99));
	}

	public function testGetByName()
	{
		$this->hasInDatabase($this->config->dbTablePerms, [
			'id'         => 1,
			'name'       => 'testPerm1',
			'definition' => 'Test Perm 1',
		]);

		$this->assertEquals(1, $this->model->getByName('testPerm1')['id']);
		$this->assertFalse($this->model->getByName('testPerm99'));
	}
}
