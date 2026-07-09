<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // Memuat model 'M_kemitraan'
        $this->load->model('User_model');
    }
    public function index() {
        $this->load->view('halaman_saya');
    }

}
