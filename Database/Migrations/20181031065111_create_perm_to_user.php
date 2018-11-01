<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_perm_to_user extends Migration
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
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
		]);
		$this->forge->addKey(array('perm_id','user_id'), TRUE);
		$this->forge->createTable($config->dbTablePermToUser, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTablePermToUser, true);
	}
}
