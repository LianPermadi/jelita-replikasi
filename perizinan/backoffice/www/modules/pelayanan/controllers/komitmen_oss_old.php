<?php

/**
 * Description of Pendaftaran Komitmen OSS
 * @author pbs
 * Created : 22 Juli 2014
 */
class komitmen_oss extends WRC_AdminCont {
  
  public function __construct() {
    parent::__construct();
    $this->username = new user();
    $this->pemohon_portal = new tmpemohon_portal();
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
    $this->perizinan_user = new trperizinan_user();
  
    $enabled = FALSE;
    $this->All = FALSE;
    $this->hapus = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
  
    foreach($list_auths as $list_auth) {
      //if($list_auth->id_role === '32') {  // komitmen oss
        $enabled = TRUE;
      //}
  	  if($list_auth->id_role === '25') {  // hapus data
        $this->hapus = TRUE;
      }
  	  if($list_auth->id_role === '18') {  // Admin
        $this->All = TRUE;
      }
    }
  
    if(!$enabled) {
      redirect('dashboard');
    }
    $this->jenis_id = "1"; // Izin Baru
  }
  
  public function index() { 
    $ossdb = $this->load->database('ossdb', TRUE);


    $this->username->where('username', $this->session->userdata('username'))->get();
    $id_user = $this->username->id;
    $user_lokasi = $this->username->lokasi;
    $izin_user = $this->perizinan_user->where("user_id",$id_user)->get();
    
    $jenis_p = $this->jenispermohonan->get_by_id($this->jenis_id);

    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    if($this->All){
      $query = "SELECT * FROM oss_nib";
    }else{
    	$query = "SELECT * FROM oss_nib";
    }
    
    $data['list'] = $query;
    $data['list_izin'] = $this->perizinan->order_by('id', 'ASC')->get();
    $data['list_jenispermohonan'] = $jenis_p;
    $data['list_izin_user'] = $izin_user;
    $data['user_lokasi'] = $user_lokasi;
    $data['jenis_id'] = $this->jenis_id;
    $data['ket_syarat'] = NULL;
    $data['all_view'] = $this->All;
    $data['aut_hapus'] = $this->hapus;
    $this->load->vars($data);
    
    $js = "
           function confirm_link(text){
               if(confirm(text)){ return true; } else { return false; }
           }
          
           $(document).ready(function() {
             oTable = $('#pendaftaran').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"
             });
           });
    
          $(document).ready(function() {
            $('#paralel_id').change(function(){
              $('#show_jenis_izin').fadeOut();
              $.post('" . base_url() . "pelayanan/komitmen_oss/izin_paralel', {
                jenis_paralel_id: $('#paralel_id').val()
              }, 
    	        function(response){
                setTimeout(\"finishAjax('show_jenis_izin', '\"+escape(response)+\"')\", 400);
              });
              return false;
            });	
          });
    
          function finishAjax(id, response){
            $('#'+id).html(unescape(response));
            $('#'+id).fadeIn();
          }
         ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Permohonan Komitmen OSS";
    $this->template->build('oss_list', $this->session_info);
  }
  
  public function validasi_Data($id_daftar = NULL) {
  }
  
  public function validasiPemohon($id_daftar = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    //Data Pemohon Baru
    $p_pemohon = $u_daftar->tmpemohon_sementara->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    
    //Data Pemohon Lama
    $p_pemohonL = $this->pemohon->where('no_referensi',$p_pemohon->no_referensi)->get();        
    $p_kelurahanL = $p_pemohonL->trkelurahan->get();
    
    //data pemohon lama 
    $data['save_method'] = "bridge";
    $data['id_daftar'] = $id_daftar;
    $data['no_referL'] = $p_pemohonL->no_referensi;
    $data['cmbsourceL'] = $p_pemohonL->source;
    $data['nama_pemohonL'] = $p_pemohonL->n_pemohon;
    $data['no_telpL'] = $p_pemohonL->telp_pemohon;
    $data['kelurahan_pemohonL'] = $p_kelurahanL->n_kelurahan;
    $data['alamat_pemohonL'] = $p_pemohonL->a_pemohon;
    
    //data pemohon baru
    $data['no_referB'] = $p_pemohon->no_referensi;
    $data['cmbsourceB'] = $p_pemohon->source;
    $data['nama_pemohonB'] = $p_pemohon->n_pemohon;
    $data['no_telpB'] = $p_pemohon->telp_pemohon;
    $data['kelurahan_pemohonB'] = $p_kelurahan->n_kelurahan;
    $data['alamat_pemohonB'] = $p_pemohon->a_pemohon;
    
    
    $js = "
           $(document).ready(function() {
             $('#form').validate();
             $(\"#tabs\").tabs();
    
             $('a[rel*=pemohon_box]').facebox();
             $('a[rel*=daftar_box]').facebox();
             $('a[rel*=perusahaan_box]').facebox();
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
    $this->session_info['page_name'] = "Verifikasi Data Pemohon";
    $this->template->build('val_pemohon', $this->session_info);
  }
    
    
  public function validasiPerusahaan($id_daftar = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    //Data perusahaan Baru
    $p_perusahaan = $u_daftar->tmperusahaan_sementara->get();
    $p_kelurahan = $p_perusahaan->trkelurahan->get();
    
    //Data Perusahaan Lama
    $p_perusahaanL = $this->perusahaan->where('npwp',$p_perusahaan->npwp)->get();        
    $p_kelurahanL = $p_perusahaanL->trkelurahan->get();
    
    //data perushaan lama 
    $data['id_daftar'] = $id_daftar;
    $data['npwpL'] = $p_perusahaanL->npwp;
    $data['registrasiL'] = $p_perusahaanL->no_reg_perusahaan;
    $data['n_perusahaanL'] = $p_perusahaanL->n_perusahaan;
    $data['no_telpL'] = $p_perusahaanL->i_telp_perusahaan;
    $data['kelurahan_perusahaanL'] = $p_kelurahanL->n_kelurahan;
    $data['alamat_perusahaanL'] = $p_perusahaanL->a_perusahaan;
    
    //data perusahaan baru
    $data['npwpB'] = $p_perusahaan->npwp;
    $data['registrasiB'] = $p_perusahaan->no_reg_perusahaan;
    $data['n_perusahaanB'] = $p_perusahaan->n_perusahaan;
    $data['no_telpB'] = $p_perusahaan->i_telp_perusahaan;
    $data['kelurahan_perusahaanB'] = $p_kelurahan->n_kelurahan;
    $data['alamat_perusahaanB'] = $p_perusahaan->a_perusahaan;
    
    $js = "
           $(document).ready(function() {
             $('#form').validate();
             $(\"#tabs\").tabs();
    
             $('a[rel*=pemohon_box]').facebox();
             $('a[rel*=daftar_box]').facebox();
             $('a[rel*=perusahaan_box]').facebox();
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
    $this->session_info['page_name'] = "Verifikasi Data Perusahaan";
    $this->template->build('val_perusahaan', $this->session_info);
  }
  
  public function replacePemohon($id_daftar = NULL){
    //  var_dump("<pre>");
    //  var_dump($_POST);
    
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    
    $p_pemohon = $u_daftar->tmpemohon_sementara->get();
    $p_pemohonL = $this->pemohon->where('no_referensi',$p_pemohon->no_referensi)->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();   
    
    $query = "update tmpemohon set no_referensi = '".$p_pemohon->no_referensi."', 
              n_pemohon = '".$p_pemohon->n_pemohon."',telp_pemohon = '".$p_pemohon->telp_pemohon."',
              a_pemohon = '".$p_pemohon->a_pemohon."',a_pemohon_luar = '".$p_pemohon->a_pemohon_luar."',
              source='".$p_pemohon->source."' where id='".$p_pemohonL->id."'";
    
    $this->db->query($query);
    $query2 = "update tmpemohon_trkelurahan set trkelurahan_id = '".$p_pemohon->trkelurahan->where("tmpemohon_sementara_id",$p_pemohon->id)->get()->id."'
               where tmpemohon_id='".$p_pemohonL->id."' and trkelurahan_id=".$p_pemohonL->trkelurahan->where("tmpemohon_id",$p_pemohonL->id)->get()->id;
    $this->db->query($query2);
    //echo $query1."<p>";
    //echo $query2;
    
    redirect('pelayanan/komitmen_oss');
    $this->db->query($query2);
    $this->db->query($query3);
  }
      
  public function tetapPemohon($id_daftar = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    
    $p_pemohon = $u_daftar->tmpemohon_sementara->get();
    $p_pemohonL = $this->pemohon->where('no_referensi',$p_pemohon->no_referensi)->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();    
    
    $query = "update tmpemohon_sementara set no_referensi = '".$p_pemohonL->no_referensi."', 
              n_pemohon = '".$p_pemohonL->n_pemohon."',telp_pemohon = '".$p_pemohonL->telp_pemohon."',
              a_pemohon = '".$p_pemohonL->a_pemohon."',a_pemohon_luar = '".$p_pemohonL->a_pemohon_luar."',
              source='".$p_pemohonL->source."' where id='".$p_pemohon->id."'";
    
    $this->db->query($query);
    $this->db->query($query);
    $query = "update tmpemohon_sementara_trkelurahan set trkelurahan_id = '".$p_pemohonL->trkelurahan->where("tmpemohon_id",$p_pemohonL->id)->get()->id."'
              where tmpemohon_sementara_id='".$p_pemohon->id."' and trkelurahan_id=".$p_pemohon->trkelurahan->where("tmpemohon_sementara_id",$p_pemohon->id)->get()->id;
    $this->db->query($query);
    redirect('pelayanan/komitmen_oss');
  }
      
  public function replacePerusahaan($id_daftar = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    
    $p_perusahaan = $u_daftar->tmperusahaan_sementara->get();
    $p_perusahaanL = $this->perusahaan->where('npwp',$p_perusahaan->npwp)->get();
    $p_kelurahan = $p_perusahaan->trkelurahan->get();    
    
    $query = "update tmperusahaan set npwp = '".$p_perusahaan->npwp."', no_reg_perusahaan = '".$p_perusahaan->no_reg_perusahaan."',
              n_perusahaan = '".$p_perusahaan->n_perusahaan."',i_telp_perusahaan = '".$p_perusahaan->i_telp_perusahaan."',
              a_perusahaan = '".$p_perusahaan->a_perusahaan."' where id='".$p_perusahaanL->id."'";
              
    $this->db->query($query);
    $query = "update tmperusahaan_trkelurahan set trkelurahan_id = '".$p_perusahaan->trkelurahan->where("tmperusahaan_sementara_id",$p_perusahaan->id)->get()->id."'
              where tmperusahaan_id='".$p_perusahaanL->id."' and trkelurahan_id=".$p_perusahaanL->trkelurahan->where("tmperusahaan_id",$p_perusahaanL->id)->get()->id;
    $this->db->query($query);
    redirect('pelayanan/komitmen_oss');
  }
      
  public function tetapPerusahaan($id_daftar = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($id_daftar);
    
    $p_perusahaan = $u_daftar->tmperusahaan_sementara->get();
    $p_perusahaanL = $this->perusahaan->where('npwp',$p_perusahaan->npwp)->get();
    $p_kelurahan = $p_perusahaan->trkelurahan->get();    
    
    $query = "update tmperusahaan_sementara set npwp = '".$p_perusahaanL->npwp."', no_reg_perusahaan = '".$p_perusahaanL->no_reg_perusahaan."',
              n_perusahaan = '".$p_perusahaanL->n_perusahaan."',i_telp_perusahaan = '".$p_perusahaanL->i_telp_perusahaan."',
              a_perusahaan = '".$p_perusahaanL->a_perusahaan."' where id='".$p_perusahaan->id."'";
    
    $this->db->query($query);
    $query = "update tmperusahaan_sementara_trkelurahan set trkelurahan_id = '".$p_perusahaanL->trkelurahan->where("tmperusahaan_id",$p_perusahaanL->id)->get()->id."'
             where tmperusahaan_sementara_id='".$p_perusahaan->id."' and trkelurahan_id=".$p_perusahaan->trkelurahan->where("tmperusahaan_sementara_id",$p_perusahaan->id)->get()->id;
    $this->db->query($query);
    redirect('pelayanan/komitmen_oss');
  }
   
  public function list_index($id_syarat = NULL){
    $this->username->where('username', $this->session->userdata('username'))->get();
    $user_lokasi = $this->username->lokasi;
    $jenis_p = $this->jenispermohonan->get_by_id($this->jenis_id);
    $data['list'] = $this->pendaftaran
                         ->where('c_pendaftaran', 2)  //2 -> Pendaftaran komitmen_oss (Online)
                         ->where('c_izin_selesai', 0) //SK Belum diserahkan
                         ->where('c_izin_dicabut', 0) //Permohonan tidak dicabut
                         ->where_related($jenis_p)    //Izin Baru = 1
                         ->order_by('id', 'DESC')->get();
    $data['list_izin'] = $this->perizinan->order_by('id', 'ASC')->get();
    $data['list_jenispermohonan'] = $jenis_p;
    $data['jenis_id'] = $this->jenis_id;
    $data['ket_syarat'] = $id_syarat;
    $data['user_lokasi'] = $user_lokasi;
    $this->load->vars($data);
    
    $js = "
           function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
           $(document).ready(function() {
             oTable = $('#pendaftaran').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             $('#paralel_id').change(function(){
               $('#show_jenis_izin').fadeOut();
               $.post('" . base_url() . "pelayanan/komitmen_oss/izin_paralel', {
                 jenis_paralel_id: $('#paralel_id').val()
                 }, function(response){setTimeout(\"finishAjax('show_jenis_izin', '\"+escape(response)+\"')\", 400);
               });
               return false;
             });
           });
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
         ";
    
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Data Permohonan OnLine";
        $this->template->build('oss_list', $this->session_info);
  }
  
  function get_perizinan_baru($id) {
    $sql = "SELECT c_show_type,status_new FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id = '$id'";
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
      if($row->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
      if(strlen($rule) < $plv) {
        $len = $plv - strlen($rule);
        $rule = str_repeat("0", $len) . $rule;
      }
      if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
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
    //var_dump($arr);
  }
  
  function get_jml_syarat($id) {
    $dum = $this->get_perizinan_baru($id);
    $query = "SELECT COUNT(*) as jml FROM
              trperizinan_trsyarat_perizinan
              INNER JOIN
              trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
              INNER JOIN
              trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
              WHERE trsyarat_perizinan.`status` = '1' and trperizinan.id = " . $id . " and c_show_type IN ('" . implode("','", $dum) . "')
              GROUP BY n_perizinan";
    $hasil = $this->db->query($query);
    return ;//$hasil->row();
  }
  
  /*
   * edit is a method to show page for updating data
   */

  public function edit($id_daftar=NULL) {  // edit pada proses permohonan komitmen_oss
    $u_daftar = $this->pemohon_portal->get_by_id($id_daftar);
  
    $this->username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->username->lokasi;
  
    $data = $this->_funcwilayah();
  
    // Check Izin Paralel
    $data_paralel = "no"; //$this->input->post('paralel');
    $kd_izin = $u_daftar->izin;
    $data['paralel'] = $data_paralel;
    if($data_paralel == "no")
      $simpan = "save";
    else
      $simpan = "save_paralel";
  
    $app_city = $this->settings->where('name', 'app_city')->get();
    $prop = $this->get_id($app_city->value);
    $idkab = NULL;
    $idkec = NULL;
    $idkel = NULL;
    foreach ($prop as $key) {
      $idkab = $key->trpropinsi_id;
    }
  
    $data['user'] = $this->username->id;
    $data['eror'] = "";
    $data['save_method'] = $simpan;
    $data['id_daftar_ol'] = $id_daftar;
    $data['id_link'] = "";
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['no_refer'] = $u_daftar->referensi;
    $data['nama_pemohon'] = $u_daftar->namaPemohon;
    $data['no_telp'] = $u_daftar->telpPemohon;
    $data['check_ctr'] = 0;
    $data['cmbsource'] = NULL;
    $data['propinsi_pemohon'] = $u_daftar->propinsi1; // ' ';
    $data['kabupaten_pemohon'] = $u_daftar->kabupaten1; // NULL;
    $data['kecamatan_pemohon'] = $u_daftar->kecamatan1; // NULL;
    $data['kelurahan_pemohon'] = $u_daftar->kelurahan1; // NULL;
    $data['jenis_kegiatan'] = "ok";
    $data['jenis_investasi'] = "ok";
    $data['propinsi_usaha'] = $u_daftar->propinsi2; // ' ';
    $data['kabupaten_usaha'] = $u_daftar->kabupaten2; // NULL;
    $data['kecamatan_usaha'] = $u_daftar->kecamatan2; // NULL;
    $data['kelurahan_usaha'] = $u_daftar->kelurahan2; // NULL;
  
    $data['tgl_daftar'] = date("Y-m-d");
    $data['tgl_survey'] = "";
    $data['lokasi_izin'] = $u_daftar->lokasi_izin;
    $data['rincian_lokasi'] = "";
    $data['keterangan'] = "";
    $data['cmbgerai'] = "";
    $data['no_antri'] = "";
    $data['kd_kontak'] = $u_daftar->telpPemohon;
    $data['alamat_pemohon'] = $u_daftar->almtPemohon;
    $data['alamat_pemohon_luar'] = "";
    $data['npwp'] = $u_daftar->npwpPerusahaan;
    $data['nodaftar'] = "OnLine";
    $data['fax'] = "";
    $data['email'] = $u_daftar->emailPerusahaan;
    $data['nama_perusahaan'] = $u_daftar->namaPerusahaan;
    $data['telp_perusahaan'] = $u_daftar->telpPerusahaan;
    $data['fax_perusahaan'] = $u_daftar->faxPerusahaan;
    $data['alamat_usaha'] = $u_daftar->almtPerusahaan;
    $data['id_permohonan_portal'] = $u_daftar->id_permohonan_portal;
    $data['rt'] = "";
    $data['rw'] = "";
    $data['lokasi_user'] = $lokasi_user;
  
    // PBS tambahan utk data teknis
    $data['id_izin'] = $u_daftar->izin;
  
    //Khusus Izin Paralel 
    $paralel_jenis = new trparalel();
    //$data['jenis_paralel'] = $paralel_jenis->get_by_id($this->input->post('jenis_paralel'));
  
    $id="";
    if($data_paralel == "no") {
      $data_izin = $this->perizinan->get_by_id($u_daftar->izin);
      $jml = $this->get_jml_syarat($id, 'seri');
      if(!empty($jml->jml)) {
        $data['jml_syarat'] = $jml->jml;
      }else{
        $data['jml_syarat'] = "";
      }
    }
    $jenis_permohonan = '1'; //$this->input->post('jenis_permohonan');   // 1 permohonan baru
    $data['group'] = $this->username->group;
    $data['mohon'] = $jenis_permohonan;
    $data['izin'] = $id; //$this->input->post('jenis_izin');
    $data['jenis_izin'] = $data_izin;
    $data['list_izin_paralel'] = ''; //$this->input->post('list_izin_paralel');
    
    //Kelompok Izin
    //$data['kelompok_izin'] = $this->kelompok_izin->get_by_id($this->input->post('jenis_izin'));
    $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($id);
      
    //Jenis Permohonan
    //$data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($this->input->post('jenis_permohonan'));
    $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($jenis_permohonan);
      
    //Syarat Perizinan
    $syarat_perizinan = new trsyarat_perizinan();
    $data['syarat_izin'] = $syarat_perizinan->where_related($data_izin)->order_by('status', 'asc')->get();
  
    //cek Online pajak
    $this->settings->where('name', 'app_web_service')->get();
    $statusOnline = $this->settings->status;
    $data['statusOnline'] = $statusOnline;
  
    //cek Online penduduk
    $this->settings->where('name', 'web_service_penduduk')->get();
    $statusOnline2 = $this->settings->status;
    $data['statusOnline2'] = $statusOnline2;
  
    //id data permohonan di database portal
    $data['id_portal'] = $u_daftar->id_permohonan_portal;
    
    // username pemohon
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $sql1 = "select id from tm_pemohon where id='".$u_daftar->id_pemohon."'";    // ambil pemohon
    $sql  = "select tm_pemohon.username from tm_pemohon,tmpermohonan_portal where tmpermohonan_portal.id='".$u_daftar->id_permohonan_portal.
    	     "' and tmpermohonan_portal.id_pemohon=tm_pemohon.id";
    if(count($otherdb->query($sql1)->result()) == 0){
    	echo 'Data Pemohon Tidak Ditemukan'; die;
    }else{
    	$username_portal = $otherdb->query($sql)->first_row();
    }
    $data['username_portal'] = $username_portal->username;
    
    // iqbal ambil data property dari portal
    $permohonan_dari_portal	= $otherdb->get_where("tmpermohonan_portal",array("id"=>$u_daftar->id_permohonan_portal))->row_array();
    $permohonan_dari_portal2 = $otherdb->get_where("tmpermohonan_portal",array("id"=>$u_daftar->id_permohonan_portal))->first_row();
    $data["editable"] = $permohonan_dari_portal2->editable;
    		
    $otherdb->order_by("id","asc");
    $asistensi = $otherdb->get_where("asistensi",array("id_permohonan"=>$u_daftar->id_permohonan_portal))->result();
    
    $data["asistensi"] = $asistensi;
    $data["id_kembali"] = $id_daftar;
    	
    // var_dump($permohonan_dari_portal);
    $no=1;
    $data_array[0] = '';
    //echo count($permohonan_dari_portal); die;
    while($no<=100){
    	$tek = "dt_teknis".$no;
    	$prop = $permohonan_dari_portal[$tek];
    	//if(empty($prop)){
    	//	break;
    	//}
    	$dt_teknis = explode("^-",$prop);
    	$data_array[$no-1] = $dt_teknis[0];
    	$no++;
    }	
    if(count($data_array)>0){
      $data['input_properti'] 	= $data_array;
      $data['jumlah_properti'] 	= count($data_array);
    }
    // die;
    // EOF() iqbal ambil data property dari portal
    
    $js = "
            $(document).ready(function() {
              $('#form').validate();
              $(\"#tabs\").tabs();
    
              $('a[rel*=pemohon_box]').facebox();
              $('a[rel*=daftar_box]').facebox();
              $('a[rel*=perusahaan_box]').facebox();
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
    
            function show_npwp(form) {
              var reg = form.nodaftar.value;
              var npwp = form.npwp_id.value;
              if(npwp.length==0) {
                  alert('Npwp harus diisi');
                  return false;
              }else 
    	          if(reg.length==0) {
                  alert('No daftar Harus diisi');
                  return false;
                }else{
                  $.post('" . base_url() . "pelayanan/pendaftaran/pick_perusahaan_data/'+reg, 
    			          { data_npwp_id: $('#npwp_id').val() }, 
    				        function(response){
                      setTimeout(\"finishAjax('tabs-2', '\"+escape(response)+\"')\", 400);
                    }
    			        );
                  return false;
                }
            }
    
            function show_ktp(form) {
              var reg = form.no_refer.value;
              if(reg.length==0) {
                $('#error_id').html('Id tidak Boleh Kosong');
                return false;
              }else {
                $('#error_id').html('');
                $.post('" . base_url() . "pelayanan/pendaftaran/pick_penduduk_data', 
    		          { data_no_refer: $('#no_refer').val() }, 
    			        function(response){
                    setTimeout(\"finishAjax('tabs-1', '\"+escape(response)+\"')\", 400);
                  }
    		        );
                return false;
              }
            }
    
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
    $this->session_info['page_name'] = "Proses Permohonan OnLine ";
    $this->template->build('oss_edit', $this->session_info);
  }
  
  public function tampil_pdf($dir1=NULL, $dir2=NULL, $file=NULL, $n_syarat=NULL) {    // Tampilkan PDF
    $data['dir1'] = $dir1;
    $data['dir2'] = $dir2;
    $data['file'] = $file;
    $data['page_name'] = "Persyaratan : ".$n_syarat;
    $this->load->vars($data);
    $this->load->view('tampil_pdf', $data);
  }
  
  function get_id($idkab) {
    $sql = "select a.n_kabupaten, trpropinsi_id  from trkabupaten as a 
            inner join trkabupaten_trpropinsi as b ON b.trkabupaten_id = a.id
            where a.id  = '" . $idkab . "' ";
    $query = $this->db->query($sql);
    return $query->result();
  }
  
  public function save() {   // Simpan Pendaftaran Baru
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $perizinan = new trperizinan();
    $perizinan->get_by_id($this->input->post('jenis_izin_id'));
    $perizinan_sektor = new trperizinan_trsektor();
    $perizinan_sektor->where('trperizinan_id', $this->input->post('jenis_izin_id'))->get();
    $kd_sektor = $perizinan_sektor->trsektor_id;
    $id_daftar_ol = $this->input->post('id_daftar_ol');
      
    $jenis_permohonan = new trjenis_permohonan();
    $jenis_permohonan->get_by_id($this->input->post('jenis_permohonan_id'));
  
    /* Cek Persyaratan Izin  */
    $syarat_perizinan = new trsyarat_perizinan();
    $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
    $syarat_izin = new trsyarat_perizinan();
    $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();
  
    $syarat = $this->input->post('pemohon_syarat');
    $syarat_len = count($syarat);
  
    // *********** improvement 15 sep *************
    $izin_len = 0;
    $wajib_len = 0;
    foreach ($list_syarat as $data) {
      $show_syarat = new trperizinan_syarat();
      $show_syarat->where('trsyarat_perizinan_id', $data->id)
                  ->where('trperizinan_id', $perizinan->id)->get();
      $var = $show_syarat->c_show_type;
  
      //$rule = strval(decbin($var));
      //if (strlen($rule) < 4) {
      //    $len = 4 - strlen($rule);
      //    $rule = str_repeat("0", $len) . $rule;
      //}
      //$arr_rule = str_split($rule);
      //$c_daftar_ulang = $arr_rule[0];
      //$c_baru = $arr_rule[1];
      //$c_perpanjangan = $arr_rule[2];
      //$c_ubah = $arr_rule[3];
  
  	  $rule = strval(decbin($var));
      if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
      if (strlen($rule) < $plv) {
          $len = $plv - strlen($rule);
          $rule = str_repeat("0", $len) . $rule;
      }
      if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
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
      if($syarat_status == '1') {
        $izin_len++;
        $is_array = NULL;
        for($i = 0; $i < $syarat_len; $i++) {
          if($is_array !== $syarat[$i]) {
            if($show_syarat->trsyarat_perizinan_id == $syarat[$i]) $wajib_len++;
          }
          $is_array = $syarat[$i];
        }
      }
    }
  
    /* Penomoran Pendaftaran Awal */
    $data_id = new tmpermohonan();
  
    $data_id->select_max('id')->get();
    $data_id->get_by_id($data_id->id);
  
    $data_tahun = substr($this->input->post('tgl_daftar'), 0, 4);
    //Per Tahun Auto Restart NoUrut
    if($data_id->d_tahun === $data_tahun) {
      $data_urut = $data_id->i_urut + 1;
      $year = new year();                          // PBS
  	  $year->where('tahun', $data_tahun);          // PBS
  	  $year->update('no_urut', $data_urut);        // PBS
    }else{
  	  $year = new year();                          // PBS
  	  $year->where('tahun', $data_tahun)->get();   // PBS
  	  $data_urut = $year->no_urut;
      if($year->tahun === $data_tahun) {           // PBS
    	  $year = new year();                        // PBS
  		  $year->where('tahun', $data_tahun);
        $data_urut++;                              // PBS
  		  $year->update('no_urut', $data_urut);      // PBS
      }else{
        $data_urut = 1;
        $year = new year();
        $year->tahun = $data_tahun;
        $year->no_urut = $data_urut;
        $year->save();
      }                                            // PBS
    }
  
    $i_urut = strlen($data_urut);
    for($i = 5; $i > $i_urut; $i--) {
      $data_urut = "0" . $data_urut;
    }
  
    $data_izin = $perizinan->id;
    $i_izin = strlen($data_izin);
    for($i = 3; $i > $i_izin; $i--) {
      $data_izin = "0" . $data_izin;
    }
  
    $data_jenis = $jenis_permohonan->id;
    $i_izin = strlen($data_jenis);
    for($i = 2; $i > $i_izin; $i--) {
      $data_jenis = "0" . $data_jenis;
    }
  
    $data_bulan = substr($this->input->post('tgl_daftar'), 5, 2); // PBS
    $i_bulan = strlen($data_bulan);
    for($i = 2; $i > $i_bulan; $i--) {
      $data_bulan = "0" . $data_bulan;
    }
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $user_id = $username->id;
    $u_id = strlen($user_id);
    for($i = 3; $i > $u_id; $i--) {
      $user_id = "0" . $user_id;
    }
  
    $permohonan = new tmpermohonan();
    $permohonan->i_urut = $data_urut;
    $permohonan->d_tahun = $data_tahun;
  
    $app_folder = new settings();
    $app_folder->where('name', 'app_folder')->get();
    $app_folder = $app_folder->value;
    // menyusun nomor pendaftaran
    if($app_folder === "Bantul") {   // untuk bantul
      $nomor_pendaftaran = $data_urut . "/" . $data_izin . "/" . $data_jenis . "/" . $data_bulan . "/" . $data_tahun;
    }else{
      $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun . $user_id;
    }
  
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    if($username->id) {
      $userid = $username->username;
      $user = $username->realname;
    }else{
  	  $userid = "................................";
      $user = "................................";
    }
  
    // input no pendaftaran ke portal
    $data = array('no_permohonan'	=> $nomor_pendaftaran);
    $id_permohonan_portal	= htmlspecialchars($_POST['id_permohonan_portal'],ENT_QUOTES);
    $otherdb->where('id', $id_permohonan_portal);
    $otherdb->update('tmpermohonan_portal', $data); 
    // input no pendaftaran ke portal
  
    // update status tampil tmpemohon_portal
    $data = array("tampil" 	=> "0");
    $this->db->where('id', htmlspecialchars($_POST['id_daftar_ol'],ENT_QUOTES));
    $this->db->update('tmpemohon_portal', $data); 
    // update status tampil tmpemohon_portal
    
    // input dt_teknis ke tmpermohonan
  	$jumlah_properti	= htmlspecialchars($_POST['jumlah_properti'],ENT_QUOTES);
  	$no=1;
  	while($no<=$jumlah_properti){
  		$dat	= "dt_teknis".$no;
  		$permohonan->$dat = htmlspecialchars($_POST['properti_'.$no],ENT_QUOTES);
  		$no++;
  	}
    // input dt_teknis ke tmpermohonan
      
    $permohonan->i_entry = $user;
    $permohonan->pendaftaran_id = $nomor_pendaftaran;
    $permohonan->id_pemohon_portal = $id_daftar_ol;
    $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
    $permohonan->d_terima_berkas_asli = date('Y-m-d');
    $permohonan->d_survey = $this->input->post('tgl_survey');
    $permohonan->a_izin = $this->input->post('lokasi_izin');
    $permohonan->keterangan = $this->input->post('keterangan');
    $permohonan->kd_gerai = $this->input->post('cmbgerai');
    $permohonan->trsektor_id = $kd_sektor;
    $permohonan->no_antri = $this->input->post('no_antri');
    $permohonan->kontak_person = $this->input->post('kd_kontak');
  
    $tgl_skr = $this->lib_date->get_date_now();
    $permohonan->d_entry = $tgl_skr;
  
    $tgl_entry = $this->input->post('tgl_daftar');
    $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
    $permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS
  
    $permohonan->save($perizinan);
    /* EOF() Penomoran Pendaftaran Awal */
  
    $permohonan_akhir = new tmpermohonan();
    $permohonan_akhir->select_max('id')->get();
    
    /* Input Data Pemohon */
    $pemohon = new tmpemohon();
    if ($this->input->post('id_pemohon'))
        $pemohon->get_by_id($this->input->post('id_pemohon'));
    $pemohon->source = $this->input->post('cmbsource');
    $pemohon->no_referensi = $this->input->post('no_refer');
  
    $pemohon->n_pemohon = $this->input->post('nama_pemohon');
    $pemohon->telp_pemohon = $this->input->post('no_telp');
    $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
    $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
  
    $pemohon->cek_prop = "0";
    $kelurahan_p = new trkelurahan();
    $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
  
    $pemohon->save(array($permohonan_akhir, $kelurahan_p));
  
    /* Input Data Index Dokumen */
    if(!$this->input->post('id_pemohon')) {
      $pemohon_akhir = new tmpemohon();
      $pemohon_akhir->select_max('id')->get();
      $inisial = strtoupper(substr($this->input->post('nama_pemohon'), 0, 1));
      $archive_lama = new tmarchive();
      $archive_lama->where('i_inisial', $inisial)
                   ->order_by('id DESC')
                   ->get();
      if($archive_lama->id) {
        $archive_lama->get_by_id($archive_lama->id);
        $data_urut_index = $archive_lama->i_urut + 1;
      }else
        $data_urut_index = 1;
  
      //Nomor Urut Index
      $i_urut_index = strlen($data_urut_index);
      for($i = 3; $i > $i_urut_index; $i--) {
        $data_urut_index = "0" . $data_urut_index;
      }
      $grup = substr($data_urut_index, 0, 1) + 1;
      $archive = new tmarchive();
      $archive->i_archive = $inisial . $grup . "-" . $data_urut_index;
      $archive->i_inisial = $inisial;
      $archive->i_urut = $data_urut_index;
      $archive->save($pemohon_akhir);
    }
  
    /* Input Data Perusahaan */
    if($this->input->post('nama_perusahaan')) {
      $perusahaan = new tmperusahaan();
      if($this->input->post('id_perusahaan'))
        $perusahaan->get_by_id($this->input->post('id_perusahaan'));
      $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
      $perusahaan->npwp = $this->input->post('npwp');
      $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
      $perusahaan->rt = $this->input->post('rt');
      $perusahaan->rw = $this->input->post('rw');
      $perusahaan->fax = $this->input->post('fax');
      $perusahaan->email = $this->input->post('email');
      $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
      $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
      $kelurahan_u = new trkelurahan();
      $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
      $kegiatan = new trkegiatan();
      $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
      $investasi = new trinvestasi();
      $investasi->get_by_id($this->input->post('jenis_investasi'));
      $perusahaan->save(array($permohonan_akhir, $kelurahan_u, $kegiatan, $investasi));
    }
  
    /* Hapus Data Syarat Perizinan Lama */
    $syarat_old = new tmpermohonan_trsyarat_perizinan();
    $list_syarat = $syarat_old->where('tmpermohonan_id', $permohonan_akhir->id)->get();
    foreach($list_syarat as $row){
      $syarat_old->where('id', $row->id)->get();
  	  if($row->tmpermohonan_id == $permohonan_akhir->id) {
        $syarat_old->delete();
      }
    }
  
    $syarat = $this->input->post('pemohon_syarat');
    $syarat_len = count($syarat);
  
    $is_array = NULL;
    for($i = 0; $i < $syarat_len; $i++) {
      if($is_array !== $syarat[$i]) {
        $syarat_daftar = new tmpermohonan_trsyarat_perizinan();
        $syarat_daftar->tmpermohonan_id = $permohonan_akhir->id;
        $syarat_daftar->trsyarat_perizinan_id = $syarat[$i];
        $syarat_daftar->save();
      }
      $is_array = $syarat[$i];
    }
  
    /* Input Data Tracking Progress saat di Front Office*/
    $tracking_izin = new tmtrackingperizinan();
    $tracking_izin->pendaftaran_id = $nomor_pendaftaran;
    $tracking_izin->status = 'Insert';
    $tracking_izin->d_entry_awal = $this->input->post('waktu_awal');
    $tracking_izin->d_entry = $this->lib_date->get_date_now();
    $tracking_izin->tr_user = $userid;
    $tracking_izin->tr_name = $user;
    $tracking_izin->tr_activiti = 'Front Office'; // hati-hati mengganti kata 'Front Office'
    $sts_izin = new trstspermohonan();
    $sts_izin->get_by_id('2');                    //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
    $sts_izin->save($permohonan_akhir);
    $tracking_izin->save($sts_izin);
    $tracking_izin->save($permohonan_akhir);
    /* EOF() Input Data Tracking*/
  
    $permohonan_akhir->save($jenis_permohonan);
  
    //cari id_daftar
    $permohonan = new tmpermohonan();
    $permohonan->where('pendaftaran_id', $nomor_pendaftaran)->get();
    $id_daftar = $permohonan->id;
  
    // Tracking utk Kirim dari pendaftaran baru
    // proses ini menyimpan spt prog /pelayanan/control/pendaftaran.php (harus sesuai)
    $u_ser = $this->session->userdata('username');
    $r_name = $this->lib_date->get_nama_ori($u_ser);
  
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($id_daftar);
    $permohonan->c_pendaftaran = 1;
  
    $data_permohonan = $this->db->get_where("tmpermohonan",array("id"=>$id_daftar))->first_row();
    $no_pendaftaran = $permohonan->pendaftaran_id;
    $kd_gerai = $permohonan->kd_gerai;
  
    $tracking_izin = new tmtrackingperizinan();
    $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                  ->where('tr_activiti', 'Kirim Ke Pelayanan')->get();
    if($tracking_izin->pendaftaran_id){
      $tracking_izin->status = 'Update';
      $tracking_izin->d_entry = $this->lib_date->get_date_now();
      $tracking_izin->tr_user = $u_ser;
      $tracking_izin->tr_name = $r_name;
  	  $tracking_izin->tr_activiti = 'Kirim Ke Pelayanan';
      $tracking_izin->save();
    }else{
      $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                    ->where('tr_activiti', 'Front Office')->get();
      if($tracking_izin->pendaftaran_id){
        $tracking_izin->status = 'Update';
        $tracking_izin->d_entry = $this->lib_date->get_date_now();
        $tracking_izin->tr_user = $u_ser;
        $tracking_izin->tr_name = $r_name;
        $tracking_izin->tr_activiti = 'Kirim Ke Pelayanan';
        $tracking_izin->save();
      }
    }
  
    // Menyiapkan slot untuk tracking Entry Data
    $tracking_izin2 = new tmtrackingperizinan();
    $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                   ->where('tr_activiti', 'Entry Data')->get();
    if(!$tracking_izin2->pendaftaran_id){
      $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
      $tracking_izin2->status = 'Insert';
      $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
      $tracking_izin2->d_entry = $this->lib_date->get_date_now();
      $tracking_izin2->tr_activiti = 'Entry Data';
  
      $sts_izin2 = new trstspermohonan();
      $sts_izin2->get_by_id('3');     //Entry Data [Lihat Tabel trstspermohonan()]
      $sts_izin2->save($permohonan);
      $tracking_izin2->save($permohonan);
      $tracking_izin2->save($sts_izin2);
    }
    $permohonan->save();
    // EOF() Tracking utk Kirim dari pendaftaran baru
  
    // Tracking utk Edit data Entry data Pelayanan
    // proses ini menyimpan spt prog /pendataan/control/pendataan.php (harus sesuai)
    $u_ser = $this->session->userdata('username');
    $r_name = $this->lib_date->get_nama_ori($u_ser);
  
    $permohonan = new tmpermohonan();
    $daftar_id = $id_daftar;
    $permohonan->get_by_id($daftar_id);
    $no_pendaftaran = $permohonan->pendaftaran_id;
    if($permohonan->kd_status == 0){ // ubah kd_status menjadi 1 untuk proses selanjutnya (Penjadualan Tinjauan)
      $permohonan->kd_status = 1;
      $permohonan->save();
    }
  
    $izin = $permohonan->trperizinan->get();
    $kelompok = $izin->trkelompok_perizinan->get();
    $kel_izin = $kelompok->id;
    if($kel_izin == "1") $id_status = "4";     //Rekomendasi [Lihat Tabel trstspermohonan()]   -> kominfo old 5
    if($kel_izin == "2") $id_status = "4";     //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
    if($kel_izin == "3") $id_status = "4";     //Pembuatan BAP [Lihat Tabel trstspermohonan()] -> kominfo old 6
    if($kel_izin == "4") $id_status = "4";     //PBS create
    if($kel_izin == "5") $id_status = "4";     //PBS create
    $status_izin = $permohonan->trstspermohonan->get();
    $status_skr = "3";                         //Entry Data [Lihat Tabel trstspermohonan()]    -> kominfo old 3
    if($status_izin->id == $status_skr){
      /* Input Data Tracking Progress */
      $tracking_izin = new tmtrackingperizinan();
      $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                    ->where('tr_activiti', 'Entry Data')->get();
      if($tracking_izin->pendaftaran_id){
        $tracking_izin->status = 'Update';
        $tracking_izin->d_entry = $this->lib_date->get_date_now();
        $tracking_izin->tr_user = $u_ser;
        $tracking_izin->tr_name = $r_name;
  	    $hit_ubah = $tracking_izin->hit_ubah + 1;
  		  $his_ubah = $tracking_izin->his_ubah;
    		$tracking_izin->hit_ubah = $hit_ubah;
    	  $tracking_izin->his_ubah = $his_ubah.'PEL.ENTRY^'.$r_name.'^'.$this->lib_date->get_date_now().';';
        $tracking_izin->tr_activiti = 'Entry Data';
        $tracking_izin->save();
      }
  
      /* [Lihat Tabel trstspermohonan()] */
  	  // Menyiapkan Slot untuk Pertimbangan Teknis
      $tracking_izin2 = new tmtrackingperizinan();
      $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                     ->where('tr_activiti', 'Pertimbangan Teknis')->get();
      if(!$tracking_izin2->pendaftaran_id){  // jika tidak ditemukan
        $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
        $tracking_izin2->status = 'Insert';
        $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
        $tracking_izin2->d_entry = $this->lib_date->get_date_now();
    		$tracking_izin2->tr_activiti = 'Pertimbangan Teknis';
        $sts_izin2 = new trstspermohonan();
        $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
        $sts_izin2->save($permohonan);
        $tracking_izin2->save($permohonan);
        $tracking_izin2->save($sts_izin2);
      }
  
      //if($id_status == "5" || $id_status == "6"){    // old kominfo
			if($id_status == "4"){             // Survai Lokasi [Lihat Tabel trstspermohonan()]
        $data_id = new tmbap();
        $data_id->select_max('id')->get();
        $data_id->get_by_id($data_id->id);
        $data_tahun = date("Y");
        //Per Tahun Auto Restart NoUrut
        if($permohonan->d_tahun == $data_tahun)
        $data_urut = $data_id->i_urut + 1;
        else $data_urut = 1;

        $i_urut = strlen($data_urut);
        for($i=4;$i>$i_urut;$i--){
            $data_urut = "0".$data_urut;
        }

        $data_izin = $izin->id;
        $i_izin = strlen($data_izin);
        for($i=3;$i>$i_izin;$i--){
            $data_izin = "0".$data_izin;
        }

        $data_bulan = $this->lib_date->set_month_roman(date("n"));

        $data_bap = "BAP";
        $no_bap = $data_urut."/".$data_bap."/".$data_izin."/".$data_bulan."/".$data_tahun;
        $data_skrd = "SKRD";
        $no_skrd = $data_urut."/".$data_skrd."/".$data_izin."/".$data_bulan."/".$data_tahun;
        
        $bap2 = new tmbap();
        $bap2->bap_id = $no_bap;
        $bap2->no_skrd = $no_skrd;
        $bap2->tgl_bap = $this->lib_date->get_date_now();
        $bap2->pendaftaran_id = $permohonan->pendaftaran_id;
        $bap2->i_urut = $data_urut;
        
        if($kel_izin == "5") {               // jika kelompok perijinan = Work Flow  (agar ditampilkan di penetapan izin)
        	$bap2->c_pesan = 'Work Flow';
        }
        if($kel_izin == "1" || $kel_izin == "3") { // jika kelompok perijinan = Tanpa Tinjauan Lapangan  (agar ditampilkan di penetapan izin)
          $bap2->c_pesan = 'Tanpa Tinjauan Lapangan';
        }
        if($kel_izin == "2" || $kel_izin == "4") { // jika kelompok perijinan = Tanpa Tinjauan Lapangan  (agar ditampilkan di penetapan izin)
          $bap2->c_pesan = 'Dengan Tinjauan Lapangan';
        }
        $bap2->save($permohonan);
      }
    }
  	// EOF() Tracking utk Edit data Entry data Pelayanan
    
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $permohonan_portal = $otherdb->get_where("tmpermohonan_portal",array("id"=>$id_permohonan_portal))->first_row();
    $user = $otherdb->get_where("tm_pemohon",array("id"=>$permohonan_portal->id_pemohon))->first_row();
    $perizinan = $this->db->get_where("trperizinan",array("id"=>$permohonan_portal->id_perizinan))->first_row();
    $status	= $this->db->get_where('trstspermohonan',array("id"=>4))->first_row();
    
    $this->settings->where('name', 'smsGateway')->get();
    if($this->settings->status == 1){
      $gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
      $data = array('DestinationNumber'	=> $user->telpPemohon,
                    'TextDecoded'		=> "Pengajuan ".$perizinan->n_perizinan." atas nama ".$user->namaPerusahaan." berganti status menjadi : ".$status->n_sts_permohonan,
                    'CreatorID' 			=> "Gammu",
      );
      $gammu->insert('outbox',$data);
    }
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql2($u_ser);
    //$p = $this->db->query("call log ('Pendaftaran Online','Insert " . $nomor_pendaftaran . "','" . $tgl . "','" . $u_ser . "')");
    
    redirect('pelayanan/komitmen_oss');
  }
    
  public function sql2($u_ser) {
    $query = "select a.description
              from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='" . $u_ser . "')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }
    
  public function delete($uid = NULL) {
    $u_daftar = $this->pemohon_portal->get_by_id($uid);
    $u_daftar->delete();
    redirect('pelayanan/komitmen_oss');
  }
  
  public function edit_OLD($id_daftar = NULL, $id_link = NULL) {  // edit pada proses permohonan komitmen_oss
    $u_daftar = $this->pemohon_portal->get_by_id($id_daftar);
        
    $p_pemohon = $u_daftar->tmpemohon_sementara->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
    $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
    $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    
    $u_perusahaan = $u_daftar->tmperusahaan_sementara->get();
    $u_kelurahan = $u_perusahaan->trkelurahan->get();
    $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
    $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
    $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    $u_kegiatan = $u_daftar->tmperusahaan_sementara->trkegiatan->get();
    $u_investasi = $u_daftar->tmperusahaan_sementara->trinvestasi->get();
    
    $d_izin = $u_daftar->trperizinan->get();
    $d_kelompok = $d_izin->trkelompok_perizinan->get();
    $d_jenis = $u_daftar->trjenis_permohonan->get();
    
    $data = $this->_funcwilayah();
    
    $data['eror'] = "";
    $data['save_method'] = "update";
    $data['id_daftar'] = $id_daftar;
    $data['paralel'] = "no";
    $paralel_jenis = new trparalel();
    $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
    $data['id_link'] = $id_link;
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['no_refer'] = $p_pemohon->no_referensi;
    $data['cmbsource'] = $p_pemohon->source;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['no_telp'] = $p_pemohon->telp_pemohon;
    $data['propinsi_pemohon'] = $p_propinsi->id;
    $data['kabupaten_pemohon'] = $p_kabupaten->id;
    $data['kecamatan_pemohon'] = $p_kecamatan->id;
    $data['kelurahan_pemohon'] = $p_kelurahan->id;
    $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
    $data['tgl_survey'] = $u_daftar->d_survey;
    $data['lokasi_izin'] = $u_daftar->a_izin;
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
    $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
    $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
    $data['npwp'] = $u_perusahaan->npwp;
    $data['noRegistrasi'] = $u_perusahaan->no_reg_perusahaan;
    $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
    $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
    $data['fax'] = $u_perusahaan->fax;
    $data['email'] = $u_perusahaan->email;
    $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
    $data['propinsi_usaha'] = $u_propinsi->id;
    $data['kabupaten_usaha'] = $u_kabupaten->id;
    $data['kecamatan_usaha'] = $u_kecamatan->id;
    $data['kelurahan_usaha'] = $u_kelurahan->id;
    $data['jenis_kegiatan'] = $u_kegiatan->id;
    $data['jenis_investasi'] = $u_investasi->id;
    $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
    $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
    $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
    
    $jml = $this->get_jml_syarat($d_izin->id);
    $data['jml_syarat'] = 0; //$jml->jml;
    
    $syarat_perizinan = new trsyarat_perizinan();
    $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
    $data['list_daftar'] = $u_daftar;
    
    //cek Online pajak
    $this->settings->where('name', 'app_web_service')->get();
    $statusOnline = $this->settings->status;
    $data['statusOnline'] = $statusOnline;
    
    //cek Online penduduk
    $this->settings->where('name', 'web_service_penduduk')->get();
    $statusOnline2 = $this->settings->status;
    $data['statusOnline2'] = $statusOnline2;
    
    $js = "
            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            $(document).ready(function() {
              $('#form').validate();
              $(\"#tabs\").tabs();
              $('a[rel*=perusahaan_box]').facebox();
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
            
            function show_npwp(form) {
              var reg = form.nodaftar.value;
              var npwp = form.npwp_id.value;
              
              if(npwp.length==0){
                alert('Npwp harus diisi');
                return false;
              }else 
                if (reg.length==0){
                  alert('No daftar Harus diisi');
                  return false;
                }else{
                  $.post('" . base_url() . "pelayanan/pendaftaran/pick_perusahaan_data/'+reg, {
                    data_npwp_id: $('#npwp_id').val()
                  }, function(response){
                      setTimeout(\"finishAjax('tabs-2', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
               }
            }
          
            function show_ktp(form) {
              var reg = form.idktp.value;
              //alert(reg);
              if(reg.length==0){
                $('#error_id').html('Id tidak Boleh Kosong');
                return false;
              }else{
                $('#error_id').html('');
                $.post('" . base_url() . "pelayanan/komitmen_oss/pick_penduduk_data', {
                    data_no_refer: $('#idktp').val()
                }, function(response){
                    setTimeout(\"finishAjax('tabs-1', '\"+escape(response)+\"')\", 400);
                });
                return false;
              }
            }
    
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
    $this->session_info['page_name'] = "Proses Permohonan OnLine";
    $this->template->build('oss_edit', $this->session_info);
  }
    
  public function edit2($id_daftar = NULL, $id_link = NULL) {
    $u_daftar = $this->pendaftaran->get_by_id($this->input->post('id_daftar'));

    $p_pemohon = $u_daftar->tmpemohon->get();
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

    //validasi pemohon
    $tgl_daftar = $this->input->post('tgl_daftar');
    $nama_pemohon = $this->input->post('nama_pemohon');
    $propinsi_p = $this->input->post('propinsi_pemohon');
    $kabupaten_p = $this->input->post('kabupaten_pemohon');
    $kecamatan_p = $this->input->post('kecamatan_pemohon');
    $kelurahan_p = $this->input->post('kelurahan_pemohon');
    $tlp = $this->input->post('no_telp');
    $ktp = $this->input->post('no_refer');
    $tgl_survey = $this->input->post('tgl_survey');
    $alamat = $this->input->post('alamat_pemohon');

    //validasi perusahaan
    $npwp = $this->input->post('no_registrasi');
    $nama_perusahaan = $this->input->post('nama_perusahaan');
    $tlp_perusahaan = $this->input->post('telp_perusahaan');
    $propinsi_u = $this->input->post('propinsi_usaha');
    $kabupaten_u = $this->input->post('kabupaten_usaha');
    $kecamatan_u = $this->input->post('kecamatan_usaha');
    $kelurahan_u = $this->input->post('kelurahan_usaha');
    $alamat_u = $this->input->post('alamat_usaha');
    $j_kegiatan = $this->input->post('jenis_kegiatan');
    $j_investasi = $this->input->post('jenis_investasi');

    $data = $this->_funcwilayah();
    $data['check'] = $this->input->post('pemohon_syarat');
    $data['save_method'] = "update";
    $data['id_daftar'] = $this->input->post('id_daftar');
    $data['paralel'] = "no";
    $paralel_jenis = new trparalel();
    $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
    $data['id_link'] = $id_link;
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['no_refer'] = $this->input->post('no_refer');
    $data['nama_pemohon'] = $this->input->post('nama_pemohon');
    $data['no_telp'] = $this->input->post('no_telp');
    $data['propinsi_pemohon'] = $this->input->post('propinsi_pemohon');
    $data['kabupaten_pemohon'] = $this->input->post('kabupaten_pemohon');
    $data['kecamatan_pemohon'] = $this->input->post('kecamatan_pemohon');
    $data['kelurahan_pemohon'] = $this->input->post('kelurahan_pemohon');
    $data['tgl_daftar'] = $this->input->post('tgl_daftar');
    $data['tgl_survey'] = $this->input->post('tgl_survey');
    $data['lokasi_izin'] = $this->input->post('lokasi_izin');
    $data['alamat_pemohon'] = $this->input->post('alamat_pemohon');
    $data['alamat_pemohon_luar'] = $this->input->post('alamat_pemohon_luar');
    $data['nama_perusahaan'] = $this->input->post('nama_perusahaan');
    $data['npwp'] = $this->input->post('npwp');
    $data['noRegistrasi'] = $this->input->post('no_registrasi');
    $data['telp_perusahaan'] = $this->input->post('telp_perusahaan');
    $data['fax'] = $this->input->post('fax');
    $data['email'] = $this->input->post('email');
    $data['alamat_usaha'] = $this->input->post('alamat_usaha');
    $data['propinsi_usaha'] = $this->input->post('propinsi_usaha');
    $data['kabupaten_usaha'] = $this->input->post('kabupaten_usaha');
    $data['kecamatan_usaha'] = $this->input->post('kecamatan_usaha');
    $data['kelurahan_usaha'] = $this->input->post('kelurahan_usaha');
    $data['jenis_kegiatan'] = $this->input->post('jenis_kegiatan');
    $data['jenis_investasi'] = $this->input->post('jenis_investasi');
    $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
    $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
    $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);

    if($nama_pemohon == "" || $tgl_daftar == "" || $tlp == "" || $ktp == "" || $alamat == "" || $propinsi_p == " " || $kabupaten_p == " " || $kecamatan_p == " " || $kelurahan_p == " " || $tgl_survey == " ") {
      $data['eror'] = "Data pemohon belum lengkap";
    }else
      if($npwp == "" || $nama_perusahaan == "" || $tlp_perusahaan == "" || $propinsi_u == " " || $kabupaten_u == " " || $kecamatan_u == " " || $kelurahan_u == " " || $alamat_u == " " ||
         $j_kegiatan == " " || $j_investasi == " ") {
        $data['eror'] = "Data perusahaan belum lengkap";
      }else {
        $data['eror'] = "Data persyaratan wajib belum lengkap";
      }

    $syarat_perizinan = new trsyarat_perizinan();
    $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
    $data['list_daftar'] = $u_daftar;
    
    $js = "
            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            $(document).ready(function() {
              $('#form').validate();
              $(\"#tabs\").tabs();
              $('a[rel*=perusahaan_box]').facebox();
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
            });

            $(document).ready(function() {
              $('#propinsi_pemohon_id').change(function(){
                $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', {
                  propinsi_id: $('#propinsi_pemohon_id').val()
                  },function(response){
                      setTimeout(\"finishAjax('show_kabupaten_pemohon', '\"+escape(response)+\"')\", 400);
                     
                  });
                  
                  $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_pemohon_idProp', {
                      propinsi_id: $('#propinsi_pemohon_id').val()
                  }, function(response){
                      setTimeout(\"finishAjax('show_kecamatan_pemohon', '\"+escape(response)+\"')\", 400);
                  });
                  
                  $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_pemohon_idProp', {
                     propinsi_id: $('#propinsi_pemohon_id').val()
                  }, function(response){
                      setTimeout(\"finishAjax('show_kelurahan_pemohon', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
                });
 
                $('#kabupaten_pemohon_id').change(function(){
                  $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_pemohon', {
                    kabupaten_id: $('#kabupaten_pemohon_id').val()
                  }, function(response){
                    setTimeout(\"finishAjax('show_kecamatan_pemohon', '\"+escape(response)+\"')\", 400);
                  });
                  
                  $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_pemohon_idKab', {
                    kabupaten_id: $('#kabupaten_pemohon_id').val()
                  }, function(response){
                    setTimeout(\"finishAjax('show_kelurahan_pemohon', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
                });
                
                $('#kecamatan_pemohon_id').change(function(){
                  $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_pemohon', {
                    kecamatan_id: $('#kecamatan_pemohon_id').val()
                    }, function(response){
                      setTimeout(\"finishAjax('show_kelurahan_pemohon', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
                });
              });

              $(document).ready(function() {
                $('#propinsi_usaha_id').change(function(){
                  $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', {
                  propinsi_id: $('#propinsi_usaha_id').val()
                  },function(response){
                      setTimeout(\"finishAjax('show_kabupaten_usaha', '\"+escape(response)+\"')\", 400);

                  });
                  
                  $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_usaha_idProp', {
                     propinsi_id: $('#propinsi_usaha_id').val()
                  }, function(response){
                      setTimeout(\"finishAjax('show_kecamatan_usaha', '\"+escape(response)+\"')\", 400);
                  });
                  
                   $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_usaha_idProp', {
                      propinsi_id: $('#propinsi_usaha_id').val()
                  }, function(response){
                      setTimeout(\"finishAjax('show_kelurahan_usaha', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
                });
                
                $('#kabupaten_usaha_id').change(function(){
                  $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_usaha', {
                    kabupaten_id: $('#kabupaten_usaha_id').val()
                  }, function(response){
                    setTimeout(\"finishAjax('show_kecamatan_usaha', '\"+escape(response)+\"')\", 400);
                  });
                  
                  $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_usaha_idKab', {
                     kabupaten_id: $('#kabupaten_usaha_id').val()
                  }, function(response){
                     setTimeout(\"finishAjax('show_kelurahan_usaha', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
                });
                
                $('#kecamatan_usaha_id').change(function(){
                  $.post('" . base_url() . "pelayanan/pendaftaran/kelurahan_usaha', {
                    kecamatan_id: $('#kecamatan_usaha_id').val()
                  }, function(response){
                    setTimeout(\"finishAjax('show_kelurahan_usaha', '\"+escape(response)+\"')\", 400);
                  });
                  return false;
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
    $data['cekPajak'] = $this->cekWebservicePajak($u_perusahaan->npwp, $u_perusahaan->no_reg_perusahaan);
    $data['cekPenduduk'] = $this->cekWebservicePenduduk($p_pemohon->no_referensi);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Proses Permohonan OnLine";
    $this->template->build('oss_edit', $this->session_info);
  }
  
  public function cekWebservicePenduduk($referensi) {
    //mysql_connect('localhost','root','') or die('tidak bisa koneksi');
    $query = mysql_query('select * from alp_penduduk.tmpemohon where no_referensi="' . $referensi . '"');
    if($query) {
      $result = mysql_fetch_row($query);
      return $result;
    }else {
      return "nothing";
    }
  }
  
  public function cekWebservicePajak($npwp, $registrasi) {
    $query = mysql_query('select * from alp_pajak.wp where npwp="' . $npwp . '" and no="' . $registrasi . '"');
    if($query) {
      $result = mysql_fetch_row($query);
      return $result;
    }else{
      return "nothing";
    }
  }
  
  public function update() {
    $perizinan = new trperizinan();
    $perizinan->get_by_id($this->input->post('jenis_izin_id'));
  
    /* Cek Persyaratan Izin */
    $syarat_perizinan = new trsyarat_perizinan();
    $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
    $syarat_izin = new trsyarat_perizinan();
    $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();
  
    $syarat = $this->input->post('pemohon_syarat');
    $syarat_len = count($syarat);
  
    $wajib_len = 0;
    foreach($list_syarat as $data) {
      $is_array = NULL;
      for($i = 0; $i < $syarat_len; $i++) {
        if($is_array !== $syarat[$i]) {
          if($data->id == $syarat[$i]) $wajib_len++;
        }
        $is_array = $syarat[$i];
      }
    }
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($this->input->post('id_daftar'));
    $permohonan->c_pendaftaran = 0;
    $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
    $permohonan->d_survey = $this->input->post('tgl_survey');
    $permohonan->a_izin = $this->input->post('lokasi_izin');
    $permohonan->tmpemohon->get();
    $permohonan->tmperusahaan->get();
  
    /* Input Data Pemohon */
    $p_pemohon = $permohonan->tmpemohon_sementara->get();
    $p_pemohonL = $this->pemohon->where('no_referensi',$p_pemohon->no_referensi)->count();
    $p_pemohon2 = $this->pemohon->where('no_referensi',$p_pemohon->no_referensi)->get();
            
    if($p_pemohonL >= '1'){
      $query = "update tmpemohon set no_referensi = '".$this->input->post('no_refer')."', 
                n_pemohon = '".$this->input->post('nama_pemohon')."',telp_pemohon = '".$this->input->post('no_telp')."',
                a_pemohon = '".$this->input->post('alamat_pemohon')."',a_pemohon_luar = '".$this->input->post('alamat_pemohon_luar')."'',
                source = '".$this->input->post('cmbsource')."'
                where no_referensi='".$p_pemohon->no_referensi."'"
               ;
            
      $query2 = "insert into tmpemohon_tmpermohonan (tmpermohonan_id,tmpemohon_id) values ('".$this->input->post('id_daftar')."',
                 '".$p_pemohon2->id."') ";
    
      $this->db->query($query);
      $this->db->query($query2);
    }else{
      $pemohon = new tmpemohon();
      //$pemohon->get_by_id($permohonan->tmpemohon->id);
      $pemohon->no_referensi = $this->input->post('no_refer');
      $pemohon->source = $this->input->post('cmbsource');
      $pemohon->n_pemohon = $this->input->post('nama_pemohon');
      $pemohon->telp_pemohon = $this->input->post('no_telp');
      $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
      $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
      $pemohon->trkelurahan->get();
      $pemohon_lurah = new tmpemohon_trkelurahan();
      $pemohon_lurah->where('tmpemohon_id', $permohonan->tmpemohon->id)->get();
      $pemohon_lurah->delete();
      $kelurahan_p = new trkelurahan();
      $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
      $pemohon->save($permohonan);
      if($this->input->post('Check_ctr')) {
        $pemohon->cek_prop = "0";
        $pemohon->save(array($kelurahan_p));
      }else{
        $pemohon->cek_prop = "1";
        $pemohon->save(array($kelurahan_p));
      }
    }
    
    /* Input Data Index Dokumen */
    $inisial = strtoupper(substr($this->input->post('nama_pemohon'), 0, 1));
    $archive_lama = new tmarchive();
    $archive_lama->where('i_inisial', $inisial)->order_by('id DESC')->get();
    if($archive_lama->id) {
      $archive_lama->get_by_id($archive_lama->id);
      $data_urut_index = $archive_lama->i_urut + 1;
    }else{
      $data_urut_index = 1;
    
      //Nomor Urut Index
      $i_urut_index = strlen($data_urut_index);
      for($i = 3; $i > $i_urut_index; $i--) {
        $data_urut_index = "0" . $data_urut_index;
      }
      $grup = substr($data_urut_index, 0, 1) + 1;
      $archive = new tmarchive();
      $archive->i_archive = $inisial . $grup . "-" . $data_urut_index;
      $archive->i_inisial = $inisial;
      $archive->i_urut = $data_urut_index;
      $archive->save($pemohon);
      
      /* Input Data Perusahaan */
      $p_perusahaan = $permohonan->tmperusahaan_sementara->get();
      $p_perusahaanL = $this->perusahaan->where('npwp',$p_perusahaan->npwp)->count();
      $p_perusahaan2 = $this->perusahaan->where('npwp',$p_perusahaan->npwp)->get();
      
      if($p_perusahaanL >= '1'){
        $query = "update tmperusahaan set npwp = '".$this->input->post('npwp')."', 
                  n_perusahaan = '".$this->input->post('nama_perusahaan')."',i_telp_perusahaan = '".$this->input->post('telp_perusahaan')."',
                  a_perusahaan = '".$this->input->post('alamat_usaha')."',fax = '".$this->input->post('fax')."',
                  email = '".$this->input->post('email')."',no_reg_perusahaan = '".$this->input->post('no_registrasi')."'
                  where npwp='".$p_perusahaan->npwp."'"
                 ;
              
        $query2 = "insert into tmpermohonan_tmperusahaan (tmpermohonan_id,tmperusahaan_id) values ('".$this->input->post('id_daftar')."',
                   '".$p_perusahaan2->id."') ";
      
        $query3 = "insert into tmperusahaan_trkelurahan (tmperusahaan_id,trkelurahan_id) values ('".$p_perusahaan2->id."',
                   '".$this->input->post('kelurahan_pemohon')."') ";
      
        $query4 = "insert into tmperusahaan_trkegiatan (tmperusahaan_id,trkegiatan_id) values ('".$p_perusahaan2->id."',
                   '".$this->input->post('jenis_kegiatan')."') ";
      
        $query5 = "insert into tmperusahaan_trinvestasi (tmperusahaan_id,trinvestasi_id) values ('".$p_perusahaan2->id."',
                   '".$this->input->post('jenis_investasi')."') ";
      
        $this->db->query($query);
        $this->db->query($query2);
        $this->db->query($query3);
        $this->db->query($query4);
        $this->db->query($query5);
      }else{
        if($permohonan->tmperusahaan->id) {
          $perusahaan = new tmperusahaan();
          $perusahaan->get_by_id($permohonan->tmperusahaan->id);
          $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
          $perusahaan->npwp = $this->input->post('npwp');
          $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
          $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
          $perusahaan->fax = $this->input->post('fax');
          $perusahaan->email = $this->input->post('email');
          $perusahaan->no_reg_perusahaan = $this->input->post('no_registrasi');
          $perusahaan->trkelurahan->get();
          $perusahaan_lurah = new tmperusahaan_trkelurahan();
          $perusahaan_lurah->where('tmperusahaan_id', $permohonan->tmperusahaan->id)
                           ->update(array('trkelurahan_id' => $this->input->post('kelurahan_usaha')));
          $kegiatan = new trkegiatan();
          $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
          $investasi = new trinvestasi();
          $investasi->get_by_id($this->input->post('jenis_investasi'));
          $perusahaan->save(array($kegiatan, $investasi));
        }else{
          if($this->input->post('nama_perusahaan')) {
            $perusahaan = new tmperusahaan();
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $perusahaan->no_reg_perusahaan = $this->input->post('no_registrasi');
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
            $perusahaan->save(array($permohonan, $kelurahan_u, $kegiatan, $investasi));
          }
        }
      }
  
      /* Input Data Syarat Perizinan */
      $syarat_pendaftaran = new tmpermohonan_trsyarat_perizinan();
      $syarat_pendaftaran->where('tmpermohonan_id', $this->input->post('id_daftar'))->get();
      $syarat_pendaftaran->delete();
      
      $syarat = $this->input->post('pemohon_syarat');
      $syarat_len = count($syarat);
      
      $is_array = NULL;
      for($i = 0; $i < $syarat_len; $i++) {
        if($is_array !== $syarat[$i]) {
          $syarat_daftar = new tmpermohonan_trsyarat_perizinan();
          $syarat_daftar->tmpermohonan_id = $this->input->post('id_daftar');
          $syarat_daftar->trsyarat_perizinan_id = $syarat[$i];
          $syarat_daftar->save();
        }
        $is_array = $syarat[$i];
      }
      
      /* Input Data Tracking Progress */
      $tracking_izin = new tmtrackingperizinan();
      $tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
      $tracking_izin->status = 'Insert';
      $tracking_izin->d_entry_awal = $this->lib_date->get_date_now();
      $tracking_izin->d_entry = $this->lib_date->get_date_now();
      $sts_izin = new trstspermohonan();
      $sts_izin->get_by_id('2');                          //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
      $sts_izin->save($permohonan);
      $tracking_izin->save($sts_izin);
      $tracking_izin->save($permohonan);
      
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      $g = $this->sql($u_ser);
      //$jam = date("H:i:s A");
      //$p = $this->db->query("call log ('Pelayanan','Edit data pelayanan OnLine','" . $tgl . "','" . $g->description . "')");
      
      $update = $permohonan->save();
      if($update) {
        $p_sementara = new tmpemohon_sementara();
        $p_sementara->get_by_id($permohonan->tmpemohon_sementara->id);
        $p_sementara->delete();
        $prs_sementara = new tmperusahaan_sementara();
        $prs_sementara->get_by_id($permohonan->tmperusahaan_sementara->id);
        $prs_sementara->delete();
        //Delete relasinya permohonan sama pemohon_sementara
        $permohonan->delete(array($p_sementara,$prs_sementara));
        redirect('pelayanan/komitmen_oss');
      }
    }
  }
  
  public function delete1($uid = NULL) {
    $permohonan = new tmpermohonan();
    $permohonan->get_by_id($uid);
    $permohonan->tmpemohon_sementara->get();
    $permohonan->tmperusahaan_sementara->get();
    $permohonan->trperizinan->get();
    
    $sqlhapus = @mysql_query("DELETE FROM tmpermohonan_trperizinan WHERE tmpermohonan_id = $uid") or die('Error: ' . mysql_error());
    $sqlhapus = @mysql_query("DELETE FROM tmpermohonan WHERE id = $uid") or die('Error: ' . mysql_error());

    $permohonan->delete();

    redirect('pelayanan/komitmen_oss');
  }
  
  /*
   * Function
  */
  
  function _funcwilayah() {
    $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
    $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
    $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
    $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();
  
    $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
    $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();
  
    return $data;
  }
  
  public function kabupaten_pemohon() {
    $data['kabupaten_id'] = 'kabupaten_pemohon';
    $data['kecamatan_id'] = 'kecamatan_pemohon';
  
    $this->load->vars($data);
    $this->load->view('kabupaten_load', $data);
  }
  
  public function kecamatan_pemohon() {
    $data['kecamatan_id'] = 'kecamatan_pemohon';
    $data['kelurahan_id'] = 'kelurahan_pemohon';
  
    $this->load->vars($data);
    $this->load->view('kecamatan_load', $data);
  }
  
  public function kelurahan_pemohon() {
    $data['kelurahan_id'] = 'kelurahan_pemohon';
  
    $this->load->vars($data);
    $this->load->view('kelurahan_load', $data);
  }
  
  public function kabupaten_usaha() {
    $data['kabupaten_id'] = 'kabupaten_usaha';
    $data['kecamatan_id'] = 'kecamatan_usaha';

    $this->load->vars($data);
    $this->load->view('kabupaten_load', $data);
  }
  
  public function kecamatan_usaha() {
    $data['kecamatan_id'] = 'kecamatan_usaha';
    $data['kelurahan_id'] = 'kelurahan_usaha';
  
    $this->load->vars($data);
    $this->load->view('kecamatan_load', $data);
  }
  
  public function kelurahan_usaha() {
    $data['kelurahan_id'] = 'kelurahan_usaha';
  
    $this->load->vars($data);
    $this->load->view('kelurahan_load', $data);
  }
  
  public function pick_pemohon_list() {
    $data['page_name'] = "Pilih Data Pemohon";
    $data['list'] = $this->pemohon->order_by('id', 'DESC')->get();
  
    $this->load->vars($data);
    $this->load->view('pemohon_load', $data);
  }
  
  public function pick_pemohon_data() {
    $data = $this->_funcwilayah();
  
    $_POST['id_pemohon'] = $this->uri->segment(4);
    $p_pemohon = $this->pemohon->get_by_id($_POST['id_pemohon']);
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
    $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
    $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
  
    $data['id_pemohon'] = $p_pemohon->id;
    $data['no_refer'] = $p_pemohon->no_referensi;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['no_telp'] = $p_pemohon->telp_pemohon;
    $data['propinsi_pemohon'] = $p_propinsi->id;
    $data['kabupaten_pemohon'] = $p_kabupaten->id;
    $data['kecamatan_pemohon'] = $p_kecamatan->id;
    $data['kelurahan_pemohon'] = $p_kelurahan->id;
    $data['tgl_daftar'] = "";
    $data['tgl_survey'] = "";
    $data['lokasi_izin'] = "";
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
    $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
  
    $this->load->vars($data);
    $this->load->view('pemohon_tab', $data);
    echo "<script>$.facebox.close();</script>";
  }
  
  public function pick_perusahaan_list() {
    $data['page_name'] = "Pilih Data Perusahaan";
    $data['list'] = $this->perusahaan->order_by('id', 'DESC')->get();
  
    $this->load->vars($data);
    $this->load->view('perusahaan_load', $data);
  }
  
  public function pick_perusahaan_data() {
    $data = $this->_funcwilayah();
  
    $_POST['id_perusahaan'] = $this->uri->segment(4);
    $u_perusahaan = $this->perusahaan->get_by_id($_POST['id_perusahaan']);
    $u_kelurahan = $u_perusahaan->trkelurahan->get();
    $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
    $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
    $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
    $u_kegiatan = $this->perusahaan->trkegiatan->get();
    $u_investasi = $this->perusahaan->trinvestasi->get();
  
    $data['id_perusahaan'] = $u_perusahaan->id;
    $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
    $data['npwp'] = $u_perusahaan->npwp;
    $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
    $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
    $data['propinsi_usaha'] = $u_propinsi->id;
    $data['kabupaten_usaha'] = $u_kabupaten->id;
    $data['kecamatan_usaha'] = $u_kecamatan->id;
    $data['kelurahan_usaha'] = $u_kelurahan->id;
    $data['jenis_kegiatan'] = $u_kegiatan->id;
    $data['jenis_investasi'] = $u_investasi->id;
  
    $this->load->vars($data);
    $this->load->view('perusahaan_tab', $data);
    echo "<script>$.facebox.close();</script>";
  }
  
  public function download($id) {
    $this->load->helper('download');
    $data = file_get_contents(base_url() . "assets/upload/api.pdf"); // Read the file's contents
    $name = $id . '.pdf';
    force_download($name, $data);
  }
  
  public function fpdf() {
  
    //$this->load->library('fpdf');
    //$this->load->helper('download');
    //
    //$pdf=new FPDF('L','mm', array(216, 330));
    //$pdf->setTopMargin(15);
    //$pdf->setLeftMargin(12);
    //$pdf->SetFont('helvetica','B', 11);
    //
    //$pdf->AddPage();
    //$pdf->Cell(6);
    //$pdf->Cell(100, 12,'Hallo Pengguna CIsdfsdf',10,1,'L');
    //
    //$data = file_get_contents(base_url()."assets\upload".$pdf->Output()); // Read the file's contents
    //$name = $id.'.pdf';
    //force_download($name, $data);
    $this->load->view('pdf');
  }
  
  public function sql($u_ser) {
    $query = "select a.description
           from user_auth as a
             inner join user_user_auth as  x on a.id = x.user_auth_id
             inner join user as b on b.id = x.user_id
             where b.id = (select id from user where username='" . $u_ser . "')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }
  
  public function pick_penduduk_data() {
    $data = $this->_funcwilayah();
  
    $data['propinsi_pemohon'] = NULL;
    $data['check_ctr'] = 0;
    $data['kabupaten_pemohon'] = NULL;
    $data['kecamatan_pemohon'] = NULL;
    $data['kelurahan_pemohon'] = NULL;
    //cek Online penduduk
    $this->settings->where('name', 'web_service_penduduk')->get();
    $statusOnline2 = $this->settings->status;
    $data['statusOnline2'] = $statusOnline2;
  
    $_POST['id_perusahaan'] = $this->uri->segment(4);
    $u_perusahaan = $this->perusahaan->get_by_id($_POST['id_perusahaan']);
    $data['data_npwp_id'] = " ";
    $data['cmbsource'] = "KTP";
    $data['id_perusahaan'] = $u_perusahaan->id;
    $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
    $data['npwp'] = $u_perusahaan->npwp;
    $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
    $perusahaan->rt = $this->input->post('rt');
    $perusahaan->rw = $this->input->post('rw');
    $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
    $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
    $data['nodaftar'] = $u_perusahaan->no_daftar;
    $data['fax'] = $u_perusahaan->i_fax;
    $data['email'] = $u_perusahaan->email;
    $data['rt'] = $u_perusahaan->rt;
    $data['rw'] = $u_perusahaan->rw;
    $data['mantra'] = $this->mantraSakti('NIK='.$_REQUEST['data_no_refer'],'web_service_penduduk');
  
    //cek Online
    $this->settings->where('name', 'web_service_penduduk')->get();
    $statusOnline = $this->settings->status;
    $data['statusOnline'] = $statusOnline;
  
    $this->load->vars($data);
    $this->load->view('penduduk_tab_sem', $data);
    echo "<script>$.facebox.close();</script>";
  }
  
  //----------------------- SCRIPT MANTRA -----------------------//
  
  public function mantraSakti($id,$wsname='web_service_penduduk'){
    $settings = new settings();
    $app_web_service = $settings->where('name', $wsname)->get();
    $url = $app_web_service->value . $id;
    $ch = curl_init();                              // PHP_CURL in php.ini must be enabled 
    curl_setopt($ch, CURLOPT_URL, $url);            // Set URL 
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  // Return result
    curl_setopt($ch, CURLOPT_USERAGENT, "MANTRA");
  
    $result = curl_exec($ch);                         // Connect to URL and get result
  
    if($result):
      if(substr($result, 0, 5) == "REST:"):                  //Replace REST:
        $result = substr_replace($result, "", 0, 5);
      endif;
      if($result):
        if(strtolower(substr($result, 0, 5)) == "<?xml"): //Detect XML format
          $xmle = new SimpleXMLElement($result);     //Parsing XML into Array
          $rootName = strtolower($xmle->getName());
          if($rootName == "invalid_response"):
            $result = (string) $xmle;
          elseif ($rootName == "valid_response"):
            $xmli = new SimpleXMLIterator($result);
            $result = $this->parseIterator($xmli);
          else:
            $result = false;
            $messageAPI = "No result from API Webservice";
          endif;
        endif;
      endif;
    endif;
    return $result;
  }
  
  public function parseIterator($xmli) {
    foreach($xmli as $key => $val):
      $child[$key] = $xmli->hasChildren() ? $this->parseIterator($val) : strval($val);
    endforeach;
    return $child;
  }
  
  //------------------------------SCRIPT MANTRA------------------------------//
  public function pick_list($id_jenis) {
    $data['page_name'] = "Pilih";
    $data['id_jenis'] = $id_jenis;
    $this->load->vars($data);
    $this->load->view('pick_list', $data);
  }
  
  public function pick_list_other($id_jenis) {
    $data['page_name'] = "Pilih";
    $data['id_jenis'] = $id_jenis;
    $this->load->vars($data);
    $this->load->view('pick_list_other', $data);
  }
  
  public function get_data_perusahaan() {
    $obj = new tmperusahaan();
  
    $columns = array('n_perusahaan',
                     'a_perusahaan',
                     'npwp'
                    );
    $obj->start_cache();
    $this->iTotalRecords = $obj->count();
    $this->sEcho = $this->input->post('sEcho');
    for($i = 0; $i < 2; $i++) {
      /**
       * Filtering
      */
      if($this->input->post('sSearch')) {
        foreach ($columns as $position => $column) {
          if($position == 0 && $position == 2) {
            $obj->like($column, $this->input->post('sSearch'));
          }else {
            $obj->or_like($column, $this->input->post('sSearch'));
          }
        }
      }
  
      /**
       * Ordering
      */
      //if ($this->input->post("iSortCol_0") != null && $this->input->post("iSortCol_0") != "") {
      //    for ($i = 0; $i < intval($this->input->post("iSortingCols")); $i++) {
      //        $obj->order_by($columns[intval($this->input->post("iSortCol_" . $i))], $this->input->post("sSortDir_" . $i));
      //    }
      //}
      
      if($i === 0) {
        $this->iTotalDisplayRecords = $obj->count();
      }else if ($i === 1) {
        if($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
          $this->iDisplayStart = $this->input->post("iDisplayStart");
          $this->iDisplayLength = $this->input->post("iDisplayLength");
      
          $obj->limit($this->iDisplayLength, $this->iDisplayStart);
        }else{
          $this->iDisplayLength = $this->input->post("iDisplayLength");
      
          if(empty($this->iDisplayLength)) {
            $this->iDisplayLength = 10;
            $obj->limit($this->iDisplayLength);
          }else
            $obj->limit($this->iDisplayLength);
        }
      }
    }

    $peru = new tmperusahaan;
    //$a = $peru->group_by('npwp')->get();

    $a = $obj->get();
    $obj->stop_cache();
    echo $this->get_data_perusahaan_output($a);
  }
  
  private function get_data_perusahaan_output($obj) {
    $aaData = array();
  
    $i = $this->iDisplayStart;
  
    foreach ($obj as $list) {
      $i++;
      //echo "<script> function conf() { alert('ok'); return false; } </script>";
      $action = NULL;
      $action = NULL;
      $action .= '<a href="javascript:popup_link(\'' . base_url() . 'pelayanan/pendaftaran/pick_perusahaan_data/' . $list->id . '\',\'#tabs-2\')">';
      $action .= '<img src="' . base_url() . 'assets/images/icon/navigation-down.png" border="0" alt="Pilih Pemohon"/>';
      $action .= '</a>';
  
      $aaData[] = array($i,
                        $list->n_perusahaan,
                        $list->npwp,
                        $list->a_perusahaan,
                        $action
                       );
    }
    $sOutput = array("sEcho" => intval($this->sEcho),
                     "iTotalRecords" => $this->iTotalRecords,
                     "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                     "aaData" => $aaData
                    );
    return json_encode($sOutput);
  }
  
  // edited by dhika
  
  public function apiCon(){
    /*
    Konektor API/Webservices MANTRA
    */
  		
    $messageAPI="";
  		
    //--------------------- Konektor CURL menggunakan metode HTTP GET -----------------------------\\
    function queryAPI($url) {
    	global $messageAPI;
    	$ch = curl_init();                              // Modul Extension PHP_CURL dalam php.ini harus dimuat/enabled 
    	                                                // extension=php_curl.dll atau extension=php_curl.so
    															
    	curl_setopt($ch, CURLOPT_URL, $url);            // URL target koneksi
    	curl_setopt($ch, CURLOPT_HEADER, FALSE);        // Tanpa header 
    	curl_setopt($ch, CURLOPT_USERAGENT, "MANTRA");
    	curl_setopt($ch, CURLOPT_HTTPGET, TRUE);        // Menggunakan metode HTTP GET 
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);  // Mendapatkan tanggapan
    	$result=curl_exec($ch);                         // Buka koneksi dan dapatkan tanggapan
    	$error=curl_error($ch);
    	if (!empty($error)):                            // Periksa kesalahan
    		$result = '';
    		$messageAPI=$error;
    	endif;
    		
    	curl_close($ch);
    	return $result;
    }
  		
    //------------------ Konektor CURL menggunakan metode HTTP POST ---------------------\\
    function postAPI($url,$param="") {
  	  global $messageAPI;	
  	  $ch = curl_init();                              // Modul Extension PHP_CURL dalam php.ini harus dimuat/enabled 
  	                                                  // extension=php_curl.dll atau extension=php_curl.so
  	  
  	  curl_setopt($ch, CURLOPT_URL, $url);            // URL target koneksi
  	  curl_setopt($ch, CURLOPT_HEADER, FALSE);        // Tanpa header 
  	  curl_setopt($ch, CURLOPT_USERAGENT, "MANTRA");
  	  curl_setopt($ch, CURLOPT_POST, TRUE);           // Menggunakan metode HTTP POST 
  	  curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);  // Mendapatkan tanggapan
  	  curl_setopt($ch, CURLOPT_POSTFIELDS,$param);    // Sisipkan parameter
  	  $result=curl_exec($ch);                         // Buka koneksi dan dapatkan tanggapan
  	  $error=curl_error($ch);
  	  if (!empty($error)):                            // Periksa kesalahan
  	  	$result = '';
  	  	$messageAPI=$error;
  	  endif;
  	  
  	  curl_close($ch);
  	  return $result;
    }
  		
    //---------------- Konversi XML ke Array ---------------------\\
    function setXML2Arr($xml="",$blockname="valid_response") {
    	$result=array();
    	if($xml=="") return $result;
    	if($blockname=="") return $result;
    	$xmle = new SimpleXMLElement($xml);
    	$xmle = getXMLelement($xmle,$blockname);        // Cari nama blok
    	if(is_object($xmle)):                           // Parsing elemen XML jika nama blok ditemukan
    		$result=parseXML2Arr($xmle);
    	endif;
    	return $result;
    }
  		
    function getXMLelement($xmle,$blockname) {
    	$result=null;
    	$tagName=$xmle->getName();
    	if($tagName==$blockname):                       // Nama tag sama dengan Nama blok yang dicari?
    		$result=$xmle;
    	else:
    		foreach($xmle->children() as $key=>$child): // Cari nama tag sampai dapat
    			$result=getXMLelement($child,$blockname);
    		endforeach;
    	endif;
    	return $result;
    }
    		
    function parseXML2Arr($xmle) {
    	$arr=array();$keys=array();
    	foreach($xmle->children() as $key=>$child) $keys[]=$key;
    	$numkeys=array_count_values($keys);$i=0;
    	foreach($xmle->children() as $key=>$child):    // Dapatkan nilai elemen XML ke dalam array
    		if($numkeys[$key]>1):
    			$key.=$i;$i++;
    		endif;
    		if($child->children()):
    			$data=parseXML2Arr($child);
    		else:
    			$data=(string) $child; 
    		endif;
    		$arr[$key]=$data;
    	endforeach;
    	return $arr;
    }	
  	 	
    function gw($nik){
      $settings = new settings();
      $app_web_service = $settings->where('name', 'web_service_penduduk')->get();
  	  $url = $app_web_service->value."NIK=".$nik;	  
      return $url;  	    
    }    			
  }
     
  public function getCitizen($nik){	 
    $callback = $_REQUEST['callback'];
    $this->apiCon();
    	    
    function get_data_wni($nik){
      global $messageAPI;
  	  $result=false;              
      $uri = gw($nik);
      $result=queryAPI($uri);
  	  return $result;
    }
    $xml=get_data_wni($nik);
    $data=setXML2Arr($xml);
    header('Content-Type: text/javascript; charset=UTF-8');
    	
    echo $callback . '(' . json_encode($data) . ');';     
  }
  
  //edited dhikaA
  
  public function cetakPermohonan($nama,$alamat,$kel,$kec,$kota,$propinsi){
    $this->load->helper('date');
    $this->load->helper('download');
    $datestring = "%d-%m-%Y";
    $tgl = mdate($datestring);    	    
    
    $this->load->plugin('odf');
    $odf = new odf('assets/odt/cetak_pernyataan.odt');
    $this->tr_instansi = new Tr_instansi();
    $logo = $this->tr_instansi->get_by_id(14);
  
    $odf->setVars('n_pemohon', strtoupper($nama));
    $odf->setVars('almt_pemohon', strtolower($alamat));
    $odf->setVars('kelurahan', strtolower($kel));
    $odf->setVars('kecamatan', strtolower($kec));
    $odf->setVars('kota', strtolower($kota));
    $odf->setVars('propinsi', strtolower($propinsi));
    $odf->setVars('tanggal', $tgl);
    $name = $odf->exportAsAttachedFile('surat_permohonan_'.$tgl.'.odt');
    force_download($name);
  }
  
  public function asistensi(){
    $pesan = htmlspecialchars($_POST['pesan'],ENT_QUOTES);
  	$oleh = '*'.htmlspecialchars($_POST['oleh'],ENT_QUOTES);
  	$id_kembali = htmlspecialchars($_POST['id_kembali'],ENT_QUOTES);
  	$id_portal = htmlspecialchars($_POST['id_permohonan_portal'],ENT_QUOTES);
  	
  	$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
  	
  	$data = array('id_permohonan' 	=> $id_portal,
                  'pesan' 	=> $pesan,
                  'oleh' 	=> $oleh
                	);
  	$otherdb->insert('asistensi', $data);
  	redirect('/pelayanan/komitmen_oss/edit/'.$id_kembali);
  }
  
  public function revisi($id_permohonan,$id_kembali){
  	$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
  	$permohonan_portal = $otherdb->get_where("tmpermohonan_portal",array("id"=>$id_permohonan))->first_row();
  
  	$user = $otherdb->get_where("tm_pemohon",array("id"=>$permohonan_portal->id_pemohon))->first_row();
  	
  	$perizinan = $this->db->get_where("trperizinan",array("id"=>$permohonan_portal->id_perizinan))->first_row();
  
  	$this->settings->where('name', 'smsGateway')->get();
    if($this->settings->status == 1){
      $gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
      $data = array('DestinationNumber' => $user->telpPemohon,
                    'TextDecoded'	=> "Pengajuan ".$perizinan->n_perizinan." atas nama ".$user->namaPerusahaan." membutuhkan revisi persyaratan, silahkan buka akun anda"
  	               );
      $gammu->insert('outbox',$data);
    }		
  	
  	$data	= array("editable" => "1");
  	$otherdb->where('id', $id_permohonan);
  	$otherdb->update('tmpermohonan_portal', $data);
  
  	redirect('/pelayanan/komitmen_oss/edit/'.$id_kembali);
  }
}