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

		$this->request = Services::request();
	}

	/**
	 * Get all Login Tokens by User ID
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
	 * Updates Login Token
	 *
	 * @param array $data Array with data
	 *
	 * @return BaseBuilder
	 */
	public function insert(array $data)
	{
		$builder = $this->builder();

		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->insert($data);
	}

	/**
	 * Updates Login Token by tokenId
	 *
	 * @param integer $tokenId Login Token id
	 *
	 * @return BaseBuilder
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
	 * @return BaseBuilder
	 */
	public function deleteExpired(int $userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('expires_at <', date('Y-m-d H:i:s'));

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

		// Ensure we have a good db connection
		if (! $this->db instanceof BaseConnection)
		{
			$this->db = Database::connect($this->DBGroup);
		}

		$this->builder = $this->db->table($table);

		return $this->builder;
	}

}
