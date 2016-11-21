<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aauth
{
	public $version = '3.00';

	public $CII;

	public $config_vars;

	public function __construct()
	{
		$this->CII = &get_instance();

		$this->CII->load->library('aauth_init');
		$this->CII->aauth_init->version('v'.$this->version);
	}
}
