<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

/* Description of kasir class
 * @author PBS 20 Oktober 2016
 */

class Kasir extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->permohonan = new tmpermohonan();
    $this->bap = new tmbap();
    $this->tmsk = new tmsk();
    $this->akdp_cetak = new akdp_cetak();
    $this->load->model('dbmodel_akdp');
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->All = FALSE;
    $this->load->library('fpdf');
    //include('./www/libraries/html_table.php');
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '16') {
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -7);
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
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');
    $data['list'] = $this->sql($username->id, $tgla, $tglb); //$query;
    $data['c_bap'] = "1";
    
    $this->load->vars($data);
    $this->template->set_metadata_javascript($this->js());
    $this->session_info['page_name'] = "Pembayaran Retribusi";
    $this->template->build('list', $this->session_info);
  }

  public function index_next() {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    
    $data['list'] = $this->sql($username->id, $tgla, $tglb); //$query;
    $data['c_bap'] = "1";
    
    $this->load->vars($data);
    $this->template->set_metadata_javascript($this->js());
    $this->session_info['page_name'] = "Pembayaran Retribusi";
    $this->template->build('list', $this->session_info);
  }

  public function sql_OLD($idusr=NULL, $tgla=NULL, $tglb=NULL) {
    $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.retribusi_id, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
              A.a_izin, A.kd_gerai, A.d_selesai_proses, A.d_berlaku_izin,
              C.id idizin, C.n_perizinan, C.c_keputusan, C.indeks, E.n_pemohon,
              G.id idjenis, I.nilai_retribusi nret, K.id idsk, K.tgl_surat, K.no_surat, K.tgl_surat_edit, K.no_surat_edit, K.c_cetak, M.trkelompok_perizinan_id
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
              AND L.user_id = '".$idusr."'
              AND A.d_terima_berkas between '".$tgla."' and '".$tglb."'
              AND I.status_bap = 1
              order by A.id DESC";
    return $query;
  }
  
  public function sql_LAMA($idusr=NULL, $tgla=NULL, $tglb=NULL) {
  	if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.retribusi_id, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.a_izin, A.kd_gerai, A.d_selesai_proses, A.d_berlaku_izin,
                C.id idizin, C.n_perizinan, C.c_keputusan, C.indeks, E.n_pemohon,
                G.id idjenis, I.nilai_retribusi nret
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan as H ON H.tmpermohonan_id = A.id
                INNER JOIN tmbap as I ON H.tmbap_id = I.id
                LEFT JOIN tmpermohonan_trstspermohonan as J ON A.id = J.tmpermohonan_id
                LEFT JOIN trstspermohonan as K ON J.trstspermohonan_id = K.id
                WHERE A.d_terima_berkas between '".$tgla."' and '".$tglb."'
                order by A.id DESC";
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.retribusi_id, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                A.a_izin, A.kd_gerai, A.d_selesai_proses, A.d_berlaku_izin,
                C.id idizin, C.n_perizinan, C.c_keputusan, C.indeks, E.n_pemohon,
                G.id idjenis, I.nilai_retribusi nret
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan as H ON H.tmpermohonan_id = A.id
                INNER JOIN tmbap as I ON H.tmbap_id = I.id
                LEFT JOIN tmpermohonan_trstspermohonan as J ON A.id = J.tmpermohonan_id
                LEFT JOIN trstspermohonan as K ON J.trstspermohonan_id = K.id
                INNER JOIN trperizinan_user AS L ON L.trperizinan_id = C.id 
                WHERE L.user_id = '".$idusr."'
                AND A.d_terima_berkas between '".$tgla."' and '".$tglb."'
                order by A.id DESC";
    }
    return $query;
  }
    
  public function sql($u_ser=NULL,$tgla=NULL,$tglb=NULL,$lokasi_user=NULL,$no_daftar=NULL) {
    $query_filter = " A.d_terima_berkas between '$tgla' and '$tglb'";
    if(!empty($no_daftar)) {
        $query_filter = " A.pendaftaran_id LIKE '%".$no_daftar."%' ";
    }
    
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.c_tinjauan, A.d_terima_berkas, A.d_survey, A.kd_status, A.kd_gerai, A.d_selesai_proses, A.a_izin,
                A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.status_berkas, A.approve, A.no_per_pertek, A.retribusi_id,
                C.id idizin, C.n_perizinan, C.template_gub, E.n_pemohon,
                G.id idjenis, G.n_permohonan, K.n_sts_permohonan
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan as H ON H.tmpermohonan_id = A.id
                INNER JOIN tmbap as I ON H.tmbap_id = I.id
                LEFT JOIN tmpermohonan_trstspermohonan as J ON A.id = J.tmpermohonan_id
                LEFT JOIN trstspermohonan as K ON J.trstspermohonan_id = K.id
                WHERE".$query_filter."
                order by A.id DESC";
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.c_tinjauan, A.d_terima_berkas, A.d_survey, A.kd_status, A.kd_gerai, A.d_selesai_proses, A.a_izin,
                A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.status_berkas, A.approve, A.no_per_pertek, A.retribusi_id,
                C.id idizin, C.n_perizinan, C.template_gub, E.n_pemohon,
                G.id idjenis, G.n_permohonan, L.n_sts_permohonan
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan as H ON H.tmpermohonan_id = A.id
                INNER JOIN tmbap as I ON H.tmbap_id = I.id
                INNER JOIN trperizinan_user AS J ON  J.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_trstspermohonan as K ON A.id = K.tmpermohonan_id
                LEFT JOIN trstspermohonan as L ON K.trstspermohonan_id = L.id
                WHERE J.user_id = '" . $u_ser . "'
                AND ".$query_filter."
                order by A.id DESC";
    }
    return $query;
  }
    
  public function js() {
    $js =  "
            $(document).ready(function() {
              oTable = $('#permohonan').dataTable({
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
    return $js;
  }

  public function edit($id=NULL, $ret_id=NULL, $cek_bayar=NULL) {
    $this->permohonan->where('id', $id)->get();
    $this->permohonan->tmpemohon->get();
    $this->permohonan->trperizinan->get();
    $this->permohonan->tmbap->get();
    $this->permohonan->tmsk->get();
    $this->permohonan->trperizinan->trretribusi->get();
    
    $indeks = $this->permohonan->trperizinan->indeks;
    $no_surat = $this->permohonan->tmsk->no_surat_edit;
    $tg_surat = $this->permohonan->tmsk->tgl_surat_edit;
    if($no_surat == ''){
      $no_surat = $this->permohonan->tmsk->no_surat;
      $tg_surat = $this->permohonan->tmsk->tgl_surat;
    }
    $idjenis = $this->permohonan->trperizinan->id;
    $keringanan = $this->permohonan->tmkeringananretribusi->get();
    $m_hitung = $this->permohonan->trperizinan->trretribusi->m_perhitungan;
        
    if($m_hitung=="0") { // Otomatis
      $nilai_ret = $this->permohonan->trperizinan->trretribusi->v_retribusi + $this->permohonan->trperizinan->trretribusi->v_denda ;
    }else{
      $nilai_ret = $this->permohonan->trperizinan->trretribusi->v_denda + $this->permohonan->tmbap->nilai_retribusi;
    }
    
    $nilai_ret = $this->permohonan->tmbap->nilai_retribusi;  // untuk keperluan pa didndin ambil langsung
    $data['cek_bayar'] = $cek_bayar;
    $data['retribusi'] = $nilai_ret;
    $data['id'] = $id;
    $data['idbap'] = $this->permohonan->tmbap->id;
    $data['idsk'] = $this->permohonan->tmsk->id;
    $data['m_hitung'] = $m_hitung;
    $data['no_pendaftaran'] = $this->permohonan->pendaftaran_id;
    $data['nama_pendaftar'] = $this->permohonan->tmpemohon->n_pemohon;
    $data['tgl_surat'] = $tg_surat;
    $data['no_surat'] = $no_surat;
    $data['tglb'] = $this->permohonan->d_berlaku_izin;
    $data['jenis'] = $this->permohonan->trperizinan->n_perizinan;
    $data['indeks'] = $indeks;
    $data['a_izin'] = $this->permohonan->a_izin;
    $data['status'] = $this->permohonan->c_status_bayar;
    $data['v_lru'] = 0;
    $data['v_ig'] = 0;
    $data['v_il'] = 0;
    $data['v_td'] = 0;
    
    $this->load->vars($data);
    $js = "
           function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
                
           $(document).ready(function() {
             oTable = $('#permohonan').dataTable({
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
    $this->session_info['page_name'] = "Pembayaran Retribusi";
    $this->template->build('edit', $this->session_info);
  }
    
  public function sql_ret($id) {
    $query = "select v_tinjauan from tmproperty_jenisperizinan as a
             inner join tmproperty_jenisperizinan_trproperty as b on a.id = b.tmproperty_jenisperizinan_id
             inner join trproperty as c on c.id = b.trproperty_id
             where a.pendaftaran_id = '".$id."' and c.id = '45'"; 
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function save() {
    $indeks = $this->input->post('indeks');
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($this->input->post('id'));
    $pendaftaran_id = $permohonan->pendaftaran_id;
    
    // EOF() isi langsung retribusi
    if($indeks == 'AKDP'){
      $isi = array('retribusi' => $this->input->post('retribusi'));
      $this->akdp_cetak->where('pendaftaran_id', $pendaftaran_id)->update($isi);
    }
    
    $isi = array('nilai_retribusi' => $this->input->post('retribusi'));
    $this->bap->where('id', $this->input->post('idbap'))->update($isi);
        
    $isi = array('c_cetak' => 1);
    $this->tmsk->where('id', $this->input->post('idsk'))->update($isi);
    // EOF() isi langsung retribusi
    
    // ubah status bayar
    $isi = array('c_status_bayar' => '1', 'd_berlaku_izin' => $this->input->post('tglb'));
    $this->permohonan->where('id', $this->input->post('id'))->update($isi);
    
    //Cek Tracking Progress
    $updated = FALSE;
    $sts_awal = new trstspermohonan();
    $sts_awal->get_by_id('12'); //Pembayaran | Old Kominfo Sudah Membayar => 13[Lihat Tabel trstspermohonan()]
    $list_track = $permohonan->tmtrackingperizinan->get();
    if($list_track){
      foreach($list_track as $data_track){
        $data_status = new tmtrackingperizinan_trstspermohonan();
        $data_status->where('tmtrackingperizinan_id', $data_track->id)
                    ->where('trstspermohonan_id', $sts_awal->id)->get();
        if($data_status->tmtrackingperizinan_id){
          $updated = TRUE;
          break;
        }
      }
    }else{
      $updated = FALSE;
      break;
    }
    
    $status_izin = $permohonan->trstspermohonan->get();
    
    $status_skr = "12"; //Kasir [Lihat Tabel trstspermohonan()] | Old Kominfo => 13
    $id_status = "16"; //Penyerahan Izin [Lihat Tabel trstspermohonan()] | Old Kominfo => 14
    if($status_izin->id == $status_skr){
    /* Input Data Tracking Progress */
        //$sts_izin = new trstspermohonan();
        //$sts_izin->get_by_id($status_skr);
        //$data_status = new tmtrackingperizinan_trstspermohonan();
        //$list_tracking = $permohonan->tmtrackingperizinan->get();
        //if($list_tracking){
        //    $tracking_id = 0;
        //    foreach ($list_tracking as $data_track){
        //        $data_status = new tmtrackingperizinan_trstspermohonan();
        //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
        //        ->where('trstspermohonan_id', $sts_izin->id)->get();
        //        if($data_status->tmtrackingperizinan_id){
        //            $tracking_id = $data_status->tmtrackingperizinan_id;
        //        }
        //    }
        //}
        //$tracking_izin = new tmtrackingperizinan();
        //$tracking_izin->get_by_id($tracking_id);
        ////$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
        //$tracking_izin->status = 'Update';
        //$tracking_izin->d_entry = $this->lib_date->get_date_now();
        //$tracking_izin->save();
    
    /* [Lihat Tabel trstspermohonan()] */
        //$tracking_izin2 = new tmtrackingperizinan();
        //$tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
        //$tracking_izin2->status = 'Insert';
        //$tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
        //$tracking_izin2->d_entry = $this->lib_date->get_date_now();
        //$sts_izin2 = new trstspermohonan();
        //$sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
        //$sts_izin2->save($permohonan);
        //$tracking_izin2->save($permohonan);
        //$tracking_izin2->save($sts_izin2);
    }
    
    //Create Naskah SK dan KP Khusus AKDP
    $n_file_sk='SK_'.$pendaftaran_id.'.pdf';
    $lok_fileDr = 'assets/skpdf/';
    $lok_fileSE = 'assets/esignfile/';
    $stat_sk = FALSE;
    if(file_exists($lok_fileSE.$n_file_sk)){            // cek PDF SE
      $stat_sk = TRUE;
    }else{
      if(file_exists($lok_fileDr.$n_file_sk)){          // cek PDF Non SE
        $stat_sk = TRUE;
      }
    }
    if(!$stat_sk && $indeks == 'AKDP'){
      
    }
		//EOF() Create Naskah SK dan KP Khusus AKDP
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql2($u_ser);
    //$p = $this->db->query("call log ('Pembayaran Retribusi','Pembayaran ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
    
    //redirect('kasir/edit/'.$this->input->post('id'));  // sementara mati untuk keperluan pak didndin
    redirect('kasir/index_next');
  }
  
  public function create_skrd($id=NULL, $ret_id=NULL, $cek_bayar=NULL) {
    $this->permohonan->where('id', $id)->get();
    $this->permohonan->tmpemohon->get();
    $this->permohonan->trperizinan->get();
    $this->permohonan->tmbap->get();
    $this->permohonan->tmsk->get();
    $this->permohonan->trperizinan->trretribusi->get();
    $sektor = $this->permohonan->trperizinan->trsektor->get();
  	$id_sektor = $sektor->id;  
    
    // cari kendaraan
    $a_izin = $this->permohonan->a_izin;
    $d_terima_berkas = $this->permohonan->d_terima_berkas;
    $no_kd = substr($a_izin,0,13);
    $jml_bulan = 0;
    $no_kend = ''; $no_uji = '';
    $no_sk_lama = ''; $tg_sk_awal = '0000-00-00'; $tg_sk_akhir = '0000-00-00';
    $no_kp_lama = ''; $tgl_kp_awal = '0000-00-00'; $tgl_kp_akhir = '0000-00-00';
    $cari = true;
    $hit=0;
    while($cari){
    	 $no_kd = substr($a_izin,0,13-$hit);
       $jml = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend = '".$no_kd."'");
       if($jml == 0){
       	 $hit++;
       	 if($hit == 5){
       	   $cari = false;
       	   $no_kd = '';
       	 }
       }else{
         $cari = false;
         $dbakdp = $this->load->database('dbakdp', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
         $dt_kend = $dbakdp->query("select * from akdpkendaraan where no_kend ='".$no_kd."'")->first_row();
         $no_uji = $dt_kend->no_uji;
         // Cek Masa Berlaku
         //if($id_sektor == 10){  // Hanya Untuk AKDP
           //$akdp_cetak = new akdp_cetak();
	         //$akdp_cetak->where('pendaftaran_id', $no_pendaftaran)->get();
	         //$berlaku_kp_lama = $dt_kend->berlaku_kp_lama;
	         //if($berlaku_kp_lama == '0000-00-00'){
	         	//$dbakdp = $this->load->database('dbakdp', TRUE);
	         	$his_kend = $dbakdp->query("select * from akdpkendaraan_history
                                        where no_uji ='".$no_uji."' ORDER BY id DESC")->first_row();
            $no_sk_lama = $his_kend->no_sk;
            $no_kp_lama = $his_kend->no_kp;
            $tgl_kp_awal = $his_kend->tgl_kp_awal;  
            $tgl_kp_akhir = $his_kend->tgl_kp_akhir;
            $tg_sk_awal = $his_kend->tgl_sk;
            $tg_sk_akhir = $his_kend->masa_berlaku;
            
            $time0 = new DateTime($d_terima_berkas);
            $time1 = new DateTime($tg_sk_akhir);
            $diff = date_diff($time1,$time0);//$time1->diff($time0);
            if(($diff->y == 0) && ($diff->m == 0)){
              $jml_bulan = 0;
            }else{
              $jml_bulan = round($diff->y * 12 + $diff->m + $diff->d / 30);
            }
            
            //$jml_bulan = 1 + (date("Y",$berlaku_kp_lama) - date("Y",$d_terima_berkas))*12;
            //$jml_bulan += date("m",$berlaku_kp_lama) - date("m",$d_terima_berkas);
            
            //$start = create_date('2015-01-01');
            //$end =  create_date('2015-06-30');
            //$diff =  $start->diff($end);
            //$jml_bulan = $diff->y * 12 + $diff->m + $diff->d / 30;

             //if($berlaku_kp_lama == '0000-00-00'){
             //  $berlaku_kp_lama = '0000-00-00';
             //}else{
             //  $db_kp_lama = new akdp_cetak();
             //  $db_kp_lama->where('pendaftaran_id', $no_pendaftaran);
             //  $db_kp_lama->update('berlaku_kp_lama', $berlaku_kp_lama);   // Update Berlaku KP Lama
             //}
	         //}
	       //}  
	       // Cek Masa Berlaku
       }
    }
    // EOF() cari kendaraan
    
    $indeks = $this->permohonan->trperizinan->indeks;
    $no_surat = $this->permohonan->tmsk->no_surat_edit;
    $tg_surat = $this->permohonan->tmsk->tgl_surat_edit;
    if($no_surat == ''){
      $no_surat = $this->permohonan->tmsk->no_surat;
      $tg_surat = $this->permohonan->tmsk->tgl_surat;
    }
    $idjenis = $this->permohonan->trperizinan->id;
    $keringanan = $this->permohonan->tmkeringananretribusi->get();
    $m_hitung = $this->permohonan->trperizinan->trretribusi->m_perhitungan;
        
    if($m_hitung=="0") { // Otomatis
      $nilai_ret = $this->permohonan->trperizinan->trretribusi->v_retribusi + $this->permohonan->trperizinan->trretribusi->v_denda ;
    }else{
      $nilai_ret = $this->permohonan->trperizinan->trretribusi->v_denda + $this->permohonan->tmbap->nilai_retribusi;
    }
    
    $nilai_ret = $this->permohonan->tmbap->nilai_retribusi;  // untuk keperluan pa didndin ambil langsung
    $data['cek_bayar'] = $cek_bayar;
    $data['retribusi'] = $nilai_ret;
    $data['id'] = $id;
    $data['idbap'] = $this->permohonan->tmbap->id;
    $data['idsk'] = $this->permohonan->tmsk->id;
    $data['m_hitung'] = $m_hitung;
    $data['no_pendaftaran'] = $this->permohonan->pendaftaran_id;
    $data['tg_daftar'] = $d_terima_berkas;
    $data['nama_pendaftar'] = $this->permohonan->tmpemohon->n_pemohon;
    $data['jml_bulan'] = $jml_bulan;
    $data['no_sk_lama'] = $no_sk_lama;
    $data['mulai_laku_sk'] = $tg_sk_awal;
    $data['masa_laku_sk'] = $tg_sk_akhir;
    $data['no_kp_lama'] = $no_kp_lama;
    $data['tg_kp_lama_awal'] = $tgl_kp_awal;
    $data['tg_kp_lama_akhir'] = $tgl_kp_akhir;
    $data['tgl_surat'] = $tg_surat;
    $data['no_surat'] = $no_surat;
    $data['tglb'] = $this->permohonan->d_berlaku_izin;
    $data['jenis'] = $this->permohonan->trperizinan->n_perizinan;
    $data['idizin'] = $this->permohonan->trperizinan->id;
    $data['indeks'] = $indeks;
    $data['a_izin'] = $a_izin;
    $data['no_kend'] = $no_kd;
    $data['no_uji'] = $no_uji;
    $data['status'] = $this->permohonan->c_status_bayar;
    $data['v_lru'] = 0;
    $data['v_ig'] = 0;
    $data['v_il'] = 0;
    $data['v_td'] = 0;
    
    $this->load->vars($data);
    $js = "
           function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
                
           $(document).ready(function() {
             oTable = $('#permohonan').dataTable({
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
    $this->session_info['page_name'] = "Penetapan SKRD";
    $this->template->build('create_skrd', $this->session_info);
  }

  public function view() {
  	$permohonan_id = $this->input->post('id');
  	$permohonan = new tmpermohonan();
  	//$permohonan = $permohonan->get_by_id($permohonan_id);
  	//$perizinan = $permohonan->trperizinan->get();
  	
  	$permohonan = $permohonan->where('id', $permohonan_id)->get();        
    $pemohon = $permohonan->tmpemohon->get();               
    $perizinan = $permohonan->trperizinan->get();             
    //$this->permohonan->tmbap->get();                   
    //$this->permohonan->tmsk->get();                    
    //$this->permohonan->trperizinan->trretribusi->get();

  	//$idizin = $this->input->post('idizin');
  	//$perizinan = new trperizinan();
  	//$perizinan->get_by_id($idizin);
  	$sektor = $perizinan->trsektor->get();
  	$id_sektor = $sektor->id;  
  	
  	$masa = '';
  	$tahun = $this->lib_date->mysql_to_human($this->lib_date->get_date_now());
  	$nama = $pemohon->n_pemohon;
  	$alamat = $pemohon->a_pemohon;
  	$npwrd = '';
  	$tg_jatuh_tempo = '';
  	
  	switch ($id_sektor) {
      case '11' :     // Dinas Perikanan dan Kelautan
        $dinas = 'DINAS KELAUTAN DAN PERIKANAN PROVINSI TASIKMALAYA';
        $kd_ring =' 4 1 2 03 02';
        $objek_izin = '';
        $ur_ret1 = 'Izin Penangkapan Ikan';   // SIPI / SIUP
        $ur_ret2 = '';
        $ur_ret3 = '';
        $ni_ret1 = 0;
        $ni_ret2 = 0;
        $ni_ret3 = 0;
        $perhatian1 = '1. Harap Penyetoran dilakukan pada Bank Bendahara Penerima Pembantu.';
        $perhatian2 = '';
        $perhatian3 = ''; 
        $jabat1 = 'An. Pengguna Anggaran';
        $jabat2 = 'Kuasa Pengguna Anggaran';
        $nm_pejabat = 'Ir. H. JAFAR ISMAIL. M.M';
        $nip_pejabat = '19630902 199002 1 001';
        break;
      case '10' :      // Dinas Perhubungan
        //$akdp_cetak = new akdp_cetak();
	      //$akdp_cetak->where('pendaftaran_id', $permohonan->pendaftaran_id)->get();
	      //$berlaku_kp_lama = $akdp_cetak->berlaku_kp_lama;
	      $no_kend = $this->input->post('no_kend');
	      //if($berlaku_kp_lama == '0000-00-00'){
	      //	$no_kend = $akdp_cetak->no_kend;
	      //}
	      $periode =  $this->lib_date->mysql_to_human($this->input->post('tg_daftar'));
	      $tg_jatuh_tempo = $this->lib_date->mysql_to_human($this->input->post('masa_laku'));
	      $denda = $this->input->post('denda');
	      $text_denda = $this->input->post('text_denda');
	      if($denda == 0) $text_denda = '';
        $dinas = 'DINAS PERHUBUNGAN';
        $kd_ring =' 1 07 01 4 1 2 03 01';
        $objek_izin = $no_kend;
        $ur_ret1 = 'Penerbitan KP/SK';
        $ur_ret2 = 'Denda Keterlambatan '.$text_denda;
        $ur_ret3 = '';
        $ni_ret1 = $this->input->post('nilai_retribusi');
        $ni_ret2 = $denda;
        $ni_ret3 = 0;
        $perhatian1 = '1. Harap Penyetoran dilakukan pada Bank Bendahara Penerima Pembantu;';
        $perhatian2 = '2. Apabila SKRD ini tidak atau kurang dibayar lewat waktu paling lama 30 hari setelah SKRD diterima atau (tanggal) jatuh tempo dikenakan';
        $perhatian3 = '    sanksi administrasi bunga sebesar 2% per bulan.';
        $jabat1 = 'Bendahara Penerima Pembantu';
        $jabat2 = '';
        $nm_pejabat = 'ROBET F SIRAIT';
        $nip_pejabat = '19720412 201410 1 001';
        break;
      default :
        $dinas = '';
        $kd_ring ='';
        $objek_izin = '';
        $ur_ret1 = '';
        $ur_ret2 = '';
        $ur_ret3 = '';
        $ni_ret1 = 0;
        $ni_ret2 = 0;
        $ni_ret3 = 0;
        $perhatian1 = '';
        $perhatian2 = '';
        $perhatian3 = '';
        $jabat1 = '';
        $jabat2 = '';
        $nm_pejabat = '';
        $nip_pejabat = '';
        break;
    }
    $ni_ket_pokok = 0;
    $ni_sanksi_bunga = 0;
    $ni_sanksi_naik = 0;
    $jumlah = $ni_ret1 + $ni_ret2 + $ni_ret3 + $ni_ket_pokok + $ni_sanksi_bunga + $ni_sanksi_naik;
    $terbilang = '# '.$this->lib_date->terbilang($jumlah).' #';
    $tanggal = $this->lib_date->mysql_to_human($this->lib_date->get_date_now());
  	
  	$Wpaper = 262;
    $Hpaper = 450;
  	$pdf = new FPDF();
    $pdf->AddPage('P',array($Hpaper,$Wpaper));
    $pdf->SetMargins(10,0,10);      //$pdf->SetMargins(kiri,atas,kanan);
        
    // KOP Surat
    $logo = base_url().'uploads/logo/Logo120x150.png';
    $pdf->Ln(0); $pdf->Image($logo,35,0,20);
    $pdf->SetFont('Arial','B',12);   // 'U' untuk underline
    $pdf->Ln(0); $pdf->Cell(0,0,'PEMERINTAH DAERAH PROVINSI TASIKMALAYA',0,1,'C');
    $pdf->SetFont('Arial','B',13);   // 'U' untuk underline
    $pdf->Ln(5); $pdf->Cell(0,0,$dinas,0,1,'C');
    $pdf->Ln(5); $pdf->Cell(0,0,'SURAT KETETAPAN RETRIBUSI DAERAH (SKRD)',0,1,'C');
    // EOF() KOP Surat
    $x = 5;
    $y = 27;
    $w = 252;
    $h = 50;
    $pdf->SetFont('Arial','',10);   // 'U' untuk underline
    $pdf->Ln(5); $pdf->SetXY($x+245,$pdf->GetY()); $pdf->Cell(0,0,'OnLine',0,1,'R');
    //$pdf->Rect($x,$y,$w,$h);  //Draw the border untuk header
    $pdf->SetFont('Arial','',10);   // 'U' untuk underline
    $pdf->Ln(5); $pdf->SetXY($x+100,$pdf->GetY()); $pdf->Cell(0,0,'Masa',0,1,'L');                   // Masa
                 $pdf->SetXY($x+100+14,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+100+14+2,$pdf->GetY()); $pdf->Cell(0,0,$masa,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+100,$pdf->GetY()); $pdf->Cell(0,0,'Periode',0,1,'L');                   // Tahun
                 $pdf->SetXY($x+100+14,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+100+14+2,$pdf->GetY()); $pdf->Cell(0,0,$periode,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'Nama',0,1,'L');      // Nama
                 $pdf->SetXY($x+1+37,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+1+37+2,$pdf->GetY()); $pdf->Cell(0,0,$nama,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'Alamat',0,1,'L');      // Alamat
                 $pdf->SetXY($x+1+37,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+1+37+2,$pdf->GetY()); $pdf->Cell(0,0,$alamat,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'NPWRD',0,1,'L');      // NPWRD
                 $pdf->SetXY($x+1+37,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+1+37+2,$pdf->GetY()); $pdf->Cell(0,0,$npwrd,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'Tanggal Jatuh Tempo',0,1,'L');      // Tanggal Jatuh Tempo
                 $pdf->SetXY($x+1+37,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+1+37+2,$pdf->GetY()); $pdf->Cell(0,0,$tg_jatuh_tempo,0,1,'L');
        
    #Buat Tabel dan Isinya
    
    $l1 = 10; $l2 = 50; $l3 = 152; $l4 = 40;
    
    $pdf->SetXY($x,$y); $pdf->Cell($w, $pdf->GetY()-1, '', 1, '0', 'C', false);
    
    $pdf->SetXY($x,53);
    $header = array(array("label"=>"NO"              , "length"=>$l1, "align"=>"C"),
                    array("label"=>"KODERING"        , "length"=>$l2, "align"=>"C"),
                    array("label"=>"URAIAN RETRIBUSI", "length"=>$l3, "align"=>"C"),
                    array("label"=>"JUMLAH"          , "length"=>$l4, "align"=>"C")
                   );
    foreach ($header as $kolom) {
    	$pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], false);
    }
    $pdf->Ln(); 
    if($ni_ret1         == 0) $ni_ret1         = ''; else $ni_ret1         = number_format($ni_ret1,2,",",".")        ;
    if($ni_ret2         == 0) $ni_ret2         = ''; else $ni_ret2         = number_format($ni_ret2,2,",",".")        ;
    if($ni_ret3         == 0) $ni_ret3         = ''; else $ni_ret3         = number_format($ni_ret3,2,",",".")        ;                          
    if($ni_ket_pokok    == 0) $ni_ket_pokok    = ''; else $ni_ket_pokok    = number_format($ni_ket_pokok,2,",",".")   ;     
    if($ni_sanksi_bunga == 0) $ni_sanksi_bunga = ''; else $ni_sanksi_bunga = number_format($ni_sanksi_bunga,2,",",".");   
    if($ni_sanksi_naik  == 0) $ni_sanksi_naik  = ''; else $ni_sanksi_naik  = number_format($ni_sanksi_naik,2,",",".") ;
    if($jumlah          == 0) $jumlah          = ''; else $jumlah          = number_format($jumlah,2,",",".")         ;
    $data = array(array("",$kd_ring, "", ""),
                  array("","", $ur_ret1, $ni_ret1),
                  array("","", $ur_ret2, $ni_ret2),
                  array("","", $ur_ret3, $ni_ret3),
                  array("", "Jumlah Ketetapan Pokok Retribusi", $ni_ket_pokok),
                  array($objek_izin, "Jumlah sanksi : a. bunga ..........", $ni_sanksi_bunga),
                  array("", "                          b. kenaikan ..........", $ni_sanksi_naik),
                  array("", "Jumlah Keseluruhan", $jumlah)
                 );
    $brs=0;$cek=0;
    foreach ($data as $baris) {
    	$i = 0;
    	$pdf->SetXY($x,$pdf->GetY());
    	$status = true;
    	foreach ($baris as $cell) {
    		if($brs < 4){   // lihat array 3 kolom mulai baris ke 
    			if($i == 3){
    		    $pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', 'R', false);
    		  }else{
    		    $pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', 'L', false);
    		  }
    	  }else{
    	  	if($status){
    	  	  $pdf->SetXY($x+$l1+$l2,$pdf->GetY());
    	  	  //$pdf->Cell($header[$i]['length'], 5, $objek_izin, 1, '0', 'L', false);
    	  	  $status = false;
    	  	  $cek++;
    	  	}
    	  	if($i >= 1 ){
    	  		if($i == 2){
    	        $pdf->Cell($header[$i+1]['length'], 5, $cell, 1, '0', 'R', false);
    	      }else{  
    	        $pdf->Cell($header[$i+1]['length'], 5, $cell, 1, '0', 'L', false);
    	      }  
    	    }
    	  }
    		$i++;
    	}
    	$brs++;
    	$pdf->Ln();
    }
    $GetY = $pdf->GetY();
    $cek = 5*$cek;
    $pdf->SetXY($x,$GetY-$cek); $pdf->Cell($l1+$l2, $cek, $objek_izin, 1, '0', 'C', false);
    
    $pdf->SetXY($x,$GetY); $pdf->Cell($w, 5*5, '', 1, '0', 'C', false);
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'Terbilang',0,1,'L');      // Terbilang
                 $pdf->SetXY($x+1+17,$pdf->GetY()); $pdf->Cell(0,0,':',0,1,'L');
                 $pdf->SetXY($x+1+17+2,$pdf->GetY()); $pdf->Cell(0,0,$terbilang,0,1,'L');
    $pdf->Ln(7); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,'PERHATIAN',0,1,'L');      // Perhatian
    $pdf->SetFont('Arial','',9);   // 'U' untuk underline
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,$perhatian1,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,$perhatian2,0,1,'L');
    $pdf->Ln(4); $pdf->SetXY($x+1,$pdf->GetY()); $pdf->Cell(0,0,$perhatian3,0,1,'L');
    $pdf->SetFont('Arial','',10);   // 'U' untuk underline
    
    $GetY = $pdf->GetY();
    $pdf->SetXY($x,$GetY+5); $pdf->Cell($w, 5*8, '', 1, '0', 'C', false);
    $pdf->Ln(4); $pdf->SetXY($x+150,$pdf->GetY()); $pdf->Cell(0,0,'Tasikmalaya, '.$tanggal,0,1,'C');                  // Tanggal
    $pdf->Ln(4); $pdf->SetXY($x+150,$pdf->GetY()); $pdf->Cell(0,0,$jabat1,0,1,'C');      // Perhatian
    $pdf->Ln(4); $pdf->SetXY($x+150,$pdf->GetY()); $pdf->Cell(0,0,$jabat2,0,1,'C');      // Perhatian
    $pdf->Ln(20); $pdf->SetXY($x+150,$pdf->GetY()); $pdf->Cell(0,0,$nm_pejabat,0,1,'C');      // Nama
    $pdf->Ln(4); $pdf->SetXY($x+150,$pdf->GetY()); $pdf->Cell(0,0,'NIP. '.$nip_pejabat,0,1,'C');      // NIP
    
    $pdf->Output('coba.pdf','D');   // tampilkan PDF
  }
  
  public function cetak($id = NULL) {
    // Setting app
    $this->settings = new settings();
    $this->settings->where('name', 'app_folder')->get();
    $app_folder = $this->settings->value . "/";
    $app_city = $this->settings->where('name', 'app_city')->get();
    
    $nama_surat = "kuitansi";
    $this->load->plugin('odf');
    $odf = new odf('assets/odt/' . $nama_surat . '.odt');
    
    $this->permohonan->where('id',$id)->get();
    $this->permohonan->tmpemohon->get();
    $this->permohonan->trperizinan->get();
    $this->permohonan->tmbap->get();

    $ret_manunal = $this->permohonan->tmbap->nilai_retribusi;
    $p_kelurahan = $this->permohonan->tmpemohon->trkelurahan->get();
    $p_kecamatan = $this->permohonan->tmpemohon->trkelurahan->trkecamatan->get();
    $p_kabupaten = $this->permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
    
    $no_daftar = str_replace('/', '', $this->permohonan->pendaftaran_id);
    
    //Cek Tracking Progress
    $updated = FALSE;
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id);
    $sts_awal = new trstspermohonan();
    $sts_awal->get_by_id('12'); //Sudah Membayar [Lihat Tabel trstspermohonan()] | Old Kominfo => 13
    $list_track = $permohonan->tmtrackingperizinan->get();
    if($list_track){
      foreach ($list_track as $data_track){
        $data_status = new tmtrackingperizinan_trstspermohonan();
        $data_status->where('tmtrackingperizinan_id', $data_track->id)
                    ->where('trstspermohonan_id', $sts_awal->id)->get();
        if($data_status->tmtrackingperizinan_id){
          $updated = TRUE;
          break;
        }
      }
    }else{
      $updated = FALSE;
      break;
    }
    
    //membuat kota
    $wilayah = new trkabupaten();
    if($app_city->value !== '0') {
      $alamat = $this->permohonan->tmpemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' .
                $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
      $wilayah->get_by_id($app_city->value);
    }else{
      $alamat = $this->permohonan->tmpemohon->a_pemohon;
    }
    
    $m_hitung = $this->permohonan->trperizinan->trretribusi->m_perhitungan;
                        
    if($m_hitung=="0"){  // Menghitung Otomatis dengan Formula
      if($this->permohonan->tmbap->nilai_bap_awal){
        $retribusi = $this->permohonan->tmbap->nilai_bap_awal;
        $keringanan = $this->permohonan->tmkeringananretribusi->get();
        if($keringanan->id){
          $nilai_ret1 = ($keringanan->v_prosentase_retribusi * 0.01) * $retribusi;
          $nilai_ret = $retribusi-$nilai_ret1;
        }else{
          $nilai_ret = $retribusi;
        }
        $odf->setVars('jumlahretribusi', 'Rp. '.$this->terbilang->nominal($nilai_ret));
        $odf->setVars('bilangan', "Terbilang : ".$this->terbilang->terbilang($nilai_ret) . ' rupiah.');
      }else{
        $odf->setVars('jumlahretribusi', 'Rp. '.$this->terbilang->nominal(0, 2));
        $odf->setVars('bilangan', "Terbilang : ".$this->terbilang->terbilang(0) . ' rupiah.');
      }
    }else{  // Menghitung Manual masukkan nilai total dalam inputan
      $keringanan = $this->permohonan->tmkeringananretribusi->get();
      $nilai = $this->sql_ret($this->permohonan->pendaftaran_id);
      if($nilai){
        if($keringanan->id){
          //hitung manual
          $manRet = $this->sql_ret($this->permohonan->pendaftaran_id);
          $man_diskon = ($keringanan->v_prosentase_retribusi * 0.01) * $manRet->v_tinjauan;
          $nilai_retManual = $manRet->v_tinjauan-$man_diskon;
        }else{
          $manRet = $this->sql_ret($this->permohonan->pendaftaran_id);
          $nilai_retManual = $manRet->v_tinjauan;
        }
        $odf->setVars('jumlahretribusi', 'Rp. '.$this->terbilang->nominal($nilai_retManual));
        $odf->setVars('bilangan', "Terbilang : ".$this->terbilang->terbilang($nilai_retManual) . ' rupiah.');
      }else{
        $odf->setVars('jumlahretribusi', 'Rp. '.$this->terbilang->nominal($ret_manunal, 2));
        $odf->setVars('bilangan', "Terbilang : ".$this->terbilang->terbilang($ret_manunal) . ' rupiah.');
      }
    }
    $tgl_skr = $this->lib_date->get_date_now();
    $odf->setVars('tanggal',$this->lib_date->mysql_to_human($tgl_skr));
    
    //Penomoran Kwitansi
    $no_daftar = $this->permohonan->pendaftaran_id;
    $data_izin = $this->permohonan->trperizinan->id;
    $data_unit = $this->permohonan->trperizinan->trunitkerja->get();
    $unit_kerja = $data_unit->n_unitkerja;
    if($data_izin == 1 || $data_izin == 89){
      $no_rek = "004.111.000422";
      $ayat = "122.023";
    }else if($data_izin == 2 || $data_izin == 3 || $data_izin == 88){
      $no_rek = "004.111.000420";
      $ayat = "122.026";
    }else if($data_izin == 14){
      $no_rek = "004.111.000428";
      $ayat = "122.028";
    }else{
      $no_rek = "";
      $ayat = "";
    }
    $odf->setVars('atas_nama', $unit_kerja);
    $odf->setVars('no_rek', $no_rek);
    $odf->setVars('ayat', $ayat);
    $odf->setVars('nama_izin', $this->permohonan->trperizinan->n_perizinan);
    $odf->setVars('no_daftar', $this->permohonan->pendaftaran_id);
    $odf->setVars('nama', $this->permohonan->tmpemohon->n_pemohon);
    $odf->setVars('alamat', $this->permohonan->tmpemohon->a_pemohon);        
    $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
  }

  public function sql2($u_ser) {
    $query = "select a.description
              from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }
}
// This is the end of kasir class