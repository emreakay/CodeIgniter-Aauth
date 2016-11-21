<?php

class Group_to_subgroup_test extends TestCase
{

	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Group_to_subgroup_model', 'group_to_subgroup', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->CI->load->model('aauth/Groups_model', 'groups', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->group_to_subgroup;
	}



}