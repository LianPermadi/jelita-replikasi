<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends WRC_AdminCont {
	
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','download'));


            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }				
	}

	public function index(){		
		 $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('tes/v_download', $this->session_info);
	}

	public function lakukan_download(){				
		force_download('tes/gambar.png',NULL);
	}	

}