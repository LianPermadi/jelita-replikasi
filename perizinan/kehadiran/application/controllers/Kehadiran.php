<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kehadiran extends CI_Controller { 

	public function __construct()
    {
        parent::__construct();
        $this->load->model("absensi_model");
    }

	public function index($id = NULL)
	{
        $short_url = md5($id);
        echo "cek online".$short_url;
	}
    
	public function test($id = NULL)
	{
        echo "cek koneksi";
	}

}