<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_users_table extends Migration
{

	public function up()
	{
		$config = new AauthConfig();

		$this->forge->addField([
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 254,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 60,
			),
			'banned' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'null' => TRUE,
				'default' => 0,
			),
			'created_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'last_activity' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'last_ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 39,
				'default' => '',
			),
			'last_login' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'deleted' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0,
			),
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
