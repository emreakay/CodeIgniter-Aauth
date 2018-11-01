<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_login_attempts extends Migration
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
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 39,
				'default' => 0,
			),
			'count' => array(
				'type' => 'TINYINT',
				'constraint' => 2,
				'default' => 0,
			),
			'created_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable($config->dbTableLoginAttempts, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableLoginAttempts, true);
	}
}
