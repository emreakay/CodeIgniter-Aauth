<?php

class User_variables_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/User_variables_model', 'user_variables', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->user_variables;
	}

	public function test_update()
	{
		$AT_create_user_var = $this->obj->update(1, 'test_key', 'test_var');
		$this->assertTrue($AT_create_user_var);
		$AE_create_user_var = $this->obj->get(1, 'test_key');
		$this->assertEquals('test_var', $AE_create_user_var);
		$AT_update_user_var = $this->obj->update(1, 'test_key', 'test_var_var');
		$this->assertTrue($AT_update_user_var);
		$AE_update_user_var = $this->obj->get(1, 'test_key');
		$this->assertEquals('test_var_var', $AE_update_user_var);
		$AF_wrong_user_id = $this->obj->update(0, 'test_key', 'test_var_var');
		$this->assertFalse($AF_wrong_user_id);
	}

	public function test_get()
	{
		$AF_wrong_user_id = $this->obj->get(0, 'test_key');
		$this->assertFalse($AF_wrong_user_id);
	}

	public function test_get_by_user_id()
	{
		$this->obj->update(1, 'test_key2', 'test_var');
		$this->obj->update(1, 'test_key3', 'test_var');
		$this->obj->update(1, 'test_key4', 'test_var');

		$AE_get_user_vars_1 = $this->obj->get_by_user_id(1);
		$this->assertEquals(4, count($AE_get_user_vars_1));
		$AT_delete_by_user_var = $this->obj->delete(1, 'test_key');
		$this->assertTrue($AT_delete_by_user_var);
		$AE_get_user_vars_2 = $this->obj->get_by_user_id(1);
		$this->assertEquals(3, count($AE_get_user_vars_2));
		$AT_delete_by_user_vars = $this->obj->delete(1);
		$this->assertTrue($AT_delete_by_user_vars);
		$AE_get_user_vars_3 = $this->obj->get_by_user_id(1);
		$this->assertEquals(0, count($AE_get_user_vars_3));
		$AF_wrong_user_id = $this->obj->get_by_user_id(0);
		$this->assertFalse($AF_wrong_user_id);
	}

}
