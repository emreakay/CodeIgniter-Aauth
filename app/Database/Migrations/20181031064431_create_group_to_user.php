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
 * Create group to user table
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_group_to_user extends Migration
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
			'group_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
			'user_id'  => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			],
		]);
		$this->forge->addKey(['group_id', 'user_id'], true);
		$this->forge->createTable($config->dbTableGroupToUser, true);
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
		$this->forge->dropTable($config->dbTableGroupToUser, true);
	}
}
