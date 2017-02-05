<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_to_group_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/Groups_model', 'groups');
		$this->cii->load->model('aauth/Permissions_model', 'permissions');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($permission_id, $group_id)
	{
		if ($this->cii->permissions->get_id($permission_id) && $this->cii->groups->get_id($group_id) && ! $this->exist($permission_id, $group_id))
		{
			$data['permission_id'] = $permission_id;
			$data['group_id'] = $group_id;
			return $this->db->insert($this->config_vars['database']['permission_to_group'], $data);
		}

		return FALSE;
	}

	public function delete($permission_id, $group_id)
	{
		$this->db->where('permission_id', $permission_id);
		$this->db->where('group_id', $group_id);
		return $this->db->delete($this->config_vars['database']['permission_to_group']);
	}

	public function delete_by_group($group_id)
	{
		if ($this->cii->groups->get_id($group_id))
		{
			$this->db->where('group_id', $group_id);
			return $this->db->delete($this->config_vars['database']['permission_to_group']);
		}

		return FALSE;
	}

	public function delete_by_permission($permission_id)
	{
		if ($this->cii->permissions->get_id($permission_id))
		{
			$this->db->where('permission_id', $permission_id);
			return $this->db->delete($this->config_vars['database']['permission_to_group']);
		}

		return FALSE;
	}

	public function exist($permission_id, $group_id)
	{
		if ($this->cii->permissions->get_id($permission_id) && $this->cii->groups->get_id($group_id))
		{
			$this->db->where('permission_id', $permission_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get($this->config_vars['database']['permission_to_group']);

			if ($query->num_rows() === 1)
			{
				return TRUE;
			}

			return FALSE;
		}

		return FALSE;
	}
}
