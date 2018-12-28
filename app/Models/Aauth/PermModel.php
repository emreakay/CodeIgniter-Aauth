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
	 * If this model should use "softDeletes" and
	 * simply set a flag when rows are deleted, or
	 * do hard deletes.
	 *
	 * @var boolean
	 */
	protected $useSoftDeletes = true;

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

	/**
	 * Checks if perm exist by perm id
	 *
	 * @param integer $permId Perm id
	 *
	 * @return boolean
	 */
	public function existsById(int $permId)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where($this->primaryKey, $permId);
		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Get perm by perm name
	 *
	 * @param string $name Perm name
	 *
	 * @return boolean
	 */
	public function getByName(string $name)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where('name', $name);

		if (! $perm = $builder->get()->getFirstRow($this->tempReturnType))
		{
			return false;
		}

		return $perm;
	}
}
