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
 * @author    Magefly Team
 * @copyright 2014-2017 Emre Akay
 * @copyright 2018 Magefly
 * @license   https://opensource.org/licenses/MIT	MIT License
 * @link      https://github.com/magefly/CodeIgniter-Aauth
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Aauth as AauthConfig;

/**
 * Create login attempts table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_login_attempts extends Migration
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
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 39,
				'default'    => 0,
			],
			'count' => [
				'type'       => 'TINYINT',
				'constraint' => 2,
				'default'    => 0,
			],
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable($config->dbTableLoginAttempts, true);
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
		$this->forge->dropTable($config->dbTableLoginAttempts, true);
	}
}
