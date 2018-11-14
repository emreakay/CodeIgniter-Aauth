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
 * @author    Jacob Tomlinson
 * @author    Tim Swagger (Renowne, LLC) <tim@renowne.com>
 * @author    Raphael Jackstadt <info@rejack.de>
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
 * User Variable Model.
 *
 * @package CodeIgniter-Aauth
 */
class UserVariableModel
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
		$this->table   = $this->config->dbTableUserVariables;

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
	 * Provides a shared instance of the Query Builder.
	 *
	 * @param string $table Table name
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

		if (! $this->db instanceof BaseConnection)
		{
			$this->db = Database::connect($this->DBGroup);
		}

		$this->builder = $this->db->table($table);

		return $this->builder;
	}

	/**
	 * Find user varialbe
	 *
	 * Find User Variable by userId, dataKey & optional system
	 *
	 * @param integer $userId  User id
	 * @param string  $dataKey Key of variable
	 * @param boolean $system  Whether system variable
	 *
	 * @return string|boolean
	 */
	public function find(int $userId, string $dataKey, bool $system = null)
	{
		$builder = $this->builder();

		$builder->select('data_value');
		$builder->where('user_id', $userId);
		$builder->where('data_key', $dataKey);

		$builder->where('system', ($system ? 1 : 0));

		if ($row = $builder->get()->getFirstRow('array'))
		{
			return $row['data_value'];
		}

		return false;
	}

	/**
	 * Find all user variables
	 *
	 * @param integer $userId User id
	 * @param boolean $system Whether system variable
	 *
	 * @return object
	 */
	public function findAll(int $userId, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('system', ($system ? 1 : 0));

		return $builder->get()->getResult();
	}

	/**
	 * Update/Insert User Variable
	 *
	 * @param integer $userId    User id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable
	 *
	 * @return BaseBuilder
	 */
	public function save(int $userId, string $dataKey, string $dataValue, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		if ($builder->countAllResults())
		{
			$response = $this->update($userId, $dataKey, $dataValue, $system);
		}
		else
		{
			$response = $this->insert($userId, $dataKey, $dataValue, $system);
		}

		return $response;
	}

	/**
	 * Inserts User Variable
	 *
	 * @param integer $userId    User id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable

	 * @return BaseBuilder
	 */
	public function insert(int $userId, string $dataKey, string $dataValue, bool $system = null)
	{
		$data['user_id']    = $userId;
		$data['data_key']   = $dataKey;
		$data['data_value'] = $dataValue;
		$data['system']     = ($system ? 1 : 0);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

		$builder = $this->builder();

		return $builder->insert($data);
	}

	/**
	 * Update User Variable
	 *
	 * @param integer $userId    User id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable
	 *
	 * @return BaseBuilder
	 */
	public function update(int $userId, string $dataKey, string $dataValue, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		$data['data_value'] = $dataValue;
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->set($data)->update();
	}

}
