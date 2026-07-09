<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_terminal extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_terminal");

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

        //$data['content_view'] = 'terminal/v_terminal';
        $data['content_view'] = 'terminal/add_terminal';
        $data['terminal_table'] = $this->create_terminal_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#terminal').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "INFORMASI TERMINAL / LINTASAN";
       // $this->template->build('terminal/v_terminal', $this->session_info);
        $this->template->build('terminal/add_terminal', $this->session_info);
    }
     function create_terminal_table()
    {
        $terminal = $this->m_terminal->get_all_terminal();
        $terminal_table = "";
$counter = 0;
        if(count($terminal) > 0)
        {
            
            
            foreach ($terminal as $key => $value)
            {
                $counter = $counter+1;
                $terminal_table .="<tr>";
                $terminal_table .="<td align='center'>{$counter}</td>";
                //$terminal_table .="<td>{$value->TERMINAL_I}</td>";
                $terminal_table .="<td>{$value->NAMA_TERMI}</td>";
                //$terminal_table .="<td>{$value->ALAMAT}</td>";
                //$terminal_table .="<td>{$value->KOTA}</td>";
                $terminal_table .="<td align='center'>{$value->KAPASITAS}</td>";
                $terminal_table .="<td align='center'>{$value->JENIS}</td>";

               $terminal_table .="<td align='center'>
                <a href='".base_url()."bisbesar/c_terminal/edit_terminal/{$value->TERMINAL_I}'>Edit</a>
             <!--|
                <a href='".base_url()."bisbesar/c_terminal/delete_terminal/{$value->TERMINAL_I}'>delete</a>--></td>";
                $terminal_table .="</tr>";
            }
            return $terminal_table;
        }
    }

    //-----------------------------------------------akhir tampil data ---------------------
    //-----------------------------------------------tambah data ---------------------
function addTerminal()
    {
        $data['kodya'] = $this->create_kodya_select();
        $data['terminal_table'] = $this->create_terminal_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#terminal').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

       $data['content_view'] = 'add_terminal';
       
       $this->load->vars($data);
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH TERMINAL";
        $this->template->build('terminal/add_terminal', $this->session_info);
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
function tambah_aksi(){
   
    $TERMINAL_I = $this->input->post('TERMINAL_I');
    $NAMA_TERMI = $this->input->post('NAMA_TERMI');
    $ALAMAT = $this->input->post('ALAMAT');
    $KODYA_ID = $this->input->post('KODYA_ID');
    $KAPASITAS = $this->input->post('KAPASITAS');
    $JENIS = $this->input->post('JENIS');
    

    $data = array(
            'TERMINAL_I' => $TERMINAL_I,
            'NAMA_TERMI' => $NAMA_TERMI,
            'ALAMAT' => $ALAMAT,
            'KODYA_ID' => $KODYA_ID,
            'KAPASITAS' => $KAPASITAS,
            'JENIS' => $JENIS
            );
     $result=$this->m_terminal->input_data($data,'bb_terminal');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
    }

    //-----------------------------------------------akhir tambah data ---------------------

    //---------------------------awal edit data
    function edit_terminal($id){
        $where = array('TERMINAL_I' => $id);
        $data['bb_terminal'] = $this->m_terminal->edit_data($where,'bb_terminal')->result();
        $data['terminal_table'] = $this->create_terminal_table();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#terminal').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "UBAH TERMINAL / LINTASAN";
        $this->template->build('terminal/v_edit_terminal', $this->session_info);
    }
    function update_aksi(){

        $TERMINAL_I = $this->input->post('TERMINAL_I');
        $NAMA_TERMI = $this->input->post('NAMA_TERMI');
        $ALAMAT = $this->input->post('ALAMAT');
        $KODYA_ID = $this->input->post('KODYA_ID');
        $KAPASITAS = $this->input->post('KAPASITAS');
        $JENIS  = $this->input->post('JENIS');
     
        $data = array(
            'NAMA_TERMI' => $NAMA_TERMI,
            'ALAMAT' => $ALAMAT,
            'KODYA_ID' => $KODYA_ID,
            'KAPASITAS' => $KAPASITAS,
            'JENIS ' => $JENIS    
        );
     
        $where = array(
            'TERMINAL_I' => $TERMINAL_I
        );
     
        $result = $this->m_terminal->update_data($where,$data,'bb_terminal');
        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
       // redirect('crud/index');
}
    //--------------------------akhir edit data
}