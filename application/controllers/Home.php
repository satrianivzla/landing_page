<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data['logo'] = $this->db->get_where('settings', array('id' => 1))->row()->logo;
		$this->load->view('home', $data);
	}
}
