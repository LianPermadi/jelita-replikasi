<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @author  Royan Sastramanggala
 *  2014
 *
 */

class Lwpengaduantriwulan extends Controller {

public function __construct() {
        parent::__construct();
		
        
    }
	public function index() {
        //$this->session_info['page_name'] = "Pengaduan Pertriwulan";
        
        //$this->template->build('index', $this->session_info);
    }	
	public function triwulan() {
		
		$this->index();
		$this->load->model('mpengaduantriwulan');
		
		$data['isi'] = $this->mpengaduantriwulan->gettriwulan();
		$this->load->view('lwtriwulan',$data);
		
		$data2['isi2'] = $this->mpengaduantriwulan->gettriwulan2();
		$this->load->view('lwtriwulan',$data2);
        
		$data3['isi3'] = $this->mpengaduantriwulan->gettriwulan3();
		$this->load->view('lwtriwulan',$data3);
		
		$data4['isi4'] = $this->mpengaduantriwulan->gettriwulan4();
		$this->load->view('lwtriwulan',$data4);
		
		$data5['isi5'] = $this->mpengaduantriwulan->gettriwulan5();
		$this->load->view('lwtriwulan',$data5);
		
		$data6['isi6'] = $this->mpengaduantriwulan->gettriwulan6();
		$this->load->view('lwtriwulan',$data6);
        
		$data7['isi7'] = $this->mpengaduantriwulan->gettriwulan7();
		$this->load->view('lwtriwulan',$data7);
		
		$data8['isi8'] = $this->mpengaduantriwulan->gettriwulan8();
		$this->load->view('lwtriwulan',$data8);
		
		
		
        $this->session_info['page_name'] = "Pengaduan Pertriwulan";
        $this->template->build('lwtriwulan', $this->session_info);
    }public function triwulan2() {
		
		$this->index();
		$this->load->model('mpengaduantriwulan');
		
		$data['isi'] = $this->mpengaduantriwulan->gettriwulan();
		$this->load->view('letriwulan',$data);
		
		$data2['isi2'] = $this->mpengaduantriwulan->gettriwulan2();
		$this->load->view('letriwulan',$data2);
        
		$data3['isi3'] = $this->mpengaduantriwulan->gettriwulan3();
		$this->load->view('letriwulan',$data3);
		
		$data4['isi4'] = $this->mpengaduantriwulan->gettriwulan4();
		$this->load->view('letriwulan',$data4);
		
		$data5['isi5'] = $this->mpengaduantriwulan->gettriwulan5();
		$this->load->view('letriwulan',$data5);
		
		$data6['isi6'] = $this->mpengaduantriwulan->gettriwulan6();
		$this->load->view('letriwulan',$data6);
        
		$data7['isi7'] = $this->mpengaduantriwulan->gettriwulan7();
		$this->load->view('letriwulan',$data7);
		
		$data8['isi8'] = $this->mpengaduantriwulan->gettriwulan8();
		$this->load->view('letriwulan',$data8);
		
		
		
        $this->session_info['page_name'] = "Pengaduan Pertriwulan";
        $this->template->build('letriwulan', $this->session_info);
    }
	}