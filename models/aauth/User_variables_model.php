<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_variables_model extends CI_Model
{
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/Users_model', 'users');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function update($user_id, $key, $value)
	{
		if ($this->cii->users->exist_by_(array('id' => $user_id)))
		{
			$data['data_value'] = $value;

			if (self::_exist($user_id, $key))
			{
				$this->db->where('data_key', $key);
				$this->db->where('user_id', $user_id);
				return $this->db->update($this->config_vars['database']['user_variables'], $data);
			}

			$data['data_key'] = $key;
			$data['user_id'] = $user_id;
			return $this->db->insert($this->config_vars['database']['user_variables'], $data);
		}

		return FALSE;
	}

	public function get($user_id, $key)
	{
		if ($this->cii->users->exist_by_(array('id' => $user_id)) && self::_exist($user_id, $key))
		{
			$query = self::_get($user_id, $key);
			return $query->row()->data_value;
		}

		return FALSE;
	}

	public function get_by_user_id($user_id)
	{
		if ($this->cii->users->exist_by_(array('id' => $user_id)))
		{
			return self::_get($user_id)->result();
		}

		return FALSE;
	}

	public function delete($user_id, $key = NULL)
	{
		if ($key)
		{
			$this->db->where('data_key', $key);
		}

		$this->db->where('user_id', $user_id);
		return $this->db->delete($this->config_vars['database']['user_variables']);
	}

	private function _exist($user_id, $key)
	{
		if (self::_get($user_id, $key)->num_rows() === 1)
		{
			return TRUE;
		}

		return FALSE;
	}

	private function _get($user_id, $key = NULL)
	{
		if ($key)
		{
			$where['data_key'] = $key;
		}

		$where['user_id'] = $user_id;
		$this->db->select('data_key, data_value');
		$this->db->where($where);
		return $this->db->get($this->config_vars['database']['user_variables']);
	}
}
