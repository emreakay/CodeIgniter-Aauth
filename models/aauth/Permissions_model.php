<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_model extends CI_Model
{
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function create($permission_name, $permission_definition = '')
	{
		if ($permission_name && ! self::get_id($permission_name))
		{
			$data['name'] = $permission_name;
			$data['definition'] = $permission_definition;
			$this->db->insert($this->config_vars['database']['permissions'], $data);
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update($permission_id, $permission_name = NULL, $permission_definition = NULL)
	{
		$permission_id = self::get_id($permission_id);

		if ($permission_id)
		{
			if ($permission_name)
			{
				$data['name'] = $permission_name;
			}
			if ($permission_definition)
			{
				$data['definition'] = $permission_definition;
			}

			$this->db->where('id', $permission_id);
			return $this->db->update($this->config_vars['database']['permissions'], $data);
		}

		return FALSE;
	}

	public function delete($permission_id)
	{
		//DELETE PERM_TO_USER
		//DELETE PERM_TO_GROUP
		$this->db->where('id', $permission_id);
		return $this->db->delete($this->config_vars['database']['permissions']);
	}

	public function get($permission_id)
	{
		$query = self::_get(array('id' => $permission_id));

		if ($query->num_rows() === 1)
		{
			return $query->row();
		}

		return FALSE;
	}

	public function get_id($permission_name)
	{
		if (is_numeric($permission_name))
		{
			$query = self::_get(array('id' => $permission_name));
		}
		else if ( ! is_numeric($permission_name))
		{
			$query = self::_get(array('name' => $permission_name));
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
		return $this->db->get($this->config_vars['database']['permissions']);
	}
}