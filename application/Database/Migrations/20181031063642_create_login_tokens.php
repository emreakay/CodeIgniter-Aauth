<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

class Migration_create_login_tokens extends Migration
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
			'user_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'default' => 0,
			],
			'random_hash' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'selector_hash' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'expires_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable($config->dbTableLoginTokens, TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableLoginTokens, true);
	}
}
