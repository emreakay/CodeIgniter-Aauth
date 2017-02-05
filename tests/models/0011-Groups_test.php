<?php

class Groups_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Groups_model', 'groups', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->groups;
	}

	public function test_create()
	{
		$AIT_create = $this->obj->create('test_group');
		$this->assertInternalType('int', $AIT_create);
		$AF_same_group = $this->obj->create('test_group');
		$this->assertFalse($AF_same_group);
		$AF_no_group = $this->obj->create('');
		$this->assertFalse($AF_no_group);

	}

	public function test_update()
	{
		$AT_update_1 = $this->obj->update(1, 'new_test_group');
		$this->assertTrue($AT_update_1);
		$AE_update_1_confirm = $this->obj->get_id('new_test_group');
		$this->assertEquals('1', $AE_update_1_confirm);
		$AT_update_2 = $this->obj->update(1, 'test_group', 'testGroup');
		$this->assertTrue($AT_update_2);
		$AE_update_2_confirm = $this->obj->get($this->obj->get_id('test_group'));
		$this->assertEquals('testGroup', $AE_update_2_confirm->definition);
		$AF_wrong_id = $this->obj->update(0, 'test_group_1', 'test grp 1');
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
		$AF_wrong_name = $this->obj->get($this->obj->get_id('testGrp'));
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
