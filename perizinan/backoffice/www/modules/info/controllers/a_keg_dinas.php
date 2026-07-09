<?php

/**
   * Description of Informasi Perizinan
   * @author agusnur ; Created : 08 Okt 2010
   * @edit PBS       ; Created : 08 Apr 2015
*/

class a_keg_dinas extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $enabled = FALSE;
    // $list_auths = $this->session_info['app_list_auth'];
    
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
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Kalender Kegiatan";
    $this->template->build('a_keg_dinas', $this->session_info);
  }
}