<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->library("Aauth");
		$this->unit->active(TRUE);
	}

	/**
	 * Dump all tests
	 */
	public function index()
	{
		foreach (get_class_methods('Testing') as $index => $test) {
			if ( $test != '__construct' && $test != 'index' && $test != 'get_instance')
				$this->$test();
		}

		echo $this->unit->report();
	}

	public function hash_password()
	{
		$tests = array(
			array('test', false, 'is_string'),
			array('test', 0, 'is_string'),
			array('test', 999999999999999999999, 'is_string'),
			array('test', 'test', 'is_string'),
			array(false, false, 'is_string'),
			array(null, null, 'is_string')
		);

		foreach ($tests as $index => $test) {
			$this->unit->run(
				$this->aauth->hash_password($test[0], $test[1]),
				$test[2],
				__FUNCTION__
			);
		}
	}

	public function google_connect()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		echo $this->aauth->google_initialize();
	}

	public function google()
	{
		if ( ($url = $this->aauth->google_connect()) )
			echo $url;
	}

	public function log()
	{
		var_dump($this->aauth->is_loggedin());
		die();
	}
}