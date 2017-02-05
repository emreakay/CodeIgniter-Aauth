<?php

class Login_attempts_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Login_attempts_model', 'login_attempts', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->login_attempts;
	}

	public function test_update()
	{
		$AE_get_0 = $this->obj->get();
		$this->assertEquals(0, $AE_get_0);
		$AT_update_create = $this->obj->update();
		$this->assertTrue($AT_update_create);
		$AE_get_1 = $this->obj->get();
		$this->assertEquals(1, $AE_get_1);
		$AT_update_update = $this->obj->update();
		$this->assertTrue($AT_update_update);
		$AE_get_2 = $this->obj->get();
		$this->assertEquals(2, $AE_get_2);

		for ($i=$this->obj->get(); $i < $this->config_vars['ddos_protection']['max_attempts']; $i++) {
			$this->obj->update();
		}

		$this->assertEquals($this->config_vars['ddos_protection']['max_attempts'], $this->obj->get());
		$AF_max_attempts = $this->obj->update();
		$this->assertFalse($AF_max_attempts);
	}

	public function test_delete()
	{
		$AT_delete = $this->obj->delete();
		$this->assertTrue($AT_delete);
		$AE_get_0 = $this->obj->get();
		$this->assertEquals(0, $AE_get_0);
	}
}
