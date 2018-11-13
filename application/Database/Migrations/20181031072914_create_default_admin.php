<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_default_admin extends Migration
{
	public function up()
	{
		$config = new AauthConfig();

		$data = [
			'username' => 'admin',
			'email'    => 'admin@example.com',
			'password' => password_hash('password123456', $config->passwordHashAlgo, $config->passwordHashOptions),
		];

		$this->db->table($config->dbTableUsers)->insert($data);

		$data = [
			[
				'group_id' => 1,
				'user_id'  => 1,
			],
			[
				'group_id' => 2,
				'user_id'  => 1,
			],
		];

		$this->db->table($config->dbTableGroupToUser)->insertBatch($data);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->db->table($config->dbTableUsers)->truncate();
		$this->db->table($config->dbTableGroupToUser)->truncate();
	}
}
