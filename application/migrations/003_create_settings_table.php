<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_settings_table extends CI_Migration {

	public function up()
	{
		// Table structure for table 'settings'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'logo' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('settings');

		// Dumping data for table 'settings'
		$data = array(
			'id' => '1',
			'logo' => 'https://via.placeholder.com/150x50.png?text=Logo'
		);
		$this->db->insert('settings', $data);
	}

	public function down()
	{
		$this->dbforge->drop_table('settings', TRUE);
	}
}
