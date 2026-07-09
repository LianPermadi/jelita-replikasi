<?php

/* To change this template, choose Tools | Templates and open the template in the editor. */

/**
 * Description of penjadwalan @author Eva
 * @edit PBS 25-06-2015
 */

class Penetapan extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
		$this->settings = new settings();
    $this->sk = new tmpermohonan();
    $this->bap = new tmbap();
    $this->propertyizin = new tmproperty_jenisperizinan();
    $this->koefisien = new trkoefesientarifretribusi();
    $this->perizinan = new trperizinan();
    $this->pemohon = new tmpemohon();
		$this->pegawai = new tmpegawai();
		$this->load->model('dbmodel_akdp');
		$this->load->library('fpdf');
    $this->awal_notolak ='503/';
		$this->akhir_notolak ='/PelPer';
        
		$this->file_upload = 'nUpload';
		/* Untuk Upload */
		$this->load->helper(array("html","form","url","text"));
		/* EOF() Untuk Upload */

    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->retribusi = NULL;
		$this->All = FALSE;
		$this->Admin = FALSE;
		$r_tetap = 0;
		$r_nomor = 0;
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '13') {    // Penetapan
				$r_tetap = 1;
        $enabled = TRUE;
        $this->retribusi = new user_auth();
      }
			if($list_auth->id_role === '19') {    // Penomoran
				$r_nomor = 1;
        $enabled = TRUE;
        $this->retribusi = new user_auth();
      }
			if ($list_auth->id_role === '18') {   // Administrator
                $this->All = TRUE;
				$this->Admin = TRUE;
      }
			if($list_auth->id_role === '20') {    // Mencetak
        $enabled = TRUE;
      }
    }

    $this->stat_role = '';
		$this->kd_role = '0';
    if($r_tetap == 1 && $r_nomor == 1) {$this->kd_role = '3'; $this->stat_role = 'Data Penetapan dan Penomoran Izin';} // penetapan dan penomoran
		if($r_tetap == 1 && $r_nomor == 0) {$this->kd_role = '2'; $this->stat_role = 'Data Penetapan Izin';}               // penetapan
		if($r_tetap == 0 && $r_nomor == 1) {$this->kd_role = '1'; $this->stat_role = 'Data Penomoran Izin';}               // penomoran
        
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {  // pertama masuk saat click menu Penetapan Permohonan
	  $sts_pil = $this->input->post('sts_pil');
		if($sts_pil == '') $sts_pil = 1;
	  $kd_filter = $this->input->post('kd_filter');
		$no_daftar = $this->input->post('kt_cari');
	  $lokasi_user = $this->session->userdata('lokasi');
    $user = new user();
		$user_user_auth = new user_user_auth();
    $stat = "19";                              // lihat tabel user_auth untuk Penomoran
		$kd_auth = FALSE;
    $user->where('username', $this->session->userdata('username'))->get();
		$user_user_auth->where('user_id', $user->id)->where('user_auth_id', $stat)->get();
		$pegawai = $this->pegawai;
		$pegawai = $user->$pegawai->get();
		
		if($user_user_auth->user_auth_id === $stat) {
		   $kd_auth = TRUE;
		}
        
		$data['kd_auth'] = $this->kd_role;
		$data['kt_cari'] = $no_daftar;
		$data['admin'] = $this->Admin;
		if($kd_filter == ''){
      $tgla = $user->gvar1;
      $tglb = $user->gvar2;
		}else{
			if($kd_filter == '1'){
        $tgla = '';
        $tglb = '';
			}else{
				$tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
			}
    }
        
		$now = $this->lib_date->get_date_now();
		$tgl_before = $this->lib_date->set_date($now, -7);
    $tgl_now = $this->lib_date->set_date($now, 0);
    if(!$tgla && !$tglb){
      $tgla = $tgl_before;
      $tglb = $tgl_now;
    }

		$data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
		if($kd_filter != ''){
	    $this->lib_date->post_variable($user->id, $tgla, $tglb, '', '', '', '', '', '', '', '');          // post variable
			if($kd_filter == '1'){
        $query_filter = " AND A.pendaftaran_id LIKE '%".$no_daftar."%' ";
				$data['tgla'] = '0000-00-00';
        $data['tglb'] = '0000-00-00';
		  }else{
				if($sts_pil == 2) { // berdasarkan Tanggal Upload
          $query_filter = " AND L.tgl_penetapan between '$tgla' and '$tglb' ";
				}else{
					$query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
				}
		  }
		}else{
			if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query_filter = " AND L.tgl_penetapan between '$tgla' and '$tglb' ";
			}else{
        $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";			
      }
		}
		
    if($this->kd_role == '1') {  // untuk status penomoran
	    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.kd_status, A.status_berkas,
                A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, A.approve, C.id idizin, C.n_perizinan, C.e_ttd,
	    				  C.e_sertifikat, C.indeks, E.n_pemohon, G.id idjenis, G.n_permohonan
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id ";
			if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query .= "INNER JOIN tmpermohonan_tmsk as K ON K.tmpermohonan_id = A.id
                   INNER JOIN tmsk as L ON K.tmsk_id = L.id ";
			}
	    if($this->All){
				$query .= "WHERE A.status_berkas = 'Izin Disetujui'".$query_filter.
	  				      "order by A.id DESC";
			}else{
        if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	   		//if($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
		      $query .= "INNER JOIN trperizinan_user AS H ON H.trperizinan_id = C.id
                     WHERE A.status_berkas = 'Izin Disetujui'
                     AND H.user_id = '".$user->id."'".$query_filter.
					           "order by A.id DESC";
		    }else{
          $query .= "INNER JOIN trperizinan_user AS H ON H.trperizinan_id = C.id
                     WHERE A.status_berkas = 'Izin Disetujui'
                     AND H.user_id = '".$user->id."'".$query_filter.
					           "AND A.kd_gerai =  '$lokasi_user'
                     order by A.id DESC";
				}
			}
	  }
        
		if($this->kd_role == '2') {  // untuk status penetapan
		  $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.kd_status, A.status_berkas,
                A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, A.approve, C.id idizin, C.n_perizinan, C.e_ttd,
			    		  C.e_sertifikat, C.indeks, E.n_pemohon, G.id idjenis, G.n_permohonan, 
                I.c_penetapan, I.status_bap, I.bap_id, I.c_pesan, I.id id_bap
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id ";
			if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query .= "INNER JOIN tmpermohonan_tmsk as K ON K.tmpermohonan_id = A.id
                   INNER JOIN tmsk as L ON K.tmsk_id = L.id ";
			}
		  if($this->All){
				$query .= "WHERE A.c_pendaftaran = 1
                   AND A.c_izin_dicabut = 0
                   AND A.c_izin_selesai = 0".$query_filter."order by A.id DESC";
			}else{
    		if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	    	//if($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
          $query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                     WHERE A.c_pendaftaran = 1
                     AND A.c_izin_dicabut = 0
                     AND A.c_izin_selesai = 0
                     AND J.user_id = '".$user->id."'".$query_filter."order by A.id DESC";
			  }else{
    		  $query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                     WHERE A.c_pendaftaran = 1
                     AND A.c_izin_dicabut = 0
                     AND A.c_izin_selesai = 0
                     AND J.user_id = '".$user->id."'".$query_filter."AND A.kd_gerai =  '$lokasi_user' order by A.id DESC";
				}  
			}
		}
			
		if($this->kd_role == '3') {  // untuk status penetapan dan penomoran
		  $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.kd_status, A.status_berkas,
                A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, A.approve, C.id idizin, C.n_perizinan, C.e_ttd,
			    		  C.e_sertifikat, C.indeks, E.n_pemohon, G.id idjenis, G.n_permohonan, 
                I.c_penetapan, I.status_bap, I.bap_id, I.c_pesan, I.id id_bap
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id ";
			if($sts_pil == 2) { // berdasarkan Tanggal Upload
        $query .= "INNER JOIN tmpermohonan_tmsk as K ON K.tmpermohonan_id = A.id
                   INNER JOIN tmsk as L ON K.tmsk_id = L.id ";
			}
		  if($this->All){
				$query .= "WHERE A.c_pendaftaran = 1
                   AND A.c_izin_dicabut = 0".$query_filter."order by A.id DESC";
			}else{
    		if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	    	//if($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
          $query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                     WHERE A.c_pendaftaran = 1
                     AND A.c_izin_dicabut = 0
                     AND J.user_id = '".$user->id."'".$query_filter."order by A.id DESC";
     		}else{
	    		$query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                     WHERE A.c_pendaftaran = 1
                     AND A.c_izin_dicabut = 0
                     AND J.user_id = '".$user->id."'".$query_filter."AND A.kd_gerai =  '$lokasi_user' order by A.id DESC";
				}
			}
    }
        
		$data['list'] = $query;
    $data['jenis_izin'] = "";
    $data['jenis_permohonan'] = "";
    $data['namapemohon'] = "";
    $data['tanggalpermohonan'] = "";
    $data['save_method'] = "save";
    $data['id'] = "";
		$data['awal_notolak'] = $this->awal_notolak;
		$data['akhir_notolak'] = $this->akhir_notolak;
		$data['eselon'] = $pegawai->eselon;
		if($sts_pil == 1) { // berdasarkan Tanggal Permohonan
    	$data['cek1'] = TRUE;
      $data['cek2'] = FALSE;
		}else{              // berdasarkan Tanggal Upload
      $data['cek1'] = FALSE;
			$data['cek2'] = TRUE;
		}

    $this->load->vars($data);

    $js = "
           $(document).ready(function() {
             oTable = $('#sk').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"});
           } );

				   $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
					          $('a[rel*=upload_box]').facebox();
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
    $this->session_info['page_name'] = $this->stat_role;
    $this->template->build('penetapan_list', $this->session_info);
  }

    /*
    public function index_next() {  // masuk berikutnya
	    $kd_filter = $this->input->post('kd_filter');
        if($kd_filter = '1'){
			$no_daftar = $this->input->post('kt_cari');
            $query_filter = "AND A.pendaftaran_id = '$no_daftar'";
		}else{
            $query_filter = "AND A.d_terima_berkas between '$tgla' and '$tglb'";
		}
		
		$lokasi_user = $this->session->userdata('lokasi');
        $user = new user();
		$user_user_auth = new user_user_auth();
        $stat = "19";                              // lihat tabel user_auth untuk Penomoran
		$kd_auth = FALSE;
        $user->where('username', $this->session->userdata('username'))->get();
		$user_user_auth->where('user_id', $user->id)->where('user_auth_id', $stat)->get();
		if($user_user_auth->user_auth_id === $stat) {
		   $kd_auth = TRUE;
		}
        
		$tgla = $user->gvar1;
        $tglb = $user->gvar2;
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
    //  $data['kd_auth'] = $kd_auth;
		$data['kd_auth'] = $this->kd_role;
		$data['kt_cari'] = '';
		$data['admin'] = $this->Admin;

        if($this->kd_role == '1') {  // untuk status penomoran
		    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.status_berkas,
                      A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, C.id idizin, C.n_perizinan, E.n_pemohon, G.id idjenis, G.n_permohonan
                      FROM tmpermohonan as A
                      INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                      INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                      INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                      INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                      INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                      INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id ";
		    if($this->All){
				    $query .= "WHERE A.status_berkas = 'Izin Disetujui'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               order by A.id DESC";
			}else{
    		    if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	    		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
		            $query .= "INNER JOIN trperizinan_user AS H ON H.trperizinan_id = C.id
                               WHERE A.status_berkas = 'Izin Disetujui'
                               AND H.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               order by A.id DESC";
		    	} else {
                    $query .= "INNER JOIN trperizinan_user AS H ON H.trperizinan_id = C.id
                               WHERE A.status_berkas = 'Izin Disetujui'
                               AND H.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               AND A.kd_gerai =  '$lokasi_user'
                               order by A.id DESC";
				}
			}
	    }
        
		if($this->kd_role == '2') {  // untuk status penetapan
		    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.status_berkas,
                      A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, C.id idizin, C.n_perizinan, E.n_pemohon, G.id idjenis, G.n_permohonan, 
                      I.c_penetapan, I.status_bap, I.bap_id, I.c_pesan, I.id id_bap
                      FROM tmpermohonan as A
                      INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                      INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                      INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                      INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                      INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                      INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                      INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                      INNER JOIN tmbap I ON H.tmbap_id = I.id ";
		    if($this->All){
				$query .= "WHERE A.c_pendaftaran = 1
                           AND A.c_izin_dicabut = 0
                           AND A.c_izin_selesai = 0
                           AND A.d_terima_berkas between '$tgla' and '$tglb'
                           order by A.id DESC";
			} else {
    		    if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	    		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
                    $query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                               WHERE A.c_pendaftaran = 1
                               AND A.c_izin_dicabut = 0
                               AND A.c_izin_selesai = 0
                               AND J.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               order by A.id DESC";
			    } else {
    				$query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                               WHERE A.c_pendaftaran = 1
                               AND A.c_izin_dicabut = 0
                               AND A.c_izin_selesai = 0
                               AND J.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb' 
                               AND A.kd_gerai =  '$lokasi_user'
                               order by A.id DESC";
				}
			}
		}
			
		if($this->kd_role == '3') {  // untuk status penetapan dan penomoran
		    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.status_berkas,
                      A.keterangan, A.a_izin, A.c_izin_selesai, A.c_tinjauan, A.kd_status, A.back_proses, C.id idizin, C.n_perizinan, E.n_pemohon, G.id idjenis, G.n_permohonan, 
                      I.c_penetapan, I.status_bap, I.bap_id, I.c_pesan, I.id id_bap
                      FROM tmpermohonan as A
                      INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                      INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                      INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                      INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                      INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                      INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                      INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                      INNER JOIN tmbap I ON H.tmbap_id = I.id ";
		    if($this->All){
				$query .= "WHERE A.c_pendaftaran = 1
                           AND A.c_izin_dicabut = 0
                           AND A.d_terima_berkas between '$tgla' and '$tglb'
                           order by A.id DESC";
			} else {
    		    if ($lokasi_user === 'Pusat') { // Untuk daerah lain
	    		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
                    $query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                               WHERE A.c_pendaftaran = 1
                               AND A.c_izin_dicabut = 0
                               AND J.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               order by A.id DESC";
     			} else {
	    			$query .= "INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                               WHERE A.c_pendaftaran = 1
                               AND A.c_izin_dicabut = 0
                               AND J.user_id = '".$user->id."'
                               AND A.d_terima_berkas between '$tgla' and '$tglb'
                               AND A.kd_gerai =  '$lokasi_user'
                               order by A.id DESC";
				}
			}
        }

        $data['list'] = $query;
        
        $data['jenis_izin'] = "";
        $data['jenis_permohonan'] = "";
        $data['namapemohon'] = "";
        $data['tanggalpermohonan'] = "";
        $data['save_method'] = "save";
        $data['id'] = "";
		$data['awal_notolak'] = $this->awal_notolak;
		$data['akhir_notolak'] = $this->akhir_notolak;

        $this->load->vars($data);

        $js = "
                $(document).ready(function() {
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
        $this->session_info['page_name'] = $this->stat_role;
        $this->template->build('penetapan_list', $this->session_info);
    }
    */

  public function viewSK($id=NULL, $idizin=NULL) { // Untuk yang belum ditetapkan / Proses Penetapan Izin
  	//Status Approve stop approve esl2
    $this->settings->where('name', 'stop_esl2')->get();
    $data['stat_stop_esl2'] = $this->settings->status;
    
    $permohonan = new tmpermohonan();
    $perizinan = new trperizinan();
    $property = new trproperty();
    $jenisproperty = new tmproperty_jenisperizinan();
    $koefesientarifretribusi = new trkoefesientarifretribusi();
    $bap = new tmbap();
    $retribusi = new trretribusi();

    $permohonan->where('id', $id)->get();
    $permohonan->trperizinan->get();
    $permohonan->tmpemohon->get();
    $permohonan->tmperusahaan->get();
    $bap = $permohonan->tmbap->get();
    $p_pemohon = $permohonan->tmpemohon->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_kelurahan->trkecamatan->get();
    $p_kabupaten = $p_kecamatan->trkabupaten->get();
    $p_prov = $p_kabupaten->trpropinsi->get();

    $permohonan->$perizinan->where('id', $idizin)->get();
    $permohonan->$perizinan->$retribusi->get();//where('perizinan_id', $idizin)->get();

    $k_property = $permohonan->$perizinan->$property->$jenisproperty->k_property;
    $koefesientarifretribusi->where('id', $k_property)->get();
    
    $indeks = $permohonan->trperizinan->indeks;
    $data_urut = $permohonan->trperizinan->no_sk_tengah;
		$ttd_elektonik = $permohonan->trperizinan->e_ttd;
		switch($ttd_elektonik){
			case 0 : $metode = ' dengan Metode Tandatangan Manual'; break;
			case 1 : $metode = ' dengan Metode Tandatangan Elektronik'; break;
			case 2 : $metode = ' dengan Metode Upload Dokumen'; break;
		}
		$sk_awal = ''; 
		$sk_akhir = '';
		$tg_sk = '';   
		$tg_kp = '';
		if($indeks == 'AKDP'){
		  //if($permohonan->trperizinan->id == 89 || $permohonan->trperizinan->id == 91 || $permohonan->trperizinan->id == 92){
		  //	if($permohonan->trperizinan->id == 89 || $permohonan->trperizinan->id == 92){//sk/kp dan perubahan
		  //    $no_kend =  $this->lib_date->isi_property($id, 1, 5); 
		  //    $no_uji =  $this->lib_date->isi_property($id, 9, 5);
		 // 	}else{ // kp
		  //    $no_kend =  $this->lib_date->isi_property($id, 9, 5);
		  //    $no_uji =  $this->lib_date->isi_property($id, 11, 5);
		  //	}
			//$dt_kendaraan = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kend = '".$no_kend."' AND no_uji = '".$no_uji."'");
			//$jm_kendaraan = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend = '".$no_kend."' AND no_uji = '".$no_uji."'");
			//foreach ($dt_kendaraan as $datak) {
      //  $sk_awal = $datak->no_sk;      // nomor SK
      //  $sk_akhir = $datak->no_kp;     // nomor KP
			//	$tg_sk = $datak->tgl_sk;       // tanggal SK
			//	$tg_kp = $datak->tgl_kp_awal;  // tanggal KP
			//}
			$akdp_cetak = new akdp_cetak();
	    $akdp_cetak->where('pendaftaran_id', $permohonan->pendaftaran_id)->get();
	    $sk_awal  = $akdp_cetak->no_sk;        // nomor SK
      $sk_akhir = $akdp_cetak->no_kp;        // nomor KP
			$tg_sk    = $akdp_cetak->tgl_sk;       // tanggal SK
			$tg_kp    = $akdp_cetak->tgl_kp_awal;  // tanggal KP
		}else{
      $sk_awal = $permohonan->trperizinan->no_sk_awal;
	    $sk_akhir = $permohonan->trperizinan->no_sk_akhir;
			// menyisipkan kode bulan di no_sk_akhir
			$kd_bln = $this->lib_date->set_month_roman(date("n"));
			$npos = strpos($sk_awal,'kd_bln');
			if($npos)
   			$sk_awal = substr($sk_awal, 0, $npos) . $kd_bln . substr($sk_awal, $npos+6);
			$npos1 = strpos($sk_akhir,'kd_bln');
			if($npos1)
   			$sk_akhir = substr($sk_akhir, 0, $npos1) . $kd_bln . substr($sk_akhir, $npos1+6);
		}

    $data['list'] = $permohonan->$perizinan->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $data['list_daftar'] = $permohonan->tmproperty_jenisperizinan->get();

    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['id'] = $permohonan->id;
    $data['idpemohon'] = $permohonan->tmpemohon->id;
    $data['idjenis'] = $permohonan->trperizinan->id;
    $data['jenislayanan'] = $permohonan->trperizinan->n_perizinan;
		$data['e_ttd'] = $permohonan->trperizinan->e_ttd;
		$data['indeks'] = $indeks;
		$data['no_sk_awal'] = $sk_awal;
		$data['no_sk_tengah'] = $data_urut;
		$data['no_sk_akhir'] = $sk_akhir;
		$data['no_sk_tahun'] = 	date("Y");
    $data['akdp_tg_sk'] = $tg_sk;
		$data['akdp_tg_kp'] = $tg_kp;
    $data['nopendaftaran'] = $permohonan->pendaftaran_id;
    $data['namapemohon'] = $permohonan->tmpemohon->n_pemohon;
    $data['alamatpemohon'] = $p_pemohon->a_pemohon . ', ' . $p_kelurahan->n_kelurahan . ', ' . $p_kecamatan->n_kecamatan . ', ' .
                             $p_kabupaten->n_kabupaten . ', ' . $p_prov->n_propinsi;
    $data['namaperusahaan'] = $permohonan->tmperusahaan->n_perusahaan;
    $data['m_hitung'] = $permohonan->trperizinan->$retribusi->m_perhitungan;
    $data['hitManualRet'] = $this->sqlRet($permohonan->pendaftaran_id);

    $data['tglperiksa'] = $permohonan->d_survey;
    $data['id_bap'] = $bap->id;
    $data['nosk'] = $bap->bap_id;
    $data['pesan'] = $bap->c_pesan;
    $data['status'] = $bap->status_bap;
    $data['ditetapkan'] = $bap->c_penetapan;

		$data['id_daftar'] = $permohonan->id;
    $data['id_izin'] = $permohonan->trperizinan->id;
		$data['status_berkas'] = $permohonan->status_berkas;
    $data['alenia1'] = 'Menindaklanjuti Surat Permohonan '.$permohonan->trperizinan->n_perizinan.', nomor pendaftaran '.$permohonan->pendaftaran_id.
  			               ' tanggal '.$this->lib_date->mysql_to_human($permohonan->d_terima_berkas).', bersama ini kami sampaikan hal-hal sebagai berikut: ';
    $data['retribusi'] = $bap->nilai_retribusi;
    //$data['retribusi'] = $permohonan->trperizinan->$retribusi->v_retribusi;

    //cek data
    $index = $koefesientarifretribusi->index_kategori;
    //$data['retribusi'] = $permohonan->$perizinan->$retribusi->v_retribusi;

    $data['indexcba'] = $index;
    $data['xx'] = $idizin;
    $data['yy'] = $k_property;

    $js_date = "
                $(function() {
                  $(\"#bap\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                  });
                });
			
			          $(document).ready(function() {
                  $('#form').validate();
                  $(\"#tabs\").tabs();
					        $('a[rel*=upload_box]').facebox();
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
    $this->template->set_metadata_javascript($js_date);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Penetapan Izin "; // .$jm_kendaraan.' | '.$no_kend.' | '.$no_uji;
    $this->template->build('penetapan_edit', $this->session_info);
  }

  public function viewSK2($id=NULL, $idizin=NULL) {  // Edit alasana penolakan Untuk yang di tolak 
    $permohonan = new tmpermohonan();
    $perizinan = new trperizinan();
    $property = new trproperty();
    $jenisproperty = new tmproperty_jenisperizinan();
    $koefesientarifretribusi = new trkoefesientarifretribusi();
    $bap = new tmbap();
    $retribusi = new trretribusi();

    $permohonan->where('id', $id)->get();

    $permohonan->trperizinan->get();
    $permohonan->tmpemohon->get();
    $permohonan->tmperusahaan->get();
    $bap = $permohonan->tmbap->get();

    $permohonan->$perizinan->where('id', $idizin)->get();
    $permohonan->$perizinan->$retribusi->get();//where('perizinan_id', $idizin)->get();

    $k_property = $permohonan->$perizinan->$property->$jenisproperty->k_property;
    $koefesientarifretribusi->where('id', $k_property)->get();

    $data['list'] = $permohonan->$perizinan->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $data['list_daftar'] = $permohonan->tmproperty_jenisperizinan->get();
    $data['list_klasifikasi'] = $permohonan->tmproperty_klasifikasi->get();
    $data['list_prasarana'] = $permohonan->tmproperty_prasarana->get();

    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['id'] = $permohonan->id;
    $data['idpemohon'] = $permohonan->tmpemohon->id;
    $data['idjenis'] = $permohonan->trperizinan->id;
    $data['jenislayanan'] = $permohonan->trperizinan->n_perizinan;
		$data['e_ttd'] = $permohonan->trperizinan->e_ttd;
		$data['no_sk_awal'] = $permohonan->trperizinan->no_sk_awal;
		$data['no_sk_tengah'] = $permohonan->trperizinan->no_sk_tengah;
		$data['no_sk_akhir'] = $permohonan->trperizinan->no_sk_akhir;
    $data['nopendaftaran'] = $permohonan->pendaftaran_id;
    $data['namapemohon'] = $permohonan->tmpemohon->n_pemohon;
    $data['alamatpemohon'] = $permohonan->tmpemohon->a_pemohon;
    $data['namaperusahaan'] = $permohonan->tmperusahaan->n_perusahaan;

    $data['tglperiksa'] = $permohonan->d_survey;
    $data['id_bap'] = $bap->id;
    $data['nosk'] = $bap->bap_id;
    $data['pesan'] = $bap->c_pesan;
    $data['status'] = $bap->status_bap;
    $data['ditetapkan'] = $bap->c_penetapan;
    $data['m_hitung'] = $permohonan->trperizinan->$retribusi->m_perhitungan;
    $data['hitManualRet'] = $this->sqlRet($permohonan->pendaftaran_id);

		$data['id_daftar'] = $permohonan->id;
    $data['id_izin'] = $permohonan->trperizinan->id;
		$data['alenia1'] = 'Menindaklanjuti Surat Permohonan '.$permohonan->trperizinan->n_perizinan.', nomor pendaftaran '.$permohonan->pendaftaran_id.
  			               ' tanggal '.$this->lib_date->mysql_to_human($permohonan->d_terima_berkas).', bersama ini kami sampaikan hal-hal sebagai berikut: ';
  
    $index = $koefesientarifretribusi->index_kategori;
    $data['retribusi'] = $permohonan->$perizinan->$retribusi->v_retribusi;
        
    $data['indexcba'] = $index;
    $data['xx'] = $idizin;
    $data['yy'] = $k_property;
  
    $js_date = "
                $(function() {
                  $(\"#bap\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                  });
                });
               ";
    $this->template->set_metadata_javascript($js_date);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Lihat Detail Penetapan Izin";
    $this->template->build('penetapan_edit2', $this->session_info);
  }

  public function penomoran($id=NULL, $idizin=NULL, $ambil_nomor = NULL, $cek_auto = NULL) { 
		$user = new user();
		$user->where('username', $this->session->userdata('username'))->get();
		$user_group = $user->group; //$cek_auto;

    $permohonan = new tmpermohonan();
    $perizinan = new trperizinan();
    $property = new trproperty();
    $jenisproperty = new tmproperty_jenisperizinan();
    $koefesientarifretribusi = new trkoefesientarifretribusi();
    $bap = new tmbap();
    $retribusi = new trretribusi();

    $permohonan->where('id', $id)->get();

    $permohonan->trperizinan->get();
    $permohonan->tmpemohon->get();
    $permohonan->tmperusahaan->get();
    $bap = $permohonan->tmbap->get();
		$sk = $permohonan->tmsk->get();
		$surat_kep = $permohonan->tmsurat_keputusan->get();
    $p_pemohon = $permohonan->tmpemohon->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_kelurahan->trkecamatan->get();
    $p_kabupaten = $p_kecamatan->trkabupaten->get();
    $p_prov = $p_kabupaten->trpropinsi->get();

    $permohonan->$perizinan->where('id', $idizin)->get();
    $permohonan->$perizinan->$retribusi->get();

    $k_property = $permohonan->$perizinan->$property->$jenisproperty->k_property;
    $koefesientarifretribusi->where('id', $k_property)->get();

    $data['list'] = $permohonan->$perizinan->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $data['list_daftar'] = $permohonan->tmproperty_jenisperizinan->get();

    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['id'] = $permohonan->id;
		$data['user_group'] = $user_group;
    $data['idpemohon'] = $permohonan->tmpemohon->id;
    $data['idjenis'] = $permohonan->trperizinan->id;
    $data['jenislayanan'] = $permohonan->trperizinan->n_perizinan;
    $data['nopendaftaran'] = $permohonan->pendaftaran_id;
		$data['noantri'] = $permohonan->no_antri;
		$data['tgl_permohonan'] = $permohonan->d_terima_berkas;
		$data['gerai'] = $permohonan->kd_gerai;
		$data['objekizin'] = $permohonan->a_izin;
    $data['namapemohon'] = $permohonan->tmpemohon->n_pemohon;
    $alamat = $p_pemohon->a_pemohon;
		if($p_kelurahan->n_kelurahan !== "-") $alamat = $alamat . ', ' . $p_kelurahan->n_kelurahan; 
		if($p_kecamatan->n_kecamatan !== "-") $alamat = $alamat . ', ' . $p_kecamatan->n_kecamatan; 
		if($p_kabupaten->n_kabupaten !== "-") $alamat = $alamat . ', ' . $p_kabupaten->n_kabupaten; 
		if($p_prov->n_propinsi !== "-") $alamat = $alamat . ', ' . $p_prov->n_propinsi;
    $data['alamatpemohon'] = $alamat;
    $data['namaperusahaan'] = $permohonan->tmperusahaan->n_perusahaan;
    $data['m_hitung'] = $permohonan->trperizinan->$retribusi->m_perhitungan;
    $data['hitManualRet'] = $this->sqlRet($permohonan->pendaftaran_id);

    $data['tglperiksa'] = $permohonan->d_survey;
    $data['id_bap'] = $bap->id;
    $data['nobap'] = $bap->bap_id;
    $data['tglbap'] = $bap->bap_id;
    $data['status'] = $bap->status_bap;
    $data['ditetapkan'] = $bap->c_penetapan;
    $data['retribusi'] = $bap->nilai_retribusi;
    $data['nosk'] = $sk->no_surat;
		$data['id_sk'] = $sk->id;
		$data['tgl_penetapan'] = $sk->tgl_penetapan;
    $data['id_surkep'] = $surat_kep->id;
		$data['ambil_nomor'] = $ambil_nomor;
    $sk_awal = $permohonan->trperizinan->no_sk_awal;
		$sk_akhir = $permohonan->trperizinan->no_sk_akhir;
    $kd_bln = $this->lib_date->set_month_roman(date("n"));
		$npos = strpos($sk_awal,'kd_bln');
		if($npos)
  		$sk_awal = substr($sk_awal, 0, $npos) . $kd_bln . substr($sk_awal, $npos+6);
		$npos1 = strpos($sk_akhir,'kd_bln');
		if($npos1)
   		$sk_akhir = substr($sk_akhir, 0, $npos1) . $kd_bln . substr($sk_akhir, $npos1+6);

    $no_sk_tengah = $bap->no_sk_lama;
    if ($no_sk_tengah == NULL) {
      $no_sk_tengah = $permohonan->trperizinan->no_sk_tengah;
    }
		
		$no_sk_berkas = $permohonan->trperizinan->no_sk_tengah;
		if($no_sk_tengah != 99999){
			if($ambil_nomor != 1){
			  $no_sk_tengah = '?????';
				$no_sk_berkas = '!!!!!';
	    }
		}

		$data['no_sk_awal'] = $sk_awal;
		$data['no_sk_tengah'] = $no_sk_tengah;
		$data['no_sk_akhir'] = $sk_akhir;
		$data['no_sk_tahun'] = date("Y");
		$data['c_in_nomor'] = $permohonan->trperizinan->cara_penomoran;
		$data['no_sk_berkas'] = $no_sk_berkas;

    if($sk->no_surat_edit == "") {
	    $data['noskedit'] = $sk->no_surat;
    }else{
			$data['noskedit'] = $sk->no_surat_edit;
		}
		$data['tglsk'] = $sk->tgl_surat;
		$data['i_urut'] = $sk->i_urut;      // no urut sk untuk ditampilkan setelah ambil nomor berkas ke sistem
		$data['tglterbit'] = date("Y-m-d");
		$data['tglsk'] = $sk->tgl_surat;
		$data['tglambil'] = $sk->tgl_ambil1;
		$data['kontak'] = $sk->kontak;

    //cek data
        
    $index = $koefesientarifretribusi->index_kategori;

    $data['indexcba'] = $index;
    $data['xx'] = $idizin;
    $data['yy'] = $k_property;

		$js_date = "
                $(document).ready(function() {
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
    $this->template->set_metadata_javascript($js_date);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Perubahan Nomor Izin ";
    $this->template->build('penomoran_edit', $this->session_info);
  }

  public function view($idjenisizin=NULL, $nopendaftaran=NULL, $idpemohon=NULL) {
    $permohonan = new tmpermohonan();
    $pemohon = new tmpemohon();

    $data['list'] = $permohonan->where('pendaftaran_id', $this->input->post('nomorpendaftaran'))->get();

    $data['idjenisizin'] = $idjenisizin;
    $data['nopendaftaran'] = $nopendaftaran;
    $data['idpemohon'] = $idpemohon;

    $this->load->vars($data);

    $js = "
           $(document).ready(function() {
             oTable = $('#sk').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           } );
          ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Penetapan Izin";
    $this->template->build('bap', $this->session_info);
  }

  public function edit() {
    $data['list'] = $this->sk->getPerizinan();
    $this->sk->where('id_pemohon', $id_pemohon);
    $this->sk->getPerizinan();
    $data['save_method'] = "save";
    $data['view'] = "index";
    $this->load->vars($data);
    $this->session_info['page_name'] = "Entry Pendataan";
    $this->template->build('bapbap', $this->session_info);
  }

  /**
   * Not yet in use, because of some limit of dataTables
  */
  public function datalist() {
    $this->sk->get();
    $this->sk->set_json_content_type();
    echo $this->sk->json_for_data_table();
  }

  /*
   * Save and update for manipulating data.
  */

  public function save_old() {
    $year = new coba();
		$year = $year->get_by_id('4273');
		echo $year->perusahaanpimpinan_id;
  }

	public function save($id = NULL) {  // Proses Penyimpanan Penetapan Izin
    $u_ser = $this->session->userdata('username');
	  $r_name = $this->lib_date->get_nama_ori($u_ser);
    $user = new user();
    $user->where('username', $u_ser)->get();
		$id_user = $user->id;
        
		if($id == NULL)
      $id_pemohon = $this->input->post('id');
		else
		$id_pemohon = $id;

    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_pemohon);
  	$kd_sektor = $permohonan->trsektor_id;
  	$back_proses = $permohonan->back_proses;
	  $perizinan = $permohonan->trperizinan->get();
    $id_izin = $perizinan->id;
    $nama_izin = $perizinan->n_perizinan;
  	$e_ttd = $perizinan->e_ttd;
  	$e_sertifikat = $perizinan->e_sertifikat;
	  $cek = $this->input->post('id_bap');
    $bap = new tmbap();
    $bap->get_by_id($cek);
    $status_bap = $this->input->post('status');
    $kelompok = $perizinan->trkelompok_perizinan->get();
    $no_pendaftaran = $permohonan->pendaftaran_id;
    $pemohon = $permohonan->tmpemohon->get();
    $tgl_skr = $this->lib_date->get_date_now();
	  $idjenis = $this->input->post('idjenis');
		if($idjenis == 89 || $idjenis == 91 || $idjenis == 92){
			$akdp = TRUE;
		}else{
			$akdp = FALSE;
		}
        
    if($bap->c_penetapan !== "1" && $id == NULL){   // jika belum ditetapkan != 1
      $tgl_awal = $this->input->post('waktu_awal');
      $bap->status_bap = $status_bap;

      $status_izin = $permohonan->trstspermohonan->get();
            
      $status_skr = "8";                       //Penetapan/Penyusunan/Pencetakan Naskah Perizinan [Lihat Tabel trstspermohonan()]  => Kominfo Old 7
      if($status_bap === "1") { 
				$id_status = "13";                     //Surat Diizinkan [Lihat Tabel trstspermohonan()]                                   => Kominfo Old 8
        $n_status = 'Izin Disetujui';
      }else{ 
				$id_status = "14";                     //Izin Ditolak [Lihat Tabel trstspermohonan()]                                      => Kominfo Old 7
				$n_status = 'Izin Ditolak';
        
        $alasan_penolakan = $_POST['alasan'];
        $id_permohonan = htmlspecialchars($_POST['id'],ENT_QUOTES);
        foreach($alasan_penolakan as $alasan){
          $data = array('id_permohonan' => $id_permohonan,
                        'alasan' => htmlspecialchars($alasan,ENT_QUOTES)
                       );
          $this->db->Insert('alasan_penolakan', $data);
        }
			}

			if($status_izin->id == $status_skr || $bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
        /* Input Data Tracking Progress */
		    if($bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
  				$tracking_izin = new tmtrackingperizinan();
          $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                        ->where('tr_activiti', 'Pertimbangan Teknis')->get();
	        if($tracking_izin->pendaftaran_id){
            $tracking_izin->tr_activiti = 'Penyusunan Berkas';
						$tracking_izin->status = 'Update';
						$tracking_izin->tr_name = $r_name;
            $tracking_izin->tr_user = $u_ser;
						$tracking_izin->d_entry = $this->lib_date->get_date_now();
						$hit_ubah = $tracking_izin->hit_ubah + 1;
   	        $his_ubah = $tracking_izin->his_ubah;
   	        $tracking_izin->hit_ubah = $hit_ubah;
		        $tracking_izin->his_ubah = $his_ubah.$n_status.'^'.$r_name.'^'.$this->lib_date->get_date_now().';';
		        $tracking_izin->save();
          }
				}else{    // belum dicek per tgl 12-Juni-2014
          //$sts_izin = new trstspermohonan();
          //$sts_izin->get_by_id($status_skr);
          //$data_status = new tmtrackingperizinan_trstspermohonan();
          //$list_tracking = $permohonan->tmtrackingperizinan->get();
          //if($list_tracking){
          //    $tracking_id = 0;
          //    foreach ($list_tracking as $data_track){
          //        $data_status = new tmtrackingperizinan_trstspermohonan();
          //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
          //                    ->where('trstspermohonan_id', $sts_izin->id)->get();
          //        if($data_status->tmtrackingperizinan_id){
          //            $tracking_id = $data_status->tmtrackingperizinan_id;
          //        }
          //    }
          //}
          //$tracking_izin = new tmtrackingperizinan();
          //$tracking_izin->get_by_id($tracking_id);
          //         //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
          //$tracking_izin->status = 'Update';
          //$tracking_izin->d_entry = $this->lib_date->get_date_now();
          //$tracking_izin->save();
        }

				/* [Lihat Tabel trstspermohonan()] */
				// Memesan tempat untuk penyerahan izin
				$tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Penyerahan Izin')->get();
		    if(!$tracking_izin2->pendaftaran_id){
          $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
          $tracking_izin2->status = 'Insert';
	    		$tracking_izin2->tr_activiti = 'Penyerahan Izin';
          $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
          $tracking_izin2->d_entry = $this->lib_date->get_date_now();
          $sts_izin2 = new trstspermohonan();
          //$sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()] => old kominfo
   				$sts_izin2->get_by_id($status_skr); //[Lihat Tabel trstspermohonan()]   => edit PBS
          $sts_izin2->save($permohonan);
          $tracking_izin2->save($permohonan);
          $tracking_izin2->save($sts_izin2);
				}
                
				$tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Arsip')->get();
		    if(!$tracking_izin2->pendaftaran_id){
          $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
          $tracking_izin2->status = 'Insert';
		   		$tracking_izin2->tr_activiti = 'Arsip';
          $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
          $tracking_izin2->d_entry = $this->lib_date->get_date_now();
          $sts_izin2 = new trstspermohonan();
   				$sts_izin2->get_by_id('16'); //[Lihat Tabel trstspermohonan()]   => edit PBS
          $sts_izin2->save($permohonan);
          $tracking_izin2->save($permohonan);
          $tracking_izin2->save($sts_izin2);
				}
				
        $petugas = 1; //1 -> Jabatan Penandatangan
        $tgl_skr = $this->lib_date->get_date_now();
        $data_tahun = date("Y");
        if($id_status == "13"){              //Surat Diizinkan [Lihat Tabel trstspermohonan()] => Kominfo Old 8
			    $diizinkan = TRUE;
          /* Input Data */
          $data_id = new tmsk();
          $data_id->select_max('id')->get();
          $data_id->get_by_id($data_id->id);

          //Per Tahun Auto Restart NoUrut
					$data_urut = $this->input->post('no_sk_tengah');
          //PBS if($permohonan->d_tahun === $data_tahun)
          //PBS   $data_urut = $data_id->i_urut + 1;
          //PBS else 
          //PBS		$data_urut = 1;

          //Memberi angka 0 di depan nomor urut
          //PBS $i_urut = strlen($data_urut);
          //PBS for($i=4;$i>$i_urut;$i--){
          //PBS   $data_urut = "0".$data_urut;
          //PBS }

          //PBS $data_izin = $perizinan->id;
          //PBS $i_izin = strlen($data_izin);
          //PBS for($i=3;$i>$i_izin;$i--){
          //PBS   $data_izin = "0".$data_izin;
          //PBS }

          //PBS $data_bulan = $this->lib_date->set_month_roman(date("n"));
          //PBS $data_sk = "DP";
          //PBS $no_surat = $data_urut."/".$data_sk."/".$data_izin."/".$data_bulan."/".$data_tahun;

          $tahun_sk = $this->input->post('no_sk_tahun');
          
          /* Update Data Nomor urut di tabel Perizinan */
					//if($tahun_sk === $data_tahun) {
					//	$izin_sektor = new  trperizinan();
          //  $izin_sektor->where('tmtrackingperizinan_id', $data_track->id)
          //              ->where('trstspermohonan_id', $sts_izin->id)->get();
    	    //  $izin_sektor->no_sk_tengah = $data_urut;
          //  $izin_sektor->save();

    	    //  $perizinan->no_sk_tengah = $data_urut;   // dalam penetapan penomoran jangan dilakukan 
          //  $perizinan->save();
				  //}
          if($akdp){
						if($idjenis == 89){ // sk/kp
						  $no_surat = $this->input->post('no_sk_awal');
							$tgl_surat = $this->input->post('akdp_tg_sk');
            }else{
						  if($idjenis == 91){ // kp
                $no_surat = $this->input->post('no_sk_akhir');
								$tgl_surat = $this->input->post('akdp_tg_kp');
							}else{
						    if($idjenis == 92){ //perubahan
                  $no_surat = $this->input->post('no_sk_awal');
									$tgl_surat = $this->input->post('akdp_tg_sk');
								}
							}
						}
						$tgl_skr = $tgl_surat;
					}else{
            $no_surat = $this->input->post('no_sk_awal').$data_urut.$this->input->post('no_sk_akhir').$tahun_sk;
						$tgl_surat = $this->input->post('tgl_terbit_sk');
					}
					if($no_surat == '') $no_surat = 'Belum Penomoran';
          $surat_sk = new tmsk();
          $surat_sk->c_status = 1;
          $surat_sk->i_urut = 0;                   //$data_urut;
          $surat_sk->no_surat = 'Belum Penomoran'; //$no_surat;
					$surat_sk->tgl_surat = '0000-00-00';     //$tgl_surat;
  				$surat_sk->tgl_penetapan = $tgl_surat;
				  $surat_sk->id_user_penetapan = $id_user;

          /* Input Relasi Tabel*/
          $pegawai = new tmpegawai();
          $pegawai->where('status', $petugas)->get();

          $permohonan->d_berlaku_izin = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+$perizinan->v_berlaku_tahun));
          $permohonan->nip_ttd = $pegawai->nip;
          $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
          $permohonan->d_berlaku_keputusan = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+1));
				  
  			  // PBS Create
          $permohonan->status_berkas = $n_status;
          if($e_sertifikat == 0){
				    $permohonan->approve = 1;       // posisi di approve pengolah ptsp
				  }
				  if($permohonan->kd_status < 6){ // ubah kd_status menjadi 6 (Penetapan, lihat status_berkas) untuk proses selanjutnya (Pencetakkan naskah izin)
            $permohonan->kd_status = 6;
				  }
	        // EOF PBS Create
            
          $permohonan->save();
          $surat_sk->save(array($permohonan, $pegawai));

          /* Input Data */
          $surat_keputusan = new tmsurat_keputusan();
          $surat_keputusan->c_status = 1;
          $surat_keputusan->i_urut = 0;                   //$data_urut;
          $surat_keputusan->no_surat = 'Belum Penomoran'; //$no_surat;
          $surat_keputusan->tgl_surat = '0000-00-00';     //$tgl_skr;
                    
          $perusahaan = $permohonan->tmperusahaan->get();
          $surat_keputusan->ket1 = "Pemohon";
          $surat_keputusan->nama1 = $pemohon->n_pemohon;
          $surat_keputusan->alamat1 = $pemohon->a_pemohon;
          $surat_keputusan->ket2 = "Perusahaan";
          $surat_keputusan->nama2 = $perusahaan->n_perusahaan;
          $surat_keputusan->alamat2 = $perusahaan->a_perusahaan;
          $surat_keputusan->content1 = $nama_izin.' ini berlaku sejak ditetapkan sampai dengan tanggal '.
                                                  $this->lib_date->mysql_to_human($this->lib_date->set_date($tgl_skr, 365)).
                                                  ' dan izin pembaharuan diajukan kepada Kepada Dinas Perijinan Kabupaten selambat-lambatnya 3 (tiga) bulan sebelum habis masa berlakunya keputusan ini.';
          $surat_keputusan->content2 = $nama_izin.' ini dapat dicabut untuk selama-lamanya bila pelaksanaannya tidak sesuai dengan ketentuan peraturan perundang-undangan yang berlaku;';
          $surat_keputusan->content3 = 'Keputusan ini berlaku sejak tanggal ditetapkan.';
          $surat_keputusan->save(array($permohonan, $pegawai));

          //Kirim SMS Izin sudah selesai
          if($kelompok->id == 2 || $kelompok->id == 4){
            $retribusi = $this->_get_ret($permohonan->id);
            $keringanan = $permohonan->tmkeringananretribusi->get();
            if($keringanan->id)
              $nilai_ret = ($keringanan->v_prosentase_retribusi * 0.01) * $retribusi;
            else
              $nilai_ret = $retribusi;
            if($nilai_ret)
              $nilair = $this->terbilang->nominal($nilai_ret, 2);
            else 
              $nilair = "0";

            $text = "Surat " . $nama_izin . " dgn no daftar " . $no_pendaftaran . " sdh selesai. Dgn biaya Rp. " . $nilair . ". Mohon segera diambil.";
          }else{
            $text = "Surat " . $nama_izin . " dgn no daftar " . $no_pendaftaran . " sdh selesai. Mohon segera diambil.";
          }
          if(strlen($text) > 160) {
            $text = NULL;
            if($kelompok->id == 2 || $kelompok->id == 4){
              $retribusi = $this->_get_ret($permohonan->id);
              if(empty($retribusi)) $retribusi = 0;
                $text = "Surat Anda dgn no daftar " . $no_pendaftaran . ". Dgn biaya Rp. " . $this->terbilang->nominal($retribusi, 2) . ". Mohon segera diambil.";
            }else{
              $text = "Surat Anda dgn no daftar " . $no_pendaftaran . ". Mohon segera diambil.";
            }
          }
					// penguncian Dokumen
					$tmky = new tmpermohonan_ky();
          $cektmky = $tmky->where('tmpermohonan_id', $id_pemohon)->get();
					if($cektmky->id){  //jika ditemukan
            //$tmky->where('tmpermohonan_id', $id_pemohon)
            //     ->update(array('kyStafPTSP' => ''),'tg_kyStafPTSP' => ''));
					}else{
					}
					// EOF() penguncian Dokumen
					
					// Membuat File naskah docx ke backoffice/assets/download
					if($e_ttd == 1)    // mode ttd Elektronik
            echo anchor(site_url('permohonan/sk/cetak_sk/'.$id_pemohon.'/1'.'/'.'permohonan/penetapan'), img($ambil_naskah));
          if($e_ttd == 2)    // mode Upload
		        echo anchor(site_url('permohonan/sk/cetak_sk/'.$id_pemohon.'/3'.'/'.'permohonan/penetapan'), img($ambil_naskah));
		      // EOF() Membuat File naskah  docx ke backoffice/assets/download
        }else{     // jika ijin di tolak
				  $diizinkan = FALSE;
					// PBS Create
        	$permohonan->status_berkas = $n_status;
					$permohonan->approve = 1;    // posisi di approve pengolah ptsp
					if($permohonan->kd_status < 6){ // ubah kd_status menjadi 6 (Penetapan, lihat status_berkas) untuk proses selanjutnya (Pencetakkan naskah izin)
				    $permohonan->kd_status = 6;
					}
          $permohonan->save();
					// EOF PBS Create
          $data_id = new tmsk();

          $data_id->select_max('id')->get();
          $data_id->get_by_id($data_id->id);

          //Per Tahun Auto Restart NoUrut
          if($permohonan->d_tahun == $data_tahun)
            $data_urut = $data_id->i_urut;
          else 
            $data_urut = 1;
                    
          $surat_sk = new tmsk();
          $surat_sk->i_urut = $data_urut;
          $surat_sk->no_surat = "Ditolak";
					$surat_sk->no_surat_edit = "";
          $surat_sk->c_status = 1;
          $surat_sk->tgl_surat = $tgl_skr;
					$surat_sk->tgl_surat_edit = "000-00-00";
					$surat_sk->tgl_penetapan = $this->lib_date->get_date_now();
					$surat_sk->id_user_penetapan = $id_user;

          /* Input Relasi Tabel*/
          $pegawai = new tmpegawai();
          $pegawai->where('status', $petugas)->get();
          $surat_sk->save(array($permohonan, $pegawai));

          //Kirim SMS Izin ditolak 160 Chr
          $text = "Permohonan dgn no. " . $no_pendaftaran ." Ditolak, Silahkan Hubungi DPMPTSP Prov tasikmalaya.";
  	      $this->settings->where('name', 'smsGateway')->get();
  	      if($this->settings->status == 1){
  	      	$no_tlp = $pemohon->telp_pemohon;
	          $gammu   = $this->load->database('gammu', TRUE);   // the TRUE paramater tells CI that you'd like to return the database object.
        	  $data = array('DestinationNumber'	=> $no_tlp,'TextDecoded' => $text);
  	        $gammu->insert('outbox',$data);
        	}

					// Hapus kunci Dokumen
					//$tmky = new tmpermohonan_ky();
          //$tmky->where('tmpermohonan_id', $id_pemohon)->get();
					// EOF() Hapus kunci Dokumen
        }
      }
      $bap->c_penetapan = 1;
    }else{ // jika telah ditetapkan = 1 untuk dikembalikan menjadi 0 karena kesalahan penetapan (hanya untuk admin)
      if($this->Admin) {
				if($back_proses == 'ReOpen'){
			    $permohonan->back_proses = '0';
				}else{
					$permohonan->back_proses = 'ReOpen';
				}
				$permohonan->save();
			}else{
      	$stat_back = $r_name.'; '.$this->lib_date->get_date_now();
				$status_berkas = $permohonan->status_berkas;  // 'proses', 'Izin Disetujui' atau 'Izin Ditolak'
		    $back_proses = $permohonan->back_proses;  // jika = 0 normal
				
				// hapus data di tmsk;
				$tmsk = $permohonan->tmsk->get();
				$no_sk_lama = $tmsk->i_urut;
				$tg_sk_lama = $tmsk->tgl_surat;
        $relasi_tmsk = new tmpermohonan_tmsk();
        $relasi_tmsk->where('tmpermohonan_id', $id_pemohon);
        $relasi_tmsk->delete();
        $tmsk->delete();
            
        if($status_berkas == 'Izin Disetujui') {// 'proses', 'Izin Disetujui' atau 'Izin Ditolak'
			    // hapus data di tmsurat_keputusan;
				  $tmsurat_keputusan = $permohonan->tmsurat_keputusan->get();
          $relasi_tmsurat_keputusan = new tmsurat_keputusan();
          $relasi_tmsurat_keputusan->where('tmpermohonan_id', $id_pemohon);
          $relasi_tmsurat_keputusan->delete();
          $tmsurat_keputusan->delete();
				}
				$permohonan->kd_status = 5;
				$permohonan->approve = 1;    // posisi di approve pengolah ptsp // 7 posisi akhir approve kabid PD
				$permohonan->status_berkas = 'proses';
				$permohonan->back_proses = $stat_back;
        $permohonan->save();
            
        $xbap = $permohonan->tmbap->get();
				$xbap->status_bap = 0;
			  $xbap->c_penetapan = 0;
			  $xbap->no_sk_lama = $no_sk_lama;
			  $xbap->tg_sk_lama = $tg_sk_lama;
				$xbap->save();
			}
    }

    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql($u_ser);
    //$p = $this->db->query("call log ('Penetapan Izin','Penetapan izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

    if($id == NULL)
			$update = $bap->save();
		
		//BKPM Integrasi 
		//if($kd_sektor == 12){ // khusus izin bidang bkpm
		//    $this->load->library('SendData');
		//    if($bap->status_bap==1){				
		//    	$this->senddata->SendData($this->input->post('id'),"2");
	  //}
    //	else if ($bap->status_bap==2){				
		//	    $this->senddata->SendData($this->input->post('id'),"3");
		//    }
		//}
		//BKPM Integrasi 
		
    //if (!$update) {
    //    echo '<p>' . $update->error->string . '</p>';
    //} else {
		//redirect('permohonan/penetapan/index');  // OLD index_next

    require_once 'assets/phpword/src/PhpWord/Autoloader.php';
    $target_dir = "assets/naskah_izin/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        // die;
        $uploadOk = 0;
      }
    }
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    }else{
    }
		
		$e_menu = 0;
		if($e_ttd == 1) $e_menu = 1; // Elektronik
    if($e_ttd == 2) $e_menu = 3; // Upload
		if($diizinkan)
			if($e_menu == 0)
		    redirect('permohonan/penetapan');
		  else
        redirect('permohonan/sk/cetak_sk/'.$id_pemohon.'/'.$e_menu.'/'.'permohonan/penetapan');   // membuat file docx
    else
      redirect('permohonan/penetapan');
  }

  public function auto_save($id_pemohon = NULL) {  // Proses Penyimpanan Penetapan Izin AKDP Auto
    $u_ser = 'ADMIN';
    $r_name = 'AUTO SISTEM';
    $user = new user();
    $user->where('username', $u_ser)->get();
    $id_user = $user->id;
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_pemohon);
    $perizinan = $permohonan->trperizinan->get();
    $e_sertifikat = $perizinan->e_sertifikat;
    $cek = $permohonan->tmbap->get()->id;
    $bap = new tmbap();
    $bap->get_by_id($cek);
    $kelompok = $perizinan->trkelompok_perizinan->get();
    $no_pendaftaran = $permohonan->pendaftaran_id;
    $pemohon = $permohonan->tmpemohon->get();
    $tgl_skr = $this->lib_date->get_date_now();
    $idjenis = $perizinan->id;
    if($bap->c_penetapan !== "1"){   // jika belum ditetapkan != 1
    	$akdp_cetak = new akdp_cetak();
      $akdp_cetak->where('pendaftaran_id', $no_pendaftaran)->get();
      $tgl_awal = $this->lib_date->get_date_now();
      $status_izin = $permohonan->trstspermohonan->get();
      $status_skr = "8";                     //Penetapan/Penyusunan/Pencetakan Naskah Perizinan [Lihat Tabel trstspermohonan()]  => Kominfo Old 7
    	$id_status = "13";                     //Surat Diizinkan [Lihat Tabel trstspermohonan()]                                   => Kominfo Old 8
      $n_status = 'Izin Disetujui';
    	if($status_izin->id == $status_skr || $bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
        /* Input Data Tracking Progress */
        if($bap->c_pesan == "Work Flow" || $bap->c_pesan == "Tanpa Tinjauan Lapangan"){
    	    $tracking_izin = new tmtrackingperizinan();
          $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                        ->where('tr_activiti', 'Pertimbangan Teknis')->get();
          if($tracking_izin->pendaftaran_id){
            $tracking_izin->tr_activiti = 'Penyusunan Berkas';
    	      $tracking_izin->status = 'Update';
    	      $tracking_izin->tr_name = $r_name;
            $tracking_izin->tr_user = $u_ser;
    	      $tracking_izin->d_entry = $akdp_cetak->tgl_penetapan_kp;
    	      $hit_ubah = $tracking_izin->hit_ubah + 1;
     	      $his_ubah = $tracking_izin->his_ubah;
     	      $tracking_izin->hit_ubah = $hit_ubah;
            $tracking_izin->his_ubah = $his_ubah.$n_status.'^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin->save();
          }
        }
        
    	  // Memesan tempat untuk penyerahan izin
    	  $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Penyerahan Izin')->get();
        if(!$tracking_izin2->pendaftaran_id){
          $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
          $tracking_izin2->status = 'Insert';
          $tracking_izin2->tr_activiti = 'Penyerahan Izin';
          $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
          $tracking_izin2->d_entry = $this->lib_date->get_date_now();
          $sts_izin2 = new trstspermohonan();
     	    $sts_izin2->get_by_id($status_skr); //[Lihat Tabel trstspermohonan()]   => edit PBS
          $sts_izin2->save($permohonan);
          $tracking_izin2->save($permohonan);
          $tracking_izin2->save($sts_izin2);
    	  }
                  
    	  $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Arsip')->get();
        if(!$tracking_izin2->pendaftaran_id){
          $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
          $tracking_izin2->status = 'Insert';
          $tracking_izin2->tr_activiti = 'Arsip';
          $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
          $tracking_izin2->d_entry = $this->lib_date->get_date_now();
          $sts_izin2 = new trstspermohonan();
     	    $sts_izin2->get_by_id('16'); //[Lihat Tabel trstspermohonan()]   => edit PBS
          $sts_izin2->save($permohonan);
          $tracking_izin2->save($permohonan);
          $tracking_izin2->save($sts_izin2);
    	  }
    	  
        $petugas = 1; //1 -> Jabatan Penandatangan
        $tgl_skr = $this->lib_date->get_date_now();
        $data_tahun = date("Y");
        if($id_status == "13"){              //Surat Diizinkan [Lihat Tabel trstspermohonan()] => Kominfo Old 8
          /* Input Data */
          $data_id = new tmsk();
          $data_id->select_max('id')->get();
          $data_id->get_by_id($data_id->id);
         
          $no_surat = 'No.SK '.$akdp_cetak->no_sk.' No.KP '.$akdp_cetak->no_kp;
    	    $tgl_surat = $akdp_cetak->tgl_penetapan_kp;
    	    
          $surat_sk = new tmsk();
          $surat_sk->c_status = 1;
          $surat_sk->i_urut = 0;                   //$data_urut;
          $surat_sk->no_surat = $no_surat;
          $surat_sk->no_surat_edit = $no_surat;
    	    $surat_sk->tgl_surat = $tgl_surat;
    	    $surat_sk->tgl_surat_edit = $tgl_surat;
    	    $surat_sk->tgl_penetapan = $tgl_surat;
    	    $surat_sk->id_user_penetapan = $id_user;
          
          /* Input Relasi Tabel*/
          $pegawai = new tmpegawai();
          $pegawai->where('status', $petugas)->get();
          $permohonan->d_berlaku_izin = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+$perizinan->v_berlaku_tahun));
          $permohonan->nip_ttd = $pegawai->nip;
          $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
          $permohonan->d_berlaku_keputusan = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")+1));
    	    
    	    // PBS Create
          $permohonan->status_berkas = $n_status;
          if($e_sertifikat == 0){
    	      $permohonan->approve = 1;       // posisi di approve pengolah ptsp
    	    }
    	    if($permohonan->kd_status < 6){ // ubah kd_status menjadi 6 (Penetapan, lihat status_berkas) untuk proses selanjutnya (Pencetakkan naskah izin)
            $permohonan->kd_status = 6;
    	    }
          // EOF PBS Create
            
          $permohonan->save();
          $surat_sk->save(array($permohonan, $pegawai));
        }
      }
      $bap->status_bap = 1;
      $bap->c_penetapan = 1;
      $bap->save();
    }
    redirect('permohonan/penetapan');
  }

  public function kunci_data($id = NULL) {  // Proses Penguncian data agar bisa di kirim ke ESL 4
  	$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
    $user = new user();
    $user->where('username', $u_ser)->get();
		$id_user = $user->id;
        
		if($id == NULL)
		  $id_pemohon = $this->input->post('id');
		else
			$id_pemohon = $id;
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_pemohon);
    $perizinan = $permohonan->trperizinan->get();
    $e_ttd = $perizinan->e_ttd;
    $permohonan->approve = 1;
		$permohonan->save();
		
		// Membuat File naskah docx ke backoffice/assets/download
		if($e_ttd == 1){    // mode ttd Elektronik
      redirect('permohonan/sk/cetak_sk/'.$id_pemohon.'/1'.'/'.'permohonan/penetapan');
    }
    if($e_ttd == 2){    // mode Upload
		  redirect('permohonan/sk/cetak_sk/'.$id_pemohon.'/3'.'/'.'permohonan/penetapan');
		}
		  
		// EOF() Membuat File naskah  docx ke backoffice/assets/download
		//echo'id req: ',$id_pemohon.'iddt: '.$permohonan->id;
    redirect('permohonan/penetapan');
  }
  
  public function create_pdf($id = NULL) {  // Proses Konfersi docx ke pdf hanya untuk admin
  	if($id == NULL)
		  $id_pemohon = $this->input->post('id');
		else
			$id_pemohon = $id;
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_pemohon);
    $nodaftar = $permohonan->pendaftaran_id;
    $perizinan = $permohonan->trperizinan->get();
    $e_ttd = $perizinan->e_ttd;
    switch($e_ttd){
		  case 0 :  // Manual
		    $redirect = str_replace(' ', '','MN'.$nodaftar); break;
      case 1 :  // Elektronik
			  $redirect = str_replace(' ', '','SK_'.$nodaftar); break;
      case 2 :  // Upload
			  $redirect = str_replace(' ', '','SK_'.$nodaftar); break; 
				break;
    }
    $file_target = 'assets/download/'.$redirect.'.docx';
    echo 'nama file: '.$file_target.'<br>';
    if(file_exists('assets/download/'.$redirect.'.docx')){ //cek file docx
      echo 'status file: Ditemukan <br>';
    }else{
      echo 'status file: Tidak Ditemukan <br>';
    }
    // Konfersi docx ke pdf di folder backoffice/assets/skpdf
    if(file_exists('assets/skpdf/'.$redirect.'.pdf')){
      unlink('assets/skpdf/'.$redirect.'.pdf');
      if(file_exists('assets/skpdf/'.$redirect.'.pdf'))
      	echo 'Penghapusan file PDF: Gagal <br>';
      else
        echo 'Penghapusan file PDF: Berhasil <br>';
    }else{
      echo 'status file PDF: Tidak Ditemukan <br>';
    }
		$namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    //$data = file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Findex&id='.$namafile, FALSE, $context);  // untuk local
    $data = file_get_contents('http://103.122.5.250/siapi/api/spekta?id='.$namafile, FALSE, $context);  // untuk server
    if ($data && $data == 'OK') {
		  echo 'Sukses';
	  }else{
		  echo "Gagal";
	  }
	  // EOF() Konfersi docx ke pdf di folder backoffice/assets/skpdf
	  redirect('permohonan/penetapan');
	}  
	
	public function edit_alasan($id = NULL) {  // Proses Penyimpanan Edit Alasan Penolakan Izin
    $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
    $user = new user();
    $user->where('username', $u_ser)->get();
		$id_user = $user->id;

    if($id == NULL)
		  $id_pemohon = $this->input->post('id');
		else
			$id_pemohon = $id;
      $permohonan = new tmpermohonan();
      $permohonan->get_by_id($id_pemohon);
        
		mysql_query("DELETE FROM alasan_penolakan WHERE id_permohonan = '$id_pemohon'");
		$alasan_penolakan = $_POST['alasan'];
    $id_permohonan = htmlspecialchars($_POST['id'],ENT_QUOTES);
    foreach($alasan_penolakan as $alasan){
      $data = array('id_permohonan' => $id_permohonan,
                    'alasan' => htmlspecialchars($alasan,ENT_QUOTES)
                   );
      $this->db->Insert('alasan_penolakan', $data);
    }
        
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql($u_ser);
    //$p = $this->db->query("call log ('Penetapan Izin','Penetapan izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

    redirect('permohonan/penetapan');
  }

  public function savenosk() {  // Create PBS  Untuk Simpan Proses Penomoran
    $u_ser = $this->session->userdata('username');
    $username = new user();
    $username->where('username', $u_ser)->get();
    $id_user = $username->id;
		$user_group = $this->input->post('user_group');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
    $id_pemohon = $this->input->post('id');
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_pemohon);
		$perizinan = $permohonan->trperizinan->get();
		$bap = $permohonan->tmbap->get();
		$no_sk_lama = $bap->no_sk_lama;
		$tg_sk_lama = $bap->tg_sk_lama;
    $nama_izin = $perizinan->n_perizinan;
    $e_sertifikat = $perizinan->e_sertifikat;
    $e_ttd = $perizinan->e_ttd;
    $approve = $perizinan->approve;
		$id_izin = $perizinan->id;
		$data_tahun = date('Y');
		$c_in_nomor = $perizinan->cara_penomoran;
		$cek_sk = $this->input->post('id_sk');
		$cek_surkep = $this->input->post('id_surkep');
		$c_in_nomor = $this->input->post('c_in_nomor');
		$in_nomor = $this->input->post('noskedit');
		$tg_srt = $this->input->post('tglterbit');
		
		$ikuti = FALSE;
		if($c_in_nomor == 3){  // jika sistem ke berkas (MENGIKUTI)
			$ikuti = TRUE;
		  $kd_izin = $perizinan->kd_izin;
		  $master_izin = new trperizinan();
      $master_izin->where("cara_penomoran",2)
                  ->where("kd_izin LIKE '%".substr($kd_izin,0,5)."%'")->get();  // filter untuk kd_izin 5 digit awal
			if($data_tahun != $master_izin->no_sk_thn){ // jika pergantian tahun
			  $master_data_urut = 1;
			  $master_izin->no_sk_thn = $data_tahun;
			}else{
				if($no_sk_lama){
			    $master_data_urut = $no_sk_lama;
			    $tg_srt = $tg_sk_lama;
			  }else{  
			    $master_data_urut = $master_izin->no_sk_tengah + 1;
          $master_izin->no_sk_tengah = $master_data_urut;
			  }
			}
      $master_izin->save();
	  }
	  
		
		if($c_in_nomor == 1){  // jika penomoran dari berkas ke sistem
			$sys_berkas = FALSE;
      $data_urut = $in_nomor;
		}else{
			$sys_berkas = TRUE;
			if($data_tahun != $perizinan->no_sk_thn){ // jika pergantian tahun
				if($ikuti){
			    $data_urut = $master_data_urut;
			  }else{
			    $data_urut = 1;
			  }  
			  $perizinan->no_sk_thn = $data_tahun;
			}else{
				if($ikuti){
			    $data_urut = $master_data_urut;
			  }else{
			  	if($no_sk_lama){
            $sys_berkas = FALSE;
            $data_urut = $in_nomor;
			  	  $data_urut = $no_sk_lama;
			  	  $tg_srt = $tg_sk_lama;
			  	}else{  
			      $data_urut = $perizinan->no_sk_tengah + 1;
			    }  
			  }
			}  
		}
		$text_no = 'PENOMORAN^';
		if($user_group == 4){
			$text_no = 'PENOMORAN MANUAL^';
			$data_urut = $perizinan->no_sk_tengah;
			$n_srt = $in_nomor;
		}else{
      $n_srt = $this->input->post('no_sk_awal').$data_urut.$this->input->post('no_sk_akhir').$this->input->post('no_sk_tahun');
		}
        
		if($sys_berkas){  // kasus maluku utara kembali nomor ke 0 lagi
	    $perizinan->no_sk_tengah = $data_urut;
      $perizinan->save();
		}
		
		$sk = new tmsk();
    $sk->get_by_id($cek_sk);
		$tr_aktivitas = "Save ";
		if($sk->no_surat_edit !== $this->input->post('noskedit')) $tr_aktivitas = $tr_aktivitas . "No SK, ";
		if($sk->tgl_surat_edit !== $this->input->post('tglterbit')) $tr_aktivitas = $tr_aktivitas . "Tgl SK, ";
      $sk->no_surat = $n_srt;
		$sk->no_surat_edit = $n_srt;
		$sk->tgl_surat = $tg_srt;
		$sk->tgl_surat_edit = $tg_srt;
		$sk->i_urut = $data_urut;
		$sk->id_user_penetapan = $id_user;
    $sk->save();

		$skp = new tmsurat_keputusan();
    $skp->get_by_id($cek_surkep);
    $skp->no_surat = $n_srt;
		$skp->tgl_surat = $tg_srt;
		$skp->i_urut = $data_urut;
    $skp->save();

    $tracking_izin = new tmtrackingperizinan();
		$tracking_izin->where('pendaftaran_id', $permohonan->pendaftaran_id)
  			          ->where('tr_activiti', 'Arsip')->get();
		if($tracking_izin->pendaftaran_id){
			$hit_ubah = $tracking_izin->hit_ubah + 1;
	    $his_ubah = $tracking_izin->his_ubah;
	    $tracking_izin->hit_ubah = $hit_ubah;
	    $tracking_izin->his_ubah = $his_ubah.$text_no.$r_name.'^'.$this->lib_date->get_date_now().';';
      $tracking_izin->save();             // hanya edit di tracking_izin
    }
    
    if($e_sertifikat == 1 && $approve == 0){
		  $permohonan->approve = 1;       // posisi di approve pengolah ptsp
		  $permohonan->save();
		}
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql($u_ser);
    // $p = $this->db->query("call log ('Penomoran Ulang Izin','Penomoran Ulang Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
    
		if($user_group == 4) {
      $kembali = 'permohonan/penetapan/index';     // OLD index_next
      $link = 0;
    } else {
      $kembali = 'permohonan/penetapan/penomoran/'. $id_pemohon .'/'. $id_izin .'/1';
      $link = 1;
    }
      $e_menu = 0;
      if($e_ttd == 1) $e_menu = 1; // Elektronik
      if($e_ttd == 2) $e_menu = 3; // Upload
      if($e_menu != 0) {
        // if ($this->All) {
          redirect('permohonan/sk/cetak_sk/'.$id_pemohon.'/'.$e_menu.'/'.$link);   // membuat file docx
        // } else {
        //   redirect($kembali);
        // } 
      }
          
  }

	public function sn_izin($id_pemohon = NULL, $id_jnsizin = NULL) {
    $this->perizinan->where('id', $id_jnsizin);
    $this->perizinan->get();
        
    $kelompok = new trkelompok_perizinan();
    $unit = new trunitkerja();
    $sektor = new trkecamatan();
		$sektor = new trsektor();

    $this->perizinan->trkelompok_perizinan->get();
    $this->perizinan->trunitkerja->get();
    $this->perizinan->trsektor->get();

    $data['dtunitkerja'] = $this->perizinan->trunitkerja->n_unitkerja;
    $data['n_klp'] = $this->perizinan->trkelompok_perizinan->n_kelompok;
    $data['n_sektor'] = $this->perizinan->trsektor->n_sektor;

    $data['id'] = $this->perizinan->id;
		$data['id_pemohon'] = $id_pemohon;
    $data['kd_izin']  = $this->perizinan->kd_izin;
		$data['n_perizinan'] = $this->perizinan->n_perizinan;
		$data['n_perizinan_cetak']  = $this->perizinan->n_perizinan_cetak;
		$data['kd_indeks']  = $this->perizinan->kd_indeks;
		$data['indeks']  = $this->perizinan->indeks;
    $data['kelompok_id'] = $this->perizinan->trkelompok_perizinan->id;
    $data['unitkerja_id'] = $this->perizinan->trunitkerja->id;
		$data['bid_teknis']  = $this->perizinan->bid_teknis;
		$data['sektor_id'] = $this->perizinan->trsektor->id;
    $data['save_method'] = "update";
    $data['v_berlaku_tahun'] = $this->perizinan->v_berlaku_tahun;
    $data['v_hari'] = $this->perizinan->v_hari;
    $data['is_open'] = $this->perizinan->is_open;
    $data['c_foto'] = $this->perizinan->c_foto;
    $data['c_keputusan'] = $this->perizinan->c_keputusan;
    $data['c_berlaku'] = $this->perizinan->c_berlaku;
		$data['c_aktif'] = $this->perizinan->c_aktif;
    $data['v_perizinan'] = $this->perizinan->v_perizinan;
		$data['no_sk_awal'] = $this->perizinan->no_sk_awal;
		$data['no_sk_tengah'] = $this->perizinan->no_sk_tengah;
		$data['no_sk_akhir'] = $this->perizinan->no_sk_akhir;
		$data['c_in_nomor'] = $this->perizinan->cara_penomoran;

    $js = "$(document).ready(function(){
             $(\"#tabs\").tabs();
             $('#form').validate();
           })";
    $this->template->set_metadata_javascript($js);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Seting Nomor Perizinan";
    $this->template->build('set_nizin', $this->session_info);
  }

  public function simpan_seting() {
	  $id_pemohon = $this->input->post('id_pemohon');
		$id_izin = $this->input->post('id_izin');
		
		$update = $this->perizinan
                   ->where('id', $id_izin)
                   ->update(array('no_sk_awal' => $this->input->post('no_sk_awal'),
			                            'no_sk_tengah' => $this->input->post('no_sk_tengah'),
                                  'no_sk_akhir' => $this->input->post('no_sk_akhir')
                                  ));
    redirect('permohonan/penetapan/penomoran/'. $id_pemohon .'/'. $id_izin);
  }

  public function _number_safe() {
    $is_safe = TRUE;
    return $is_safe;
  }

  public function _get_ret($id = NULL) {
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id);
    $permohonan->tmbap->get();
    $ret = $permohonan->tmbap->nilai_retribusi;
    return $ret;
  }

  public function _get_day_to_send() {
    /*
     * Cek apakah besok libur?
    */

    $date = now();
    $date = substr(unix_to_human($date, FALSE), 0, 10);
    $day = intval(substr($date, 8, 2));
    $month = intval(substr($date, 5, 2));
    $year = intval(substr($date, 0, 4));
    $day = $day + 1;
    $holiday = FALSE;
    do {
      if ($month === 1 || $month === 3 || $month === 5 || $month === 7 || $month === 8 || $month === 10 || $month === 12) {
        $day_length = 31;
      } else 
        if ($month === 2) {
          if ($year % 4 === 0) {
            $day_length = 29;
          } else {
            $day_length = 28;
          }
        } else {
          $day_length = 30;
        }

      $day = $day + 1;
      if ($day > $day_length) {
        $day = $day - $day_length;
        $month = $month + 1;
        if ($month > 12) {
          $month = $month - 12;
          $year = $year + 1;
        }
      }

      $parse_date = $year . "-" . $month . "-" . $day;
      $holiday = new tmholiday();
      $is_holiday = $holiday->where('date', $parse_date)->count();

      if ($is_holiday === 0) {
        $holiday = FALSE;
      }
    } while ($holiday);
    return $day . "-" . $month . "-" . $year;
  }

  public function update() {
    $update = $this->bap
                   ->where('id', $this->input->post('id_bap'))
                   ->update('pendaftaran_id', $this->input->post('nopendaftaran'))
                   ->update('bap_id', $this->input->post('nobap'))
                   ->update('c_pesan', $this->input->post('pesankomentar'))
                   ->update('status_bap', $this->input->post('status'))
                   ->update('nilai_retribusi', $this->input->post('nilai_retribusi'));

    if ($update) {
      $this->index();
    }
  }

  public function delete($id = NULL) {
    $this->perizinan->where('id_pemohon', $id)->get();
    if ($this->perizinan->delete()) {
      redirect('perizinan');
    }
  }

	public function delete_bap($uid = NULL) {
		$sqlhapus = @mysql_query("DELETE FROM tmbap WHERE id = $uid");
		redirect('permohonan/penetapan/index');     // OLD index_next
  }

  public function ctk_pengembalian($id=NULL, $idizin=NULL) {  // Cetak Surat Pengembalian
	  $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $permohonan = new tmpermohonan();
		$dkelurahan = new trkelurahan();
    $permohonan->where('id', $id)->get();
		$tmsk = $permohonan->tmsk->get();
    $permohonan->trperizinan->get();
		$sektor = $permohonan->trperizinan->trsektor->get();
    $permohonan->tmpemohon->get();
    $permohonan->tmperusahaan->get();
		$sektor = $permohonan->trperizinan->trsektor->get();

    $perusahaan = $permohonan->tmperusahaan->n_perusahaan;
		if($perusahaan){
			$perusahaan = 'Direksi '.$permohonan->tmperusahaan->n_perusahaan;
      $p_kelurahan = $permohonan->tmperusahaan->trkelurahan->get();
			$n_kelurahan = $p_kelurahan->n_kelurahan; if($n_kelurahan == '-') $n_kelurahan = ''; else $n_kelurahan = 'Ds/Kel. '.$p_kelurahan->n_kelurahan.' ';
			//if($p_kelurahan->n_kelurahan == '') $n_kelurahan = '';
      $p_kecamatan = $permohonan->tmperusahaan->trkelurahan->trkecamatan->get();
			$n_kecamatan = $p_kecamatan->n_kecamatan; if($n_kecamatan == '-') $n_kecamatan = ''; else $n_kecamatan = 'Kec. '.$p_kecamatan->n_kecamatan.' ';
			//if($p_kecamatan->n_kecamatan == '') $n_kecamatan = '';
      $p_kabupaten = $permohonan->tmperusahaan->trkelurahan->trkecamatan->trkabupaten->get();
      $n_kabupaten = $p_kabupaten->n_kabupaten; if($n_kabupaten == '-') $n_kabupaten = '';
			$alamat_perus = $permohonan->tmperusahaan->a_perusahaan.' '.$n_kelurahan.$n_kecamatan.$n_kabupaten;
		}else{
			$perusahaan = 'Saudara/i '.$permohonan->tmpemohon->n_pemohon;
			$p_kelurahan = $permohonan->tmpemohon->trkelurahan->get();
			$n_kelurahan = $p_kelurahan->n_kelurahan; if($n_kelurahan == '-') $n_kelurahan = ''; else $n_kelurahan = 'Ds/Kel. '.$p_kelurahan->n_kelurahan.' ';
			//if($p_kelurahan->n_kelurahan == '') $n_kelurahan = '';
      $p_kecamatan = $permohonan->tmpemohon->trkelurahan->trkecamatan->get();
			$n_kecamatan = $p_kecamatan->n_kecamatan; if($n_kecamatan == '-') $n_kecamatan = ''; else $n_kecamatan = 'Kec. '.$p_kecamatan->n_kecamatan.' ';
			//if($p_kecamatan->n_kecamatan == '') $n_kecamatan = '';
      $p_kabupaten = $permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
      $n_kabupaten = $p_kabupaten->n_kabupaten; if($n_kabupaten == '-') $n_kabupaten = '';
	    $alamat_perus = $permohonan->tmpemohon->a_pemohon.' '.$n_kelurahan.$n_kecamatan.$n_kabupaten;
		}
		$tgl_terima_berkas = $this->lib_date->mysql_to_human($permohonan->d_terima_berkas);
		$no_daftar = $permohonan->pendaftaran_id;
		$nama_izin = $permohonan->trperizinan->n_perizinan;  //n_perizinan_cetak
		$id_sk = $tmsk->id;
		$nperusahaan = strtoupper($perusahaan);

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

		// Ambil tinggi_kop
    $this->tr_instansi = new Tr_instansi();
    $tinggi_kop = $this->tr_instansi->get_by_id(26)->value;
        
    $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
    $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;

    //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
		//$pdf = new FPDF();
		$pdf = new FPDF('P','mm','LEGAL'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), legal'=>array(612,1008));
		//$pdf->SetMargins(0,20,0); //$pdf->SetMargins(kiri,atas,kanan);
    //$pdf->AddPage();
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
		$pdf->SetAutoPageBreak('ON', 50);
		$pdf->SetTopMargin($brs);
		$pdf->SetLeftMargin(10);
		$pdf->SetRightMargin(10);
    $tinggikop = $tinggi_kop; //dapat diubah untuk menentukan tinggi kop surat yang ada
		$pdf->Ln($tinggikop);
		
		$no_srtolak = "        ";
		$tgl_srtolak = date('Y-m-d H:i:s');
		
    // penomoran penolakan Otomatis Per Tahun Auto Restart No penolakan
		if($tmsk->no_surat_edit == '') { // belum ada no permohonan 
		  $save_no = TRUE;
      $data_tahun = date('Y');
      $year = new year();
      $year = $year->where('tahun', $data_tahun)->get();
      if($year->tahun){ // ditemukan
        $no_srtolak = $year->no_urut_pertek + 1;
      }else{            // tidakditemukan
        $no_srtolak = 1;
        $year = new year();
        $year->tahun = $data_tahun;
      }
      $year->no_urut_pertek = $no_srtolak;
      $year->save();
		}else{   // sudah ada no penolakan
		  $save_no = FALSE;
      $no_srtolak  = $tmsk->no_surat_edit;
      $tgl_srtolak = $tmsk->tgl_surat_edit;
    }

    // Menyimpan nomor dan tanggal penolakan
		if($save_no){
			$sk = new tmsk();
      $sk = $sk->get_by_id($id_sk);
      $sk->no_surat_edit = $no_srtolak;
      $sk->tgl_surat_edit = $tgl_srtolak;
      $sk->save();
	  }

		//simpan ke tabel tmsurat_keluar
		$surat_keluar = new tmsurat_keluar();
    $surat_keluar = $surat_keluar->where('tmsk_id', $id_sk)->where('no_surat', $no_srtolak)->get();
		$npaw = $surat_keluar->no_pertek_awal;
		$ns = $surat_keluar->no_surat;
		$npak = $surat_keluar->no_pertek_akhir;
		if(!$surat_keluar->tmsk_id){ //jika tidak ditemukan
		  $npaw = $sektor->no_pertek_awal.' / ';
			$ns = $no_srtolak;
			$npak = ' / '.$sektor->no_pertek_akhir;
		  $surat_keluar = new tmsurat_keluar();
      $surat_keluar->tmpermohonan_id = $id;
      $surat_keluar->tmsk_id = $id_sk;
			$surat_keluar->user_id = $username->id;
			$surat_keluar->no_pertek_awal = $npaw;
	  	$surat_keluar->no_surat = $ns;
			$surat_keluar->no_pertek_akhir = $npak;
      $surat_keluar->tgl_surat = $tgl_srtolak;
      $surat_keluar->perihal = 'Surat Pengembalian';
      $surat_keluar->keterangan = 'Pembuatan Surat';
		}
		$surat_keluar->kepada = $nperusahaan;
		$surat_keluar->save();

		// EOF() Menyimpan nomor dan tanggal penolakan
		$this->settings->where('name', 'no_srt_tolak')->get();
		if($this->settings->status == 1){
			if($npaw == '') $npaw = '503 / ';
			if($npak == '') $npak = ' / PelPer';
	    $no_notolak = $npaw.$ns.$npak;
    }else{
      $no_notolak = $npaw.'          '.$npak;
    }
		
		$i_urut = strlen($no_srtolak);
    for ($i = 5; $i > $i_urut; $i--) {
      $no_srtolak = "0" . $no_srtolak;
    }
		//menghilangkan tanda yg tdk sesuai kaidah nama file
		$no_srtolak = str_replace("/","",$no_srtolak);
		$cod_bar = $no_srtolak.$this->lib_date->ambil_tahun($tgl_srtolak).$this->lib_date->ambil_bulan($tgl_srtolak,1).
    $this->lib_date->ambil_tanggal($tgl_srtolak);

		$tgl = $surat_keluar->tgl_surat; // $tgl_srtolak;
		$jam_srtolak = date("H",strtotime($tgl)).date("i",strtotime($tgl)).date("s",strtotime($tgl));
		$jam_srtolak_ctk = ';'.date("H",strtotime($tgl)).':'.date("i",strtotime($tgl)).':'.date("s",strtotime($tgl));
		$cod_bar     = $no_srtolak.$jam_srtolak;     // gabungan no_urut dan Jam Pertek utk barcode
    $cod_bar_ctk = $no_srtolak.$jam_srtolak_ctk; // gabungan no_urut dan Jam Pertek utk cetak

		//NEW BARCODE
   	$font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
    $text = isset($_GET['text']) ? $_GET['text'] : $cod_bar;
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
    }
		catch(Exception $exception) {
      $drawException = $exception;
    }
    $drawing = new BCGDrawing('assets/barcode/' . $cod_bar . '.png', $color_white);
    if($drawException) {
      $drawing->drawException($drawException);
    } else {
      $drawing->setBarcode($code);
      $drawing->draw();
    }
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		$b_code_notolak = base_url(). 'assets/barcode/' . $cod_bar . '.png';
    //EOF() NEW BARCODE
		// EOF() penomoran pertemohonan penolakan Otomatis

		$spc  = '       ';
		$sp = 0;
		$br0  = 'Tasikmalaya, '.$this->lib_date->mysql_to_human($tgl_srtolak); //date('Y-m-d'));
		$br1  = 'Nomor';
		$br1a = $no_notolak; //'503/          /PelPer ';
    $br1b = 'Kepada';
		$br2  = 'Sifat';
		$br2a = 'Biasa';
		$br3  = 'Lampiran';
		$br3a = '-';
    $br3b = 'Yth.';
		$br3c = $nperusahaan;
		$br3d = strtoupper($alamat_perus);
    $br4  = 'Hal';
		$br4a = 'Pengembalian Berkas Permohonan';
		$br4b = 'di-';
		$br5  = 'TEMPAT';
    $br6  = 'Menindaklanjuti Surat Permohonan '.$nama_izin.', nomor pendaftaran '.$no_daftar.' tanggal '.$tgl_terima_berkas.', bersama ini kami sampaikan hal-hal sebagai berikut: '; 
		//$br7  = 'Berkenaan dengan hal tersebut, permohonan saudara belum dapat kami proses lebih lanjut dan berkas permohonan kami kembalikan. Kepada saudara dapat mengajukan kembali permohonan kepada kami apabila kelengkapan persyaratan administrasi dan teknis sudah terpenuhi sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.';
    $br8  = 'Demikian disampaikan untuk menjadi maklum.';
		$br9  = '';
		$br10 = '';
		
		$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('id', $sektor->ttd_tolak)->get();
		$br11 = ''; $br11a = ''; $jbt = '';
		if($sektor->ttd_tolak == '1'){     // utk kepala
      $br11 = 'KEPALA DINAS PENANAMAN MODAL DAN';
			$br11a = 'PELAYANAN TERPADU SATU PINTU';
		}else{
	    $br11 = 'a.n. KEPALA DINAS PENANAMAN MODAL DAN';
	    $br11a = 'PELAYANAN TERPADU SATU PINTU';
			$jbt = $pegawai->n_jabatan;;
		}		
		$br12 = 'PROVINSI TASIKMALAYA';
		$br13 = $jbt;
		$br14 = $pegawai->n_pegawai;
		$br15 = $pegawai->pangkat_gol;
		$br16 = 'NIP. '.$pegawai->nip;
		$br17 = ''; //'Tembusan Kepada Yth:';
		$br18 = ''; //'1. Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya;';
		$br19 = ''; //ucwords(strtolower('2. Kepala '.$unit.'.'));
		$tab = 30;

    //Put the watermark
    //$pdf->SetFont('Arial','B',50);
    //$pdf->SetTextColor(255,192,203);
    //$pdf->RotatedText(35,190,'W a t e r m a r k   d e m o',45);

		$pdf->SetFont('times','',16);
		$pdf->Ln(15); $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()); $pdf->Cell(0,0,$br0,2,2,'L');    //125
		$pdf->Ln(10); $pdf->Cell(0,0,$br1,0,1,'L');
	  $pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
	  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br1a,0,1,'L');
	  $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()); $pdf->Cell(0,0,$br1b,0,1,'L');   //125
		$pdf->Ln(6);  $pdf->Cell(0,0,$br2,0,1,'L');
		$pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br2a,0,1,'L');
		$pdf->Ln(6);  $pdf->Cell(0,0,$br3,0,1,'L');  $a = $pdf->GetY();
		$pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br3a,0,1,'L');
    $pdf->SetXY($pdf->GetX()+125,  $pdf->GetY()); $pdf->Cell(0,0,$br3b,0,1,'L');
		$pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br3c,0,'J');
    $b = $pdf->GetY();
		$pdf->SetXY($pdf->GetX(),$a);
		$pdf->Ln(6);  $pdf->Cell(0,0,$br4,0,1,'L');
		$pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br4a,0,1,'L'); 
		$pdf->SetXY($pdf->GetX(),$b+3);
    $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br3d,0,'J');
    $b = $pdf->GetY(); 
    $pdf->Ln(6);  $pdf->SetXY($pdf->GetX(),$b+4);
	  $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()); $pdf->Cell(0,0,$br4b,0,1,'L');
		$pdf->Ln(6);  $pdf->SetXY($pdf->GetX()+150,  $pdf->GetY()); $pdf->Cell(0,0,$br5,0,1,'L');
        
		//Cetak Alenia I
		$pdf->Ln(10);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$br6,0,'J',0,15);

		//Mencetak Alasan Penolakan
    $list = "SELECT * FROM alasan_penolakan WHERE id_permohonan = '$id'";
    $results = mysql_query($list);
		$no_lv0 = array('1.','2.','3.','4.','5.','6.','7.','8.','9.','10.','11.','12.','13.','14.','15.','16.','17.','18.','19.','20.','21.','22.','23.','24.','25.','26.');
		$no_lv1 = array('a.','b.','c.','d.','e.','f.','g.','h.','i.','j.','k.','l.','m.','n.','o.','p.','q.','r.','s.','t.','u.','v.','w.','x.','y.','z.');
    $no_lv2 = array('1)','2)','3)','4)','5)','6)','7)','8)','9)','10)','11)','12)','13)','14)','15)','16)','17)','18)','19)','20)','21)','22)','23)','24)','25)','26)');
		$no_lv3 = array('a)','b)','c)','d)','e)','f)','g)','h)','i)','j)','k)','l)','m)','n)','o)','p)','q)','r)','s)','t)','u)','v)','w)','x)','y)','z)');;
    $no=0;
    while ($rows = mysql_fetch_assoc(@$results)){
      $alasan =$rows['alasan'];
			$ar1_alasan = explode('$1{',$alasan);
			$jml_ar1_alasan = count($ar1_alasan);

			$pdf->SetFont('times','',16);
      $pdf->Ln(5);
			if($jml_ar1_alasan == 1){ // jika tanpa tabulasi lagi dg kode $1{ lv.1
     		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$no_lv0[$no],0,1,'L');                                      //50 => ctk no array lv 0
        $pdf->SetXY($pdf->GetX()+$tab+10, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($alasan),0,'J');                              //57
				$no++;
			}else{
				$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$no_lv0[$no],0,1,'L');                                      //50 => ctk no array lv 0
				$pdf->SetXY($pdf->GetX()+$tab+10, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar1_alasan[0]),0,'J');                       //57
				$no++;
        for($jar=1; $jar < $jml_ar1_alasan; $jar++){
          $pdf->Ln(3);
					$pdf->SetXY($pdf->GetX()+$tab+10, $pdf->GetY()); $pdf->Cell(0,0,$no_lv1[$jar-1],0,1,'L');                             //50 => ctk no array lv 1
					$ar2_alasan = explode('$2{',$ar1_alasan[$jar]);
          $jml_ar2_alasan = count($ar2_alasan);
					if($jml_ar2_alasan == 1){ // jika tanpa tabulasi lagi dg kode $2{ lv.2
            $pdf->SetXY($pdf->GetX()+$tab+18, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar1_alasan[$jar]),0,'J');           //57
					}else{
            for($jar2=0; $jar2 < $jml_ar2_alasan; $jar2++){
							if($jar2 == 0){
								$pdf->SetXY($pdf->GetX()+$tab+18, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar2_alasan[0]),0,'J');      //57
  				    }else{	
	  				    $pdf->Ln(3);
								$pdf->SetXY($pdf->GetX()+$tab+18, $pdf->GetY()); $pdf->Cell(0,0,$no_lv2[$jar2-1],0,1,'L');               //50 => ctk no array lv 2
                $ar3_alasan = explode('$3{',$ar2_alasan[$jar2]);
                $jml_ar3_alasan = count($ar3_alasan);
                if($jml_ar3_alasan == 1){ // jika tanpa tabulasi lagi dg kode $3{ lv.3
    							$pdf->SetXY($pdf->GetX()+$tab+26, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar2_alasan[$jar2]),0,'J');          //57
								}else{
									for($jar3=0; $jar3 < $jml_ar3_alasan; $jar3++){
                    if($jar3 == 0){
                      $pdf->SetXY($pdf->GetX()+$tab+26, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar3_alasan[0]),0,'J');      //57
										}else{
									    $pdf->Ln(3);
											$pdf->SetXY($pdf->GetX()+$tab+26, $pdf->GetY()); $pdf->Cell(0,0,$no_lv3[$jar3-1],0,1,'L');               //50 => ctk no array lv 3
                      $pdf->SetXY($pdf->GetX()+$tab+34, $pdf->GetY()-3); $pdf->MultiCell(0,6,trim($ar3_alasan[$jar3]),0,'J');  //57
										}
									}
								}
							}
						}
					}
				}
			}
		}
    // EOF(Mencetak Alasan Penolakan)
        
		// cetak ttd harus loncat jika
		if($pdf->GetY() > 311){                        // nilai sesuaikan dengan coba tampilan diatas  std 313
      $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
      $pdf->SetMargins(0,0,0);                   // $pdf->SetMargins(kiri,atas,kanan);
			$pdf->SetTopMargin($brs);
    	$pdf->SetLeftMargin(10);
	   	$pdf->SetRightMargin(10);
      //$pdf->SetY($brs);
      //$y=$pdf->GetY();
    }

		$pdf->SetFont('times','',16);
		$pdf->Ln(8);  $pdf->SetXY($pdf->GetX()+$tab+15, $pdf->GetY()); $pdf->Cell(0,0,$br8,0,1,'L');
		$pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br9,0,'J');

		$pdf->Ln(10); $pdf->Cell(75); $pdf->Cell(0,0,$br11,0,1,'C');
		$pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br11a,0,1,'C');
		$pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br12,0,1,'C');
		$pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br13,0,1,'C');
		$a = $pdf->GetY();
    //$pdf->Image($n_logo,155,$pdf->GetX()+$a+2,35);  // untuk ttd elektronik

		$pdf->Image($b_code_notolak,10,$a+27,55);
		$pdf->Ln(30); $pdf->Cell(75); $pdf->Cell(0,0,$br14,0,1,'C'); 
		$pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br15,0,1,'C');
		$pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br16,0,1,'C');

		$pdf->SetFont('times','',10);
		$pdf->Ln(2);
		$pdf->Cell(0,0,'------- tlk-'.$cod_bar_ctk.'-bdg -------',0,1,'L');

		//tembusan
		//$pdf->SetFont('times','',12);
		//$pdf->Ln(20); $pdf->Cell(0,0,$br17,0,1,'L');
		//$pdf->Ln(5);  $pdf->Cell(0,0,$br18,0,1,'L');
		//$pdf->Ln(5);  $pdf->Cell(0,0,$br19,0,1,'L');
    // EOF() ttd
        
		$n_file='tlk'.$permohonan->pendaftaran_id.'.pdf';
		$pdf->Output($n_file,'D');
  }

  public function cetakBAP($id=NULL, $idjenis=NULL) {
    $this->settings->where('name', 'app_folder')->get();
    $app_folder = $this->settings->value . "/";
    $app_city = $this->settings->where('name', 'app_city')->get();

    $permohonan = new tmpermohonan();
    $perizinan = new trperizinan();
    $property = new trproperty();
    $koefesien = new trkoefesientarifretribusi();
    $jenisproperty = new tmproperty_jenisperizinan();
    $permohonan->where('id', $id)->get();
    $permohonan->$perizinan->where('id', $idjenis)->get();
    $permohonan->$tanggal_survey->get();

    $pemohon = $permohonan->tmpemohon->get();
    $perusahaan = $permohonan->tmperusahaan->get();
    $bap = $permohonan->tmbap->get();

    $daftar = $permohonan->pendaftaran_id;

    $perizinan->trperizinan_trproperty->where('c_retribusi_id', 1);
    $perizinan->trperizinan_trproperty->where('trperizinan_id', $this->input->post('idjenis'));
    $perizinan->trperizinan_trproperty->get();

    $listform = $permohonan->$perizinan->trproperty->order_by('c_parent asc, c_order asc')->get();
    $list_daftar = $permohonan->tmproperty_jenisperizinan->get();
    $permohonan->$perizinan->$property->$jenisproperty->where('pendaftaran_id', $daftar)->get();
    $k_property = $permohonan->$perizinan->$property->$jenisproperty->k_property;
    $permohonan->$perizinan->$property->$koefesien->where('id', $k_property)->get();

    //path of the template file
    $nama_surat = "cetak_BAP";
    $this->load->plugin('odf');
    $odf = new odf('assets/odt/' . $nama_surat . '.odt');
    $odf->setImage('header', 'assets/css/' . $app_folder . '/images/dinas_1.jpg', '17.5', '4.5');

    /* $wilayah = new trkabupaten();
     if($app_city->value !== '0'){
       $alamat = $pemohon->a_pemohon.' '.$p_kelurahan->n_kelurahan.', '.
       $p_kecamatan->n_kecamatan.', '.ucwords(strtolower($p_kabupaten->n_kabupaten));
       $wilayah->get_by_id($app_city->value);
       $odf->setVars('kabupaten', ucwords(strtolower($wilayah->n_kabupaten)));
       $odf->setVars('kota', ucwords(strtolower($wilayah->n_kabupaten)));
     }else{
       $alamat = $pemohon->a_pemohon;
       $odf->setVars('kabupaten', 'setempat');
       $odf->setVars('kota', '...........');
     } 
    */
    $odf->setVars('title', 'Berita Acara Pemeriksaan');
    $odf->setVars('kota', '....');
    $odf->setVars('tanggal', date('d/m/Y'));

    if ($permohonan->$tanggal_survey->date) {
      if ($permohonan->$tanggal_survey->date != '0000-00-00')
        $tgl_periksa = $this->lib_date->mysql_to_human($permohonan->$tanggal_survey->date);
      else
        $tgl_periksa = "";
    }else
      $tgl_periksa = "";
    if ($bap->status_bap) {
      if ($bap->status_bap == "1")
        $status = "Ya";
      else
        $status = "Tidak";
    }else
    $status = "Tidak";

    $listeArticles = array(array('property' => 'Nomor pendaftaran','content' => $permohonan->pendaftaran_id,),
                           array('property' => 'Jenis Layanan','content' => $permohonan->$perizinan->n_perizinan,),
                           array('property' => 'Nama Pemohon','content' => $pemohon->n_pemohon,),
                           array('property' => 'Alamat pemohon','content' => $pemohon->a_pemohon,),
                           array('property' => 'Nama Perusahaan','content' => $perusahaan->n_perusahaan,),
                           array('property' => 'Tanggal Pemeriksaan','content' => $tgl_periksa,),
                           array('property' => 'No SK BAP','content' => $bap->bap_id,),
                           array('property' => 'Pesan Komentar','content' => $bap->c_pesan,),
                           array('property' => 'Sesuai','content' => $status,),
                          );
    $article = $odf->setSegment('articles');
    foreach ($listeArticles AS $element) {
      $article->titreArticle($element['property']);
      $article->texteArticle($element['content']);
      $article->merge();
    }
    $odf->mergeSegment($article);

    //break
    foreach ($listform as $data) {
      if ($list_daftar->id) {
        foreach ($list_daftar as $data_daftar) {
          $entry_property = new tmproperty_jenisperizinan_trproperty();
          $entry_property->where('tmproperty_jenisperizinan_id', $data_daftar->id)
                         ->where('trproperty_id', $data->id)->get();
          if ($entry_property->tmproperty_jenisperizinan_id) {
            $entry_daftar = new tmproperty_jenisperizinan();
            $entry_daftar->get_by_id($entry_property->tmproperty_jenisperizinan_id);
            $entry_id = $entry_daftar->id;
            $data_entry = $entry_daftar->v_property;
            $data_koefisien = $entry_daftar->k_property;
            $data_entryt = $entry_daftar->v_tinjauan;
            $data_koefisient = $entry_daftar->k_tinjauan;
          }
        }
      } else {
        $entry_id = '';
        $data_entry = '';
        $data_koefisien = 0;
      }
      $data_koefisien2 = new trkoefesientarifretribusi();
      $data_koefisien2->get_by_id($data_koefisien);

      if ($entry_daftar->v_tinjauan) {
        if ($entry_daftar->v_tinjauan == "0")
          $hasil = " ";
        else
          $hasil = $entry_daftar->v_tinjauan;
      }else
        $hasil = " ";
      if ($data->c_type) {
        if ($data->c_type == "2")
          $prop = "<b>" . $data->n_property . "</b>";
        else
          $prop = $data->n_property;
      }else
        $prop = $data->n_property;

      $listeArticles3 = array(array('property3' => $prop,
                                    'content3' => $data_koefisien2->kategori,
                                    'content33' => $hasil,
                                   ),
                             );

      $article3 = $odf->setSegment('articles3');
      foreach ($listeArticles3 AS $element3) {
        $article3->titreArticle3($element3['property3']);
        $article3->texteArticle3($element3['content3']);
        $article3->texteArticle4($element3['content33']);
        $article3->merge();
      }
    }
    $odf->mergeSegment($article3);

    //export the file
    $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
    $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
  }
    
  public function sqlRet($id) {
    $query = "select v_tinjauan from tmproperty_jenisperizinan as a 
              inner join tmpermohonan as b on b.pendaftaran_id=a.pendaftaran_id
              inner join tmproperty_jenisperizinan_trproperty as c on c.tmproperty_jenisperizinan_id=a.id
              inner join trproperty as d on d.id=c.trproperty_id
              where b.pendaftaran_id='".$id."' and d.id='45'";
        
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function sql($u_ser) {
    $query = "select a.description
	            from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  function showform($hit=Null,$id=NULL,$idijin=NULL,$nopendaftaran=NULL){
		if($hit==0)
			$judul = "Upload Dokumen Izin Baru ";
		else
			$judul = "Upload Dokumen Hasil Revisi Izin ";
		$data["judulapp"]=$judul;
		$data["hit"]=$hit;       // status 0:baru 1:revisi
		$data["id"]=$id;         // id perizinan
		$data["idijin"]=$idijin; // id jenis izin
		$data["nopendaftaran"]=$nopendaftaran;  // Nomor pendaftaran
		$viewfile="v_cupload_form";
		$this->load->view($viewfile,$data);
  }

  function upfile(){
		$hit = $this->input->post('hit');        // status 0:baru 1:revisi
		$id = $this->input->post('id');          // id perizinan
		$idijin = $this->input->post('idijin');  // id jenis izin
	  $nopendaftaran = $this->input->post('nopendaftaran');  // Nomor pendaftaran
	  $file_name = basename($_FILES["fileToUpload"]["name"]);
	  if(substr($file_name,-3) == 'pdf'){
	  	$ext = '.pdf';
	  	$target_dir = "assets/skpdf/";
	  }
		if(substr($file_name,-4) == 'docx'){
		  $ext = '.docx';
		  $target_dir = "naskah_izin/";
	  }
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    } else {
    }
		$fileBaru = $target_dir.$nopendaftaran.$ext;
		//unlink("naskah_izin/".$nopendaftaran.'.pdf');  // jika lebih dari satu tipe file
		//unlink("naskah_izin/".$nopendaftaran.'.docx'); // jika lebih dari satu tipe file
    rename($target_file, $fileBaru); // mengubah nama file
		if($hit == 0){
  		redirect('permohonan/penetapan/viewSK'.'/'. $id.'/'.$idijin);
		}else{
			unlink("assets/download/SK_".$nopendaftaran.'.docx');
			$permohonan = new tmpermohonan();
      $permohonan->where('id', $id)->update(array('approve' => '1'));
			//redirect('permohonan/sk/cetak_sk/'.$rows['id'].'/3'.'/'.'permohonan/penetapan');
			redirect('permohonan/penetapan/index');
		}
	}
}
// This is the end of role class