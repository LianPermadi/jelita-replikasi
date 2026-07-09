<?php
class M_kemitraan extends CI_Model {
    public function __construct() {
        parent::__construct();
        // Memuat database CodeIgniter
        $this->load->database();
    }

    public function get_data() {
        // Mengambil data dari tabel 'kemitraan'
        $query = $this->db->get('agenda');
        return $query->result();
    }
}
?>
