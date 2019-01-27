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
 * User Session Model.
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class UserSessionModel
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
		$this->table          = $this->config->dbTableUserSessions;
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
	 * Find all active user sessions
	 *
	 * @param integer $userId User id
	 * @param boolean $system Whether system variable
	 *
	 * @return object
	 */
	public function findAll()
	{
		$builder = $this->builder();
		$builder->where('timestamp >', strtotime('-' . $this->config->userActiveTime));
		$builder->where("data NOT LIKE CONCAT('%', timestamp, '%')");
		$builder->like('data', 'user|');

		$this->tempReturnType = $this->returnType;

		return $builder->get()->getResult($this->tempReturnType);
	}

	/**
	 * Delete User Session
	 *
	 * @param integer $id Session id
	 *
	 * @return boolean
	 */
	public function delete($id)
	{
		$builder = $this->builder();
		$builder->where('id', $id);
		$builder->delete();

		return true;
	}

	//--------------------------------------------------------------------
	// Utility
	//--------------------------------------------------------------------

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
