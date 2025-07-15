<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->model('install_model');
    }

    public function index()
    {
        if (empty($this->config->item('base_url')))
        {
            $this->data['message'] = 'Please set the base_url in application/config/config.php';
        }
        else
        {
            $this->data['message'] = '';
        }
        $this->data['requirements'] = $this->install_model->check_server_requirements();
        $this->load->view('install/index', $this->data);
    }

    public function step2()
    {
        $this->load->view('install/step2');
    }

    public function step3()
    {
        $hostname = $this->input->post('hostname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $database = $this->input->post('database');

        if ($this->install_model->validate_database_credentials($hostname, $username, $password, $database))
        {
            //create uploads directories
            if (!is_dir('./uploads')) {
                mkdir('./uploads', 0755, TRUE);
            }
            if (!is_dir('./uploads/slider')) {
                mkdir('./uploads/slider', 0755, TRUE);
            }
            if (!is_dir('./uploads/slider/webp')) {
                mkdir('./uploads/slider/webp', 0755, TRUE);
            }
            if (!is_dir('./uploads/gallery')) {
                mkdir('./uploads/gallery', 0755, TRUE);
            }
            if (!is_dir('./uploads/gallery/webp')) {
                mkdir('./uploads/gallery/webp', 0755, TRUE);
            }
            if (!is_dir('./uploads/logo')) {
                mkdir('./uploads/logo', 0755, TRUE);
            }
            if (!is_dir('./uploads/logo/webp')) {
                mkdir('./uploads/logo/webp', 0755, TRUE);
            }
            if (!is_dir('./uploads/favicon')) {
                mkdir('./uploads/favicon', 0755, TRUE);
            }

            //write to database.php
            $data = file_get_contents(APPPATH.'config/database.php');
            $data = str_replace(
                array(
                    '$database_host     = "localhost"',
                    '$database_user     = \'root\'',
                    '$database_password = \'\'',
                    '$database_name     = \'landingcms\''
                ),
                array(
                    '$database_host     = "'.$hostname.'"',
                    '$database_user     = \''.$username.'\'',
                    '$database_password = \''.$password.'\'',
                    '$database_name     = \''.$database.'\''
                ),
                $data
            );
            write_file(APPPATH.'config/database.php', $data);

            //run migrations
            $this->load->library('migration');
            if ($this->migration->latest() === FALSE)
            {
                show_error($this->migration->error_string());
            }
            else
            {
                $this->load->library('ion_auth');
                $this->load->view('install/step3');
            }
        }
        else
        {
            show_error('Invalid database credentials.');
        }
    }

    public function step4()
    {
        //upload logo
		$config['upload_path']          = './uploads/logo/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['max_width']            = 1920;
		$config['max_height']           = 1080;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('logo'))
		{
			$this->install_model->save_site_info($this->input->post('site_title'), 'https://placehold.co/150x50');
			$this->load->view('install/step4');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['upload_data']['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 200;
			$config['height']       = 200;
			$config['new_image'] = './uploads/logo/webp/'.$data['upload_data']['raw_name'].'.webp';
			$config['quality'] = '80%';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			$this->install_model->save_site_info($this->input->post('site_title'), $config['new_image']);

			$this->load->view('install/step4');
		}
    }

}

/* End of file Install.php */
/* Location: ./application/controllers/Install.php */
