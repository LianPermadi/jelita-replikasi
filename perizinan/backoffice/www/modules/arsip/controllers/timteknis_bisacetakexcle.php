<?php

/**
 * Description of Info Izin diterbitkan untuk Tim Teknis SK
 * Update  : PBS, 27 Juli 2020
 */

class TimTeknis extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->permohonan = new tmpermohonan();
    $this->propertyizin = new tmproperty_jenisperizinan();
    $this->perizinan = new trperizinan();
    $this->sk = new tmpermohonan();
    $this->pegawai = new tmpegawai();
    $this->pemohon = new tmpemohon();
    $this->surat = new tmsk();
    $this->settings = new settings();
    $this->load->library('dompdf_gen');
    //$this->load->library('fpdf');
    
    $enabled = TRUE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->sk = NULL;
    $this->All = FALSE;
    if($this->session->userdata('username') != 'budi') $enabled = FALSE;   // Nanti harus dihapus
    foreach ($list_auths as $list_auth) {
      //if($list_auth->id_role === '26') {
      //  $enabled = TRUE;
      //  $this->sk = new user_auth();
      //}
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index() {
    $no_daftar = $this->input->post('kt_cari');
    $sts_pil = $this->input->post('sts_pil');
    if($sts_pil == '') $sts_pil = 1;
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -40);
    $tgl_now = $this->lib_date->set_date($now, 0);
    if($tgla == '')
      $awal = FALSE;
    else
      $awal = TRUE;
    
    if($tgla && $tglb){
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }else{
      $tgla = $tgl_before;
      $tglb = $tgl_now;
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template, C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2";
      if($sts_pil == 2) { // berdasarkan Tanggal Upload
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND K.tgl_penetapan between '$tgla' AND '$tglb' AND I.status_bap = 1 order by A.id DESC";
        }
      }elseif($sts_pil == 3){
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";  
        }
      }else{
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";  
        }
      }
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template, C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2
                AND L.user_id = '".$username->id."'";
      if($sts_pil == 2) { // berdasarkan Tanggal Upload
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
        }
      }elseif($sts_pil == 3){
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";  
        }
      }else{
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";
        }
      }
    }
    $data['list'] = $query;
    $data['c_bap'] = "1";
    switch($sts_pil){
      case 2 : $data['cek1'] = FALSE;
               $data['cek2'] = TRUE; 
               $data['cek3'] = FALSE; 
               break;
      case 3 : $data['cek1'] = FALSE;
               $data['cek2'] = FALSE; 
               $data['cek3'] = TRUE;
               break;
      default: $data['cek1'] = TRUE;
               $data['cek2'] = FALSE;
               $data['cek3'] = FALSE;
               break;
    }

    $data['kt_cari'] = $no_daftar;
    
    $this->load->vars($data);
    
    $js = "$(document).ready(function() {
    		$( '#notif' ).click(function() {
			  $('#pageloader').fadeIn();
			});

            oTable = $('#sk').dataTable({
                     \"bJQueryUI\": true,
                     \"sPaginationType\": \"full_numbers\"
            });
           } );
           $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
          });
         ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Arip dan Data Perizinan";
    $this->template->build('arsip_opd_list', $this->session_info);
  }
  
  //public function index_next() {
  //  $no_daftar = $this->input->post('kt_cari');
  //  $sts_pil = $this->input->post('sts_pil');
  //  if($sts_pil == '') $sts_pil = 1;
  //  $username = new user();
  //  $username->where('username', $this->session->userdata('username'))->get();
  //  $group = $username->group;
  //  $tgla = $username->gvar1;
  //  $tglb = $username->gvar2;
  //  $data['tgla'] = $tgla;
  //  $data['tglb'] = $tglb;
  //  
  //  if($this->All){
  //    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
  //              A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
  //              C.template,C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
  //              K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
  //              FROM tmpermohonan as A
  //              INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
  //              INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
  //              INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
  //              INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
  //              INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
  //              INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
  //              INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
  //              INNER JOIN tmbap I ON H.tmbap_id = I.id
  //              INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
  //              INNER JOIN tmsk K ON J.tmsk_id = K.id
  //              INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
  //              WHERE A.c_pendaftaran = 1
  //              AND A.c_izin_dicabut = 0
  //              AND A.c_izin_selesai = 0";
  //    if($sts_pil == 2) { // berdasarkan Tanggal Upload
  //      $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
  //    }elseif($sts_pil == 3){
  //        $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 AND A.approve = 2 order by A.id DESC";  
  //    }else{
  //      $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";			
  //    }
  //  }else{
  //    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
  //              A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
  //              C.template,C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
  //              K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
  //              FROM tmpermohonan as A
  //              INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
  //              INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
  //              INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
  //              INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
  //              INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
  //              INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
  //              INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
  //              INNER JOIN tmbap I ON H.tmbap_id = I.id
  //              INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
  //              INNER JOIN tmsk K ON J.tmsk_id = K.id
  //              INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
  //              INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
  //              WHERE A.c_pendaftaran = 1
  //              AND A.c_izin_dicabut = 0
  //              AND A.c_izin_selesai = 0
  //              AND L.user_id = '".$username->id."'";
  //    if($sts_pil == 2) { // berdasarkan Tanggal Upload
  //      $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
  //    }elseif($sts_pil == 3){
  //        $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 AND A.approve = 2 order by A.id DESC";  
  //    }else{
  //      $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";			
  //    }
  //  }
  //  $data['list'] = $query;
  //  $data['c_bap'] = "1";
  //  switch($sts_pil){
  //    case 2 : $data['cek1'] = FALSE;
  //             $data['cek2'] = TRUE; 
  //             $data['cek3'] = FALSE; 
  //             break;
  //    case 3 : $data['cek1'] = FALSE;
  //             $data['cek2'] = FALSE; 
  //             $data['cek3'] = TRUE;
  //             break;
  //    default: $data['cek1'] = TRUE;
  //             $data['cek2'] = FALSE;
  //             $data['cek3'] = FALSE;
  //             break;
  //  }
  //  
  //  $data['kt_cari'] = $no_daftar;
  //  $this->load->vars($data);
  //  
  //  $js =  "$(document).ready(function() {
  //            oTable = $('#sk').dataTable({
  //                     \"bJQueryUI\": true,
  //                     \"sPaginationType\": \"full_numbers\"
  //            });
  //          } );
  //          $(function() {
  //            $(\".monbulan\").datepicker({
  //              changeMonth: true,
  //              changeYear: true,
  //              dateFormat: 'yy-mm-dd',
  //              closeText: 'X'
  //            });
  //          });
  //         ";
  //  
  //  $this->template->set_metadata_javascript($js);
  //  $this->session_info['page_name'] = "Arip dan Data Perizinan";
  //  $this->template->build('arsip_opd_list', $this->session_info);
  //}
  
  public function edit($id_daftar = NULL) {
    $permohonan = new tmpermohonan();
    $permohonan = $permohonan->get_by_id($id_daftar);
    $surat = $permohonan->tmsk->get();
    $pegawai = $permohonan->tmsk->tmpegawai->get();

    if($surat->id){
      $save = "update";
      $id_surat = $surat->id;
      $no_surat = $surat->no_surat;
      $sts_surat = $surat->c_status;
      $tgl_surat = $surat->tgl_surat;
      $petugas = $pegawai->id;
    }else{
      $save = "save";
      $id_surat = "";
      $no_surat = "";
      $sts_surat = "";
      $tgl_surat = "";
      $petugas = "";
    }
    $data['save_method'] = $save;
    $data['daftar'] = $permohonan;
    $data['id_daftar'] = $id_daftar;
    $data['id_surat'] = $id_surat;
    $data['no_surat'] = $no_surat;
    $data['sts_surat'] = $sts_surat;
    $data['tgl_surat'] = $tgl_surat;
    $data['petugas'] = $petugas;
    $petugas = new tmpegawai();
    $data['list_petugas'] = $petugas->order_by('n_pegawai','ASC')->get();

    $js =  "$(function() {
              $(\"#inputTanggal\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
            });
            var base_url = '". base_url() ."';
            $(document).ready(function() {
              $(\"#tabs\").tabs();
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Data Pembuatan Izin";
    $this->template->build('sk_edit', $this->session_info);
  }

  /*
   * Save and update for manipulating data.
   */
  public function save() {
    $petugas = 1;
    /* Input Data */
    $this->surat->no_surat = $this->input->post('no_surat');
    $this->surat->tgl_surat = $this->input->post('tgl_surat');

    /* Input Relasi Tabel*/
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($this->input->post('id_daftar'));
    $perizinan = $permohonan->trperizinan->get();
    $permohonan->d_berlaku_izin = $this->lib_date->set_date($this->input->post('tgl_surat'), $perizinan->v_berlaku_tahun * 365); //per tahun
    $permohonan->save();
    $pegawai = new tmpegawai();
    $pegawai->where('status', $pegawai)->get();

    if(! $this->surat->save(array($permohonan, $pegawai))) {
      echo '<p>' . $this->surat->error->string . '</p>';
    } else {
      redirect('permohonan/sk');
    }
  }

	public function cetak_nota($tgla=NULL,$tglb=NULL) {
		$username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
		$data['lokasi'] = $username->lokasi;

		$data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
		$data['checked'] = FALSE;

    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    if($this->All){
			$query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai,
                C.id idizin, C.n_perizinan, C.c_keputusan, E.n_pemohon, G.id idjenis, K.tgl_surat, K.no_surat, K.c_cetak, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.d_terima_berkas between '$tgla' and '$tglb'
                AND I.status_bap = 1
                order by A.id DESC";
		}else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai,
                C.id idizin, C.n_perizinan, C.c_keputusan, E.n_pemohon, G.id idjenis, K.tgl_surat, K.no_surat, K.c_cetak, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND L.user_id = '".$username->id."'
                AND A.d_terima_berkas between '$tgla' and '$tglb'
                AND I.status_bap = 1
                order by A.id DESC";
		}
    $data['list'] = $this->db->query($query)->result();
    $data['c_bap'] = "1";

    $this->load->vars($data);

    $js = "$(document).ready(function() {
             oTable = $('#cetakizin').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });

           $(document).ready(function() {
             $('.monbulan').datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });

		       function check_uncheckAll(field,nilai){
			       for(i=0; i< field.length; i++){
				       field[i].checked=nilai;
			       }
		       }

           function finishAjax(id, response){
               $('#'+id).html(unescape(response));
               $('#'+id).fadeIn();
           }
          ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Cetak Nota Pengantar";
    $this->template->build('cetak_nota', $this->session_info);
	}

	public function ctk_np() {   // cetak nota penjelasan multi
		$this->load->library('fpdf');
    $syarat = $this->input->post('pilih_cetak');
    $syarat_len = count($syarat);
		$cek_len = count($syarat) - 1;
		$is_array = NULL;
		
    for ($i = 0; $i < $syarat_len; $i++) {
      $is_array = $syarat[$i];
    }

    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $user = $username->realname;
		$tgla = $username->gvar1;
    $tglb = $username->gvar2;
		$gerai = $username->gvar3;
    if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
		$list_state = $gerai;

    // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
    $logo = $this->tr_instansi->get_by_id(23);
    $n_logo = base_url(). 'uploads/logo/ttd.png';

    // Ambil Penanda tangan
    $this->pegawai->where('status', '1')->get();
    $n_peg = $this->pegawai->n_pegawai;
		$n_pangkat = $this->pegawai->pangkat_gol;
		$cek_posisi = strpos($n_pangkat,'(');
		$n_pangkat = substr($n_pangkat,0,$cek_posisi);
		$n_nip = $this->pegawai->nip;

		// Ambil Pemerintah 
    $this->tr_instansi = new Tr_instansi();
    $nama_prov = $this->tr_instansi->get_by_id(17)->value;

    // Ambil Badan
    $this->tr_instansi = new Tr_instansi();
    $nama_badan = $this->tr_instansi->get_by_id(9)->value;

    // Ambil Alamat
    $this->tr_instansi = new Tr_instansi();
    $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
    $this->tr_instansi = new Tr_instansi();
    $tlp = $this->tr_instansi->get_by_id(10)->value;

    // Ambil Fax
    $this->tr_instansi = new Tr_instansi();
    $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
    $this->tr_instansi = new Tr_instansi();
    $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
    $this->tr_instansi = new Tr_instansi();
    $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
    $this->tr_instansi = new Tr_instansi();
    $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
    $this->tr_instansi = new Tr_instansi();
    $e_mail = $this->tr_instansi->get_by_id(22)->value;
    
    $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
    $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;
    $judul1 = 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla).' - '.$this->lib_date->mysql_to_human($tglb);
		$judul2 = 'Asal Permohonan : ' . $c_asal;

    //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
		//$pdf = new FPDF();
		$pdf = new FPDF('P','mm','LETTER'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), legal'=>array(612,1008));
		//$pdf->SetMargins(0,20,0); //$pdf->SetMargins(kiri,atas,kanan);
    //		$pdf->AddPage();
    /**		$pdf->Image($n_logo,2,5,22);
		$pdf->SetFont('Arial','B',15);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','B',16);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.1); $pdf->Line(1,33,209,33);
		$pdf->SetLineWidth(0.5); $pdf->Line(1,34,209,34);

        $pdf->SetFont('Arial','',11);
		$pdf->Ln(13); $pdf->Cell(0,0.5,$judul1,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul2,0,1,'C');
    **/
    $Wpaper = 262;
		$Hpaper = 450;
		$brs = 20;
		$pdf->AddPage('P',array($Hpaper,$Wpaper));
		$pdf->SetMargins(0,0,0);  //$pdf->SetMargins(kiri,atas,kanan);
		//$pdf->SetAutoPageBreak('ON', 60);  //63
		$pdf->SetTopMargin($brs);
		$pdf->SetLeftMargin(10);
		$pdf->SetRightMargin(10);
    $tinggikop = 50; //$tinggi_kop; //dapat diubah untuk menentukan tinggi kop surat yang ada
		$pdf->Ln($tinggikop);

		//cek kesamaan jenis izin
		for ($is = 0; $is < $syarat_len; $is++) {
      $permohonan = new tmpermohonan();
      $permohonan = $permohonan->get_by_id($syarat[$is]);
      $perizinan = $permohonan->trperizinan->get();
			$n_izin = $perizinan->n_perizinan;
			if($is == 0){
				$sektor = $perizinan->trsektor->get();
				$id_izin = $perizinan->id;
				$id_sama = TRUE;
			}else{
			  if($id_izin != $perizinan->id){
          $id_sama = FALSE;
				break;
				}
			}
		}
        
   	$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('status', '1')->get();  // untuk jabatan kepala
		$n_jab_kepala = $pegawai->n_jabatan;

		$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('id', $sektor->ttd_nota)->get();
		$n_jab_kabid = $pegawai->n_jabatan;
		$spc  = '          ';
		$sp = 0;
		$br1  = 'NOTA PENJELASAN';
		$br2  = '';
		$br3  = 'Kepada';
		$br3a = $n_jab_kepala; //'Kepala Badan';
		$br4  = 'Dari';
		$br4a = $n_jab_kabid;  //'Kepala Bidang Pelayanan';
		$br5  = 'Perihal';

		if($id_sama)
		  $br5a = 'Permohonan Penandatanganan'; // Surat '.ucwords(strtolower($n_izin));
		else
      $br5a = 'Permohonan Penandatanganan'; //  Surat Izin';
		if($syarat_len == 1)
			$br6  = 'Disampaikan dengan hormat, berkas Administrasi Izin dari : ';
		else
		  $br6  = 'Disampaikan dengan hormat, berkas Administrasi Izin sejumlah '.$syarat_len.' ('.$this->terbilang->terbilang($syarat_len).') berkas, terdiri dari : ';
        
		$br7  = 'Sehubungan dengan hal tersebut proses penelitian berkas telah sesuai dengan ketentuan yang berlaku sehingga dapat diterbitkan naskah perizinan untuk ditanda tangani '. ucwords(strtolower($n_jab_kepala));
		$br9  = 'Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut :';
		$br10 = 'Bandung, '.$this->lib_date->mysql_to_human(date('Y-m-d'));
		$br11 = $n_jab_kabid;
		$br12 = $pegawai->n_pegawai;
		$br13 = $pegawai->pangkat_gol;
		$br14 = 'NIP. '.$pegawai->nip;
		$tab = 30;

    $pdf->SetFont('times','U',20);
		$pdf->Ln(15); $pdf->Cell(0,0,$br1,2,2,'C');
		$pdf->SetFont('times','',16);
		$pdf->Ln(7);  $pdf->Cell(0,0,$br2.$spc.$spc,0,1,'C');
		$pdf->Ln(10); $pdf->Cell(0,0,$br3,0,1,'L');
		$pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br3a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br4,0,1,'L');
		$pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br4a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br5,0,1,'L');
		$pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br5a,0,'J');

    $pdf->Ln(5);  $pdf->SetLineWidth(0.2);
    //$pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
		$pdf->Line(12,$pdf->GetY(),250,$pdf->GetY());
		$pdf->Ln(1);  $pdf->SetLineWidth(0.4);
    //$pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
    $pdf->Line(12,$pdf->GetY(),250,$pdf->GetY());
    $pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br6,0,'J');
		//Mencetak judul dengan tinggi bervariasi
		$pdf->SetFont('times','',12);
		$jd1 = 'NO';
		$jd2 = ' NO PENDAFTARAN '.' TANGGAL DAFTAR ';
		$jd3 = 'NAMA PEMOHON';
		$jd4 = 'NAMA IZIN';
		$judul = array($jd1,$jd2,$jd3,$jd4);
		$l_col = array(10,45,75,80); 
		$align = array('C','C','C','C');
		$hit_judul = count($judul);

		$pdf->Ln(5);
    $space = 5;
		$nb=0;
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
		// Create box
    for($i=0;$i<count($judul);$i++){
      $nb=max($nb,$pdf->NbLines($l_col[$i],$judul[$i]));
		}
    $h=$space*$nb;
    //Issue a page break first if needed
    $pdf->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($judul);$i++) {
      $w=$l_col[$i];
      $a=isset($align[$i]) ? $align[$i] : 'L';
      //Save the current position
      $x=$pdf->GetX();
      $y=$pdf->GetY();
      //Draw the border

      $pdf->Rect($x,$y,$w,$h);
      //Print the text

      $pdf->MultiCell($w,$space,$judul[$i],0,$a);
      //Put the position to the right of the cell
      $pdf->SetXY($x+$w,$y);
    } 
    //Go to the next line
    $pdf->Ln($h);
    //EOF(Mencetak judul dengan tinggi bervariasi)

		//cetak isi tabel ke pdf
	  $no = 0;
		for($ai=0; $ai<$syarat_len; $ai++){
      $permohonan = new tmpermohonan();
      $permohonan = $permohonan->get_by_id($syarat[$ai]);
      $perizinan = $permohonan->trperizinan->get();
			$pemohon = $permohonan->tmpemohon->get();
			$perusahaan = $permohonan->tmperusahaan->get();
			$sk = $permohonan->tmsk->get();
            
      //NEW BARCODE
    	$font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
      $text = isset($_GET['text']) ? $_GET['text'] : $permohonan->pendaftaran_id;
      // The arguments are R, G, B for color.
      $color_black = new BCGColor(0, 0, 0);
      $color_white = new BCGColor(255, 255, 255);
      $drawException = null;
      try {$code = new BCGcode128();
           $code->setScale(2); // Resolution
           $code->setThickness(30); // Thickness
           $code->setForegroundColor($color_black); // Color of bars
           $code->setBackgroundColor($color_white); // Color of spaces
           $code->setFont(0); // $font or 0
           $code->parse($text); // Text
          } 
			catch(Exception $exception) {$drawException = $exception;}
      $drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
      if($drawException) {
        $drawing->drawException($drawException);
      } else {
        $drawing->setBarcode($code);
        $drawing->draw();
      }
      $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	 	  $b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
            //EOF() NEW BARCODE

			$nama = $perusahaan->n_perusahaan;
			$alamat = $perusahaan->a_perusahaan;
			if($nama == ''){
			  $nama = $pemohon->n_pemohon;
			  $alamat = $pemohon->a_pemohon;
			}
			$no++;

			$xspc = ' ';
			for($i=1; $i<=84; $i++) $xspc=$xspc.' '; 
        $isi = array($no.'.',
			               $permohonan->pendaftaran_id . $xspc . $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
				             $nama.' Alamat:'.$alamat,ucwords(strtolower($perizinan->n_perizinan)),
				            );

			$align = array('R','L','L','L');
      $space = 5;
   	  $nb=0;
   
			$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
      // Create box
			for($i=0;$i<count($isi);$i++)
      $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
      $h=$space*$nb;
      //Issue a page break first if needed
      $pdf->CheckPageBreak($h);

			//Inisialisasi ulang halaman baru
      if($pdf->GetY()+$h >= 400){ //333
        $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
        $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
        //$pdf->SetAutoPageBreak('ON', 63);
        $pdf->SetTopMargin($brs);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
				$pdf->SetFont('times','',12);
        $pdf->SetY($brs);
				$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
      }

      //Draw the cells of the row
			for($i=0; $i<count($isi); $i++) {
				$w=$l_col[$i];
        $a=isset($align[$i]) ? $align[$i] : 'L';
        //Save the current position
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        //Draw the border
        $pdf->Rect($x,$y,$w,$h);
        //Print the text
        $pdf->MultiCell($w,$space,$isi[$i],0,$a);
				if($i==0){
					$ypos_bc = $pdf->GetY();
				  //$pdf->Image($b_code,$x+$l_col[0]+2,$ypos_bc+1,40);   // matikan jika ingin tidak menampilkan barcode
				}
        //Put the position to the right of the cell
        $pdf->SetXY($x+$w,$y);
      }
    	// EOF() Cetak Full

      //Go to the next line
      $pdf->Ln($h);
		}
    // EOF(cetak isi tabel ke pdf)

		if($pdf->GetY() > 330){ // nilai sesuaikan dengan coba tampilan diatas
      $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
      $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
			$pdf->SetTopMargin($brs);
    	$pdf->SetLeftMargin(10);
	    $pdf->SetRightMargin(10);
    }
		$pdf->SetFont('times','',16);
		$pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br7,0,'J');
		$pdf->Ln(25); 
    $pdf->Cell(100); $pdf->Cell(0,0,$br10,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(100); $pdf->Cell(0,0,$br11,0,1,'C');
		$a = $pdf->GetY();
    //			 $pdf->Image($n_logo,155,$pdf->GetX()+$a+2,35);
		$pdf->Ln(30);$pdf->Cell(100); $pdf->Cell(0,0,$br12,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(100); $pdf->Cell(0,0,$br13,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(100); $pdf->Cell(0,0,$br14,0,1,'C');
    // EOF() ttd

		$n_file=$permohonan->pendaftaran_id.'NP_'.$no.'.pdf';
		$pdf->Output($n_file,'D');

    // Menghapus Barcode yang telah dibuat
		for($ai=0; $ai<$syarat_len; $ai++){
      unlink('assets/barcode/' . $syarat[$ai] . '.png');
		}
  }

  public function aktifsk() {
    $permohonan = new tmpermohonan();
    $data['list'] = $permohonan->where('c_pendaftaran', 1) //Pendaftaran selesai
                               ->where('c_izin_selesai', 0) //SK Belum diserahkan
                               ->where('c_izin_dicabut', 0) //Permohonan tidak dicabut
                               ->order_by('id', 'DESC')->get();
    $bap = new tmbap();
    $data['list_bap'] = $bap->get();
    $data['c_bap'] = "1";
    $this->load->vars($data);

    $js =  "$(document).ready(function() {
              oTable = $('#sk').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Aktivasi Cetak Izin";
    $this->template->build('aktifsk_list', $this->session_info);
  }

  public function aktivasisk($id_daftar = NULL) {
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_daftar);
    $surat = $permohonan->tmsk->get();
    $surat_sk = new tmsk();
    $update = $surat_sk->where('id', $surat->id)->update(array('c_status' => 2));

    if(! $update) {
      echo '<p>' . $update->error->string . '</p>';
    }else{
      redirect('permohonan/sk/aktifsk');
    }
  }

  public function update() {
    $surat = new tmsk();
    $surat->get_by_id($this->input->post('id_surat'));
    $surat->no_surat = $this->input->post('no_surat');
    $surat->tgl_surat = $this->input->post('tgl_surat');

    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($this->input->post('id_daftar'));
    $perizinan = $permohonan->trperizinan->get();
    $permohonan->d_berlaku_izin = $this->lib_date->set_date($this->input->post('tgl_surat'), $perizinan->v_berlaku_tahun * 365); //per tahun
    $permohonan->save();

    $update = $surat->save();
    if($update) {
      redirect('permohonan/sk');
    }
  }

  // $jenis => 0:tanpa templet; 1:dengan templete; $menu => 1:SK 2:Sartek 3:Upload
  public function cetakx($id_daftar = NULL, $jenis = NULL, $menu = NULL) {
    //catatan sementara jika menu = 1 utk cetak SK hidupkan save status
    $app_folder = new settings();
    $app_folder->where('name','app_folder')->get();
    $app_folder = $app_folder->value . "/";
    $app_city = new settings();
    $app_city->where('name','app_city')->get();
    $app_city = $app_city->value;
    $app_kan =  $this->settings->where('name', 'app_kantor')->get();
    
    $petugas = 1; //1 -> Jabatan Penandatangan
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_daftar);
    $perizinan = $permohonan->trperizinan->get();
    $e_sertifikat = $perizinan->e_sertifikat;
    $e_ttd = $perizinan->e_ttd;
    $surat_awal = $permohonan->tmsk->get();
    $bap = $permohonan->tmbap->get();
    $nodaftar = $permohonan->pendaftaran_id;
    $kd_status = $permohonan->kd_status;
    
    //Cek AKDP Trayek 
    //$akdp_cetak = new akdp_cetak();
	  //$akdp_cetak->like("pendaftaran_id",$nodaftar)->order_by('id', 'DESC')->get();
	  //$pendaftaran_id_trayek = $akdp_cetak->pendaftaran_id;
	  //if($pendaftaran_id_trayek != ''){
	  //  
	  //}
    //EOF() Cek AKDP Trayek
    
    $sts_cetak = 1;
    if($surat_awal->id){
      $surat_sk = new tmsk();
      $surat_sk->get_by_id($surat_awal->id);
      $surat_sk->c_status = $sts_cetak;
      $tgl_skr = $this->lib_date->get_date_now();
      if($menu == 1) $surat_sk->save();    // khusus cetak SK
      $pegawai = new tmpegawai();
      $pegawai->where('status', $petugas)->get();
      
      /* Input Relasi Tabel*/
      //$perizinan = $permohonan->trperizinan->get();
      $permohonan->nip_ttd = $pegawai->nip;
      $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
      $permohonan->kd_status = 7; // ubah kd_status menjadi 7 untuk proses selanjutnya (izin siap diserahkan)
      if($menu == 1) $permohonan->save();    // khusus cetak SK
    }else{
      /* Input Data */
      $data_id = new tmsk();
      $data_id->select_max('id')->get();
      $data_id->get_by_id($data_id->id);
      $data_tahun = date("Y");
      //Per Tahun Auto Restart NoUrut
      if($permohonan->d_tahun === $data_tahun)
        $data_urut = $data_id->i_urut + 1;
      else 
        $data_urut = 1;
      
      $i_urut = strlen($data_urut);
      for($i=4;$i>$i_urut;$i--){
        $data_urut = "0".$data_urut;
      }
      
      $data_izin = $perizinan->id;
      $i_izin = strlen($data_izin);
      for($i=3;$i>$i_izin;$i--){
        $data_izin = "0".$data_izin;
      }
      
      $data_bulan = $this->lib_date->set_month_roman(date("n"));
      
      $data_sk = "DP";
      $no_surat = $data_urut."/".$data_sk."/".$data_izin."/".$data_bulan."/".$data_tahun;
      $surat_sk = new tmsk();
      $surat_sk->c_status = $sts_cetak;
      $surat_sk->i_urut = $data_urut;
      $surat_sk->no_surat = $no_surat;
      $tgl_skr = $this->lib_date->get_date_now();
      $surat_sk->c_cetak = 1;
      
      /* Input Relasi Tabel*/
      $pegawai = new tmpegawai();
      $pegawai->where('status', $petugas)->get();
      //$perizinan = $permohonan->trperizinan->get();
      $permohonan->nip_ttd = $pegawai->nip;
      $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
      if ($menu != 2) {
        $permohonan->kd_status = 7; // ubah kd_status menjadi 7 untuk proses selanjutnya (izin siap diserahkan)
      }
      if($menu == 1) $permohonan->save();    // khusus cetak SK
      if($menu == 1) $surat_sk->save(array($permohonan, $pegawai));    // khusus cetak SK
    }
    $status_izin = $permohonan->trstspermohonan->get();
    
    //edited 12-04-2013
    //by mucktar
    $status_skr  = "8" ; // Diizinkan [Lihat Tabel trstspermohonan()]
    $status_skrd = "10"; // SKRD [Lihat Tabel trstspermohonan()]
    $id_status   = "14"; // Mencetak Surat [Lihat Tabel trstspermohonan()]
    $id_status2  = "13"; // Kasir [Lihat Tabel trstspermohonan()]
    $id_status3  = "14"; // Penyerahan Izin [Lihat Tabel trstspermohonan()]
    $kelompok    = $permohonan->trperizinan->trkelompok_perizinan->get();
    if($kelompok->id == 2 || $kelompok->id == 4){
      //if($status_izin->id == $status_skr || $status_izin->id == $status_skrd){
      /* Input Data Tracking Progress */
      $sts_izin = new trstspermohonan();
      $sts_izin->get_by_id($status_skr);
      $data_status = new tmtrackingperizinan_trstspermohonan();
      $list_tracking = $permohonan->tmtrackingperizinan->get();
      if($list_tracking){
        $tracking_id = 0;
        foreach ($list_tracking as $data_track){
          $data_status = new tmtrackingperizinan_trstspermohonan();
          $data_status->where('tmtrackingperizinan_id', $data_track->id)
                      ->where('trstspermohonan_id', $sts_izin->id)->get();
          if($data_status->tmtrackingperizinan_id){
            $tracking_id = $data_status->tmtrackingperizinan_id;
          }
        }
      }
      $tracking_izin = new tmtrackingperizinan();
      $tracking_izin->get_by_id($tracking_id);
      $tracking_izin->status = 'Update';
      $tracking_izin->d_entry = $this->lib_date->get_date_now();
      if($menu == 1) $tracking_izin->save();    // khusus cetak SK
    
      /* [Lihat Tabel trstspermohonan()] */
      $tracking_izin2 = new tmtrackingperizinan();
      $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
      $tracking_izin2->status = 'Insert';
      $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
      $tracking_izin2->d_entry = $this->lib_date->get_date_now();
      $sts_izin2 = new trstspermohonan();
      $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
      if($menu == 1) $sts_izin2->save($permohonan);    // khusus cetak SK
      if($menu == 1) $tracking_izin2->save($permohonan);    // khusus cetak SK
      if($menu == 1) $tracking_izin2->save($sts_izin2);    // khusus cetak SK
    }else{
      //if($status_izin->id == $status_skr){
      /* Input Data Tracking Progress */
      $sts_izin = new trstspermohonan();
      $sts_izin->get_by_id($status_skr);
      $data_status = new tmtrackingperizinan_trstspermohonan();
      $list_tracking = $permohonan->tmtrackingperizinan->get();
      if($list_tracking){
        $tracking_id = 0;
        foreach ($list_tracking as $data_track){
          $data_status = new tmtrackingperizinan_trstspermohonan();
          $data_status->where('tmtrackingperizinan_id', $data_track->id)
                      ->where('trstspermohonan_id', $sts_izin->id)->get();
          if($data_status->tmtrackingperizinan_id){
              $tracking_id = $data_status->tmtrackingperizinan_id;
          }
        }
      }
      $tracking_izin = new tmtrackingperizinan();
      $tracking_izin->get_by_id($tracking_id);
      $tracking_izin->status = 'Update';
      $tracking_izin->d_entry = $this->lib_date->get_date_now();
      if($menu == 1) $tracking_izin->save();    // khusus cetak SK
    
      /* [Lihat Tabel trstspermohonan()] */
      $tracking_izin2 = new tmtrackingperizinan();
      $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
      $tracking_izin2->status = 'Insert';
      $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
      $tracking_izin2->d_entry = $this->lib_date->get_date_now();
      $sts_izin2 = new trstspermohonan();
      $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
      if($menu == 1) $sts_izin2->save($permohonan);    // khusus cetak SK
      if($menu == 1) $tracking_izin2->save($permohonan);    // khusus cetak SK
      if($menu == 1) $tracking_izin2->save($sts_izin2);    // khusus cetak SK
    }
    //end edit
    
    if($menu == 1 || $menu == 3){   // Jika cetak SK
      $sk = new tmsk();
      $sk->get_by_id($surat_awal->id);
      $sk->c_cetak = $surat_awal->c_cetak + 1;
      $sk->save();    // khusus cetak SK
    }
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql2($u_ser);
    if($menu == 1) $p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$nodaftar."','".$tgl."','".$u_ser."')");    // khusus cetak SK

    if($jenis == 0){  // tanpa tmplate pertek /gub
      //if($menu == 1) redirect('permohonan/sk/index_next');  // untuk naskah izin menu SK
      if($menu == 2) redirect('permohonan/bap/index_next'); // untuk pertek menu BAP
    }

    if($menu == 1) $file = str_replace(' ', '','SK_'.$nodaftar); // SK
    if($menu == 2) $file = str_replace(' ', '','PT_'.$nodaftar); // Sartek
    if($menu == 3) $file = str_replace(' ', '','SK_'.$nodaftar); // Upload
    $lok_nonsign = 'assets/skpdf/';
    $lok_esign =   'assets/esignfile/';
    
    if( (!file_exists($lok_esign.$file.'.pdf') && $e_sertifikat == 0) && $menu != 2){  // jika tidak e-sign $ bukan sartek
      $this->cetak_sk($id_daftar,$menu);   // ke membuat docx dan pdf
    }else{                                 // jika e-sign
      
      // if (file_exists($lok_esign.$file.'.pdf') && $kd_status < 7 && $e_ttd == 2) { //status < 7, ada file pdf & metode upload
      //   $permohonan2 = new tmpermohonan();
      //   $permohonan2->where('id', $id_daftar)->update(array('kd_status' => '7'));
      // }
      
      $this->load->helper('download');
      if(file_exists($lok_esign.$file.'.pdf')){             // cek PDF yang sudah SE
        $data = file_get_contents($lok_esign.$file.'.pdf');
        force_download($file.'.pdf', $data);
      }else{
        if(file_exists($lok_nonsign.$file.'.pdf') && $menu != 2){         // cek PDF yang tanpa SE
        	//if(file_exists('assets/skpdfWM/'.$file.'.pdf'))   // cek PDF yang DG Watermark
          //  $data = file_get_contents('assets/skpdfWM/'.$file.'.pdf');
          //else  
          $data = file_get_contents($lok_nonsign.$file.'.pdf');
          force_download($file.'NonSE.pdf', $data);
        }else{
          //var_dump($lok_nonsign.$file.'.pdf');die;
          if($menu == 2){
            $this->cetak_sk($id_daftar,$menu); // ke membuat docx dan pdf
          }
          echo "file sudah tidak ada.";
          die;
        }
      }	
    } 
  }
  
  public function cetak($id_daftar=NULL, $jenis=NULL) {
  	$permohonan = new tmpermohonan();
  	$permohonan->get_by_id($id_daftar);
  	$nodaftar = $permohonan->pendaftaran_id;
  	$lok_esign = 'assets/esignfile/';
  	$lok_nonSE = 'assets/skpdf/';
    $this->load->helper('download');
    $fileSK = str_replace(' ', '','SK_'.$nodaftar);
    $fileKP = str_replace(' ', '','KP_'.$nodaftar);
    switch($jenis) {
		  case 'se':   // SK/izin(SE)
        if(file_exists($lok_esign.$fileSK.'.pdf')){             // cek PDF SK atau Izin yang sudah SE
          $data = file_get_contents($lok_esign.$fileSK.'.pdf');
          force_download($fileSK.'.pdf', $data);
        }
        break;
      case 'sn':   // SK/izin(NonSE)
        if(file_exists($lok_nonSE.$fileSK.'.pdf')){             // cek PDF SK atau Izin yang non SE
          $data = file_get_contents($lok_nonSE.$fileSK.'.pdf');
          force_download($fileSK.'.pdf', $data);
        }
        break;
      case 'ke':   // KP(SE)
        if(file_exists($lok_esign.$fileKP.'.pdf')){             // cek PDF KP yang sudah SE
          $data = file_get_contents($lok_esign.$fileKP.'.pdf');
          force_download($fileKP.'.pdf', $data);
        }  
        break;
      case 'kn':   // KP(NonSE)
        if(file_exists($lok_nonSE.$fileKP.'.pdf')){             // cek PDF KP yang non SE
          $data = file_get_contents($lok_nonSE.$fileKP.'.pdf');
          force_download($fileKP.'.pdf', $data);
        }
        break;  
    }
    
    
    //if($jenis=='s'){
    //	$file = str_replace(' ', '','SK_'.$nodaftar);
    //  if(file_exists($lok_esign.$file.'.pdf')){             // cek PDF SK atau Izin yang sudah SE
    //    $data = file_get_contents($lok_esign.$file.'.pdf');
    //    force_download($file.'.pdf', $data);
    //  }  
    //}
    if($jenis=='k'){
    	$file = str_replace(' ', '','KP_'.$nodaftar);
      if(file_exists($lok_esign.$file.'.pdf')){             // cek PDF KP yang sudah SE
        $data = file_get_contents($lok_esign.$file.'.pdf');
        force_download($file.'.pdf', $data);
      }  
    }
  }

  public function cetak_excel($id = null) {  // Cetak per izin
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=dataxl.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $permohonan = new tmpermohonan();
    $data_pendaftaran = $permohonan->where("id = '$id'")->get();
    $permohonan_perizinan = new tmpermohonan_trperizinan();
    $dt_link = $permohonan_perizinan->where("tmpermohonan_id = '$id'")->get();
    $dt_link = $dt_link->trperizinan_id;
    $izin = new trperizinan();
    $izin->get_by_id($dt_link);
        
    $jdl = "<tr>
             <td>".'NOMOR'."</td>
             <td>".'NOMOR PENDAFTARAN'."</td>
             <td>".'ASAL PERMOHONAN'."</td>
             <td>".'TANGGAL DAFTAR'."</td>
             <td>".'JAM DAFTAR'."</td>
             <td>".'NAMA PEMOHON'."</td>
             <td>".'TELPON PEMOHON'."</td>
             <td>".'ALAMAT PEMOHON'."</td>
             <td>".'PROVINSI'."</td>
             <td>".'KABUPATEN/KOTA'."</td>
             <td>".'KECAMATAN'."</td>
             <td>".'DESA/KELURAHAN'."</td>
             <td>".'NAMA PERUSAHAAN'."</td>
             <td>".'NAMA PIMPINAN'."</td>
             <td>".'ALAMAT PERUSAHAAN'."</td>
             
             <td>".'PERMOHONAN IZIN'."</td>
             <td>".'KODE IZIN'."</td>
             <td>".'STATUS BERKAS'."</td>
             <td>".'TANGGAL SELESAI'."</td>
             <td>".'DURASI'."</td>
             <td>".'NOMOR SURAT'."</td>
             <td>".'OBJEK IZIN'."</td>
             <td>".'KETERANGAN'."</td>
             <td>".'KONTAK PERSON'."</td>";
             
    //Menambahkan judul property
    $hitproperty = 0;
    $no_field = array('');
    for($i = 0; $i <= 100; $i++) {
      $var = "var_teknis".$i;
      if($izin->$var <> '' ){
        $aktif = $this->lib_date->array_property('11',$izin->$var);      // Aktifasi Property
        if($aktif == 'Ya') {
          $hitproperty++;
          $nfield = $this->lib_date->array_property('0',$izin->$var);// ambil no Data Field property 
          if($hitproperty == 1) {
            $no_field = array($nfield);
          }else{
            $tempArray = array($nfield);
            $no_field = array_merge ($no_field, $tempArray);
          }
        	$njdl = $this->lib_date->array_property('1',$izin->$var);// ambil judul property 
          $jdl = $jdl."<td>".$njdl."</td>";
        }
      }
    }
    
    $jdl = $jdl . "</tr>";
    echo "<table width='100%' border='0' font-size:16px;'>";
    //echo "<tr>LAPORAN PERIZINAN : ".$n_izin."</tr>";
    //echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
    //echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
    echo "</table>";
    echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
    echo $jdl; 
    
    $i=0;
    foreach ($data_pendaftaran as $row){
      $row->tmpemohon->get();
      $row->trstspermohonan->get();
      $row->tmperusahaan->get();
  	  $row->trperizinan->get();
  	  $row->tmsk->get();
  	  $row->tmpemohon->trkelurahan->get();
  	  $row->tmpemohon->trkelurahan->trkecamatan->get();
  	  $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
  	  $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
      if($row->status_berkas == "proses")
        $n_status = $row->trstspermohonan->n_sts_permohonan;
      else
        $n_status = $row->status_berkas;
      $tgl_selesai = $row->tmsk->tgl_surat_edit;
      $no_surat = $row->tmsk->no_surat_edit;
      if($no_surat === '') {
        $tgl_selesai = $row->tmsk->tgl_surat;
        $no_surat = $row->tmsk->no_surat;
      }
      
      if($tgl_selesai == '') {
        $durasi = '-';
      }else{
        $durasi = $this->lib_date->lama_durasi($row->d_terima_berkas, $tgl_selesai);
      }
      
      $i++;
      
      $isi = "<tr>
                <td>".$i."</td>
                <td>'".$row->pendaftaran_id."</td>
                <td>".$row->kd_gerai."</td>
                <td>".$row->d_terima_berkas."</td>
                <td>".substr($row->d_entry,11,8)."</td>
                <td>".$row->tmpemohon->n_pemohon."</td>
                <td>".$row->tmpemohon->telp_pemohon."</td>
                <td>".$row->tmpemohon->a_pemohon."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->n_kecamatan."</td>
                <td>".$row->tmpemohon->trkelurahan->n_kelurahan."</td>
                <td>".$row->tmperusahaan->n_perusahaan."</td>
                <td>".$row->tmperusahaan->nama_pimpinan."</td>
                <td>".$row->tmperusahaan->a_perusahaan."</td>
                
                <td>".$row->trperizinan->n_perizinan."</td>
                <td>".$row->trperizinan->kd_izin."</td>
                <td>".$n_status."</td>
                <td>".$tgl_selesai."</td>
                <td>".$durasi."</td>
                <td>".$no_surat."</td>
                <td>".$row->a_izin."</td>
                <td>".$row->keterangan."</td>
                <td>".$row->kontak_person."</td>";
                
      //Menambahkan judul property
      foreach($no_field as $cek_syarat) {
        $var = "dt_teknis".$cek_syarat;
        $nisi = '-';
        if($row->$var <> '') {
          $nisi = $row->$var;    // ambil nilai data property
          $hitung = strlen($nisi);
          $cek_posisi = strpos($nisi,'^'); 
          $cekisi = substr($nisi,$cek_posisi+1,$hitung);
          if($cekisi == '' || $cekisi == '-') {
            $nisi = substr($nisi,0,$cek_posisi);
            if($nisi == '' || $nisi == '-') $nisi = '-';
          }else{
            $nisi = $cekisi;
          }
        }
        $isi = $isi."<td>".$nisi."</td>";
      }
      $isi = $isi . "</tr>";
      echo $isi;
    }
    echo "</table>";
  }
  
	public function cetak_kp() {  // cetak ke php
session_start();

include '../config/conn.php';
include 'formattglindo.php';

        $sql= mysql_query("select akdpkendaraan.*,
						DATE_FORMAT(akdpkendaraan.tgl_kp_awal, '%Y-%m-%d') as 'tgl_kp_awal2',
							DATE_FORMAT(akdpkendaraan.tgl_kp_akhir, '%Y-%m-%d') as 'tgl_kp_akhir2',
							DATE_FORMAT(akdpkendaraan.tgl_kp_awal, '%d-%m-%Y') as 'tgl_kp_awal',
							DATE_FORMAT(akdpkendaraan.tgl_kp_akhir, '%d-%m-%Y') as 'tgl_kp_akhir',
							akdptrayek.trayek from akdpkendaraan
                       left join akdptrayek on akdpkendaraan.kode_trayek = akdptrayek.kode_trayek
                       where akdpkendaraan.id ='".$id."'");
		
        $spasi 		= "<font style='color:#FFFFFF;'>".str_repeat(".",60)."</font>";
        $spasi4 	= "<font style='color:#FFFFFF;'>".str_repeat(".",100)."</font>";
        $spasi41 	= "<font style='color:#FFFFFF;'>".str_repeat(".",80)."</font>";
        $spasi0 	= "<font style='color:#FFFFFF;'>".str_repeat(".",160)."</font>";
        $spasi02 	= "<font style='color:#FFFFFF;'>".str_repeat(".",140)."</font>";
        $spasi01 	= "<font style='color:#FFFFFF;'>".str_repeat(".",130)."</font>";
        $spasi1 	= "<font style='color:#FFFFFF;'>".str_repeat(".",10)."</font>";
        $spasi2 	= "<font style='color:#FFFFFF;'>".str_repeat(".",40)."</font>";
        $spasi3 	= "<font style='color:#FFFFFF;'>".str_repeat(".",30)."</font>";
        $spasi32 	= "<font style='color:#FFFFFF;'>".str_repeat(".",50)."</font>";
        $spasi33 	= "<font style='color:#FFFFFF;'>".str_repeat(".",40)."</font>";
        $spasi31 	= "<font style='color:#FFFFFF;'>".str_repeat(".",50)."</font>";
        $spasi5 	= "<font style='color:#FFFFFF;'>".str_repeat(".",5)."</font>";
        $spasi10 	= "<font style='color:#FFFFFF;'>".str_repeat(".",10)."</font>";
		
		echo "
		<style>
		
		.add{line-height:18px;}
		.add2{
			line-height:18px;
			margin-left:180px;
			font-size:13.5px; 
		}
		.add3{
			line-height:15px;
			margin-left:180px;
			font-size:13.5px; 
		}
		.add4{
			line-height:19px;
			margin-left:168px;
			font-size:14px; 
		}
		</style>
		";
		while($row = mysql_fetch_array($sql)) {
            echo "<page style='font-size: 12px'>";
			
				$cari	=	mysql_fetch_array(
								mysql_query("
									select * from kepala_badan where pangkat = 'Pembina Utama Madya'
								")
							);
			echo "<div style='height:200px;position:absolute;right:83px;top:665px;'>";
			echo "<font class='add2' style='font-size:13px;!important;'><u>$cari[nama]</u></font>";
			echo "<br/>";
			echo "<font style='font-size:10px;margin-left:230px;'>$cari[pangkat]</font><br>";
			echo "<font style='margin-left:220px;font-size:10px;'>NIP". $cari['nip']."</font>";
			echo"</div>";
			
			echo "<div style='height:3px;width:700px;position:absolute;right:20px;top:150px;background-color:black;'>";
			echo"</div>";
			
			echo "<div style='height:2px;width:700px;position:absolute;right:20px;top:145px;background-color:black;'>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:285;top:170px;'>";
			echo "<font style='font-size:20px;!important;font-weight:bold;text-decoration:underline'>KARTU PENGAWASAN</font>";
			echo"</div>";
			
			echo "<div style='height:80px;width:665px;border:solid 1px;position:absolute;right:50px;top:355px;'>";
            echo "<table width='100%'>";
            echo "<tr><td></td><td><font style='font-size:13px;'>".wordwrap($row['trayek'],80,"<br>\n")."</font></td></tr>";
            echo "</table>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:150;top:470px;'>";
			echo "<font style='font-size:14px;!important;font-weight:bold;'>Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut : </font>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:257;top:540px;'>";
			echo "<font style='font-size:12px;!important;'>Diberikan di Bandung<br>Tanggal :</font>";
			echo"</div>";

			echo "<div style='height:100px;position:absolute;right:50;top:575px;text-align:center'>";
			echo "<font style='font-size:12px;!important;'>BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU<br>PROVINSI JAWA BARAT</font>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;left:40px;top:515px;'>";
			echo "<font style='font-size:14px;!important;line-height:19px;'>Nomor Kendaraan<br>
							Nomor Uji<br>
							Daya Angkut Penp.<br>
							Daya Angkut Barang<br>
							Jenis Kendaraan<br>
							Merk/Tahun Pemb.<br>
							Bahan Bakar<br>
							Jenis Pelayanan<br>
							Kode Trayek<br>
							Sifat/Fasilitas Pel.<br>
							Nama Pemilik<br>
							Alamat Pemilik
						</font><br>
						<font style='font-size:14px;!important;font-weight:bold;text-decoration:underline;'>Kewajiban Pengusaha Angkutan tercantum dibalik Kartu Pengawasan ini</font>
						";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:40px;top:40px;text-align:center'>";
			echo "<font style='font-size:22px;!important;font-weight:bold;'>PEMERINTAH PROVINSI JAWA BARAT<BR>BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU</font>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:125;top:100px;text-align:center'>";
			echo "<font style='font-size:14px;!important;'>Jalan Sumatera No. 50 Telepon (022)4237369 Fax: (022) 4237081<BR>BANDUNG - 40115</font>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;left:40px;top:800px;'>";
			echo "<font style='font-size:15px;!important;'>DAFTAR WAKTU PERJALANAN (DWP) NO. INDUK KEND :</font>";
			echo "<font style='font-size:15px;!important;margin-left:70px;'>NO. INDUK PERSH :</font><br>";
			echo "<font style='font-size:15px;!important;'>NAMA PO : </font>";
			echo"<br>";
			echo"<br>";
			echo"<font style='font-size:13px;!important;margin-left:25px'>TEMPAT</font>";
			echo"<font style='font-size:13px;!important;margin-left:190px'>TEMPAT</font>";
			echo"<font style='font-size:13px;!important;margin-left:190px'>TEMPAT</font><br>";
			echo"<font style='font-size:13px;!important;'>PERSINGGAHAN</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>TIBA</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>BERANGKAT</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px;'>PERSINGGAHAN</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>TIBA</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>BERANGKAT</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px;'>PERSINGGAHAN</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>TIBA</font>";
			echo"<font style='font-size:13px;!important;margin-left:9px'>BERANGKAT</font>";
			echo"</div>";
			
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<font style='font-size:13px;margin-left:267px;'><b>Nomor : </b>".$row['no_kp']."</font><br/>";
            echo "<br/>";
            echo "<font style='margin-left:100px;font-size:13px;' class='add'>Berdasarkan Keputusan Kepala Badan Penanaman Modal dan Perijinan Terpadu Provinsi Jawa Barat Nomor :</font><br>";
			echo "<br>";
             echo "<font style='margin-left:35px;font-size:13px;' class='add'>".$row['no_sk']."</font><font style='margin-left:60px;font-size:13px;' class='add'>Tanggal</font>
					<font style='font-size:13px;margin-left:53px;'>".DateToIndo($row['tgl_penetapan_kp'])."</font><font style='margin-left:60px;font-size:13px;' class='add'>tentang Izin</font>
					<font style='font-size:12;margin-left:43px;'>Trayek</font>";
			echo "<br>";
            echo "<font style='font-size:13px;margin-left:35px;'>Angkutan Penumpang Umum, diberikan Kartu Pengawasan kepada : ".$row['nama_perusahaan']."</font>";
			echo "<br>";
			echo "<br>";
            echo "<font style='font-size:13px;margin-left:35px;'>yang dipimpin oleh : </font><font style='margin-left:0px;font-size:10.5px;' >".$row['nama_pimpinan']."</font>"."
						<font style='font-size:13px;margin-left:0px;'> alamat </font><font style='font-size:10.5px;margin-left:0px;'>". $row['alamat_pimpinan']."</font>";
			echo "<br/>";
            echo "<font style='margin-left:35px;font-size:13px;'>Dari Tanggal ".DateToIndo($row['tgl_kp_awal2'])."</font>
					<font style='font-size:13px;margin-left:30px;' class='add'> sampai dengan tanggal </font>
					<font style='font-size:13px;margin-left:39px;' class='add'>".DateToIndo($row['tgl_kp_akhir2'])."</font>";
			echo "<br>";
            echo "<font style='font-size:13px;margin-left:35px;'>dengan menggunakan bis/mobil penumpang pada Lintasan Trayek :</font>";
			echo "<br>";
			echo "<br>";
            // echo "<table width='100%'>";
            // echo "<tr><td style='width:43px'></td><td align='center'><font style='font-size:13px;'>".wordwrap($row['trayek'],80,"<br>\n")."</font></td></tr>";
            // echo "</table>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
			
				if(!empty($row['info']))
				{
					echo "<font style='font-size:8px;margin-left:50px;'>".$row['info']."</font>";
				}
				if(empty($row['info']))
				{
					// echo "<br>";
				}
				date_default_timezone_set("Asia/Jakarta"); 
				$time	=	date('H:i:s');
				
            echo "<br/>";
            echo "<br/>";
			
			//echo "<p style='line-height:16.5px;'><font style='font-size:13px;!important'>";
			
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
			echo "<font class='add4'> : ".$row['no_kend']."</font><br/>";
            echo "<font class='add4'> : ".$row['no_uji']."</font><br/>";
            echo "<font class='add4'> : ".$row['daya_angkut_org']." Orang</font><font class='add3' style='margin-left:200px;!important;'>".DateToIndo(date("Y-m-d"))."</font><br/>";
            echo "<font class='add4'> : ".$row['daya_angkut_brg']." Kg</font><br/>";
            echo "<font class='add4'> : ".$row['jenis_kend']."</font><br/>";
            echo "<font class='add4'> : ".$row['merek']." / ".$row['tahun']."</font><br/>";
            echo "<font class='add4'> : ".$row['bahan_bakar']."</font><br>";
			
			//echo "<font style='font-size:13px;!important'>";
            echo "<font class='add4'> : ".$row['jenis_pel']."</font><br/>";
            echo "<font class='add4'> : ".$row['kode_trayek']."</font><br/>";
            echo "<font class='add4'> : ".$row['sifat_pel']."</font><br/>";
            echo "<font class='add4'> : ".$row['nama_pemilik']."</font><br/>";
            echo "<font class='add4'> : ".$row['alamat_pemilik']."</font><br/>";
			
			//echo "</font><br><br>";
			
			echo "<br>";
			echo "<br>";
			$far	=	substr($row['user_bo'],0,3);
			echo "<font style='font-size:10px;margin-left:40px;'>".$row['tgl_kp_awal'].$time;
			echo $spasi5;
			echo $row['no_sk']." ".$far;
			echo $spasi5;
			echo "";
			echo $spasi4.$spasi10.$spasi10;
			echo $row['tgl_kp_akhir'];
			echo "</font>";
			echo "<br>";
			echo "<font style='font-size:10px;margin-left:30px;'>$row[ket]</font>";
			
			$kondisi	=	substr($row['kode_trayek'],-4,1);
			if($kondisi=="L")
			{
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<div style='border:4px double black;width:615px;margin-left:50px;padding:15px 10px;word-wrap:break-word;'>";
				
				echo "<table>";
				
				echo "<tr>";
				echo "<td colspan=3>";
				echo "<font style='font-size:13px'><u>Rute yang ditetapkan dalam Wilayah Kota Bandung sbb :</u></font>";
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td width=25%>";
					echo "</td>";
					echo "<td style='width:10px'>";
					echo "</td>";
					echo "<td style='word-wrap:break-word;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td width=25%>";
					echo "<font style='font-size:13px'><b>KELUAR</b></font>";
					echo "</td>";
					echo "<td style='width:10px'>";
					echo ":";
					echo "</td>";
					echo "<td style='word-wrap:break-word;'>";
					echo "<font style='font-size:12px'>".wordwrap("Term.Leuwi Panjang - Jl.Kopo - Jl.Soekarno Hatta(PS.Induk Caringin) - Jl.Soekarno Hatta - Jl.Moch.Toha - Pintu Tol Moch.Toh",100,"<br>",true)."</font>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td width=25%>";
					echo "</td>";
					echo "<td style='width:10px'>";
					echo "</td>";
					echo "<td style='word-wrap:break-word;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
					echo "<font style='font-size:13px'><b>MASUK</b></font>";
					echo "</td>";
					echo "<td>";
					echo ":";
					echo "</td>";
					echo "<td>";
					echo "<font style='font-size:12px'>".wordwrap("Pintu Tol Moch.Toha - Jl.Moch.Toha - Jl.Soekarno Hatta - Jl.Leuwi Panjang - Term.Leuwi Panjang",100,"<br>",true)."</font>";
					echo "</td>";
				echo "</tr>";
				
				echo "</table>";
				echo "</div>";
			}
			/*
            echo "<table align=left width='100%'>";
            echo "<tr><td style='width:70px;padding-left:175px;'>".$row['jenis_pel']."</td><td></td></tr>";
            echo "<tr><td style='width:70px;padding-left:175px;'>".$row['kode_trayek']."</td><td>Drs. H. DEDE RUSDIA, MAP</td></tr>";
			
            echo "<tr><td style='width:70px;padding-left:175px;'>".$row['sifat_pel']."</td><td>19570313 198503 1010</td>";
            echo "</tr>";
            echo "<tr><td style='width:70px;padding-left:175px;'>".$row['nama_pemilik']."</td><td></td>";
            echo "</tr>";
            echo "<tr><td style='width:70px;padding-left:175px;'>".$row['alamat_pemilik']."</td><td></td>";
            echo "</tr>";
            echo "</table>";
            */
			
			//echo $spasi.$row['kode_trayek'].$spasi."Drs. H. DEDE RUSDIA, MAP<br/>"."<br/>";
            //echo $spasi.$row['sifat_pel'].$spasi2."19570313 198503 1010<br/>"."<br/>";
            //echo $spasi.$row['nama_pemilik']."<br/>";
            echo "</page>";
		}
	}

	public function cetak_sk_pdf($uid = NULL) {
		$this->load->library('fpdf');
        $syarat = $this->input->post('pilih_cetak');
        $syarat_len = count($syarat);
		$cek_len = count($syarat) - 1;
		$is_array = NULL;
		
        for ($i = 0; $i < $syarat_len; $i++) {
            $is_array = $syarat[$i];
        }

        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
		$list_state = $gerai;

        // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        $n_logo = base_url(). 'uploads/logo/ttd.png';

        // Ambil Penanda tangan
        $this->pegawai->where('status', '1')->get();
        $n_peg = $this->pegawai->n_pegawai;
		$n_pangkat = $this->pegawai->pangkat_gol;
		$cek_posisi = strpos($n_pangkat,'(');
		$n_pangkat = substr($n_pangkat,0,$cek_posisi);
		$n_nip = $this->pegawai->nip;

		// Ambil Pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17)->value;

        // Ambil Badan
        $this->tr_instansi = new Tr_instansi();
        $nama_badan = $this->tr_instansi->get_by_id(9)->value;

        // Ambil Alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10)->value;

        // Ambil Fax
        $this->tr_instansi = new Tr_instansi();
        $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22)->value;
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;
        $judul1 = 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla).' - '.$this->lib_date->mysql_to_human($tglb);
		$judul2 = 'Asal Permohonan : ' . $c_asal;

        //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
		//$pdf = new FPDF();
		$pdf = new FPDF('P','mm','LETTER'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), legal'=>array(612,1008));
		//$pdf->SetMargins(0,20,0); //$pdf->SetMargins(kiri,atas,kanan);
//		$pdf->AddPage();
/**		$pdf->Image($n_logo,2,5,22);
		$pdf->SetFont('Arial','B',15);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','B',16);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.1); $pdf->Line(1,33,209,33);
		$pdf->SetLineWidth(0.5); $pdf->Line(1,34,209,34);

        $pdf->SetFont('Arial','',11);
		$pdf->Ln(13); $pdf->Cell(0,0.5,$judul1,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul2,0,1,'C');
**/
        $Wpaper = 262;
		$Hpaper = 450;
        $brs = 20;
		$pdf->AddPage('P',array($Hpaper,$Wpaper));
		$pdf->SetMargins(0,0,0);  //$pdf->SetMargins(kiri,atas,kanan);
		//$pdf->SetAutoPageBreak('ON', 60);  //63
		$pdf->SetTopMargin($brs);
		$pdf->SetLeftMargin(10);
		$pdf->SetRightMargin(10);
        $tinggikop = $tinggi_kop; //dapat diubah untuk menentukan tinggi kop surat yang ada
		$pdf->Ln($tinggikop);
		//cek kesamaan jenis izin
		for ($is = 0; $is < $syarat_len; $is++) {
            $permohonan = new tmpermohonan();
            $permohonan = $permohonan->get_by_id($syarat[$is]);
            $perizinan = $permohonan->trperizinan->get();
			$n_izin = $perizinan->n_perizinan;
			$alenia1 = $perizinan->sk_alenia1;
			if($is == 0){
				$id_izin = $perizinan->id;
				$id_sama = TRUE;
			}else{
			    if($id_izin != $perizinan->id){
                    $id_sama = FALSE;
					break;
				}
			}
		}
        
		$permohonan = new tmpermohonan();
        $permohonan = $permohonan->get_by_id($uid);
        $perizinan = $permohonan->trperizinan->get();
		$n_izin = $perizinan->n_perizinan;
		$alenia1 = $perizinan->sk_alenia1;
        
		$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('status', '1')->get();
		$n_jab_kepala = $pegawai->n_jabatan;

		$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('status', '2')->get();
		$n_jab_kabid = $pegawai->n_jabatan;
		$spc  = ''; for ($a = 1; $a < 10; $a++) $spc .= ' ';   //'          ';
		$sp = 0;
		$br1  = 'NOTA PENJELASAN';
		$br2  = '';
		$br3  = 'Kepada';
		$br3a = $n_jab_kepala; //'Kepala Badan';
		$br4  = 'Dari';
		$br4a = $n_jab_kabid;  //'Kepala Bidang Pelayanan';
		$br5  = 'Perihal';

		if($id_sama)
		    $br5a = 'Permohonan Penandatanganan Surat '.ucwords(strtolower($n_izin));
		else
            $br5a = 'Permohonan Penandatanganan Surat Izin';

		$kalimat = $alenia1;
		$loop = 100;
		for ($a = 1; $a <= $loop; $a++) {
            $br6 = strpos($kalimat,"#$");
            $br6_akhir = strpos($kalimat,"$#");
	    	if($br6){ // jika ada
		        $kata_kunci = substr($kalimat,$br6,$br6_akhir - $br6 + 2);
//			    isi_property($uid, $var = NULL, 5) // untuk ambil isi variabel properti
//              field_property($v_id = NULL, $var = NULL, $pil = NULL) { // mengambil data properti per field {v_id=no_id_izin, var=nomor filed, pil = pilihan output}
		        $br6 = str_replace($kata_kunci, "INI KATA PENGGANTINYA", $kalimat);  // ubah kata
    		}else{
	    		$br6 = $kalimat;
                $a = $loop;
    		}
            $kalimat = $br6;
		}
		$br7  = 'Sehubungan dengan hal tersebut proses penelitian berkas telah sesuai dengan ketentuan yang berlaku sehingga dapat diterbitkan naskah perizinan untuk ditandatangani Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat';
		$br9  = 'Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut :';
		$br10 = 'Bandung, '.$this->lib_date->mysql_to_human(date('Y-m-d'));
		$br11 = $n_jab_kabid;
		$br12 = $pegawai->n_pegawai;
		$br13 = $pegawai->pangkat_gol;
		$br14 = 'NIP. '.$pegawai->nip;
		$tab = 30;

        $pdf->SetFont('times','U',20);
		$pdf->Ln(15); $pdf->Cell(0,0,$br1,2,2,'C');
		$pdf->SetFont('times','',16);
		$pdf->Ln(7);  $pdf->Cell(0,0,$br2.$spc.$spc,0,1,'C');
		$pdf->Ln(15); $pdf->Cell(0,0,$br3,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br3a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br4,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br4a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br5,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br5a,0,'J');

        $pdf->Ln(5);  $pdf->SetLineWidth(0.2);
                      $pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
		$pdf->Ln(1);  $pdf->SetLineWidth(0.6);
                      $pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
        $pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br6,0,'J');
		//Mencetak judul dengan tinggi bervariasi
		$pdf->SetFont('times','',12);
		$jd1 = 'NO';
		$jd2 = ' NO PENDAFTARAN '.' TANGGAL DAFTAR ';
		$jd3 = 'NAMA PEMOHON';
		if($id_sama)
		    $jd4 = '         NOMOR SURAT         '.'         TANGGAL SURAT         ';
		else
			$jd4 = 'NAMA IZIN';
		$judul = array($jd1,$jd2,$jd3,$jd4);
		$l_col = array(10,55,75,90); 
		$align = array('C','C','C','C');
		$hit_judul = count($judul);

		$pdf->Ln(5);
        $space = 5;
		$nb=0;
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
		// Create box
        for($i=0;$i<count($judul);$i++){
            $nb=max($nb,$pdf->NbLines($l_col[$i],$judul[$i]));
		}
        $h=$space*$nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($judul);$i++) {
            $w=$l_col[$i];
            $a=isset($align[$i]) ? $align[$i] : 'L';
            //Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            //Draw the border

            $pdf->Rect($x,$y,$w,$h);
            //Print the text

            $pdf->MultiCell($w,$space,$judul[$i],0,$a);
            //Put the position to the right of the cell
            $pdf->SetXY($x+$w,$y);
        }
        //Go to the next line
        $pdf->Ln($h);
        //EOF(Mencetak judul dengan tinggi bervariasi)

		//cetak isi tabel ke pdf
	    $no = 0;
		for($ai=0; $ai<$syarat_len; $ai++){
            $permohonan = new tmpermohonan();
            $permohonan = $permohonan->get_by_id($syarat[$ai]);
            $perizinan = $permohonan->trperizinan->get();
			$pemohon = $permohonan->tmpemohon->get();
			$perusahaan = $permohonan->tmperusahaan->get();
			$sk = $permohonan->tmsk->get();
            
			// EOF() barcode
            //OLD Create Barcode
			//$color_black = new BCGColor(0, 0, 0);
            //$color_white = new BCGColor(255, 255, 255);
            //$code = new BCGcode128();
            //$code->setThickness(25);
            //$code->setForegroundColor($color_black); // Color of bars
            //$code->setBackgroundColor($color_white); // Color of spaces
            //$code->parse($permohonan->pendaftaran_id); // Text
            //$drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
            //$drawing->setBarcode($code);
            //$drawing->draw();
            //$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
			//$b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
			//$b_code = base_url(). 'assets/barcode/51.png';
			// EOF() OLD Barcode

            //NEW BARCODE
    		$font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
            $text = isset($_GET['text']) ? $_GET['text'] : $permohonan->pendaftaran_id;
            // The arguments are R, G, B for color.
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);
            $drawException = null;
            try {
                 $code = new BCGcode128();
                 $code->setScale(2); // Resolution
                 $code->setThickness(30); // Thickness
                 $code->setForegroundColor($color_black); // Color of bars
                 $code->setBackgroundColor($color_white); // Color of spaces
                 $code->setFont(0); // $font or 0
                 $code->parse($text); // Text
               } catch(Exception $exception) {
                 $drawException = $exception;
               }
           /* Here is the list of the arguments
           1 - Filename (empty : display on screen)
           2 - Background color */
           ///$drawing = new BCGDrawing('', $color_white);
           $drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
           if($drawException) {
               $drawing->drawException($drawException);
           } else {
               $drawing->setBarcode($code);
               $drawing->draw();
           }
           //$drawing->setFilename('barcode.png');
           ///header('Content-Type: image/png');
           ///header('Content-Disposition: inline; filename="barcode.png"');
           // Draw (or save) the image into PNG format.
           $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		   $b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
           //EOF() NEW BARCODE


			$nama = $perusahaan->n_perusahaan;
			$alamat = $perusahaan->a_perusahaan;
			if($nama == ''){
			    $nama = $pemohon->n_pemohon;
			    $alamat = $pemohon->a_pemohon;
			}
			$no++;
			if($id_sama)
			    $isi = array($no.'.',
				         $permohonan->pendaftaran_id .'  '.'                                             '. $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
				         $nama.' Alamat:'.$alamat,
				         $sk->no_surat.' Tanggal: '.$this->lib_date->mysql_to_human($sk->tgl_surat),
				         );
			else
				$isi = array($no.'.',
				         $permohonan->pendaftaran_id .'  '.'                                             '. $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
				         $nama.' Alamat:'.$alamat,
				         ucwords(strtolower($perizinan->n_perizinan)),
				         );
    		$align = array('R','L','L','L');
            $space = 5;
   	    	$nb=0;
   
			$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
            // Create box
			for($i=0;$i<count($isi);$i++)
                $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
            $h=$space*$nb;
            //Issue a page break first if needed
            $pdf->CheckPageBreak($h);

            //Inisialisasi ulang halaman baru
            if($pdf->GetY()+$h >= 400){ //400
                $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
                $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
                //$pdf->SetAutoPageBreak('ON', 63);
                $pdf->SetTopMargin($brs);
                $pdf->SetLeftMargin(10);
                $pdf->SetRightMargin(10);
				$pdf->SetFont('times','',12);
                $pdf->SetY($brs);
				$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
            }

            //Draw the cells of the row
            for($i=0; $i<count($isi); $i++) {
				$w=$l_col[$i];
                $a=isset($align[$i]) ? $align[$i] : 'L';
                //Save the current position
                $x=$pdf->GetX();
                $y=$pdf->GetY();
                //Draw the border
                $pdf->Rect($x,$y,$w,$h);
                //Print the text
                $pdf->MultiCell($w,$space,$isi[$i],0,$a);
				if($i==0){
					$ypos_bc = $pdf->GetY();
				    $pdf->Image($b_code,$x+$l_col[0]+2,$ypos_bc-0.5,30);   // matikan jika ingin tidak menampilkan barcode
				}
                //Put the position to the right of the cell
                $pdf->SetXY($x+$w,$y);
            }

            //Inisialisasi ulang halaman baru
            //if($y >= 370){
            //    $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
            //    $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
            //    $pdf->SetY($brs);
    		//	$y=$pdf->GetY();
                //$pdf->Ln($tinggikop);
            //}
    		// EOF() Cetak Full

            //Go to the next line
            $pdf->Ln($h);
	        unlink('assets/barcode/' . $syarat[$ai] . '.png');
		}
        // EOF(cetak isi tabel ke pdf)

		if($pdf->GetY() > 330){ // nilai sesuaikan dengan coba tampilan diatas
            $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
            $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
            $pdf->SetY($brs);
    	    $y=$pdf->GetY();
            //$pdf->Ln($tinggikop);
        }
		$pdf->SetFont('times','',16);
		$pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br7,0,'J');
		$pdf->Ln(25); 
                     $pdf->Cell(160); $pdf->Cell(0,0,$br10,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br11,0,1,'C');
					 $a = $pdf->GetY();
        //			 $pdf->Image($n_logo,155,$pdf->GetX()+$a+2,35);
		    $pdf->Ln(30);$pdf->Cell(160); $pdf->Cell(0,0,$br12,0,1,'C');
		    $pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br13,0,1,'C');
		    $pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br14,0,1,'C');
        // EOF() ttd

		    $n_file=$permohonan->pendaftaran_id.'NP_'.$no.'.pdf';
		    $pdf->Output($n_file,'D');
  }
  
  public function sql2($u_ser){
    $query = "select a.description
              from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }
  
  public function getDatahukum($id){
    $query = "select a.id,a.trdasar_hukum_id,a.trperizinan_id
              from trdasar_hukum_trperizinan as a
              inner join trperizinan as b on b.id=a.trperizinan_id
              inner join trdasar_hukum as c on c.id = a.trdasar_hukum_id
              where a.trperizinan_id = '".$id."' and c.type=0";
    $hasil = $this->db->query($query);
    return $hasil->result();
  }
  
  public function getTinjauan($daftar, $izin, $jnsProp) {
    $query = "select a.id,a.v_property,a.v_tinjauan from tmproperty_jenisperizinan as a
              inner join tmpermohonan_tmproperty_jenisperizinan as b on b.tmproperty_jenisperizinan_id=a.id
              inner join tmpermohonan as c on c.id=b.tmpermohonan_id
              inner join tmproperty_jenisperizinan_trproperty as d on d.tmproperty_jenisperizinan_id=a.id
              inner join trproperty as e on e.id=d.trproperty_id
              where c.id='".$daftar."' and e.id='".$jnsProp."'";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function copai() {
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $dtpdf = 'https://apisimpatik.jabarprov.go.id.jabarprov.go.id/nrspdf/web/assets/skpdf/' .preg_replace('/\s/i', '%20', 'SK_0284147401032019175'). '.pdf';
          $newfile = $_SERVER['DOCUMENT_ROOT']. '/jelita/backoffice/assets/skpdf/SK_0284147401032019175.pdf';
          if (copy($dtpdf, $newfile)) {
            $draft = TRUE;
            file_get_contents('https://apisimpatik.jabarprov.go.id.jabarprov.go.id/nrspdf/web/index.php?r=site%2Fdelsicantik&id=SK_0284147401032019175&token=m1WOvGqS7G', FALSE, $context);
            echo 'Sukses';die;
          }
  }

  public function cetak_lampiran($id, $id_izin){
        $this->load->helper('download');

        $data = array();

        $pegawai = $this->db->get_where("tmpegawai",array("status"=>"1"))->first_row();

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

          $arr = array($jab, $nmjbt[1], $nmjbt[2], $nmjbt[3], $nmjbt[4], $nmjbt[5], $nmjbt[6], $nmjbt[7], $nmjbt[8], $nmjbt[9]);
          $jbt = implode(" ", $arr);
        } else {
          $jbt = strtoupper($jbt);
        }

        $ttd_kepala  = $pegawai->n_pegawai;
        $ttd_pangkat = $pegawai->pangkat_gol;
        $ttd_nip     = $pegawai->nip;
        $ttd_jabatan = $jbt;
        $image_path = 'uploads/logo/'.str_replace(' ', '', $ttd_nip).'.png';

        $data['ttd_kepala']  = $ttd_kepala;
        $data['ttd_pangkat'] = $ttd_pangkat;
        $data['ttd_nip']   = $ttd_nip;
        $data['ttd_jabatan'] = $ttd_jabatan;
        $data['ttd_img']   = $image_path;

        $online = 0;
        $p_daftar = $this->permohonan->get_by_id($id);
        $nama_perus = $this->permohonan->tmperusahaan->n_perusahaan;

        if ($p_daftar->kd_gerai === 'OnLine') {
          $online = 1;
        }

        $jml_property = $this->lib_date->data_property($id_izin,'1');
        $i = 1;
        $stat_property = TRUE;
        $text = $this->lib_date->data_property($id_izin,'2');
        if($jml_property > '1') {
          $text = $this->lib_date->sort_property($id_izin, $text);
        }
        $jml = '';

        $data['id_daftar'] = $id;
        $data['text'] = $text;
        $data['n_perus'] = $nama_perus;

        $jml = 0;

        $list1 = explode (",",$text);
        foreach($list1 as $datas){
          $property_aktif = $this->lib_date->array_property('11',$datas);   // Aktifasi Property
          $data_property = $this->lib_date->isi_property($id, $this->lib_date->array_property('0',$datas), '1');
          $property_type = $this->lib_date->array_property('9',$datas);     // Type Property
          $hitung = strlen($data_property);
          $cek_posisi = strpos($data_property,'^'); 
          $cek_data = substr($data_property,$cek_posisi+1,$hitung);
          if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
          if($property_aktif == 'Ya' && $property_type != 'Array') {
            if($cek_data == '-')
              $data_property = substr($data_property,0,$cek_posisi);
            else
              if($online == 1)
                $data_property = substr($data_property,$cek_posisi,$hitung);
              else  
                $data_property = substr($data_property,$cek_posisi+1,$hitung);
          }else{
            $data_property = substr($data_property,$cek_posisi+1,$hitung);
          }
          $data_property = str_replace('^','',$data_property);

          if($property_type == 'Jumlah') {
            if($property_aktif == 'Ya' && $property_type != 'Array') {
              $jml = $data_property;
            }
          }

          if($property_aktif == 'Ya' && $property_type != 'Array') {
            $i++;
          }
        }

        $data['jml'] = $jml;

        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->load->view('cetak_lampiran.php',$this->session_info);

        $file = 'LAMPIRAN_'.$p_daftar->pendaftaran_id;

        $paper_size  = 'Legal'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $output = $this->dompdf->output();
        file_put_contents('assets/sklampiran/'.$file.'.pdf', $output);
        $datap = file_get_contents('assets/sklampiran/'.$file.'.pdf');
        force_download('LAMPIRAN_'.$p_daftar->pendaftaran_id.'.pdf', $datap);
        //$this->dompdf->stream("cetak daftar kendaraaan id $id.pdf", array('Attachment'=>0));
               
    }

    public function test_pdf() {
        $namafile = preg_replace('/\s/i', '%20', "111_SK"); //isi 'namafile' dengan value nama file
        $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);
        $data = file_get_contents('https://apisimpatik.jabarprov.go.id/nrspdf/web/index.php?r=site%2Findex&id='.$namafile, FALSE, $context);
        if($data && $data == 'OK') {
          $dtpdf = 'https://apisimpatik.jabarprov.go.id/nrspdf/web/assets/skpdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
          $newfile = $_SERVER['DOCUMENT_ROOT']. '/jelita/backoffice/assets/skpdf/'.$namafile.'.pdf';
          if (copy($dtpdf, $newfile)) {
            $draft = TRUE;
            file_get_contents('https://apisimpatik.jabarprov.go.id/nrspdf/web/index.php?r=site%2Fdelsicantik&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
            //$this->session->set_flashdata('sukses', "Berhasil Refresh Dokumen Dan Konversi PDF.");
            echo 'Sukses';
          }
        }else{
          //$this->session->set_flashdata('gagal', "Gagal Konversi PDF, Silahkan mengulangi proses.");
          echo "Gagal";
        }
    }

    public function notif($tgla=NULL,$tglb=NULL,$kt_cari=NULL) {

    $no_daftar = $kt_cari;
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();

    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable

    $pegawai = new tmpegawai_user();
    $pegawai->where('user_id', $username->id)->get();

    $idpeg = $pegawai->tmpegawai_id;
    $iduser = $username->id;

    if($this->All){
      $query = "SELECT A.id AS idpermohonan, A.*, K.*, E.telp_pemohon, P.email AS emailp 
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpermohonan_tmperusahaan AS O ON A.id = O.tmpermohonan_id
                LEFT JOIN tmperusahaan AS P ON O.tmperusahaan_id = P.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0";
        if ($no_daftar != 0) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";
        }
    }else{
      $query = "SELECT A.id AS idpermohonan, A.*, K.*, E.telp_pemohon, P.email AS emailp
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpermohonan_tmperusahaan AS O ON A.id = O.tmpermohonan_id
                LEFT JOIN tmperusahaan AS P ON O.tmperusahaan_id = P.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND L.user_id = '".$username->id."'";
        if ($no_daftar != 0) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";
        }
    }

    	$sql = $this->db->query($query);

    	if(empty($sql)) {
    		$this->session->set_flashdata('gagal', "Data tidak ditemukan.");
    		redirect('permohonan/sk');
    	}

    	//$angka = $sql->num_rows;

    	$counter  = 0;
    	require_once("assets/plugins/phpmailer/class.phpmailer.php");
        require_once("assets/plugins/phpmailer/class.smtp.php");

    	foreach ($sql->result() as $row) {
    		$id_portal = $row->id_pemohon_portal;
    		$id = $row->idpermohonan;

    		$notif = $this->db->get_where('tmpermohonan_notif_log', array('tmpermohonan_id' => $id))->first_row();

    		if (empty($notif)) {
    			if(file_exists('assets/esignfile/SK_'.$row->pendaftaran_id.'.pdf')) {
    				$jm = 1;
		    		if($id_portal > 0){ //untuk pendaftaran OnLine
		    	    	$pemohon_portal = new tmpemohon_portal();
			        	$pemohon_portal->get_by_id($id_portal);
		                $n_hp = $pemohon_portal->telpPemohon;
				        $n_email = $pemohon_portal->emailPerusahaan;
						$stat = '<Bawa Resi Asli & Tunjukkan SMS ini>'; //max 35 dgt
				    } else {
		                $n_hp = $row->kontak_person;
						$n_hp2 = $row->telp_pemohon;
		                if($n_hp != $n_hp2) $jm = 2;
		                $n_email = $row->emailp;
						if($n_email == '') $n_email = '-';
						$stat = '<Bawa Tanda Terima Berkas Asli>'; //max 35 dgt
					}

					$i_ok='T';
		    		if($row->no_surat == 'Ditolak') $i_ok='F';

		    		$n_judul = 'Status Perizinan';
					if($i_ok=='T') {
			    	    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$row->pendaftaran_id.' DISETUJUI, dan dapat dicetak pada Dashboard pendaftaran. 
							\n abaikan pesan ini jika telah menerima/cetak mandiri izin.';
					}
					else {
					    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$row->pendaftaran_id.' DITOLAK, silahkan hubungi Call Center DPMPTSP Jabar untuk info lebih lanjut. 
							\n abaikan pesan ini jika telah menerima/cetak mandiri izin.';
					}
		    		$jum_in_pesan = 10;

		    		$this->settings->where('name', 'smsGateway')->get();
		            if($this->settings->status == 1) {
		            	$campaign 	= 'Penyerahan';
				        $username   = 'dpmptspjbr';
				        $password   = '4RrtRM5X';
				        if ($jm == 2) {
				          $receiver = $n_hp.",".$n_hp2;
				          $method   = 'multiple';
				        } else {
				          $receiver = $n_hp;
				          $method   = 'single';
				        }
				        //$receiver = '082117788286';
				        $message  = urlencode($n_pesan);

				        $url = 'http://103.111.57.219/eskalasi/public/messaging/request?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message.'&campaign='.$campaign;

				        $data = file_get_contents($url);
				        if ($data) {
				          $json = json_decode($data);
				          if (isset($json->status)) {
				            if ($json->status == 200) {
				              $sendS = TRUE;
				            } else {
				              $sendS = FALSE;
				            }
				          }
				        }
		            }

		            $this->settings->where('name', 'send_mail')->get();
					if ($this->settings->status == 1) {
						if($n_email != '-'){
			    		    $host             =	"smtp.gmail.com";
		        		    $emailpengirim    =	"dpmptspjabar@gmail.com";
		    		        $namapengirim     =	"DPMPTSP JABAR";
		    		        $password         =	"~dpmptspjabarprovgoid#";
		    	    	    $targetpengiriman =	$n_email;
		    	    	    //$targetpengiriman =	"nirwan.nrs@gmail.com";
		    		        $mailer = new PHPMailer();
		    		        $mailer->CharSet = "UTF-8";
		    	    	    $mailer->IsSMTP();
		        		    $mailer->SMTPSecure = 'tls';
		        		    $mailer->Host =$host;
		    		        $mailer->Port =587;
		    		        $mailer->SMTPAuth = true;
		    	    	    $mailer->Username = $emailpengirim;
		        		    $mailer->Password = $password;
		        		    $mailer->FromName = $namapengirim;
		    		        $mailer->From     = $emailpengirim;
		    		        $mailer->AddAddress($targetpengiriman,$targetpengiriman);
		    	    	    //Isi Data untuk e-mail
		        		    $mailer->Subject = $n_judul;
		        		    //$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
		    		        //$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT JAWA BARAT</p>";
		    		        $isi  = "<img src = 'https://dpmptsp.jabarprov.go.id/jelita/assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
		    		        $isi .= "<h2>Informasi Permohonan Perizinan anda di Dinas PMPTSP Jawa Barat</h2><hr>";
		    		        if($i_ok=='T') {
		    		        	$isi .= 'Izin dengan nomor pendaftaran: '.$row->pendaftaran_id.' DISETUJUI, dan dapat dicetak pada Dashboard pendaftaran.';
		    		        } else {
		    		        	$isi .= 'Izin dengan nomor pendaftaran: '.$row->pendaftaran_id.' DITOLAK, silahkan hubungi Call Center DPMPTSP Jabar untuk info lebih lanjut.';
		    		        }
		    		        $isi .= "<br>";
		    		        $isi .= "<br>Abaikan jika telah menerima/cetak mandiri izin.";
		    		        $isi .= "<p>Terima kasih atas perhatiannya.<br>- Dinas PMPTSP Jawa Barat</p>";
				            $isi .= "<br><hr>";
				            $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - ".date('Y')."<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
				            $isi .= "<hr>";
				            $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
		    	    	    $mailer->Body = $isi;
		        		    $mailer->AltBody = $isi;
		        		    if ($mailer->Send()) {
		        		    	$sendE = TRUE;
		        		    } else {
		        		    	$sendE = FALSE;
		        		    }
						}
					}

					if ($sendS || $sendE) {
						$counter++;
						$timezone = time() + (60 * 60 * 7);
						//date_default_timezone_set('Asia/Jakarta');
						$data = array('tmpermohonan_id' => $id,
									  'user_id' 		=> $iduser,
									  'tmpegawai_id' 	=> $idpeg,
									  'waktu' 			=> gmdate('H:i:s', $timezone),
									  'tanggal' 		=> date('Y-m-d'),
									  'keterangan' 		=> '-'
									);
						$this->db->insert('tmpermohonan_notif_log', $data);
					}
    			}
    		}
    	}

    //if ($angka == $counter) {
    	$this->session->set_flashdata('sukses', "Berhasil mengirim seluruh pesan notifikasi.");
    // } else {
    // 	$this->session->set_flashdata('gagal', "Pesan notifikasi tidak terkirim seluruhnya. ".$counter." pesan terkirim dari ".$angka);
    // }

    redirect('permohonan/sk');
    }

    public function resend_notif($tgla=NULL,$tglb=NULL,$kt_cari=NULL) {
    //
    //$no_daftar = $kt_cari;
    //
    //$username = new user();
    //$username->where('username', $this->session->userdata('username'))->get();
    //
    //$this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
    //
    //$pegawai = new tmpegawai_user();
    //$pegawai->where('user_id', $username->id)->get();
    //
    //$idpeg = $pegawai->tmpegawai_id;
    //$iduser = $username->id;
    //
    //if($this->All){
    //  $query = "SELECT A.id AS idpermohonan, A.*, K.*, E.telp_pemohon, P.email AS emailp 
    //            FROM tmpermohonan as A
    //            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
    //            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
    //            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
    //            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
    //            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
    //            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
    //            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
    //            INNER JOIN tmbap I ON H.tmbap_id = I.id
    //            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
    //            INNER JOIN tmsk K ON J.tmsk_id = K.id
    //            INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
    //            LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
    //            LEFT JOIN tmpermohonan_tmperusahaan AS O ON A.id = O.tmpermohonan_id
    //            LEFT JOIN tmperusahaan AS P ON O.tmperusahaan_id = P.id
    //            WHERE A.c_pendaftaran = 1
    //            AND A.c_izin_dicabut = 0
    //            AND A.c_izin_selesai = 0";
    //
    //  $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
    //
    //}else{
    //  $query = "SELECT A.id AS idpermohonan, A.*, K.*, E.telp_pemohon, P.email AS emailp
    //            FROM tmpermohonan as A
    //            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
    //            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
    //            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
    //            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
    //            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
    //            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
    //            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
    //            INNER JOIN tmbap I ON H.tmbap_id = I.id
    //            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
    //            INNER JOIN tmsk K ON J.tmsk_id = K.id
    //            INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
    //            INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
    //            LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
    //            LEFT JOIN tmpermohonan_tmperusahaan AS O ON A.id = O.tmpermohonan_id
    //            LEFT JOIN tmperusahaan AS P ON O.tmperusahaan_id = P.id
    //            WHERE A.c_pendaftaran = 1
    //            AND A.c_izin_dicabut = 0
    //            AND A.c_izin_selesai = 0
    //            AND L.user_id = '".$username->id."'";
    //
    //  $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
    //  
    //}
    //
    //  $sql = $this->db->query($query);
    //
    //  if(empty($sql)) {
    //    $this->session->set_flashdata('gagal', "Data tidak ditemukan.");
    //    redirect('permohonan/sk');
    //  }
    //
    //  //$angka = $sql->num_rows;
    //
    //  $counter  = 0;
    //  require_once("assets/plugins/phpmailer/class.phpmailer.php");
    //    require_once("assets/plugins/phpmailer/class.smtp.php");
    //
    //  foreach ($sql->result() as $row) {
    //    $id_portal = $row->id_pemohon_portal;
    //    $id = $row->idpermohonan;
    //
    //    //$notif = $this->db->get_where('tmpermohonan_notif_log', array('tmpermohonan_id' => $id))->first_row();
    //
    //      if(file_exists('assets/esignfile/SK_'.$row->pendaftaran_id.'.pdf')) {
    //        $jm = 1;
    //        if($id_portal > 0){ //untuk pendaftaran OnLine
    //            $pemohon_portal = new tmpemohon_portal();
    //            $pemohon_portal->get_by_id($id_portal);
    //                $n_hp = $pemohon_portal->telpPemohon;
    //            $n_email = $pemohon_portal->emailPerusahaan;
    //        $stat = '<Bawa Resi Asli & Tunjukkan SMS ini>'; //max 35 dgt
    //        } else {
    //          $n_hp = $row->kontak_person;
    //          $n_hp2 = $row->telp_pemohon;
    //          if($n_hp != $n_hp2) $jm = 2;
    //          $n_email = $row->emailp;
    //          if($n_email == '') $n_email = '-';
    //          $stat = '<Bawa Tanda Terima Berkas Asli>'; //max 35 dgt
    //        }
    //
    //        $i_ok='T';
    //          if($row->no_surat == 'Ditolak') $i_ok='F';
    //
    //        $n_judul = 'Status Perizinan';
    //          if($i_ok=='T') {
    //            $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$row->pendaftaran_id.' DISETUJUI, dan dapat dicetak pada Dashboard pendaftaran. 
    //            \n abaikan pesan ini jika telah menerima/cetak mandiri izin.';
    //          }
    //          else {
    //          $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$row->pendaftaran_id.' DITOLAK, silahkan hubungi Call Center DPMPTSP Jabar untuk info lebih lanjut. 
    //          \n abaikan pesan ini jika telah menerima/cetak mandiri izin.';
    //        }
    //        $jum_in_pesan = 10;
    //
    //        $this->settings->where('name', 'smsGateway')->get();
    //            if($this->settings->status == 1) {
    //              $campaign   = 'Penyerahan';
    //            $username   = 'dpmptspjbr';
    //            $password   = '4RrtRM5X';
    //            if ($jm == 2) {
    //              $receiver = $n_hp.",".$n_hp2;
    //              $method   = 'multiple';
    //            } else {
    //              $receiver = $n_hp;
    //              $method   = 'single';
    //            }
    //            //$receiver = '082117788286';
    //            $message  = urlencode($n_pesan);
    //
    //            $url = 'http://103.111.57.219/eskalasi/public/messaging/request?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message.'&campaign='.$campaign;
    //
    //            $data = file_get_contents($url);
    //            if ($data) {
    //              $json = json_decode($data);
    //              if (isset($json->status)) {
    //                if ($json->status == 200) {
    //                  $sendS = TRUE;
    //                } else {
    //                  $sendS = FALSE;
    //                }
    //              }
    //            }
    //            }
    //
    //            $this->settings->where('name', 'send_mail')->get();
    //        if ($this->settings->status == 1) {
    //          if($n_email != '-'){
    //                $host             = "smtp.gmail.com";
    //                  $emailpengirim    = "dpmptspjabar@gmail.com";
    //                  $namapengirim     = "DPMPTSP JABAR";
    //                  $password         = "~dpmptspjabarprovgoid#";
    //                  $targetpengiriman = $n_email;
    //                  //$targetpengiriman = "nirwan.nrs@gmail.com";
    //                  $mailer = new PHPMailer();
    //                  $mailer->CharSet = "UTF-8";
    //                  $mailer->IsSMTP();
    //                  $mailer->SMTPSecure = 'tls';
    //                  $mailer->Host =$host;
    //                  $mailer->Port =587;
    //                  $mailer->SMTPAuth = true;
    //                  $mailer->Username = $emailpengirim;
    //                  $mailer->Password = $password;
    //                  $mailer->FromName = $namapengirim;
    //                  $mailer->From     = $emailpengirim;
    //                  $mailer->AddAddress($targetpengiriman,$targetpengiriman);
    //                  //Isi Data untuk e-mail
    //                  $mailer->Subject = $n_judul;
    //                  //$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
    //                  //$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT JAWA BARAT</p>";
    //                  $isi  = "<img src = 'https://dpmptsp.jabarprov.go.id/jelita/assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
    //                  $isi .= "<h2>Informasi Permohonan Perizinan anda di Dinas PMPTSP Jawa Barat</h2><hr>";
    //                  if($i_ok=='T') {
    //                    $isi .= 'Izin dengan nomor pendaftaran: '.$row->pendaftaran_id.' DISETUJUI, dan dapat dicetak pada Dashboard pendaftaran.';
    //                  } else {
    //                    $isi .= 'Izin dengan nomor pendaftaran: '.$row->pendaftaran_id.' DITOLAK, silahkan hubungi Call Center DPMPTSP Jabar untuk info lebih lanjut.';
    //                  }
    //                  $isi .= "<br>";
    //                  $isi .= "<br>Abaikan jika telah menerima/cetak mandiri izin.";
    //                  $isi .= "<p>Terima kasih atas perhatiannya.<br>- Dinas PMPTSP Jawa Barat</p>";
    //                  $isi .= "<br><hr>";
    //                  $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - ".date('Y')."<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
    //                  $isi .= "<hr>";
    //                  $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
    //                  $mailer->Body = $isi;
    //                  $mailer->AltBody = $isi;
    //                  if ($mailer->Send()) {
    //                    $sendE = TRUE;
    //                  } else {
    //                    $sendE = FALSE;
    //                  }
    //          }
    //        }
    //
    //        if ($sendS || $sendE) {
    //          $counter++;
    //          $timezone = time() + (60 * 60 * 7);
    //          //date_default_timezone_set('Asia/Jakarta');
    //          $data = array('tmpermohonan_id' => $id,
    //                  'user_id'     => $iduser,
    //                  'tmpegawai_id'  => $idpeg,
    //                  'waktu'       => gmdate('H:i:s', $timezone),
    //                  'tanggal'     => date('Y-m-d'),
    //                  'keterangan'    => '-'
    //                );
    //          $this->db->insert('tmpermohonan_notif_log', $data);
    //        }
    //      }
    //  }
    //
    //if ($angka == $counter) {
      $this->session->set_flashdata('sukses', "Berhasil mengirim seluruh pesan notifikasi.");
    // } else {
    //  $this->session->set_flashdata('gagal', "Pesan notifikasi tidak terkirim seluruhnya. ".$counter." pesan terkirim dari ".$angka);
    // }

    redirect('permohonan/sk');
    }

    public function gettime() {
    	$notif = $this->lib_date->statNotif('162200');
    	var_dump($notif);die;
    }
}
