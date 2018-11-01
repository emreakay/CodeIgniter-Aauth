<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_perms extends Migration
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
		$this->forge->createTable($config->dbTablePerms, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTablePerms, true);
	}
}
