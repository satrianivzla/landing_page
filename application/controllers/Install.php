<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    private $data = [];

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Install_model');

        // Basic data for views
        $this->data['title'] = 'Installation';
        $this->data['project_name'] = 'Coming Soon';
    }

    public function index() {
        $this->step_1();
    }

    public function step_1() {
        $this->data['section'] = 'Database Setup';
        $this->form_validation->set_rules('hostname', 'Hostname', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('database', 'Database', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('install/header', $this->data);
            $this->load->view('install/step_1', $this->data);
            $this->load->view('install/footer', $this->data);
        } else {
            $db_data = [
                'hostname' => $this->input->post('hostname'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'database' => $this->input->post('database'),
            ];

            if ($this->Install_model->create_database($db_data) && $this->Install_model->create_tables($db_data)) {
                $this->session->set_userdata('db_data', $db_data);
                redirect('install/step_2');
            } else {
                $this->data['error'] = 'Database connection or creation failed. Please check your credentials and try again.';
                $this->load->view('install/header', $this->data);
                $this->load->view('install/step_1', $this->data);
                $this->load->view('install/footer', $this->data);
            }
        }
    }

    public function step_2() {
        $this->data['section'] = 'Admin Account';
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('install/header', $this->data);
            $this->load->view('install/step_2', $this->data);
            $this->load->view('install/footer', $this->data);
        } else {
            $admin_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            ];

            $db_data = $this->session->userdata('db_data');
            if ($this->Install_model->create_admin($db_data, $admin_data)) {
                redirect('install/step_3');
            } else {
                $this->data['error'] = 'Failed to create admin user. Please try again.';
                $this->load->view('install/header', $this->data);
                $this->load->view('install/step_2', $this->data);
                $this->load->view('install/footer', $this->data);
            }
        }
    }

    public function step_3() {
        $this->data['section'] = 'Website Settings';
        $this->form_validation->set_rules('site_title', 'Site Title', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('install/header', $this->data);
            $this->load->view('install/step_3', $this->data);
            $this->load->view('install/footer', $this->data);
        } else {
            $site_data = [
                'site_title' => $this->input->post('site_title'),
            ];
            $db_data = $this->session->userdata('db_data');
            if ($this->Install_model->save_settings($db_data, $site_data)) {
                $this->Install_model->finalize_installation($db_data);
                redirect('install/complete');
            } else {
                $this->data['error'] = 'Failed to save settings. Please try again.';
                $this->load->view('install/header', $this->data);
                $this->load->view('install/step_3', $this->data);
                $this->load->view('install/footer', $this->data);
            }
        }
    }

    public function complete() {
        $this->data['section'] = 'Installation Complete';
        $this->load->view('install/header', $this->data);
        $this->load->view('install/complete', $this->data);
        $this->load->view('install/footer', $this->data);
    }
}
