<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aauth_init {

	protected $_enabled = FALSE;
	protected $_path = NULL;
	protected $_version = 0;
	protected $_table = 'aauth_init';
	protected $_auto_latest = FALSE;
	protected $_regex = NULL;
	protected $_error_string = '';

	public function __construct($config = array())
	{
		foreach ($config as $key => $val)
		{
			$key = str_replace('aauthinit', '', $key);
			$this->{$key} = $val;
		}

		$this->_regex = '/^(\w+)_v(\d{1})\.(\d{2})$/';'' !== $this->_path OR $this->_path = APPPATH.'libraries/Aauth_init/';
		$this->_path = rtrim($this->_path, '/').'/';
        $this->CII = &get_instance();
		$this->CII->config->load('aauth');
		$this->config_vars = $this->CII->config->item('aauth');
		$this->aauth_db = $this->CII->load->database($this->config_vars['database']['_profile'], TRUE);
		$this->aauth_db_forge = $this->CII->load->dbforge($this->aauth_db, TRUE);

		if ( ! $this->aauth_db->table_exists($this->_table))
		{
			$this->aauth_db_forge->add_field(array(
				'version' => array('type' => 'VARCHAR', 'constraint' => 20),
			));

			$this->aauth_db_forge->create_table($this->_table, TRUE);
			$this->aauth_db->insert($this->_table, array('version' => 0));
		}
	}

	public function version($target_version)
	{
		$current_version = $this->_get_version();
		$target_version = (string) $target_version;
		$updates = $this->find_updates();
		$previous = FALSE;

		if ($current_version == 0)
		{
			$method = 'install';
		}
		else if ($target_version > $current_version)
		{
			$method = 'update';
		}
		foreach ($updates as $number => $file)
		{
			include_once $file;
			$class = 'Aauth_v'.str_replace('.', '', $number);
			$previous = $number;

			if (
				($method === 'install' && $number > $current_version && $number <= $target_version) OR
				($method === 'update' && $number > $current_version && $number <= $target_version)
			)
			{
				$instance = new $class();

				if (is_callable(array($instance, $method)))
				{
					call_user_func(array($instance, $method));
					$current_version = $number;
					$this->_update_version($current_version);
				}
			}
		}
		if ($current_version !== $target_version)
		{
			$current_version = $target_version;
			$this->_update_version($current_version);
		}

		return $current_version;
	}

	public function find_updates()
	{
		$updates = array();

		foreach (glob($this->_path.'*_v*.php') as $file)
		{
			$name = basename($file, '.php');

			if (preg_match($this->_regex, $name))
			{
				$number = $this->_get_number($name);
				$updates[$number] = $file;
			}
		}

		ksort($updates);
		return $updates;
	}

	protected function _get_number($update)
	{
		return str_replace('Aauth_v', '', $update);
	}

	protected function _get_version()
	{
		$row = $this->aauth_db->select('version')->get($this->_table)->row();
		return $row->version;
	}

	protected function _update_version($update)
	{
		$update = str_replace('v', '', $update);
		$this->aauth_db->update($this->_table, array(
			'version' => $update,
		));
	}
}