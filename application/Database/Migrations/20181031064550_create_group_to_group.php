<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_group_to_group extends Migration
{
	public function up()
	{
		$config = new AauthConfig();
		$this->forge->addField([
			'group_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
			'subgroup_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			],
		]);
		$this->forge->addKey(['group_id','subgroup_id'], TRUE);
		$this->forge->createTable($config->dbTableGroupToGroup, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableGroupToGroup, true);
	}
}
