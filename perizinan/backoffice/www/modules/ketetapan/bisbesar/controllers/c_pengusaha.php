<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_pengusaha extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_pengusaha");

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

    public function index() {
        $data['kodya'] = $this->create_kodya_select();
        //$data['content_view'] = 'list';
        $data['content_view'] = 'pengusaha/add_pengusaha';
        $data['pau_table'] = $this->create_pau_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#perizinan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "INFORMASI PENGUSAHA ANGKUTAN";
       // $this->template->build('list', $this->session_info);
        $this->template->build('pengusaha/add_pengusaha', $this->session_info);
    }

    function create_pau_table()
    {
        $pau = $this->m_pengusaha->get_all_pau();
        $pau_table = "";
$counter = 0;
        if(count($pau) > 0)
        {
            
            
            foreach ($pau as $key => $value)
            {
                $counter = $counter+1;
                $pau_table .="<tr>";
                $pau_table .="<td>{$counter}</td>";
                $pau_table .="<td>{$value->NO_IP}</td>";
                $pau_table .="<td>{$value->NAMA_PERUS}</td>";
                $pau_table .="<td>{$value->NAMA_PEMIL}</td>";
                $pau_table .="<td>{$value->ALAMAT_PER}</td>";
                $pau_table .="<td>{$value->TELPON_PER}</td>";
                

               $pau_table .="<td width=15%;>
                 <a href='".base_url()."bisbesar/c_pengusaha/daftar_kendaraan/{$value->NO_IP}'>View Kendaraan</a> |
                 <a href='".base_url()."bisbesar/c_pengusaha/rekap_trayek_pengusaha/{$value->NO_IP}'>Trayek</a> |  
                <a href='".base_url()."bisbesar/c_pengusaha/edit_pengusaha/{$value->NO_IP}'>Edit</a>
                <!--|
                <a href='".base_url()."delete_pengusaha/{$value->PAU_ID}'>delete</a>--></td>";
                $pau_table .="</tr>";
            }
            return $pau_table;
        }
    }
 function edit_pengusaha($id){
        $where = array('NO_IP' => $id);
        $data['bb_pau'] = $this->m_pengusaha->edit_data($where,'bb_pau')->result();
        $data['pau_table'] = $this->create_pau_table();
        $data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#pau').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "UBAH INFORMASI PENGUSAHA ANGKUTAN";
        $this->template->build('pengusaha/edit_pengusaha', $this->session_info);
    }

     function daftar_kendaraan($id){
        $where = array('NO_IP' => $id);
        $where2 = $id;
        $data['bb_pau'] = $this->m_pengusaha->edit_data($where,'bb_pau')->result();
        $data['kendaraan'] = $this->m_pengusaha->daftar_kendaraan($where,'bb_kp')->result();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#daftar_kendaraan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "DAFTAR KENDARAAN";
        $this->template->build('pengusaha/v_daftar_kendaraan', $this->session_info);
    }


 function rekap_trayek_pengusaha($id){
        $where = array('NO_IP' => $id);
        $where2 = $id;
        //$data['bb_pau'] = $this->m_pengusaha->edit_data($where,'bb_pau')->result();
        $data['rekap'] = $this->m_pengusaha->rekap_trayek_pengusaha($where,'bb_kp')->result();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#daftar_kendaraan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "REKAPITULASI TRAYEK PER PENGUSAHA ANGKUTAN";
        $this->template->build('pengusaha/v_rekap_trayek_pengusaha', $this->session_info);
    }
//-------------------------tambah pengusaha
function addPengusaha()
    {
        $data['kodya'] = $this->create_kodya_select();
        $data['pau_table'] = $this->create_pau_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#perizinan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
       $data['content_view'] = 'add_pengusaha';
       
       $this->load->vars($data);
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH PENGUSAHA";
        $this->template->build('add_pengusaha', $this->session_info);
    }

function create_kodya_select()
    {
        $this->load->model('m_pengusaha');

        $kodya = $this->m_pengusaha->get_active_kodya();
        $option = "";
        if(count($kodya)){
            foreach($kodya as $key => $value){
                $option .="<option value = '{$value->KODYA_ID}'>{$value->NAMA_KODYA}</option>";
            }
        }
        return $option;
    }


  /*  function post_pengusaha()
    {
        
          $this->m_pengusaha->post_pengusaha();
            redirect(base_url() . 'Admin/books');
        
    }
*/


//-------------------------- akhir tambah pengusaha
function tambah_aksi(){
   
    $PAU_ID = $this->input->post('PAU_ID');
    $NAMA_PERUS = $this->input->post('NAMA_PERUS');
    $NAMA_PEMIL = $this->input->post('NAMA_PEMIL');
    $ALAMAT_PER = $this->input->post('ALAMAT_PER');
    $TELPON_PER = $this->input->post('TELPON_PER');
    $KODYA_ID_P = $this->input->post('KODYA_ID_P');
    $ALAMAT_PEM = $this->input->post('ALAMAT_PEM');
    $TELPON_PEM = $this->input->post('TELPON_PEM');
    $KODYA_ID_2 = $this->input->post('KODYA_ID_2');
    $NO_IP = $this->input->post('NO_IP');
    $BARU_26 = $this->input->post('BARU_26');
    $BARU26_ = $this->input->post('BARU26_');
    $PRPJ_26 = $this->input->post('PRPJ_26');
    $PRPJ26_ = $this->input->post('PRPJ26_');
    $PRMJ_26 = $this->input->post('PRMJ_26');
    $PRMJ26_ = $this->input->post('PRMJ26_');
    $PPTRA_26 = $this->input->post('PPTRA_26');
    $PPTRA26_ = $this->input->post('PPTRA26_');
    $DUPLIKAT_2 = $this->input->post('DUPLIKAT_2');
    $DUPLIKAT26 = $this->input->post('DUPLIKAT26');
    $PIJIN_26 = $this->input->post('PIJIN_26');
    $PIJIN26_ = $this->input->post('PIJIN26_');
    $RUBAHTRA_2 = $this->input->post('RUBAHTRA_2');
    $RUBAHTRA26 = $this->input->post('RUBAHTRA26');
    $TPOSISI_26 = $this->input->post('TPOSISI_26');
    $TPOSISI26_ = $this->input->post('TPOSISI26_');
    $RUBAHDWP_2 = $this->input->post('RUBAHDWP_2');
    $RUBAHDWP26 = $this->input->post('RUBAHDWP26');
    $BBN_26 = $this->input->post('BBN_26');
    $BBN26_ = $this->input->post('BBN26_');

    $data = array(
            'PAU_ID' => $PAU_ID,
            'NAMA_PERUS' => $NAMA_PERUS,
            'NAMA_PEMIL' => $NAMA_PEMIL,
            'ALAMAT_PER' => $ALAMAT_PER,
            'TELPON_PER' => $TELPON_PER,
            'KODYA_ID_P' => $KODYA_ID_P,
            'ALAMAT_PEM' => $ALAMAT_PEM,
            'TELPON_PEM' => $TELPON_PEM,
            'KODYA_ID_2' => $KODYA_ID_2,
            'NO_IP' => $NO_IP,
            'BARU_26' => $BARU_26,
            'BARU26_' => $BARU26_,
            'PRPJ_26' => $PRPJ_26,
            'PRPJ26_' => $PRPJ26_,
            'PRMJ_26' => $PRMJ_26,
            'PRMJ26_' => $PRMJ26_,
            'PPTRA_26' => $PPTRA_26,
            'PPTRA26_' => $PPTRA26_,
            'DUPLIKAT_2' => $DUPLIKAT_2,
            'DUPLIKAT26' => $DUPLIKAT26,
            'PIJIN_26' => $PIJIN_26,
            'PIJIN26_' => $PIJIN26_,
            'RUBAHTRA_2' => $RUBAHTRA_2,
            'RUBAHTRA26' => $RUBAHTRA26,
            'TPOSISI_26' => $TPOSISI_26,
            'TPOSISI26_' => $TPOSISI26_,
            'RUBAHDWP_2' => $RUBAHDWP_2,
            'RUBAHDWP26' => $RUBAHDWP26,
            'BBN_26' => $BBN_26,
            'BBN26_' => $BBN26_


            );
     $result=$this->m_pengusaha->input_data($data,'bb_pau');


       /* $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $pekerjaan = $this->input->post('pekerjaan');
 
        $data = array(
            'nama' => $nama,
            'alamat' => $alamat,
            'pekerjaan' => $pekerjaan
            );
        $this->m_pengusaha->input_data($data,'user_tes');*/
        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
        //redirect('bisbesar/c_pengusaha/addPengusaha');
          $this->template->build('pengusaha/add_pengusaha', $this->session_info);
    }

 function update_aksi(){

        $NO_IP = $this->input->post('NO_IP');
        $NAMA_PERUS = $this->input->post('NAMA_PERUS');
        $NAMA_PEMIL = $this->input->post('NAMA_PEMIL');
        $ALAMAT_PER = $this->input->post('ALAMAT_PER');
        $TELPON_PER = $this->input->post('TELPON_PER');
        $ALAMAT_PEM  = $this->input->post('ALAMAT_PEM');
        $TELPON_PEM  = $this->input->post('TELPON_PEM');
        $KODYA_ID_P  = $this->input->post('KODYA_ID_P');
           
        $data = array(
            'NAMA_PERUS' => $NAMA_PERUS,
            'NAMA_PEMIL' => $NAMA_PEMIL,
            'ALAMAT_PER' => $ALAMAT_PER,
            'TELPON_PER' => $TELPON_PER,
            'ALAMAT_PEM' => $ALAMAT_PEM,
            'TELPON_PEM' => $TELPON_PEM,
            'KODYA_ID_P ' => $KODYA_ID_P    
        );
     
        $where = array(
            'NO_IP' => $NO_IP
        );
     
        $result = $this->m_pengusaha->update_data($where,$data,'bb_pau');
        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
       // $this->index();
      // redirect('bisbesar/c_pengusaha');

      $this->template->build('pengusaha/add_pengusaha', $this->session_info);
}
}