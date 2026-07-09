<?php
class Total extends WRC_AdminCont {

public function __construct() {
        parent::__construct();
	
    }
	function index(){

 $this->session_info['page_name'] = "Total";
        $this->template->build('list', $this->session_info);
}
 public function tampildata() {
        $tgla = $this->input->post('tgla');
        
            $data['tgla'] = $tgla;
           
        $this->load->vars($data);
      

        $this->session_info['page_name'] = "Total";
        $this->template->build('vtotal', $this->session_info);
    }
	}