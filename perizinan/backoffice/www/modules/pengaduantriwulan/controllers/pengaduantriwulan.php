<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @author  Royan Sastramanggala
 *  2014
 *
 */

class Pengaduantriwulan extends WRC_AdminCont {

public function __construct() {
        parent::__construct();
		
        
		
    }

	public function jsbox(){
	 $js =  "
            $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=pengaduantriwulan_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );
                $(document).ready(function() {
                        oTable = $('#realisasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
	}
	public function index() {
	$this->jsbox();
        $this->session_info['page_name'] = "Pengaduan Pertriwulan";
        
        $this->template->build('index', $this->session_info);
    }	
	public function triwulan() {
		$this->jsbox();
		//$this->index();
		$this->load->model('mpengaduantriwulan');
		
		$data['isi'] = $this->mpengaduantriwulan->gettriwulan();
		$this->load->view('triwulan',$data);
		
		$data2['isi2'] = $this->mpengaduantriwulan->gettriwulan2();
		$this->load->view('triwulan',$data2);
        
		$data3['isi3'] = $this->mpengaduantriwulan->gettriwulan3();
		$this->load->view('triwulan',$data3);
		
		$data4['isi4'] = $this->mpengaduantriwulan->gettriwulan4();
		$this->load->view('triwulan',$data4);
		
		$data5['isi5'] = $this->mpengaduantriwulan->gettriwulan5();
		$this->load->view('triwulan',$data5);
		
		$data6['isi6'] = $this->mpengaduantriwulan->gettriwulan6();
		$this->load->view('triwulan',$data6);
        
		$data7['isi7'] = $this->mpengaduantriwulan->gettriwulan7();
		$this->load->view('triwulan',$data7);
		
		$data8['isi8'] = $this->mpengaduantriwulan->gettriwulan8();
		$this->load->view('triwulan',$data8);
		
		
		
        $this->session_info['page_name'] = "Pengaduan Pertriwulan";
        $this->template->build('triwulan', $this->session_info);
    }
	public function rekaptriwulan() {
		$this->jsbox();
		//$this->index();
		$this->load->model('mpengaduantriwulan');
		
		$data['isi'] = $this->mpengaduantriwulan->gettriwulan();
		//$this->load->view('triwulan1',$data);
		
		$data2['isi2'] = $this->mpengaduantriwulan->gettriwulan2();
		//$this->load->view('triwulan1',$data2);
        
		$data3['isi3'] = $this->mpengaduantriwulan->gettriwulan3();
		//$this->load->view('triwulan1',$data3);
		
		$data4['isi4'] = $this->mpengaduantriwulan->gettriwulan4();
		//$this->load->view('triwulan1',$data4);
		
		$data5['isi5'] = $this->mpengaduantriwulan->gettriwulan5();
		//$this->load->view('triwulan1',$data5);
		
		$data6['isi6'] = $this->mpengaduantriwulan->gettriwulan6();
		//$this->load->view('triwulan1',$data6);
        
		$data7['isi7'] = $this->mpengaduantriwulan->gettriwulan7();
		//$this->load->view('triwulan1',$data7);
		
		$data8['isi8'] = $this->mpengaduantriwulan->gettriwulan8();
		$this->load->view('triwulan1',$data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8);
		
		
		
        //$this->session_info['page_name'] = "Pengaduan Pertriwulan";
       // $this->template->build('triwulan', $this->session_info);
    }
public function rekaptriwulan1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('triwulan1', $d);
    }
	
	public function rekaptriwulan2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('triwulan2', $d);
    }
	public function rekaptriwulan3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('triwulan3', $d);
    }
	public function rekaptriwulan4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('triwulan4', $d);
    }
	public function lwrekaptriwulan1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwtriwulan1', $d);
    }
	public function lwrekaptriwulan2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwtriwulan2', $d);
    }
	public function lwrekaptriwulan3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwtriwulan3', $d);
    }
public function lwrekaptriwulan4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwtriwulan4', $d);
    }
	
	public function lerekaptriwulan1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('letriwulan1', $d);
    }
	public function lerekaptriwulan2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('letriwulan2', $d);
    }
	public function lerekaptriwulan3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('letriwulan3', $d);
    }
	public function lerekaptriwulan4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('letriwulan4', $d);
    }
	public function penyelesaian1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('penyelesaian1', $d);
    }
	public function penyelesaian2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('penyelesaian2', $d);
    }
	public function penyelesaian3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('penyelesaian3', $d);
    }
	public function penyelesaian4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('penyelesaian4', $d);
    }
	public function lwpenyelesaian1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwpenyelesaian1', $d);
    }
	public function lwpenyelesaian2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwpenyelesaian2', $d);
    }
	public function lwpenyelesaian3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwpenyelesaian3', $d);
    }
	public function lwpenyelesaian4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lwpenyelesaian4', $d);
    }
	public function lepenyelesaian1($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lepenyelesaian1', $d);
    }
	public function lepenyelesaian2($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lepenyelesaian2', $d);
    }
	public function lepenyelesaian3($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lepenyelesaian3', $d);
    }
	public function lepenyelesaian4($tgla = null) {  // per Sektor Ijin
$this->jsbox();
        $d['page_name'] = "Pengaduan Pertriwulan";
       
        $d['tgla'] = $tgla;
      
        $this->load->vars($d);
        $this->load->view('lepenyelesaian4', $d);
    }
	}