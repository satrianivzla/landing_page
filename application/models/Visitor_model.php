<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function log_visitor()
    {
        $data = array(
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'page_url'   => current_url()
        );

        $this->db->insert('visitors', $data);
    }

    public function get_visitors()
    {
        $query = $this->db->get('visitors');
        return $query->result_array();
    }

    public function get_banned_ips()
    {
        $query = $this->db->get('banned_ips');
        return $query->result_array();
    }

    public function ban_ip($ip_address)
    {
        $data = array(
            'ip_address' => $ip_address
        );

        return $this->db->insert('banned_ips', $data);
    }

    public function unban_ip($id)
    {
        return $this->db->delete('banned_ips', array('id' => $id));
    }

    public function is_banned($ip_address)
    {
        $query = $this->db->get_where('banned_ips', array('ip_address' => $ip_address));
        return $query->num_rows() > 0;
    }

    public function get_visitor_data_for_graph()
    {
        $this->db->select('DATE(timestamp) as date, COUNT(id) as count');
        $this->db->group_by('DATE(timestamp)');
        $query = $this->db->get('visitors');
        return $query->result_array();
    }
}
