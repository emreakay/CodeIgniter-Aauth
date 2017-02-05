<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_attempts_model extends CI_Model {
	
	protected $config_vars;
	protected $cii;

	public function __construct()
	{
		parent::__construct();
		$this->cii = &get_instance();
		$this->cii->config->load('aauth');
		$this->config_vars = $this->cii->config->item('aauth');
	}

	public function get()
	{
		$query = $this->_get();

		if ($query->num_rows() === 1)
		{
			return $query->row()->login_attempts;
		}

		return 0;
	}

	public function update()
	{
		$query = $this->_get();

		if ($query->num_rows() === 1)
		{
			$row = $query->row();
			$data['timestamp'] = date('Y-m-d H:i:s');
			$data['login_attempts'] = $row->login_attempts + 1;
			$this->db->update($this->config_vars['database']['login_attempts'], $data, array('id' => $row->id));

			if ($data['login_attempts'] > $this->config_vars['ddos_protection']['max_attempts'])
			{
				return FALSE;
			}

			return TRUE;
		}

		return $this->_create();
	}

	public function delete()
	{
		$data['ip_address'] = $this->cii->input->ip_address();
		$data['timestamp >='] = date('Y-m-d H:i:s', strtotime('-'.$this->config_vars['ddos_protection']['time_period']));
		$this->db->where($data);
		return $this->db->delete($this->config_vars['database']['login_attempts']);
	}

	private function _create()
	{
		$data['ip_address'] = $this->cii->input->ip_address();
		$data['timestamp'] = date('Y-m-d H:i:s');
		$data['login_attempts'] = 1;
		return $this->db->insert($this->config_vars['database']['login_attempts'], $data);
	}

	private function _get()
	{
		$data['ip_address'] = $this->cii->input->ip_address();
		$data['timestamp >='] = date('Y-m-d H:i:s', strtotime('-'.$this->config_vars['ddos_protection']['time_period']));
		$this->db->where($data);
		return $this->db->get($this->config_vars['database']['login_attempts']);
	}
}
