<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['settings'] = $this->settings_model->get_settings();
        $data['title'] = $data['settings']['site_title'];
        $data['countdown_date'] = $data['settings']['countdown_date'];
        $this->load->view('templates/header', $data);
        $this->load->view('home', $data);
        $this->load->view('templates/footer', $data);
    }
}
