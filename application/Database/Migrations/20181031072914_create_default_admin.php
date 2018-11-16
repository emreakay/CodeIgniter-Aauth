<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like groupping,
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
 * Create default admin
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_default_admin extends Migration
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
			'username' => 'admin',
			'email'    => 'admin@example.com',
			'password' => password_hash('password123456', $config->passwordHashAlgo, $config->passwordHashOptions),
		];

		$this->db->table($config->dbTableUsers)->insert($data);

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
		$this->db->table($config->dbTableUsers)->truncate();
		$this->db->table($config->dbTableGroupToUser)->truncate();
	}
}
