<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$settings = $this->db->get_where('settings', array('id' => 1))->row();
		$data['logo'] = $settings->logo;
		$data['favicon'] = $settings->favicon;
		$this->load->view('home', $data);
	}
}
