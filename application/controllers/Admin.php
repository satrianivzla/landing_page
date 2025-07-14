<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
	}

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function slider()
	{
		$this->load->view('admin/slider');
	}

	public function upload_slider_image()
	{
		$config['upload_path']          = './uploads/slider/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['max_width']            = 1920;
		$config['max_height']           = 1080;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('image'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/slider', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['upload_data']['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 1920;
			$config['height']       = 1080;
			$config['new_image'] = './uploads/slider/webp/'.$data['upload_data']['raw_name'].'.webp';
			$config['quality'] = '80%';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			//save to database
			$this->db->insert('slider', array('image' => $config['new_image']));

			redirect('admin/slider');
		}
	}

	public function about()
	{
		$this->load->view('admin/about');
	}

	public function update_about()
	{
		$data = array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content')
		);
		$this->db->where('id', 1);
		$this->db->update('about', $data);
		redirect('admin/about');
	}

	public function services()
	{
		$this->load->view('admin/services');
	}

	public function update_services()
	{
		$data = array(
			array(
				'id' => 1,
				'title' => $this->input->post('service1_title'),
				'content' => $this->input->post('service1_content')
			),
			array(
				'id' => 2,
				'title' => $this->input->post('service2_title'),
				'content' => $this->input->post('service2_content')
			),
			array(
				'id' => 3,
				'title' => $this->input->post('service3_title'),
				'content' => $this->input->post('service3_content')
			),
			array(
				'id' => 4,
				'title' => $this->input->post('service4_title'),
				'content' => $this->input->post('service4_content')
			)
		);
		$this->db->update_batch('services', $data, 'id');
		redirect('admin/services');
	}

	public function gallery()
	{
		$this->load->view('admin/gallery');
	}

	public function upload_gallery_image()
	{
		$config['upload_path']          = './uploads/gallery/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['max_width']            = 1920;
		$config['max_height']           = 1080;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('image'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/gallery', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['upload_data']['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 800;
			$config['height']       = 600;
			$config['new_image'] = './uploads/gallery/webp/'.$data['upload_data']['raw_name'].'.webp';
			$config['quality'] = '80%';
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			//save to database
			$this->db->insert('gallery', array('image' => $config['new_image'], 'category' => $this->input->post('category')));

			redirect('admin/gallery');
		}
	}

	public function contact()
	{
		$this->load->view('admin/contact');
	}

	public function update_contact()
	{
		$data = array(
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'map' => $this->input->post('map')
		);
		$this->db->where('id', 1);
		$this->db->update('contact', $data);
		redirect('admin/contact');
	}

	public function legal()
	{
		$this->load->view('admin/legal');
	}

	public function update_legal()
	{
		$data = array(
			array(
				'id' => 1,
				'content' => $this->input->post('privacy')
			),
			array(
				'id' => 2,
				'content' => $this->input->post('cookies')
			),
			array(
				'id' => 3,
				'content' => $this->input->post('terms')
			)
		);
		$this->db->update_batch('legal', $data, 'id');
		redirect('admin/legal');
	}

	public function logo()
	{
		$this->load->view('admin/logo');
	}

	public function upload_logo()
	{
		$config['upload_path']          = './uploads/logo/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['max_width']            = 1920;
		$config['max_height']           = 1080;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('image'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/logo', $error);
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

			//save to database
			$this->db->where('id', 1);
			$this->db->update('settings', array('logo' => $config['new_image']));

			redirect('admin/logo');
		}
	}
}
