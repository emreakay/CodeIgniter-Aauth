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
 * @since     3.0.0
 * @author    Emre Akay
 * @author    Raphael "REJack" Jackstadt
 * @copyright 2014-2019 Emre Akay
 * @license   https://opensource.org/licenses/MIT   MIT License
 * @link      https://github.com/emreakay/CodeIgniter-Aauth
 */

namespace App\Models\Aauth;

use CodeIgniter\Model;
use Config\Aauth as AauthConfig;

/**
 * Group Model
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class GroupModel extends Model
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
	public function __construct($db = null, $validation = null, $config = null)
	{
		if (is_null($config))
		{
			$config = new AauthConfig();
		}

		$this->config  = $config;
		$this->DBGroup = $this->config->dbProfile;

		parent::__construct();

		$this->table              = $this->config->dbTableGroups;
		$this->tempUseSoftDeletes = $this->config->dbSoftDeleteGroups;
		$this->tempReturnType     = $this->config->dbReturnType;

		$this->validationRules['name'] = 'required|is_unique[' . $this->table . '.name,id,{id}]';

		$this->validationMessages = [
			'name' => [
				'required'  => lang('Aauth.requiredGroupName'),
				'is_unique' => lang('Aauth.existsAlreadyGroup'),
			],
		];
	}

	/**
	 * Checks if group exist by group id
	 *
	 * @param integer $groupId Group id
	 *
	 * @return boolean
	 */
	public function existsById(int $groupId)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where($this->primaryKey, $groupId);
		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Get group by group name
	 *
	 * @param string $groupName Group name
	 *
	 * @return boolean
	 */
	public function getByName(string $groupName)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where('name', $groupName);

		if (! $group = $builder->get()->getFirstRow($this->tempReturnType))
		{
			return false;
		}

		return $group;
	}

}
