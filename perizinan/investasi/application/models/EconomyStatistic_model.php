<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EconomyStatistic_model extends CI_Model {

    protected $table = 'economystatistic'; // Nama tabel di database

    public function __construct()
    {
        parent::__construct();
        // Load database agar dapat menggunakan fungsi-fungsi query
        $this->load->database();
    }

    // Method untuk mendapatkan data pertama
    public function get_first()
    {
        return $this->db
            ->order_by('id', 'ASC') // Urutkan berdasarkan id secara ascending (data pertama)
            ->limit(1) // Ambil hanya 1 data pertama
            ->get($this->table)
            ->row(); // Mengembalikan hasil dalam bentuk objek
    }

}
