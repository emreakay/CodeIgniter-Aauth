<?php

class Permissions_to_group_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Permission_to_group_model', 'permission_to_group', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->CI->load->model('aauth/Permissions_model', 'permissions', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->permission_to_group;
	}

	public function test_create()
	{
		$this->CI->permissions->create('test_permission');
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$AT_create = $this->obj->create($test_permission_id, 1);
		$this->assertTrue($AT_create);
		$AF_already_member = $this->obj->create($test_permission_id, 1);
		$this->assertFalse($AF_already_member);
		$AF_wrong_group = $this->obj->create($test_permission_id, 0);
		$this->assertFalse($AF_wrong_group);
		$AF_wrong_permission = $this->obj->create(0, 1);
		$this->assertFalse($AF_wrong_permission);
	}

	public function test_delete()
	{
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$AT_pre_test = $this->obj->exist($test_permission_id, 1);
		$this->assertTrue($AT_pre_test);
		$AT_delete = $this->obj->delete($test_permission_id, 1);
		$this->assertTrue($AT_delete);
		$AF_after_test = $this->obj->exist($test_permission_id, 1);
		$this->assertFalse($AF_after_test);
	}

	public function test_delete_by_group()
	{
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$this->obj->create(1, $test_permission_id);
		$AT_delete_by_group = $this->obj->delete_by_group(1);
		$this->assertTrue($AT_delete_by_group);
		$AF_wrong_group = $this->obj->delete_by_group(0);
		$this->assertFalse($AF_wrong_group);
	}

	public function test_delete_by_permission()
	{
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$this->obj->create(1, $test_permission_id);
		$AT_delete_by_permission = $this->obj->delete_by_permission($test_permission_id);
		$this->assertTrue($AT_delete_by_permission);
		$AF_wrong_permission = $this->obj->delete_by_permission(0);
		$this->assertFalse($AF_wrong_permission);
	}

	public function test_exist()
	{
		$AF_wrong_group = $this->obj->exist(1, 0);
		$this->assertFalse($AF_wrong_group);
		$AF_wrong_permission = $this->obj->exist(0, 1);
		$this->assertFalse($AF_wrong_permission);
	}

}
