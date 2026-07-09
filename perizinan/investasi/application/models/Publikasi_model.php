<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publikasi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_ordered_by_date() {
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get('publikasi');
        return $query->result(); // Return multiple rows
    }
    public function get_by_slug($slug) {
        $query = $this->db->get_where('publikasi', array('slug' => $slug));
        return $query->row(); // Return a single row
    }
}
?>
