<?php
namespace App\Models\Aauth;

use CodeIgniter\Model;
use Config\Aauth as AauthConfig;

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

	public function updateLastLogin(int $id)
	{
		$builder = $this->builder();
		$data = array();
		$data['last_login'] = $this->setDate();
		$builder->update($data, array('id' => $id));

	}

	public function updateLastActivity(int $id)
	{
		$builder = $this->builder();
		$data = array();
		$data['last_activity'] = $this->setDate();
		$builder->update($data, array('id' => $id));

	}

	public function isBanned(int $id)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where($this->primaryKey, $id);
		$builder->where('banned', 1);
		return $builder->countAllResults();
	}

	public function existsById(int $id)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where($this->primaryKey, $id);
		return $builder->countAllResults();
	}

	public function existsByEmail(string $email)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where('email', $email);
		return $builder->countAllResults();
	}

	public function existsByUsername(string $username)
	{
		$builder = $this->builder();

		if ($this->tempUseSoftDeletes === true)
		{
			$builder->where($this->deletedField, 0);
		}

		$builder->where('username', $username);
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
