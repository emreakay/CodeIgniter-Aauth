<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_perm_to_user extends Migration
{
	public function up()
	{
		$config = new AauthConfig();
		$this->forge->addField([
			'perm_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
			'user_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
		]);
		$this->forge->addKey(['perm_id','user_id'], TRUE);
		$this->forge->createTable($config->dbTablePermToUser, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTablePermToUser, true);
	}
}
