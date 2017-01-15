<?php

class Permissions_to_user_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Permission_to_user_model', 'permission_to_user', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->CI->load->model('aauth/Permissions_model', 'permissions', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->permission_to_user;
	}

	public function test_create()
	{
		$this->CI->permissions->create('test_permission');
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$AT_create = $this->obj->create(1, $test_permission_id);
		$this->assertTrue($AT_create);
		$AF_already_member = $this->obj->create(1, $test_permission_id);
		$this->assertFalse($AF_already_member);
		$AF_wrong_user = $this->obj->create(0, $test_permission_id);
		$this->assertFalse($AF_wrong_user);
		$AF_wrong_permission = $this->obj->create(1, 0);
		$this->assertFalse($AF_wrong_permission);
	}

	public function test_delete()
	{
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$AT_pre_test = $this->obj->exist(1, $test_permission_id);
		$this->assertTrue($AT_pre_test);
		$AT_delete = $this->obj->delete(1, $test_permission_id);
		$this->assertTrue($AT_delete);
		$AF_after_test = $this->obj->exist(1, $test_permission_id);
		$this->assertFalse($AF_after_test);
	}

	public function test_delete_by_user()
	{
		$test_permission_id = $this->CI->permissions->get_id('test_permission');
		$this->obj->create(1, $test_permission_id);
		$AT_delete_by_user = $this->obj->delete_by_user(1);
		$this->assertTrue($AT_delete_by_user);
		$AF_wrong_user = $this->obj->delete_by_user(0);
		$this->assertFalse($AF_wrong_user);
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
		$AF_wrong_user = $this->obj->exist(0, 1);
		$this->assertFalse($AF_wrong_user);
		$AF_wrong_permission = $this->obj->exist(1, 0);
		$this->assertFalse($AF_wrong_permission);
	}

}
