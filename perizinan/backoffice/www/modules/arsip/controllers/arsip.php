<?php

/**
 * Description of Pengarsipan Berkas
 * @author PBS
 * Created : 4 Maret 2012
 */
 
class Arsip extends WRC_AdminCont{
  var $obj;
  /* Variable for generating JSON. */
  var $iTotalRecords;
  var $iTotalDisplayRecords;
  
  /* Variable that taken form input. */
  var $iDisplayStart;
  var $iDisplayLength;
  var $iSortingCols;
  var $sSearch;
  var $sEcho;
  
  public function __construct(){
    parent::__construct();
    $this->load->model("m_arsip");
    $this->load->model("m_akdp");
    $this->sk = new tmsk();
    
    $this->username = new user();
    $this->pendaftaran = new tmpermohonan();
    $this->perizinan = new trperizinan();
    $this->kelompok_izin = new trkelompok_perizinan();
    $this->jenispermohonan = new trjenis_permohonan();
    $this->propinsi = new trpropinsi();
    $this->kabupaten = new trkabupaten();
    $this->kecamatan = new trkecamatan();
    $this->kelurahan = new trkelurahan();
    $this->pemohon = new tmpemohon();
    $this->perusahaan = new tmperusahaan();
    $this->kegiatan = new trkegiatan();
    $this->investasi = new trinvestasi();
    $this->settings = new settings();
    $this->sk = new tmsk();
    $this->status = new trstspermohonan();
    $this->sektor = new trsektor();
    
    $this->file_upload = 'nUpload';
    //$this->load->model('../pelayanan/models/m_ossrba');
    /* Untuk Upload */
    $this->load->helper(array("html", "form", "url", "text"));
    /* EOF() Untuk Upload */
    
    $enabled = TRUE;
    $this->admin = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '18') {
        $this->admin = TRUE;
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index(){  // Masuk Pertama Kali saat klok menu Pengarsipan
    $file_upload = $this->file_upload;
    $query = $this->view_query();
    $mark = $this->input->post('mark');
    $list_sektor = $this->input->post('list_sektor');
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
    $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $file_upload, '', '', '', '', '');   // post variable
    if ($list_sektor == '') $list_sektor = '0';
    $lokasi_user = $this->session->userdata('lokasi');
    $data['lokasi_user'] = $lokasi_user;
    $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
    $data['mark'] = $mark;
    $data['file_upload'] = $file_upload;
    $data['sektor'] = $list_sektor;
    
    if ($lokasi_user === 'Pusat') // Untuk daerah lain
    // if($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar')
      $query .= "";
    else 
      $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
    if($list_sektor != '0')  // Semua Sektor
      $query .= " AND A.trsektor_id = '" . $list_sektor . "'";
    
    $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
    $jum_ijin = $this->db->query($query)->num_rows();
    $jum_arsip = $this->db->query($query . " AND A.desc_arsip != ' '")->num_rows();
    $query .= " order by A.id DESC";
    
    $data['list'] = $query;
    $data['jum_ijin'] = $jum_ijin;
    $data['jum_arsip'] = $jum_arsip;
    $this->load->vars($data);
    $js = "
           function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
          
           $(document).ready(function() {
             oTable = $('#penyerahan').dataTable({
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
             $('.kirimsms').click(function(){               
               $('#smsdialog').dialog({modal: true,title:'Konfirmasi SMS',autoOpen: false,height: 150,width:250,draggable:false,resizable:false});
               $('#smsdialog').dialog('open');
               return false;
             });    
             $('#tblreset').click(function(){
               $('#smsdialog').dialog('close');
             });
           });
          
           function isino(data,isisms) {
             $('#txtno').val(data.toString());
             $('#spanno').text(data.toString());
             $('#txtisi').val(isisms.toString());
             //var url=$(this).attr('href'); 
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Administrasi Pengarsipan Berkas Izin";
    $this->template->build('arsip_list', $this->session_info);
  }
  
  public function list_index(){ // Kembali dari proses pengarsipan
    $query = $this->view_query();
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $list_sektor = $username->gvar3;
    $mark = $username->gvar4;
    $file_upload = $username->gvar5;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    
    $lokasi_user = $this->session->userdata('lokasi');
    $data['lokasi_user'] = $lokasi_user;
    $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
    $data['mark'] = $mark;
    $data['file_upload'] = $file_upload;
    $data['sektor'] = $list_sektor;
    
    if ($lokasi_user === 'Pusat')  // Untuk daerah lain
    // if($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar')
      $query .= "";
    else
      $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
    
    if($list_sektor != '0')  // Semua Sektor
      $query .= " AND A.trsektor_id = '" . $list_sektor . "'";
    $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
    $jum_ijin = $this->db->query($query)->num_rows();
    $jum_arsip = $this->db->query($query . " AND A.desc_arsip != ' '")->num_rows();
    $query .= " order by A.id DESC";
    
    $data['list'] = $query;
    $data['jum_ijin'] = $jum_ijin;
    $data['jum_arsip'] = $jum_arsip;
    $this->load->vars($data);
    
    $js = "
           function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
           
           $(document).ready(function() {
             oTable = $('#penyerahan').dataTable({
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
    $this->session_info['page_name'] = "Administrasi Pengarsipan Berkas Izin ";
    $this->template->build('arsip_list', $this->session_info);
  }
  
  public function edit($edt = NULL, $id_daftar = NULL, $asal_menu = NULL){
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $list_sektor = $username->gvar3;
    $mark = $username->gvar4;
    $menu = $username->gvar10;
    $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $username->gvar6, $username->gvar7, $username->gvar8, $username->gvar9, $menu);   // post variable
    
    $this->username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    $p_pemohon = $u_daftar->tmpemohon->get();
    $p_status = $u_daftar->trstspermohonan->get();
    $p_sk = $u_daftar->tmsk->get();
    $p_bap = $u_daftar->tmbap->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
    $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
    $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    
    // Ambil data dari tabel 'akdp_cetak' berdasarkan pendaftaran_id
    $akdpcetak = $this->db->where('pendaftaran_id', $u_daftar->pendaftaran_id)
                          ->get('akdp_cetak')
                          ->row();
    $tmky = new tmpermohonan_ky();
    $tmky->where('tmpermohonan_id', $id_daftar)->get();
    $usr = new user();
    $usr->where('id', $p_bap->iduser_upload_pertek)->get();
    $iduser_upload_pertek = $usr->oriname;
    if ($iduser_upload_pertek == '') $iduser_upload_pertek = 'N/A';
    
    //Cek data Pengawasan
    $pengawasanjelita = $this->db->where('pendaftaran_id', $u_daftar->pendaftaran_id)
                             ->get('pengawasanjelita')
                             ->row();

if ($pengawasanjelita) {
    // Jika data ditemukan, cari user berdasarkan id_user_dal
    $CrLaporan = $this->db->where('id', $pengawasanjelita->id_user_dal)
                          ->get('user')
                          ->row();

    if ($CrLaporan) {
        // Jika user ditemukan, simpan oriname
        $ccc = $CrLaporan->oriname;
    } else {
        // Jika user tidak ditemukan, beri nilai default
        $ccc = "User tidak ditemukan";
    }
} else {
    // Jika data pengawasan tidak ditemukan
    $ccc = "Data pengawasan tidak ditemukan";
}
// Cek data pemohon portal online
$tmpemohon_portal = $this->db->where('id', $u_daftar->id_pemohon_portal)
                             ->get('tmpemohon_portal')
                             ->row();

if (!$tmpemohon_portal) {
    echo "Data pemohon portal tidak ditemukan untuk ID " . $u_daftar->id_pemohon_portal;
}
    $nib = $tmpemohon_portal->nib; //'8120206941172';//$tmpemohon_portal->nib;
    //EOF() Cek data Pemohon Portal Online
    
    //Ambil data OSS
    $dtoss = "SELECT * FROM oss_persetujuanpermohonan WHERE nib = ?";
    $dtoss = $this->db->query($dtoss, $nib)->result();
    //EOF() Ambil data OSS
    
    $this->tr_instansi = new Tr_instansi();
    $nama_prov = $this->tr_instansi->get_by_id(18);
    $kelurahan_lok = $u_daftar->trkelurahan_id;
    $dkelurahan = $this->kelurahan->get_by_id($kelurahan_lok);
    $lok_kecamatan = $dkelurahan->trkecamatan->get();
    $lok_kabupaten = $dkelurahan->trkecamatan->trkabupaten->get();
    $lok_propinsi  = $dkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    $kelurahan_lok = $dkelurahan->n_kelurahan;
    $kecamatan_lok = $lok_kecamatan->n_kecamatan;
    $kabupaten_lok = $lok_kabupaten->n_kabupaten;
    $propinsi_lok  = $nama_prov->value; //$lok_propinsi->n_propinsi;
    
    $u_perusahaan = $u_daftar->tmperusahaan->get();
    $u_kelurahan = $u_perusahaan->trkelurahan->get();
    $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
    $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
    $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
    $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();
    
    $d_izin = $u_daftar->trperizinan->get();
    $d_kelompok = $d_izin->trkelompok_perizinan->get();
    $d_jenis = $u_daftar->trjenis_permohonan->get();
    
    $no_sk = $p_sk->no_surat_edit;
    $tgl_sk = $p_sk->tgl_surat_edit;
    if($no_sk == "") {
      $no_sk = $p_sk->no_surat;
      $tgl_sk = $p_sk->tgl_surat;
    }
    
    $data = $this->_funcwilayah();
    
    $jml = $this->get_jml_syarat($d_izin->id, 'seri');
    // var_dump($jml);die();
    if($edt == 'E') {
      $data['edit'] = TRUE;
    }else{
      $data['edit'] = FALSE;
    }
    
    if($u_daftar->status_berkas == "proses")
      $n_status = $p_status->n_sts_permohonan;
    else
      $n_status = $u_daftar->status_berkas;
    
    //Start Data Berkas Nirwan
    $p_daftar = $this->pendaftaran->get_by_id($id_daftar);
    $data['daftaronline'] = $p_daftar->kd_gerai;
    $id_portal = $p_daftar->id_pemohon_portal;
    $data['peronline'] = 0;
    if($p_daftar->kd_gerai === 'OnLine') {
      $backoffice = $this->load->database('default', TRUE);
      $otherdb = $this->load->database('otherdb', TRUE);
      $portal = $this->db->query("SELECT * FROM tmpemohon_portal where id = $id_portal")->row_array();
      
      if(!empty($portal['id_permohonan_portal'])) {
        $online = 1;
        $permohonan_portal_trperizinan = $otherdb->get_where("tmpermohonan_portal", array("id" => $portal['id_permohonan_portal']))->first_row();
        $sql = "SELECT A.*, B.tmpermohonan_id, B.nomor_surat, B.tanggal_surat, B.masa_berlaku_surat FROM $backoffice->database.trsyarat_perizinan A 
                LEFT JOIN $otherdb->database.tmpermohonan_trsyarat_perizinan B ON A.id = B.trsyarat_perizinan_id
                WHERE A.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan where trperizinan_id=? and status='1')
                GROUP BY A.id
                ORDER BY (A.urutan * -1) DESC, A.status ASC, A.urutan = 0, A.urutan";
      
        $persyaratan_portal = $this->db->query($sql, $permohonan_portal_trperizinan->id_perizinan)->result();
        $username_portal = $otherdb->get_where("tm_pemohon", array("id" => $portal['id_pemohon']))->first_row();
      
        $sql2 = "SELECT DISTINCT A.id, A.v_syarat, B.tmpermohonan_id, C.nomor_surat, C.tanggal_surat, C.masa_berlaku_surat
                 FROM trsyarat_perizinan A
                 LEFT JOIN tmpermohonan_trsyarat_perizinan B ON A.id = B.trsyarat_perizinan_id
                 LEFT JOIN $otherdb->database.tmpermohonan_trsyarat_perizinan C ON B.tmpermohonan_id = C.tmpermohonan_id
                 WHERE B.tmpermohonan_id = ?
                 GROUP BY A.id";
        $old_persyaratan = $this->db->query($sql2, $u_daftar->id)->result();
      
        $data['old_persyaratan'] = $old_persyaratan;
        $data["persyaratan"] = $persyaratan_portal;
        $data["id_portal"] = $portal['id_permohonan_portal'];
        $data["username_portal"] = $username_portal->username;
        $data['peronline'] = 1;
      
        $asistensi = "";
        $otherdb->order_by("id", "asc");
        $asistensi = $otherdb->get_where("asistensi", array("id_permohonan" => $portal['id_permohonan_portal']))->result();
        $data["asistensi"] = $asistensi;
      }
    }
    //End Data Berkas Nirwan
  
    //Data Survey Nirwan
    $sqlsurvey = "SELECT A.*, F.n_pegawai
                  FROM survei_perijinan_gambar A
                  INNER JOIN survei_perijinan B ON A.survei_id = B.kode
                  INNER JOIN tmpermohonan C ON B.permohonan_id = C.id
                  INNER JOIN user D ON A.petugas_id = D.id
                  INNER JOIN tmpegawai_user E ON D.id = E.user_id
                  INNER JOIN tmpegawai F ON E.tmpegawai_id = F.id
                  WHERE C.id = ?";
    $data_survey = $this->db->query($sqlsurvey, $u_daftar->id)->result();
    $data['data_survey'] = $data_survey;
    //End Data Survey Nirwan
  
    $data['admin'] = $this->admin;
    $data['asal_menu'] = $asal_menu;
    $data['jml_syarat'] = 0; //$jml->jml;
    $data['group'] = $this->username->group;
    $data['izin'] = "";
    $data['eror'] = "";
    $data['save_method'] = "update";
    $data['id_daftar'] = $id_daftar;
    $data['paralel'] = "no";
    $paralel_jenis = new trparalel();
    $data['mohon'] = "";
    $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['no_refer'] = $p_pemohon->no_referensi;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['no_telp'] = $p_pemohon->telp_pemohon;
    $data['cmbsource'] = $p_pemohon->source;
    $data['check_ctr'] = $p_pemohon->cek_prop;
    $data['propinsi_pemohon'] = $p_propinsi->n_propinsi;
    $data['kabupaten_pemohon'] = $p_kabupaten->n_kabupaten;
    $data['kecamatan_pemohon'] = $p_kecamatan->n_kecamatan;
    $data['kelurahan_pemohon'] = $p_kelurahan->n_kelurahan;
  
    $data['propinsi_lok']  = $propinsi_lok;
    $data['kabupaten_lok'] = $kabupaten_lok;
    $data['kecamatan_lok'] = $kecamatan_lok;
    $data['kelurahan_lok'] = $kelurahan_lok;
  
    $data['n_status'] = $n_status;
  
    $data['jenis_kegiatan'] = $u_kegiatan->n_kegiatan;
    $data['jenis_investasi'] = $u_investasi->n_investasi;
    $data['propinsi_usaha'] = $u_propinsi->n_propinsi;
    $data['kabupaten_usaha'] = $u_kabupaten->n_kabupaten;
    $data['kecamatan_usaha'] = $u_kecamatan->n_kecamatan;
    $data['kelurahan_usaha'] = $u_kelurahan->n_kelurahan;
  
    $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
    $data['tgl_daftar_asli'] = $u_daftar->d_terima_berkas_asli;
    $data['tgl_survey'] = $u_daftar->d_survey;
    $data['lokasi_izin'] = $u_daftar->a_izin;
    $data['rincian_lokasi'] = "";
    $data['keterangan'] = $u_daftar->keterangan;
    $data['cmbgerai'] = $u_daftar->kd_gerai;
    $data['no_antri'] = $u_daftar->no_antri;
    $data['kd_kontak'] = $u_daftar->kontak_person;
    $data['val_combo_syarat'] = $u_daftar->syarat_arsip;
    $data['val_combo_asli'] = $u_daftar->arsip_asli;
    $data['val_combo_asli_lain'] = $u_daftar->arsip_asli_lain;
    $data['syarat_arsip_lain'] = $u_daftar->syarat_arsip_lain;
    $data['ket_syarat_arsip'] = $u_daftar->ket_syarat_arsip;
    $data['ket_syarat_arsip_lain'] = $u_daftar->ket_syarat_arsip_lain;
    $data['desc_arsip'] = $u_daftar->desc_arsip;
    $data['approve'] = $u_daftar->approve;
    $data['kyStafOPD'] = $tmky->kyStafOPD;
    if(!empty($akdpcetak)){
      if($akdpcetak->pendaftaran_id == '') { //Non AKDP
        $data['tglstaf'] = $tmky->tg_kyStafPTSP;
        $data['ketstaf'] = $tmky->ket_ptsp;
        $data['namstaf'] = $this->m_arsip->get_pegawai($tmky->id_pengguna_ptsp);
        $data['tglesl4'] = $tmky->tg_kyEsl4PTSP;
        $data['ketesl4'] = $tmky->ket_esl4_ptsp;
        $data['namesl4'] = $this->m_arsip->get_pegawai($tmky->id_pengguna_esl4_ptsp);
        $data['tglesl3'] = $tmky->tg_kyEsl3PTSP;
        $data['ketesl3'] = $tmky->ket_esl3_ptsp;
        $data['namesl3'] = $this->m_arsip->get_pegawai($tmky->id_pengguna_esl3_ptsp);
        $data['tglesl2'] = $tmky->tg_kyKaPTSP;
        $data['ketesl2'] = '-';
        $data['namesl2'] = '-';
      }else{                                 // AKDP
        $data['tglstaf'] = $akdpcetak->tg_kyStafPTSP;
        $data['ketstaf'] = '-';
        $data['namstaf'] = '-';
        $data['tglesl4'] = $akdpcetak->tg_kyEsl4PTSP;
        $data['ketesl4'] = '-';
        $data['namesl4'] = '-';
        $data['tglesl3'] = $akdpcetak->tg_kyEsl3PTSP;
        $data['ketesl3'] = '-';
        $data['namesl3'] = '-';
        $data['tglesl2'] = $akdpcetak->tg_kyKaPTSP;
        $data['ketesl2'] = '-';
        $data['namesl2'] = '-';
      }
    }else{                                 // AKDP
        $data['tglstaf'] = '-';
        $data['ketstaf'] = '-';
        $data['namstaf'] = '-';
        $data['tglesl4'] = '-';
        $data['ketesl4'] = '-';
        $data['namesl4'] = '-';
        $data['tglesl3'] = '-';
        $data['ketesl3'] = '-';
        $data['namesl3'] = '-';
        $data['tglesl2'] = '-';
        $data['ketesl2'] = '-';
        $data['namesl2'] = '-';
    }
    $data['nama_file'] = $u_daftar->nama_file;
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
    $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
    $data['id_perusahaan'] = $u_perusahaan->id;
    $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
    $data['npwp'] = $u_perusahaan->npwp;
    $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
    $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
    $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
    $data['fax'] = $u_perusahaan->fax;
    $data['email'] = $u_perusahaan->email;
    $data['rt'] = $u_perusahaan->rt;
    $data['rw'] = $u_perusahaan->rw;
    $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
    $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
    $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
    $data['lokasi_user'] = $lokasi_user;
    $data['id_sk'] = $p_sk->id;
    $data['c_cetak'] = $p_sk->c_cetak;
    $data['id_user_cetak'] = $p_sk->id_user_cetak;
    $data['no_sk'] = $no_sk;
    $data['tgl_sk'] = $tgl_sk;
    $data['tgl_up_pertek'] = $p_bap->tgl_upload_pertek;
    $data['petugas_upload'] = $iduser_upload_pertek;
  
    $syarat_perizinan = new trsyarat_perizinan();
    $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
    $data['list_daftar'] = $u_daftar;
    $data['statusOnline'] = 0;
  
    $data['statusOnline2'] = 0;
  
    //$data['daftar'] = $u_daftar;    -> list_daftar
    $data['list_tr'] = $this->status->get();
    $data['list_tracking'] = $u_daftar->tmtrackingperizinan->order_by('id', 'DESC')->get();
    $data['pengawasanjelita'] = $pengawasanjelita;
    $data['oriname'] = $ccc;
    $data['nib'] = $nib;
    $data['dtoss'] = $dtoss;
    
    // Data Informasi Pencabutan
    $data['c_izin_dicabut'] = $u_daftar->c_izin_dicabut;
    $data['id_lama'] = $u_daftar->id_lama;
    $data['d_ajuan_cabut'] = $u_daftar->d_ajuan_cabut;
    $data['d_izin_dicabut'] = $u_daftar->d_izin_dicabut;
    $data['ket_cabut'] = $u_daftar->ket_cabut;
    // EOF() Data Informasi Pencabutan
    
    // var_dump($data['list_tr']);die();
  
    //<!-- Upload Area -->
    //$data["judulapp"]="Upload Dokumen Izin";
    //$data["scriptaksi"]="arsip/arsip/uploadfile";
    //$data["aksi"]="Upload";
    //$data["error"]=(isset($data["error"]))?$data["error"]:"";
    //$viewfile="v_cupload_form";
    //$this->load->view($viewfile,$data);
    //<!-- Upload Area -->
  
    $js = "
          function confirm_link(text){
            if(confirm(text)){ return true;
              }else{ return false; }
            }
  
            function copyLink() {
              /* Get the text field */
              var copyText = document.getElementById('copy');
  
              /* Select the text field */
              copyText.select();
  
              /* Copy the text inside the text field */
              if(document.execCommand('copy')){
                  /* Alert the copied text */
                  alert('Meng-Copy: ' + copyText.value);
                } else {
                  alert('gagal');
                }
              }
  
              function copyLinkDocx() {
              /* Get the text field */
              var copyText = document.getElementById('copydocx');
  
              /* Select the text field */
              copyText.select();
  
              /* Copy the text inside the text field */
              if(document.execCommand('copy')){
                  /* Alert the copied text */
                  alert('Meng-Copy: ' + copyText.value);
                } else {
                  alert('gagal');
                }
              }
  
            $(document).ready(function() {
              oTable = $('#trackingdetail').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                       });
            } );
            
            $(document).ready(function() {
                      oTable = $('#izinlaindioss').dataTable({
                              \"bJQueryUI\": true,
                              \"sPaginationType\": \"full_numbers\"
                      });
  
              });
  
           $(document).ready(function() {
             $('#form').validate();
             $(\"#tabs\").tabs();
             $('a[rel*=upload_box]').facebox();
           } );
  
           $(function() {
             $(\"#inputTanggal1\").datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
             $(\"#inputTanggal2\").datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
             $(\".monbulan\").datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });
  
           $(document).ready(function() {
             $('#propinsi_pemohon_id').change(function(){
               $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                 function(data) {
                   $('#show_kabupaten_pemohon').html(data);
                   $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                   $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                 }
               );
             }); 
           });
  
           $(document).ready(function() {
             $('#propinsi_usaha_id').change(function(){
               $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                 function(data) {
                   $('#show_kabupaten_usaha').html(data);
                   $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                   $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                 }
               );
             });
           });
  
  
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
  
           function Check(){
             if(document.form.Check_ctr.checked == true){
               document.form.propinsi_pemohon.disabled = false ;
               document.form.kabupaten_pemohon.disabled = false ;
               document.form.kecamatan_pemohon.disabled = false ;
               document.form.kelurahan_pemohon.disabled = false ;
             }else{
               document.form.propinsi_pemohon.disabled = true ;
               document.form.kabupaten_pemohon.disabled = true ;
               document.form.kecamatan_pemohon.disabled = true ;
               document.form.kelurahan_pemohon.disabled = true ;
             }
           }
          ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    if($edt == 'E')
      $this->session_info['page_name'] = "Edit Data Arsip";
    else
      $this->session_info['page_name'] = "Informasi Data Detail";
    $this->template->build('arsip_edit', $this->session_info);
  }
  
  public function download_pdf($nodaftar = NULL){  // Download file ber ttE BSrE
    $file = str_replace(' ', '', 'SK_' . $nodaftar);
    $lok_esign = 'assets/esignfile/';
    if(file_exists($lok_esign . $file . '.pdf')) {        // cek PDF yang sudah SE
    	//merekam user yang mendownolad izin
    	$permohonan = new tmpermohonan();
      $permohonan->where('pendaftaran_id', $nodaftar)->get();
      $surat_awal = $permohonan->tmsk->get();
      $user_cetak = $surat_awal->id_user_cetak;
    	if($user_cetak == NULL){
    	  $user_cetak = $this->session->userdata('id_auth');
    	}else{
    	  $user_cetak = $user_cetak.','.$this->session->userdata('id_auth');
    	}
      $sk = new tmsk();
      $sk->get_by_id($surat_awal->id);
      $sk->c_cetak = $surat_awal->c_cetak + 1;
      $sk->id_user_cetak = $user_cetak;
      $sk->save();    // khusus cetak SK
      //EOF() merekam user yang mendownolad Naskah izin
      $data = file_get_contents($lok_esign . $file . '.pdf');
      force_download($file . '.pdf', $data);
    }
  }
  
  public function download_pertek($nodaftar = NULL){  // Download file ber ttE BSrE
    $file = str_replace(' ', '', 'PT_' . $nodaftar);
    $lok_esign = 'assets/pertekSE/';
    $lok_pt = 'assets/pertek/';
    if(file_exists($lok_esign . $file . '.pdf')) {        // cek PDF yang sudah SE
      $data = file_get_contents($lok_esign . $file . '.pdf');
      force_download($file . '.pdf', $data);
    }else{
      $data = file_get_contents($lok_pt . $file . '.pdf');
      force_download($file . '.pdf', $data);
    }
  }
  
  public function info_detail($id_daftar = NULL){
    $this->username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    $p_pemohon = $u_daftar->tmpemohon->get();
    $p_sk = $u_daftar->tmsk->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
    $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
    $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    
    $u_perusahaan = $u_daftar->tmperusahaan->get();
    $u_kelurahan = $u_perusahaan->trkelurahan->get();
    $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
    $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
    $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
    $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();
    
    $d_izin = $u_daftar->trperizinan->get();
    $d_kelompok = $d_izin->trkelompok_perizinan->get();
    $d_jenis = $u_daftar->trjenis_permohonan->get();
    
    $no_sk = $p_sk->no_surat_edit;
    $tgl_sk = $p_sk->tgl_surat_edit;
    if($no_sk == "") {
      $no_sk = $p_sk->no_surat;
      $tgl_sk = $p_sk->tgl_surat;
    }
  
    $data = $this->_funcwilayah();
  
    $jml = $this->get_jml_syarat($d_izin->id, 'seri');
    $data['jml_syarat'] = 0; //$jml->jml;
    $data['group'] = $this->username->group;
    $data['izin'] = "";
    $data['eror'] = "";
    $data['save_method'] = "update";
    $data['id_daftar'] = $id_daftar;
    $data['paralel'] = "no";
    $paralel_jenis = new trparalel();
    $data['mohon'] = "";
    $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['no_refer'] = $p_pemohon->no_referensi;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['no_telp'] = $p_pemohon->telp_pemohon;
    $data['cmbsource'] = $p_pemohon->source;
    $data['check_ctr'] = $p_pemohon->cek_prop;
    $data['propinsi_pemohon'] = $p_propinsi->id;
    $data['kabupaten_pemohon'] = $p_kabupaten->id;
    $data['kecamatan_pemohon'] = $p_kecamatan->id;
    $data['kelurahan_pemohon'] = $p_kelurahan->id;
  
    $data['jenis_kegiatan'] = $u_kegiatan->id;
    $data['jenis_investasi'] = $u_investasi->id;
    $data['propinsi_usaha'] = $u_propinsi->id;
    $data['kabupaten_usaha'] = $u_kabupaten->id;
    $data['kecamatan_usaha'] = $u_kecamatan->id;
    $data['kelurahan_usaha'] = $u_kelurahan->id;
  
    $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
    $data['tgl_survey'] = $u_daftar->d_survey;
    $data['lokasi_izin'] = $u_daftar->a_izin;
    $data['rincian_lokasi'] = "";
    $data['keterangan'] = $u_daftar->keterangan;
    $data['cmbgerai'] = $u_daftar->kd_gerai;
    $data['no_antri'] = $u_daftar->no_antri;
    $data['kd_kontak'] = $u_daftar->kontak_person;
    $data['val_combo_syarat'] = $u_daftar->syarat_arsip;
    $data['val_combo_asli'] = $u_daftar->arsip_asli;
    $data['val_combo_asli_lain'] = $u_daftar->arsip_asli_lain;
    $data['syarat_arsip_lain'] = $u_daftar->syarat_arsip_lain;
    $data['ket_syarat_arsip'] = $u_daftar->ket_syarat_arsip;
    $data['ket_syarat_arsip_lain'] = $u_daftar->ket_syarat_arsip_lain;
    $data['desc_arsip'] = $u_daftar->desc_arsip;
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
    $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
  
    $data['id_perusahaan'] = $u_perusahaan->id;
    $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
    $data['npwp'] = $u_perusahaan->npwp;
    $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
    $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
    $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
    $data['fax'] = $u_perusahaan->fax;
    $data['email'] = $u_perusahaan->email;
    $data['rt'] = $u_perusahaan->rt;
    $data['rw'] = $u_perusahaan->rw;
    $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
    $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
    $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
    $data['lokasi_user'] = $lokasi_user;
    $data['no_sk'] = $no_sk;
    $data['tgl_sk'] = $tgl_sk;
  
    $syarat_perizinan = new trsyarat_perizinan();
    $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
    $data['list_daftar'] = $u_daftar;
    $data['statusOnline'] = 0;
  
    $data['statusOnline2'] = 0;
  
    $js = "
         $(document).ready(function() {
           $('#form').validate();
           $(\"#tabs\").tabs();
         });
         
         $(function() {
           $(\"#inputTanggal1\").datepicker({
             changeMonth: true,
             changeYear: true,
             dateFormat: 'yy-mm-dd',
             closeText: 'X'
           });
           $(\"#inputTanggal2\").datepicker({
             changeMonth: true,
             changeYear: true,
             dateFormat: 'yy-mm-dd',
             closeText: 'X'
           });
         });
  
         $(document).ready(function() {
           $('#propinsi_pemohon_id').change(function(){
             $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
               function(data) {
                 $('#show_kabupaten_pemohon').html(data);
                 $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                 $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
               });
             }); 
         });
         
         $(document).ready(function() {
           $('#propinsi_usaha_id').change(function(){
             $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
             function(data) {
               $('#show_kabupaten_usaha').html(data);
               $('#show_kecamatan_usaha').html('Data Tidak tersedia');
               $('#show_kelurahan_usaha').html('Data Tidak tersedia');
             });
           });
         });
  
         function finishAjax(id, response){
           $('#'+id).html(unescape(response));
           $('#'+id).fadeIn();
         }
         
         function Check(){
           if(document.form.Check_ctr.checked == true){
             document.form.propinsi_pemohon.disabled = false ;
             document.form.kabupaten_pemohon.disabled = false ;
             document.form.kecamatan_pemohon.disabled = false ;
             document.form.kelurahan_pemohon.disabled = false ;
           }else{
             document.form.propinsi_pemohon.disabled = true ;
             document.form.kabupaten_pemohon.disabled = true ;
             document.form.kecamatan_pemohon.disabled = true ;
             document.form.kelurahan_pemohon.disabled = true ;
           }
         }
        ";
  
    $this->template->set_metadata_javascript($js);
  
    $this->load->vars($data);
    $this->session_info['page_name'] = "Detail Data Permohonan";
    $this->template->build('arsip_detail', $this->session_info);
  }
  
  function _funcwilayah(){
    $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
    $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
    $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
    $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();
    $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
    $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();
    return $data;
  }
  
  function get_jml_syarat($id, $jenis){
    if($id == NULL){
      redirect('pelayanan/pendaftaran');
    }else{
      $dum = $this->get_perizinan_baru($id, $jenis);
      if($jenis == 'paralel'){
        $query = "SELECT COUNT(DISTINCT trsyarat_perizinan.id) as jml FROM trperizinan_trsyarat_perizinan
                  INNER JOIN trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                  INNER JOIN trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                  WHERE trsyarat_perizinan.`status` = '1' and trperizinan.id IN ($id) and c_show_type IN ('" . implode("','", $dum) . "')";
      }else{
        $query = "SELECT COUNT(*) as jml FROM trperizinan_trsyarat_perizinan
                  INNER JOIN trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                  INNER JOIN trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                  WHERE trsyarat_perizinan.`status` = '1' and trperizinan.id = " . $id . " and c_show_type IN ('" . implode("','", $dum) . "')
                  GROUP BY n_perizinan";
      }
      $hasil = $this->db->query($query);
      return $hasil->row();
    }
  }

  function get_perizinan_baru($id, $jenis){
    if($jenis == 'paralel'){
      $sql = "SELECT DISTINCT c_show_type,status_new FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id IN ($id)";
    }else{
      $sql = "SELECT DISTINCT c_show_type,status_new FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id = '$id'";
    }
    $hasil = $this->db->query($sql);
    $result = $hasil->result();
    $arr = array();
    foreach ($result as $row) {
      $var = $row->c_show_type;
      //$rule = strval(decbin($var));
      //if (strlen($rule) < 4) {
      //    $len = 4 - strlen($rule);
      //    $rule = str_repeat("0", $len) . $rule;
      //}
      //$arr_rule = str_split($rule);
      //$c_baru = $arr_rule[1];
      
      $rule = strval(decbin($var));
      if($row->status_new == 1)
        $plv = 6;
      else
        $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
      if(strlen($rule) < $plv){
        $len = $plv - strlen($rule);
        $rule = str_repeat("0", $len) . $rule;
      }
      if($plv == 4) $rule = $rule . '00';                         // penambahan pencabutan dan penutupan ditambah 00
      $arr_rule = str_split($rule);
      if($plv == 4){
        $c_baru         = $arr_rule[1];
        $c_daftar_ulang = $arr_rule[0];
      }else{
        $c_baru         = $arr_rule[0];
        $c_daftar_ulang = $arr_rule[1];
      }
      $c_perpanjangan = $arr_rule[2];
      $c_ubah         = $arr_rule[3];
      $c_pencabutan   = $arr_rule[4];
      $c_penutupan    = $arr_rule[5];
      
      if($arr_rule[1] == '1') {
        $arr[] = $var;
      }
    }
    return $arr;
  }
  
  public function save(){
    //echo $this->input->post('jenis_izin_id'); die;
    $u_ser = $this->session->userdata('username');
    $r_name = $this->lib_date->get_nama_ori($u_ser);
    $syarat = $this->input->post('pemohon_syarat');
    // var_dump($syarat);die();
    $syarat_len = count($syarat);
    $is_array = NULL;
    $kd_lampiran = '';
    for($i = 0; $i < $syarat_len; $i++){
      if($is_array !== $syarat[$i]){
        if($i == 0)
          $kd_lampiran = $syarat[$i];
        else
          $kd_lampiran = $kd_lampiran . '^' . $syarat[$i];
      }
      $is_array = $syarat[$i];
    }
    
    $syarat = $this->input->post('keaslian_syarat_wajib');
    $syarat_len = count($syarat);
    $is_array = NULL;
    $kd_asli_wajib = '';
    for($i = 0; $i < $syarat_len; $i++){
      if($is_array !== $syarat[$i]){
        if($i == 0)
          $kd_asli_wajib = $syarat[$i];
        else
          $kd_asli_wajib = $kd_asli_wajib . '^' . $syarat[$i];
      }
      $is_array = $syarat[$i];
    }
    $syarat = $this->input->post('keaslian_syarat_lainnya');
    $syarat_len = count($syarat);
    $is_array = NULL;
    $kd_asli_lain = '';
    for($i = 0; $i < $syarat_len; $i++){
      if($is_array !== $syarat[$i]) {
        if($i == 0)
          $kd_asli_lain = $syarat[$i];
        else
          $kd_asli_lain = $kd_asli_lain . '^' . $syarat[$i];
      }
      $is_array = $syarat[$i];
    }
    
    $syarat_len = $this->input->post('jumlah_syarat');
    $kd_ket_wajib = '';
    for($i = 0; $i < $syarat_len; $i++){
      $ket_wajib = 'ket_wajib' . strval($i + 1);
      $isi_ket_wajib = $this->input->post($ket_wajib);
      if($isi_ket_wajib == '') $isi_ket_wajib = '-';
      $ket_id = 'id_wajib' . strval($i + 1);
      if($i == 0)
        $kd_ket_wajib = $this->input->post($ket_id) . ';' . $isi_ket_wajib;
      else
        $kd_ket_wajib = $kd_ket_wajib . '^' . $this->input->post($ket_id) . ';' . $isi_ket_wajib;
    }
    
    $syarat1 = $this->input->post('syarat1');
    if($syarat1 == '') $syarat1 = '-';
    $syarat2 = $this->input->post('syarat2');
    if($syarat2 == '') $syarat2 = '-';
    $syarat3 = $this->input->post('syarat3');
    if($syarat3 == '') $syarat3 = '-';
    $syarat4 = $this->input->post('syarat4');
    if($syarat4 == '') $syarat4 = '-';
    $syarat5 = $this->input->post('syarat5');
    if($syarat5 == '') $syarat5 = '-';
    $syarat_lain = $syarat1 . '^' . $syarat2 . '^' . $syarat3 . '^' . $syarat4 . '^' . $syarat5;
    
    $ket_lain1 = $this->input->post('ket_lain1');
    if($ket_lain1 == '') $ket_lain1 = '-';
    $ket_lain2 = $this->input->post('ket_lain2');
    if($ket_lain2 == '') $ket_lain2 = '-';
    $ket_lain3 = $this->input->post('ket_lain3');
    if($ket_lain3 == '') $ket_lain3 = '-';
    $ket_lain4 = $this->input->post('ket_lain4');
    if($ket_lain4 == '') $ket_lain4 = '-';
    $ket_lain5 = $this->input->post('ket_lain5');
    if($ket_lain5 == '') $ket_lain5 = '-';
    $ket_lain = $ket_lain1 . '^' . $ket_lain2 . '^' . $ket_lain3 . '^' . $ket_lain4 . '^' . $ket_lain5;
    
    $tahun  = $this->input->post('tahun');
    if($tahun  == '') $tahun  = '-';
    $jumlah = $this->input->post('jumlah');
    if($jumlah == '') $jumlah = '-';
    $sampul = $this->input->post('sampul');
    if($sampul == '') $sampul = '-';
    $box    = $this->input->post('box');
    if($box    == '') $box    = '-';
    $rak    = $this->input->post('rak');
    if($rak    == '') $rak    = '-';
    $desc_arsip = $tahun . '^' . $jumlah . '^' . $sampul . '^' . $box . '^' . $rak;
    
    $id_daftar = $this->input->post('id_daftar');
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_daftar);
    $no_pendaftaran = $permohonan->pendaftaran_id;
    $permohonan->syarat_arsip = $kd_lampiran;        // simpan u/ persyaratan izin wajib dan tidak wajib (dlm syarat perizinan) ada atau tidak
    $permohonan->arsip_asli = $kd_asli_wajib;        // simpan u/ keaslian persyaratan izin wajib dan tidak wajib (dlm syarat perizinan) ada atau tidak
    $permohonan->syarat_arsip_lain = $syarat_lain;   // simpan u/ persyaratan lainnya
    $permohonan->arsip_asli_lain = $kd_asli_lain;    // simpan u/ keaslian persyaratan izin lainnya ada atau tidak
    $permohonan->ket_syarat_arsip = $kd_ket_wajib;   // simpan u/ keterangan persyaratan wajib
    $permohonan->ket_syarat_arsip_lain = $ket_lain;  // simpan u/ keterangan persyaratan lainnya
    $permohonan->desc_arsip = $desc_arsip;           // simpan u/ identitas arsip tahun^jumlah^sampul^box^rak
    $permohonan->save();
    
    /* Input Data Tracking Progress */
    $tracking_izin = new tmtrackingperizinan();
    $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                  ->where('tr_activiti', 'Arsip')->get();
    if($tracking_izin->pendaftaran_id) {
      $tracking_izin->status = 'Update';
      $tracking_izin->d_entry = $this->lib_date->get_date_now();
      $tracking_izin->tr_user = $u_ser;
      $tracking_izin->tr_name = $r_name;
      $hit_ubah = $tracking_izin->hit_ubah + 1;
      $his_ubah = $tracking_izin->his_ubah;
      $tracking_izin->hit_ubah = $hit_ubah;
      $tracking_izin->his_ubah = $his_ubah . 'ARSIP^' . $r_name . '^' . $this->lib_date->get_date_now() . ';';
      $tracking_izin->save();             // hanya edit di tracking_izin
    }
    
    //simpan untuk data property di pengarsipan...
    //input data properti
    $id_izin = $this->input->post('jenis_izin_id');
    $jumlah = $this->lib_date->data_property($id_izin, '1');
    $i = 1;
    while ($i <= $jumlah){
      //$id_daftar = $this->input->post('id_daftar');
      $data_property = $this->lib_date->isi_property($id_daftar, $i, '1');
      $permohonan = new tmpermohonan();
      $permohonan->where('id', $id_daftar);
      
      $hitung = strlen($data_property);
      $cek_posisi = strpos($data_property, '^');
      $data_property = substr($data_property, 0, $cek_posisi);
      
      $nama_fild = 'dt_teknis' . $i;
      $isi_fild = $data_property . '^' . $this->input->post('vdt_teknis' . $i);
      $permohonan->update($nama_fild, $isi_fild);
      $i++;
      $nama_fild = '';
      $isi_fild = '';
    }
    
    //input data no dan tanggal surat
    $id_sk = $this->input->post('id_sk');
    $tmsk = new tmsk();
    $tmsk->where('id', $id_sk)->get();
    if($tmsk->id) {
      $tmsk->no_surat_edit = $this->input->post('no_sk');
      $tmsk->tgl_surat_edit = $this->input->post('tgl_sk');
      $tmsk->save();
    }
    //EOF()simpan untuk data property di pengarsipan...
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql($u_ser);
    $p = $this->db->query("call log ('Pengarsipan','Update " . $no_pendaftaran . "','" . $tgl . "','" . $u_ser . "')");
    redirect('arsip/arsip/list_index');
  }

  public function proses_upload(){
    echo "Masuk ke fungsi";
    $uploads = $_FILES['file_upload']['name'];
    if(!empty($uploads)) {
      $configs['overwrite'] = FALSE;
      $config['upload_path'] = './uploads/lampiran/';
      $config['allowed_types'] = 'pdf|png|jpg|jpeg';
      $config['max_size'] = '1000';
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $field = 'file_upload';
      if(!$this->upload->do_upload($field)) {
        $uploaded = $this->upload->data();
        $file = $uploaded['file_name'];
        //$data2['lampiran'] = base_url() . 'uploads/lampiran/' . $file;  //untuk menyimpan nama file
      }
    }
  }

  public function cetak_arsip(){
    $query = $this->view_query();
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $list_sektor = $username->gvar3;
    $mark = $username->gvar4;
    $lokasi_user = $this->session->userdata('lokasi');
    
    if ($lokasi_user === 'Pusat')  // Untuk daerah lain
    // if($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar')
      $query .= "";
    else
      $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
    
    if($list_sektor == '0') {  // Semua Sektor
      $bidang = "SEMUA SEKTOR";
    }else{
      $query .= " AND A.trsektor_id = '" . $list_sektor . "'";
      $sektor = new trsektor();
      $bidang = $sektor->get_by_id($list_sektor)->n_sektor;
    }
    $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
    $query .= " order by A.id DESC";
    
    $obj = $this->db->query($query)->result();
    
    $i = 0;
    $jumlah = 0;
    $hal = 1;
    $gt_hal = TRUE;
    foreach($obj as $row){
      $jumlah++;
      if($gt_hal){
        $gt_hal = FALSE;
        $file = 'data_arsip' . $hal . '.xls';
        $hal++;
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $file);
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "<table width='100%' border='0' font-size:16px;'>";
        echo "<tr>DAFTAR ARSIP PERIZINAN BIDANG : " . $bidang . "</tr>";
        echo "<tr>PERIODE : " . $this->lib_date->mysql_to_human($tgla) . " - " . $this->lib_date->mysql_to_human($tglb) . "</tr>";
        echo "</table>";
        echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
        echo "<tr>
                <td>" . 'NOMOR' . "</td>
                <td>" . 'NOMOR PENDAFTARAN' . "</td>
                <td>" . 'JENIS PERMOHONAN' . "</td>
                <td>" . 'TANGGAL DAFTAR' . "</td>
                <td>" . 'NAMA PEMOHON' . "</td>
                <td>" . 'TANGGAL SELESAI' . "</td>
                <td>" . 'NOMOR SK' . "</td>
                <td>" . 'KELENGKAPAN PERSYARATAN' . "</td>
                <td>" . 'TAHUN' . "</td>
                <td>" . 'JUMLAH' . "</td>
                <td>" . 'SAMPUL' . "</td>
                <td>" . 'BOX' . "</td>
                <td>" . 'RAK' . "</td>
                <td>" . 'KETERANGAN' . "</td>
              </tr>";
        echo "</table>";
      }
      
      if($row->desc_arsip != ''){
        $i++;
        $jumlah++;
        $tgl_selesai = $row->tgl_surat_edit;
        if($tgl_selesai == "0000-00-00") $tgl_selesai = $row->tgl_surat;
        $no_surat = $row->no_surat_edit;
        if($no_surat == "") $no_surat = $row->no_surat;
        
        $dt_izin = new trperizinan();
        $id_izin = $dt_izin->get_by_id($row->idizin);
        $syarat_perizinan = new trsyarat_perizinan();
        $syarat_izin = $syarat_perizinan->where_related($dt_izin)->order_by('status', 'asc')->get();
        
        // Ambil Nilai Keterangan Arsip (tahun,jumlah,sampul,box,rak)
        $val_ket_arsip = $row->desc_arsip;
        $tahun = '-';
        $jumlah = '-';
        $sampul = '-';
        $box = '-';
        $rak = '-';
        if($val_ket_arsip){
          $hitung = strlen($val_ket_arsip);
          $cek_posisi = strpos($val_ket_arsip, '^');
          $a = 1;
          while($a < 50){
            $item_arsip = substr($val_ket_arsip, 0, $cek_posisi);
            $val_ket_arsip = substr($val_ket_arsip, $cek_posisi + 1, $hitung);
            $hitung = strlen($val_ket_arsip);
            $cek_posisi = strpos($val_ket_arsip, '^');
            if($a == 1){
              $opsi_koefisien = array($item_arsip => $item_arsip);
            }else{
              $tempArray = array($item_arsip => $item_arsip);
              $opsi_koefisien = array_merge($opsi_koefisien, $tempArray);
            }
            if($cek_posisi == ""){
              $a = $a + 1;
              $tempArray = array($val_ket_arsip => $val_ket_arsip);
              $opsi_koefisien = array_merge($opsi_koefisien, $tempArray);
              $a = 51;
            }
            $a = $a + 1;
          }
          $a = 1;
          foreach($opsi_koefisien as $cek_ket_arsip){
            if($a == 1) $tahun = $cek_ket_arsip;
            if($a == 2) $jumlah = $cek_ket_arsip;
            if($a == 3) $sampul = $cek_ket_arsip;
            if($a == 4) $box = $cek_ket_arsip;
            if($a == 5) $rak = $cek_ket_arsip;
            $a++;
          }
        }
        
        // merubah data menjadi array keaslian syarat wajib
        $val_combo_asli = $row->arsip_asli;
        if($val_combo_asli){
          $cek_val_combo_asli = TRUE;
          $hitung = strlen($val_combo_asli);
          $cek_posisi = strpos($val_combo_asli, '^');
          if($cek_posisi == 0) $cek_posisi = $hitung + 1;
          $a = 1;
          while($a < 50){
            $item_combo = substr($val_combo_asli, 0, $cek_posisi);
            $val_combo_asli = substr($val_combo_asli, $cek_posisi + 1, $hitung);
            $hitung = strlen($val_combo_asli);
            $cek_posisi = strpos($val_combo_asli, '^');
            if($a == 1){
              $opsi_koefisien_asli = array($item_combo => $item_combo);
            }else{
              $tempArray = array($item_combo => $item_combo);
              $opsi_koefisien_asli = array_merge($opsi_koefisien_asli, $tempArray);
            }
            if($cek_posisi == ""){
              $a = $a + 1;
              $tempArray = array($val_combo_asli => $val_combo_asli);
              $opsi_koefisien_asli = array_merge($opsi_koefisien_asli, $tempArray);
              $a = 51;
            }
            $a = $a + 1;
          }
        }else{
          $cek_val_combo_asli = FALSE;
        }
        
        // merubah data menjadi array keberadaan syarat wajib
        $val_combo_syarat = $row->syarat_arsip;
        if($val_combo_syarat){
          $cek_val_combo = TRUE;
          $hitung = strlen($val_combo_syarat);
          $cek_posisi = strpos($val_combo_syarat, '^');
          if($cek_posisi == 0) $cek_posisi = $hitung + 1;
          $a = 1;
          while($a < 50){
            $item_combo = substr($val_combo_syarat, 0, $cek_posisi);
            $val_combo_syarat = substr($val_combo_syarat, $cek_posisi + 1, $hitung);
            $hitung = strlen($val_combo_syarat);
            $cek_posisi = strpos($val_combo_syarat, '^');
            if($a == 1){
              $opsi_koefisien_syarat = array($item_combo => $item_combo);
            }else{
              $tempArray = array($item_combo => $item_combo);
              $opsi_koefisien_syarat = array_merge($opsi_koefisien_syarat, $tempArray);
            }
            if($cek_posisi == ""){
              $a = $a + 1;
              $tempArray = array($val_combo_syarat => $val_combo_syarat);
              $opsi_koefisien_syarat = array_merge($opsi_koefisien_syarat, $tempArray);
              $a = 51;
            }
            $a = $a + 1;
          }
        }else{
          $cek_val_combo = FALSE;
        }
        
        $ln = 0;
        echo "<table width='100%' cellspacing='0' cellpadding='0' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>";
        foreach ($syarat_izin as $srt) {
          $show_syarat = new trperizinan_syarat();
          $show_syarat->where('trsyarat_perizinan_id', $srt->id)->where('trperizinan_id', $row->idizin)->get();
          $var = $show_syarat->c_show_type;
          $rule = strval(decbin($var));
          if($show_syarat->status_new == 1)
            $plv = 6;
          else
            $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
          if(strlen($rule) < $plv){
            $len = $plv - strlen($rule);
            $rule = str_repeat("0", $len) . $rule;
          }
          if($plv == 4) $rule = $rule . '00';                         // penambahan pencabutan dan penutupan ditambah 00
          $arr_rule = str_split($rule);
          if($plv == 4){
            $c_baru         = $arr_rule[1];
            $c_daftar_ulang = $arr_rule[0];
          }else{
            $c_baru         = $arr_rule[0];
            $c_daftar_ulang = $arr_rule[1];
          }
          $c_perpanjangan = $arr_rule[2];
          $c_ubah         = $arr_rule[3];
          $c_pencabutan   = $arr_rule[4];
          $c_penutupan    = $arr_rule[5];
          
          $syarat_status = $c_baru;
          if($syarat_status == '1'){
            $srt_asli = '';
            if($cek_val_combo_asli){
              foreach ($opsi_koefisien_asli as $cek_syarat_asli){
                if($srt->id == $cek_syarat_asli){
                  $srt_asli = 'ASLI';
                }
              }
            }
            if($srt_asli == ''){
              if($cek_val_combo){
                $srt_asli = '-';
                foreach($opsi_koefisien_syarat as $cek_syarat){
                  if ($srt->id == $cek_syarat) $srt_asli = 'V';
                }
              }
            }
            $ln++;
            if($ln == 1){
              echo "<tr>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $i . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>'" . $row->pendaftaran_id . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $row->n_perizinan . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $this->lib_date->mysql_to_human($row->d_terima_berkas) . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $row->n_pemohon . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $this->lib_date->mysql_to_human($tgl_selesai) . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $no_surat . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $ln . '. ' . $srt->v_syarat . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $tahun . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $jumlah . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $sampul . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $box . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $rak . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $srt_asli . "</td>
                    </tr>";
            }else{
              echo "<tr>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $ln . '. ' . $srt->v_syarat . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . $srt_asli . "</td>
                    </tr>";
            }
          }
        }
        echo "</table>";
        echo "<table width='100%' cellspacing='0' cellpadding='0' border='0' style='border-bottom-style:solid; border-width:thin;font-size:10px;'>";
        echo "<tr>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
                <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" . '' . "</td>
              </tr>";
        echo "</table>";
        // diperlukan jika ingin memecah per halaman 
        if($jumlah == 50){
          $gt_hal = TRUE;
          $jumlah = 0;
          //echo "</table>"; 
        }
      }
    }
    echo "</table>";
  }
  
  public function sql($u_ser){
    $query = "select a.description from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='" . $u_ser . "')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }
  
  public function view_query(){
    $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.desc_arsip, A.arsip_asli, A.syarat_arsip,
              A.keterangan, A.a_izin, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas, A.kd_gerai, A.nama_file,
              C.id idizin, C.n_perizinan, 
              E.n_pemohon, E.telp_pemohon,
              G.id idjenis, G.n_permohonan,
              I.status_bap, 
              K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, 
              N.n_sts_permohonan,
              L.trkelompok_perizinan_id idkelompok
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
              INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
              INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
              INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
              /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
              WHERE A.status_berkas = 'Izin Disetujui'
             ";
    return $query;
  }

  function showform($hit = Null){
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $list_sektor = $username->gvar3;
    $mark = $username->gvar4;
    $id_daftar = $username->gvar5;
    $menu = $username->gvar10;
    $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $hit, '', '', '', $menu);   // post variable
    if($hit == '0'){
      $jdl = "Upload Dokumen Izin Baru";
    }else{
      if($hit == '999'){
        $jdl = "Upload Penambahan Dokumen Izin";
      }else{
        $jdl = "Upload Perubahan Dokumen Izin Lama";
      }
    }
    $data["judulapp"] = $jdl;
    $data["scriptaksi"] = "arsip/uploadfile";
    $data["aksi"] = "Upload";
    $data["error"] = (isset($data["error"])) ? $data["error"] : "";
    $viewfile = "v_cupload_form";
    $this->load->view($viewfile, $data);
  }
  
    function deleteform($hit = Null)
    {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $tgla = $username->gvar1;
        $tglb = $username->gvar2;
        $list_sektor = $username->gvar3;
        $mark = $username->gvar4;
        $id_daftar = $username->gvar5;
        $menu = $username->gvar10;
        $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $hit, '', '', '', $menu);   // post variable

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $isi = $permohonan->nama_file;
        $val_combo_name =  $isi;
        $hitung = strlen($val_combo_name);
        $cek_posisi = strpos($val_combo_name, '^');
        if ($cek_posisi == 0) $cek_posisi = $hitung + 1;
        $a = 1;
        $name = '';
        while ($a < 50) {
            if ($a == $hit)
                $item_combo = 'dihapus';
            else
                $item_combo = substr($val_combo_name, 0, $cek_posisi);
            if ($item_combo != 'dihapus') {
                if ($a == 1)
                    $name = $item_combo;
                else
                    $name = $name . '^' . $item_combo;
            }
            $val_combo_name = substr($val_combo_name, $cek_posisi + 1, $hitung);
            $hitung = strlen($val_combo_name);
            $cek_posisi = strpos($val_combo_name, '^');
            if ($cek_posisi == "") { // jika item terakhir
                $a++;
                if ($a == $hit) {
                    $val_combo_name = 'dihapus';
                }
                if ($a != $hit) {
                    $name = $name . '^' . $val_combo_name;
                }
                $a = 51;
            }
            $a++;
        }
        if (substr($name, -1) == '^') $name = substr($name, 1, strlen($name) - 1);
        if (substr($name, 0, 1)  == '^') $name = substr($name, 1, strlen($name));
        if ($name == null)
            $permohonan->nama_file = null;                     // simpan u/ nama file upload baru
        else
            $permohonan->nama_file = $name;                     // simpan u/ nama file upload baru
        $permohonan->save();
        redirect('arsip/edit' . '/E/' . $id_daftar . '/0/');   // E:edit; L:List, 0:Menu Asal 
    }

    function uploadfile()
    {
        $config['upload_path'] = './doc-izin';
        //$config['allowed_types'] = 'csv|txt|gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|ini';
        $config['allowed_types'] = 'pdf|gif|jpg';
        $config['overwrite'] = true;
        $config['max_size']    = '20000000';
        $config['max_width']  = '2600';
        $config['max_height']  = '4000';
        $this->load->library('upload', $config);
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $tgla = $username->gvar1;
        $tglb = $username->gvar2;
        $list_sektor = $username->gvar3;
        $mark = $username->gvar4;
        $id_daftar = $username->gvar5;
        $hit = $username->gvar6;
        $name = $username->gvar7;
        $menu = $username->gvar10;
        if (!$this->upload->do_upload()) {
            //$error = array('error' => $this->upload->display_errors());
            //$this->showform($error);
            $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, '', '', '', '', '', $menu);   // post variable
        } else {
            //$data = array('upload_data' => $this->upload->data());
            //$data["judulapp"]="Upload Dokumen Izin";
            //$this->load->view('v_cupload_hasil', $data);
            $array = $this->upload->data();
            $nama_file = $array['file_name'];
            $permohonan = new tmpermohonan();
            $permohonan->get_by_id($id_daftar);
            $isi = $permohonan->nama_file;
            if ($isi == '') {
                $permohonan->nama_file = $nama_file;                     // simpan u/ nama file upload baru
                $permohonan->save();
            } else {
                if ($hit == '999') {
                    $permohonan->nama_file = $isi . '^' . $nama_file;        // simpan u/ nama file upload tambah baru
                    $permohonan->save();
                } else {                                                 // simpan u/ nama file upload Edit
                    $val_combo_name =  $isi;
                    $hitung = strlen($val_combo_name);
                    $cek_posisi = strpos($val_combo_name, '^');
                    if ($cek_posisi == 0) $cek_posisi = $hitung + 1;
                    $a = 1;
                    $name = "";
                    while ($a < 50) {
                        if ($a == $hit)
                            $item_combo = $nama_file;
                        else
                            $item_combo = substr($val_combo_name, 0, $cek_posisi);
                        $name = $name . $item_combo . '^';
                        $val_combo_name = substr($val_combo_name, $cek_posisi + 1, $hitung);
                        $hitung = strlen($val_combo_name);
                        $cek_posisi = strpos($val_combo_name, '^');
                        if ($cek_posisi == "") { // jika item terakhir
                            $a++;
                            if ($a == $hit)
                                $name = $name . $nama_file;
                            else
                                $name = $name . $val_combo_name;
                            $a = 51;
                        }
                        $a++;
                    }
                    $permohonan->nama_file = $name;        // simpan u/ nama file upload
                    $permohonan->save();
                }
            }
            $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $name_file, '', '', '', '', $menu);   // post variable
        }
        redirect('arsip/edit' . '/E/' . $id_daftar . '/0/');   // E:edit; L:List, 0:Menu Asal
    }

    #  EDIT AHMAD
    public function berkas_gub($id_daftar = null)
    {
        if ($id_daftar != null) {
            $a = "select * from tmpermohonan where id ='" . $id_daftar . "'";
            $hasil = $this->db->query($a)->row_array();
            $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='" . $id_daftar . "')";
            $hasil2 = $this->db->query($b)->row_array();
            $c = "select * from trperizinan_template where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='" . $id_daftar . "') ";
            $hasil3 = $this->db->query($c)->result();
            $d = "select * from trmengingat where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='" . $hasil2['id'] . "') order by jenis,nomor,tahun asc";
            $hasil4 = $this->db->query($d)->result();
            $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='" . $hasil2['id'] . "')";
            $hasil5 = $this->db->query($e)->result();
            $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='" . $hasil2['id'] . "')";
            $hasil6 = $this->db->query($f)->result();
            $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='" . $id_daftar . "')";
            $hasil7 = $this->db->query($g)->row_array();

            $kota = "select * from trkabupaten where id in(select trkabupaten_id from trkabupaten_trkecamatan where trkecamatan_id in(select id from trkecamatan where id in(select trkecamatan_id from trkecamatan_trkelurahan where trkelurahan_id in(select id from trkelurahan where id in(select trkelurahan_id from tmpemohon_trkelurahan where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = (select id from tmpermohonan where id = '" . $id_daftar . "'))))))) ";
            $sqlkota = $this->db->query($kota)->row_array();

            // Including all required classes
            require_once('assets/barcode_file/class/BCGFontFile.php');
            require_once('assets/barcode_file/class/BCGColor.php');
            require_once('assets/barcode_file/class/BCGDrawing.php');

            // Including the barcode technology
            require_once('assets/barcode_file/class/BCGcode39.barcode.php');

            // Loading Font
            $font = new BCGFontFile('assets/barcode_file/font/Arial.ttf', 10);

            // Don't forget to sanitize user inputs
            $text = $hasil7['no_surat'];

            // The arguments are R, G, B for color.
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);

            $drawException = null;
            try {
                $code = new BCGcode39();
                $code->setScale(1);
                $code->setThickness(50);
                $code->setForegroundColor($color_black);
                $code->setBackgroundColor($color_white);
                $code->setFont(0); // Font (or 0)
                $code->parse($text);
            } catch (Exception $exception) {
                $drawException = $exception;
            }

            $drawing = new BCGDrawing('assets/barcode/' . $hasil['pendaftaran_id'] . '.png', $color_white);
            if ($drawException) {
                $drawing->drawException($drawException);
            } else {
                $drawing->setBarcode($code);
                $drawing->draw();
            }

            // Draw (or save) the image into PNG format.
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

            require_once 'assets/phpword/src/PhpWord/Autoloader.php';
            \PhpOffice\PhpWord\Autoloader::register();
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/' . $hasil2['template_gub']);
            echo $hasil2['template_gub'];
            die();

            // $replace = base_url()."assets/barcode/".$hasil['pendaftaran_id'].".png";
            // $templateProcessor->setValue('barcode',base_url().'assets/barcode/'.$hasil['pendaftaran_id'].'.png');
            // $templateProcessor->setImageValue($templateProcessor->getImgFileName($templateProcessor->seachImagerId("image1.png")),''.base_url().'assets/barcode/0005807801062015001.png');
            $templateProcessor->setImageValue('image1.png', 'assets/barcode/' . $hasil['pendaftaran_id'] . '.png');
            $templateProcessor->setValue("namaizin", $hasil2['n_perizinan']);
            $templateProcessor->setValue("nomor", $hasil7['no_surat']);

            //menimbang--------------
            $no = 1;
            $templateProcessor->cloneRow('menimbang', count($hasil5));
            // while($no<=count($hasil4)){
            foreach ($hasil5 as $ha5) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("menimbang#" . $no, $ha5->deskripsi);
                $no++;
            }
            $no = 1;
            foreach ($hasil5 as $ha5) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("No1#" . $no, $no);
                $no++;
            }
            //end---------------------

            //mengingat---------------
            $no = 1;
            $templateProcessor->cloneRow('mengingat', count($hasil4));
            // while($no<=count($hasil4)){
            foreach ($hasil4 as $ha4) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("mengingat#" . $no, $ha4->deskripsi);
                $no++;
            }
            $no = 1;
            foreach ($hasil4 as $ha4) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("No2#" . $no, $no);
                $no++;
            }
            //end-------------------     

            //memperhatikan---------------
            $no = 1;
            $templateProcessor->cloneRow('memperhatikan', count($hasil6));
            // while($no<=count($hasil4)){
            foreach ($hasil6 as $ha6) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("memperhatikan#" . $no, $ha6->deskripsi);
                $no++;
            }
            $no = 1;
            foreach ($hasil6 as $ha6) {
                // $templateProcessor->setValue('N'.$no,$no);
                $templateProcessor->setValue("No3#" . $no, $no);
                $no++;
            }
            $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
            $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi = $cx[id]");
            $cx3 = count($cx);
            $blnID = array("Januari", "Februari", "Maret", 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

            if ($cx3 == 0) {
                $templateProcessor->setValue("text_atas", " ");
                $templateProcessor->setValue("text_alasan1", " ");
                $templateProcessor->setValue("text_alasan2", " ");
                $templateProcessor->setValue("No4", " ");
                $templateProcessor->setValue("t1", " ");
                $templateProcessor->setValue("t2", " ");
                $templateProcessor->setValue("t3", " ");
                $templateProcessor->setValue("t4", " ");
                $templateProcessor->cloneRow('No5', " ");
                $templateProcessor->setValue("No5", " ");
                $templateProcessor->setValue("prop", " ");
                $templateProcessor->setValue("dari", " ");
                $templateProcessor->setValue("menjadi", " ");
            } else {
                $ttg = explode(" ", $cx['tgl_revisi']);
                $ttg2 = explode("-", $ttg[0]);
                $bulan11 = $blnID[$ttg2[1]];
                $cx4 = $cx2->result();
                $templateProcessor->setValue("text_atas", "Dengan perubahan sebagai berikut : ");
                $templateProcessor->setValue("text_alasan1", "Perubahan Pada Tanggal : $ttg2[2] $bulan11 $ttg2[0]");
                $templateProcessor->setValue("text_alasan2", "Dengan Alasan : $cx[alasan]");
                $templateProcessor->setValue("No4", " ");
                $templateProcessor->setValue("t1", "No.");
                $templateProcessor->setValue("t2", "Properti");
                $templateProcessor->setValue("t3", "Dari");
                $templateProcessor->setValue("t4", "Menjadi");
                $templateProcessor->cloneRow('No5', count($cx4));
                $u = 1;
                foreach ($cx4 as $cc) {
                    $templateProcessor->setValue("No5#" . $u, "$u");
                    $templateProcessor->setValue("prop#" . $u, $cc->data);
                    $templateProcessor->setValue("dari#" . $u, $cc->asal);
                    $templateProcessor->setValue("menjadi#" . $u, $cc->jadi);
                    $u++;
                }
            }
            //end-------------------

            foreach ($hasil3 as $data) {
                $tek = "var_teknis" . $data->urutan_vars_teknis;
                $prop = $hasil2[$tek];
                if (empty($prop)) {
                    break;
                }
                $array = explode("^", $prop);
                $tek2 = "dt_teknis" . $data->urutan_vars_teknis;
                $prop2 = $hasil[$tek2];
                if (empty($prop)) {
                    break;
                }
                $array2 = explode("^", $prop2);
                $templateProcessor->setValue($data->t_nama, $array[1]);
                $templateProcessor->setValue($data->t_value, $array2[1]);
            }
            $templateProcessor->setValue('ttd', $hasil['nama_ttd']);
            $templateProcessor->setValue('nip', $hasil['nip_ttd']);
            $kota = explode(' ', $sqlkota['n_kabupaten']);
            if ($kota[0] == 'KOTA') {
                $templateProcessor->setValue('wal/bup', 'Walikota ' . ucfirst(strtolower($kota[1])));
            } else {
                $templateProcessor->setValue('wal/bup', 'Bupati ' . ucfirst(strtolower($kota[1])));
            }
            if ($kota[0] == 'KOTA') {
                $templateProcessor->setValue('ket', 'Kota');
                $templateProcessor->setValue('kota', ucfirst(strtolower($kota[1])));
            } else {
                $templateProcessor->setValue('ket', 'Kab.');
                $templateProcessor->setValue('kota', ucfirst(strtolower($kota[1])));
            }

            $templateProcessor->saveAs('assets/download/' . $hasil2['n_perizinan'] . ' ' . time() . '.docx');
            redirect('assets/download/' . $hasil2['n_perizinan'] . ' ' . time() . '.docx');
            // die;
        }
    }

    public function berkascetak($id_daftar = null, $jenis = null)
    {
        if ($id_daftar != null) {
            $a = "select * from tmpegawai where status = '1'";
            $hasil = $this->db->query($a)->row_array();
            $a22 = "select * from tmpermohonan where id ='" . $id_daftar . "'";

            $hasil22 = $this->db->query($a22)->row_array();
            $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='" . $id_daftar . "')";
            $hasil2 = $this->db->query($b)->row_array();

            $string3 = "select * from trperizinan_template 
                  where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='" . $id_daftar . "') ";
            if ($jenis == 2) {
                $string3 = "select * from trperizinan_template_gub 
                    where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='" . $id_daftar . "') ";
            }

            $c = $string3;
            $hasil3 = $this->db->query($c)->result();

            $d = "select * from trmengingat 
            where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='" . $hasil2['id'] . "') order by jenis,nomor,tahun asc";
            $hasil4 = $this->db->query($d)->result();
            $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='" . $hasil2['id'] . "')";
            $hasil5 = $this->db->query($e)->result();
            $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='" . $hasil2['id'] . "')";
            $hasil6 = $this->db->query($f)->result();
            $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='" . $id_daftar . "')";
            $hasil7 = $this->db->query($g)->row_array();

            $kota = "select * from trkabupaten 
               where id in(select trkabupaten_id from trkabupaten_trkecamatan 
               where trkecamatan_id in(select id from trkecamatan 
               where id in(select trkecamatan_id from trkecamatan_trkelurahan 
               where trkelurahan_id in(select id from trkelurahan 
               where id in(select trkelurahan_id from tmpemohon_trkelurahan 
               where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan 
               where tmpermohonan_id = (select id from tmpermohonan where id = '" . $id_daftar . "'))))))) ";
            $sqlkota = $this->db->query($kota)->row_array();

            // Including all required classes
            require_once('assets/barcode_file/class/BCGFontFile.php');
            require_once('assets/barcode_file/class/BCGColor.php');
            require_once('assets/barcode_file/class/BCGDrawing.php');

            // Including the barcode technology
            require_once('assets/barcode_file/class/BCGcode39.barcode.php');

            // Loading Font
            $font = new BCGFontFile('assets/barcode_file/font/Arial.ttf', 10);
            //die;
            // Don't forget to sanitize user inputs
            $text = $hasil7['no_surat'];

            // The arguments are R, G, B for color.
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);

            $drawException = null;
            try {
                $code = new BCGcode39();
                $code->setScale(1);
                $code->setThickness(50);
                $code->setForegroundColor($color_black);
                $code->setBackgroundColor($color_white);
                $code->setFont(0); // Font (or 0)
                $code->parse($text);
            } catch (Exception $exception) {
                $drawException = $exception;
            }

            $drawing = new BCGDrawing('assets/barcode/' . $hasil22['pendaftaran_id'] . '.png', $color_white);
            if ($drawException) {
                $drawing->drawException($drawException);
            } else {
                $drawing->setBarcode($code);
                $drawing->draw();
            }

            // Draw (or save) the image into PNG format.
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

            require_once 'assets/phpword/src/PhpWord/Autoloader.php';
            \PhpOffice\PhpWord\Autoloader::register();
            if ($jenis == 1) {
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/' . $hasil2['template']);
            }
            if ($jenis == 2) {
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/' . $hasil2['template_gub']);
            }
            // $replace = base_url()."assets/barcode/".$hasil['pendaftaran_id'].".png";
            // $templateProcessor->setValue('barcode',base_url().'assets/barcode/'.$hasil['pendaftaran_id'].'.png');
            $templateProcessor->setImageValue($templateProcessor->getImgFileName($templateProcessor->seachImagerId("image1.png")), '' .
                base_url() . 'assets/barcode/0005807801062015001.png');
            $templateProcessor->setImageValue('image1.png', 'assets/barcode/' . $hasil['pendaftaran_id'] . '.png');
            $templateProcessor->setValue("namaizin", $hasil2['n_perizinan']);
            $templateProcessor->setValue("nomor", $hasil7['no_surat']);
            $arrblnRomawi = array("I", "II", "III", "IV", "V", "VI", 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
            $blnRomawi = $arrblnRomawi[date("M") - 1];
            $templateProcessor->setValue("bulanromawi", $blnRomawi);
            $templateProcessor->setValue("tahunini", date("Y"));

            ############################################
            #                                          #
            #   NEW QUERY PEMOHON DAN PERUSAHAAN       #
            #                                          #
            ############################################
            $qqq = "select * from tmpemohon where id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = '" . $id_daftar . "')";
            $dt_pemohon = $this->db->query($qqq)->row_array();
            $qqq2 = "select * from tmperusahaan where id = (select tmperusahaan_id from tmpermohonan_tmperusahaan where tmpermohonan_id = '" . $id_daftar . "')";
            $dt_pemohon2 = $this->db->query($qqq2)->row_array();
            $bulanArr = array("Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $expl = explode("-", $hasil["d_terima_berkas"]);
            $blnIndo = "$expl[2] " . $bulanArr[$expl[1] - 1] . " $expl[0]";
            if (count($dt_pemohon2) > 0) {
                $templateProcessor->setValue("nperusahaan", $dt_pemohon2['n_perusahaan']);
            } else {
                $templateProcessor->setValue("nperusahaan", $dt_pemohon['n_pemohon']);
            }

            $pegawai = new tmpegawai();
            $pegawai = $pegawai->where('status', '1')->get();
            $organisasi = '';
            $jbt = '';
            if ($sektor->ttd_sp == '1') {     // utk kepala
                $organisasi = 'KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU';
            } else {
                $organisasi = 'a.n. KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU';
                $jbt = $pegawai->n_jabatan;;
            }
            $ttd_kepala  = $pegawai->n_pegawai;
            $ttd_pangkat = $pegawai->pangkat_gol;
            $ttd_nip     = $pegawai->nip;

            //Create Variabel => transfer variabel pencetakan
            $templateProcessor->setValue("nopendaftaran", $hasil22['pendaftaran_id']);
            $templateProcessor->setValue("npemohon", $dt_pemohon['n_pemohon']);
            $templateProcessor->setValue("tgl_daftar", $blnIndo);

            $templateProcessor->setValue("organisasi", $organisasi); //ttd
            $templateProcessor->setValue("jabatan", $jbt);           //ttd
            $templateProcessor->setValue("kepala_opd", $ttd_kepala); //ttd
            $templateProcessor->setValue("pangkat", $ttd_pangkat);   //ttd
            $templateProcessor->setValue("nip", $ttd_nip);           //ttd
            //Create Variabel => transfer variabel pencetakan EOF()

            ############################################
            #                                          #
            # END OF NEW QUERY PEMOHON DAN PERUSAHAAN  #
            #                                          #
            ############################################

            //menimbang--------------
            function docx2text($filename)
            {
                return readZippedXML($filename, "word/document.xml");
            }
            $tulis_nama = array();
            $tulis_variable = array();

            function readZippedXML($archiveFile, $dataFile)
            {
                $zip = new ZipArchive;
                if (true === $zip->open($archiveFile)) {
                    if (($index = $zip->locateName($dataFile)) !== false) {
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

            if ($jenis == 1) {
                $text = docx2text('assets/template-baru/' . $hasil2['template']);
            }
            if ($jenis == 2) {
                $text = docx2text('assets/template-baru/' . $hasil2['template_gub']);
            }
            $texts = explode(" ", $text);
            $output = array();
            $output2 = array();
            $output3 = array();
            foreach ($texts as $t) {
                if (strpos($t, '${menimbang}') !== false) {
                    $output[] = $t;
                }
                if (strpos($t, '${mengingat}') !== false) {
                    $output2[] = $t;
                }
                if (strpos($t, '${memperhatikan}') !== false) {
                    $output3[] = $t;
                }
            }

            //menimbang--------------
            if (count($output) > 0) {
                $no = 1;
                if (count($hasil5) > 0) {
                    $templateProcessor->cloneRow('menimbang', count($hasil5));
                    // while($no<=count($hasil4)){
                    foreach ($hasil5 as $ha5) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("menimbang#" . $no, $ha5->deskripsi);
                        $no++;
                    }
                    $no = 1;
                    foreach ($hasil5 as $ha5) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("No1#" . $no, $no);
                        $no++;
                    }
                } else {
                    $templateProcessor->setValue("menimbang", "");
                    $templateProcessor->setValue("No1", "");
                }
            }
            //end---------------------

            //mengingat---------------
            if (count($output2) > 0) {
                $no = 1;
                if (count($hasil4) > 0) {
                    $templateProcessor->cloneRow('mengingat', count($hasil4));
                    // while($no<=count($hasil4)){
                    foreach ($hasil4 as $ha4) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("mengingat#" . $no, $ha4->deskripsi);
                        $no++;
                    }
                    $no = 1;
                    foreach ($hasil4 as $ha4) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("No2#" . $no, $no);
                        $no++;
                    }
                } else {
                    $templateProcessor->setValue("mengingat", "");
                    $templateProcessor->setValue("No2", "");
                }
            }
            //end-------------------     

            //memperhatikan---------------
            if (count($output3) > 0) {
                $no = 1;
                if (count($hasil6) > 0) {
                    $templateProcessor->cloneRow('memperhatikan', count($hasil6));
                    // while($no<=count($hasil4)){
                    foreach ($hasil6 as $ha6) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("memperhatikan#" . $no, $ha6->deskripsi);
                        $no++;
                    }
                    $no = 1;
                    foreach ($hasil6 as $ha6) {
                        // $templateProcessor->setValue('N'.$no,$no);
                        $templateProcessor->setValue("No3#" . $no, $no);
                        $no++;
                    }
                } else {
                    $templateProcessor->setValue("memperhatikan", "");
                    $templateProcessor->setValue("No3", "");
                }
            }
            $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
            $cxv = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc")->result();
            $cx3 = count($cxv);
            $blnID = array("Januari", "Februari", "Maret", 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            if ($cx3 == 0) {
                $templateProcessor->setValue("text_atas", " ");
                $templateProcessor->setValue("text_alasan1", " ");
                $templateProcessor->setValue("text_alasan2", " ");
                $templateProcessor->setValue("No4", " ");
                $templateProcessor->setValue("t1", " ");
                $templateProcessor->setValue("t2", " ");
                $templateProcessor->setValue("t3", " ");
                $templateProcessor->setValue("t4", " ");
                $templateProcessor->setValue("t5", " ");
                // $templateProcessor->cloneRow('No5', " ");
                $templateProcessor->setValue("No5", " ");
                $templateProcessor->setValue("prop", " ");
                $templateProcessor->setValue("dari", " ");
                $templateProcessor->setValue("menjadi", " ");
                $templateProcessor->setValue("tgl_berubah", " ");
            } else {
                $arr1 = array();
                $arr2 = array();
                foreach ($cxv as $key) {
                    $arr1[] = $key->id;
                    $arr2[$key->id] = $key->tgl_revisi;
                    // var_dump($key);
                    // echo "<br>";
                }
                // die;
                $many1 = implode(",", $arr1);
                $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi in($many1) order by data asc,id asc");
                $cx4 = $cx2->result();

                // $ttg = explode(" ", $cxv['tgl_revisi']);
                // $ttg2 = explode("-",$ttg[0]);
                // $bulan11 = $blnID[$ttg2[1]-1];
                $templateProcessor->setValue("text_atas", " ");
                $templateProcessor->setValue("text_alasan1", "(Catatan perubahan) : ");
                $templateProcessor->setValue("text_alasan2", "");
                $templateProcessor->setValue("No4", " ");
                $templateProcessor->setValue("t1", "No.");
                $templateProcessor->setValue("t2", "Properti");
                $templateProcessor->setValue("t3", "Semula");
                $templateProcessor->setValue("t4", "Menjadi");
                $templateProcessor->setValue("t5", "Tanggal Berubah");
                $templateProcessor->cloneRow('No5', count($cx4));
                $u = 1;

                foreach ($cx4 as $cc) {
                    $wa = explode(" ", $arr2[$cc->id_revisi]);
                    $templateProcessor->setValue("No5#" . $u, "$u");
                    $templateProcessor->setValue("prop#" . $u, $cc->data);
                    $templateProcessor->setValue("dari#" . $u, $cc->asal);
                    $templateProcessor->setValue("menjadi#" . $u, $cc->jadi);
                    $templateProcessor->setValue("tgl_berubah#" . $u, $wa[0]);
                    $u++;
                }
                //var_dump($cx3);
            }

            //exit();
            //end-------------------       
            foreach ($hasil3 as $data) {
                $tek = "var_teknis" . $data->urutan_vars_teknis;
                $prop = $hasil2[$tek];
                if (empty($prop)) {
                    break;
                }
                $array = explode("^", $prop);
                $tek2 = "dt_teknis" . $data->urutan_vars_teknis;
                $prop2 = $hasil22[$tek2];
                if (empty($prop)) {
                    break;
                }
                $array2 = explode("^", $prop2);
                $templateProcessor->setValue($data->t_nama, $array[1]);
                $templateProcessor->setValue($data->t_value, $array2[1]);
            }
            $templateProcessor->setValue('ttd', $hasil['n_pegawai']);
            $templateProcessor->setValue('nip', $hasil['nip']);
            $templateProcessor->setValue('jabatan', $hasil['n_jabatan']);
            $kota = explode(' ', $sqlkota['n_kabupaten']);
            if ($kota[0] == 'KOTA') {
                $templateProcessor->setValue('wal/bup', 'Walikota ' . ucfirst(strtolower($kota[1])));
            } else {
                $templateProcessor->setValue('wal/bup', 'Bupati ' . ucfirst(strtolower($kota[1])));
            }
            if ($kota[0] == 'KOTA') {
                $templateProcessor->setValue('ket', 'Kota');
                $templateProcessor->setValue('kota', ucfirst(strtolower($kota[1])));
            } else {
                $templateProcessor->setValue('ket', 'Kab.');
                $templateProcessor->setValue('kota', ucfirst(strtolower($kota[1])));
            }
            $redirect = $hasil2['n_perizinan'] . ' ' . time();
            $templateProcessor->saveAs('assets/download/' . $redirect . '.docx');
            // redirect('assets/download/'.$hasil2['n_perizinan'].' '.time().'.docx');        
            redirect('assets/download/' . $redirect . '.docx');
        }
    }

    public function cetak_excel()
    { // cetak list per izin ke Excel

        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Rekap_Arsip_Excel.xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $list_izin = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.desc_arsip, A.arsip_asli, A.syarat_arsip,
              A.keterangan, A.a_izin, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas, A.kd_gerai, A.nama_file,
              C.id idizin, C.n_perizinan, 
              E.n_pemohon, E.telp_pemohon,
              G.id idjenis, G.n_permohonan,
              I.status_bap, 
              K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, 
              N.n_sts_permohonan,
              L.trkelompok_perizinan_id idkelompok,
              TRIM(LEADING '-' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(A.desc_arsip, '^', -2), '^', 1)) as angka,
              C.indeks, C.kd_indeks
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
              INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
              INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
              INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
              WHERE A.status_berkas = 'Izin Disetujui' ";

        $query = $list_izin;
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $tgla = $username->gvar1;
        $tglb = $username->gvar2;
        $list_sektor = $username->gvar3;
        $mark = $username->gvar4;
        $lokasi_user = $this->session->userdata('lokasi');

        if ($lokasi_user === 'Pusat')  // Untuk daerah lain
        // if ($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar')
            $query .= "";
        else
            $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";

        if ($list_sektor == '0') {  // Semua Sektor
            $bidang = "SEMUA SEKTOR";
        } else {
            $query .= " AND A.trsektor_id = '" . $list_sektor . "'";
            $sektor = new trsektor();
            $bidang = $sektor->get_by_id($list_sektor)->n_sektor;
        }
        $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
        $query .= " ORDER BY C.indeks, C.kd_indeks, -A.desc_arsip DESC, TRIM(LEADING '-' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(A.desc_arsip, '^', -2), '^', 1)) + 0 ASC, SUBSTRING_INDEX(SUBSTRING_INDEX(K.no_surat, '/', 2), '/', -1) + 0 ASC";

        echo "<table width='100%' border='0' font-size:16px;'>";
        echo "<tr>DAFTAR REKAP ARSIP PERIZINAN BIDANG : " . $bidang . "</tr>";
        echo "<tr>PERIODE : " . $this->lib_date->mysql_to_human($tgla) . " - " . $this->lib_date->mysql_to_human($tglb) . "</tr>";
        echo "</table>";
        echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
        $jdl = "<tr>
              <td>" . 'NO' . "</td>
              <td>" . 'INDEKS' . "</td>
              <td>" . 'KLAS' . "</td>
              <td>" . 'URAIAN/DESKRIPSI' . "</td>
              <td>" . 'TAHUN' . "</td>
              <td>" . 'JUMLAH' . "</td>
              <td>" . 'SAMPUL' . "</td>
              <td>" . 'BOKS' . "</td>
              <td>" . 'RAK' . "</td>
              <td>" . 'KETERANGAN' . "</td>";

        $i = 0;
        echo $jdl;

        $results = mysql_query($query);

        while ($row = mysql_fetch_assoc(@$results)) {

            $status_bap = $row['status_bap'];
            $no_surat = $row['no_surat_edit'];
            $tgl_surat = $row['tgl_surat_edit'];
            if ($no_surat == '') {
                $no_surat = $row['no_surat'];
                $tgl_surat = $row['tgl_surat'];
            }

            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $row['id'])->get();
            $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
            $n_perusahaan = $perusahaan->n_perusahaan;

            if ($row['desc_arsip'] == '') {
                $stat_edit = 'Mengarsipkan';
                $cek_kirim = FALSE;
                $b = '<span style="color: Red">';
                $be = '</span>';
            } else {
                $stat_edit = 'Edit Arsip';
                $cek_kirim = TRUE;
                if ($row['nama_file'] == '') {
                    $stat_edit = 'Edit Arsip Naskah Izin';
                    $b = '<span style="color: Blue">';
                    $be = '</span>';
                } else {
                    $b = '';
                    $be = '';
                }
            }

            if ($cek_kirim) {
                $ket_arsip = $row['desc_arsip'];
            } else {
                $ket_arsip = '-_^-_^-_^-_^-_';
            }
            $arr_kalimat = explode("^", $ket_arsip);

            $i++;

            // $tanda = 0;
            // $jmlboks = null;
            //$nperizinan = $this->db->escape_like_str('%Tenaga kerja asing%');
            // if ($tanda = 0 || $jmlboks) {
            //   $qhitung = "SELECT  COUNT(*) as angka
            //         FROM tmpermohonan as A
            //         INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
            //         INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
            //         INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
            //         INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
            //         INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
            //         INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
            //         INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
            //         INNER JOIN tmbap I ON H.tmbap_id = I.id
            //         INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
            //         INNER JOIN tmsk K ON J.tmsk_id = K.id
            //         INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            //         INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            //         INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            //         WHERE A.status_berkas = 'Izin Disetujui' AND C.n_perizinan LIKE '%Tenaga kerja asing%' AND (K.tgl_surat BETWEEN ? AND ?) AND C.indeks = ? AND TRIM(LEADING '-' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(A.desc_arsip, '^', -2), '^', 1)) + 0 = ?";
            //   $hasilq = $this->db->query($qhitung, array('2014-01-01', '2014-01-31', $row['indeks'], str_replace('-','',$arr_kalimat[3])));

            //   $result = $hasilq->row_array();
            //   $jmlboks = $result['angka'];
            // }


            $isi = "<tr>
                <td>" . $i . "</td>
                <td>" . $row['indeks'] . "</td>
                <td>" . $row['kd_indeks'] . "</td>
                <td>" . $n_perusahaan . "<br>NOMOR " . $no_surat . " TGL " . date('d F Y', strtotime($tgl_surat)) . "</td>
                <td>" . date('Y', strtotime($tgl_surat)) . "</td>
                <td>" . str_replace('-', '', $arr_kalimat[1]) . "</td>
                <td>" . str_replace('-', '', $arr_kalimat[2]) . "</td>
                <td>" . str_replace('-', '', $arr_kalimat[3]) . "</td>
                <td>" . str_replace('-', '', $arr_kalimat[4]) . "</td>
                <td>" . $row['n_perizinan'] . "</td></tr>";
            echo $isi;
        }

        echo "</table>";
    }
}
// This is the end of role class