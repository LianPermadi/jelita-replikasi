<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat library session
        $this->load->library('session');
        // Memuat helper URL
        $this->load->helper('url');
    }

    public function set_language($key) {
        $this->session->set_userdata('locale', $key);
        // var_dump($key);die();

        redirect($_SERVER['HTTP_REFERER']); // Redirect kembali ke halaman sebelumnya
    }
}
