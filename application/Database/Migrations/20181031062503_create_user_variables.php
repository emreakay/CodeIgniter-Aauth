<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_user_variables extends Migration
{
	public function up()
	{
		$config = new AauthConfig();
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'user_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
			'data_key' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'data_value' => [
				'type' => 'TEXT',
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at' => [
				'type' => 'DATETIME',
				'default' => NULL,
			],
			'system' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable($config->dbTableUserVariables, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableUserVariables, true);
	}
}
