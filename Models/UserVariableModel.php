<?php namespace Magefly\Aauth\Models;

use \CodeIgniter\Model;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class UserVariableModel extends Model
{
	protected $useSoftDeletes = false;
	protected $useTimestamps  = true;
	protected $createdField   = 'created_datetime';
	protected $updatedField   = 'updated_datetime';
	protected $protectFields  = false;

	public function __construct()
	{
		parent::__construct();
		$this->config = new AauthConfig();
		$this->table = $this->config->dbTableUserVariables;
		$this->DBGroup = $this->config->dbProfile;
	}

	public function get($userId, $dataKey, $system = 0)
	{
		$builder = $this->builder();

		$builder->where('user_id', $userId);
		$builder->where('data_key', $dataKey);

		if ($builder->countAllResults() != 0)
		{
			return $builder->get()->getFirstRow();
		}
		else
		{
			return false;
		}
	}
}
