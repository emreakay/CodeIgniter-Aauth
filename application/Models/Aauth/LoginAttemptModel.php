<?php
namespace App\Models\Aauth;

use CodeIgniter\Model;
use Config\Aauth as AauthConfig;

class LoginAttemptModel extends Model
{
	protected $useTimestamps  = true;
	protected $createdField   = 'created_datetime';
	protected $updatedField   = 'updated_datetime';
	protected $protectFields  = false;

	public function __construct()
	{
		parent::__construct();
		$this->config = new AauthConfig();
		$this->table = $this->config->dbTableLoginAttempts;
		$this->DBGroup = $this->config->dbProfile;
	}

	public function update($id = null, $data = null)
	{
		$request = \Config\Services::request();
		$builder = $this->builder();
		$ip_address = $request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_datetime >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));

		if ($builder->countAllResults() == 0)
		{
			$data = [];
			$data['ip_address'] = $ip_address;
			$data['count'] = 1;
			$data[$this->updatedField] = $this->setDate();
			$builder->insert($data);
			return true;
		}
		else
		{
			$row = $builder->get()->getFirstRow();
			$data = array();
			$data['count'] = $row->count + 1;
			$data[$this->updatedField] = $this->setDate();
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
		$request = \Config\Services::request();
		$builder = $this->builder();
		$ip_address = $request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_datetime >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));

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

	public function delete($id = null, $purge = false)
	{
		$request = \Config\Services::request();
		$builder = $this->builder();
		$ip_address = $request->getIPAddress();
		$builder->where('ip_address', $ip_address);
		$builder->where('updated_datetime >=', date("Y-m-d H:i:s", strtotime("-".$this->config->loginAttemptLimitTimePeriod)));

		return $builder->delete();
	}
}
