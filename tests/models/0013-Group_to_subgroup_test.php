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

	public function test_create()
	{
		$this->CI->groups->create('test_subgroup_1');
		$this->CI->groups->create('test_subgroup_2');
		$test_maingroup_id = $this->CI->groups->get_id('test_subgroup_1');
		$test_subgroup_id = $this->CI->groups->get_id('test_subgroup_2');
		$AT_create = $this->obj->create($test_subgroup_id, $test_maingroup_id);
		$this->assertTrue($AT_create);
		$AF_already_member = $this->obj->create($test_subgroup_id, $test_maingroup_id);
		$this->assertFalse($AF_already_member);
		$AF_wrong_subgroup = $this->obj->create(0, $test_maingroup_id);
		$this->assertFalse($AF_wrong_subgroup);
		$AF_wrong_maingroup = $this->obj->create($test_subgroup_id, 0);
		$this->assertFalse($AF_wrong_maingroup);
		$AF_same_group = $this->obj->create($test_subgroup_id, $test_subgroup_id);
		$this->assertFalse($AF_same_group);
	}

	public function test_delete()
	{
		$test_maingroup_id = $this->CI->groups->get_id('test_subgroup_1');
		$test_subgroup_id = $this->CI->groups->get_id('test_subgroup_2');
		$AT_pre_test = $this->obj->exist($test_subgroup_id, $test_maingroup_id);
		$this->assertTrue($AT_pre_test);
		$AT_delete = $this->obj->delete($test_subgroup_id, $test_maingroup_id);
		$this->assertTrue($AT_delete);
		$AF_after_test = $this->obj->exist($test_subgroup_id, $test_maingroup_id);
		$this->assertFalse($AF_after_test);
	}

	public function test_delete_by_subgroup()
	{
		$test_maingroup_id = $this->CI->groups->get_id('test_subgroup_1');
		$test_subgroup_id = $this->CI->groups->get_id('test_subgroup_2');
		$AT_create = $this->obj->create($test_subgroup_id, $test_maingroup_id);
		$AT_delete_by_subgroup = $this->obj->delete_by_subgroup($test_subgroup_id);
		$this->assertTrue($AT_delete_by_subgroup);

		$AF_wrong_subgroup = $this->obj->delete_by_subgroup(0);
		$this->assertFalse($AF_wrong_subgroup);
	}

	public function test_delete_by_group()
	{
		$test_maingroup_id = $this->CI->groups->get_id('test_subgroup_1');
		$test_subgroup_id = $this->CI->groups->get_id('test_subgroup_2');
		$AT_create = $this->obj->create($test_subgroup_id, $test_maingroup_id);
		$AT_delete_by_group = $this->obj->delete_by_group($test_maingroup_id);
		$this->assertTrue($AT_delete_by_group);
		$AF_wrong_group = $this->obj->delete_by_group(0);
		$this->assertFalse($AF_wrong_group);
	}

	public function test_exist()
	{
		$test_maingroup_id = $this->CI->groups->get_id('test_subgroup_1');
		$test_subgroup_id = $this->CI->groups->get_id('test_subgroup_2');
		$AF_wrong_subgroup = $this->obj->exist(0, $test_maingroup_id);
		$this->assertFalse($AF_wrong_subgroup);
		$AF_wrong_group = $this->obj->exist($test_subgroup_id, 0);
		$this->assertFalse($AF_wrong_group);
	}


}