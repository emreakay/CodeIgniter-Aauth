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
 * Create default admin
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_default_users extends Migration
{
	/**
	 * Create Table
	 *
	 * @return void
	 */
	public function up()
	{
		$config = new AauthConfig();
		$data   = [
			[
				'username' => 'admin',
				'email'    => 'admin@example.com',
				'password' => password_hash('password123456', $config->passwordHashAlgo, $config->passwordHashOptions),
			],
			[
				'username' => 'user',
				'email'    => 'user@example.com',
				'password' => password_hash('password123456', $config->passwordHashAlgo, $config->passwordHashOptions),
			],
		];

		$this->db->table($config->dbTableUsers)->insertBatch($data);

		$data = [
			[
				'group_id' => 1,
				'user_id'  => 1,
			],
			[
				'group_id' => 2,
				'user_id'  => 1,
			],
		];

		if ($config->groupDefault)
		{
			$data[] = [
				'group_id' => 2,
				'user_id'  => 2,
			];
		}

		$this->db->table($config->dbTableGroupToUser)->insertBatch($data);
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
		$this->db->simpleQuery('SET FOREIGN_KEY_CHECKS = 0;');
		$this->db->table($config->dbTableUsers)->truncate();
		$this->db->table($config->dbTableGroupToUser)->truncate();
		$this->db->simpleQuery('SET FOREIGN_KEY_CHECKS = 1;');
	}
}
