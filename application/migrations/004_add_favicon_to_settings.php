<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_favicon_to_settings extends CI_Migration {

	public function up()
	{
		$fields = array(
			'favicon' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
				'after' => 'logo'
			)
		);
		$this->dbforge->add_column('settings', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('settings', 'favicon');
	}
}
