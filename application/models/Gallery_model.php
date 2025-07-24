<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_gallery()
    {
        $query = $this->db->get('gallery');
        return $query->result_array();
    }

    public function get_image($id)
    {
        $query = $this->db->get_where('gallery', array('id' => $id));
        return $query->row_array();
    }

    public function insert_image($data)
    {
        return $this->db->insert('gallery', $data);
    }

    public function update_image($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('gallery', $data);
    }

    public function delete_image($id)
    {
        return $this->db->delete('gallery', array('id' => $id));
    }
}
