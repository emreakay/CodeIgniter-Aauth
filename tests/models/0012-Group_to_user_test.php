<?php

class Group_to_user_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Group_to_user_model', 'group_to_user', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->CI->load->model('aauth/Groups_model', 'groups', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->group_to_user;
	}

	public function test_create()
	{
		$this->CI->groups->create('test_group');
		$test_group_id = $this->CI->groups->get_id('test_group');
		$AT_create = $this->obj->create($test_group_id, 1);
		$this->assertTrue($AT_create);
		$AF_already_member = $this->obj->create($test_group_id, 1);
		$this->assertFalse($AF_already_member);
		$AF_wrong_user = $this->obj->create($test_group_id, 0);
		$this->assertFalse($AF_wrong_user);
		$AF_wrong_group = $this->obj->create(0, 1);
		$this->assertFalse($AF_wrong_group);
	}

	public function test_delete()
	{
		$test_group_id = $this->CI->groups->get_id('test_group');
		$AT_pre_test = $this->obj->exist($test_group_id, 1);
		$this->assertTrue($AT_pre_test);
		$AT_delete = $this->obj->delete($test_group_id, 1);
		$this->assertTrue($AT_delete);
		$AF_after_test = $this->obj->exist($test_group_id, 1);
		$this->assertFalse($AF_after_test);
	}

	public function test_delete_by_user()
	{
		$AF_wrong_user = $this->obj->delete_by_user(0);
		$this->assertFalse($AF_wrong_user);
	}

	public function test_delete_by_group()
	{
		$AF_wrong_group = $this->obj->delete_by_group(0);
		$this->assertFalse($AF_wrong_group);
	}

	public function test_exist()
	{
		$AF_wrong_user = $this->obj->exist(1, 0);
		$this->assertFalse($AF_wrong_user);
		$AF_wrong_group = $this->obj->exist(0, 1);
		$this->assertFalse($AF_wrong_group);
	}

}
