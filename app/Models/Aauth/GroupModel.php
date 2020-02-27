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
 * @since     3.0.0
 */

namespace App\Models\Aauth;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
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
	 *
	 * @param ConnectionInterface $db         Connection Interface
	 * @param ValidationInterface $validation Validation Interface
	 * @param \Config\Aauth       $config     Config Object
	 */
	public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null, \Config\Aauth $config = null)
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
			$builder->where($this->deletedField, null);
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
			$builder->where($this->deletedField, null);
		}

		$builder->where('name', $groupName);

		if (! $group = $builder->get()->getFirstRow($this->tempReturnType))
		{
			return false;
		}

		return $group;
	}

}
