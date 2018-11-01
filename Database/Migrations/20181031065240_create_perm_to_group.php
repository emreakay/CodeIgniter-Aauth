<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_perm_to_group extends Migration
{
	public function up()
	{
		$config = new AauthConfig();
		$this->forge->addField([
			'perm_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
		]);
		$this->forge->addKey(array('perm_id','user_id'), TRUE);
		$this->forge->createTable($config->dbTablePermToGroup, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTablePermToGroup, true);
	}
}
