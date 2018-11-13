<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_groups extends Migration
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
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'definition' => array(
				'type' => 'TEXT',
			),
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable($config->dbTableGroups, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableGroups, true);
	}
}
