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
		$builder->select('perm_id, state');
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
		$builder->select('user_id, state');
		$builder->where('perm_id', $permId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Check if Perm Id is allowed by User Id
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 *
	 * @return boolean
	 */
	public function allowed(int $permId, int $userId)
	{
		$builder = $this->builder();

		$builder->where('perm_id', $permId);
		$builder->where('user_id', $userId);
		$builder->where('state', 1);
		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Check if Perm Id is allowed by User Id
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 *
	 * @return boolean
	 */
	public function denied(int $permId, int $userId)
	{
		$builder = $this->builder();

		$builder->where('perm_id', $permId);
		$builder->where('user_id', $userId);
		$builder->where('state', 0);
		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Save
	 *
	 * Inserts or Updates Perm to User
	 *
	 * @param integer $permId Perm Id
	 * @param integer $userId User Id
	 * @param integer $state  State Int (0 deny, 1 allow)
	 *
	 * @return boolean
	 */
	public function save(int $permId, int $userId, int $state = 1)
	{
		$builder = $this->builder();
		$builder->where('perm_id', $permId);
		$builder->where('user_id', $userId);

		if (! $row = $builder->get()->getFirstRow())
		{
			$data['perm_id'] = $permId;
			$data['user_id'] = $userId;
			$data['state']   = $state;

			$builder->insert($data);
		}
		else
		{
			$data['state'] = $state;

			$builder->update($data, ['perm_id' => $permId, 'user_id' => $userId]);
		}

		return true;
	}

	/**
	 * Deletes all by Perm Id
	 *
	 * @param integer $permId Perm Id
	 *
	 * @return boolean
	 */
	public function deleteAllByPermId(int $permId)
	{
		$builder = $this->builder();
		$builder->where('perm_id', $permId);
		$builder->delete();

		return true;
	}

	/**
	 * Deletes all by User Id
	 *
	 * @param integer $userId User Id
	 *
	 * @return boolean
	 */
	public function deleteAllByUserId(int $userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->delete();

		return true;
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
