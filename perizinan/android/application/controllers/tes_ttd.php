<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tes_ttd extends CI_Controller {

	public function index()
	{
		$this->load->view('v_tes_ttd');
	}
	function cek(){
		$this->load->view('v_tes_cekttd');
	}
}