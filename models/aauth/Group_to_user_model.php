<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_to_user_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/Users_model', 'users');
		$this->cii->load->model('aauth/Groups_model', 'groups');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($group_id, $user_id)
	{
		if ($this->cii->groups->get_id($group_id) && $this->cii->users->exist_by_(array('id' => $user_id)) && ! $this->exist($group_id, $user_id))
		{
			$data['group_id'] = $group_id;
			$data['user_id'] = $user_id;
			return $this->db->insert($this->config_vars['database']['group_to_user'], $data);
		}

		return FALSE;
	}

	public function delete($group_id, $user_id)
	{
		$this->db->where('group_id', $group_id);
		$this->db->where('user_id', $user_id);
		return $this->db->delete($this->config_vars['database']['group_to_user']);
	}

	public function delete_by_user($user_id)
	{
		if ($this->cii->users->exist_by_(array('id' => $user_id)))
		{
			$this->db->where('user_id', $user_id);
			return $this->db->delete($this->config_vars['database']['group_to_user']);
		}

		return FALSE;
	}

	public function delete_by_group($group_id)
	{
		if ($this->cii->groups->get_id($group_id))
		{
			$this->db->where('group_id', $group_id);
			return $this->db->delete($this->config_vars['database']['group_to_user']);
		}

		return FALSE;
	}

	public function exist($group_id, $user_id)
	{
		if ($this->cii->groups->get_id($group_id) && $this->cii->users->exist_by_(array('id' => $user_id)))
		{
			$this->db->where('group_id', $group_id);
			$this->db->where('user_id', $user_id);
			$query = $this->db->get($this->config_vars['database']['group_to_user']);

			if ($query->num_rows() === 1)
			{
				return TRUE;
			}

			return FALSE;
		}

		return FALSE;
	}
}
