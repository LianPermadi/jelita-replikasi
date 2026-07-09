<?php 

class M_survey extends CI_Model
{
    function __construct() {
        parent::__construct();
    }



    function get_nib($nib) {
        // Pastikan $nib sudah di-set dan aman untuk digunakan
        if (empty($nib)) {
            return []; // atau return null; jika $nib tidak valid
        }
    
        // Menggunakan query builder CodeIgniter untuk keamanan dan kemudahan
        $this->db->select('id, nib');
        $this->db->from('db_sicantik_backoffice.cambuk_nib');
        $this->db->where('nib', $nib);
        $this->db->limit(1);
    
        $query = $this->db->get();
        return $query->result();
    }
    public function insert_survey($data) {
        // Menggunakan Active Record untuk insert data ke tabel 'survey'
        return $this->db->insert('Survey_Nib', $data);
    }

    // Method untuk mengambil semua data survey (opsional jika diperlukan)
    public function get_all_surveys() {
        $query = $this->db->get('survey');
        return $query->result();
    }
   
}
?>