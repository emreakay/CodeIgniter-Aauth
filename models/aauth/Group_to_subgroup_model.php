<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_to_subgroup_model extends CI_Model
{
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->cii->load->model('aauth/Groups_model', 'groups');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($subgroup_id, $group_id)
	{
		if ($this->cii->groups->get_id($group_id) && $this->cii->groups->get_id($subgroup_id) && ! $this->exist($subgroup_id, $group_id) && $subgroup_id != $group_id)
		{
			$data['group_id'] = $group_id;
			$data['subgroup_id'] = $subgroup_id;
			return $this->db->insert($this->config_vars['database']['group_to_subgroup'], $data);
		}

		return FALSE;
	}

	public function delete($subgroup_id, $group_id)
	{
		$this->db->where('group_id', $group_id);
		$this->db->where('subgroup_id', $subgroup_id);
		return $this->db->delete($this->config_vars['database']['group_to_subgroup']);
	}

	public function delete_by_subgroup($subgroup_id)
	{
		if ($this->cii->groups->get_id($subgroup_id))
		{
			$this->db->where('subgroup_id', $subgroup_id);
			return $this->db->delete($this->config_vars['database']['group_to_subgroup']);
		}

		return FALSE;
	}

	public function delete_by_group($group_id)
	{
		if ($this->cii->groups->get_id($group_id))
		{
			$this->db->where('group_id', $group_id);
			return $this->db->delete($this->config_vars['database']['group_to_subgroup']);
		}

		return FALSE;
	}

	public function exist($subgroup_id, $group_id)
	{
		if ($this->cii->groups->get_id($group_id) && $this->cii->groups->get_id($subgroup_id))
		{
			$this->db->where('group_id', $group_id);
			$this->db->where('subgroup_id', $subgroup_id);
			$query = $this->db->get($this->config_vars['database']['group_to_subgroup']);

			if ($query->num_rows() === 1)
			{
				return TRUE;
			}

			return FALSE;
		}

		return FALSE;
	}
}
