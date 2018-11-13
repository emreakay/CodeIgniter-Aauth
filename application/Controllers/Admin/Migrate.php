<?php
namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Migrate extends Controller
{
	public function index()
	{
		$config = new \Config\Aauth();
		$migrate = \Config\Services::migrations();
		try
		{
		  	$migrate->latest('App', $config->dbProfile);
		}
		catch (\Exception $e)
		{
		  // Do something with the error here...
		}
	}
}
