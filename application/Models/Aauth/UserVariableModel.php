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
	 * The format that the results should be returned as.
	 * Will be overridden if the as* methods are used.
	 *
	 * @var string
	 */
	protected $returnType = 'array';

	/**
	 * Used by asArray and asObject to provide
	 * temporary overrides of model default.
	 *
	 * @var string
	 */
	protected $tempReturnType;

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
		$this->config         = new AauthConfig();
		$this->DBGroup        = $this->config->dbProfile;
		$this->table          = $this->config->dbTableUserVariables;
		$this->tempReturnType = $this->returnType;

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

		if ($row = $builder->get()->getFirstRow($this->tempReturnType))
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

		$this->tempReturnType = $this->returnType;

		return $builder->get()->getResult($this->tempReturnType);
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
		$builder = $this->builder();

		$data['user_id']    = $userId;
		$data['data_key']   = $dataKey;
		$data['data_value'] = $dataValue;
		$data['system']     = ($system ? 1 : 0);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

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

	/**
	 * Delete User Variable
	 *
	 * @param integer $userId  User id
	 * @param string  $dataKey Key of variable
	 * @param boolean $system  Whether system variable
	 *
	 * @return BaseBuilder
	 */
	public function delete(int $userId, string $dataKey, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		return $builder->delete();
	}

	//--------------------------------------------------------------------
	// Utility
	//--------------------------------------------------------------------

	/**
	 * Sets the return type of the results to be as an associative array.
	 *
	 * @return Model
	 */
	public function asArray()
	{
		$this->tempReturnType = 'array';

		return $this;
	}

	/**
	 * Sets the return type to be of the specified type of object.
	 * Defaults to a simple object, but can be any class that has
	 * class vars with the same name as the table columns, or at least
	 * allows them to be created.
	 *
	 * @param string $class Class
	 *
	 * @return Model
	 */
	public function asObject(string $class = 'object')
	{
		$this->tempReturnType = $class;

		return $this;
	}

	/**
	 * Returns the first row of the result set. Will take any previous
	 * Query Builder calls into account when determing the result set.
	 *
	 * @return array|object|null
	 */
	public function first()
	{
		$builder = $this->builder();

		$row = $builder->limit(1, 0)->get();
		$row = $row->getFirstRow($this->tempReturnType);

		$this->tempReturnType = $this->returnType;

		return $row;
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
	 * Provides direct access to method in the builder (if available)
	 * and the database connection.
	 *
	 * @param string $name   Name
	 * @param array  $params Params
	 *
	 * @return Model|null
	 */
	public function __call(string $name, array $params)
	{
		$result = null;

		if (method_exists($this->db, $name))
		{
			$result = $this->db->$name(...$params);
		}
		elseif (method_exists($builder = $this->builder(), $name))
		{
			$result = $builder->$name(...$params);
		}

		// Don't return the builder object unless specifically requested
		//, since that will interrupt the usability flow
		// and break intermingling of model and builder methods.
		if ($name !== 'builder' && empty($result))
		{
			return $result;
		}
		if ($name !== 'builder' && ! $result instanceof BaseBuilder)
		{
			return $result;
		}

		return $this;
	}
}
