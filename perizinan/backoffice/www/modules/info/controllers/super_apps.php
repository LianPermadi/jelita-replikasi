<?php

/**
  * Description of Informasi Perizinan
  * @author agusnur ; Created : 08 Okt 2010
  * @edit PBS       ; Created : 08 Apr 2015
*/

class Super_apps extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->load->model("m_super_apps");
    $this->perizinan = new trperizinan();
    $this->syarat_izin = new trsyarat_perizinan();
    $this->load->library('fpdf');
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    //foreach ($list_auths as $list_auth) {
      //if($list_auth->id_role === '17') {
        $enabled = TRUE;
      //}
    //}
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['data'] = $this->m_super_apps->get_data();
    $this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Jabar Super Apps";
    $this->template->build('super_apps_list', $this->session_info);
  }

  public function etanamya() {
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Elektronik daTA penaNAMan MODAL dan pelaYAnan izin (E-Tanam Modal Ya)";
    $this->template->build('etanamya', $this->session_info);
  }
  
  public function mppdigital() { 
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Mal Pelayanan Publik Digital Jabar (MPP Digital)";
    $this->template->build('mppdigital', $this->session_info);
  }
  
  public function peta_ijin() { 
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Peta Sebaran Penerbitan Ijin";
    $this->template->build('peta_ijin', $this->session_info);
  }
  
  public function peta_potensi() { 
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Peta Sebaran Potensi Investasi Jawa Barat";
    $this->template->build('peta_potensi', $this->session_info);
  }
  
  public function cambuk_nib() { 
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Capaian Penerbitan NIB Jawa Barat";
    $this->template->build('cambuk_nib', $this->session_info);
  }

  public function redirect($id) {
    $id_user = $this->session->userdata('id_auth');
    $link = $this->m_super_apps->get_link($id);
    $modul = 'Super APPS ( '.$this->m_super_apps->get_modul($id).' )'; 
    echo $this->lib_date->view_title($modul);
    $ipaddress = $_SERVER['REMOTE_ADDR']."";
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d G:j:s');
    $kunjungan = 1;
    $counter = $this->m_super_apps->counterdb($id, $kunjungan, $tanggal, $ipaddress, $id_user);
    // var_dump($counter);die();
		header("Location: ".$link);
  }
}