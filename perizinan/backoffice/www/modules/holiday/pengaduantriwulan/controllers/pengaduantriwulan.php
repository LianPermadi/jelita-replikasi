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
	public function index() {
        //$this->session_info['page_name'] = "Pengaduan Pertriwulan";
        
        //$this->template->build('index', $this->session_info);
    }	
	public function triwulan() {
		
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
	}