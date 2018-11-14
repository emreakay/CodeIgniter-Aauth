<?php
namespace App\Models\Aauth;

use Config\Aauth as AauthConfig;
use Config\Database;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

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

	public function __construct(ConnectionInterface &$db = null)
	{
		$this->config = new AauthConfig();
		$this->DBGroup = $this->config->dbProfile;
		$this->table = $this->config->dbTableLoginTokens;

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
	 * Works with the current Query Builder instance to return
	 * all results, while optionally limiting them.
	 *
	 * @param intger $user_id
	 * @param boolean $expired
	 *
	 * @return array|null
	 */
	public function getAllByUserId($userId)
	{
		$builder = $this->builder();
		$builder->select('id, user_id, random_hash, selector_hash, expires_at');
		$builder->where('user_id', $userId);

		$row = $builder->get()->getResult('array');

		return $row;
	}

	/**
	 * Updates Login Token
	 *
	 * @param array $data array with data
	 *
	 * @return BaseBuilder
	 */
	public function insert($data)
	{
		$builder = $this->builder();

		$data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

		return $builder->insert($data);
	}

	/**
	 * Updates Login Token by tokenId
	 *
	 * @return BaseBuilder
	 */
	public function update($tokenId)
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
	 * @return BaseBuilder
	 */
	public function delete($userId)
	{
		$builder = $this->builder();
		$builder->where('user_id', $userId);
		$builder->where('expires_at <', date('Y-m-d H:i:s'));

		return $builder->delete();
	}

	/**
	 * Provides a shared instance of the Query Builder.
	 *
	 * @param string $table
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
		if ( ! $this->db instanceof BaseConnection)
		{
			$this->db = Database::connect($this->DBGroup);
		}

		$this->builder = $this->db->table($table);

		return $this->builder;
	}

}
