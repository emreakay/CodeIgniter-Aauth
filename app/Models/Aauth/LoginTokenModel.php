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
 * Login Token Model
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
class LoginTokenModel
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
		$this->table   = $this->config->dbTableLoginTokens;

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
	 * Find all Login Tokens by User ID
	 *
	 * @param integer $userId User id
	 *
	 * @return array|null
	 */
	public function findAllByUserId(int $userId)
	{
		$builder = $this->builder();
		$builder->select('id, user_id, random_hash, selector_hash, expires_at');
		$builder->where('user_id', $userId);

		return $builder->get()->getResult('array');
	}

	/**
	 * Insert Login Token
	 *
	 * @param array $data Array with data
	 *
	 * @return boolean
	 */
	public function insert(array $data)
	{
		$builder = $this->builder();

		$data['created_at'] = date('Y-m-d H:i:s');
		$data['expires_at'] = date('Y-m-d H:i:s', strtotime($this->config->loginRemember));
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->insert($data)->resultID;
	}

	/**
	 * Update Login Token by tokenId
	 *
	 * @param integer $tokenId Login Token id
	 *
	 * @return boolean
	 */
	public function update(int $tokenId)
	{
		$builder = $this->builder();
		$builder->where('id', $tokenId);

		$data['expires_at'] = date('Y-m-d H:i:s', strtotime($this->config->loginRemember));
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->set($data)->update();
	}

	/**
	 * Deletes expired Login Tokens by userId.
	 *
	 * @param integer $userId User id
	 *
	 * @return boolean
	 */
	public function deleteExpired(int $userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('expires_at <', date('Y-m-d H:i:s'));

		return $builder->delete()->resultID;
	}

	/**
	 * Deletes all Login Tokens by userId.
	 *
	 * @param integer $userId User id
	 *
	 * @return boolean
	 */
	public function deleteAll(int $userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);

		return $builder->delete()->resultID;
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
