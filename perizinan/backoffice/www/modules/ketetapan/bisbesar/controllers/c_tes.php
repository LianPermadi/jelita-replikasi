<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_tes extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','download'));

       $this->load->model("m_lintasan");

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
    public function index() {

      //$data['content_view'] = 'lintasan/v_lintasan';
        $data['content_view'] = 'tes/auto_cek';
        $this->load->vars($data);

      /*  $js =  "

                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#lintasan2').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#lintasan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
               "*/

?>
<?php
     //   $this->template->set_metadata_javascript($js);
     //  $this->session_info['page_name'] = "Auto Check";
      //  $this->template->build('lintasan/v_lintasan', $this->session_info);
        $this->load->view('tes/index.html', $this->session_info);
    }


public function index2(){        
         $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('tes/v_download', $this->session_info);
    }

    public function lakukan_download(){             
        force_download('tes/tes.txt',NULL);
    }   

    public function qrcode() {

       
        $this->load->view('tes/qrcode.php', $this->session_info);

    }
}