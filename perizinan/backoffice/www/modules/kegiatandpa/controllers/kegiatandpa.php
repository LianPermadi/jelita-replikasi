<?php
/*
 * Created By : Arif / 23-01-2024 
 */

class Kegiatandpa extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();
    $this->load->model("m_renaksi");
    $this->load->library('fpdf');
    $base_url = base_url();
    $enabled = FALSE;
    $this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '53') {
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
      // if ($list_auth->id_role === '33') {
      //   $this->Penomoran_surat = TRUE;
      // }
    }
    
    if (!$enabled) {
        redirect('dashboard');
    }
  }

  public function index() { 
    $renaksi = $this->m_renaksi->get_renaksi();
    // var_dump($renaksi); die();
    $kinerja = $this->m_renaksi->get_targetkinerja(); 

    $data['renaksi'] = $renaksi;
    $data['kinerja'] = $kinerja;
    // var_dump($kinerja); die();
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
    $this->session_info['page_name'] = "Rencana Aksi";
    $this->template->build('v_renaksi', $this->session_info);
  }

  public function print_excel_renaksi(){

      $iduser = $this->session->userdata('id_auth');
      if ($this->All  || $iduser == 553) {
        $admin = 1;
      } else {
        $admin = 0;
      }

        $pakai = $this->m_renaksi->get_data_cetak_excel($iduser, $admin);
        // var_dump($pakai);die;
        $data['pakai'] = $pakai;
        $data['title'] = 'Template Form Monitoring Realisasi Rencana Aksi Kinerja DPMPTSP Tahun 2024';
        $data['jdl_laporan'] = 'Template Form Monitoring Realisasi Rencana Aksi Kinerja DPMPTSP Tahun 2024';
        $this->load->vars($data);

     $this->load->view('laporan_excel_renaksi',$data);
     }

  public function tot() { 
    $tim = $this->m_renaksi->get_master();
    $data['admin'] = $this->All;
    $data['tim'] = $tim;
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
    $this->session_info['page_name'] = "Master Tim Of Tim";
    $this->template->build('master_list', $this->session_info);
  }

  public function renaksi() {
  $data['admin'] = $this->All; 
    $program = $this->m_renaksi->get_program();
    $kinerja = $this->m_renaksi->get_targetkinerja();

    $data['program'] = $program;
    $data['kinerja'] = $kinerja;
    // var_dump($kinerja); die();
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
    $this->session_info['page_name'] = "Sasaran Program";
    $this->template->build('v_program', $this->session_info);
  }

  public function add_realisasi_anggaran($id) {
   $data['id'] = $id;
    $data['tim'] = $this->m_renaksi->get_master();
    $data['anggaran_program'] = $this->m_renaksi->get_anggaran_program($id);
    $data['total_realisasii'] = $this->m_renaksi->get_total_anggaran_program($id);
    $data['program'] = $this->m_renaksi->get_dataprogram_id($id);
    $program = $this->m_renaksi->get_dataprogram_id($id);
    // var_dump($program);die();
    $data['step'] = "anggaran_simpan";

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

            function confirm_link(text){
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

        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Input Realisasi Anggaran Program";
    $this->template->build('add_r_anggaran', $this->session_info);
  }

  
  public function tim_add() {
    $petugas = new tmpegawai();
    $data['koor'] = $this->m_renaksi->get_set_koor();
    $data['katim'] = $this->m_renaksi->get_set_ketua();
    $data['kodering'] = $this->m_renaksi->get_kode_ring();
    $data['kodering_sub'] = $this->m_renaksi->get_kode_ring_subkeg();
    // $data['list'] = $petugas->where('unitkerja_id', 1)
    //                     ->order_by('golongan', "DESC")
    //                     ->get();
    $data['list'] = $petugas->order_by('golongan', "DESC")
                        ->get();

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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Tim Of Tim";
    $this->template->build('master_edit', $this->session_info);
  }

  public function tot_ubah($id) {
    $data['id'] = $id;
    $data['katim'] = $this->m_renaksi->get_set_ketua();
    $data['koor'] = $this->m_renaksi->get_set_koor();
    $data['tim'] = $this->m_renaksi->get_datamaster($id);
    $data['pil_anggota'] = $this->m_renaksi->get_anggota($id);
    $data['pegawai'] = $this->m_renaksi->get_pegawai($id);
    $data['anggota'] = $this->m_renaksi->get_anggota_tim2($id);
    $data['kodering'] = $this->m_renaksi->get_kode_ring();
    $data['kodering_sub'] = $this->m_renaksi->get_kode_ring_subkeg();
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Data Tim Of Tim";
    $this->template->build('master_edit', $this->session_info);
  }

  public function unduh_sk($id){
    $sk = $this->m_renaksi->get_masterid($id);

    $kepada = $sk->id;
    $nama_tim = $sk->nama_tim;
    // var_dump($sk); die();
// $fileBaru = $target_dir.'SK_Tim_'.$nama_tim.'_'.$id.'.'.$ext;
    $file = "SK_Tim_".$nama_tim."_".$id;
    $data = file_get_contents('assets/tot/sk/'.$file.'.pdf');
    force_download('SK_Tim_'.$nama_tim.'_'.$kepada.'.pdf', $data);
    }

    public function hapus_sk($id) {
    $sk = $this->m_renaksi->get_masterid($id);
    $nama_tim = $sk->nama_tim;

    $hapus = unlink('assets/tot/sk/SK_Tim_'.$nama_tim.'_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('kegiatandpa/tot_ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('kegiatandpa/tot_ubah/'.$id);
    }
  }

  public function subrenaksi($id) { 
    $subrenaksi = $this->m_renaksi->get_sub_renaksi();
    $kinerja = $this->m_renaksi->get_targetkinerja();
    $data['tim'] = $this->m_renaksi->get_master();


    $data['renaksi'] = $this->m_renaksi->get_datarenaksi($id);
    $data['subrenaksi'] = $subrenaksi;
    $data['kinerja'] = $kinerja;
    // var_dump($kinerja); die();
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
    $this->session_info['page_name'] = "Add Sub Renaksi";
    $this->template->build('v_subrenaksi', $this->session_info);
  }

  // public function add_subrenaksi($id) {
  //   $data['id'] = $id;
  //   $data['subrenaksi'] = $this->m_renaksi->get_sub_renaksi($id);
  //   $kd_tim = $this->m_renaksi->get_kdtim($id);
  //   $data['tim'] = $this->m_renaksi->get_master();
  //   $data['renaksi'] = $this->m_renaksi->get_datarenaksi($id);
  //   $tes_anggota = $this->m_renaksi->get_anggota_tim2($kd_tim);
  //   $data['anggota'] = $this->m_renaksi->get_anggota_tim2($kd_tim);
  //   $data['step'] = "subrenaksi_simpan";
    
  //   $js =  "
  //           $(document).ready(function() {
  //               $(\"#tabs\").tabs();
  //               $('.monbulan').datepicker({
  //                   changeMonth: true,
  //                   changeYear: true,
  //                   dateFormat: 'yy-mm-dd',
  //                   closeText: 'X'
  //               });
  //               $('#form').validate();
  //               $('.pilihan').select2();
  //           });
    
  //           function finishAjax(id, response){
  //               $('#'+id).html(unescape(response));
  //               $('#'+id).fadeIn();
  //           }

  //           function confirm_link(text){
  //           if(confirm(text)){ return true;
  //           }else{ return false; }
  //         }
          
  //         $(document).ready(function() {
  //           oTable = $('#pendataan').dataTable({
  //             \"bJQueryUI\": true,
  //             \"sPaginationType\": \"full_numbers\"
  //           });
  //         });
  //         $(function() {
  //           $(\".monbulan\").datepicker({
  //             changeMonth: true,
  //             changeYear: true,
  //             dateFormat: 'yy-mm-dd',
  //             closeText: 'X'
  //           });
  //           $('#form').validate();
  //         });

  //       ";
    
  //   $this->template->set_metadata_javascript($js);
  //   $this->load->vars($data);
  //   $this->session_info['page_name'] = "Tambah Anggota Untuk Renaksi";
  //   $this->template->build('subrenaksi_edit', $this->session_info);
  // }

  public function edit_subrenaksi($id) {
    $data['id'] = $id;
    $data['tim'] = $this->m_renaksi->get_master();
     $data['renaksi'] = $this->m_renaksi->get_datarenaksi($id);
    $data['subrenaksi'] = $this->m_renaksi->get_subrenaksi_id($id);
    $data['step'] = "sub_renaksi_update";

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
    $this->session_info['page_name'] = "Ubah Renaksi Tim Of Tim";
    $this->template->build('sub_renaksi_ubah', $this->session_info);
  }

  public function hapus_tot($id) {

    $sk = $this->m_renaksi->get_nama_tim($id);
    $hapus_sk = unlink('assets/tot/sk/SK_Tim_'.$sk.'_'.$id.'.pdf');
    $hapus = $this->m_renaksi->hapus_tot($id);

    // var_dump($hapus_sk); die();

    if ($hapus_sk && $hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/tot');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/tot');
    }
  }

  public function hapus_program($id) {
    $hapus = $this->m_renaksi->hapus_program($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/renaksi');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function hapus_renaksi($id, $id_buat) {
    $hapus = $this->m_renaksi->hapus_renaksi($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/buat_renaksi/'.$id_buat);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/buat_renaksi/'.$id_buat);
    }
  }

  public function hapus_sub_renaksi($id) {
    $hapus = $this->m_renaksi->hapus_sub_renaksi($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa');
    }
  }

  public function hapus_r_anggaran($id) {
    $hapus = $this->m_renaksi->hapus_r_anggaran($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/renaksi');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function program_add() {
    $data['tim'] = $this->m_renaksi->get_master();
    $data['step'] = "program_simpan";
    
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
    $this->session_info['page_name'] = "Tambah Data Sasaran Tim Of Tim";
    $this->template->build('program_edit', $this->session_info);
  }

  public function program_ubah($id) {
    $data['tim'] = $this->m_renaksi->get_master();
    $data['program'] = $this->m_renaksi->get_dataprogram($id);
    $data['step'] = "program_update";

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
    $this->session_info['page_name'] = "Ubah Sasaran Tim Of Tim";
    $this->template->build('program_edit', $this->session_info);
  }

  public function program_simpan() {
    $id_user = $this->session->userdata('id_auth');
    $id_tim = $this->input->post('id_tim');
    $sasaran       = $this->input->post('sasaran');
    $indikator    = $this->input->post('indikator');
    $target_tahun    = $this->input->post('target_tahun');
    $satuan       = $this->input->post('satuan');
    $t1       = $this->input->post('t1');
    $t2       = $this->input->post('t2');
    $t3       = $this->input->post('t3');
    $t4       = $this->input->post('t4');
    $t5       = $this->input->post('t5');
    $t6       = $this->input->post('t6');
    $t7       = $this->input->post('t7');
    $t8       = $this->input->post('t8');
    $t9       = $this->input->post('t9');
    $t10       = $this->input->post('t10');
    $t11       = $this->input->post('t11');
    $t12       = $this->input->post('t12');
    $r1       = $this->input->post('r1');
    $r2       = $this->input->post('r2');
    $r3       = $this->input->post('r3');
    $r4       = $this->input->post('r4');
    $r5       = $this->input->post('r5');
    $r6       = $this->input->post('r6');
    $r7       = $this->input->post('r7');
    $r8       = $this->input->post('r8');
    $r9       = $this->input->post('r9');
    $r10       = $this->input->post('r10');
    $r11       = $this->input->post('r11');
    $r12       = $this->input->post('r12');
    
    $simpan = $this->m_renaksi->save_program($id_user, $id_tim, $sasaran, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);
    // var_dump($simpan); die();
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function anggaran_simpan() {
    $program_id       = $this->input->post('id');
    $kegiatan    = $this->input->post('kegiatan');
    $tanggal    = $this->input->post('tanggal');
    $r_anggaran       = $this->input->post('r_anggaran');
    $keterangan       = $this->input->post('keterangan');

    
    $simpan = $this->m_renaksi->save_r_anggaran($program_id, $kegiatan, $tanggal, $r_anggaran, $keterangan);
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function program_update() {
    $id           = $this->input->post('id');
    $id_user = $this->session->userdata('id_auth');
    $id_tim = $this->input->post('id_tim');
    $sasaran       = $this->input->post('sasaran');
    $indikator    = $this->input->post('indikator');
    $target_tahun    = $this->input->post('target_tahun');
    $satuan       = $this->input->post('satuan');
    $t1       = $this->input->post('t1');
    $t2       = $this->input->post('t2');
    $t3       = $this->input->post('t3');
    $t4       = $this->input->post('t4');
    $t5       = $this->input->post('t5');
    $t6       = $this->input->post('t6');
    $t7       = $this->input->post('t7');
    $t8       = $this->input->post('t8');
    $t9       = $this->input->post('t9');
    $t10       = $this->input->post('t10');
    $t11       = $this->input->post('t11');
    $t12       = $this->input->post('t12');
    $r1       = $this->input->post('r1');
    $r2       = $this->input->post('r2');
    $r3       = $this->input->post('r3');
    $r4       = $this->input->post('r4');
    $r5       = $this->input->post('r5');
    $r6       = $this->input->post('r6');
    $r7       = $this->input->post('r7');
    $r8       = $this->input->post('r8');
    $r9       = $this->input->post('r9');
    $r10       = $this->input->post('r10');
    $r11       = $this->input->post('r11');
    $r12       = $this->input->post('r12');
    
    $simpan = $this->m_renaksi->update_program($id, $id_user, $id_tim, $sasaran, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);

    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function buat_renaksi($id) {
    $data['id'] = $id;
    $data['rencana_aksi'] = $this->m_renaksi->get_renaksi($id);
    $kd_tim = $this->m_renaksi->get_kdtim_prog($id);
    $data['tim'] = $this->m_renaksi->get_master();
    $data['program'] = $this->m_renaksi->get_dataprogram_id($id);
    $tes_anggota = $this->m_renaksi->get_anggota_tim2($kd_tim);
    $data['anggota'] = $this->m_renaksi->get_anggota_tim2($kd_tim);
    $data['step'] = "subrenaksi_simpan";
    
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

            function confirm_link(text){
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

          $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });

          document.addEventListener('DOMContentLoaded', function () {
            var toggleCheckbox = document.getElementById('toggleField');
            var myInput = document.getElementById('myInput');
            var originalValue = myInput.value; // Simpan nilai asli

            // Cek apakah nilai myInput kosong atau tidak
            if (originalValue.trim() !== '') {
                toggleCheckbox.checked = true; // Jika tidak kosong, tandai checkbox
            }

            toggleCheckbox.addEventListener('change', function () {
                myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
                if (toggleCheckbox.checked) {
                    myInput.value = originalValue; // Jika checkbox dicentang, kembalikan nilai asli
                } else {
                    myInput.value = ''; // Jika tidak dicentang, kosongkan nilai
                }
            });

            myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
        });

        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Susun Rencana Aksi";
    $this->template->build('v_buat_renaksi', $this->session_info);
  }

  public function edit_rencana_aksi($id, $pic = NULL) {
    // $data['pic'] = base64_decode($pic);
    // var_dump($pic); die();
    $data['id'] = $id;
    $data['tim'] = $this->m_renaksi->get_master();
    $data['rencana_aksi'] = $this->m_renaksi->get_renaksi($id);
     $data['renaksi'] = $this->m_renaksi->get_datarenaksi_id($id);
     $data['anggota'] = $this->m_renaksi->get_anggota_tim2($pic);
    $data['step'] = "subrenaksi_update";

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

            document.addEventListener('DOMContentLoaded', function () {
            var toggleCheckbox = document.getElementById('toggleField');
            var myInput = document.getElementById('myInput');
            var originalValue = myInput.value; // Simpan nilai asli

            // Cek apakah nilai myInput kosong atau tidak
            if (originalValue.trim() !== '') {
                toggleCheckbox.checked = true; // Jika tidak kosong, tandai checkbox
            }

            toggleCheckbox.addEventListener('change', function () {
                myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
                if (toggleCheckbox.checked) {
                    myInput.value = originalValue; // Jika checkbox dicentang, kembalikan nilai asli
                } else {
                    myInput.value = ''; // Jika tidak dicentang, kosongkan nilai
                }
            });

            myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
        });
        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Renaksi Tim Of Tim";
    $this->template->build('v_ubah_renaksi', $this->session_info);
  }

  public function renaksi_add() {
    $data['tim'] = $this->m_renaksi->get_master();
    $data['step'] = "renaksi_simpan";
    
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
    $this->session_info['page_name'] = "Tambah Data renaksi Tim Of Tim";
    $this->template->build('renaksi_edit', $this->session_info);
  }

  public function renaksi_ubah($id) {
    $data['tim'] = $this->m_renaksi->get_master();
    $data['renaksi'] = $this->m_renaksi->get_datarenaksi_id($id);
    $data['step'] = "renaksi_update";

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
    $this->session_info['page_name'] = "Ubah Renaksi Tim Of Tim";
    $this->template->build('renaksi_edit', $this->session_info);
  }

  public function renaksi_simpan() {
    $id_tim = $this->input->post('id_tim');
    $aktivitas       = $this->input->post('aktivitas');
    $indikator    = $this->input->post('indikator');
    $target_tahun    = $this->input->post('target_tahun');
    $satuan       = $this->input->post('satuan');
    $t1       = $this->input->post('t1');
    $t2       = $this->input->post('t2');
    $t3       = $this->input->post('t3');
    $t4       = $this->input->post('t4');
    $t5       = $this->input->post('t5');
    $t6       = $this->input->post('t6');
    $t7       = $this->input->post('t7');
    $t8       = $this->input->post('t8');
    $t9       = $this->input->post('t9');
    $t10       = $this->input->post('t10');
    $t11       = $this->input->post('t11');
    $t12       = $this->input->post('t12');
    $r1       = $this->input->post('r1');
    $r2       = $this->input->post('r2');
    $r3       = $this->input->post('r3');
    $r4       = $this->input->post('r4');
    $r5       = $this->input->post('r5');
    $r6       = $this->input->post('r6');
    $r7       = $this->input->post('r7');
    $r8       = $this->input->post('r8');
    $r9       = $this->input->post('r9');
    $r10       = $this->input->post('r10');
    $r11       = $this->input->post('r11');
    $r12       = $this->input->post('r12');
    
    $simpan = $this->m_renaksi->save_renaksi($id_tim, $aktivitas, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);
    // var_dump($simpan); die();
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa');
    }
  }

  public function subrenaksi_simpan() {
    $id_user = $this->session->userdata('id_auth');
    $program_id = $this->input->post('id');
    $renaksi       = $this->input->post('renaksi');

    $pkepada      = $this->input->post('u_anggota');
    $pkepada = implode('^', $pkepada);
          if($pkepada){
            $pic  = ($pkepada ? $pkepada : Array());
            if (!empty($pic)) {

    
    $r_anggaran       = $this->input->post('r_anggaran');
    $target_aktivitas       = $this->input->post('target_aktivitas');
    $satuan       = $this->input->post('satuan');
    $tgl_rencana       = $this->input->post('tgl_rencana');
    $tgl_realisasi       = $this->input->post('tgl_realisasi');
    $keterangan       = $this->input->post('keterangan');

    
    $simpan = $this->m_renaksi->save_renaksi($id_user, $program_id, $renaksi, $pic, $r_anggaran, $target_aktivitas, $satuan, $tgl_rencana, $tgl_realisasi, $keterangan);
    // var_dump($simpan); die();
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/buat_renaksi/'.$program_id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }
}
}

public function subrenaksi_simpan_tes() {
    $id_user = $this->session->userdata('id_auth');
    $program_id = $this->input->post('id');
    $renaksi       = $this->input->post('renaksi');

    $pkepada      = $this->input->post('u_anggota');
    $pkepada = implode('^', $pkepada);
          if($pkepada){
            $pic  = ($pkepada ? $pkepada : Array());
            if (!empty($pic)) {

    
    $r_anggaran       = $this->input->post('r_anggaran');
    $target_aktivitas       = $this->input->post('target_aktivitas');
    $satuan       = $this->input->post('satuan');
    $tgl_rencana       = $this->input->post('tgl_rencana');
    $tgl_realisasi       = $this->input->post('tgl_realisasi');
    $keterangan       = $this->input->post('keterangan');
    // var_dump($keterangan); die();
    foreach ($keterangan as $ket) {
      $save_ket = $this->m_renaksi->save_ket($ket, $program_id);
    }
    // var_dump($save_ket); die();

    
    $simpan = $this->m_renaksi->save_renaksi($id_user, $program_id, $renaksi, $pic, $r_anggaran, $target_aktivitas, $satuan, $tgl_rencana, $tgl_realisasi, $keterangan);
    // var_dump($simpan); die();
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/buat_renaksi/'.$program_id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }
}
}

  public function subrenaksi_update() {
    $id = $this->input->post('id');
    $id_user = $this->session->userdata('id_auth');
    $program_id = $this->input->post('program_id');
    $renaksi       = $this->input->post('renaksi');

    $pkepada      = $this->input->post('u_anggota');
    $pic       = implode('^', $pkepada);

    $r_anggaran       = $this->input->post('r_anggaran');
    $target_aktivitas       = $this->input->post('target_aktivitas');
    $satuan       = $this->input->post('satuan');
    $tgl_rencana       = $this->input->post('tgl_rencana');
    $tgl_realisasi       = $this->input->post('tgl_realisasi');
    $keterangan       = $this->input->post('keterangan');

    
    $simpan = $this->m_renaksi->update_renaksi($id, $id_user, $program_id, $renaksi, $pic, $r_anggaran, $target_aktivitas, $satuan, $tgl_rencana, $tgl_realisasi, $keterangan);
    // var_dump($simpan); die();
    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa/buat_renaksi/'.$program_id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa/renaksi');
    }
  }

  public function renaksi_updatee() {
    $id           = $this->input->post('id');
    $id_tim = $this->input->post('id_tim');
    $aktivitas       = $this->input->post('aktivitas');
    $indikator    = $this->input->post('indikator');
    $target_tahun    = $this->input->post('target_tahun');
    $satuan       = $this->input->post('satuan');
    $t1       = $this->input->post('t1');
    $t2       = $this->input->post('t2');
    $t3       = $this->input->post('t3');
    $t4       = $this->input->post('t4');
    $t5       = $this->input->post('t5');
    $t6       = $this->input->post('t6');
    $t7       = $this->input->post('t7');
    $t8       = $this->input->post('t8');
    $t9       = $this->input->post('t9');
    $t10       = $this->input->post('t10');
    $t11       = $this->input->post('t11');
    $t12       = $this->input->post('t12');
    $r1       = $this->input->post('r1');
    $r2       = $this->input->post('r2');
    $r3       = $this->input->post('r3');
    $r4       = $this->input->post('r4');
    $r5       = $this->input->post('r5');
    $r6       = $this->input->post('r6');
    $r7       = $this->input->post('r7');
    $r8       = $this->input->post('r8');
    $r9       = $this->input->post('r9');
    $r10       = $this->input->post('r10');
    $r11       = $this->input->post('r11');
    $r12       = $this->input->post('r12');
    
    $simpan = $this->m_renaksi->update_renaksi($id, $id_tim, $aktivitas, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);

    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('kegiatandpa');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('kegiatandpa');
    }
  }

public function master_simpan() {
      $id_user = $this->session->userdata('id_auth');

      $pkepada      = $this->input->post('anggota');

      $user_kepada  = ($pkepada ? $pkepada : Array());
      $nama_tim = $this->input->post('nama_tim');
      $pengampu       = $this->input->post('pengampu');
      $ketua    = $this->input->post('ketua');
      $anggota       = implode('^', $pkepada);
      $anggaran       = $this->input->post('anggaran');
      $realisasi_anggaran       = $this->input->post('realisasi_anggaran');
      $kode_ring       = $this->input->post('kode_ring');
      $tahun       = $this->input->post('tahun');

      $simpan = $this->m_renaksi->save_tot($id_user,$nama_tim, $pengampu, $ketua, $anggota, $anggaran, $realisasi_anggaran, $kode_ring, $tahun);
      // var_dump($simpan);die();
        if($simpan != 0) {
          if (!empty($user_kepada)) {
            foreach ($user_kepada as $row) {
              $simpan_anggota = $this->m_renaksi->save_anggota($simpan, $row, $tahun);

              if(!$simpan_anggota) {
                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data Anggota");
                redirect('kegiatandpa/tot');
              }
            }
          }

          $id = $simpan;
          $file = $_FILES["file_srt"]["name"];
          $file_name = basename($_FILES["file_srt"]["name"]);
          $ext = pathinfo($file, PATHINFO_EXTENSION);

          $target_dir = "assets/tot/sk/";
          $target_file = $target_dir . $file_name;

          // Cek dan buat folder kalau belum ada
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0755, true); // rekursif, biar bisa buat subfolder juga
          }

          $fileBaru = $target_dir . 'SK_Tim_' . $nama_tim . '_' . $id . '.' . $ext;

          // Pindahkan file ke folder tujuan
          $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);


          // var_dump($upload); die();
 
          if($upload) {
            $rnm = rename($target_file, $fileBaru);
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
            redirect('kegiatandpa/tot');
          }else{
            $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Tetapi Gagal Menggunggah File Dokumen.");
            redirect('kegiatandpa/tot');
          }
          // $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          // redirect('kegiatandpa/tot');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/tot');
        }
      }
    

// public function master_simpan() {
//     $pkepada      = $this->input->post('anggota');
//             // $user_kepada  = ($pkepada ? $pkepada : Array());
//             if (!empty($pkepada)) {
//               $anggota_save = array();
//                 foreach ($pkepada as $row) {
//     $anggota_save = array('anggota' => $row);
//   }
//     $nama_tim = $this->input->post('nama_tim');
//     $pengampu       = $this->input->post('pengampu');
//     $ketua    = $this->input->post('ketua');
//     // $anggota    = $this->input->post('anggota');
//     $anggaran       = $this->input->post('anggaran');
    
//     $simpan = $this->m_renaksi->save_tot($nama_tim, $pengampu, $ketua, $anggota_save, $anggaran);
//     if ($simpan) {
//       $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
//       redirect('kegiatandpa/tot');
//     } else {
//       $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
//       redirect('kegiatandpa/tot');
//     }
// }}

  public function master_update() {
      $id           = $this->input->post('id');
      $id_user = $this->session->userdata('id_auth');
      $pkepada      = $this->input->post('u_anggota');

      $user_kepada  = ($pkepada ? $pkepada : Array());
      $nama_tim = $this->input->post('nama_tim');
      $pengampu       = $this->input->post('pengampu');
      $ketua    = $this->input->post('ketua');
      $anggota       = implode('^', $pkepada);
      $anggaran       = $this->input->post('anggaran');
      $realisasi_anggaran       = $this->input->post('realisasi_anggaran');
      $kode_ring       = $this->input->post('kode_ring');
      $tahun       = $this->input->post('tahun');

    $simpan = $this->m_renaksi->update_tot($id, $id_user, $nama_tim, $pengampu, $ketua,$anggota, $anggaran, $realisasi_anggaran, $kode_ring, $tahun);
    // var_dump($simpan); die();
    if($simpan != 0) {
          if (!empty($user_kepada)) {
            $unlink = $this->m_renaksi->hapus_anggota($id);
            foreach ($user_kepada as $row) {
              $simpan_anggota = $this->m_renaksi->save_anggota($id, $row, $tahun);

              if(!$simpan_anggota) {
                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data Anggota");
                redirect('kegiatandpa/tot');
              }
            }
          }

          $file = $_FILES["file_srt"]["name"];
          $file_name = basename($_FILES["file_srt"]["name"]);
          $ext = pathinfo($file, PATHINFO_EXTENSION);

          $target_dir = "assets/tot/sk/";

          // Cek dan buat folder kalau belum ada
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0755, true); // Buat folder dengan akses penuh
          }

          $target_file = $target_dir . $file_name;
          $fileBaru = $target_dir . 'SK_Tim_' . $nama_tim . '_' . $id . '.' . $ext;

          // Upload file
          $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);

          // var_dump($upload); die();
 
          if($upload) {
            $rnm = rename($target_file, $fileBaru);
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
            redirect('kegiatandpa/tot');
          }else{
            $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Tetapi Gagal Menggunggah File Dokumen.");
            redirect('kegiatandpa/tot');
          }
          // $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          // redirect('kegiatandpa/tot');
         
          // $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          // redirect('kegiatandpa/tot');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/tot');
        }
   
}

public function aktivitas() {
  $data['admin'] = $this->All; 
    $program = $this->m_renaksi->get_program();
    $kinerja = $this->m_renaksi->get_targetkinerja();

    $data['program'] = $program;
    $data['kinerja'] = $kinerja;
    // var_dump($kinerja); die();
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
    $this->session_info['page_name'] = "Sasaran Program";
    $this->template->build('v_program_tes', $this->session_info);
  }

  public function buat_renaksi_tes($id) {
    $data['id'] = $id;
    $data['rencana_aksi'] = $this->m_renaksi->get_renaksi($id);
    $kd_tim = $this->m_renaksi->get_kdtim_prog($id);
    $data['tim'] = $this->m_renaksi->get_master();
    $data['program'] = $this->m_renaksi->get_dataprogram_id($id);
    $tes_anggota = $this->m_renaksi->get_anggota_tim2($kd_tim);
    $data['anggota'] = $this->m_renaksi->get_anggota_tim2($kd_tim);
    $data['step'] = "subrenaksi_simpan";
    
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

            function confirm_link(text){
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

          $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });

          document.addEventListener('DOMContentLoaded', function () {
            var toggleCheckbox = document.getElementById('toggleField');
            var myInput = document.getElementById('myInput');
            var originalValue = myInput.value; // Simpan nilai asli

            // Cek apakah nilai myInput kosong atau tidak
            if (originalValue.trim() !== '') {
                toggleCheckbox.checked = true; // Jika tidak kosong, tandai checkbox
            }

            toggleCheckbox.addEventListener('change', function () {
                myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
                if (toggleCheckbox.checked) {
                    myInput.value = originalValue; // Jika checkbox dicentang, kembalikan nilai asli
                } else {
                    myInput.value = ''; // Jika tidak dicentang, kosongkan nilai
                }
            });

            myInput.style.display = toggleCheckbox.checked ? 'block' : 'none';
        });

        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Susun Rencana Aksi";
    $this->template->build('v_buat_renaksi_tes', $this->session_info);
  }

  public function set_koor() { 
    $koor = $this->m_renaksi->get_set_koor();
    $data['admin'] = $this->All;
    $data['koor'] = $koor;
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
    $this->session_info['page_name'] = "Koordinator";
    $this->template->build('v_set_koor', $this->session_info);
  }

  public function set_ketua() { 
    $ketua = $this->m_renaksi->get_set_ketua();
    $data['admin'] = $this->All;
    $data['ketua'] = $ketua;
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
    $this->session_info['page_name'] = "Ketua Tim";
    $this->template->build('v_set_ketua', $this->session_info);
  }

  public function add_koor() {
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['step'] = "koor_simpan";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Koordinator";
    $this->template->build('koor_edit', $this->session_info);
  }

  public function add_ketua() {
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    $data['get_koor'] = $this->m_renaksi->get_set_koor();
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['step'] = "ketua_simpan";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Ketua";
    $this->template->build('ketua_edit', $this->session_info);
  }

  public function ubah_koor($id) {
    $petugas = new tmpegawai();
    $data['id'] = $id;
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['koor'] = $this->m_renaksi->get_koordinator($id);
    $data['step'] = "koor_ubah";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Koordinator";
    $this->template->build('koor_edit', $this->session_info);
  }

  public function ubah_ketua($id) {
    $petugas = new tmpegawai();
    $data['id'] = $id;
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['get_koor'] = $this->m_renaksi->get_set_koor();
    $data['ketua'] = $this->m_renaksi->get_katim($id);
    $data['step'] = "ketua_ubah";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Koordinator";
    $this->template->build('ketua_edit', $this->session_info);
  }

  public function koor_simpan() {
      $nama_tim = $this->input->post('nama_tim');
      $kode_pengampu       = $this->input->post('kode_pengampu');
      $id_pegawai = $this->input->post('id_pegawai');
      $kode_tim = $this->input->post('kode_tim');
      $status = $this->input->post('status');
      $tahun = $this->input->post('tahun');

      $simpan = $this->m_renaksi->save_koor($id_pegawai,$nama_tim, $kode_pengampu, $tahun, $kode_tim, $status);

        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/set_koor');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/set_koor');
        }
      }

  public function koor_ubah() {
      $id = $this->input->post('id');
      $nama_tim = $this->input->post('nama_tim');
      $kode_pengampu       = $this->input->post('kode_pengampu');
      $id_pegawai = $this->input->post('id_pegawai');
      $kode_tim = $this->input->post('kode_tim');
      $status = $this->input->post('status');
      $tahun = $this->input->post('tahun');

      $simpan = $this->m_renaksi->ubah_koor($id, $id_pegawai,$nama_tim, $kode_pengampu, $tahun, $kode_tim, $status);

        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/set_koor');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/set_koor');
        }
      }

      public function ketua_simpan() {
      $id_koor = $this->input->post('id_koor');
      $nama_tim = $this->input->post('nama_tim');
      $kode_ketua       = $this->input->post('kode_ketua');
      $id_pegawai = $this->input->post('id_pegawai');
      $kode_tim = $this->input->post('kode_tim');
      $tahun = $this->input->post('tahun');

      $simpan = $this->m_renaksi->save_ketua($id_pegawai,$nama_tim, $kode_ketua, $tahun, $kode_tim, $id_koor);
      // var_dump($simpan); die();

        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/set_ketua');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/set_ketua');
        }
      }

  public function ketua_ubah() {
      $id = $this->input->post('id');
      $id_koor = $this->input->post('id_koor');
      $nama_tim = $this->input->post('nama_tim');
      $kode_ketua       = $this->input->post('kode_ketua');
      $id_pegawai = $this->input->post('id_pegawai');
      $kode_tim = $this->input->post('kode_tim');
      $tahun = $this->input->post('tahun');

    //   var_dump([
    //     'kode_ketua' => $kode_ketua,
    //     'id_pegawai' => $id_pegawai,
    //     'nama_tim' => $nama_tim,
    //     'tahun' => $tahun
    // ]);
    // die();


      $simpan = $this->m_renaksi->ubah_ketua($id, $id_pegawai,$nama_tim, $kode_ketua, $tahun, $kode_tim, $id_koor);

        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/set_ketua');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/set_ketua');
        }
      }

  public function hapus_koor($id) {
    $hapus = $this->m_renaksi->hapus_koor($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/set_koor');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/set_koor');
    }
  }

  public function hapus_ketua($id) {
    $hapus = $this->m_renaksi->hapus_ketua($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/set_ketua');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/set_ketua');
    }
  }


  public function kode_ring() { 
    $kode_ring = $this->m_renaksi->get_kode_ring();
    $data['admin'] = $this->All;
    $data['kode_ring'] = $kode_ring;
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
    $this->session_info['page_name'] = "Kode Rekening";
    $this->template->build('v_set_kode_ring', $this->session_info);
  }

  
  public function add_kode_ring() {
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['step'] = "kode_ring_simpan";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Koordinator";
    $this->template->build('kode_ring_edit', $this->session_info);
  }

  public function ubah_kode_ring($id) {
    $data['id'] = $id;
    $data['kodering'] = $this->m_renaksi->get_kodering_anggaran($id);
    $data['step'] = "kode_ring_ubah";

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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Kode Rekening";
    $this->template->build('kode_ring_edit', $this->session_info);
  }

  public function kode_ring_simpan() {
      $kode_ring = $this->input->post('kode_ring');
      $uraian_kegiatan       = $this->input->post('uraian_kegiatan');
      $anggaran = $this->input->post('anggaran');
      $tahun = $this->input->post('tahun');
      $t1 = $this->input->post('t1');
      $t2 = $this->input->post('t2');
      $t3 = $this->input->post('t3');
      $t4 = $this->input->post('t4');
      $t5 = $this->input->post('t5');
      $t6 = $this->input->post('t6');
      $t7 = $this->input->post('t7');
      $t8 = $this->input->post('t8');
      $t9 = $this->input->post('t9');
      $t10 = $this->input->post('t10');
      $t11 = $this->input->post('t11');
      $t12 = $this->input->post('t12');
      $r1 = $this->input->post('r1');
      $r2 = $this->input->post('r2');
      $r3 = $this->input->post('r3');
      $r4 = $this->input->post('r4');
      $r5 = $this->input->post('r5');
      $r6 = $this->input->post('r6');
      $r7 = $this->input->post('r7');
      $r8 = $this->input->post('r8');
      $r9 = $this->input->post('r9');
      $r10 = $this->input->post('r10');
      $r11 = $this->input->post('r11');
      $r12 = $this->input->post('r12');

      $simpan = $this->m_renaksi->save_kode_ring($kode_ring, $uraian_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);
        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/kode_ring');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/kode_ring');
        }
      }

      public function kode_ring_ubah() {
      $id           = $this->input->post('id');
      $kode_ring = $this->input->post('kode_ring');
      $uraian_kegiatan       = $this->input->post('uraian_kegiatan');
      $anggaran = $this->input->post('anggaran');
      $tahun = $this->input->post('tahun');
      $t1 = $this->input->post('t1');
      $t2 = $this->input->post('t2');
      $t3 = $this->input->post('t3');
      $t4 = $this->input->post('t4');
      $t5 = $this->input->post('t5');
      $t6 = $this->input->post('t6');
      $t7 = $this->input->post('t7');
      $t8 = $this->input->post('t8');
      $t9 = $this->input->post('t9');
      $t10 = $this->input->post('t10');
      $t11 = $this->input->post('t11');
      $t12 = $this->input->post('t12');
      $r1 = $this->input->post('r1');
      $r2 = $this->input->post('r2');
      $r3 = $this->input->post('r3');
      $r4 = $this->input->post('r4');
      $r5 = $this->input->post('r5');
      $r6 = $this->input->post('r6');
      $r7 = $this->input->post('r7');
      $r8 = $this->input->post('r8');
      $r9 = $this->input->post('r9');
      $r10 = $this->input->post('r10');
      $r11 = $this->input->post('r11');
      $r12 = $this->input->post('r12');

      $simpan = $this->m_renaksi->update_kode_ring($id, $kode_ring, $uraian_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12);
      // var_dump($simpan); die();
        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/kode_ring');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/kode_ring');
        }
      }

    public function hapus_kodering($id) {
    $hapus = $this->m_renaksi->hapus_kodering($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/kode_ring');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/kode_ring');
    }
  }

  public function hapus_kodering_subkeg($id) {
    $hapus = $this->m_renaksi->hapus_kodering_subkeg($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('kegiatandpa/kode_ring_subkeg');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('kegiatandpa/kode_ring_subkeg');
    }
  }

    public function kode_ring_subkeg() { 
    $kode_ring_subkeg = $this->m_renaksi->get_kode_ring_subkeg();
    $data['admin'] = $this->All;
    $data['kode_ring_subkeg'] = $kode_ring_subkeg;
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
    $this->session_info['page_name'] = "Kode Rekening Sub Kegiatan";
    $this->template->build('v_set_kode_ring_subkeg', $this->session_info);
  }


    public function add_kode_ring_subkeg() {
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    $data['pegawai'] = $this->m_renaksi->get_pegawai();
    $data['get_kode_ring'] = $this->m_renaksi->get_kode_ring();
    $data['step'] = "kode_ring_subkeg_simpan";
    
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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Koordinator";
    $this->template->build('kode_ring_subkeg_edit', $this->session_info);
  }

  public function ubah_kode_ring_subkeg($id) {
    $data['id'] = $id;
    $data['kodering'] = $this->m_renaksi->get_kodering_subkeg_anggaran($id);
    $data['get_kode_ring'] = $this->m_renaksi->get_kode_ring();
    $data['step'] = "kode_ring_subkeg_ubah";

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

            $(document).ready(
                     function() {
                       $('#anggota').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#anggota .ui-multiselect').css('width', '75%');
                   });
        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Kode Rekening";
    $this->template->build('kode_ring_subkeg_edit', $this->session_info);
  }

  public function kode_ring_subkeg_simpan() {
      $id_kode_ring = $this->input->post('id_kode_ring');
      $kode_sub_ring       = $this->input->post('kode_sub_ring');
      $uraian_sub_kegiatan       = $this->input->post('uraian_sub_kegiatan');
      $anggaran = $this->input->post('anggaran');
      $tahun = $this->input->post('tahun');
      $t1 = $this->input->post('t1');
      $t2 = $this->input->post('t2');
      $t3 = $this->input->post('t3');
      $t4 = $this->input->post('t4');
      $t5 = $this->input->post('t5');
      $t6 = $this->input->post('t6');
      $t7 = $this->input->post('t7');
      $t8 = $this->input->post('t8');
      $t9 = $this->input->post('t9');
      $t10 = $this->input->post('t10');
      $t11 = $this->input->post('t11');
      $t12 = $this->input->post('t12');
      $r1 = $this->input->post('r1');
      $r2 = $this->input->post('r2');
      $r3 = $this->input->post('r3');
      $r4 = $this->input->post('r4');
      $r5 = $this->input->post('r5');
      $r6 = $this->input->post('r6');
      $r7 = $this->input->post('r7');
      $r8 = $this->input->post('r8');
      $r9 = $this->input->post('r9');
      $r10 = $this->input->post('r10');
      $r11 = $this->input->post('r11');
      $r12 = $this->input->post('r12');
      $keterangan = $this->input->post('keterangan');

      $simpan = $this->m_renaksi->save_kode_ring_subkeg($id_kode_ring, $kode_sub_ring, $uraian_sub_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $keterangan);
        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/kode_ring_subkeg');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/kode_ring_subkeg');
        }
      }

      public function kode_ring_subkeg_ubah() {
      $id           = $this->input->post('id');
      $id_kode_ring = $this->input->post('id_kode_ring');
      $kode_sub_ring       = $this->input->post('kode_sub_ring');
      $uraian_sub_kegiatan       = $this->input->post('uraian_sub_kegiatan');
      $anggaran = $this->input->post('anggaran');
      $tahun = $this->input->post('tahun');
      $t1 = $this->input->post('t1');
      $t2 = $this->input->post('t2');
      $t3 = $this->input->post('t3');
      $t4 = $this->input->post('t4');
      $t5 = $this->input->post('t5');
      $t6 = $this->input->post('t6');
      $t7 = $this->input->post('t7');
      $t8 = $this->input->post('t8');
      $t9 = $this->input->post('t9');
      $t10 = $this->input->post('t10');
      $t11 = $this->input->post('t11');
      $t12 = $this->input->post('t12');
      $r1 = $this->input->post('r1');
      $r2 = $this->input->post('r2');
      $r3 = $this->input->post('r3');
      $r4 = $this->input->post('r4');
      $r5 = $this->input->post('r5');
      $r6 = $this->input->post('r6');
      $r7 = $this->input->post('r7');
      $r8 = $this->input->post('r8');
      $r9 = $this->input->post('r9');
      $r10 = $this->input->post('r10');
      $r11 = $this->input->post('r11');
      $r12 = $this->input->post('r12');
      $keterangan = $this->input->post('keterangan');

      $simpan = $this->m_renaksi->update_kode_ring_subkeg($id, $id_kode_ring, $kode_sub_ring, $uraian_sub_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $keterangan);
      // var_dump($simpan); die();
        if($simpan) {
          $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
          redirect('kegiatandpa/kode_ring_subkeg');
         } else {
          $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
          redirect('kegiatandpa/kode_ring_subkeg');
        }
      }



}