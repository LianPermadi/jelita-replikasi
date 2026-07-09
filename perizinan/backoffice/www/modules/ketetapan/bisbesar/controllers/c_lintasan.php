<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_lintasan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        
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

      //  $data['content_view'] = 'lintasan/v_lintasan';
        $data['content_view'] = 'lintasan/add_lintasan';
        $data['lintasan_table'] = $this->create_lintasan_table();
        $data['lintasan2_table'] = $this->create_lintasan2_table();
        $this->load->vars($data);

        $js =  "

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
               
$(function(){
 
  // show popup
  $('.popup-show').click(function(e) {
   e.preventDefault();
   $('.popup').fadeIn();
    
  });
 
  // close
  $('.bg,.close').click(function(e){
   e.preventDefault();
   $('.popup').fadeOut('slow');
  });
    
 });
               ";
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<?php
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "INFORMASI LINTASAN TRAYEK ANTAR KOTA";
      //  $this->template->build('lintasan/v_lintasan', $this->session_info);
        $this->template->build('lintasan/add_lintasan', $this->session_info);
    }
     function create_lintasan_table()
    {
        $lintasan = $this->m_lintasan->get_all_lintasan();
        $lintasan_table = "";
$counter = 0;
        if(count($lintasan) > 0)
        {
            
            
            foreach ($lintasan as $key => $value)
            {
                $counter = $counter+1;
                $lintasan_table .="<tr>";
                $lintasan_table .="<td align='center'>{$counter}</td>";
                $lintasan_table .="<td>{$value->KODE_TRAYE}</td>";
                $lintasan_table .="<td>{$value->NAMA_TRAYE}</td>";
                //$lintasan_table .="<td>{$value->ALAMAT}</td>";
                //$lintasan_table .="<td>{$value->KOTA}</td>";
                //$lintasan_table .="<td align='center'>{$value->KAPASITAS}</td>";
              // $lintasan_table .="<td align='center'>{$value->JENIS}</td>";

               $lintasan_table .="<td align='center'>
                <a href='".base_url()."bisbesar/c_lintasan/edit_lintasan/{$value->KODE_TRAYE}'>Edit</a>
             <!--|
                <a href='".base_url()."bisbesar/c_lintasan/delete_lintasan/{$value->KODE_TRAYE}'>delete</a>--></td>";
                $lintasan_table .="</tr>";
            }
            return $lintasan_table;
        }
    }

    function create_lintasan2_table()
    {
        $lintasan2 = $this->m_lintasan->get_all_lintasan2();
        $lintasan2_table = "";
$counter = 0;
        if(count($lintasan2) > 0)
        {
            
            
            foreach ($lintasan2 as $key => $value)
            {
                $counter = $counter+1;
                $lintasan2_table .="<tr>";
                $lintasan2_table .="<td align='center'>{$counter}</td>";
                $lintasan2_table .="<td>{$value->NAMA_LINTA}</td>";
                $lintasan2_table .="<td>{$value->NAMA_LINT2}</td>";
                //$lintasan_table .="<td>{$value->ALAMAT}</td>";
                //$lintasan_table .="<td>{$value->KOTA}</td>";
                //$lintasan_table .="<td align='center'>{$value->KAPASITAS}</td>";
              // $lintasan_table .="<td align='center'>{$value->JENIS}</td>";

               $lintasan2_table .="<td align='center'>{$value->JARAK}
               <!-- <a href='".base_url()."bisbesar/c_lintasan/edit_lintasan/{$value->TRA_ID}'>Edit</a>-->
             <!--|
                <a href='".base_url()."bisbesar/c_lintasan/delete_lintasan/{$value->TRA_ID}'>delete</a>--></td>";
                $lintasan2_table .="</tr>";
            }
            return $lintasan2_table;
        }
    }

 
    function edit_lintasan($id)
    {
         $where = array('KODE_TRAYE' => $id);
         $where2 =array($id);
        $data['bb_lintasan'] = $this->m_lintasan->edit_data($where,'bb_traak')->result();
        $data['lintasan_table'] = $this->create_lintasan_table();
      //$data['lintasan3_table'] = $this->create_lintasan3_table();
          $data['bb_traakdet'] = $this->m_lintasan->create_traakdet($where,'bb_traak')->result();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#l').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#l2').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                
$(function(){
 
  // show popup
  $('.popup-show').click(function(e) {
   e.preventDefault();
   $('.popup').fadeIn();
    
  });
 
  // close
  $('.bg,.close').click(function(e){
   e.preventDefault();
   $('.popup').fadeOut('slow');
  });
    
 });
                ";
?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "UBAH KENDARAAN / LINTASAN";
        $this->template->build('lintasan/edit_lintasan', $this->session_info);
    }

    function addlintasan()
    {
      
        $data['lintasan_table'] = $this->create_lintasan_table();
        $data['lintasan2_table'] = $this->create_lintasan2_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#lintasan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
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
                ";

       $data['content_view'] = 'add_lintasan';
       
       $this->load->vars($data);
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH LINTASAN";
        $this->template->build('lintasan/add_lintasan', $this->session_info);
    }

    function tambah_aksi(){
   
    $TRA_ID = $this->input->post('TRA_ID');
    $KODE_TRAYE = $this->input->post('KODE_TRAYE');
    $NAMA_TRAYE = $this->input->post('NAMA_TRAYE');
    $VIA = $this->input->post('VIA');
    $JENIS = $this->input->post('JENIS');
    $KAPASITAS = $this->input->post('KAPASITAS');
    $TARIF_EKON = $this->input->post('TARIF_EKON');
    $TARIF_PATA = $this->input->post('TARIF_PATA');
    $JUMLAH_BAR = $this->input->post('JUMLAH_BAR');
    $KETERANGAN = $this->input->post('KETERANGAN');
    

    $data = array(
            'TRA_ID' => $TRA_ID,
            'KODE_TRAYE' => $KODE_TRAYE,
            'NAMA_TRAYE' => $NAMA_TRAYE,
            'VIA' => $VIA,
            'JENIS' => $JENIS,
            'KAPASITAS' => $KAPASITAS,
            'TARIF_EKON' => $TARIF_EKON,
            'TARIF_PATA' => $TARIF_PATA,
            'JUMLAH_BAR' => $JUMLAH_BAR,
            'KETERANGAN' => $KETERANGAN
            );
     $result=$this->m_lintasan->input_data($data,'bb_traak');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
    }
     function update_aksi(){

        $TRA_ID = $this->input->post('TRA_ID');
        $KODE_TRAYE = $this->input->post('KODE_TRAYE');
        $NAMA_TRAYE = $this->input->post('NAMA_TRAYE');
        $VIA = $this->input->post('VIA');
        $JENIS = $this->input->post('JENIS');
        $KAPASITAS  = $this->input->post('KAPASITAS');
        $TARIF_EKON  = $this->input->post('TARIF_EKON');
        $TARIF_PATA  = $this->input->post('TARIF_PATA');
        $JUMLAH_BAR  = $this->input->post('JUMLAH_BAR');
        $KETERANGAN  = $this->input->post('KETERANGAN');
     
        $data = array(
            'KODE_TRAYE' => $KODE_TRAYE,
            'NAMA_TRAYE' => $NAMA_TRAYE,
            'NAMA_TRAYE' => $NAMA_TRAYE,
            'VIA' => $VIA,
            'JENIS ' => $JENIS,
            'KAPASITAS ' => $KAPASITAS,
            'TARIF_EKON ' => $TARIF_EKON,
            'TARIF_PATA ' => $TARIF_PATA,
            'JUMLAH_BAR ' => $JUMLAH_BAR,
            'KETERANGAN ' => $KETERANGAN    
        );
     
        $where = array(
            'TRA_ID' => $TRA_ID
        );
     
        $result = $this->m_lintasan->update_data($where,$data,'bb_traak');
        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
       // redirect('crud/index');
}

}