<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_to_user_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/Users_model', 'users');
		$this->cii->load->model('aauth/Permissions_model', 'permissions');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($permission_id, $user_id)
	{
		if ($this->cii->permissions->get_id($permission_id) && $this->cii->users->exist_by_(array('id' => $user_id)) && ! $this->exist($user_id, $permission_id))
		{
			$data['permission_id'] = $permission_id;
			$data['user_id'] = $user_id;
			return $this->db->insert($this->config_vars['database']['permission_to_user'], $data);
		}

		return FALSE;
	}

	public function delete($permission_id, $user_id)
	{
		$this->db->where('permission_id', $permission_id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete($this->config_vars['database']['permission_to_user']);
	}

	public function delete_by_user($user_id)
	{
		if ($this->cii->users->exist_by_(array('id' => $user_id)))
		{
			$this->db->where('user_id', $user_id);
			return $this->db->delete($this->config_vars['database']['permission_to_user']);
		}

		return FALSE;
	}

	public function delete_by_permission($permission_id)
	{
		if ($this->cii->permissions->get_id($permission_id))
		{
			$this->db->where('permission_id', $permission_id);
			return $this->db->delete($this->config_vars['database']['permission_to_user']);
		}

		return FALSE;
	}

	public function exist($permission_id, $user_id)
	{
		if ($this->cii->permissions->get_id($permission_id) && $this->cii->users->exist_by_(array('id' => $user_id)))
		{
			$this->db->where('permission_id', $permission_id);
			$this->db->where('user_id', $user_id);
			$query = $this->db->get($this->config_vars['database']['permission_to_user']);

			if ($query->num_rows() === 1)
			{
				return TRUE;
			}

			return FALSE;
		}

		return FALSE;
	}
}
