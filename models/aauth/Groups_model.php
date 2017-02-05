<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($name, $definition = '')
	{
		if ($name && ! $this->get_id($name))
		{
			$data['name'] = $name;
			$data['definition'] = $definition;
			$this->db->insert($this->config_vars['database']['groups'], $data);
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update($group_id, $name = NULL, $definition = NULL)
	{
		$group_id = $this->get_id($group_id);

		if ($group_id)
		{
			if ($name)
			{
				$data['name'] = $name;
			}
			if ($definition)
			{
				$data['definition'] = $definition;
			}

			$this->db->where('id', $group_id);
			return $this->db->update($this->config_vars['database']['groups'], $data);
		}

		return FALSE;
	}

	public function delete($group_id)
	{
		$this->cii->load->model('aauth/Group_to_subgroup_model', 'group_to_subgroup');
		$this->cii->load->model('aauth/Group_to_user_model', 'group_to_user');

		$this->cii->group_to_user->delete_by_group($group_id);
		$this->cii->group_to_subgroup->delete_by_group($group_id);	
		//DELETE PERM_TO_GROUP
		$this->db->where('id', $group_id);
		return $this->db->delete($this->config_vars['database']['groups']);
	}

	public function get($group_id)
	{
		$query = $this->_get(array('id' => $group_id));

		if ($query->num_rows() === 1)
		{
			return $query->row();
		}

		return FALSE;
	}

	public function get_id($name)
	{
		if (is_numeric($name))
		{
			$query = $this->_get(array('id' => $name));
		}
		else if ( ! is_numeric($name))
		{
			$query = $this->_get(array('name' => $name));
		}
		if ($query->num_rows() === 1)
		{
			return $query->row()->id;
		}

		return FALSE;
	}

	public function get_all()
	{
		$query = $this->_get();

		if ($query->num_rows() !== 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	private function _get($where = array())
	{
		$this->db->where($where);
		return $this->db->get($this->config_vars['database']['groups']);
	}
}
