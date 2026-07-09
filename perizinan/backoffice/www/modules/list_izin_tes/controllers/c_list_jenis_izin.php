<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_list_jenis_izin extends Controller {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_jenis_perizinan");

            /*$enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }*/
    }


//-----------------------------------------------tampil data ---------------------
    public function index() {

        $data['content_view'] = 'v_jenis_perizinan';
        $data['jenis_perizinan_table'] = $this->create_jenis_perizinan_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#jenis_perizinan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "DATA INDUK jenis_perizinan";
        $this->template->build('v_jenis_perizinan', $this->session_info);
    }
    function create_jenis_perizinan_table()
    {
        $jenis_perizinan = $this->m_jenis_perizinan->get_all_jenis_perizinan();
        $jenis_perizinan_table = "";
$counter = 0;
        if(count($jenis_perizinan) > 0)
        {
            
            
            foreach ($jenis_perizinan as $key => $value)
            {
                $counter = $counter+1;
                $jenis_perizinan_table .="<tr>";
                $jenis_perizinan_table .="<td align='center'>{$counter}</td>";
               
                $jenis_perizinan_table .="<td align='center'>{$value->n_perizinan}</td>";
                $jenis_perizinan_table .="<td align='center'>{$value->v_hari}</td>";

               $jenis_perizinan_table .="<td align='center'>
                <a href='".base_url()."bisbesar/c_jenis_perizinan/edit_jenis_perizinan/{$value->kd_izin}'>Edit</a>
             <!--|
                <a href='".base_url()."bisbesar/c_jenis_perizinan/delete_jenis_perizinan/{$value->kd_izin}'>delete</a>--></td>";
                $jenis_perizinan_table .="</tr>";
            }
            return $jenis_perizinan_table;
        }
    }

    //--------------------------------------------edit data

    function edit_jenis_perizinan($id){
        $where = array('NO_MOBIL' => $id);
        $data['bb_jenis_perizinan'] = $this->m_jenis_perizinan->edit_data($where,'bb_mobil')->result();
        $data['jenis_perizinan_table'] = $this->create_jenis_perizinan_table();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#jenis_perizinan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "UBAH jenis_perizinan / LINTASAN";
        $this->template->build('jenis_perizinan/edit_jenis_perizinan', $this->session_info);
    }
   //-----------------end edit data
}