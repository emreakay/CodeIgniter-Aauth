<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model
{
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->config_vars = $this->cii->config->item('aauth');
		$this->cii->load->model('aauth/Group_to_user_model', 'group_to_user');
	}

	public function create($group_name, $group_definition = '')
	{
		if ($group_name && ! self::get_id($group_name))
		{
			$data['name'] = $group_name;
			$data['definition'] = $group_definition;
			$this->db->insert($this->config_vars['database']['groups'], $data);
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update($group_id, $group_name = NULL, $group_definition = NULL)
	{
		$group_id = self::get_id($group_id);

		if ($group_id)
		{
			if ($group_name)
			{
				$data['name'] = $group_name;
			}
			if ($group_definition)
			{
				$data['definition'] = $group_definition;
			}

			$this->db->where('id', $group_id);
			return $this->db->update($this->config_vars['database']['groups'], $data);
		}

		return FALSE;
	}

	public function delete($group_id)
	{
		$this->cii->group_to_user->delete_group($group_id);
		//DELETE PERM_TO_GROUP
		//DELETE GROUP_TO_GROUP MAIN GROUP
		//DELETE GROUP_TO_GROUP SUB GROUP
		$this->db->where('id', $group_id);
		return $this->db->delete($this->config_vars['database']['groups']);
	}

	public function get($group_id)
	{
		$query = self::_get(array('id' => $group_id));

		if ($query->num_rows() === 1)
		{
			return $query->row();
		}

		return FALSE;
	}

	public function get_id($group_name)
	{
		if (is_numeric($group_name))
		{
			$query = self::_get(array('id' => $group_name));
		}
		else if ( ! is_numeric($group_name))
		{
			$query = self::_get(array('name' => $group_name));
		}
		if ($query->num_rows() === 1)
		{
			return $query->row()->id;
		}

		return FALSE;
	}

	public function get_all()
	{
		$query = self::_get();

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
