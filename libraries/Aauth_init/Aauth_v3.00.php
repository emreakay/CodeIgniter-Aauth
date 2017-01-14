<?php

class Aauth_v300
{
	public function __construct()
	{
		$this->CII = &get_instance();
		$this->config_vars = $this->CII->config->item('aauth');
		$this->CII->aauth_db = $this->CII->load->database($this->config_vars['database']['_profile'], TRUE);
		$this->CII->aauth_db_forge = $this->CII->load->dbforge($this->CII->aauth_db, TRUE);
	}

	public function install()
	{
		// Users TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '254',
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '150',
				'null' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '60',
			),
			'banned' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'null' => TRUE,
				'default' => '0',
			),
			'created_since' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'last_ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '39',
				'default' => '',
			),
			'last_login' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'last_activity' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
		));
		$this->CII->aauth_db_forge->add_key('id', TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['users'], FALSE, array('ENGINE' => 'InnoDB'));

		// Login Attempts TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '39',
				'default' => '0',
			),
			'timestamp' => array(
				'type' => 'DATETIME',
				'default' => NULL,
			),
			'login_attempts' => array(
				'type' => 'TINYINT',
				'constraint' => '2',
				'default' => '0',
			),

		));
		$this->CII->aauth_db_forge->add_key('id', TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['login_attempts'], FALSE, array('ENGINE' => 'InnoDB'));

		// User Variables TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'data_key' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'data_value' => array(
				'type' => 'text',
			),
		));
		$this->CII->aauth_db_forge->add_key('id', TRUE);
		$this->CII->aauth_db_forge->add_key('user_id');
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['user_variables'], FALSE, array('ENGINE' => 'InnoDB'));

		// Groups TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'definition' => array(
				'type' => 'TEXT',
			),
		));
		$this->CII->aauth_db_forge->add_key('id', TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['groups'], FALSE, array('ENGINE' => 'InnoDB'));

		// Group To User TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
		));
		$this->CII->aauth_db_forge->add_key(array('group_id','user_id'), TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['group_to_user'], FALSE, array('ENGINE' => 'InnoDB'));

		// Group To SubGroup TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'subgroup_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
		));
		$this->CII->aauth_db_forge->add_key(array('group_id','subgroup_id'), TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['group_to_subgroup'], FALSE, array('ENGINE' => 'InnoDB'));

		// Permissions TABLE
		$this->CII->aauth_db_forge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'definition' => array(
				'type' => 'TEXT',
			),
		));
		$this->CII->aauth_db_forge->add_key('id', TRUE);
		$this->CII->aauth_db_forge->create_table($this->config_vars['database']['permissions'], FALSE, array('ENGINE' => 'InnoDB'));

	}

}
