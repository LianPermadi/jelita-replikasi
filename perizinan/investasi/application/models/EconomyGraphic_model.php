<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EconomyGraphic_model extends CI_Model {

    protected $table = 'economygraphic'; // Nama tabel di database

    public function __construct()
    {
        parent::__construct();
        // Load database agar dapat menggunakan fungsi-fungsi query
        $this->load->database();
    }

    // Method untuk mendapatkan 5 data terakhir
    public function get_last_5()
    {
        return $this->db
            ->order_by('date', 'DESC') // Urutkan berdasarkan tanggal secara descending
            ->limit(5) // Ambil 5 data terakhir
            ->get($this->table)
            ->result(); // Mengembalikan hasil dalam bentuk array
    }

}
