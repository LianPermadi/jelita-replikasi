<?php
/*
 * Created By : DPMPTSP / 01-02-2023
 */

class Peminjamanmobil extends WRC_AdminCont
{
    public function __construct(){
        parent::__construct();
        // $this->load->model("m_permintaan");
        $this->load->model("m_mobil");
        $this->load->model('m_approve_surat');
        $this->load->model('m_persuratan');
        $this->load->library('upload');
        $base_url = base_url();
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->admin = FALSE;
        $this->peminjamanmobil = FALSE;
        $this->pengelolalaptop = FALSE;
        foreach ($list_auths as $list_auth) {
        	if($list_auth->id_role === '18') {  // Admin
            $this->admin = TRUE;
          }
          if($list_auth->id_role === '18') {
            $this->peminjamanmobil = TRUE;
            $this->All = TRUE;
          }
          if($list_auth->id_role === '59') {
            $this->pengelolalaptop = TRUE;
            $this->All = TRUE;
          }
        }
    }

    public function index()
    {
        if(!empty($this->input->post('tgla'))){
          $date = $this->input->post('tgla');
        }else{
          $date = date('Y-m-d');
        }
        $data['page'] = '11';
        $mobil = $this->m_mobil->get_data(); 
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_peminjaman_mobil($idpegawai);
        $data['date'] = $date;
        $data['mobil'] = $mobil;
        $data['peminjamanmobil'] = $peminjamanmobil;
        $data['langkah'] = 0;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('mobil', $this->session_info);
    }

    public function peminjaman_laptop(){
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -40));
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 20));
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    	if(!$this->admin){
    		IF(!$this->pengelolalaptop){
    	    echo 'Maaf Modul Peminjaman Laptop dalam Proses QC dan Pengembangan (digieTeam), klick Back'; die();
    	  }  
    	}
      if(!empty($this->input->post('tgla'))){
        $date = $this->input->post('tgla');
      }else{
        $date = date('Y-m-d');
      }
        $data['page'] = '11';
        $mobil = $this->m_mobil->get_data('laptop');
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_peminjaman_mobil($idpegawai);
        $data['date'] = $date;
        $data['mobil'] = $mobil;
        $data['peminjamanmobil'] = $peminjamanmobil; 
        $data['langkah'] = 0;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Laptop";
        $this->template->build('laptop', $this->session_info);
    }

    public function pengawas1()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '50') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->pengawas();

      $data['id_user'] = $id_user;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['mobil'] = $mobil;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('pengawas', $this->session_info);
    }

    public function pengawas_mobil()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '50') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->peminjamanmobil = TRUE;
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->pengawas();

      $data['id_user'] = $id_user;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['mobil'] = $mobil;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('pengawas1', $this->session_info);
    }

    public function history_pengawas()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '50') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
                $this->peminjamanmobil = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->pengawas_mobil();

      $data['id_user'] = $id_user;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['mobil'] = $mobil;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('history_pengawas', $this->session_info);
    }

    public function keluar($id, $id_peminjam)
    {
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->pengawas();

      $data['id_user'] = $id_user;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['id'] = $id;
      $data['mobil'] = $mobil;
      $data['id_peminjam'] = $id_peminjam;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('pergi', $this->session_info);
    }

    public function infokeberangkatan($id)
    {
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->get_id_pengawas($id);

      $data['id_user'] = $id_user;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['id'] = $id;
      $data['mobil'] = $mobil;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('info', $this->session_info);
    }

    public function mobilkeluar($id)
    {    
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $penumpang = $this->input->post('jumlah_penumpang_1');
        $tujuan = $this->input->post('tujuan');
        $keterangan_berangkat = $this->input->post('keterangan_berangkat');   
        $fuel = $this->input->post('fuel');  
        $catatan_berangkat = $this->input->post('catatan_berangkat');  
        $kondisi = $this->input->post('kondisi');  
        $catatan_kondisi = $this->input->post('catatan_kondisi');  
        $kelengkapan = $this->input->post('kelengkapan');  
        $id_peminjam = $this->input->post('id_peminjam');  
        $catatan_kelengkapan = $this->input->post('catatan_kelengkapan');  
        $file = $_FILES["foto1"]["name"];
        $text = $file;
        // Menghilangkan spasi dengan mengganti spasi dengan string kosong
        $text_without_spaces = str_replace(' ', '', $text);
        // echo $text_without_spaces;
        $first = 'awal_'.date('YmdGis');
        $upload = move_uploaded_file($_FILES['foto1']['tmp_name'], $root.'/'.$routees.'www/modules/peminjamanmobil/assets/img/gambar_bensin/' . $first . $text_without_spaces);
        $file = $first.$text_without_spaces;
        $myArray = $penumpang;
        $myString = implode('^', $myArray);
        $mobil_indit = $this->m_mobil->geus_indit($id, $myString, $tujuan, $keterangan_berangkat, $file, $fuel, $catatan_berangkat, $kondisi, $catatan_kondisi, $kelengkapan, $catatan_kelengkapan, $id_peminjam);
        $this->m_mobil->get_mobilkeluar($id, $mobil_indit);
        $this->session->set_flashdata('sukses', "Mobil Berhasil Di Pinjam");
        redirect('/peminjamanmobil/pengawas_mobil');
    }

    public function mobil_kembali($id, $id_pengawas, $id_peminjam)
    {
      $id_user = $this->session->userdata('id_auth');
      $mobil = $this->m_mobil->pengawas();

      $data['id_user'] = $id_user;
      $data['id_pengawas'] = $id_pengawas;
      $data['id_peminjam'] = $id_peminjam;
      $data['langkah'] = 1;
      $data['page'] = 4;
      $data['id'] = $id;
      $data['mobil'] = $mobil;
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
      $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
      $this->template->build('pergi_kembali', $this->session_info);

    }

    public function mobil_kembali_proses($id, $id_pengawas)
    {
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        // $id_pengawas = $this->session->userdata('id_auth');
        $fuel = $this->input->post('fuel');  
        $keterangan_berangkat = $this->input->post('keterangan_berangkat');   
        $catatan_berangkat = $this->input->post('catatan_berangkat');  
        $kondisi = $this->input->post('kondisi');  
        $catatan_kondisi = $this->input->post('catatan_kondisi');  
        $kelengkapan = $this->input->post('kelengkapan');  
        $catatan_kelengkapan = $this->input->post('catatan_kelengkapan');
        $id_peminjam = $this->input->post('id_peminjam');
        $file = $_FILES["foto1"]["name"];
        $text = $file;
        if($catatan_kondisi == '' || $catatan_kondisi == NULL){
          $catatan_kondisi = '-';
        }
        if($catatan_kelengkapan == '' || $catatan_kelengkapan == NULL){
          $catatan_kelengkapan = '-';
        }
        // Menghilangkan spasi dengan mengganti spasi dengan string kosong
        $text_without_spaces = str_replace(' ', '', $text);
        // echo $text_without_spaces;
        $first = 'awal_'.date('YmdGis');
        $upload = move_uploaded_file($_FILES['foto1']['tmp_name'], $root.'/'.$routees.'www/modules/peminjamanmobil/assets/img/gambar_bensin/' . $first . $text_without_spaces);
        if($upload){
          $foto_bensin = $first . $text_without_spaces;
          $simpan = $this->m_mobil->get_mobil_kembali($id, $id_pengawas, $fuel,$keterangan_berangkat,$catatan_berangkat, $kondisi, $catatan_kondisi, $kelengkapan, $catatan_kelengkapan, $foto_bensin);
            if($simpan){
              $status = "3";
              $kembali = $this->m_mobil->kembali_mobil($id_peminjam, $status);
              if($kembali){
              $this->session->set_flashdata('sukses', "Mobil Berhasil Di Kembalikan");
              }
            }else{
              $this->session->set_flashdata('gagal', "Mobil Gagal Di Kembalikan");
            }
        }else{
          $this->session->set_flashdata('gagal', "Upload File Gagal");
        }
          redirect('/peminjamanmobil/pengawas_mobil');
    }

    public function jadwal()
    {
        if(!empty($this->input->post('tgla'))){
          $date = $this->input->post('tgla');
        }else{
          $date = date('Y-m-d');
        }
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
        $mobil = $this->m_mobil->get_data(); 
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_peminjaman_mobil($idpegawai);
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['date'] = $date;
        $data['mobil'] = $mobil;
        $data['peminjamanmobil'] = $peminjamanmobil;
        $data['langkah'] = '6';
        $data['page'] = '7';
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('mobil', $this->session_info);
    }

    public function search()
    {
        $tgla = $this->input->post('tgla');
        $mobil = $this->m_mobil->get_data(); 
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_peminjaman_mobil($idpegawai);
        $data['mobil'] = $mobil;
        $data['date'] = $tgla;
        $data['peminjamanmobil'] = $peminjamanmobil;
        $data['langkah'] = 0;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('mobil', $this->session_info);
    }

    public function detail_mobil($id)
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -90));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 90));

        $mobil = $this->m_mobil->get_data(); 
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_list_peminjaman($id, $tgla, $tglb);
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['id'] = $id;
        $data['page'] = '10';
        $data['peminjamanmobil'] = $mobil;
        $data['mobil'] = $peminjamanmobil;
        $data['langkah'] = 0;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('detailmobil', $this->session_info);
    }

    public function tambahmobil()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_mobil->get_pegawai_user($id_user);
        // var_dump($data);die();
        $data['barang'] = array();
        $data['step'] = "add_mobil";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('tambah_mobil', $this->session_info);
    }

    public function tambahlaptop(){
        //$this->peminjamanmobil = FALSE;
        //$this->All = FALSE;
        //$list_auths = $this->session_info['app_list_auth'];
        //foreach ($list_auths as $list_auth) {
        //    if ($list_auth->id_role === '49') { 
        //        $this->peminjamanmobil = TRUE;
        //    }
        //    if ($list_auth->id_role === '18') {
        //        $this->All = TRUE;
        //    }
        //}
        //
        //if(!$this->peminjamanmobil) {
        //  redirect('dashboard');
        //}
        if (!$this->pengelolalaptop && !$this->All) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_mobil->get_pegawai_user($id_user);
        $data['barang'] = array();
        $data['step'] = "add_mobil";

        $js = "
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
        $this->session_info['page_name'] = "Penambahan Laptop";
        $this->template->build('tambah_laptop', $this->session_info);
    }

    public function add_mobil(){
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49' || $list_auth->id_role === '59') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
            $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
            $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
            $routees        = ltrim($routees, '/');              // buang leading slash
            $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
            $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
            // var_dump($routees, $root, $routees_portal, $master_url);die();
        $foto = $this->input->post('foto1');
        $id_user = $this->input->post('id_user');
        $nama_user = $this->input->post('nama');
        $nama_mobil = $this->input->post('nama_mobil');
        $plat = $this->input->post('plat');
        $tahun = $this->input->post('tahun');
        $date = $this->input->post('date');
        $kategori = $this->input->post('kategori');
        $ketegori_jenis = $this->input->post('ketegori_jenis');
        $kapasitas = $this->input->post('kapasitas');
        $harga = $this->input->post('harga');
        $jumlah = $this->input->post('jumlah');
        $jenis = $this->input->post('jenis');
        $status = $this->input->post('status');
        $kondisi = $this->input->post('kondisi');    
        $foto1 = $this->upload->do_upload('foto1');
        $file = $_FILES["foto1"]["name"];
        $file_name = basename($_FILES["foto1"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $target_dir = $root.'/'.$routees."www/modules/peminjamanmobil/assets/img/";
        $target_file = $target_dir . $file_name;
        $nama_file = $nama_mobil.'mobil'.date('YmdGis').'.'.$ext;
        $fileBaru = $target_dir.$nama_file;
        if ($nama_mobil) {
          $upload = move_uploaded_file($_FILES["foto1"]["tmp_name"], $target_file);
          if($upload){
            $rnm = rename($target_file, $fileBaru);
            $simpan = $this->m_mobil->save_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $foto, $nama_file, $ketegori_jenis, $harga, $jumlah);
            if($ketegori_jenis == 'mobil'){
              $this->session->set_flashdata('sukses', "Mobil Berhasil Diinput");
              redirect('/peminjamanmobil/mobil');
            }
            if($ketegori_jenis == 'laptop'){
              $this->session->set_flashdata('sukses', "Laptop Berhasil Diinput");
              redirect('/peminjamanmobil/laptop');
            }
          }else{
          	if($ketegori_jenis == 'mobil'){
              $this->session->set_flashdata('gagal', "Data Belum Valid");
              redirect('/peminjamanmobil/tambahmobil');
            }  
            if($ketegori_jenis == 'laptop'){
            	$this->session->set_flashdata('gagal', "Data Belum Valid");
              redirect('/peminjamanmobil/tambahlaptop');
            }  
          }
        }
    }

  public function preview_peminjaman_mobil($id) {
    $surat = $this->m_mobil->data_surat($id);

    if (empty($surat)) {
      $this->session->set_flashdata('gagal', 'Data Tidak Ditemukan.');
      redirect('approve_surat');
    }

    $n_file = $surat->id.".pdf";
    
    $data['id'] = $surat->id;
    $data['n_file'] = 'SRT_'.$n_file;
    $data['n_file_draft'] = 'SRTDRAFT_'.$n_file;
    $data['page'] = 'mobil';
    $data['tgl_entry'] = $surat->tgl_entry;
    $data['no_surat'] = $surat->nomor_surat;
    $data['tgl_surat'] = $surat->tgl_surat;
	  $data['id_ess2'] = $surat->ess2;
	  $data['id_sekdis'] = $surat->sekdis;
	  $data['id_ess3'] = $surat->ess3;
	  $data['id_ess4'] = $surat->ess4;
    $data['id_jfah'] = $surat->jfah;
    $data['analis_hukum'] = $surat->analis_hukum;
	  $data['id_konseptor'] = $surat->user_id;
        $js = '
      var u = jQuery.noConflict();
      u(document).ready(function() {
        u("input[name="checkAll"]").click(function() {
          var checked = u(this).attr("checked");
          u("#myTable tr td input:checkbox").attr("checked", checked);
        });
      });
          ';
    // $this->load->view('v_preview_surat',$data);
        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('v_preview_surat', $this->session_info);
  }
  
    public function preview_mobil($id)
    {
	  $data['id'] = $id;
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('preview_mobil', $this->session_info);
    }


  public function update_multiple_mobil() {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $angka = 0;

    if(empty($this->input->post('msg'))){
      $this->session->set_flashdata('gagal', 'Surat tidak ada');
      redirect('peminjamanmobil/history_user');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
        $model = $this->m_approve_surat->update_permohonan1($iduser, $update, $passphrase);

        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
        $id_mobil = $this->m_approve_surat->id_peminjaman_mobil($update);
        $this->session->set_flashdata('sukses', "TTE berhasil");        
        
        $struktural = $this->m_mobil->get_data_struktural();
        foreach ($struktural as $key) {
        if($key->nama_posisi == 'Pengelola Mobil'){ $struktural_mobil = $key->id_pegawai; }
        }
        $id_user_pengelola_mobil = $this->m_mobil->get_id_pegawai($struktural_mobil);
        $n_hp = $this->m_mobil->get_no_telp($id_user_pengelola_mobil);
        // $n_hp    = '083822039748';
        $n_pesan = "Notifikasi Pesanan Mobil Masuk";

        // Assuming $this->lib_date->postWaSms() function works as intended
        $this->lib_date->postWaSms($n_hp, $n_pesan, "mobil");

        redirect('peminjamanmobil/approve/'.$id_mobil);
      } else {
        $this->session->set_flashdata('gagal', "Passphrase Tidak Sesuai !<br>Penanda Tanganan Dokumen Gagal<br>Silahkan Ulangi Proses Approve<br>");
        redirect('peminjamanmobil/history_user');
      }
    }
  }

  public function update_multiple_laptop() {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $id_permintaan_mobil = $this->input->post('id_permintaan_mobil');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $angka = 0;

    if(empty($this->input->post('msg'))){
      $this->session->set_flashdata('gagal', 'Surat tidak ada');
      redirect('peminjamanmobil/history_user');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
      if ($iduser == "114") { //114 = lucky 443 Jonas 680 Lian
         $model = $this->m_approve_surat->update_permohonan2($iduser, $update, $passphrase);
       } 
        $model = $this->m_approve_surat->update_permohonan1($iduser, $update, $passphrase);

        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
        $id_mobil = $this->m_approve_surat->id_peminjaman_mobil($update);
        $this->session->set_flashdata('sukses', "TTE berhasil");        
        
        $struktural = $this->m_mobil->get_data_struktural();
        foreach ($struktural as $key) {
        if($key->nama_posisi == 'Pengelola Laptop'){ $struktural_mobil = $key->id_pegawai; }
        }
        $id_user_pengelola_laptop = $this->m_mobil->get_id_pegawai($struktural_mobil);
        $n_hp = $this->m_mobil->get_no_telp($id_user_pengelola_laptop);
        // $n_hp    = '083822039748';
        $n_pesan = "Notifikasi Pesanan Mobil Masuk";

        // Assuming $this->lib_date->postWaSms() function works as intended
        // $this->lib_date->postWaSms($n_hp, $n_pesan, "mobil");
        redirect('peminjamanmobil/approve_laptop/'.$id_permintaan_mobil);
      } else {
        $this->session->set_flashdata('gagal', "Passphrase Tidak Sesuai !<br>Penanda Tanganan Dokumen Gagal<br>Silahkan Ulangi Proses Approve<br>");
        // redirect('peminjamanmobil/history_user_laptop');
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

  }

    public function test(){
        // Assuming $n_hp and $n_pesan are defined elsewhere in your code
        $id_mobil = 290;
        $struktural = $this->m_mobil->get_data_struktural();
        foreach ($struktural as $key) {
        if($key->nama_posisi == 'Pengelola Mobil'){ $struktural_mobil = $key->id_pegawai; }
        }
        $id_user_pengelola_mobil = $this->m_mobil->get_id_pegawai($struktural_mobil);
        $no_hp = $this->m_mobil->get_no_telp($id_user_pengelola_mobil);
        $n_hp    = '083822039748';
        $n_pesan = "Notofikasi Pesanan Mobil";

        // Assuming $this->lib_date->postWaSms() function works as intended
        $sms = $this->lib_date->postWaSms($n_hp, $n_pesan, "mobil");
        if($sms){
          echo 'sukses';
        }else{
          echo 'gagal';
        }
    }

  public function update_multiple_mobil_ess3() {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $angka = 0;
    if(empty($this->input->post('msg'))){
      $this->session->set_flashdata('sukses', $this->input->post('msg'));
      redirect('peminjamanmobil/peminjaman');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
      if ($iduser == "114") { //114 = lucky 443 Jonas 680 Lian
         $model = $this->m_approve_surat->update_permohonan2($iduser, $update, $passphrase);
       } 
        $model = $this->m_approve_surat->update_permohonan1($iduser, $update, $passphrase);

        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
          $id_mobil = $this->m_approve_surat->id_peminjaman_mobil($update);
          $this->session->set_flashdata('sukses', "TTE berhasil");
          redirect('peminjamanmobil/approve_admin/'.$id_mobil);
      } else {
          $this->session->set_flashdata('gagal', "Passphrase Tidak Sesuai !<br>Penanda Tanganan Dokumen Gagal<br>Silahkan Ulangi Proses Approve<br>");
          redirect($_SERVER['HTTP_REFERER']);
      }
    }
  }

  public function update_multiple_laptop_ess3() {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $idpegawai = $this->input->post('idpegawai');
    $id_pengolah = $this->input->post('id_pengolah');
    $simpan = $this->input->post('id_pemintaan');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $accept_encoding = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : null;
    
          if($idpegawai != $id_pengolah){
            $update_ess3 = $this->m_mobil->update_ess_3($update,$idpegawai,$id_pengolah);
            if(!$update_ess3){
                $this->session->set_flashdata('gagal', "Terjadi Kesalahan Hubungi Admin!!");
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $refresh = $this->refresh_doc($update,$idpegawai,$id_pengolah);
            }
          }

    // Gunakan $accept_encoding sesuai kebutuhan
    if ($accept_encoding) {
        // Proses jika encoding diterima
    } else {
        // Tindakan jika header tidak ditemukan
    }

    // die();
    $angka = 0;
    if(empty($this->input->post('msg'))){
      $this->session->set_flashdata('sukses', $this->input->post('msg'));
      redirect('peminjamanmobil/peminjaman');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
        $model = $this->m_approve_surat->update_permohonan1($iduser, $update, $passphrase);

        if ($model == 1) {
          $angka++;
        }
      }
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
      if ($hitung == $angka) {
          $id_mobil = $this->m_approve_surat->id_peminjaman_mobil($update);
          $this->session->set_flashdata('sukses', "TTE berhasil");
          // redirect('peminjamanmobil/approve_admin/'.$id_mobil);
          
        $status = '1';
        $approve = $this->m_mobil->get_approve_mobil($id_mobil, $status);
        $cek = $this->m_mobil->get_peminjaman($id_mobil);
        // foreach ($cek as $row) {
        //   if($row->kategori == 'laptop'){
            $redirect = 'peminjam_laptop';
          // }else{
          //   $redirect = 'peminjaman_laptop';
        //   }
        // }
        $this->session->set_flashdata('sukses', "Surat Berhasil di ajukan");
        redirect('/peminjamanmobil/'.$redirect);
          // redirect($master_url.'/'.$routees.'/persuratan/laptop/'.$simpan);
      } else {
          $this->session->set_flashdata('gagal', "Passphrase Tidak Sesuai !<br>Penanda Tanganan Dokumen Gagal<br>Silahkan Ulangi Proses Approve<br>");
          redirect($_SERVER['HTTP_REFERER']);
      }
    }
  }

  public function refresh_doc($update,$idpegawai,$id_pengolah) {
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $id = $update;
        if ($this->All) {
          $lokasi     = $this->input->post('kabupaten');
	        $pkepada      = $this->input->post('listizin');
          $tglberangkat     = $this->input->post('tglberangkat');
          $tglkembali     = $this->input->post('tglkembali');
	  	  }
        $file = "$master_url/$routees/assets/docx-surat/SRT_laptop.docx";
        $file_name = basename('SRT_laptop.docx');       
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/docx-surat/";
        $target_docx = "assets/docx-surat-processed/";
        $target_file = $target_dir . $file_name;
        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;
        
        $sourceFilePath = "assets/template/SRT_laptop.docx"; // Ganti dengan path file sumber yang ingin disalin
        $destinationFilePath = "assets/docx-surat/SRT_laptop.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        $destinationFilePathdocx = "assets/docx-surat-processed/SRT_laptop.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        chmod($target_dir, 0777);
        chmod($target_docx, 0777);
        if (copy($sourceFilePath, $destinationFilePath)) {
          $oldFilePath = "assets/docx-surat/SRT_laptop.docx"; // Ganti dengan path file yang ingin diubah namanya
          $newFilePath = "assets/docx-surat/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          $newFilePath2 = "assets/docx-surat-processed/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          if(file_exists($newFilePath)){
            unlink($newFilePath);
          }
          if (rename($oldFilePath, $newFilePath)) {
            if (copy($newFilePath, $newFilePath2)) {
              
            } else {
              chmod($target_dir, 0755);
              chmod($target_docx, 0755);
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                redirect('/peminjamanmobil/peminjaman');
            }
              echo "File berhasil diubah namanya.";
              chmod($target_docx, 0755);
              chmod($target_dir, 0755);
          } else {
            chmod($target_dir, 0755);
            chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal mengubah nama file.");
            redirect('/peminjamanmobil/peminjaman');
          }
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            echo "File berhasil disalin.";
        } else {
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
            redirect('/peminjamanmobil/peminjaman');
        }
          $this->m_mobil->update_path($id, $newFilePath);
          $dok = $this->olah_word($id);
          if ($dok) {
            $convert = $this->konversi_pdf($id);
            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan/update_penomoran_ba_laptop/'.$id.'/'.$idmobil);
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              redirect('/peminjamanmobil/peminjaman');
            }
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/peminjamanmobil/peminjaman');
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/peminjamanmobil/peminjaman');
          }
  }

  public function konversi_pdf($id) {
    
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    $redirect = str_replace(' ', '','SRT_'.$id);
    $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $data = file_get_contents('http://103.122.5.250/siapi/api/surat?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
    $json = json_decode($data);
    if($json->status && $json->status == 'success') {
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
      $newfile =  $_SERVER['DOCUMENT_ROOT'] .'/'.$routees.'assets/pdf-surat/'.$namafile.'.pdf';
      $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/'.$routees.'assets/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
      if(file_exists($newfile)){
        unlink($newfile);
      }
      if(file_exists($filenameW)){
        unlink($filenameW);
      }
      if (copy($dtpdf, $newfile)) {

        //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .'/'.$routees.'assets/pdf-surat/'.$namafile.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/'.$routees.'assets/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
        try{
          $pageCount = $pdf->setSourceFile($filename);
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            if($size['w'] > $size['h']) {
              $pdf->AddPage('L', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/draft.png';
              $pdf->Image($img,5,10,300,200);
            }else{
              $pdf->AddPage('P', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/draft.png';
              $pdf->Image($img,10,10,220,310);
            }
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filenameW,'F');
        }
        catch (Exception $e) {
          return false;
        }
        //EOFCreate pdf watermark

        return true;
      }
    }else{
      return false;
    }
  }

  public function olah_word($id) {
      require_once 'assets/phpword/src/PhpWord/Autoloader.php';
      \PhpOffice\PhpWord\Autoloader::register();

      $datasurat = $this->m_mobil->get_datasurat($id);

      if ($datasurat) {
        $id_ess4 = $datasurat->ess4;
        $id_ess3 = $datasurat->ess3;
        $id_ess2 = $datasurat->ess2;
        $id_sekdis = $datasurat->sekdis;
        $tgl_surat = $datasurat->tgl_surat;
        $nomor_surat = $datasurat->nomor_surat;
        $sifat_surat = $datasurat->sifat_surat;
        $lampiran = $datasurat->lampiran;
        $hal = $datasurat->hal;
        $kepada = $datasurat->kepada;
      } else {
        return false;
      }
      if(file_exists('assets/docx-surat/SRT_'.$id.'.docx')){
      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/docx-surat/SRT_'.$id.'.docx');

      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
      $blnRomawi = $arrblnRomawi[date("m")-1];
      
      // Ttd SK
      $idttd = $id_ess2;

      if ($id_ess2 == "0") {
        if ($id_sekdis != "0") {
          $idttd = $id_sekdis;
        } else {
          if ($id_ess3 == "0") {
            $idttd = $id_ess4;
          } else {
            $idttd = $id_ess3;
          }
        }
      }

      $pegawai = new tmpegawai();
      $pegawai = $pegawai->where('id', $idttd)->get();
      $jbt     = $pegawai->n_jabatan;
      $nmjbt  = explode(" ", $jbt); 

      //update jabatan kadis kalau ada Plh
      if (strtolower($nmjbt[0]) == 'plh.' || strtolower($nmjbt[0]) == 'plt.') {
        $nmjbt = array_map('strtoupper', $nmjbt);

        if (strtolower($nmjbt[0]) == 'plh.') {
          $jab = 'Plh.';
        } else {
          $jab = 'Plt.';
        }

        $arr = array($jab, $nmjbt[1], $nmjbt[2], $nmjbt[3], $nmjbt[4], $nmjbt[5], $nmjbt[6], $nmjbt[7], $nmjbt[8], $nmjbt[9], $nmjbt[10], $nmjbt[11], $nmjbt[12]);
        $jbt = implode(" ", $arr);
      } else {
        $jbt = strtoupper($jbt);
      }
      //end update jabatan

      $ttd_kepala  = $pegawai->n_pegawai;
      $ttd_pangkat = $pegawai->pangkat_gol;
      $ttd_nip     = $pegawai->nip;
      $ttd_idfile  = $pegawai->id;
      // EOF() Ttd SK

        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];

      // create peminjaman mobil by lian
      $idmobil = $this->m_mobil->get_idmobil($id);
        if($idmobil != NULL){

              //Create QRCode
      include('./assets/qrcode/qrlib.php');
      $tempDir = 'uploads/data_qrcode_naskah/';
      $link = $master_url.'/'.$routees_portal.'/main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
      $pngAbsoluteFilePath = $tempDir.$fileName;
      $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
      if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.

      $logopath = "$master_url/$routees/uploads/logo/logo_ttd.jpg";
        
      if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
        $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
        $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
        $padding = 0;
        QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
      }

      $QR = imagecreatefrompng($tempDir.$fileName);

      // memulai menggambar logo dalam file qrcode
      $logo = imagecreatefromstring(file_get_contents($logopath));
      
      imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
      imagealphablending($logo , false);
      imagesavealpha($logo , true);

      $QR_width = imagesx($QR);
      $QR_height = imagesy($QR);

      $logo_width = imagesx($logo);
      $logo_height = imagesy($logo);

      // Scale logo to fit in the QR Code
      $logo_qr_width = $QR_width/2.4;
      $scale = $logo_width/$logo_qr_width;
      $logo_qr_height = $logo_height/$scale;

      imagecopyresampled($QR, $logo, $QR_width/3.2, $QR_height/3.2, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

      // Simpan kode QR lagi, dengan logo di atasnya
      imagepng($QR,$tempDir.$fileName);
      //EOF() Create QRCode

          $idpeminjam = $this->m_persuratan->get_idpeminjam_mobil($idmobil);
          $nama_peminjam = $this->m_persuratan->get_peminjam_mobil($idpeminjam);
          $templateProcessor->setValue("nama",$nama_peminjam);                                          // Nama Peminjam Mobil
          $jabatan_peminjam = $this->m_persuratan->get_jabatan_mobil($idpeminjam);
          $templateProcessor->setValue("jabatan_peminjam",$jabatan_peminjam);                           // Jabatan Peminjam

          $nip_kedua = $this->m_persuratan->get_nip_mobil($idpeminjam);
          $templateProcessor->setValue("nip_kedua",$nip_kedua);                           // nip Peminjam
          $unit = $this->m_persuratan->get_nama_unit($idpeminjam);
          $trunit = $this->m_persuratan->get_trunitkerja($unit); 
          $templateProcessor->setValue("unit",$trunit);                           // unit Peminjam
          $mobil = $this->m_persuratan->get_mobil_id($idmobil);                 // unit Peminjam
          $driver = $this->m_persuratan->get_driver_id($idmobil);
          $nopol = $this->m_persuratan->get_platnomor_id($mobil);
          $templateProcessor->setValue("nopol",$nopol);                           // nopol Peminjam
          $templateProcessor->setValue("driver",$driver);                           // nopol Peminjam
          $templateProcessor->setValue("qr_",$nopol);                           // nopol Peminjam

          setlocale(LC_TIME, 'id_ID');
          $startDate = date('Y-m-d', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
          $endDate = date('Y-m-d', strtotime($this->m_persuratan->tanggal_kembali($idmobil)));
          $startTime = strtotime($startDate);
          $endTime = strtotime($endDate);

          $daysDiff = ($endTime - $startTime) / (60 * 60 * 24);
          $start = date('d F Y', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
          $end = date('d F Y', strtotime($this->m_persuratan->tanggal_kembali($idmobil)));
          $haristart = strftime('%A', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
          $daysDiff = $daysDiff + 1;
          $templateProcessor->setValue("durasi",$daysDiff);                           // durasi Peminjam
          $templateProcessor->setValue("tgl_awal",$start);                           // tgl_awal Peminjam
          $templateProcessor->setValue("tgl_akhir",$end);                           // tgl_akhir Peminjam
          $templateProcessor->setValue("hari",$haristart);                           // hari Peminjam
          $tujuan = $this->m_persuratan->tujuan($idmobil);
          $templateProcessor->setValue("tujuan",$tujuan);                           // tujuan Peminjam
          $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));
          $id_satu       = $this->m_persuratan->struktural(4);
          $templateProcessor->setValue("nama_satu",$this->m_persuratan->get_peminjam_mobil($id_satu));                           // hari Peminjam
          $nama_kesatu = $this->m_persuratan->get_peminjam_mobil($id_satu);
          $id_dua = $this->m_persuratan->id_pihak_dua($id);

          // $id_satu = $this->m_persuratan->id_pihak_satu($id);
          // $id_satu = '453';
          // $nip_satu = $this->m_persuratan->nip_pihak_satu($id_satu);
          $nip_satu = $this->m_persuratan->get_nip_mobil($id_satu);
          $ttd_id_peminjam = $root.'/'.$routees.'uploads/logo/SRT_'.$id_satu.'.png';
          $ttd_nip_peminjam = $root.'/'.$routees.'uploads/logo/'.$nip_satu.'.png';
          if(file_exists($ttd_id_peminjam)){
              $templateProcessor->setImg('ttd_satu', array('src' => $ttd_id_peminjam, 'size' => array(270, 93)));
          } elseif(file_exists($ttd_nip_peminjam)){
              $templateProcessor->setImg('ttd_satu', array('src' => $ttd_nip_peminjam, 'size' => array(270, 93), 'text' => '('.$nama_kesatu.')<br> NIP. '.$nip_satu));
          }
          $ttd_id_peminjam_kedua = $root.'/'.$routees.'uploads/logo/SRT_'.$id_dua.'.png';
          $ttd_nip_peminjam_kedua = $root.'/'.$routees.'uploads/logo/'.$nip_kedua.'.png';
          // Periksa apakah file $ttd_id_peminjam_kedua ada
          if (file_exists($ttd_id_peminjam_kedua)) {
              // File $ttd_id_peminjam_kedua ada, gunakan itu
              $path_ttd_kedua = $ttd_id_peminjam_kedua;
              $templateProcessor->setImg('ttd_dua', array('src' => $path_ttd_kedua,'size' => array( 270, 93 )));
          } else {
              // File $ttd_id_peminjam_kedua tidak ada, gunakan $ttd_nip_peminjam_kedua
              $path_ttd_kedua = $ttd_nip_peminjam_kedua;
              $templateProcessor->setImg('ttd_dua', array('src' => $path_ttd_kedua,'size' => array( 270, 93 ).'<br>('.$nama_peminjam.')<br>'.'NIP. '.$nip_kedua));
          }
          $id_tiga        = $this->m_persuratan->struktural(7);
          // $id_tiga = '911'; // 911 id pak cucun
          $nip_tiga = $this->m_persuratan->get_nip_mobil($id_tiga); // 198109082008011002 id pak cucun
          $ttd_id_ketiga = $root.'/'.$routees.'uploads/logo/SRT_'.$id_tiga.'.png';
          $ttd_nip_ketiga = $root.'/'.$routees.'uploads/logo/'.$nip_tiga.'.png';
          if(file_exists($ttd_id_peminjam)){
              $templateProcessor->setImg('ttd_tiga', array('src' => $ttd_id_ketiga, 'size' => array(270, 93)));
          } elseif(file_exists($ttd_nip_peminjam)){
              $templateProcessor->setImg('ttd_tiga', array('src' => $ttd_nip_ketiga, 'size' => array(270, 93), 'text' => '(Cucun Suherman)<br> NIP. '.$nip_satu));
          }
          $id_dua = $this->m_persuratan->id_pihak_dua($id);
          $templateProcessor->setImg('bsre', array('src' => $root.'/'.$routees.'uploads/logo/bsre.png', 'size' => array(710,63)));
          
          //Ambil dan Tampilkan QrCode
          $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
          //$image_path = 'uploads/logo/blank_qr.png';
          $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
      // end peminjaman mobil
        }else{

      
      //Create QRCode
      include('./assets/qrcode/qrlib.php');
      $tempDir = 'uploads/data_qrcode_naskah/';
      $link = $master_url.'/'.$routees_portal.'/main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
      $pngAbsoluteFilePath = $tempDir.$fileName;
      $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
      if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.

      $logopath = $master_url.'/'.$routees.'uploads/logo/logo_ttd.jpg';
        
      if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
        $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
        $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
        $padding = 0;
        QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
      }

      $QR = imagecreatefrompng($tempDir.$fileName);

      // memulai menggambar logo dalam file qrcode
      $logo = imagecreatefromstring(file_get_contents($logopath));
      
      imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
      imagealphablending($logo , false);
      imagesavealpha($logo , true);

      $QR_width = imagesx($QR);
      $QR_height = imagesy($QR);

      $logo_width = imagesx($logo);
      $logo_height = imagesy($logo);

      // Scale logo to fit in the QR Code
      $logo_qr_width = $QR_width/2.4;
      $scale = $logo_width/$logo_qr_width;
      $logo_qr_height = $logo_height/$scale;

      imagecopyresampled($QR, $logo, $QR_width/3.2, $QR_height/3.2, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

      // Simpan kode QR lagi, dengan logo di atasnya
      imagepng($QR,$tempDir.$fileName);
      //EOF() Create QRCode


      //Create Variabel => transfer variabel pencetakan All
      // hindari input data menggunakan karakter & < > || sudah fixed by Nirwan

      $templateProcessor->setValue("provinsi",'PROVINSI JAWA BARAT');
      
      $templateProcessor->setValue("jabatan",htmlspecialchars($jbt));
      $templateProcessor->setValue("kepala",$ttd_kepala);
      $templateProcessor->setValue("pangkat",$ttd_pangkat);
      $templateProcessor->setValue("nip",$ttd_nip);

      $templateProcessor->setValue("no_surat",$nomor_surat);
      $templateProcessor->setValue("tgl_surat",$this->lib_date->mysql_to_human($tgl_surat));
      $templateProcessor->setValue("sifat_surat",htmlspecialchars($sifat_surat));
      $templateProcessor->setValue("lampiran",htmlspecialchars($lampiran));
      $templateProcessor->setValue("hal",htmlspecialchars($hal));
      $templateProcessor->setValue("kepada",htmlspecialchars($kepada));

      $templateProcessor->setValue("bulanromawi",$blnRomawi);
      $templateProcessor->setValue("tahunini",date("Y"));
      $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));
        
      //Ambil dan Tampilkan QrCode
      $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
      //$image_path = 'uploads/logo/blank_qr.png';
      $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
      
      //Ambil dan Tampilkan TTD Penandatangan        
      $image_path = 'uploads/logo/TtdEKadis.png';
      $file_ttd = str_replace(" ", "", $ttd_nip);

      if (file_exists('uploads/logo/SRT_'.$ttd_idfile.'.png')) {
        $image_path = 'uploads/logo/SRT_'.$ttd_idfile.'.png';
      }

      $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 270, 93 ))); //default = 100, 47 | Pak Daud Plt = 140, 87    // ttd kadis

      //Ambil dan Tampilkan Kop Surat
      $image_path = 'uploads/logo/kop.png';
      $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
      
      //Ambil dan Tampilkan Cap Dinas
      $image_path = 'uploads/logo/CapDinas.png';
      $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas
    }
     //Create File docx
    $file_target = 'assets/docx-surat-processed/SRT_'.$id.'.docx';
    $simpan = $templateProcessor->saveAs($file_target);
    //EOF() Create File docx
    
      return TRUE;    
    }else{
      return FALSE;
    }
  }
    public function edit_mobil($id)
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $data['koor_tot'] = $this->m_mobil->koor_tot_id($id);
        $data['mobil'] = $this->m_mobil->get_data_id($id);
        $data['id'] = $id;
        $data['step'] = "edit_mobil";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('edit_mobil', $this->session_info);
    }
    
    public function edit_laptop($id)
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '59') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        //if (!$this->peminjamanmobil) {
        //    redirect('dashboard');
        //}
        $id_user = $this->session->userdata('id_auth');
        $data['koor_tot'] = $this->m_mobil->tmpegawai();
        $data['mobil'] = $this->m_mobil->get_data_id($id);
        $data['id'] = $id;
        $data['step'] = "edit_mobil";

        $js = "
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
        $this->session_info['page_name'] = "Edit Data Laptop";
        $this->template->build('edit_laptop', $this->session_info);
    }

    public function edit_pemohonan($id)
    {
        $id_user = $this->session->userdata('id_auth');
        $data['mobil'] = $this->m_mobil->get_data_peminjaman_id($id);
        $data['id'] = $id;
        $data['step'] = "edit_mobil";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('edit_peminjaman_mobil', $this->session_info);
    }

    public function editmobil($id)
    {
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        // var_dump($routees, $root,$routees_portal,$master_url);die();
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49' || $list_auth->id_role === '59') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE; 
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->input->post('id_user');
        $nama_user = $this->input->post('nama');
        $nama_mobil = $this->input->post('nama_mobil');
        $plat = $this->input->post('plat');
        $tahun = $this->input->post('tahun');
        $date = $this->input->post('date');
        $kategori = $this->input->post('kategori');
        $harga = $this->input->post('harga');
        $jumlah = $this->input->post('jumlah');
        $ketegori_jenis = $this->input->post('ketegori_jenis');
        $kapasitas = $this->input->post('kapasitas');
        $jenis = $this->input->post('jenis');
        $status = $this->input->post('status');
        $kondisi = $this->input->post('kondisi');
        $on_off = $this->input->post('on_off');
        $oldfoto = $this->input->post('oldfoto');
        $foto = $this->input->post('gambar');
        $tim = $this->input->post('tim');
        // new file
        $file = $_FILES["gambar"]["name"];
        $file_name = basename($_FILES["gambar"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $target_dir = $root.'/'.$routees."www/modules/peminjamanmobil/assets/img/";
        $target_file = $target_dir . $file_name;
        $nama_file = $nama_mobil.'mobil'.date('YmdGis').$id.'.'.$ext;
        $fileBaru = $target_dir.$nama_file;
          $file_path = $target_dir.$oldfoto;
          $new_file_path = $target_dir.$nama_file;

          // Mengganti file dengan file baru
          if (move_uploaded_file($_FILES['gambar']['tmp_name'], $new_file_path)) {
              // Menghapus file yang ada
              if (file_exists($file_path)) {
                  if (unlink($file_path)) {
                      echo 'File lama berhasil dihapus.';
                  }
              }
              echo 'File baru berhasil diunggah dan diganti.';                  
              $this->m_mobil->edit_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $id, $nama_file, $on_off , $tim,$ketegori_jenis, $harga,$jumlah);
              if($ketegori_jenis == 'mobil'){
                $this->session->set_flashdata('sukses', "Mobil Berhasil Di edit");
                redirect('/peminjamanmobil/mobil');
              }
              if($ketegori_jenis == 'laptop'){
                $this->session->set_flashdata('sukses', "Laptop Berhasil Di edit");
                redirect('/peminjamanmobil/laptop');
              }
          } else {
              $this->m_mobil->edit_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $id, $oldfoto, $on_off ,$tim, $ketegori_jenis, $harga, $jumlah);
              if($ketegori_jenis == 'mobil'){
                $this->session->set_flashdata('sukses', "Mobil Berhasil Di edit");
                redirect('/peminjamanmobil/mobil');
              }
              if($ketegori_jenis == 'laptop'){
                $this->session->set_flashdata('sukses', "Laptop Berhasil Di edit");
                redirect('/peminjamanmobil/Laptop');
              }
          }
    }

    public function editlaptop($id)
    {
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49' || $list_auth->id_role === '59') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE; 
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->input->post('id_user');
        $nama_user = $this->input->post('nama');
        $nama_mobil = $this->input->post('nama_mobil');
        $plat = $this->input->post('plat');
        $tahun = $this->input->post('tahun');
        $date = $this->input->post('date');
        $kategori = $this->input->post('kategori');
        $harga = $this->input->post('harga');
        $jumlah = $this->input->post('jumlah');
        $ketegori_jenis = $this->input->post('ketegori_jenis');
        $kapasitas = $this->input->post('kapasitas');
        $jenis = $this->input->post('jenis');
        $status = $this->input->post('status');
        $kondisi = $this->input->post('kondisi');
        $on_off = $this->input->post('on_off');
        $oldfoto = $this->input->post('oldfoto');
        $foto = $this->input->post('gambar');
        $tim = $this->input->post('tim');
        $peminjam_laptop = $this->input->post('peminjam_laptop');
        $tanggal_pinjam = $this->input->post('tanggal_pinjam');
        $tanggal_kembali = $this->input->post('tanggal_kembali');
        // new file
        $file = $_FILES["gambar"]["name"];
        $file_name = basename($_FILES["gambar"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $target_dir = "$root/$routees/www/modules/peminjamanmobil/assets/img/";
        $target_file = $target_dir . $file_name;
        $nama_file = $nama_mobil.'mobil'.date('YmdGis').$id.'.'.$ext;
        $fileBaru = $target_dir.$nama_file;
          $file_path = $target_dir.$oldfoto;
          $new_file_path = $target_dir.$nama_file;


          // Mengganti file dengan file baru
          if (move_uploaded_file($_FILES['gambar']['tmp_name'], $new_file_path)) {
              // Menghapus file yang ada
              if (file_exists($file_path)) {
                  if (unlink($file_path)) {
                      echo 'File lama berhasil dihapus.';
                  }
              }
              echo 'File baru berhasil diunggah dan diganti.';    
              $keterangan_berangkat = '-';              
              $status = "-";          
              $bagian = "-";  
              $driver = "-";

              $this->m_mobil->edit_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $id, $nama_file, $on_off , $tim,$ketegori_jenis, $harga,$jumlah,$tanggal_pinjam, $tanggal_kembali, $peminjam_laptop);
              
              if($peminjam_laptop != ""){

                $cek_laptop = $this->m_mobil->insert_laptop($status, $tanggal_pinjam, $tanggal_kembali, $peminjam_laptop, $id, $keterangan_berangkat, $bagian, $driveri);

              }
              if($ketegori_jenis == 'laptop'){
                $this->session->set_flashdata('sukses', "Laptop Berhasil Di edit");
                redirect('/peminjamanmobil/laptop');
              }
              
              
              if($ketegori_jenis == 'mobil'){
                $this->session->set_flashdata('sukses', "Mobil Berhasil Di edit");
                redirect('/peminjamanmobil/mobil');
              }
              if($ketegori_jenis == 'laptop'){
                $this->session->set_flashdata('sukses', "Laptop Berhasil Di edit");
                redirect('/peminjamanmobil/laptop');
              }
          } else {
              $keterangan_berangkat = '-';             
              $status = "-";          
              $bagian = "-";            
              $driver = "-";     

              $this->m_mobil->edit_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $id, $oldfoto, $on_off ,$tim, $ketegori_jenis, $harga, $jumlah,$tanggal_pinjam, $tanggal_kembali, $peminjam_laptop);
              
              if($peminjam_laptop != ""){

                $cek_laptop = $this->m_mobil->insert_laptop($status, $tanggal_pinjam, $tanggal_kembali, $peminjam_laptop, $id, $keterangan_berangkat, $bagian, $driver);

              }
              if($ketegori_jenis == 'mobil'){
                $this->session->set_flashdata('sukses', "Mobil Berhasil Di edit");
                redirect('/peminjamanmobil/mobil');
              }
              if($ketegori_jenis == 'laptop'){
                $this->session->set_flashdata('sukses', "Laptop Berhasil Di edit");
                redirect('/peminjamanmobil/Laptop');
              }
          }
    }

    public function hapus_mobil($id)
    {
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $target_dir = "$root/$routess/www/modules/peminjamanmobil/assets/img/";
        $oldfoto = $this->m_mobil->get_file_foto($id);
        $file_path = $target_dir.$oldfoto;
        // Menghapus file yang ada
        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                echo 'File lama berhasil dihapus.';
            }
        }
        $this->m_mobil->get_hapus_mobil($id);
        $this->session->set_flashdata('sukses', "Mobil Berhasil Di Hapus");
        redirect('/peminjamanmobil/mobil');
    }

    public function approve_old($id)
    {
        $status = '10';
        $approve = $this->m_mobil->get_approve_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Surat Berhasil di ajukan");
        redirect('/peminjamanmobil/history_user');
    }

    public function approve_old_laptop($id)
    {
        $status = '10';
        $approve = $this->m_mobil->get_approve_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Surat Berhasil di ajukan");
        redirect('/peminjamanmobil/history_user_laptop');
    }

    public function approve_admin($id)
    {
        $status = '1';
        $approve = $this->m_mobil->get_approve_mobil($id, $status);
        $cek = $this->m_mobil->get_peminjaman($id);
        foreach ($cek as $row) {
          if($row->kategori == 'laptop'){
            $redirect = 'peminjam_laptop';
          }else{
            $redirect = 'peminjaman';
          }
        }
        $this->session->set_flashdata('sukses', "Surat Berhasil di ajukan");
        redirect('/peminjamanmobil/'.$redirect);
    }

    public function approve($id)
    {
        $status = '0';
        $approve = $this->m_mobil->get_approve_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Peminjaman Berhasil Di apporve");
        redirect('/peminjamanmobil/history_user');
    }

    public function approve_laptop($id)
    {
        $status = '0';
        $approve = $this->m_mobil->get_approve_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Peminjaman Berhasil Di apporve");
        redirect('/peminjamanmobil/history_user_laptop');
    }

    public function reject($id, $req = NULL)
    {
          	
    //   $id_surat = $this->m_mobil->get_id_mobil_persuratan($id);
    //   if ($this->m_mobil->delete_surat($id_surat)) {
    //    $id_tim = $this->m_mobil->del_tim($id_surat);
  	// 	$this->session->set_flashdata('sukses', "Berhasil Reject Data.");
    //   	redirect('/peminjamanmobil/peminjaman');
  	// } else {
  	// 	$this->session->set_flashdata('gagal', "Gagal Reject Data.");
    //   	redirect('/peminjamanmobil/peminjaman');
  	// }
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
    $id_surat = $this->m_mobil->get_id_mobil_persuratan($id);
  	if ($this->m_mobil->delete_surat($id_surat)) {
      $id_id = $this->m_mobil->del_tim_mobil($id);
  		$this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
        $target_dir = "$root/$routees/assets/pdf-surat/SRT_".$id_surat.".pdf";
        $target_dir_word = "$root/$routees/assets/docx-surat/SRT_".$id_surat.".pdf";
        $processed = "$root/$routees/assets/docx-surat-processed/SRT_".$id_surat.".pdf";
        $pdfsuratwm = "$root/$routees/assets/pdf-surat-wm/SRT_".$id_surat.".pdf";
        $file_path = $target_dir;
        $file_path_word = $target_dir_word;
      // $file_path = 'path/to/your/SRT_'.$id_surat.'.txt';

      if (file_exists($file_path_word)) {
          if (unlink($file_path_word)) {
              $this->session->set_flashdata('gagal', "File berhasil Reject");
          } else {
              $this->session->set_flashdata('gagal', "Gagal Reject file");
          }
      } else {
          $this->session->set_flashdata('gagal', "File tidak ditemukan");
      }
      if (file_exists($processed)) {
          if (unlink($processed)) {
              $this->session->set_flashdata('gagal', "File berhasil Reject");
          } else {
              $this->session->set_flashdata('gagal', "Gagal Reject file");
          }
      } else {
          $this->session->set_flashdata('gagal', "File tidak ditemukan");
      }
      if (file_exists($pdfsuratwm)) {
          if (unlink($pdfsuratwm)) {
              $this->session->set_flashdata('gagal', "File berhasil Reject");
          } else {
              $this->session->set_flashdata('gagal', "Gagal Reject file");
          }
      } else {
          $this->session->set_flashdata('gagal', "File tidak ditemukan");
      }
      if (file_exists($file_path)) {
          if (unlink($file_path)) {
              $this->session->set_flashdata('gagal', "File berhasil Reject");
          } else {
              $this->session->set_flashdata('gagal', "Gagal Reject file");
          }
      } else {
          $this->session->set_flashdata('gagal', "File tidak ditemukan");
      }
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Reject Data.");
  	}
        $status = '12';
        $approve = $this->m_mobil->get_reject_mobil($id);
        if($req == 'laptop'){
        redirect('/peminjamanmobil/peminjam_laptop');
        }elseif($req != 2){
        redirect('/peminjamanmobil/peminjaman');
        }else{
        redirect('/peminjamanmobil/history_user');
        }
    }

  public function reload($idmobil, $idpegawai, $id_surat) {
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    redirect("$master_url/$routees/persuratan/reload_mobil/$idmobil/$idpegawai/$id_surat",'refresh');
  }
  
  public function reload_laptop($idmobil, $idpegawai, $id_surat) {
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    redirect("$master_url/$routees/persuratan/reload_laptop/$idmobil/$idpegawai/$id_surat",'refresh');
  }
  
  public function hapus_pengajuan($id, $kategori) {
    if($kategori == '2'){
      if ($this->m_mobil->del_tim_mobil($id_mobil)) {
          $id_motor = $this->m_mobil->delete_surat($id);
          $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
          redirect('peminjamanmobil/history_user');
      } else {
        $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
          redirect('peminjamanmobil/history_user');
      }
    }else{
      if ($this->m_mobil->del_tim_mobil($id_mobil)) {
          $id_motor = $this->m_mobil->delete_surat($id);
          $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
          redirect('peminjamanmobil/history_user_laptop');
      } else {
        $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
          redirect('peminjamanmobil/history_user_laptop');
      }
    }
  }
  
    public function mobil()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $mobil = $this->m_mobil->get_data();
        $data['langkah'] = 1;
        $data['page'] = 1;
        $data['button'] = 'mobil';
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('mobil', $this->session_info);
    }

    public function laptop(){
        //$this->peminjamanmobil = FALSE;
        //$this->All = FALSE;
        //$list_auths = $this->session_info['app_list_auth'];
        //foreach ($list_auths as $list_auth) {
        //    if ($list_auth->id_role === '49') {
        //        $this->peminjamanmobil = TRUE;
        //    }
        //    if ($list_auth->id_role === '18') {
        //        $this->All = TRUE;
        //    }
        //}

        if (!$this->pengelolalaptop && !$this->All) {
            redirect('dashboard');
        }
        $mobil = $this->m_mobil->get_data('laptop');
        $data['langkah'] = 1;
        $data['page'] = 1;
        $data['button'] = 'laptop';
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Laptop";
        $this->template->build('laptop', $this->session_info);
    }

    public function peminjaman()
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -40));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 20));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;

          $id_user = $this->session->userdata('id_auth');
          $mobil = $this->m_mobil->get_peminjaman($tgla,$tglb);

        $data['id_user'] = $id_user;
        $data['langkah'] = 1;
        $mobil = $this->m_mobil->get_peminjaman($tgla,$tglb);
        $data['langkah'] = 1;
        $data['button'] = 'mobil';
        $data['page'] = 2;
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('peminjaman', $this->session_info);
    }

    public function peminjam_laptop()
    {
      
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -40));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 20));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
          $id_user = $this->session->userdata('id_auth');
          $mobil = $this->m_mobil->get_peminjaman();

        $data['id_user'] = $id_user;
        $data['langkah'] = 1;
        $mobil = $this->m_mobil->get_peminjaman_laptop($tgla, $tglb);
        $data['button'] = 'laptop';
        $data['page'] = 2;
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "List Peminjaman Laptop";
        $this->template->build('peminjaman', $this->session_info);
    }

  public function hapus($id_mobil, $id) {
  	if ($this->m_mobil->del_tim_mobil($id_mobil)) {
        $id_motor = $this->m_mobil->delete_surat($id);
  		  $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      	redirect('peminjamanmobil/rekap');
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      	redirect('peminjamanmobil/rekap');
  	}
  }
  
    public function rekap()
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -15));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 25));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->peminjamanmobil = TRUE;
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $mobil = $this->m_mobil->get_peminjaman($tgla, $tglb, $this->All);
        $data['langkah'] = 1;
        $data['page'] = 3;
        $data['button'] = 'mobil';
        $data['mobil'] = $mobil;

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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('rekap', $this->session_info);
    }

    
    public function rekap_laptop()
    {
      
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -15));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 25));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->peminjamanmobil = TRUE;
                $this->All = TRUE;
            }
        }

        //if (!$this->peminjamanmobil) {
        //    redirect('dashboard');
        //}
        if (!$this->pengelolalaptop && !$this->All) {
            redirect('dashboard');
        }
          $id_user = $this->session->userdata('id_auth');
        $mobil = $this->m_mobil->get_peminjaman_laptop($tgla, $tglb);
        $data['langkah'] = 1;
        $data['button'] = 'laptop';
        $data['page'] = 3;
        $data['mobil'] = $mobil;

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
        $this->session_info['page_name'] = "Rekapitulasi Peminjaman Laptop";
        $this->template->build('rekap', $this->session_info);
    }

    public function history()
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $mobil = $this->m_mobil->get_peminjaman($tgla, $tglb);
        $data['langkah'] = 1;
        $data['page'] = 4;
        $data['button'] = 'mobil';
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('history', $this->session_info);
    }

    public function history_laptop()
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));
        $data['tgla'] = $tgla;
        $data['button'] = 'laptop';
        $data['tglb'] = $tglb;
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        //if (!$this->peminjamanmobil) {
        //    redirect('dashboard');
        //}
        if (!$this->pengelolalaptop && !$this->All) {
            redirect('dashboard');
        }
        $mobil = $this->m_mobil->get_peminjaman_laptop($tgla, $tglb);
        $data['langkah'] = 1;
        $data['page'] = 4;
        $data['button'] = 'laptop';
        $data['mobil'] = $mobil;
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
        $this->session_info['page_name'] = "History Peminjaman Laptop";
        $this->template->build('history', $this->session_info);
    }

    public function history_user(){

        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));
        $data['tgla'] = $tgla;
        $data['button'] = 'mobil';
        $data['tglb'] = $tglb;
    $id_user = $this->session->userdata('id_auth');
    $mobil = $this->m_mobil->get_peminjaman($tgla , $tglb);

    $data['id_user'] = $id_user;
    $data['langkah'] = 1;
    $data['page'] = 4;
    $data['mobil'] = $mobil;
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
    $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil";
    $this->template->build('history_user', $this->session_info);

    }

    public function history_user_laptop(){

        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
    $id_user = $this->session->userdata('id_auth');
    $mobil = $this->m_mobil->get_peminjaman_laptop($tgla , $tglb);

    $data['id_user'] = $id_user;
    $data['langkah'] = 1;
    $data['page'] = 4;
    $data['mobil'] = $mobil;
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
    $this->session_info['page_name'] = "Sistem Informasi Peminjaman Laptop (SI PELA)";
    $this->template->build('history_user_laptop', $this->session_info);

    }

    public function booking()
    {
        $data['langkah'] = 0;
        $this->load->vars($data);

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('rental_mobil', $this->session_info);
    }

    public function check_mobil($kat=null){
      switch($kat){
        case 'mobil':
         $judul = "Informasi Mobil Yang Tersedia";
         $button = "mobil";
         break;
        case 'laptop':
         $judul = "Informasi Laptop Yang Tersedia";
         $button = "laptop";
         break;
        default:
         $judul = "Informasi Mobil Yang Tersedia";
         $button = "mobil";
         break;
      }
        $date = date('Y-m-d g:i:s');
        $date1 = date("Ymdgis", strtotime($date));
        $tanggal = date("Ymd", strtotime($date));
        $jam = date("gis", strtotime($date));
        if (strlen($date1) < 6) {
            $date1 = $tanggal.'0'.$jam;
        }
        $tgla = $this->input->post('tgla').' '.date("G:i:s");
        $tglb = $this->input->post('tglb').' 23:59:59';
        $a = date("Ymdgis", strtotime($tgla));
        $tanggala = date("Ymd", strtotime($tgla));
        $jama = date("gis", strtotime($tgla));
        if (strlen($a) < 6) {
            $a = $tanggala.'0'.$jama;
        }
        $b = date("Ymdgis", strtotime($tglb));
        $tanggalb = date("Ymd", strtotime($tglb));
        $jamb = date("gis", strtotime($tglb));
        if (strlen($a) < 6) {
            $a = $tanggalb.'0'.$jamb;
        }
        // $c = $a - $b;
        // echo $a.' Lebih kecil '.$b.' = '.$c;die();
        if($a >= $b){
          $this->session->set_flashdata('gagal', "Tanggal Kembali harus di atas tanggal pinjam ");
          redirect('/peminjamanmobil/booking');
        }
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['button'] = $button;
        $mobil = $this->m_mobil->get_data($kat); 
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
        $peminjamanmobil = $this->m_mobil->get_data_peminjaman_mobil($idpegawai);
        $data['mobil'] = $mobil;
        $data['peminjamanmobil'] = $peminjamanmobil;
        $data['langkah'] = 0;
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
        $this->session_info['page_name'] = $judul;
        $this->template->build('check_mobil', $this->session_info);
    }

    public function pinjam_mobil($id, $tgla = NULL, $tglb = NULL)
    {
        $tgla = str_replace('_', ' ', $tgla);
        $tglb = str_replace('_', ' ', $tglb);
        $id_user = $this->session->userdata('id_auth');
        $data['mobil'] = $this->m_mobil->get_data_id($id);
        // $data['koot_tot'] = $this->m_mobil->koot_tot_id($id);
        $data['id'] = $id;
        $data['step'] = "edit_mobil";
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('pinjam_mobil', $this->session_info);
    }

    public function pinjam_laptop($id, $tgla = NULL, $tglb = NULL)
    {
        $tgla = str_replace('_', ' ', $tgla);
        $tglb = str_replace('_', ' ', $tglb);
        $id_user = $this->session->userdata('id_auth');
        $data['mobil'] = $this->m_mobil->get_data_id($id);
        // $data['koot_tot'] = $this->m_mobil->koot_tot_id($id);
        $data['id'] = $id;
        $data['step'] = "edit_mobil";
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Laptop";
        $this->template->build('pinjam_laptop', $this->session_info);
    }

    public function pinjammobil($id)
    {
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    // var_dump($routees, $root,$routees_portal,$master_url);
    $tanggal_pinjam = $this->input->post('tanggal_pinjam');
    $jam_pinjam = $this->input->post('jam_pinjam');
    $tanggal_kembali = $this->input->post('tanggal_kembali');
    $jam_kembali = $this->input->post('jam_kembali');
    $idpegawai = $this->input->post('idpegawai');
    $tujuan = $this->input->post('tujuan');
    $bagian = $this->input->post('bagian');
    if($bagian == 'lainnya'){
    $bagian = $this->input->post('bagian_lainnya');
    }
    $driver = $this->input->post('driver');
    $mobilnya = $this->m_mobil->get_data_list_peminjaman($id);
    $date_now = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date_now)));
    // Check if the booking is on Thursday or Friday
    $day_of_week = date('N', strtotime($tanggal_pinjam));
    $day_of_week2 = date('N', strtotime($tanggal_kembali));
    // if ($day_of_week == 4 || $day_of_week == 5 || $day_of_week2 == 4 || $day_of_week2 == 5) {
    //     $this->session->set_flashdata('gagal', "Nol Emisi : Mobil tidak dapat dipinjam pada hari Kamis atau Jumat.");
    //     redirect('/peminjamanmobil/pinjam_mobil/'.$id);
    // }

    // Check if the booking date is in the past
    if ($tanggal_pinjam <= $yesterday) {
        $this->session->set_flashdata('gagal', "Periksa tanggal Berangkat anda");
        redirect('/peminjamanmobil/pinjam_mobil/'.$id);
    }

    // Check for conflicts with existing bookings
    foreach ($mobilnya as $row) {
        if ($tanggal_pinjam.' '.$jam_pinjam >= $row->tanggal_pinjam && $tanggal_pinjam.' '.$jam_pinjam <= $row->tanggal_kembali) {
            $this->session->set_flashdata('gagal', "Mobil Sudah di booking pada tanggal tersebut Oleh " . $row->bagian . ' Ke ' . $row->tujuan);
            redirect('/peminjamanmobil/pinjam_mobil/'.$id);
        }
        if ($tanggal_kembali <= $row->tanggal_kembali && $tanggal_kembali >= $row->tanggal_pinjam) {
            $this->session->set_flashdata('gagal', "Mobil Sudah di booking pada tanggal tersebut Oleh " . $row->bagian . ' Ke ' . $row->tujuan);
            redirect('/peminjamanmobil/pinjam_mobil/'.$id);
        }
    }

    // Proceed with booking logic here if all checks pass

        $status = 0;
        $simpan = $this->m_mobil->pinjam_mobil($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver,$jam_pinjam,$jam_kembali);

        redirect($master_url.'/'.$routees.'persuratan/mobil/'.$simpan);
    }

    public function pinjamlaptop($id)
    {
        $tanggal_pinjam = $this->input->post('tanggal_pinjam');
        $jam_pinjam = $this->input->post('jam_pinjam');
        $tanggal_kembali = $this->input->post('tanggal_kembali');
        $jam_kembali = $this->input->post('jam_kembali');
        $idpegawai = $this->input->post('idpegawai');
        $tujuan = $this->input->post('tujuan');
        $bagian = $this->input->post('bagian');
        $driver = $this->input->post('driver');
        $mobilnya = $this->m_mobil->get_data_list_peminjaman($id);
        $date_now = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date_now)));
        if($tanggal_pinjam <= $yesterday){
          $this->session->set_flashdata('gagal', "Periksa tanggal Berangkat anda");
          redirect('/peminjamanmobil/pinjam_laptop/'.$id);
        }
        foreach ($mobilnya as $row) {
          if($tanggal_pinjam.' '.$jam_pinjam >= $row->tanggal_pinjam && $tanggal_pinjam.' '.$jam_pinjam <= $row->tanggal_kembali){
          $this->session->set_flashdata('gagal', "Laptop Sudah di booking pada tanggal tersebut Oleh ". $row->bagian.' Ke '.$row->tujuan);
          redirect('/peminjamanmobil/pinjam_laptop/'.$id);
          }
          if($tanggal_kembali <= $row->tanggal_kembali && $tanggal_kembali >= $row->tanggal_pinjam){
          $this->session->set_flashdata('gagal', "Laptop Sudah di booking pada tanggal tersebut Oleh ". $row->bagian.' Ke '.$row->tujuan);
          redirect('/peminjamanmobil/pinjam_laptop/'.$id);
          }
        }
        $status = 0;
        $simpan = $this->m_mobil->pinjam_mobil($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver,$jam_pinjam,$jam_kembali);
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        redirect($master_url.'/'.$routees.'persuratan/laptop/'.$simpan);
        // redirect('/peminjamanmobil/approve_old_laptop/'.$simpan);
    }

    public function editpinjammobil($id)
    {
        $tanggal_pinjam = $this->input->post('tanggal_pinjam');
        $jam_pinjam = $this->input->post('jam_pinjam');
        $tanggal_kembali = $this->input->post('tanggal_kembali');
        $jam_kembali = $this->input->post('jam_kembali');
        $idpegawai = $this->input->post('idpegawai');
        $tujuan = $this->input->post('tujuan');
        $bagian = $this->input->post('bagian');
        $driver = $this->input->post('driver');
        $kategori = $this->input->post('kategori');
        $mobilnya = $this->m_mobil->get_data_list_peminjaman($id);
          foreach ($mobilnya as $row) {
            if($tanggal_pinjam.' '.$jam_pinjam >= $row->tanggal_pinjam && $tanggal_pinjam.' '.$jam_pinjam <= $row->tanggal_kembali){
              $this->session->set_flashdata('gagal', "Mobil Sudah di booking pada tanggal tersebut Oleh ". $row->bagian.' Ke '.$row->tujuan);
              redirect('/peminjamanmobil/pinjam_mobil/'.$id);
            }
            if($tanggal_kembali <= $row->tanggal_kembali && $tanggal_kembali >= $row->tanggal_pinjam){
              $this->session->set_flashdata('gagal', "Mobil Sudah di booking pada tanggal tersebut Oleh ". $row->bagian.' Ke '.$row->tujuan);
              redirect('/peminjamanmobil/pinjam_mobil/'.$id);
            }
          }
        $status = 10;
        $simpan = $this->m_mobil->edit_pinjam_mobil($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver,$jam_pinjam,$jam_kembali);
        if($simpan){
        redirect('/persuratan/hapus_mobil/'.$id.'/'.$kategori);
        }
    }

    public function kembali($id)
    {
        $status = 2;
        $this->m_mobil->kembali_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Mobil Berhasil Di Kembalikan");
        redirect('/peminjamanmobil/history_user');
    }

    public function kembali_laptop($id)
    {
        $status = 2;
        $this->m_mobil->kembali_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Mobil Berhasil Di Kembalikan");
        redirect('/peminjamanmobil/history_user_laptop');
    }

    public function confirm_kembali($id)
    {
        $status = 3;
        $this->m_mobil->kembali_mobil($id, $status);
        $this->session->set_flashdata('sukses', "Mobil Berhasil Di Kembalikan");
        redirect('/peminjamanmobil/rekap');
    }

    public function confirm_kembali_laptop($id)
    {
        $status = 3;
        $this->m_mobil->kembali_laptop($id, $status);
        $this->session->set_flashdata('sukses', "Laptop Berhasil Di Kembalikan");
        redirect('/peminjamanmobil/rekap_laptop');
    }

    public function pinjam_index() {
        $data['cars'] = $this->m_mobil->get_all_cars();
        $this->load->view('booking_form', $data);
    }

    public function book_car() {
        $car_id = $this->input->post('car_id');
        $user_name = $this->input->post('user_name');
        $booking_date = $this->input->post('booking_date');

        $car = $this->m_mobil->get_car_by_id($car_id);

        $booking_data = array(
            'car_id' => $car_id,
            'user_name' => $user_name,
            'booking_date' => $booking_date
        );

        $booking_id = $this->m_mobil->create_booking($booking_data);

        // Lakukan tindakan lain, seperti mengirim email konfirmasi dll.

        $data['car'] = $car;
        $data['booking_id'] = $booking_id;
        $this->load->view('booking_success', $data);
    }

    public function berita_acara($id){ // berita acara

        $mobil = $this->m_mobil->get_mobil_master($id);
        $id_user = $this->session->userdata('id_auth');
        $data['mobil'] = $mobil;
        $data['id_user'] = $id_user;
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
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('pdf_ba', $this->session_info);
    }

    public function cetak_pengeluaran(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $mobil = $this->m_mobil->get_laporan_excel($bulan, $tahun);
        $data['mobil'] = $mobil;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi Peminjaman Mobil (SI PEMO)";
        $this->template->build('cetak_excel', $this->session_info);
    }

}