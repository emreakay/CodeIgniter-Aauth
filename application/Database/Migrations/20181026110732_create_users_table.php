<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_users_table extends Migration
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
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 254,
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
			],
			'banned' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'null' => TRUE,
				'default' => 0,
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'last_activity' => [
				'type' => 'DATETIME',
				'default' => NULL,
			],
			'last_ip_address' => [
				'type' => 'VARCHAR',
				'constraint' => 39,
				'default' => '',
			],
			'last_login' => [
				'type' => 'DATETIME',
				'default' => NULL,
			],
			'deleted' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable($config->dbTableUsers, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableUsers, true);
	}
}
