<?php namespace Magefly\Aauth\Database\Migrations;

use CodeIgniter\Database\Migration;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migration_create_default_groups extends Migration
{
	public function up()
	{
		$config = new AauthConfig();

		$data = [
			[
				'name'       => $config->adminGroup,
				'definition' => 'Administators',
			],
			[
				'name'       => $config->defaultGroup,
				'definition' => 'Users',
			],
			[
				'name'       => $config->publicGroup,
				'definition' => 'Guests',
			],
		];

		$this->db->table($config->dbTableGroups)->insertBatch($data);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->db->table($config->dbTableGroups)->truncate();
	}
}
