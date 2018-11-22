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
use Config\Services;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

/**
 * Login Attempt caseModel
 *
 * @package CodeIgniter-Aauth
 *
 * @since 3.0.0
 */
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

	/**
	 * Constructor
	 *
	 * @param ConnectionInterface $db Database connection
	 *
	 * @return void
	 */
	public function __construct(ConnectionInterface &$db = null)
	{
		$this->config  = new AauthConfig();
		$this->DBGroup = $this->config->dbProfile;
		$this->table   = $this->config->dbTableLoginAttempts;

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
	 * Get Login Attempt
	 *
	 * Get login attempt based on time and ip address
	 *
	 * @return integer
	 */
	public function find()
	{
		$builder = $this->builder();
		$builder->where('ip_address', $this->request->getIPAddress());
		$builder->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-' . $this->config->loginAttemptLimitTimePeriod)));

		if ($builder->countAllResults() !== 0)
		{
			return $builder->get()->getFirstRow()->count;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Save Login Attempt
	 *
	 * Inserts or Updates Login Attempt
	 *
	 * @return boolean
	 */
	public function save()
	{
		$ipAddress = $this->request->getIPAddress();
		$builder   = $this->builder();
		$builder->where('ip_address', $ipAddress);
		$builder->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-' . $this->config->loginAttemptLimitTimePeriod)));

		if (! $row = $builder->get()->getFirstRow())
		{
			$data['ip_address'] = $ipAddress;
			$data['count']      = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');

			$builder->insert($data);

			return true;
		}
		else
		{
			$data['count']      = $row->count + 1;
			$data['updated_at'] = date('Y-m-d H:i:s');

			$builder->update($data, ['id' => $row->id]);

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

	/**
	 * Delete login attempt.
	 *
	 * Delete login attempt based on time and ip address
	 *
	 * @return BaseBuilder
	 */
	public function delete()
	{
		$builder = $this->builder();
		$builder->where('ip_address', $this->request->getIPAddress());
		$builder->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-' . $this->config->loginAttemptLimitTimePeriod)));

		return $builder->delete();
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

		// Ensure we have a good db connection
		if (! $this->db instanceof BaseConnection)
		{
			$this->db = Database::connect($this->DBGroup);
		}

		$this->builder = $this->db->table($table);

		return $this->builder;
	}

}
