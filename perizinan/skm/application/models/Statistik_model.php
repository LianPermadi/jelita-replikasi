<?php
// application/models/Statistik_model.php

defined('BASEPATH') or exit('No direct script access allowed');

class Statistik_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_list()
    {
        // TODO: kembalikan data untuk chart/statistik
        // Contoh: return $this->db->select('bulan, total')->from('skm_stat')->order_by('bulan')->get()->result();
        return [];
    }
}