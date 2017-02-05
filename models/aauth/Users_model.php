<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/User_variables_model', 'user_variables');
		$this->cii->load->model('aauth/Group_to_user_model', 'group_to_user');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($email, $pass, $username = '')
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) && ! $this->exist_by_(array('email' => $email)) && ( ! empty($username) && ! $this->exist_by_(array('username' => $username))))
		{
			$data = array();
			$data['email'] = $email;
			$data['username'] = $username;
			$data['password'] = password_hash($pass, $this->config_vars['password']['hash_algo'], $this->config_vars['password']['hash_options']);
			$data['created_since'] = date('Y-m-d H:i:s');
			$this->db->insert($this->config_vars['database']['users'], $data);

			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update($user_id, $data = array())
	{
		if ($this->exist_by_(array('id' => $user_id)))
		{
			return $this->db->update($this->config_vars['database']['users'], $data, array('id' => $user_id));
		}

		return FALSE;
	}

	public function delete($user_id)
	{
		$this->cii->user_variables->delete($user_id);
		$this->cii->group_to_user->delete_by_user($user_id);
		return $this->db->delete($this->config_vars['database']['users'], array('id' => $user_id));
	}

	public function get_all($options = array())
	{
		$filters = array();
		$args = array();
		$filters['banned'] = '0';

		if (isset($options['filters']))
		{
			$filters = $options['filters'];
		}
		if (isset($options['include_banneds']) && $options['include_banneds'])
		{
			unset($filters['banned']);
		}
		if (isset($options['only_banneds']) && $options['only_banneds'])
		{
			$filters['banned'] = '1';
		}
		if (isset($options['offset']))
		{
			$args['offset'] = $options['offset'];
		}
		if (isset($options['limit']))
		{
			$args['limit'] = $options['limit'];
		}

		$query = $this->get_by_($filters, $args);
		return $query->result();
	}

	public function ban($user_id, $ver_code = NULL)
	{
		if ($this->exist_by_(array('id' => $user_id)))
		{
			if ($ver_code)
			{
				$this->cii->user_variables->update($user_id, 'verification_code', $ver_code);
			}

			$data['banned'] = '1';
			return $this->update($user_id, $data);
		}

		return FALSE;
	}

	public function unban($user_id, $ver_code = NULL)
	{
		if ($this->exist_by_(array('id' => $user_id)) && $this->is_($user_id, 'banned'))
		{
			if ( ! $this->is_($user_id, 'verified'))
			{
				if ($this->cii->user_variables->get($user_id, 'verification_code') !== $ver_code)
				{
					return FALSE;
				}

				$this->cii->user_variables->delete($user_id, 'verification_code');
			}

			return $this->update($user_id, array('banned' => '0'));
		}

		return FALSE;
	}

	public function update_($user_id, $type)
	{
		if ($this->exist_by_(array('id' => $user_id)))
		{
			if ($type === 'activity')
			{
				$data['last_activity'] = date('Y-m-d H:i:s');
			}
			else if ($type === 'last_login')
			{
				$data['last_login'] = date('Y-m-d H:i:s');
				$data['last_ip_address'] = $this->input->ip_address();
			}

			return $this->update($user_id, $data);
		}

		return FALSE;
	}

	public function exist_by_($filters = array())
	{
		if ($this->get_by_($filters)->num_rows() === 1)
		{
			return TRUE;
		}

		return FALSE;
	}

	public function get_($filters, $result_column)
	{
		$query = $this->get_by_($filters, array('select' => $result_column));

		if ($query->num_rows() === 1)
		{
			return $query->row($result_column);
		}

		return FALSE;
	}

	public function get_by_($filters, $options = NULL)
	{
		if ($filters)
		{
			foreach ($filters as $column => $value)
			{
				$this->db->where($column, $value);
			}
		}
		if (isset($options['limit']))
		{
			$this->db->limit($options['limit']);
		}
		if (isset($options['offset']))
		{
			$this->db->offset($options['offset']);
		}
		if (isset($options['select']))
		{
			$this->db->select($options['select']);
		}

		return $this->db->get($this->config_vars['database']['users']);
	}

	public function is_($user_id, $type)
	{
		if ($this->exist_by_(array('id' => $user_id)))
		{
			$data['banned'] = '1';
			$data['id'] = $user_id;
			$query = $this->get_by_($data);

			if ($type === 'banned' && $query->num_rows() === 1)
			{
				return TRUE;
			}
			else if ($type === 'verified' && ! $this->cii->user_variables->get($user_id, 'verification_code'))
			{
				return TRUE;
			}
		}

		return FALSE;
	}
}
