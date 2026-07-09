<?php
/*
 * Created By : Arif Ahmadi / 01-02-2023
 */

class Permintaanbarang extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();
    // $this->load->model("m_permintaan");
    $this->load->model("m_barang");
    $base_url = base_url();
    // $this->penglola_barang = FALSE;
    $enabled = FALSE;
    $this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '45') {
         $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
      if ($list_auth->id_role === '33') {
        $this->Penomoran_surat = TRUE;
      }
    }
    
    if (!$enabled) {
        redirect('dashboard');
    }
  }

  public function barang_index() { 
      $barang = $this->m_barang->get_data();
      $logbarang = $this->m_barang->get_data_master();

      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });

            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_index', $this->session_info);
    }

  public function barang() { 
      // $list_auths = $this->session_info['app_list_auth'];
      $barang = $this->m_barang->get_data();
      $logbarang = $this->m_barang->get_data_master();
      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
      $data['penglola_barang'] = $this->penglola_barang;
      $this->load->vars($data);

    
    // foreach ($list_auths as $list_auth) {
    //   if($list_auth->id_role == '45') {
    //     $data['role']   = '45';
    //   }else{
    //     $data['role'] = '10';
    //   }
    // }

    // var_dump($data['role']);die();

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });

            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_list', $this->session_info);
    }

    public function addbarang(){
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['barang'] = array();
      $data['step'] = "simpan";

      $js =  "
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Tambah Data Barang";
      $this->template->build('barang_add', $this->session_info);
    }

    public function simpan(){
      $id_user      = $this->input->post('id_user');
      $nama_user      = $this->input->post('nama');
      $barang       = $this->input->post('nama_barang');
      $jumlah       = $this->input->post('jumlah');
      $satuan       = $this->input->post('satuan');
      $merk         = $this->input->post('merk');
      $simpan       = $this->input->post('rak');
      $date         = $this->input->post('date');

      // var_dump($id_user);die();

      $simpan = $this->m_barang->save_data($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan);
      $log = $this->m_barang->save_log($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan, $nama_user);
      redirect('/permintaanbarang/barang');
    }

    public function pinjam($id){
      $data['barang'] = $this->m_barang->get_barang_id($id);
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['step'] = "order";

      $js =  "
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Pinjam";
      $this->template->build('barang_pinjam', $this->session_info);
    }

    public function order(){
      $id_user      = $this->session->userdata('id_auth');
      $id           = $this->input->post('id');
      $jumlah       = $this->input->post('jumlah');
      $saatini      = $this->input->post('saatini');
      $hasil        = $saatini - $jumlah;
      // var_dump($hasil);die();
      if($jumlah > $saatini){
      $data['salah'] = "Stok tidak cukup turunkan Jumlah barang";
      $this->load->vars($data);
      redirect('/permintaanbarang/pinjam/'.$id);
      }else{
      $simpan = $this->m_barang->save_order($id_user, $id, $jumlah ,$hasil);
      redirect('/permintaanbarang/barang');
      }
    }

    public function checkout() { 
      $barang       = $this->m_barang->get_checkout();
      $permintaan   = $this->m_barang->get_permintaan();
      $id_user      = $this->session->userdata('id_auth');
      $pemberi      = $this->m_barang->get_pegawai_user($id_user);

      $data['user'] = $this->m_barang->get_user();
      $data['pemberi'] = $pemberi;
      $data['id_user']  = $id_user;
      $data['permintaan'] = $permintaan;
      $data['barang']   = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });


            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Checkout";
      $this->template->build('checkout_list', $this->session_info);
    }

    public function accept(){
      $barang       = $this->input->post('nama_barang');
      $id_user      = $this->session->userdata('id_auth');
      $pemberi      = $this->input->post('pemberi');
      $penerima     = $this->input->post('penerima');
      $status       = '1';
      // var_dump($pemberi);die();

      $simpan = $this->m_barang->save_checkout($pemberi, $barang, $penerima, $status);
      redirect('/permintaanbarang');
    }

    public function index() { 
      $barang = $this->m_barang->get_data_master();

      $data['barang'] = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "LOG Barang ";
      $this->template->build('barang_master_list', $this->session_info);
    }

    public function hapus_checkout($id, $jumlah, $id_barang){
      $awal        = $this->m_barang->get_barang_id($id);
      $jumlah_awal = $this->m_barang->get_jumlah_awal($id_barang);
      $hasil = $jumlah_awal + $jumlah;
      // var_dump($hasil);die();

      $simpan       = $this->m_barang->hapus_checkout($id, $id_barang, $hasil);
      redirect('/permintaanbarang/barang');
    }

    public function activity(){
      $barang = $this->m_barang->get_log();

      $data['barang'] = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "LOG Activity";
      $this->template->build('barang_log', $this->session_info);
    }


// 20 feb 2023
    public function tambah($id){
      $barang = $this->m_barang->get_barang_id($id);
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['barang'] = $barang;
      $data['step'] = 'stok';
      $js =  "
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Tambah Data Barang";
      $this->template->build('tambah_stok', $this->session_info);
    }
    public function stok(){
      $id             = $this->input->post('id');
      $id_user      = $this->session->userdata('id_auth');
      $jumlah1        = $this->input->post('jumlahawal');
      $jumlah2        = $this->input->post('jumlahmasuk');
      $penginput      = $this->input->post('nama');
      $barang         = $this->input->post('barang');
      $merk           = $this->input->post('merk');
      $date           = date('Y-m-d G:i:s');
      var_dump($date);die();


      $text           = 'telah menambah barang dengan jumlah : <b>'.$jumlah2.'</b><br>Penginput Barang : <b>'.$penginput.'<b>';
      // var_dump($penginput);die();
      $hasil = $jumlah1 + $jumlah2;
      $this->m_barang->get_update_barang($id, $hasil, $text, $jumlah2, $barang, $merk, $penginput, $date);

      redirect('/permintaanbarang/barang');
    }

    public function pengajuan() {

    $enabled = FALSE;
    $this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '45') {
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
      if ($list_auth->id_role === '33') {
        $this->Penomoran_surat = TRUE;
      }
    }
    
    if (!$enabled) {
        redirect('dashboard');
    }

      $barang = $this->m_barang->get_data_pengajuan();
      $logbarang = $this->m_barang->get_data_user_master();

      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });

            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_list_user', $this->session_info);
    }

    public function pengajuan_barang(){
      $barang = $this->m_barang->get_data();
      $logbarang = $this->m_barang->get_data_master();
      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });

            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_list_pengajuan_user', $this->session_info);
    }


}
