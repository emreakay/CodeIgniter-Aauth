<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_model extends CI_Model {
	
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
			$this->db->insert($this->config_vars['database']['permissions'], $data);
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function update($uid, $name = NULL, $definition = NULL)
	{
		$uid = $this->get_id($uid);

		if ($uid)
		{
			if ($name)
			{
				$data['name'] = $name;
			}
			if ($definition)
			{
				$data['definition'] = $definition;
			}

			$this->db->where('id', $uid);
			return $this->db->update($this->config_vars['database']['permissions'], $data);
		}

		return FALSE;
	}

	public function delete($uid)
	{
		//DELETE PERM_TO_USER
		//DELETE PERM_TO_GROUP
		$this->db->where('id', $uid);
		return $this->db->delete($this->config_vars['database']['permissions']);
	}

	public function get($uid)
	{
		$query = $this->_get(array('id' => $uid));

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
		return $this->db->get($this->config_vars['database']['permissions']);
	}
}