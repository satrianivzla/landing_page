<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_categories_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_categories()
    {
        $query = $this->db->get('gallery_categories');
        return $query->result_array();
    }

    public function get_category($id)
    {
        $query = $this->db->get_where('gallery_categories', array('id' => $id));
        return $query->row_array();
    }

    public function insert_category($data)
    {
        return $this->db->insert('gallery_categories', $data);
    }

    public function update_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('gallery_categories', $data);
    }

    public function delete_category($id)
    {
        return $this->db->delete('gallery_categories', array('id' => $id));
    }
}
