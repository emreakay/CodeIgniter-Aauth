<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_ci_sessions_table extends Migration
{

	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'       => 'VARCHAR',
				'constraint' => 128,
				'null'       => false
			],
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => false
			],
			'timestamp'  => [
				'type'       => 'INT',
				'constraint' => 10,
				'unsigned'   => true,
				'null'       => false,
				'default'    => 0
			],
			'data'       => [
				'type'       => 'TEXT',
				'null'       => false,
				'default'    => ''
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('timestamp');
		$this->forge->createTable('ci_sessions', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('ci_sessions', true);
	}
}
