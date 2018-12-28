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
 * Group To Group Model
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class GroupToGroupModel
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
		$this->table   = $this->config->dbTableGroupToGroup;

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
	 * Get all Group Ids by Subgroup Id
	 *
	 * @param integer $subgroupId Subgroup Id
	 *
	 * @return array|null
	 */
	public function findAllBySubgroupId(int $subgroupId)
	{
		$builder = $this->builder();
		$builder->select('group_id');
		$builder->where('subgroup_id', $subgroupId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Get all Subgroup Ids by Group Id
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return array|null
	 */
	public function findAllByGroupId(int $groupId)
	{
		$builder = $this->builder();
		$builder->select('subgroup_id');
		$builder->where('group_id', $groupId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Check if exists by Group Id and Subgroup Id
	 *
	 * @param integer $groupId    Group Id
	 * @param integer $subgroupId Subgroup Id
	 *
	 * @return boolean
	 */
	public function exists(int $groupId, int $subgroupId)
	{
		$builder = $this->builder();

		$builder->where('group_id', $groupId);
		$builder->where('subgroup_id', $subgroupId);

		return ($builder->countAllResults() ? true : false);
	}

	/**
	 * Insert
	 *
	 * @param integer $groupId    Group Id
	 * @param integer $subgroupId Subgroup Id
	 *
	 * @return boolean
	 */
	public function insert(int $groupId, int $subgroupId)
	{
		$builder = $this->builder();

		$data['group_id']    = $groupId;
		$data['subgroup_id'] = $subgroupId;

		$builder->insert($data);

		return true;
	}

	/**
	 * Delete by Group Id and Subgroup Id
	 *
	 * @param integer $groupId    Group Id
	 * @param integer $subgroupId Subgroup Id
	 *
	 * @return boolean
	 */
	public function delete(int $groupId, int $subgroupId)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->where('subgroup_id', $subgroupId);
		$builder->delete();

		return true;
	}

	/**
	 * Deletes all by Group Id
	 *
	 * @param integer $groupId Group Id
	 *
	 * @return boolean
	 */
	public function deleteAllByGroupId(int $groupId)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->delete();

		return true;
	}

	/**
	 * Deletes all by Subgroup Id
	 *
	 * @param integer $subgroupId Subgroup Id
	 *
	 * @return boolean
	 */
	public function deleteAllBySubgroupId(int $subgroupId)
	{
		$builder = $this->builder();
		$builder->where('subgroup_id', $subgroupId);
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
