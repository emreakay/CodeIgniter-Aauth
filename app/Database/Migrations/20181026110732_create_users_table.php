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
 * Create users table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_users_table extends Migration
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
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => 254,
			],
			'username' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true,
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => 60,
			],
			'banned' => [
				'type'       => 'TINYINT',
				'constraint' => 1,
				'null'       => true,
				'default'    => 0,
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'last_activity' => [
				'type'    => 'DATETIME',
				'default' => null,
			],
			'last_ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 39,
				'default'    => '',
			],
			'last_login' => [
				'type'    => 'DATETIME',
				'default' => null,
			],
			'deleted' => [
				'type'       => 'TINYINT',
				'constraint' => 1,
				'default'    => 0,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable($config->dbTableUsers, true);
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
		$this->forge->dropTable($config->dbTableUsers, true);
	}
}
