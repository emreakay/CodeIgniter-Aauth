<?php namespace Tests\Aauth\Database;

use Config\Aauth as AauthConfig;
use CodeIgniter\Test\CIDatabaseTestCase;
use App\Models\Aauth\UserSessionModel;

class UserSessionModelTest extends CIDatabaseTestCase
{
	protected $refresh = true;

	protected $basePath = FCPATH . '../app/Database/Migrations';

	protected $namespace = 'App';

	public function setUp()
	{
		parent::setUp();

		$this->model  = new UserSessionModel($this->db);
		$this->config = new AauthConfig();
	}

	//--------------------------------------------------------------------

	public function testDelete()
	{
		$id = md5(time());
		$this->hasInDatabase($this->config->dbTableUserSessions, [
			'id'         => $id,
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => '',
		]);
		$this->seeNumRecords(1, $this->config->dbTableUserSessions, []);
		$this->model->delete($id);
		$this->seeNumRecords(0, $this->config->dbTableUserSessions, []);
	}

	public function testDBInsert()
	{
		$this->seeNumRecords(0, $this->config->dbTableUserSessions, []);
		$id = md5(time());
		$this->model->insert([
			'id'         => $id,
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => '',
		]);
		$this->seeNumRecords(1, $this->config->dbTableUserSessions, []);
		$this->assertEquals(1, $this->model->affectedRows());
		$this->assertEquals(1, $this->model->countAll());
	}

}
