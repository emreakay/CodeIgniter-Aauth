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
 * Create default groups
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
class Migration_create_default_groups extends Migration
{
	/**
	 * Create Table
	 *
	 * @return void
	 */
	public function up()
	{
		$config = new AauthConfig();

		$adminGroup   = [
			'name'       => $config->groupAdmin,
			'definition' => 'Administators',
		];
		$defaultGroup = [
			'name'       => $config->groupDefault,
			'definition' => 'Users',
		];
		$publicGroup  = [
			'name'       => $config->groupPublic,
			'definition' => 'Guests',
		];

		if ($config->groupDefault)
		{
			$data = [
				$adminGroup,
				$defaultGroup,
				$publicGroup,
			];
		}
		else
		{
			$data = [
				$adminGroup,
				$publicGroup,
			];
		}

		$this->db->table($config->dbTableGroups)->insertBatch($data);
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
		$this->db->table($config->dbTableGroups)->truncate();
		$this->db->simpleQuery('SET FOREIGN_KEY_CHECKS = 1;');
	}
}
