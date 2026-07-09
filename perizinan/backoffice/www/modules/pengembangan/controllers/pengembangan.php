<?php
/*
 * Created By : Arif Ahmadi / 05-01-2022
 */

class Pengembangan extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();
    $this->load->model("m_pengembangan");
    $base_url = base_url();
    $enabled = FALSE;
    $this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
    // var_dump($list_auth->id_role);
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    
    // if (!$enabled) {
    //     redirect('dashboard');
    // }
  }

  public function index() { 
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('ruangan_list', $this->session_info);
  }

  public function list_aa() { 
        $enabled = TRUE;
    // if (!$enabled) {
    //     redirect('dashboard');
    // }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('permintaan_list', $this->session_info);
  }

  public function proses() { 
        $enabled = TRUE;
    // if (!$enabled) {
    //     redirect('dashboard');
    // }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('proses_list', $this->session_info);
  }

  public function selesai() { 
        $enabled = TRUE;
    // if (!$enabled) {
    //     redirect('dashboard');
    // }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('selesai_list', $this->session_info);
  }

  public function uat_list() { 
        $enabled = TRUE;
    // if (!$enabled) {
    //     redirect('dashboard');
    // }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('uat_list', $this->session_info);
  }

  public function cetak_excel(){
  $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -300));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    // $tgla = $this->lib_date->set_date($this->input->post('tgla'));
    // $tglb = $this->lib_date->set_date($this->input->post('tglb'));
    
    $pakai = $this->m_pengembangan->get_data($tgla, $tglb);
    // var_dump($pakai);die;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['pakai'] = $pakai;
    $data['title'] = 'Rekap Persuratan';
    $data['jdl_laporan'] = 'Rekap Persuratan';
    $this->load->vars($data);

 // $data = array( 
 //  'title' => 'Laporan Excel',
 //  'pakai' => $this->m_pengembangan->get_data($tgla, $tglb));
 $this->load->view('laporan_excel',$data);
 }

  public function master() { 
    $ruangan = $this->m_pengembangan->get_master();

    $data['ruangan'] = $ruangan;
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
    $this->session_info['page_name'] = "Master Ruangan";
    $this->template->build('master_list', $this->session_info);
  }

  public function add() {

    $iduser      = $this->session->userdata('id_auth');
    // var_dump($iduser);die();
    $data['iduser'] = $iduser;
    $data['pemakai'] = array();
    $data['ruangan'] = $this->m_pengembangan->get_ruangan();
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
    $this->session_info['page_name'] = "Usulan Pengembangan Sistem";
    $this->template->build('pakai_edit', $this->session_info);
  }

  public function edit($id) {
      $iduser      = $this->session->userdata('id_auth');
      $data['iduser'] = $iduser;
      $data['pakai'] = $this->m_pengembangan->get_datapakai($id);
      $data['ruangan'] = $this->m_pengembangan->get_ruangan();
      $data['step'] = "update";

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
      $this->session_info['page_name'] = "Ubah Data Booking";
      $this->template->build('pakai_edit', $this->session_info);
  }
  
  public function approve() { 
      $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    // var_dump($list_auths);die();
    if (!$enabled) {
        redirect('dashboard');
    }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
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
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('approve_list', $this->session_info);
  }

  public function approve_text($id) { 
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
    $data['id'] = $id;
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
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('approve_text', $this->session_info);
  }

  public function detail($id) { 
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
    $data['id'] = $id;
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
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('detail', $this->session_info);
  }

  public function approve_action($id) {
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $iduser      = $this->session->userdata('id_auth');
    $id_user     = $this->m_pengembangan->get_user_id($iduser);
    $status      = '1';

    $simpan = $this->m_pengembangan->approve($id, $id_user, $status);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan/approve');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di Approve");
    redirect('pengembangan/approve');
    }
  }

  public function approve_action_back($id) {
    $pesan = $this->input->post('pesan');
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $iduser      = $this->session->userdata('id_auth');
    $id_user     = $this->m_pengembangan->get_user_id($iduser);
    $status      = '4';

    $simpan = $this->m_pengembangan->approve_text($id, $id_user, $status, $pesan);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan/approve');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di Approve");
    redirect('pengembangan/approve');
    }
  }

  public function reject_text($id) { 
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));

    $ruangan = $this->m_pengembangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_pengembangan'] = $ruangan;
    $data['id'] = $id;
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
    $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->template->build('reject_text', $this->session_info);
  }

  public function reject_action($id) {
    $pesan = $this->input->post('pesan');
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $iduser      = $this->session->userdata('id_auth');
    $id_user     = $this->m_pengembangan->get_user_id($iduser);
    $status      = '404';

    $simpan = $this->m_pengembangan->approve_text($id, $id_user, $status, $pesan);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di Tolak");
    redirect('pengembangan/approve');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di Approve");
    redirect('pengembangan/approve');
    }
  }

  public function done($id) {
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $iduser      = $this->session->userdata('id_auth');
    $id_user     = $this->m_pengembangan->get_user_id($iduser);
    $status      = '2';

    $simpan = $this->m_pengembangan->approve($id, $id_user, $status);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan/approve');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di Approve");
    redirect('pengembangan/approve');
    }
  }

  public function done_fix($id) {
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '40') { 
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    if (!$enabled) {
        redirect('dashboard');
    }
    $iduser      = $this->session->userdata('id_auth');
    $id_user     = $this->m_pengembangan->get_user_id($iduser);
    $status      = '3';

    $simpan = $this->m_pengembangan->approve($id, $id_user, $status);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan/approve');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di Approve");
    redirect('pengembangan/approve');
    }
  }

  public function master_add() {
    $data['ruangan'] = array();
    $data['step'] = "master_simpan";
    
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
    $this->session_info['page_name'] = "Tambah Data Ruangan";
    $this->template->build('master_edit', $this->session_info);
  }

  public function master_ubah($id) {
    $data['ruangan'] = $this->m_pengembangan->get_datamaster($id);
    $data['step'] = "master_update";

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
    $this->session_info['page_name'] = "Ubah Data Ruangan";
    $this->template->build('master_edit', $this->session_info);
  }

  public function master_simpan() {
    $nama_ruangan = $this->input->post('nama_ruangan');
    $lantai       = $this->input->post('lantai');
    $kapasitas    = $this->input->post('kapasitas');
    $fasilitas    = $this->input->post('fasilitas');
    
    $simpan = $this->m_pengembangan->save_master($nama_ruangan, $lantai, $kapasitas, $fasilitas);

    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('ruangan/master');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('ruangan/master');
    }
  }

  public function master_update() {
    $id           = $this->input->post('id');
    $nama_ruangan = $this->input->post('nama_ruangan');
    $lantai       = $this->input->post('lantai');
    $kapasitas    = $this->input->post('kapasitas');
    $fasilitas    = $this->input->post('fasilitas');
    
    $simpan = $this->m_pengembangan->update_master($id, $nama_ruangan, $lantai, $kapasitas, $fasilitas);

    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('ruangan/master');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('ruangan/master');
    }
  }

  public function hapus_master($id) {
    $hapus = $this->m_pengembangan->hapus_master($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('ruangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('ruangan');
    }
  }

  public function simpan() {
    $iduser       = $this->session->userdata('id_auth');
    $pengajuan   = $this->input->post('pengajuan');
    $desk        = $this->input->post('desk');
    $date        = $this->input->post('date');
    $tingkat     = $this->input->post('tingkat');
    $bidang        = $this->input->post('bidang');
    $nama        = $this->input->post('nama');
    $simpan = $this->m_pengembangan->add_pengajuan($iduser, $pengajuan, $desk, $date, $tingkat, $bidang, $nama);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di ajukan");
    redirect('pengembangan/add');
    }
  }

  public function unduh_naskah($id){
    $surat = $this->m_pengembangan->get_datapakai($id);

    $kepada = $surat->acara;

    $file = "NOTDIN_".$id;
    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/ruangan/notdin/'.$file.'.pdf');
    force_download('NOTDIN_'.$kepada.'.pdf', $data);
    }

  public function hapus_notdin($id) {
    $hapus = unlink('assets/ruangan/notdin/NOTDIN_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('pengembangan/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('pengembangan/ubah/'.$id);
    }
  }


  public function update() {
    $iduser      = $this->session->userdata('id_auth');
    $id          = $this->input->post('id');
    $pengajuan   = $this->input->post('pengajuan');
    $desk        = $this->input->post('desk');
    $date        = $this->input->post('date');
    $tingkat     = $this->input->post('tingkat');
    $bidang      = $this->input->post('bidang');
    $nama        = $this->input->post('nama');

    $simpan = $this->m_pengembangan->update_pakai($iduser, $id, $pengajuan, $desk, $date, $tingkat, $bidang, $nama);
    if ($simpan) {
    $this->session->set_flashdata('sukses', "Data Berhasil Di ajukan");
    redirect('pengembangan');
    }else{
    $this->session->set_flashdata('gagal', "Data tidak Berhasil Di edit");
    redirect('pengembangan/edit');
    }
  }

  public function hapus($id) {
    $hapus = $this->m_pengembangan->hapus_pakai($id);
    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('pengembangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('pengembangan');
    }
  }

}