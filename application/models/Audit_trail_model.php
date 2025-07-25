<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_trail_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function log_audit($data)
    {
        return $this->db->insert('audit_trail', $data);
    }

    public function get_audit_trail()
    {
        $this->db->select('audit_trail.*, users.username');
        $this->db->from('audit_trail');
        $this->db->join('users', 'users.id = audit_trail.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
