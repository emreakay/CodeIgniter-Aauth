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
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'data_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'data_value' => array(
				'type' => 'TEXT',
			),
			'created_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_datetime' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'system' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0,
			),
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
