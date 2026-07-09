<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

    public function get_by_lang_type($lang_type, $limit, $offset) {
        $this->db->where('lang_type', $lang_type);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get('artikel', $limit, $offset);
        return $query->result();
    }

    public function count_by_lang_type($lang_type) {
        $this->db->where('lang_type', $lang_type);
        $query = $this->db->get('artikel');
        return $query->num_rows();
    }
    public function get_by_slug($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('artikel');
        return $query->row(); // Return a single row
    }
}
?>
