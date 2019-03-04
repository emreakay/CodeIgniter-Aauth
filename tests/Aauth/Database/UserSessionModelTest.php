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

	public function testAsArrayFirst()
	{
		$this->hasInDatabase($this->config->dbTableUserSessions, [
			'id'         => md5(time()),
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => 'user|',
		]);
		$userSession = $this->model->asArray()->findAll();
		$this->assertInternalType('array', $userSession[0]);
	}

	public function testAsObjectFirst()
	{
		$this->hasInDatabase($this->config->dbTableUserSessions, [
			'id'         => md5(time()),
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => 'user|',
		]);
		$userSession = $this->model->asObject()->findAll();
		$this->assertInternalType('object', $userSession[0]);
	}

	public function testConfigDBGroup()
	{
		$this->model = new UserSessionModel();
		$this->hasInDatabase($this->config->dbTableUserSessions, [
			'id'         => md5(time()),
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => 'user|',
		]);
		$userSession = $this->model->asObject()->where(['ip_address' => '127.0.0.1'])->first();
		$this->assertInternalType('object', $userSession);
	}

	public function testDBCall()
	{
		$this->assertEquals(0, $this->model->insertID());
		$this->seeNumRecords(0, $this->config->dbTableUserSessions, []);
		$this->model->insert([
			'id'         => md5(time()),
			'ip_address' => '127.0.0.1',
			'timestamp'  => time(),
			'data'       => 'user|',
		]);
		$this->assertCount(1, $this->model->asObject()->findAll());
	}
}
