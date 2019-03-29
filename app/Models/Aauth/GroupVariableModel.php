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

use Config\Aauth as AauthConfig;
use Config\Database;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

/**
 * Group Variable Model.
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class GroupVariableModel
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
		$this->table          = $this->config->dbTableGroupVariables;
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
	 * Find group variable
	 *
	 * Find Group Variable by groupId, dataKey & optional system
	 *
	 * @param integer $groupId Group id
	 * @param string  $dataKey Key of variable
	 * @param boolean $system  Whether system variable
	 *
	 * @return string|boolean
	 */
	public function find(int $groupId, string $dataKey, bool $system = null)
	{
		$builder = $this->builder();
		$builder->select('data_value');
		$builder->where('group_id', $groupId);
		$builder->where('data_key', $dataKey);

		$builder->where('system', ($system ? 1 : 0));

		if ($row = $builder->get()->getFirstRow($this->tempReturnType))
		{
			return $row['data_value'];
		}

		return false;
	}

	/**
	 * Find all group variables
	 *
	 * @param integer $groupId Group id
	 * @param boolean $system  Whether system variable
	 *
	 * @return object
	 */
	public function findAll(int $groupId, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->where('system', ($system ? 1 : 0));

		$this->tempReturnType = $this->returnType;

		return $builder->get()->getResult($this->tempReturnType);
	}

	/**
	 * Update/Insert Group Variable
	 *
	 * @param integer $groupId   Group id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable
	 *
	 * @return BaseBuilder
	 */
	public function save(int $groupId, string $dataKey, string $dataValue, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		if ($builder->countAllResults())
		{
			$response = $this->update($groupId, $dataKey, $dataValue, $system);
		}
		else
		{
			$response = $this->insert($groupId, $dataKey, $dataValue, $system);
		}

		return $response;
	}

	/**
	 * Inserts Group Variable
	 *
	 * @param integer $groupId   Group id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable
	 *
	 * @return boolean
	 */
	public function insert(int $groupId, string $dataKey, string $dataValue, bool $system = null)
	{
		$builder = $this->builder();

		$data['group_id']   = $groupId;
		$data['data_key']   = $dataKey;
		$data['data_value'] = $dataValue;
		$data['system']     = ($system ? 1 : 0);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->insert($data)->resultID;
	}

	/**
	 * Update Group Variable
	 *
	 * @param integer $groupId   Group id
	 * @param string  $dataKey   Key of variable
	 * @param string  $dataValue Value of variable
	 * @param boolean $system    Whether system variable
	 *
	 * @return BaseBuilder
	 */
	public function update(int $groupId, string $dataKey, string $dataValue, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		$data['data_value'] = $dataValue;
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->set($data)->update();
	}

	/**
	 * Delete Group Variable
	 *
	 * @param integer $groupId Group id
	 * @param string  $dataKey Key of variable
	 * @param boolean $system  Whether system variable
	 *
	 * @return boolean
	 */
	public function delete(int $groupId, string $dataKey, bool $system = null)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);
		$builder->where('data_key', $dataKey);
		$builder->where('system', ($system ? 1 : 0));

		return $builder->delete()->resultID;
	}

	/**
	 * Delete all Group Variables by Group ID
	 *
	 * @param integer $groupId Group id
	 *
	 * @return boolean
	 */
	public function deleteAllByGroupId(int $groupId)
	{
		$builder = $this->builder();
		$builder->where('group_id', $groupId);

		return $builder->delete()->resultID;
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
		$this->tempReturnType = $this->returnType = 'array';

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
		$this->tempReturnType = $this->returnType = $class;

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
