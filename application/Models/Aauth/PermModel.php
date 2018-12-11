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

namespace App\Models\Aauth;

use CodeIgniter\Model;
use Config\Aauth as AauthConfig;

/**
 * Perm Model
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class PermModel extends Model
{
	/**
	 * If true, will set created_at, and updated_at
	 * values during insert and update routines.
	 *
	 * @var boolean
	 */
	protected $useTimestamps = true;

	/**
	 * An array of field names that are allowed
	 * to be set by the user in inserts/updates.
	 *
	 * @var array
	 */
	protected $allowedFields = [
		'name',
		'definition',
	];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->config  = new AauthConfig();
		$this->table   = $this->config->dbTablePerms;
		$this->DBGroup = $this->config->dbProfile;

		$this->validationRules['name'] = 'required|is_unique[' . $this->table . '.name,id,{id}]';

		$this->validationMessages = [
			'name' => [
				'required'  => lang('Aauth.requiredPermName'),
				'is_unique' => lang('Aauth.existsAlreadyPerm'),
			],
		];
	}

}
