<?php

/**
   * Description of Informasi Perizinan
   * @author agusnur ; Created : 08 Okt 2010
   * @edit PBS       ; Created : 22 Ags 2023
*/

class fitur_jelita extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $enabled = FALSE;
    //$list_auths = $this->session_info['app_list_auth'];
    
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
    //$data['list'] = $this->perizinan->where('c_online',0)->order_by('kd_izin', 'ASC')->get();
    //$data['list_izin'] = $this->perizinan->get_list();
    //$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Fitur-Fitur Administrasi Perkantoran DPMPTSP";
    $this->template->build('fitur_jelita', $this->session_info);
  }
}