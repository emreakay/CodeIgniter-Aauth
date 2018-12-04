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

use Config\Aauth as AauthConfig;
use Config\Database;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

/**
 * Perm To User Model
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class PermToUserModel
{

	/**
	 * Database Connection
	 *
	 * @var ConnectionInterface
	 */
	protected $db;

	/**
	 * Query Builder object
	 *
	 * @var BaseBuilder
	 */
	protected $builder;

	/**
	 * Name of database table
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * The Database connection group that
	 * should be instantiated.
	 *
	 * @var string
	 */
	protected $DBGroup;

	/**
	 * Aauth Config object
	 *
	 * @var BaseConfig
	 */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param ConnectionInterface $db Database object
	 */
	public function __construct(ConnectionInterface &$db = null)
	{
		$this->config  = new AauthConfig();
		$this->DBGroup = $this->config->dbProfile;
		$this->table   = $this->config->dbTablePermToUser;

		if ($db instanceof ConnectionInterface)
		{
			$this->db = & $db;
		}
		else
		{
			$this->db = Database::connect($this->DBGroup);
		}
	}

	/**
	 * Get all Perm Ids by User Id
	 *
	 * @param integer $userId User Id
	 *
	 * @return array|null
	 */
	public function findAllByUserId(int $userId)
	{
		$builder = $this->builder();
		$builder->select('perm_id');
		$builder->where('user_id', $userId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Get all User Ids by Perm Id
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return array|null
	 */
	public function findAllByPermId(int $permId)
	{
		$builder = $this->builder();
		$builder->select('user_id');
		$builder->where('perm_id', $permId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Check if exists by Perm Id and User Id
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 *
	 * @return boolean
	 */
	public function exists(int $permId, int $userId)
	{
		$builder = $this->builder();

		$builder->where('perm_id', $permId);
		$builder->where('user_id', $userId);
		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Insert
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 *
	 * @return BaseBuilder
	 */
	public function insert(int $permId, int $userId)
	{
		$builder = $this->builder();

		$data['perm_id'] = $permId;
		$data['user_id'] = $userId;

		return $builder->insert($data);
	}

	/**
	 * Delete by Perm Id and User Id
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 *
	 * @return BaseBuilder
	 */
	public function delete(int $permId, int $userId)
	{
		$builder = $this->builder();
		$builder->where('perm_id', $permId);
		$builder->where('user_id', $userId);

		return $builder->delete();
	}

	/**
	 * Deletes all by Perm Id
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return BaseBuilder
	 */
	public function deleteAllByPermId(int $permId)
	{
		$builder = $this->builder();
		$builder->where('perm_id', $permId);

		return $builder->delete();
	}

	/**
	 * Deletes all by User Id
	 *
	 * @param integer $userId User Id
	 *
	 * @return BaseBuilder
	 */
	public function deleteAllByUserId(int $userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);

		return $builder->delete();
	}

	/**
	 * Provides a shared instance of the Query Builder.
	 *
	 * @param string $table Table Name
	 *
	 * @return BaseBuilder
	 */
	protected function builder(string $table = null)
	{
		if ($this->builder instanceof BaseBuilder)
		{
			return $this->builder;
		}

		$table = empty($table) ? $this->table : $table;

		$this->builder = $this->db->table($table);

		return $this->builder;
	}

}
