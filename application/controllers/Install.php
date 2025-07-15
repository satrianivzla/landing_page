<?php

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
        $data['requirements'] = $this->install_model->check_server_requirements();
        $this->load->view('install/index', $data);
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
            //write to database.php
            $data = file_get_contents(APPPATH.'config/database.php');
            $data = str_replace(
                array(
                    "'hostname' => 'localhost'",
                    "'username' => 'root'",
                    "'password' => 'root'",
                    "'database' => 'codeigniter'"
                ),
                array(
                    "'hostname' => '".$hostname."'",
                    "'username' => '".$username."'",
                    "'password' => '".$password."'",
                    "'database' => '".$database."'"
                ),
                $data
            );
            write_file(APPPATH.'config/database.php', $data);

            //run migrations
            $migration = $this->install_model->run_migrations();
            if ($migration === TRUE)
            {
                $this->load->view('install/step3');
            }
            else
            {
                show_error($migration);
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
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('install/step3', $error);
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
