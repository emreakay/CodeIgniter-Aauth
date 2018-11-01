<?php namespace Magefly\Aauth\Models;

use \CodeIgniter\Model;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class UserModel extends Model
{
	protected $useSoftDeletes = true;
	protected $useTimestamps  = true;
	protected $createdField   = 'created_datetime';
	protected $updatedField   = 'updated_datetime';
	protected $allowedFields  = ['email', 'username', 'password'];
	protected $beforeInsert   = ['hashPassword'];
	protected $beforeUpdate   = ['hashPassword'];

	public function __construct()
	{
		parent::__construct();
		$this->config = new AauthConfig();
		$this->table = $this->config->dbTableUsers;
		$this->DBGroup = $this->config->dbProfile;
		$this->validationRules['email'] = 'required|if_exist|valid_email|is_unique['.$this->table.'.email,id,{id}]';
		$this->validationRules['password'] = 'required|if_exist|min_length['.$this->config->passwordMin.']|max_length['.$this->config->passwordMax.']';
		$this->validationRules['username'] = 'if_exist|is_unique['.$this->table.'.username,id,{id}]|alpha_numeric_space|min_length[3]';
		$this->validationMessages = [
			'email' => [
				'is_unique' => lang('Aauth.existsAlreadyEmail'),
				'valid_email' => lang('Aauth.invalidEmail'),
			],
			'password' => [
				'min_length' => lang('Aauth.invalidPassword'),
				'max_length' => lang('Aauth.invalidPassword'),
			],
			'username' => [
				'is_unique' => lang('Aauth.existsAlreadyUsername'),
				'min_length' => lang('Aauth.invalidUsername'),
			],
		];

		if ($this->config->loginUseUsername)
		{
			$this->validationRules['username'] = 'is_unique['.$this->table.'.username,id,{id}]|required|alpha_numeric_space|min_length[3]';
			$this->validationMessages['username']['required'] = lang('Aauth.requiredUsername');
		}
	}

	public function findAllExtra(int $limit = 0, int $offset = 0, array $options = null)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		if (isset($options['where']))
		{
			foreach ($options['where'] as $key => $value)
			{
				$builder->where($key, $value);
			}
		}

		if (isset($options['order_by']))
		{
			foreach ($options['order_by'] as $key => $value)
			{
				$builder->orderBy($key, $value);
			}
		}

		$row = $builder->limit($limit, $offset)
				->get();

		$row = $row->getResult($this->tempReturnType);

		$row = $this->trigger('afterFind', ['data' => $row, 'limit' => $limit, 'offset' => $offset]);

		$this->tempReturnType = $this->returnType;
		$this->tempUseSoftDeletes = $this->useSoftDeletes;

		return $row['data'];
	}

	public function exists(int $id)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->like($this->table.'.'.$this->primaryKey, $id);

		return $builder->countAllResults();
	}

	protected function hashPassword(array $data)
	{
		if ( ! isset($data['data']['password']))
		{
			return $data;
		}

		$data['data']['password'] = password_hash($data['data']['password'], $this->config->passwordHashAlgo, $this->config->passwordHashOptions);
		return $data;
	}
}
