<?php

/**
 * Description of Pembuatan SK
 * @author Eva
 * Updated : 04 Sep 2010 (agusnur)
 * Update  : PBS, 14 Okt 2016 -> mencetak sk dengan pdf 
 *         : jika ada perubahan darurat gunakan file sk_141016.pdf
 */

class Sk extends WRC_AdminCont {

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
    
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->sk = NULL;
    $this->All = FALSE;
    
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '13' || $list_auth->id_role === '20') {
        $enabled = TRUE;
        $this->sk = new user_auth();
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index($xsts_pil=NULL, $xtgla=NULL, $xtglb=NULL) {
    $no_daftar = $this->input->post('kt_cari');
    if($xsts_pil != ''){ 
      $sts_pil = $xsts_pil;
      $tgla = $xtgla;
      $tglb = $xtglb;
    }else{
      $sts_pil = $this->input->post('sts_pil');
      $tgla = $this->input->post('tgla');
      $tglb = $this->input->post('tglb');
    }  
    if($sts_pil == '') $sts_pil = 1;
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -40);
    $tgl_now = $this->lib_date->set_date($now, 0);
    
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
    $jum = $this->cek_data_notif($username->id);  // cek jumlah data yang akan di notif
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
    if($this->All){
      $query = "SELECT DISTINCT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template, C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id, N.tg_kyKaPTSP
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
                AND A.c_izin_selesai = 0";
      if($sts_pil == 2) { // berdasarkan Tanggal Penetapan
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND K.tgl_penetapan between '$tgla' AND '$tglb' AND I.status_bap = 1 order by A.id DESC";
        }
      }elseif($sts_pil == 3){  // berdasarkan approve Esl II
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";  
        }
      }else{
        if (!empty($no_daftar)) { // berdasarkan Tanggal Permohonan
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";  
        }
      }
    }else{
      $query = "SELECT DISTINCT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template, C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id, N.tg_kyKaPTSP
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
                AND L.user_id = '".$username->id."'";
      if($sts_pil == 2) { // berdasarkan Tanggal Penetapan
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
        }
      }elseif($sts_pil == 3){ // berdasarkan approve Esl II
        if (!empty($no_daftar)) {
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND DATE(N.tg_kyKaPTSP) between '$tgla' and '$tglb' AND A.approve = 2 order by A.id DESC";  
        }
      }else{
        if (!empty($no_daftar)) { // berdasarkan Tanggal Permohonan
          $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
        } else {
          $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";
        }
      }
    }
    // if ($this->All) {
      // var_dump($query);die();
    // }
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
    // if($sts_pil == 1) { // berdasarkan Tanggal Permohonan
    //   $data['cek1'] = TRUE;
    //   $data['cek2'] = FALSE;
    // }else{              // berdasarkan Tanggal Upload
    //   $data['cek1'] = FALSE;
    //   $data['cek2'] = TRUE;
    // }

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
    $this->session_info['page_name'] = "Pencetakan Naskah Izin Izin ";
    $this->template->build('sk_list', $this->session_info);
  }
  
  public function index_next() {
    $sts_pil = $this->input->post('sts_pil');
    if($sts_pil == '') $sts_pil = 1;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template,C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
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
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0";
      if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
      }else{
        $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";			
      }
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.kd_gerai, A.approve, A.a_izin, A.status_berkas, C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub,
                C.template,C.e_ttd, C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
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
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND L.user_id = '".$username->id."'";
      if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query .= " AND K.tgl_penetapan between '$tgla' and '$tglb' AND I.status_bap = 1 order by A.id DESC";
      }else{
        $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";			
      }
    }
    $data['list'] = $query;
    $data['c_bap'] = "1";
    if($sts_pil == 1) { // berdasarkan Tanggal Permohonan
      $data['cek1'] = TRUE;
      $data['cek2'] = FALSE;
    }else{              // berdasarkan Tanggal Upload
      $data['cek1'] = FALSE;
      $data['cek2'] = TRUE;
    }
    
    $this->load->vars($data);
    
    $js =  "$(document).ready(function() {
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
    $this->session_info['page_name'] = "Data Pembuatan Izin";
    $this->template->build('sk_list', $this->session_info);
  }
  
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
		$br10 = 'Tasikmalaya, '.$this->lib_date->mysql_to_human(date('Y-m-d'));
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
  public function cetak($id_daftar = NULL, $jenis = NULL, $menu = NULL) {
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
    $surat_awal = $permohonan->tmsk->get();
    $bap = $permohonan->tmbap->get();
    $nodaftar = $permohonan->pendaftaran_id;
    
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
      $permohonan->kd_status = 7; // ubah kd_status menjadi 7 untuk proses selanjutnya (izin siap diserahkan)
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
    if($menu == 1) //$p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$nodaftar."','".$tgl."','".$u_ser."')");    // khusus cetak SK

    if($jenis == 0){  // tanpa tmplate pertek /gub
      if($menu == 1) redirect('permohonan/sk/index_next');  // untuk naskah izin menu SK
      if($menu == 2) redirect('permohonan/bap/index_next'); // untuk pertek menu BAP
    }
    
    if($e_sertifikat == 0 && $menu != 2){  // jika tidak e-sign $ bukan sartek
      $this->cetak_sk($id_daftar,$menu);   // ke membuat docx dan pdf
    }else{                                 // jika e-sign
      $lok_nonsign = 'assets/skpdf/';
      $lok_esign =   'assets/esignfile/';
      if($menu == 1) $file = str_replace(' ', '','SK_'.$nodaftar); // SK
      if($menu == 2) $file = str_replace(' ', '','PT_'.$nodaftar); // Sartek
      if($menu == 3) $file = str_replace(' ', '','SK_'.$nodaftar); // Upload
      $this->load->helper('download');
      if(file_exists($lok_esign.$file.'.pdf')){             // cek PDF yang sudah SE
        $data = file_get_contents($lok_esign.$file.'.pdf');
        force_download($file.'.pdf', $data);
      }else{
        if(file_exists($lok_nonsign.$file.'.pdf')){         // cek PDF yang tanpa SE
        	//if(file_exists('assets/skpdfWM/'.$file.'.pdf'))   // cek PDF yang DG Watermark
          //  $data = file_get_contents('assets/skpdfWM/'.$file.'.pdf');
          //else  
            $data = file_get_contents($lok_nonsign.$file.'.pdf');
          force_download($file.'NonSE.pdf', $data);
        }else{
          if($menu == 2){
            $this->cetak_sk($id_daftar,$menu); // ke membuat docx dan pdf
          }
          echo "file sudah tidak ada.";
          die;
        }
      }	
    } 
  }
  
	// membuat docx dan konversi ke pdf
  public function cetak_sk($id_daftar = NULL, $menu = NULL, $view = NULL){
    $a = "select * from tmpegawai where status = '1'";
    $hasil = $this->db->query($a)->row_array();
    $a22 = "select * from tmpermohonan where id ='".$id_daftar."'";
    $hasil22 = $this->db->query($a22)->row_array();
    $nodaftar =	$hasil22['pendaftaran_id'];
    
    $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."')";
    $hasil2 = $this->db->query($b)->row_array();
    $e_sertifikat =	$hasil2['e_sertifikat'];
		
		$d = "select * from trmengingat 
		      where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='".$hasil2['id']."') order by jenis,nomor,tahun asc";
    $hasil4 = $this->db->query($d)->result();
    $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil5 = $this->db->query($e)->result();
    $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil6 = $this->db->query($f)->result();        
    $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
    $hasil7 = $this->db->query($g)->row_array(); 

    $kota = "select * from trkabupaten 
		         where id in(select trkabupaten_id from trkabupaten_trkecamatan 
             where trkecamatan_id in(select id from trkecamatan 
				     where id in(select trkecamatan_id from trkecamatan_trkelurahan 
				     where trkelurahan_id in(select id from trkelurahan 
				     where id in(select trkelurahan_id from tmpemohon_trkelurahan 
				     where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan 
				     where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."'))))))) ";
    $sqlkota = $this->db->query($kota)->row_array();
         
    $pemohon_portal = new tmpemohon_portal();                      
    $pemohon_portal->where('id', $hasil22['id_pemohon_portal'])->get();
    $nib = $pemohon_portal->nib;
    if($nib == '') $nib='-';                    
         
		$surat_keluar = new tmsurat_keluar();
		$surat_keluar->where('tmpermohonan_id', $id_daftar)->get();
		$tgl_surat = $surat_keluar->tgl_surat;
		$no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
		if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
		if($surat_keluar->no_surat == '') $no_pertek = '-';
    
    require_once 'assets/phpword/src/PhpWord/Autoloader.php';
		\PhpOffice\PhpWord\Autoloader::register();

		switch($menu){
	    case 1 :  // SK
	      $isSK = TRUE;
	      $redirect = str_replace(' ', '','SK_'.$nodaftar);
        $string3 = "select * from trperizinan_template 
			              where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template']);
        break;
      case 2 :  // Sartek
        $isSK = FALSE;
        $redirect = str_replace(' ', '','PT_'.$nodaftar);
        $string3 = "select * from trperizinan_template_gub 
                    where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template_gub']);
			  break;
      case 3 : // Upload
        $isSK = TRUE;
        $redirect = str_replace(' ', '','SK_'.$nodaftar);
        $string3 = "select * from trperizinan_template 
			              where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('naskah_izin/'.$hasil22['pendaftaran_id'].'.docx');
			  break;
    }
    $c = $string3;
    $hasil3 = $this->db->query($c)->result();

    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
    $blnRomawi = $arrblnRomawi[date("m")-1];

		############################################
    #                                          #
    #   NEW QUERY PEMOHON DAN PERUSAHAAN       #
    #                                          #
    ############################################
    $qqq = "select * from tmpemohon where id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = '".$id_daftar."')";
    $dt_pemohon = $this->db->query($qqq)->row_array();
    $qqq2 = "select * from tmperusahaan where id = (select tmperusahaan_id from tmpermohonan_tmperusahaan where tmpermohonan_id = '".$id_daftar."')";
    $dt_pemohon2 = $this->db->query($qqq2)->row_array();
    $bulanArr = array("Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $expl = explode("-",$hasil22["d_terima_berkas"]);
    $blnIndo = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
    if(count($dt_pemohon2) > 0){
      $nperusahaan = $dt_pemohon2['n_perusahaan'];
		  $alamatperusahaan = $dt_pemohon2['a_perusahaan'];
		  $npwpperusahaan = $dt_pemohon2['npwp'];
      $perusahaan = new tmperusahaan();
      $perusahaan->get_by_id($dt_pemohon2['id']);
      $kelurahan = $perusahaan->trkelurahan->get();
      $kecamatan = $perusahaan->trkelurahan->trkecamatan->get();
      $kabupaten = $perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
      $provinsi = $perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
      $desaperusahaan = $kelurahan->n_kelurahan;
      $kecperusahaan  = $kecamatan->n_kecamatan;
      $kabperusahaan  = $kabupaten->n_kabupaten;
      $provperusahaan = $provinsi->n_propinsi;
    }else{
      $nperusahaan = $dt_pemohon['n_pemohon'];
			$alamatperusahaan = $dt_pemohon['a_pemohon'];
			$npwpperusahaan = '';
      $desaperusahaan = '';
      $kecperusahaan  = '';
      $kabperusahaan  = '';
      $provperusahaan = '';
    }
    
    if($menu == 2){
		  $nosk     = '';
		  $tgl_sk   = '0000-00-00';
		}else{  
      if(empty($hasil7)){
        $nosk     = '';
        $tgl_sk   = '';
      }else{
        $nosk     = $hasil7['no_surat'];
        $tgl_sk   = $hasil7['tgl_surat_edit'];
      }
	  }
		$namaizin = $hasil2['n_perizinan'];
		$id_izin  = $hasil2['id'];
		
		// Ttd SK

    // if ((strtotime($tgl_sk) >= strtotime('2019-04-04') && strtotime($tgl_sk) <= strtotime('2019-04-12')) || (strtotime($hasil7['tgl_penetapan']) >= strtotime('2019-04-04') && strtotime($hasil7['tgl_penetapan']) <= strtotime('2019-04-12'))) {
    //   $pegawai = new tmpegawai();
    //   $pegawai = $pegawai->where('id', '831')->get(); //ID PLH/PLT Kadis di tmpegawai
    // } else {
      $pegawai = new tmpegawai();
      $pegawai = $pegawai->where('status', '1')->get();
    //}
		
		$jbt     = $pegawai->n_jabatan;

		$nmjbt	= explode(" ", $jbt); 

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

		// $ttd     = base_url().'uploads/logo/pantas.jpg' ;
		// http://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/logo/ttdblue.png
		// echo $ttd; die;
		$ttd_kepala  = $pegawai->n_pegawai;
    $ttd_pangkat = $pegawai->pangkat_gol;
    $ttd_nip     = $pegawai->nip;
		// EOF() Ttd SK
           
		//Create Konten Izin untuk di kunci
    $konten = $this->lib_date->all_property($id_izin, $id_daftar);
    $kontenizin = 'ID. '.$nodaftar.$konten;
		$kontenizin = trim($kontenizin);
		//EOF() Create Konten Izin untuk di kunci

    //Create QRCode
		include('./assets/qrcode/qrlib.php');
    $tempDir = 'uploads/data_qrcode_naskah/';      
    $local = $_SERVER['PHP_SELF'];
    $url = $local;
    $pos = strpos($url, "/backoffice");
    if ($pos !== false) {
        $local = substr($url, 0, $pos);
    } else {
        $local = $url;
    }
    $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$local;
		$link = "$domain/main/cekiz/index/";
		$key = 'ky_'.md5($kontenizin); // Create Content Key
    $codeContents = $nodaftar;
		  $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
		$fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
    if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
      
		if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
		  $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
      $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
      $padding = 0;
      QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
      $s_izin = new tmpermohonan();
      $s_izin->where('id', $id_daftar)->update('file_naskah', $fileName);
			$s_izin->where('id', $id_daftar)->update('file_konten', $key); 
    }
    //EOF() Create QRCode
		
		//Create Variabel => transfer variabel pencetakan All
		// hindari input data menggunakan karakter & < >
		$templateProcessor->setValue("provinsi",'PROVINSI TASIKMALAYA');                               // Nama Provinsi Penandatangan
    $templateProcessor->setValue("jabatan",$jbt);                                     // Jabatan Penandatangan
    $templateProcessor->setValue("kepala",$ttd_kepala);                                           // Nama Kepala Penandatangan
    $templateProcessor->setValue("pangkat",$ttd_pangkat);                                         // Pangkat Penandatangan
    $templateProcessor->setValue("nip",$ttd_nip);                                                 // NIP Penandatangan
		$templateProcessor->setValue("nopendaftaran",$nodaftar);                                      // Nomor Pendaftaran
		$templateProcessor->setValue("tgl_daftar",$blnIndo);                                          // Tanggal Pendaftaran
    $templateProcessor->setValue("npemohon",$dt_pemohon['n_pemohon']);                            // Nama Pemohon
		$templateProcessor->setValue("nperusahaan",$nperusahaan);                                     // Nama Perusahaan
		$templateProcessor->setValue("alamatperusahaan",$alamatperusahaan);                           // Alamat Perusahaan
    $templateProcessor->setValue("perusahaan_npwp",$npwpperusahaan);	                            // NPWP Perusahaan
    $templateProcessor->setValue("perusahaan_prov",$provperusahaan);	                            // Alamat Perusahaan Provinsi
    $templateProcessor->setValue("perusahaan_kab",$kabperusahaan);	                              // Alamat Perusahaan Kab/Kota
    $templateProcessor->setValue("perusahaan_kec",$kecperusahaan);	                              // Alamat Perusahaan Kecamatan
    $templateProcessor->setValue("perusahaan_desa",$desaperusahaan);	                            // Alamat Perusahaan Desa/Kelurahan
		$templateProcessor->setValue("namaizin",$namaizin);                                           // Nama Izin
    $templateProcessor->setValue("nosk",$nosk);                                                   // Nomor SK
    $templateProcessor->setValue("tglsk",$this->lib_date->mysql_to_human($tgl_sk));               // Tanggal SK
    $templateProcessor->setValue("bulanromawi",$blnRomawi);                                       // Bulan Romawi Sekarang
    $templateProcessor->setValue("tahunini",date("Y"));                                           // Tahun Sekarang
    $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));  // tanggal Sekarang
		$templateProcessor->setValue("no_mohon_sartek",$no_pertek);                                   // nomor permohonan pertek ke tim teknis
    $templateProcessor->setValue("tgl_mohon_sartek",$this->lib_date->mysql_to_human($tgl_surat)); // tanggal permohonan pertek ke tim teknis
    $templateProcessor->setValue("nib",$nib);                                                     // Nomor Induk Berusaha
		
			
		//Ambil dan Tampilkan QrCode
		$image_path = 'uploads/data_qrcode_naskah/'.$fileName;
    $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 110, 110 )));// QrCode
    
    //Ambil dan Tampilkan TTD Kadis        
		$image_path = 'uploads/logo/'.str_replace(' ', '', $ttd_nip).'.png';
		$templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 140, 87 ))); //default = 100, 47     // ttd kadis
    
    //Ambil dan Tampilkan TTD Kadis        
		$image_path = 'uploads/qrcode/'.str_replace(' ', '', $ttd_nip).'.png';
		$templateProcessor->setImg('ttd_qrcode', array('src' => $image_path,'size' => array( 110, 110 ))); //default = 100, 47     // ttd kadis

    //Ambil dan Tampilkan Kop Surat
    $image_path = 'uploads/logo/kop.png';
		$templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
		
		//Ambil dan Tampilkan BSrE
		if($e_sertifikat == 1){
		  $image_path = 'uploads/logo/bsre.png';
		  $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 795, 80 ))); // Logo Bsre
		}else{
			$image_path = 'uploads/logo/nonbsre.jpg';
		  $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 600, 80 ))); // Logo Bsre
		}
		
		//Ambil dan Tampilkan Cap Dinas
		$image_path = 'uploads/logo/CapDinas.png';
		$templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas

    //ambil path foto pemohon
    $otherdb = $this->load->database('otherdb', TRUE);    
    $backoffice_db     = $this->load->database('default', TRUE);
    $portal_db         = $this->load->database('otherdb', TRUE);
    $db_portal      = $portal_db->database;
    $db_backoffice  = $backoffice_db->database;

    $sql1 = "select id from tm_pemohon where id='".$pemohon_portal->id_pemohon."'";
    $sql  = "select tm_pemohon.username from tm_pemohon where tm_pemohon.id='".$pemohon_portal->id_pemohon."'";
    $username_portal = $otherdb->query($sql)->first_row()->username;
    $id_mohon_portal = $pemohon_portal->id_permohonan_portal;
    //Ambil dan Tampilkan Foto pemohon
    $image_path = "../assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_mohon_portal."/foto_".$id_mohon_portal.".jpg";
      $query = "
        SELECT * 
        FROM $db_portal.tm_pemohon 
        WHERE 
            (ktpPerusahaan = '{$dt_pemohon['no_referensi']}' OR ktpPemohon = '{$dt_pemohon['no_referensi']}') AND 
            (almtPerusahaan = '{$dt_pemohon['a_pemohon']}' OR almtPemohon = '{$dt_pemohon['a_pemohon']}') AND 
            (telpPemohon = '{$dt_pemohon['telp_pemohon']}' OR telpPerusahaan = '{$dt_pemohon['telp_pemohon']}') AND 
            status = '1'
        LIMIT 1;
        ";
      

      // To execute the query, you might use something like this:
      $user = $this->db->query($query)->row();
    
    $pendaftaran_id = $this->db->query("SELECT *  FROM `tmpermohonan` WHERE `id` = '$id_daftar'")->first_row();
    if(!empty($user)){
      $eksis = $this->db->query("select * from $db_portal.tmpermohonan_portal where no_permohonan=".$pendaftaran_id->pendaftaran_id." order by id desc LIMIT 1")->first_row();
      $foto = NULL;
      if($hasil2['c_foto'] == '1' && !empty($eksis)){
        $image_path = 'jelita/assets/userassets/pemohon/'.$user->username.'/pengajuan/'.$eksis->id.'/';  // Path ke direktori lokal
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $image_path;  // Membuat path lengkap dari root server

        // Memeriksa apakah direktori ada
        if (is_dir($full_path)) {
            // Mengambil daftar file di dalam direktori
            $files = array_diff(scandir($full_path), array('.', '..'));
            
            // Membuat array dengan URL lengkap untuk setiap file JPG
            $file_urls = array();
            $foto = '';
            foreach ($files as $file) {
                // Mengecek apakah file adalah JPG
                if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jpg') {
                  $foto = $file;
                    $file_urls[] = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $image_path . $file;
                }
            print_r($foto);
            }
            
            // Output atau pemrosesan lebih lanjut dari $file_urls
            $foto_mohon = $_SERVER['DOCUMENT_ROOT'] . '/' . $image_path. $foto;
        }
        if($foto != '' || $foto != NULL){
          $templateProcessor->setImg('FotoMohon', array('src' => $foto_mohon,'size' => array( 112, 150 ))); // ttd Kop Surat
        }
      }
    }
		
    //Create Variabel => transfer variabel pencetakan All EOF()
    ############################################
    #                                          #
    # END OF NEW QUERY PEMOHON DAN PERUSAHAAN  #
    #                                          #
    ############################################
           
		//menimbang--------------
		
    function docx2text($filename) {
      return readZippedXML($filename, "word/document.xml");
    }
    $tulis_nama = array();
    $tulis_variable = array();

    function readZippedXML($archiveFile, $dataFile) {
      $zip = new ZipArchive;
      if(true === $zip->open($archiveFile)) {
        if(($index = $zip->locateName($dataFile)) !== false) {
          $data = $zip->getFromIndex($index);
          $zip->close();
          $xml = new DOMDocument();
          $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
          return strip_tags($xml->saveXML());
        }
        $zip->close();
      }
      return "";
    }
        
		if($menu==1) $text = docx2text('assets/template-baru/'.$hasil2['template']);
    if($menu==2) $text = docx2text('assets/template-baru/'.$hasil2['template_gub']);
		if($menu==3) $text = docx2text('naskah_izin/'.$hasil22['pendaftaran_id'].'.docx');
        
    $texts = explode(" ", $text);
    $output = array();
    $output2 = array();
    $output3 = array();
    foreach($texts as $t) {
      if(strpos($t, '${menimbang}') !== false)     $output[] = $t;
      if(strpos($t, '${mengingat}') !== false)     $output2[] = $t;
      if(strpos($t, '${memperhatikan}') !== false) $output3[] = $t;
    }
          
    //menimbang--------------
    if(count($output) > 0){
      $no = 1;
      if(count($hasil5) > 0){
        $templateProcessor->cloneRow('menimbang', count($hasil5));
        foreach($hasil5 as $ha5){
          $templateProcessor->setValue("menimbang#".$no,$ha5->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil5 as $ha5){
          $templateProcessor->setValue("No1#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("menimbang","");
        $templateProcessor->setValue("No1","");
      }
    }
    //EOF() menimbang---------

    //mengingat---------------
    if(count($output2) > 0){
      $no = 1;
      if(count($hasil4) > 0){
        $templateProcessor->cloneRow('mengingat', count($hasil4));
        foreach($hasil4 as $ha4){
          $templateProcessor->setValue("mengingat#".$no,$ha4->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil4 as $ha4){
          $templateProcessor->setValue("No2#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("mengingat","");
        $templateProcessor->setValue("No2","");
      }
    }
    //EOF() mengingat---------   
  
    //memperhatikan-----------
    if(count($output3) > 0){ 
      $no = 1;
      if(count($hasil6) > 0){
        $templateProcessor->cloneRow('memperhatikan', count($hasil6));
        foreach($hasil6 as $ha6){
          $templateProcessor->setValue("memperhatikan#".$no,$ha6->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil6 as $ha6){
          $templateProcessor->setValue("No3#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("memperhatikan","");
        $templateProcessor->setValue("No3","");
      }
    }
    //EOF() memperhatikan-----

    $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
    $cxv = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc")->result();
    $cx3 = count($cxv);
    $blnID = array("Januari","Februari","Maret",'April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
    if($cx3 == 0){
      $templateProcessor->setValue("text_atas"," ");
      $templateProcessor->setValue("text_alasan1"," ");
      $templateProcessor->setValue("text_alasan2"," ");
      $templateProcessor->setValue("No4"," ");
      $templateProcessor->setValue("t1"," ");
      $templateProcessor->setValue("t2"," ");
      $templateProcessor->setValue("t3"," ");
      $templateProcessor->setValue("t4"," ");
      $templateProcessor->setValue("t5"," ");
      $templateProcessor->setValue("No5"," ");
      $templateProcessor->setValue("prop"," ");
      $templateProcessor->setValue("dari", " ");
      $templateProcessor->setValue("menjadi"," ");
      $templateProcessor->setValue("tgl_berubah"," ");
    }else{
      $arr1 = array();
      $arr2 = array();
      foreach ($cxv as $key) {
        $arr1[] = $key->id;
        $arr2[$key->id] = $key->tgl_revisi; 
      }
      $many1 = implode(",", $arr1);
      $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi in($many1) order by data asc,id asc");
      $cx4 = $cx2->result();
        
      $templateProcessor->setValue("text_atas"," ");
      $templateProcessor->setValue("text_alasan1","(Catatan perubahan) : ");
      $templateProcessor->setValue("text_alasan2","");
      $templateProcessor->setValue("No4"," ");
      $templateProcessor->setValue("t1","No.");
      $templateProcessor->setValue("t2","Properti");
      $templateProcessor->setValue("t3","Semula");
      $templateProcessor->setValue("t4","Menjadi");
      $templateProcessor->setValue("t5","Tanggal Berubah");
      $templateProcessor->cloneRow('No5', count($cx4));
      $u = 1;
      foreach($cx4 as $cc){
        $wa = explode(" ",$arr2[$cc->id_revisi]);
        $templateProcessor->setValue("No5#".$u,"$u");
        $templateProcessor->setValue("prop#".$u,$cc->data);
        $templateProcessor->setValue("dari#".$u, $cc->asal);
        $templateProcessor->setValue("menjadi#".$u,$cc->jadi);
        $templateProcessor->setValue("tgl_berubah#".$u,$wa[0]);
        $u++;
      }
    }

    foreach ($hasil3 as $data) {
        // var_dump($data);
        $tek = "var_teknis" . $data->urutan_vars_teknis;
        $prop = isset($hasil2[$tek]) ? $hasil2[$tek] : null; // Use isset to handle undefined index
        if (empty($prop)) {
            break;
        }
        $array = explode("^", $prop);
        $tek2 = "dt_teknis" . $data->urutan_vars_teknis;
        $prop2 = isset($hasil22[$tek2]) ? $hasil22[$tek2] : null; // Use isset to handle undefined index
        $prop2 = str_replace("&", "-", $prop2); // tanda & mengakibatkan error
        if (empty($prop2)) {
            break;
        }
        
        $array2 = explode("^", $prop2);
        if ($data->t_value == "v_pokja") {
            $data->t_value = "v_tanggalpertek2";
        }
        
        if (isset($array2[1]) && strtotime($array2[1])) {
            $bulanArr = array("Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $expl = explode("-", $array2[1]);
            
            // Check if the $expl array has the expected number of elements
            if (count($expl) === 3) {
                $array2[1] = "$expl[2] " . $bulanArr[$expl[1] - 1] . " $expl[0]";
            }
        }
    if (strpos($array2[1], 'Lisensi') !== false) {
        // The string contains the word "lisensi"// Function to check if a string is a valid date
          if(is_valid_date($array2[1])){
            $date_sk = $this->lib_date->mysql_to_human($array2[1]);
            $templateProcessor->setValue("tglsk", $date_sk);
          }
        // Add your code execution here
    } 
        // Check if $array[1] and $array2[1] exist before setting the values
        $templateProcessor->setValue($data->t_nama, $array[1]);
        if(!empty($array2[1])){
        $templateProcessor->setValue($data->t_value, $array2[1]);
        }else{
        $templateProcessor->setValue($data->t_value, $array2[0]);
        }
    }
            
    $kota = explode(' ', $sqlkota['n_kabupaten']);
    if($kota[0] == 'KOTA') {
      $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
    }else{
      $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
    }
 
    if($kota[0] == 'KOTA'){
      $templateProcessor->setValue('ket','Kota'); 
      $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
    }else{
      $templateProcessor->setValue('ket','Kab.'); 
      $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
    }

    //Create File docx
    $file_target = 'assets/download/'.$redirect.'.docx';
    $templateProcessor->saveAs($file_target);
    //EOF() Create File docx
    
    // Konfersi docx ke pdf di folder backoffice/assets/skpdf
    $draft = FALSE;
    if($menu != 2){ // jika bukan Sartek
      if($e_sertifikat == 1) {   //penggunaan SE 
        if(file_exists('assets/skpdf/'.$redirect.'.pdf')){
          unlink('assets/skpdf/'.$redirect.'.pdf');
        }
        $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
        $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);          
        $local = $_SERVER['PHP_SELF'];
        $url = $local;
        
        // Cari posisi kata "android" dalam URL
        $pos = strpos($url, "/backoffice");
        if ($pos !== false) {
            // Ambil bagian URL sebelum "android"
            $local = substr($url, 0, $pos);
        } else {
            // Jika tidak ada kata "android", gunakan URL asli
            $local = $url;
        }
        $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$local;
        $base_domain = base64_encode($domain);
        $data = file_get_contents('http://103.122.5.250/siapi/api/default-izin?id='.$namafile.'&token=9wdxc7txiH&url='.$base_domain, FALSE, $context);
        $data = json_decode($data);
        // $data = file_get_contents('http://localhost/convert/index.php?id='.$namafile.'&link='.$base_domain, FALSE, $context);
        if($data->status == 'success') {
          $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
          // $dtpdf = 'http://localhost/convert/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';  
          $local = $_SERVER['SCRIPT_FILENAME'];
          $url = $local;
          // Cari posisi kata "android" dalam URL
          $pos = strpos($url, "/backoffice");
          if ($pos !== false) {
              // Ambil bagian URL sebelum "android"
              $local = substr($url, 0, $pos);
          } else {
              // Jika tidak ada kata "android", gunakan URL asli
              $local = $url;
          }
          $newfile = $local. '/backoffice/assets/skpdf/'.$namafile.'.pdf'; 
          if (copy($dtpdf, $newfile)) {
            $draft = TRUE;
            //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelspekta&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
            echo 'Sukses';
          }
        }else{
          echo "Gagal";
        }
      }
    }
    
    if($menu == 2){ // jika Sartek
      if(file_exists('assets/skpdf/'.$redirect.'.pdf')){
        unlink('assets/skpdf/'.$redirect.'.pdf');
      }
      $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
      $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
      $context = stream_context_create($opts);
      $local = $_SERVER['PHP_SELF'];
      $url = $local;
      
      // Cari posisi kata "android" dalam URL
      $pos = strpos($url, "/backoffice");
      if ($pos !== false) {
          // Ambil bagian URL sebelum "android"
          $local = substr($url, 0, $pos);
      } else {
          // Jika tidak ada kata "android", gunakan URL asli
          $local = $url;
      }
      $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$local;
      $base_domain = base64_encode($domain);
      $data = file_get_contents('http://103.122.5.250/siapi/api/default-izin?id='.$namafile.'&token=9wdxc7txiH&url='.$base_domain, FALSE, $context);
      // $data = file_get_contents('http://localhost/convert/index.php?id='.$namafile.'&link='.$base_domain, FALSE, $context);
        if($data->status == 'success') {
          $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
          // $dtpdf = 'http://localhost/convert/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';  
          $local = $_SERVER['SCRIPT_FILENAME'];
          $url = $local;
          // Cari posisi kata "android" dalam URL
          $pos = strpos($url, "/backoffice");
          if ($pos !== false) {
              // Ambil bagian URL sebelum "android"
              $local = substr($url, 0, $pos);
          } else {
              // Jika tidak ada kata "android", gunakan URL asli
              $local = $url;
          }
          $newfile = $local. '/backoffice/assets/skpdf/'.$namafile.'.pdf';  
          if (copy($dtpdf, $newfile)) {
            $draft = TRUE;
            //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelspekta&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
            echo 'Sukses';
          }
      }else{
        echo "Gagal";
      }
    }
    // EOF() Konfersi docx ke pdf di folder backoffice/assets/skpdf
    
    //Create Draft Naskah
    if($draft){
      $file = $redirect.'.pdf';
      $file_draft = 'DRAFT'.$redirect.'.pdf';
      $lok_fileDr = 'assets/skpdf/';
      $lok_fileWm = 'assets/skpdfWM/';
      $lok_fileSE = 'assets/esignfile/';
      $this->load->helper('download');
      if(file_exists($lok_fileDr.$file)){              // cek PDF Draft
        if(file_exists($lok_fileSE.$file)){            // cek PDF SE
      		//$data = file_get_contents($lok_fileSE.$file);
          //force_download($file, $data);
      	}else{	
          if(file_exists($lok_fileWm.$file)){          // cek PDF WaterMark	
            //$data = file_get_contents($lok_fileWm.$file);
            //force_download($file, $data);
          }else{
            //Create pdf watermark
            $this->load->library('cfpdf');
            $this->load->library('cfpdi');
            $pdf = new FPDI();
            $local = $_SERVER['SCRIPT_FILENAME'];
            $url = $local;
            // Cari posisi kata "android" dalam URL
            $pos = strpos($url, "/backoffice");
            if ($pos !== false) {
                // Ambil bagian URL sebelum "android"
                $local = substr($url, 0, $pos);
            } else {
                // Jika tidak ada kata "android", gunakan URL asli
                $local = $url;
            }
            $filename  = $local .'/backoffice/assets/skpdf/'.$file; //Lokasi File Tanpa WaterMark
            $filenameW = $local .'/backoffice/assets/skpdfWM/'.$file;    //Lokasi File WaterMark
            try{
              $pageCount = $pdf->setSourceFile($filename);
              for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                $Wpaper = 220;
                $Hpaper = 450;
                $pdf->AddPage('P',array($Hpaper,$Wpaper));
                $img = base_url().'uploads/logo/draft.png';
                $pdf->Image($img,10,10,220,310);
                $pdf->useTemplate($templateId);
              }
              $pdf->Output($filenameW,'F');
            }
            catch (Exception $e) {}
            //EOFCreate pdf watermark
            //$data = file_get_contents($lok_fileWm.$file);
            //force_download($file, $data);
          }  
        }
      }else{
      	echo 'File '.$file.' Tidak Didokumentasikan (Sebelum penggunaan e-Sign)';
      }
    }
    
    //EOF() Create Draft Naskah
    if($view == NULL) {
      if($menu == 2){
        $bap_permohonan = new tmbap_tmpermohonan();
        $bap_permohonan->where('tmpermohonan_id', $id_daftar)->get();
        //$bap = new tmbap();
        //$bap->where('id',$bap_permohonan->tmbap_id)
        //    ->update('approve', 3);
        redirect('permohonan/bap/index_next');
      }else{  
        redirect('assets/download/'.$redirect.'.docx');
      } 
    } else {
      if ($view == 0) {
        redirect('permohonan/penetapan/index');
      } elseif($view == 1) {
        redirect('permohonan/penetapan/penomoran/'. $id_daftar .'/'. $id_izin .'/1');
      } else {
        redirect('permohonan/penetapan');
      }
    }
      //redirect('permohonan/penetapan');
      
  }

  public function cetak_preview($id_daftar = NULL, $menu = NULL, $view = NULL){
    $a = "select * from tmpegawai where status = '1'";
    $hasil = $this->db->query($a)->row_array();
    $a22 = "select * from tmpermohonan where id ='".$id_daftar."'";
    $hasil22 = $this->db->query($a22)->row_array();
    $nodaftar = $hasil22['pendaftaran_id'];
    
    $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."')";
    $hasil2 = $this->db->query($b)->row_array();
    $e_sertifikat = $hasil2['e_sertifikat'];
    
    $d = "select * from trmengingat 
          where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='".$hasil2['id']."') order by jenis,nomor,tahun asc";
    $hasil4 = $this->db->query($d)->result();
    $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil5 = $this->db->query($e)->result();
    $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil6 = $this->db->query($f)->result();        
    $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
    $hasil7 = $this->db->query($g)->row_array(); 

    $kota = "select * from trkabupaten 
             where id in(select trkabupaten_id from trkabupaten_trkecamatan 
             where trkecamatan_id in(select id from trkecamatan 
             where id in(select trkecamatan_id from trkecamatan_trkelurahan 
             where trkelurahan_id in(select id from trkelurahan 
             where id in(select trkelurahan_id from tmpemohon_trkelurahan 
             where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan 
             where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."'))))))) ";
    $sqlkota = $this->db->query($kota)->row_array();
         
    $pemohon_portal = new tmpemohon_portal();                      
    $pemohon_portal->where('id', $hasil22['id_pemohon_portal'])->get();
    $nib = $pemohon_portal->nib;
    if($nib == '') $nib='-';                    
         
    $surat_keluar = new tmsurat_keluar();
    $surat_keluar->where('tmpermohonan_id', $id_daftar)->get();
    $tgl_surat = $surat_keluar->tgl_surat;
    $no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
    if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
    if($surat_keluar->no_surat == '') $no_pertek = '-';
    
    $redirect = str_replace(' ', '','SK_'.$nodaftar);
    $file_target = 'assets/download/'.$redirect.'.docx';

    if (!file_exists($file_target) || $view == 1) {
      require_once 'assets/phpword/src/PhpWord/Autoloader.php';
      \PhpOffice\PhpWord\Autoloader::register();

      switch($menu){
        case 1 :  // SK
          $isSK = TRUE;
          $redirect = str_replace(' ', '','SK_'.$nodaftar);
          $string3 = "select * from trperizinan_template 
                      where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
          $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template']);
          break;
      }
      $c = $string3;
      $hasil3 = $this->db->query($c)->result();

      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
      $blnRomawi = $arrblnRomawi[date("m")-1];

      ############################################
      #                                          #
      #   NEW QUERY PEMOHON DAN PERUSAHAAN       #
      #                                          #
      ############################################
      $qqq = "select * from tmpemohon where id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = '".$id_daftar."')";
      $dt_pemohon = $this->db->query($qqq)->row_array();
      $qqq2 = "select * from tmperusahaan where id = (select tmperusahaan_id from tmpermohonan_tmperusahaan where tmpermohonan_id = '".$id_daftar."')";
      $dt_pemohon2 = $this->db->query($qqq2)->row_array();
      $bulanArr = array("Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
      $expl = explode("-",$hasil22["d_terima_berkas"]);
      $blnIndo = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
      if(count($dt_pemohon2) > 0){
        $nperusahaan = $dt_pemohon2['n_perusahaan'];
        $alamatperusahaan = $dt_pemohon2['a_perusahaan'];
        $npwpperusahaan = $dt_pemohon2['npwp'];
        $perusahaan = new tmperusahaan();
        $perusahaan->get_by_id($dt_pemohon2['id']);
        $kelurahan = $perusahaan->trkelurahan->get();
        $kecamatan = $perusahaan->trkelurahan->trkecamatan->get();
        $kabupaten = $perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $provinsi = $perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $desaperusahaan = $kelurahan->n_kelurahan;
        $kecperusahaan  = $kecamatan->n_kecamatan;
        $kabperusahaan  = $kabupaten->n_kabupaten;
        $provperusahaan = $provinsi->n_propinsi;
      }else{
        $nperusahaan = $dt_pemohon['n_pemohon'];
        $alamatperusahaan = $dt_pemohon['a_pemohon'];
        $npwpperusahaan = '';
        $desaperusahaan = '';
        $kecperusahaan  = '';
        $kabperusahaan  = '';
        $provperusahaan = '';
      }
      
      if($menu == 2){
        $nosk     = '';
        $tgl_sk   = '0000-00-00';
      }else{  
        $nosk     = (!empty($hasil7['no_surat']) ? $hasil7['no_surat'] : '');
        $tgl_sk   = (!empty($hasil7['tgl_surat_edit']) ? $hasil7['tgl_surat_edit']: '');
      }
      $namaizin = $hasil2['n_perizinan'];
      $id_izin  = $hasil2['id'];
      
        $pegawai = new tmpegawai();
        $pegawai = $pegawai->where('status', '1')->get();
      
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
      // EOF() Ttd SK
             
      //Create Konten Izin untuk di kunci
      $konten = $this->lib_date->all_property($id_izin, $id_daftar);
      $kontenizin = 'ID. '.$nodaftar.$konten;
      $kontenizin = trim($kontenizin);
      //EOF() Create Konten Izin untuk di kunci

      //Create QRCode
      include('./assets/qrcode/qrlib.php');
      $tempDir = 'uploads/data_qrcode_naskah/';
      //$link = 'http://spekta.tasikmalayakab.go.id/spekta/main/cekiz/index/';
      $local = $_SERVER['PHP_SELF'];
      $url = $local;
      
      // Cari posisi kata "android" dalam URL
      $pos = strpos($url, "/backoffice");
      if ($pos !== false) {
          // Ambil bagian URL sebelum "android"
          $local = substr($url, 0, $pos);
      } else {
          // Jika tidak ada kata "android", gunakan URL asli
          $local = $url;
      }
      $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$local;
      $link = "$domain/main/cekiz/index/";
      $key = 'ky_'.md5($kontenizin); // Create Content Key
      //$codeContents = 'ID._'.$nodaftar.'_NoSurat:_'.$nosk.'_TglSurat:_'.$tgl_sk;
      $codeContents = $nodaftar;
      //if($isSK){ // jika SK Izin
        //$codeContents = $link.$codeContents.'_idkeySK.'.$key;
      //}else{     // jika Sartek
        $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      //}
      //$codeContents = str_replace(' ', '_',$codeContents);
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
      $pngAbsoluteFilePath = $tempDir.$fileName;
      $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
      if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
        
      if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
        $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
        $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
        $padding = 0;
        QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
        //$s_izin = new tmpermohonan();
        // $s_izin->where('id', $id_daftar)->update('file_naskah', $fileName);
        // $s_izin->where('id', $id_daftar)->update('file_konten', $key); 
      }
      //EOF() Create QRCode
      
      //Create Variabel => transfer variabel pencetakan All
      // hindari input data menggunakan karakter & < >
      $templateProcessor->setValue("provinsi",'KABUPATEN TASIKMALAYA');                               // Nama Provinsi Penandatangan
      $templateProcessor->setValue("jabatan",$jbt);                                     // Jabatan Penandatangan
      $templateProcessor->setValue("kepala",$ttd_kepala);                                           // Nama Kepala Penandatangan
      $templateProcessor->setValue("pangkat",$ttd_pangkat);                                         // Pangkat Penandatangan
      $templateProcessor->setValue("nip",$ttd_nip);                                                 // NIP Penandatangan
      $templateProcessor->setValue("nopendaftaran",$nodaftar);                                      // Nomor Pendaftaran
      $templateProcessor->setValue("tgl_daftar",$blnIndo);                                          // Tanggal Pendaftaran
      $templateProcessor->setValue("npemohon",$dt_pemohon['n_pemohon']);                            // Nama Pemohon
      $templateProcessor->setValue("nperusahaan",$nperusahaan);                                     // Nama Perusahaan
      $templateProcessor->setValue("alamatperusahaan",$alamatperusahaan);                           // Alamat Perusahaan
      $templateProcessor->setValue("perusahaan_npwp",$npwpperusahaan);                              // NPWP Perusahaan
      $templateProcessor->setValue("perusahaan_prov",$provperusahaan);                              // Alamat Perusahaan Provinsi
      $templateProcessor->setValue("perusahaan_kab",$kabperusahaan);                                // Alamat Perusahaan Kab/Kota
      $templateProcessor->setValue("perusahaan_kec",$kecperusahaan);                                // Alamat Perusahaan Kecamatan
      $templateProcessor->setValue("perusahaan_desa",$desaperusahaan);                              // Alamat Perusahaan Desa/Kelurahan
      $templateProcessor->setValue("namaizin",$namaizin);                                           // Nama Izin
      $templateProcessor->setValue("nosk",$nosk);                                                   // Nomor SK
      $templateProcessor->setValue("tglsk",$this->lib_date->mysql_to_human($tgl_sk));               // Tanggal SK
      $templateProcessor->setValue("bulanromawi",$blnRomawi);                                       // Bulan Romawi Sekarang
      $templateProcessor->setValue("tahunini",date("Y"));                                           // Tahun Sekarang
      $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));  // tanggal Sekarang
      $templateProcessor->setValue("no_mohon_sartek",$no_pertek);                                   // nomor permohonan pertek ke tim teknis
      $templateProcessor->setValue("tgl_mohon_sartek",$this->lib_date->mysql_to_human($tgl_surat)); // tanggal permohonan pertek ke tim teknis
      $templateProcessor->setValue("nib",$nib);                                                     // Nomor Induk Berusaha
      
        
      //Ambil dan Tampilkan QrCode
      $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
      $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 110, 110 )));// QrCode
      
      //Ambil dan Tampilkan TTD Kadis        
      $image_path = 'uploads/logo/'.str_replace(' ', '', $ttd_nip).'.png';
      $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 140, 87 ))); //default = 100, 47     // ttd kadis

      //Ambil dan Tampilkan TTD Kadis        
      $image_path = 'uploads/qrcode/'.str_replace(' ', '', $ttd_nip).'.png';
      $templateProcessor->setImg('ttd_qrcode', array('src' => $image_path,'size' => array( 110, 110 ))); //default = 100, 47     // ttd kadis

      //Ambil dan Tampilkan Kop Surat
      $image_path = 'uploads/logo/kop.png';
      $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
      
      //Ambil dan Tampilkan BSrE
      if($e_sertifikat == 1){
        $image_path = 'uploads/logo/bsre.png';
        $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 795, 80 ))); // Logo Bsre
      }else{
        $image_path = 'uploads/logo/nonbsre.jpg';
        $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 600, 80 ))); // Logo Bsre
      }
      
      //Ambil dan Tampilkan Cap Dinas
      $image_path = 'uploads/logo/CapDinas.png';
      $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas
      
      //Create Variabel => transfer variabel pencetakan All EOF()
      ############################################
      #                                          #
      # END OF NEW QUERY PEMOHON DAN PERUSAHAAN  #
      #                                          #
      ############################################
             
      //menimbang--------------
      
      function docx2text($filename) {
        return readZippedXML($filename, "word/document.xml");
      }
      $tulis_nama = array();
      $tulis_variable = array();

      function readZippedXML($archiveFile, $dataFile) {
        $zip = new ZipArchive;
        if(true === $zip->open($archiveFile)) {
          if(($index = $zip->locateName($dataFile)) !== false) {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new DOMDocument();
            $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            return strip_tags($xml->saveXML());
          }
          $zip->close();
        }
        return "";
      }
          
      if($menu==1) $text = docx2text('assets/template-baru/'.$hasil2['template']);
          
      $texts = explode(" ", $text);
      $output = array();
      $output2 = array();
      $output3 = array();
      foreach($texts as $t) {
        if(strpos($t, '${menimbang}') !== false)     $output[] = $t;
        if(strpos($t, '${mengingat}') !== false)     $output2[] = $t;
        if(strpos($t, '${memperhatikan}') !== false) $output3[] = $t;
      }
            
      //menimbang--------------
      if(count($output) > 0){
        $no = 1;
        if(count($hasil5) > 0){
          $templateProcessor->cloneRow('menimbang', count($hasil5));
          foreach($hasil5 as $ha5){
            $templateProcessor->setValue("menimbang#".$no,$ha5->deskripsi);
            $no++;
          }
          $no = 1;
          foreach($hasil5 as $ha5){
            $templateProcessor->setValue("No1#".$no,$no);
            $no++;
          }
        }else{
          $templateProcessor->setValue("menimbang","");
          $templateProcessor->setValue("No1","");
        }
      }
      //EOF() menimbang---------

      //mengingat---------------
      if(count($output2) > 0){
        $no = 1;
        if(count($hasil4) > 0){
          $templateProcessor->cloneRow('mengingat', count($hasil4));
          foreach($hasil4 as $ha4){
            $templateProcessor->setValue("mengingat#".$no,$ha4->deskripsi);
            $no++;
          }
          $no = 1;
          foreach($hasil4 as $ha4){
            $templateProcessor->setValue("No2#".$no,$no);
            $no++;
          }
        }else{
          $templateProcessor->setValue("mengingat","");
          $templateProcessor->setValue("No2","");
        }
      }
      //EOF() mengingat---------   
    
      //memperhatikan-----------
      if(count($output3) > 0){ 
        $no = 1;
        if(count($hasil6) > 0){
          $templateProcessor->cloneRow('memperhatikan', count($hasil6));
          foreach($hasil6 as $ha6){
            $templateProcessor->setValue("memperhatikan#".$no,$ha6->deskripsi);
            $no++;
          }
          $no = 1;
          foreach($hasil6 as $ha6){
            $templateProcessor->setValue("No3#".$no,$no);
            $no++;
          }
        }else{
          $templateProcessor->setValue("memperhatikan","");
          $templateProcessor->setValue("No3","");
        }
      }
      //EOF() memperhatikan-----

      $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
      $cxv = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc")->result();
      $cx3 = count($cxv);
      $blnID = array("Januari","Februari","Maret",'April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
      if($cx3 == 0){
        $templateProcessor->setValue("text_atas"," ");
        $templateProcessor->setValue("text_alasan1"," ");
        $templateProcessor->setValue("text_alasan2"," ");
        $templateProcessor->setValue("No4"," ");
        $templateProcessor->setValue("t1"," ");
        $templateProcessor->setValue("t2"," ");
        $templateProcessor->setValue("t3"," ");
        $templateProcessor->setValue("t4"," ");
        $templateProcessor->setValue("t5"," ");
        $templateProcessor->setValue("No5"," ");
        $templateProcessor->setValue("prop"," ");
        $templateProcessor->setValue("dari", " ");
        $templateProcessor->setValue("menjadi"," ");
        $templateProcessor->setValue("tgl_berubah"," ");
      }else{
        $arr1 = array();
        $arr2 = array();
        foreach ($cxv as $key) {
          $arr1[] = $key->id;
          $arr2[$key->id] = $key->tgl_revisi; 
        }
        $many1 = implode(",", $arr1);
        $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi in($many1) order by data asc,id asc");
        $cx4 = $cx2->result();
          
        $templateProcessor->setValue("text_atas"," ");
        $templateProcessor->setValue("text_alasan1","(Catatan perubahan) : ");
        $templateProcessor->setValue("text_alasan2","");
        $templateProcessor->setValue("No4"," ");
        $templateProcessor->setValue("t1","No.");
        $templateProcessor->setValue("t2","Properti");
        $templateProcessor->setValue("t3","Semula");
        $templateProcessor->setValue("t4","Menjadi");
        $templateProcessor->setValue("t5","Tanggal Berubah");
        $templateProcessor->cloneRow('No5', count($cx4));
        $u = 1;
        foreach($cx4 as $cc){
          $wa = explode(" ",$arr2[$cc->id_revisi]);
          $templateProcessor->setValue("No5#".$u,"$u");
          $templateProcessor->setValue("prop#".$u,$cc->data);
          $templateProcessor->setValue("dari#".$u, $cc->asal);
          $templateProcessor->setValue("menjadi#".$u,$cc->jadi);
          $templateProcessor->setValue("tgl_berubah#".$u,$wa[0]);
          $u++;
        }
      }

      foreach ($hasil3 as $data) {
        $tek = "var_teknis" . $data->urutan_vars_teknis;
        $prop = isset($hasil2[$tek]) ? $hasil2[$tek] : null; // Use isset to handle undefined index
        if (empty($prop)) {
            break;
        }
        $array = explode("^", $prop);
        $tek2 = "dt_teknis" . $data->urutan_vars_teknis;
        $prop2 = isset($hasil22[$tek2]) ? $hasil22[$tek2] : null; // Use isset to handle undefined index
        $prop2 = str_replace("&", "-", $prop2); // tanda & mengakibatkan error
        if (empty($prop2)) {
            break;
        }
        
        $array2 = explode("^", $prop2);
        if ($data->t_value == "v_pokja") {
            $data->t_value = "v_tanggalpertek2";
        }
        
        if (isset($array2[1]) && strtotime($array2[1])) {
            $bulanArr = array("Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $expl = explode("-", $array2[1]);
            
            // Check if the $expl array has the expected number of elements
            if (count($expl) === 3) {
                // $array2[1] = $expl[2] .' '. $bulanArr[$expl[1] - 1] .' '. $expl[0];
            }
        }
    if (strpos($array2[1], 'Lisensi') !== false) {
        // The string contains the word "lisensi"// Function to check if a string is a valid date
          if(is_valid_date($array2[1])){
            $date_sk = $this->lib_date->mysql_to_human($array2[1]);
            $templateProcessor->setValue("tglsk", $date_sk);
          }
        // Add your code execution here
    } 
        // Check if $array[1] and $array2[1] exist before setting the values
        $templateProcessor->setValue($data->t_nama, $array[1]);
        if(!empty($array2[1])){
        $templateProcessor->setValue($data->t_value, $array2[1]);
        }else{
        $templateProcessor->setValue($data->t_value, $array2[0]);
        }
    }
              
      $kota = explode(' ', $sqlkota['n_kabupaten']);
      if($kota[0] == 'KOTA') {
        $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
      }else{
        $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
      }
   
      if($kota[0] == 'KOTA'){
        $templateProcessor->setValue('ket','Kota'); 
        $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
      }else{
        $templateProcessor->setValue('ket','Kab.'); 
        $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
      }

      //Create File docx
      $file_target = 'assets/download/'.$redirect.'.docx';
      $templateProcessor->saveAs($file_target);
      //EOF() Create File docx
    }
    
    // Konfersi docx ke pdf di folder backoffice/assets/skpdf
    $draft = FALSE;
      if($e_sertifikat == 1) {   //penggunaan SE 
        if(file_exists('assets/skpdf/'.$redirect.'.pdf') && $view != 1){
          $file = $redirect.'.pdf';
          $file_draft = 'DRAFT'.$redirect.'.pdf';
          $lok_fileDr = 'assets/skpdf/';
          $lok_fileWm = 'assets/skpdfWM/';
          $lok_fileSE = 'assets/esignfile/';
          $this->load->helper('download');
          if(file_exists($lok_fileDr.$file)){              // cek PDF Draft
                //Create pdf watermark
                $this->load->library('cfpdf');
                $this->load->library('cfpdi');
                $pdf = new FPDI();            
                $local = $_SERVER['SCRIPT_FILENAME'];
                $url = $local;
                // Cari posisi kata "android" dalam URL
                $pos = strpos($url, "/backoffice");
                if ($pos !== false) {
                    // Ambil bagian URL sebelum "android"
                    $local = substr($url, 0, $pos);
                } else {
                    // Jika tidak ada kata "android", gunakan URL asli
                    $local = $url;
                }
                $filename  = $local .'/backoffice/assets/skpdf/'.$file; //Lokasi File Tanpa WaterMark
                $filenameW = $local .'/backoffice/assets/skpdfWM/'.$file;    //Lokasi File WaterMark
                try{
                  $pageCount = $pdf->setSourceFile($filename);
                  for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);
                    $Wpaper = 220;
                    $Hpaper = 450;
                    $pdf->AddPage('P',array($Hpaper,$Wpaper));
                    $img = base_url().'uploads/logo/draft.png';
                    $pdf->Image($img,10,10,220,310);
                    $pdf->useTemplate($templateId);
                  }
                  $pdf->Output($filenameW,'F');
                }
                catch (Exception $e) {}
                //EOFCreate pdf watermark
                // $data = file_get_contents($lok_fileWm.$file);
                // force_download($file, $data);
                redirect($lok_fileWm.$file);
          }else{
            echo 'File '.$file.' Tidak Didokumentasikan (Sebelum penggunaan e-Sign)';
          }
        } else {
          $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
          $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
          $context = stream_context_create($opts);      
          $local = $_SERVER['PHP_SELF'];
          $url = $local;
          
          // Cari posisi kata "android" dalam URL
          $pos = strpos($url, "/backoffice");
          if ($pos !== false) {
              // Ambil bagian URL sebelum "android"
              $local = substr($url, 0, $pos);
          } else {
              // Jika tidak ada kata "android", gunakan URL asli
              $local = $url;
          }
          $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$local;
          $base_domain = base64_encode($domain);
          $data = file_get_contents('http://103.122.5.250/siapi/api/default-izin?id='.$namafile.'&token=9wdxc7txiH&url='.$base_domain, FALSE, $context);
          // $data = file_get_contents('http://localhost/convert/index.php?id='.$namafile.'&link='.$base_domain, FALSE, $context);
          $data = json_decode($data);
          if($data->status == 'success') {
            $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
            // $dtpdf = 'http://localhost/convert/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';  
            $local = $_SERVER['SCRIPT_FILENAME'];
            $url = $local;
            // Cari posisi kata "android" dalam URL
            $pos = strpos($url, "/backoffice");
            if ($pos !== false) {
                // Ambil bagian URL sebelum "android"
                $local = substr($url, 0, $pos);
            } else {
                // Jika tidak ada kata "android", gunakan URL asli
                $local = $url;
            }
            $newfile = $local. '/backoffice/assets/skpdf/'.$namafile.'.pdf';       
            if (copy($dtpdf, $newfile)) {
              $draft = TRUE;
              //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelspekta&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
              //echo 'Sukses';
              //Create Draft Naskah
              if($draft){
                $file = $redirect.'.pdf';
                $file_draft = 'DRAFT'.$redirect.'.pdf';
                $lok_fileDr = 'assets/skpdf/';
                $lok_fileWm = 'assets/skpdfWM/';
                $lok_fileSE = 'assets/esignfile/';
                $this->load->helper('download');
                if(file_exists($lok_fileDr.$file)){              // cek PDF Draft
                      //Create pdf watermark
                      $this->load->library('cfpdf');
                      $this->load->library('cfpdi');
                      $pdf = new FPDI();
                      $filename  = $local .'/backoffice/assets/skpdf/'.$file; //Lokasi File Tanpa WaterMark
                      $filenameW = $local .'/backoffice/assets/skpdfWM/'.$file;    //Lokasi File WaterMark
                      try{
                        $pageCount = $pdf->setSourceFile($filename);
                        for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                          $templateId = $pdf->importPage($pageNo);
                          $size = $pdf->getTemplateSize($templateId);
                          $Wpaper = 220;
                          $Hpaper = 450;
                          $pdf->AddPage('P',array($Hpaper,$Wpaper));
                          $img = base_url().'uploads/logo/draft.png';
                          $pdf->Image($img,10,10,220,310);
                          $pdf->useTemplate($templateId);
                        }
                        $pdf->Output($filenameW,'F');
                      }
                      catch (Exception $e) {}
                      //EOFCreate pdf watermark
                      // $data = file_get_contents($lok_fileWm.$file);
                      // force_download($file, $data);
                      redirect($lok_fileWm.$file);
                }else{
                  echo 'File '.$file.' Tidak Didokumentasikan (Sebelum penggunaan e-Sign)';
                }
              }
              //EOF() Create Draft Naskah
            }
          }else{
            $this->session->set_flashdata('gagal', "Gagal Konversi PDF, Silahkan mengulangi proses.");
            if ($view == 1) {
              redirect('permohonan/penetapan');
            } else {
              redirect('permohonan/sk');
            }
            
          }
        }
      // EOF() Konfersi docx ke pdf di folder backoffice/assets/skpdf
        } else {
          redirect('assets/download/'.$redirect.'.docx');
        }
  }
  
    public function cetak_OLD($id_daftar = NULL) {
        $nama_surat = "cetak_sk";
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();
//        $app_sk = new settings();
//        $app_sk->where('name','app_sk')->get();
//        $app_sk = $app_sk->value;

        $petugas = 1; //1 -> Jabatan Penandatangan
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsk->get();
        $sts_cetak = 1;
        if($surat_awal->id){
            $surat_sk = new tmsk();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
//            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365);
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
        }else{
            /* Input Data */
            $data_id = new tmsk();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

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
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsk();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
//            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365); //per tahun
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
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
                //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin->status = 'Update';
                $tracking_izin->d_entry = $this->lib_date->get_date_now();
                $tracking_izin->save();

            /* [Lihat Tabel trstspermohonan()] */
                $tracking_izin2 = new tmtrackingperizinan();
                $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin2->status = 'Insert';
                $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin2->d_entry = $this->lib_date->get_date_now();
                $sts_izin2 = new trstspermohonan();
                $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
                $sts_izin2->save($permohonan);
                $tracking_izin2->save($permohonan);
                $tracking_izin2->save($sts_izin2);

            /* [Lihat Tabel trstspermohonan()] 
                $tracking_izin3 = new tmtrackingperizinan();
                $tracking_izin3->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin3->status = 'Insert';
                $tracking_izin3->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin3->d_entry = $this->lib_date->get_date_now();
                $sts_izin3 = new trstspermohonan();
                $sts_izin3->get_by_id($id_status2); //[Lihat Tabel trstspermohonan()]
                $sts_izin3->save($permohonan);
                $tracking_izin3->save($permohonan);
                $tracking_izin3->save($sts_izin3);*/
            //}
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
                //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin->status = 'Update';
                $tracking_izin->d_entry = $this->lib_date->get_date_now();
                $tracking_izin->save();

            /* [Lihat Tabel trstspermohonan()] */
                $tracking_izin2 = new tmtrackingperizinan();
                $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin2->status = 'Insert';
                $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin2->d_entry = $this->lib_date->get_date_now();
                $sts_izin2 = new trstspermohonan();
                $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
                $sts_izin2->save($permohonan);
                $tracking_izin2->save($permohonan);
                $tracking_izin2->save($sts_izin2);

            /* [Lihat Tabel trstspermohonan()] 
                $tracking_izin3 = new tmtrackingperizinan();
                $tracking_izin3->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin3->status = 'Insert';
                $tracking_izin3->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin3->d_entry = $this->lib_date->get_date_now();
                $sts_izin3 = new trstspermohonan();
                $sts_izin3->get_by_id($id_status3); //[Lihat Tabel trstspermohonan()]
                $sts_izin3->save($permohonan);
                $tracking_izin3->save($permohonan);
                $tracking_izin3->save($sts_izin3);*/
//            /}
        }
        //end edit
        //Status cetak SK
        $sk = new tmsk();
        $sk->get_by_id($surat_awal->id);
		// edit BKPM
		if($sk->c_cetak<1){        
        	$permohonan = new tmpermohonan();
        	$permohonan->get_by_id($id_daftar);
			$kd_sektor = $permohonan->trsektor_id;
        	$bap = new tmbap();
			$bap = $permohonan->tmbap->get();
			if($kd_sektor == 12){ // khusus izin bidang bkpm
    			$this->load->library('SendData');
	    		$this->senddata->SendData($id_daftar,"2");
            	$this->senddata->sendData($id_daftar);
			}
        } 
		// EOF() edit BKPM
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $sk->save();

        $surat = $permohonan->tmsk->get();
        $pemohon = $permohonan->tmpemohon->get();
        $jenis_izin = $permohonan->trperizinan->get();
        //$petugas = $surat->tmpegawai->get();


        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');
//        $odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');
        $odf->setVars ('ttd', '');



		 //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(14);
        if($logo->value!=="")
        {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '1.7', '1.7');
        }
        else
        {
            $odf->setVars('logo', ' ');
        }

        //pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

        //e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(18);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
        $odf->setVars('k_kota', $kop_kota->value);

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);


        //fill the template with the variables
        $nama_izin = $jenis_izin->n_perizinan;
        $data_judul = $jenis_izin->c_judul;
        $odf->setVars('nama_izin', strtoupper($nama_izin));
        $odf->setVars('no_surat', $surat->no_surat);
        $odf->setVars('tanggal', $this->lib_date->mysql_to_human($surat->tgl_surat));
        $odf->setVars('jabatan', $pegawai->n_jabatan);
        $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
        $odf->setVars('nip_pejabat', $pegawai->nip);
         $odf->setVars('kantor', $app_kan->value);
        if($jenis_izin->c_foto == 1){
        $odf->setVars('ket_pemohon', "Tanda tangan pemegang");
        $odf->setVars('nama_pemohon', strtoupper($pemohon->n_pemohon));
        }else{
        $odf->setVars('ket_pemohon', "");
        $odf->setVars('nama_pemohon', "");
        }
        $wilayah = new trkabupaten();
        if($app_city !== '0'){
            $wilayah->get_by_id($app_city);
            //$kota = ucwords(strtolower($wilayah->n_kabupaten));
            $kota = $wilayah->ibukota;
            $odf->setVars('kota', $kota);
        }else{
            $kota = "..............";
            $odf->setVars('kota', $kota);
        }

        $gede_kota=strtoupper($wilayah->n_kabupaten);
        $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
        $odf->setVars('kota4', $gede_kota);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', ucwords(strtolower($alamat->value)).' - '.$kecil_kota);


        //Head Ketetapan SK
        $listeArticles = array(
                array(	'property' => '',
                        'content' => 'Berdasarkan :',
                ),
        );
        $article = $odf->setSegment('articles1');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['content']);
                $article->merge();
        }
        $odf->mergeSegment($article);

        //Content Ketetapan SK
         $i = 1;
//        $izin_hukum = new trdasar_hukum_trperizinan();
//        $list_hukum = $izin_hukum->where('type', 0)
//                        ->where('trperizinan_id', $data1->id)->order_by('trdasar_hukum_id', 'ASC')->get(); //17 2
          $list_hukum = $this->getDatahukum($permohonan->trperizinan->id);


        if ($list_hukum) {
            foreach ($list_hukum as $hukum) {
                $dasar_hukum = new trdasar_hukum();
                if ($hukum->id) {
                    $data6 = $dasar_hukum->where('id', $hukum->trdasar_hukum_id)->get();
                    $desk = $data6->deskripsi;
                } else {
                    $desk = ' ';
//                      $i=' ';
                }


                $listeArticles = array(
                    array('property' => $i . '.',
                        'content' => $desk,
                    ),
                );

                $article = $odf->setSegment('articles2');
                foreach ($listeArticles AS $element2) {
                    $article->titreArticle($element2['property']);
                    $article->texteArticle($element2['content']);
                    $article->merge();
                }
                $i++;
            }
        } else {
            $desk = ' ';
            $listeArticles = array(
                array('property' => ' ',
                    'content' => $desk,
                ),
            );
            
            $article2 = $odf->setSegment('articles2');
            foreach ($listeArticles AS $element2) {
                $article2->titreArticle($element2['property']);
                $article2->texteArticle($element2['content']);
                $article2->merge();
            }
        }
        $odf->mergeSegment($article);

        //Head Property
        if($data_judul == "1") $head = "Mengizinkan";
        else $head = "Memberikan ".$nama_izin." kepada";
        $listeArticles = array(
                array(	'property' => '',
                        'content' => $head.' :',
                ),
        );
        $article = $odf->setSegment('articles3');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['content']);
                $article->merge();
        }
        $odf->mergeSegment($article);

        //Content Property
        
         $perizinan = new trperizinan();
        $perizinan->get_by_id($jenis_izin->id);
        $list_daftar = $permohonan->tmproperty_jenisperizinan->get();
        $lists = $perizinan->trproperty->include_join_fields()->where('c_type', 2)->order_by('c_parent_order', "asc")->get();

        $property = $odf->setSegment('property');
        foreach ($lists as $list) {
            //$property->nama($list->n_property);
            $children = $perizinan->trproperty->where('c_sk_id', 1)->where_join_field($perizinan, 'c_parent', $list->id)->include_join_fields()->order_by('c_order', "asc")->get();
            
            //added 11-04-2013
            //by mucktar
            $child_exist = false;
            //loop cek jika child ditemukan
            foreach($children as $child_){
                if($child_->id && ($list->id!==$child_->id)){
                    $child_exist = true;
                    break;
                }
            }
            
            //jika child ditemukan, set nama parent
            if($child_exist){
                $property->nama($list->n_property);
            }
            
            //end add
            
            foreach ($children as $child_) {
                if ($list->id !== $child_->id) {
                    $property->child->child($child_->n_property);
// ................................ Isi ...........................
                    if ($list_daftar->id) {
                        foreach ($list_daftar as $data_daftar) {
                            $entry_property = new tmproperty_jenisperizinan_trproperty();
                            $entry_property->where('tmproperty_jenisperizinan_id', $data_daftar->id)
                                    ->where('trproperty_id', $child_->id)->get();
                            $izin_property = new trperizinan_trproperty();
                            $izin_property->where('trperizinan_id', $jenis_izin->id)
                                    ->where('trproperty_id', $child_->id)->get();
                            if ($entry_property->tmproperty_jenisperizinan_id) {
                                $entry_daftar = new tmproperty_jenisperizinan();
                                $koefret = new trkoefesientarifretribusi();
                                $entry_daftar->get_by_id($entry_property->tmproperty_jenisperizinan_id);
                                $pil = $koefret->get_by_id($entry_daftar->k_tinjauan);
                                $data_koefisient = $entry_daftar->v_tinjauan;
                                $isilow = strtolower($pil->kategori . " " . $data_koefisient . " " . $izin_property->satuan);
                                $isi = ucwords($isilow);
                                $property->child->isi($isi);
                            }
                        }
                    }

                    if ($child_->join_c_retribusi_id === '1') {
                        $property->child->indeks("");
                    } else {
                        $property->child->indeks("");
                    }
                    $property->child->merge();
                }
            }
            $property->merge();
        }
        $odf->mergeSegment($property);

        //Head Property
        $listeArticles = array(
                array(	'property' => '',
                        'content' => 'Dengan ketentuan :',
                ),
        );
        $article = $odf->setSegment('articles5');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['content']);
                $article->merge();
        }
        $odf->mergeSegment($article);

        $i = 1;
        $list_ketentuan = $permohonan->trperizinan->trketetapan->get();
        foreach($list_ketentuan as $data){
            $listeArticles = array(
                    array(  'property' => $i.'.',
                            'content' => $data->n_ketetapan,
                    ),
            );
            $article = $odf->setSegment('articles6');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->merge();
            }
            $i++;
        }
        if($i == '1'){
            $listeArticles = array(
                    array(  'property' => '',
                            'content' => '',
                    ),
            );
            $article = $odf->setSegment('articles6');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->merge();
            }
        }
        $odf->mergeSegment($article);

        //Content Retribusi
        $data_bap = $permohonan->tmbap->get();
        $retribusi = $data_bap->nilai_bap_awal;
        $keringanan = $permohonan->tmkeringananretribusi->get();
        if ($keringanan->id)
        {
            $nilai_ret1 = ($keringanan->v_prosentase_retribusi * 0.01) * $retribusi;
            $nilai_ret = $retribusi-$nilai_ret1;
        }
         else
         {
            $nilai_ret = $retribusi;
         }
            
        $odf->setVars('nor', $i.'. ');
        if($nilai_ret) $nilair = $this->terbilang->nominal($nilai_ret, 2);
        else $nilair = "0";
        $izin_kelompok = $jenis_izin->trkelompok_perizinan->get();

        //jika metode perhitungan manual
         $izin =$jenis_izin->id ;
        $this->perizinan = new trperizinan();
        $perizinan = $this->perizinan->get_by_id($izin);
        $property = $perizinan->trretribusi->get();

        if ($property->m_perhitungan == "1") {
            $prop = '45';
            $prop_nilai = $this->getTinjauan($id_daftar, $izin, $prop);
            
             if($izin_kelompok->id == 4) {
            if (isset($prop_nilai->v_tinjauan)) {
                if ($keringanan->id)
                {
                    $nilai_retM = ($keringanan->v_prosentase_retribusi * 0.01) * $prop_nilai->v_tinjauan;
                    $tot = $prop_nilai->v_tinjauan-$nilai_retM; 
                }
                else
                {
                    $tot = $prop_nilai->v_tinjauan;
                }
              $ket_retribusi = "Wajib membayar retribusi sebesar Rp. ".$tot;
            } else {
                $ket_retribusi = "Wajib membayar retribusi sebesar Rp. ______";
            }
       
            }
        else {
            $ket_retribusi = "Proses penerbitan izin ini tidak dikenai retribusi";
             }
        

            
        } else {
            if($izin_kelompok->id == 4) {
            $ket_retribusi = "Wajib membayar retribusi sebesar Rp. ".$nilair;
            //$ret = $permohonan->$perizinan->trretribusi->v_retribusi;
//            if ($ret=="")
//            {
//                $ret = "0";
//            }
//            $ket_retribusi = "Wajib membayar retribusi sebesar Rp. ".$ret;
             }
        else {
            $ket_retribusi = "Proses penerbitan izin ini tidak dikenai retribusi";
             }
            }
  $odf->setVars('retribusi', $ket_retribusi);
// -------------------| |----------------------
        
       
        $i++;

        //Content Masa Berlaku
        $berlaku = $permohonan->d_berlaku_izin;
        if($perizinan->c_berlaku == 1){
            $odf->setVars('nob', $i.'. ');
            if($berlaku){
                if($berlaku != '0000-00-00') $nilaib = $this->lib_date->mysql_to_human($berlaku);
                else $nilaib = "..............";
            }
            else $nilaib = "..............";
            if($perizinan->id == 2 || $perizinan->id == 3 || $perizinan->id == 88)
            $masa_berlaku = $perizinan->n_perizinan." ini berlaku sepanjang bangunan, pemilik dan fungsi bangunan tidak mengalami perubahan.";
            else $masa_berlaku = $perizinan->n_perizinan.' ini berlaku sampai dengan '.$nilaib;
        }else{
            $odf->setVars('nob', '');
            $masa_berlaku = '';
        }
        $odf->setVars('masaberlaku', $masa_berlaku);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");



        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile('surat_izin_'.$no_daftar.'.odt');

    }

  public function cetak_archive($id_daftar = NULL) {
    $nama_surat = "cetak_sk";
    $app_folder = new settings();
    $app_folder->where('name','app_folder')->get();
    $app_folder = $app_folder->value . "/";
    $app_city = new settings();
    $app_city->where('name','app_city')->get();
    $app_city = $app_city->value;
    
    $petugas = 1; //1 -> Jabatan Penandatangan
    $pegawai = new tmpegawai();
    $pegawai->where('status', $petugas)->get();
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_daftar);
    $perizinan = $permohonan->trperizinan->get();
    $surat_awal = $permohonan->tmsk->get();
    $sts_cetak = 1;
    
    $surat = $permohonan->tmsk->get();
    $pemohon = $permohonan->tmpemohon->get();
    $jenis_izin = $permohonan->trperizinan->get();
    
    //path of the template file
    $this->load->plugin('odf');
    $odf = new odf('assets/odt/'.$nama_surat.'.odt');
    $odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');
    if($permohonan->file_ttd)
      $odf->setImage('ttd', 'assets/upload/ttd/'.$permohonan->file_ttd, '2.5', '2.5');
    else
      $odf->setVars ('ttd', '');
    
    //fill the template with the variables
    $nama_izin = $jenis_izin->n_perizinan;
    $data_judul = $jenis_izin->c_judul;
    $odf->setVars('nama_izin', strtoupper($nama_izin));
    $odf->setVars('no_surat', $surat->no_surat);
    $odf->setVars('tanggal', $this->lib_date->mysql_to_human($surat->tgl_surat));
    $odf->setVars('jabatan', $pegawai->n_jabatan);
    $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
    $odf->setVars('nip_pejabat', $pegawai->nip);
    //$odf->setVars('jabatan', $pegawai->n_jabatan);
    //$odf->setVars('nama_pejabat', $permohonan->nama_ttd);
    //$odf->setVars('nip_pejabat', $permohonan->nip_ttd);
    if($jenis_izin->c_foto == 1){
      $odf->setVars('ket_pemohon', "Tanda tangan pemegang");
      $odf->setVars('nama_pemohon', strtoupper($pemohon->n_pemohon));
    }else{
      $odf->setVars('ket_pemohon', "");
      $odf->setVars('nama_pemohon', "");
    }
    $wilayah = new trkabupaten();
    if($app_city !== '0'){
      $wilayah->get_by_id($app_city);
      //$kota = ucwords(strtolower($wilayah->n_kabupaten));
      $kota = $wilayah->n_kabupaten;
      $odf->setVars('kota', $kota);
    }else{
      $kota = "..............";
      $odf->setVars('kota', $kota);
    }
    
    //Head Ketetapan SK
    $listeArticles = array(
    array('property' => '',
          'content' => 'Berdasarkan :',
         ),
    );
    $article = $odf->setSegment('articles1');
    foreach($listeArticles AS $element) {
      $article->titreArticle($element['property']);
      $article->texteArticle($element['content']);
      $article->merge();
    }
    $odf->mergeSegment($article);
    
    //Content Ketetapan SK
    $list_ketetapan = $permohonan->trperizinan->trdasar_hukum->order_by('id', 'asc')->get();
    $i = 1;
    foreach($list_ketetapan as $data){
      $rel = new trdasar_hukum_trperizinan();
      $rel->where(array('trdasar_hukum_id' => $data->id,'trperizinan_id' => $permohonan->trperizinan->id))->get();
      if($rel->type !== "1") {
        $listeArticles = array(array(  'property' => $i.'.','content' => $data->deskripsi,),);
        $article = $odf->setSegment('articles2');
        foreach($listeArticles AS $element) {
          $article->titreArticle($element['property']);
          $article->texteArticle($element['content']);
          $article->merge();
        }
        $i++;
      }
    }
    if($i == '1'){
      $listeArticles = array(array(  'property' => '','content' => '',),);
      $article = $odf->setSegment('articles2');
      foreach($listeArticles AS $element) {
        $article->titreArticle($element['property']);
        $article->texteArticle($element['content']);
        $article->merge();
      }
    }
    $odf->mergeSegment($article);
    
    //Head Property
    if($data_judul == "1") $head = "Mengizinkan";
    else $head = "Memberikan ".$nama_izin." kepada";
    $listeArticles = array(array(	'property' => '','content' => $head.' :',),);
    $article = $odf->setSegment('articles3');
    foreach($listeArticles AS $element) {
      $article->titreArticle($element['property']);
      $article->texteArticle($element['content']);
      $article->merge();
    }
    $odf->mergeSegment($article);
    
    //Content Property
    $i = 1;
    $list_property = $permohonan->trperizinan->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $list_content = $permohonan->tmproperty_jenisperizinan->get();
    foreach($list_property as $data){
      $property_satuan = new trperizinan_trproperty();
      $property_satuan->where('trproperty_id', $data->id)->get();
      if($list_content->id){
        foreach ($list_content as $data_daftar){
          $entry_property = new tmproperty_jenisperizinan_trproperty();
          $entry_property->where('tmproperty_jenisperizinan_id', $data_daftar->id)
                         ->where('trproperty_id', $data->id)->get();
          if($entry_property->tmproperty_jenisperizinan_id){
            $entry_daftar = new tmproperty_jenisperizinan();
            $entry_daftar->get_by_id($entry_property->tmproperty_jenisperizinan_id);
            $kelompok = $perizinan->trkelompok_perizinan->get();
            if($kelompok->id == 2 || $kelompok->id == 4){
              $data_entry = $entry_daftar->v_tinjauan;
              $id_koefisien = $entry_daftar->k_tinjauan;
            }else{
              $data_entry = $entry_daftar->v_property;
              $id_koefisien = $entry_daftar->k_property;
            }
            
            $izin_property = new trperizinan_trproperty();
            $izin_property->where('trperizinan_id', $jenis_izin->id)
                          ->where('trproperty_id', $data->id)->get();
            $id_sk = $izin_property->c_sk_id;
            if($data_entry){
              if($id_sk == '1'){
                if($data->c_type == '1'){
                  $data_koefisien = new trkoefesientarifretribusi();
                  $data_koefisien->get_by_id($id_koefisien);
                  $no = '';
                  $data_property = $data->n_property;
                  //if($data_entry) $all_entry = $data_koefisien->kategori.' ('.$data_entry.')';
                  //else $all_entry = $data_koefisien->kategori;
                  if($data_entry)
                    $all_entry = $data_entry;
                  else
                    $all_entry = '';
                  $titik = ":";
                  $i++;
                }else
                  if($data->c_type == '2'){
                    $no = '';
                    $data_property = $data->n_property;
                    $titik = "";
                    $all_entry = "";
                  }else{
                    $no = '';
                    $data_property = $data->n_property;
                    $titik = ":";
                    $all_entry = $data_entry." ".$property_satuan->satuan;
                    $i++;
                  }
                $listeArticles = array(array('no' => '',
                                             'property' => $data_property,
                                             'titik' => $titik,
                                             'content' => $all_entry,
                                            ),
                                      );
                $article = $odf->setSegment('articles4');
                foreach($listeArticles AS $element) {
                  $article->titreArticle($element['no']);
                  $article->texteArticle2($element['property']);
                  $article->texteArticle3($element['titik']);
                  $article->texteArticle($element['content']);
                  $article->merge();
                }
              }
            }
          }
        }
      }
      //if(empty($data_entry)) $data_entry = '';
      //if(empty($id_koefisien)) $id_koefisien = '';
    }
    if($i == '1'){
      $listeArticles = array(array('no' => '',
                                   'property' => '',
                                   'titik' => '',
                                   'content' => '',
                                  ),
                            );
      $article = $odf->setSegment('articles4');
      foreach($listeArticles AS $element) {
        $article->titreArticle($element['no']);
        $article->texteArticle2($element['property']);
        $article->texteArticle3($element['titik']);
        $article->texteArticle($element['content']);
        $article->merge();
      }
    }
    $odf->mergeSegment($article);
    
    //Head Property
    $listeArticles = array(array('property' => '',
                                 'content' => 'Dengan ketentuan :',
                                ),
                          );
    $article = $odf->setSegment('articles5');
    foreach($listeArticles AS $element) {
      $article->titreArticle($element['property']);
      $article->texteArticle($element['content']);
      $article->merge();
    }
    $odf->mergeSegment($article);
    
    $i = 1;
    $list_ketentuan = $permohonan->trperizinan->trketetapan->get();
    foreach($list_ketentuan as $data){
      $listeArticles = array(array('property' => $i.'.',
                                   'content' => $data->n_ketetapan,
                                  ),
                            );
      $article = $odf->setSegment('articles6');
      foreach($listeArticles AS $element) {
        $article->titreArticle($element['property']);
        $article->texteArticle($element['content']);
        $article->merge();
      }
      $i++;
    }
    if($i == '1'){
        $listeArticles = array(
                array(  'property' => '',
                        'content' => '',
                ),
        );
        $article = $odf->setSegment('articles6');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['content']);
                $article->merge();
        }
    }
    $odf->mergeSegment($article);
    
    //Content Retribusi
    $data_bap = $permohonan->tmbap->get();
    $retribusi = $data_bap->nilai_retribusi;
    $keringanan = $permohonan->tmkeringananretribusi->get();
    if($keringanan->id)
      $nilai_ret = ($keringanan->v_prosentase_retribusi * 0.01) * $retribusi;
    else
      $nilai_ret = $retribusi;
    $odf->setVars('nor', $i.'. ');
    if($nilai_ret)
      $nilair = $this->terbilang->nominal($nilai_ret, 2);
    else
      $nilair = "0";
    $izin_kelompok = $jenis_izin->trkelompok_perizinan->get();
    if($izin_kelompok->id == 4)
      $ket_retribusi = "Wajib membayar retribusi sebesar Rp. ".$nilair;
    else
      $ket_retribusi = "Proses penerbitan izin ini tidak dikenai retribusi";
    $odf->setVars('retribusi', $ket_retribusi);
    $i++;
    
    //Content Masa Berlaku
    $berlaku = $permohonan->d_berlaku_izin;
    if($perizinan->c_berlaku == 1){
      $odf->setVars('nob', $i.'. ');
      if($berlaku){
        if($berlaku != '0000-00-00')
          $nilaib = $this->lib_date->mysql_to_human($berlaku);
        else
          $nilaib = "..............";
      }else
        $nilaib = "..............";
      if($perizinan->id == 2 || $perizinan->id == 3 || $perizinan->id == 88)
        $masa_berlaku = $perizinan->n_perizinan." ini berlaku sepanjang bangunan, pemilik dan fungsi bangunan tidak mengalami perubahan.";
      else
        $masa_berlaku = $perizinan->n_perizinan.' ini berlaku sampai dengan '.$nilaib;
    }else{
      $odf->setVars('nob', '');
      $masa_berlaku = '';
    }
    $odf->setVars('masaberlaku', $masa_berlaku);
    
    //export the file
    $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
    $odf->exportAsAttachedFile('surat_izin_'.$no_daftar.'.odt');
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
			echo "<font style='font-size:12px;!important;'>Diberikan di Tasikmalaya<br>Tanggal :</font>";
			echo"</div>";

			echo "<div style='height:100px;position:absolute;right:50;top:575px;text-align:center'>";
			echo "<font style='font-size:12px;!important;'>BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU<br>PROVINSI TASIKMALAYA</font>";
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
			echo "<font style='font-size:22px;!important;font-weight:bold;'>PEMERINTAH PROVINSI TASIKMALAYA<BR>BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU</font>";
			echo"</div>";
			
			echo "<div style='height:100px;position:absolute;right:125;top:100px;text-align:center'>";
			echo "<font style='font-size:14px;!important;'>Jalan Sumatera No. 50 Telepon (022)4237369 Fax: (022) 4237081<BR>TASIKMALAYA - 40115</font>";
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
            echo "<font style='margin-left:100px;font-size:13px;' class='add'>Berdasarkan Keputusan Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya Nomor :</font><br>";
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
				echo "<font style='font-size:13px'><u>Rute yang ditetapkan dalam Wilayah Kota Tasikmalaya sbb :</u></font>";
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
		$br7  = 'Sehubungan dengan hal tersebut proses penelitian berkas telah sesuai dengan ketentuan yang berlaku sehingga dapat diterbitkan naskah perizinan untuk ditandatangani Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya';
		$br9  = 'Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut :';
		$br10 = 'Tasikmalaya, '.$this->lib_date->mysql_to_human(date('Y-m-d'));
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

  public function cek_data_notif($user_id = NULL) {
    $tgl_now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($tgl_now, -10);
    $query = "SELECT A.id FROM tmpermohonan as A
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
              AND L.user_id = '".$user_id."'"."
              AND DATE(N.tg_kyKaPTSP) between '$tgl_before' and '$tgl_now' AND A.approve = 2 order by A.id DESC";
    $results = mysql_query($query);
    $a=0;
    while ($rows = mysql_fetch_assoc(@$results)){
      $statnotif = $this->lib_date->statNotif($rows['id']);
      if (!$statnotif) {
        $id = $rows['id'];
        $a++;
      }
    }
    return $a;
  }

}
