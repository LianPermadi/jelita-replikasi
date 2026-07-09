<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

    protected $table = 'banner';
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_banner_by_menu($menu)
    {
        $this->db->where('menu', $menu);
        $query = $this->db->get('banner');
        return $query->row();
    }
    public function get_all()
    {
        $query = $this->db->get('countries');
        return $query->result();
    }
    public function get_by_menu($menu) {
        $this->db->where('menu', $menu);
        $query = $this->db->get('banner');
        return $query->row();
    }

    
}
