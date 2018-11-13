<?php
namespace App\Models\Aauth;

use Config\Aauth as AauthConfig;
use Config\Database;
use Config\Services;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

class LoginAttemptModel
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
		$this->table = $this->config->dbTableLoginAttempts;

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

	public function update($id = null, $data = null)
	{
		$builder = $this->builder();
		$ip_address = $this->request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_at >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));
		if ( ! $row = $builder->get()->getFirstRow())
		{
			$data = [];
			$data['ip_address'] = $ip_address;
			$data['count'] = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder->insert($data);
			return true;
		}
		else
		{
			$data = array();
			$data['count'] = $row->count + 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder->update($data, array('id' => $row->id));

			if ($data['count'] > $this->config->loginAttemptLimit)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	public function get()
	{
		$builder = $this->builder();
		$ip_address = $this->request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_at >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));

		if ($builder->countAllResults() != 0)
		{
			$row = $builder->get()->getFirstRow();
			return $row->count;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Deletes login attempt.
	 *
	 * @return BaseBuilder
	 */
	public function delete()
	{
		$builder = $this->builder();
		$ip_address = $this->request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_at >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));

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
