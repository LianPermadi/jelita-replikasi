<?php
class Total extends WRC_AdminCont {

public function __construct() {
        parent::__construct();
	
    }
	function index(){

 $this->session_info['page_name'] = "Resume Evaluasi Perbulan";
        $this->template->build('list', $this->session_info);
}
 public function tampildata() {
        $tgla = $this->input->post('tgla');
        
            $data['tgla'] = $tgla;
           
        $this->load->vars($data);
      

        $this->session_info['page_name'] = "Resume Evaluasi Perbulan";
        $this->template->build('vtotal', $this->session_info);
    }
	public function lwvtotal($tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Resume Evaluasi Perbulan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
       // $d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwvtotal', $d);
    }
	public function levtotal($tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Resume Evaluasi Perbulan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('levtotal', $d);
    }
	}