<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eperdin extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->model('m_login');
    $this->load->model('m_perdin');
  }

  function index(){
    $awalyear =  date('Y').'-01-01';
    $akhiryear =  date('Y').'-12-31';
    $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
    $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;
    $perdin = $this->m_login->get_perdin($tgla, $tglb);
    $data['list_perdin'] = $perdin;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $this->load->vars($data);
    $this->session_info['page_name'] = "Laporan Perjalanan Dinas (e-perdin)";
    $this->load->view('v_perdin_list', $data);
  }   
  
  public function rupiah($angka){
    $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
    return $hasil_rupiah;
  }
}