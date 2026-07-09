<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_autocomplete extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
      // $this->load->model("m_izintrayek");

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


//-----------------------------------------------tampil data ---------------------
 public function index()
    {
        
        $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('index', $this->session_info);
    }
}