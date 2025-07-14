<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_cms_tables extends CI_Migration {

	public function up()
	{
		// Table structure for table 'slider'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'image' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('slider');

		// Table structure for table 'about'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'content' => array(
				'type' => 'TEXT',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('about');

		// Table structure for table 'services'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'content' => array(
				'type' => 'TEXT',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('services');

		// Table structure for table 'gallery'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'image' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'category' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('gallery');

		// Table structure for table 'contact'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'map' => array(
				'type' => 'TEXT',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('contact');

		// Table structure for table 'legal'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'content' => array(
				'type' => 'TEXT',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('legal');

		// Dumping data for table 'about'
		$data = array(
			'id' => '1',
			'title' => 'About Us',
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.'
		);
		$this->db->insert('about', $data);

		// Dumping data for table 'services'
		$data = array(
			array(
				'id' => '1',
				'title' => 'Sturdy Templates',
				'content' => 'Our templates are updated regularly so they don\'t break.'
			),
			array(
				'id' => '2',
				'title' => 'Ready to Ship',
				'content' => 'You can use this theme as is, or you can make changes!'
			),
			array(
				'id' => '3',
				'title' => 'Up to Date',
				'content' => 'We update dependencies to keep things fresh.'
			),
			array(
				'id' => '4',
				'title' => 'Made with Love',
				'content' => 'Is it really open source if it\'s not made with love?'
			)
		);
		$this->db->insert_batch('services', $data);

		// Dumping data for table 'contact'
		$data = array(
			'id' => '1',
			'phone' => '123-456-6789',
			'email' => 'feedback@startbootstrap.com',
			'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.252953282967!2d144.9630579153165!3d-37.81410797975145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d2f4c4a5a2a7!2sFederation+Square!5e0!3m2!1sen!2sau!4v1542861612419" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'
		);
		$this->db->insert('contact', $data);

		// Dumping data for table 'legal'
		$data = array(
			array('id' => '1', 'content' => ''),
			array('id' => '2', 'content' => ''),
			array('id' => '3', 'content' => '')
		);
		$this->db->insert_batch('legal', $data);
	}

	public function down()
	{
		$this->dbforge->drop_table('slider', TRUE);
		$this->dbforge->drop_table('about', TRUE);
		$this->dbforge->drop_table('services', TRUE);
		$this->dbforge->drop_table('gallery', TRUE);
		$this->dbforge->drop_table('contact', TRUE);
		$this->dbforge->drop_table('legal', TRUE);
	}
}
