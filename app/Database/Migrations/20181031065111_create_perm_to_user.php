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
 * Create perm to user table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_perm_to_user extends Migration
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
			'perm_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'user_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'state'   => [
				'type'       => 'TINYINT',
				'constraint' => 1,
				'default'    => 1,
			],
		]);
		$this->forge->addKey(['perm_id', 'user_id'], true);
		$this->forge->addForeignKey('perm_id', $config->dbTablePerms, 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('user_id', $config->dbTableUsers, 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable($config->dbTablePermToUser, true);
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
		$this->forge->dropForeignKey($config->dbTablePermToUser, $config->dbTablePermToUser . '_perm_id_foreign');
		$this->forge->dropForeignKey($config->dbTablePermToUser, $config->dbTablePermToUser . '_user_id_foreign');
		$this->forge->dropTable($config->dbTablePermToUser, true);
	}
}
