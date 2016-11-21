<?php

class Users_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$this->CI->config->load('aauth');
		$this->config_vars = $this->CI->config->item('aauth');
		$this->CI->load->library('aauth');
		$this->CI->load->model('aauth/Users_model', 'users', $this->CI->load->database($this->config_vars['database']['_profile']));
		$this->obj = $this->CI->users;
	}

	public function test_create()
	{
		$AT_create = $this->obj->create('admin@example.com', 'password', 'Admin');
		$this->assertInternalType('int', $AT_create);
		$AF_email_exist = $this->obj->create('admin@example.com', 'password');
		$this->assertFalse($AF_email_exist);
		$AF_username_exist = $this->obj->create('admin@examples.com', 'password', 'Admin');
		$this->assertFalse($AF_username_exist);
		$AF_email_wrong = $this->obj->create('adminexample.com', 'password', 'Admin');
		$this->assertFalse($AF_email_wrong);
	}

	public function test_update()
	{
		$AT_update = $this->obj->update(1, array('username' => 'Admin1'));
		$this->assertTrue($AT_update);
		$AF_userid_false = $this->obj->update(0, array('username' => 'Admin1'));
		$this->assertFalse($AF_userid_false);
		$AF_column_unkown = $this->obj->update(0, array('user' => 'Admin1'));
		$this->assertFalse($AF_column_unkown);
	}

	public function test_delete()
	{
		$this->obj->create('admin@examples.com', 'password', 'Admin');
		$AT_delete = $this->obj->delete(2);
		$this->assertTrue($AT_delete);
	}

	public function test_get_all()
	{
		$this->obj->create('admin@examples.com', 'password', 'Admin');
		$AE_default = $this->obj->get_all();
		$this->assertEquals(2, count($AE_default));
		$this->obj->ban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'));
		$AE_include_banneds = $this->obj->get_all(array('include_banneds' => TRUE));
		$this->assertEquals(2, count($AE_include_banneds));
		$AE_only_banneds = $this->obj->get_all(array('only_banneds' => TRUE));
		$this->assertEquals(1, count($AE_only_banneds));
		$AE_filters = $this->obj->get_all(array('filters' => array('username =' => 'TestUser')));
		$this->assertEquals(0, count($AE_filters));
		$AE_offset_preTest = $this->obj->get_all(array('include_banneds' => TRUE));
		$this->assertEquals(2, count($AE_offset_preTest));
		$AE_offset_1 = $this->obj->get_all(array('limit' => 1, 'offset' => 1, 'include_banneds' => TRUE));
		$this->assertEquals($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), $AE_offset_1[0]->id);
		$AE_limit_1 = $this->obj->get_all(array('limit' => 1));
		$this->assertEquals(1, count($AE_limit_1));

	}

	public function test_ban()
	{
		$AT_ban = $this->obj->ban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'));
		$this->assertTrue($AT_ban);
		$AT_is_banned = $this->obj->is_($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), 'banned');
		$this->assertTrue($AT_is_banned);
		$AT_ban_verifiy = $this->obj->ban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), 'verifiy');
		$this->assertTrue($AT_ban_verifiy);
		$AF_is_not_verified = $this->obj->is_($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), 'verified');
		$this->assertFalse($AF_is_not_verified);
		$AF_userid_false = $this->obj->ban(0);
		$this->assertFalse($AF_userid_false);
	}

	public function test_unban()
	{
		$this->obj->ban(1);
		$AT_unban = $this->obj->unban(1);
		$this->assertTrue($AT_unban);
		$AT_unban_verifiy = $this->obj->unban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), 'verifiy');
		$this->assertTrue($AT_unban_verifiy);
		$this->obj->ban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'), 'verifiy');
		$AF_no_verCode = $this->obj->unban($this->obj->get_(array('email' => 'admin@examples.com'), 'id'));
		$this->assertFalse($AF_no_verCode);
		$AF_userid_false = $this->obj->unban(0);
		$this->assertFalse($AF_userid_false);
		$AF_not_banned = $this->obj->unban(1);
		$this->assertFalse($AF_not_banned);

	}

	public function test_update_()
	{
		$AT_activity = $this->obj->update_(1, 'activity');
		$this->assertTrue($AT_activity);
		$AT_last_login = $this->obj->update_(1, 'last_login');
		$this->assertTrue($AT_last_login);
		$AF_userid_false = $this->obj->update_(0, 'activity');
		$this->assertFalse($AF_userid_false);
	}

	public function test_is_()
	{
		$AT_verified = $this->obj->is_(1, 'verified');
		$this->assertTrue($AT_verified);
		$AF_userid_false = $this->obj->is_(0, 'verified');
		$this->assertFalse($AF_userid_false);
		$this->obj->delete($this->obj->get_(array('email' => 'admin@examples.com'), 'id'));
	}

	public function test_get_()
	{
		$AF_user_unknown = $this->obj->get_(array('email' => 'admin@examples.com'), 'id');
		$this->assertFalse($AF_user_unknown);
	}
}
