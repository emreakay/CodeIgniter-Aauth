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
 * Create perm to group table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_perm_to_group extends Migration
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
			'perm_id'  => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'group_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'state'    => [
				'type'       => 'TINYINT',
				'constraint' => 1,
				'default'    => 1,
			],
		]);
		$this->forge->addKey(['perm_id', 'group_id'], true);
		$this->forge->createTable($config->dbTablePermToGroup, true);
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
		$this->forge->dropTable($config->dbTablePermToGroup, true);
	}
}
