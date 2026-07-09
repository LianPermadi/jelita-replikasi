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
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '16') {
        $enabled = TRUE;
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

  public function sql($idusr=NULL, $tgla=NULL, $tglb=NULL) {
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