<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('settings_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['title'] = 'Admin Panel';
        $data['settings'] = $this->settings_model->get_settings();
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function settings()
    {
        $data['title'] = 'Settings';
        $this->form_validation->set_rules('site_title', 'Site Title', 'required');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
        $this->form_validation->set_rules('countdown_date', 'Countdown Date', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['settings'] = $this->settings_model->get_settings();
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/settings', $data);
            $this->load->view('admin/templates/footer', $data);
        }
        else
        {
            $settings_data = [
                'site_title' => $this->input->post('site_title'),
                'meta_description' => $this->input->post('meta_description'),
                'meta_keywords' => $this->input->post('meta_keywords'),
                'countdown_date' => $this->input->post('countdown_date'),
                'show_about' => $this->input->post('show_about') ? 1 : 0,
                'show_services' => $this->input->post('show_services') ? 1 : 0,
                'show_gallery' => $this->input->post('show_gallery') ? 1 : 0,
                'show_contact' => $this->input->post('show_contact') ? 1 : 0,
                'account_whatsapp' => $this->input->post('account_whatsapp'),
                'account_instagram' => $this->input->post('account_instagram'),
                'account_tiktok' => $this->input->post('account_tiktok'),
                'account_facebook' => $this->input->post('account_facebook'),
                'account_twitter' => $this->input->post('account_twitter'),
                'account_linkedin' => $this->input->post('account_linkedin'),
                'contact_address' => $this->input->post('contact_address'),
                'contact_phone' => $this->input->post('contact_phone'),
                'contact_email' => $this->input->post('contact_email'),
                'opening_days' => $this->input->post('opening_days'),
                'opening_hours' => $this->input->post('opening_hours'),
            ];

            // Handle logo upload
            if (!empty($_FILES['logo']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|webp';
                $config['file_name'] = 'logo';
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo')) {
                    $upload_data = $this->upload->data();
                    $settings_data['logo'] = $upload_data['file_name'];
                } else {
                    $data['error'] = $this->upload->display_errors();
                    $data['settings'] = $this->settings_model->get_settings();
                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/settings', $data);
                    $this->load->view('admin/templates/footer', $data);
                    return;
                }
            }

            // Handle favicon upload
            if (!empty($_FILES['favicon']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'ico';
                $config['file_name'] = 'favicon';
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);
                if ($this->upload->do_upload('favicon')) {
                    $upload_data = $this->upload->data();
                    $settings_data['favicon'] = $upload_data['file_name'];
                } else {
                    $data['error'] = $this->upload->display_errors();
                    $data['settings'] = $this->settings_model->get_settings();
                    $this->load->view('admin/templates/header', $data);
                    $this->load->view('admin/settings', $data);
                    $this->load->view('admin/templates/footer', $data);
                    return;
                }
            }

            $this->settings_model->update_settings($settings_data);
            redirect('admin/settings');
        }
    }

    public function about()
    {
        $data['title'] = 'About Us';
        $this->form_validation->set_rules('about_us_content', 'About Us Content', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['settings'] = $this->settings_model->get_settings();
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/about', $data);
            $this->load->view('admin/templates/footer', $data);
        }
        else
        {
            $settings_data = [
                'about_us_content' => $this->input->post('about_us_content'),
            ];
            $this->settings_model->update_settings($settings_data);
            redirect('admin/about');
        }
    }

    public function services()
    {
        $data['title'] = 'Services';
        $this->form_validation->set_rules('services_content', 'Services Content', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['settings'] = $this->settings_model->get_settings();
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/services', $data);
            $this->load->view('admin/templates/footer', $data);
        }
        else
        {
            $settings_data = [
                'services_content' => $this->input->post('services_content'),
            ];
            $this->settings_model->update_settings($settings_data);
            redirect('admin/services');
        }
    }

    public function gallery()
    {
        $data['title'] = 'Gallery';
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/gallery', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function contact()
    {
        $data['title'] = 'Contact';
        $this->form_validation->set_rules('contact_content', 'Contact Content', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['settings'] = $this->settings_model->get_settings();
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/contact', $data);
            $this->load->view('admin/templates/footer', $data);
        }
        else
        {
            $settings_data = [
                'contact_content' => $this->input->post('contact_content'),
            ];
            $this->settings_model->update_settings($settings_data);
            redirect('admin/contact');
        }
    }

    public function legal()
    {
        $data['title'] = 'Legal Documents';
        $this->form_validation->set_rules('privacy_policy', 'Privacy Policy', 'required');
        $this->form_validation->set_rules('terms_of_use', 'Terms of Use', 'required');
        $this->form_validation->set_rules('cookie_policy', 'Cookie Policy', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['settings'] = $this->settings_model->get_settings();
            $this->load->view('admin/templates/header', $data);
            $this->load->view('admin/legal', $data);
            $this->load->view('admin/templates/footer', $data);
        }
        else
        {
            $settings_data = [
                'privacy_policy' => $this->input->post('privacy_policy'),
                'terms_of_use' => $this->input->post('terms_of_use'),
                'cookie_policy' => $this->input->post('cookie_policy'),
            ];
            $this->settings_model->update_settings($settings_data);
            redirect('admin/legal');
        }
    }
}
