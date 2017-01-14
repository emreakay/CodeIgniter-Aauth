<?php

class Permissions_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Permissions_model', 'permissions', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->permissions;
	}

	public function test_create()
	{
		$AIT_create = $this->obj->create('test_permission');
		$this->assertInternalType('int', $AIT_create);
		$AF_same_permission = $this->obj->create('test_permission');
		$this->assertFalse($AF_same_permission);
		$AF_no_permission = $this->obj->create('');
		$this->assertFalse($AF_no_permission);

	}

	public function test_update()
	{
		$AT_update_1 = $this->obj->update(1, 'new_test_permission');
		$this->assertTrue($AT_update_1);
		$AE_update_1_confirm = $this->obj->get_id('new_test_permission');
		$this->assertEquals('1', $AE_update_1_confirm);
		$AT_update_2 = $this->obj->update(1, 'test_permission', 'testPermission');
		$this->assertTrue($AT_update_2);
		$AE_update_2_confirm = $this->obj->get($this->obj->get_id('test_permission'));
		$this->assertEquals('testPermission', $AE_update_2_confirm->definition);
		$AF_wrong_id = $this->obj->update(0, 'test_permission_1', 'test perm 1');
		$this->assertFalse($AF_wrong_id);
	}

	public function test_get_id()
	{
		$AF_wrong_name = $this->obj->get_id('');
		$this->assertFalse($AF_wrong_name);
		$AIT_id_given = $this->obj->get_id(1);
		$this->assertEquals('1', $AIT_id_given);
	}

	public function test_get()
	{
		$AF_wrong_name = $this->obj->get($this->obj->get_id('testPerm'));
		$this->assertFalse($AF_wrong_name);
	}

	public function test_get_all()
	{
		$AE_get_all = $this->obj->get_all();
		$this->assertEquals(1, count($AE_get_all));
		$AT_delete = $this->obj->delete(1);
		$this->assertTrue($AT_delete);
		$AF_get_all = $this->obj->get_all();
		$this->assertFalse($AF_get_all);

	}

}
