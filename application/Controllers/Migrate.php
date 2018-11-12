<?php namespace Magefly\Aauth\Controllers;

use CodeIgniter\Controller;
use Magefly\Aauth\Config\Aauth as AauthConfig;

class Migrate extends Controller
{
	public function index()
	{
		$config = new AauthConfig();
		$migrate = \Config\Services::migrations();
		try
		{
		  	$migrate->latest('Magefly\Aauth', $config->dbProfile);
		}
		catch (\Exception $e)
		{
		  // Do something with the error here...
		}
	}
}
