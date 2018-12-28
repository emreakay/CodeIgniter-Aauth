<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like grouping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Emre Akay
 * @author    Raphael "REJack" Jackstadt
 * @copyright 2014-2019 Emre Akay
 * @license   https://opensource.org/licenses/MIT   MIT License
 * @link      https://github.com/emreakay/CodeIgniter-Aauth
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

/**
 * Create login tokens table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_login_tokens extends Migration
{
	/**
	 * Create Table
	 *
	 * @return void
	 */
	public function up()
	{
		$config = new AauthConfig();
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'user_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'default'    => 0,
			],
			'random_hash' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],
			'selector_hash' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'expires_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable($config->dbTableLoginTokens, true);
	}

	//--------------------------------------------------------------------

	/**
	 * Drops Table
	 *
	 * @return void
	 */
	public function down()
	{
		$config = new AauthConfig();
		$this->forge->dropTable($config->dbTableLoginTokens, true);
	}
}
