<?php
/** Description of monitoring class
  * @author PBS 18-08-2015
*/
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Pemohon_Online extends WRC_AdminCont {
  
  public function __construct() {
    parent::__construct();
    $this->load->model('dbmodel_portal');
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '4' || $list_auth->id_role === '18') {
        $enabled = TRUE;
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index() { 
    $hak = '-';
    $list_auths = $this->session_info['app_list_auth'];
      
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '18') {
        $hak = "administrator"; 
      }
    }
    $data['hak'] = $hak;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -10) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $list_state = $this->input->post('list_state');
    $mark = $this->input->post('mark');
    $stspermohonan = new trstspermohonan();
    $data['list_state'] = $list_state;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    //$data['sekarang'] = $today;
    
    $list_state = $this->input->post('list_state');
    $kt_cari = $this->input->post('kt_cari');
    $data['kt_cari'] = $kt_cari;
    $data['list_state'] = $list_state;
		
		switch($list_state) {
      case '':    // per tgl permohonan
        $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where tgl_daftar >= '".$first_date."' AND tgl_daftar <= '".$second_date."'"."ORDER BY `tgl_daftar` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where tgl_daftar >= '".$first_date."' AND tgl_daftar <= '".$second_date."'"."ORDER BY `tgl_daftar` DESC");
        break;
		  case '1':    // per nama pemohon
  	    $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where namaPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `namaPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where namaPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `namaPerusahaan` DESC");
        break;
      case '2':    // per no hp pemohon
  	    $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where telpPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `telpPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where telpPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `telpPerusahaan` DESC");
        break;
      case '3':    // per email pemohon
  	    $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where emailPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `emailPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where emailPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `emailPerusahaan` DESC");
        break;
      case '4':    // per user pemohon
        if($kt_cari == ''){
  	      $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where username = '' OR username IS NULL");
          $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where username = '' OR username IS NULL");
        }else{
        	$data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where username LIKE '%".$kt_cari."%'"."ORDER BY `username` DESC");
          $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where username LIKE '%".$kt_cari."%'"."ORDER BY `username` DESC");
        }
        break;
    }
    $this->load->vars($data);
    
    $js = "
           function confirm_link(text){
             if(confirm(text)){ 
               return true;
             }else{ 
               return false; 
             }
           }
           
           $(document).ready(function() {
             oTable = $('#monitoring').dataTable({
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
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Pemohon Online ";
    $this->template->build('list_pemohon_ol', $this->session_info);
  }

  public function listpemohon() { 
    $hak = '-';
    $list_auths = $this->session_info['app_list_auth'];
      
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '18') {
        $hak = "administrator"; 
      }
    }
    $data['hak'] = $hak;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -10) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $list_state = $this->input->post('list_state');
    $mark = $this->input->post('mark');
    $stspermohonan = new trstspermohonan();
    $data['list_state'] = $list_state;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    //$data['sekarang'] = $today;
    
    $list_state = $this->input->post('list_state');
    $kt_cari = $this->input->post('kt_cari');
    $data['kt_cari'] = $kt_cari;
    $data['list_state'] = $list_state;
    
    switch($list_state) {
      case '':    // per tgl permohonan
        $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where tgl_daftar >= '".$first_date."' AND tgl_daftar <= '".$second_date."'"."ORDER BY `tgl_daftar` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where tgl_daftar >= '".$first_date."' AND tgl_daftar <= '".$second_date."'"."ORDER BY `tgl_daftar` DESC");
        break;
      case '1':    // per nama pemohon
        $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where namaPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `namaPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where namaPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `namaPerusahaan` DESC");
        break;
      case '2':    // per no hp pemohon
        $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where telpPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `telpPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where telpPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `telpPerusahaan` DESC");
        break;
      case '3':    // per email pemohon
        $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where emailPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `emailPerusahaan` DESC");
        $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where emailPerusahaan LIKE '%".$kt_cari."%'"."ORDER BY `emailPerusahaan` DESC");
        break;
      case '4':    // per user pemohon
        if($kt_cari == ''){
          $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where username = '' OR username IS NULL");
          $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where username = '' OR username IS NULL");
        }else{
          $data['list_data'] = $this->dbmodel_portal->dbportal_sql("select * from tm_pemohon where username LIKE '%".$kt_cari."%'"."ORDER BY `username` DESC");
          $data['jumlah'] = $this->dbmodel_portal->dbportal_sql_hit("select * from tm_pemohon where username LIKE '%".$kt_cari."%'"."ORDER BY `username` DESC");
        }
        break;
    }
    $this->load->vars($data);
    
    $js = "
           function confirm_link(text){
             if(confirm(text)){ 
               return true;
             }else{ 
               return false; 
             }
           }
           
           $(document).ready(function() {
             oTable = $('#monitoring').dataTable({
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
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Pemohon Online ";
    $this->template->build('list_pemohon_ol_new', $this->session_info);
  }

  public function detail($id = NULL) {
    //echo 'BELUM DIBUAT, NANTI SAJA OK !! ...pbs...';
    $otherdb = $this->load->database('otherdb', TRUE);

    $user = $otherdb->get_where("tm_pemohon",array("id"=>$id))->first_row();

    $provinsi	= $this->db->query('select * from trpropinsi order by n_propinsi')->result();
    $kabupaten	= $this->db->query("select * from trkabupaten where kd_prov='12' order by n_kabupaten")->result();
    $propinsi1	=	0;
    $kabupaten1	=	0;
    $kecamatan1	=	0;
    $kelurahan1	=	0;
    
    if(!empty($query->kelurahan1)){
      $propinsi1	=	$this->db->query("select * from trpropinsi order by n_propinsi asc")->result();
      $kabupaten1	=	$this->db->query("select * from trkabupaten where kd_prov=".$user->propinsi1."")->result();
      $kecamatan1	=	$this->db->query("select * from trkecamatan where kd_kab=".$user->kabupaten1."")->result();
      //$kelurahan1	=	$otherdb->query("select * from trkelurahan where kd_kec=".$query->kecamatan1."")->result();
      $kelurahan1	=	$this->db->query("select * from trkelurahan where kd_kel  IN (SELECT trkelurahan_id FROM trkecamatan_trkelurahan WHERE trkecamatan_id ='".$user->kecamatan1."') order by n_kelurahan")->result();
    }
    
    $kabupaten2	=	$this->db->query("select * from trkabupaten where kd_prov=".$user->propinsi2."")->result();
    $kecamatan2	=	$this->db->query("select * from trkecamatan where kd_kab=".$user->kabupaten2."")->result();
    //$kelurahan2	=	$otherdb->query("select * from trkelurahan where kd_kec=".$query->kecamatan2."")->result();
    $kelurahan2	=	$this->db->query("select * from trkelurahan where kd_kel  IN (SELECT trkelurahan_id FROM trkecamatan_trkelurahan WHERE trkecamatan_id ='".$user->kecamatan2."') order by n_kelurahan")->result();

    $data['user'] = $user;
    $data['provinsi']	= $provinsi;
    $data['kabupaten']	= $kabupaten;
    $data['propinsi1']	= $propinsi1;
    $data['kabupaten1']	= $kabupaten1;
    $data['kecamatan1']	= $kecamatan1;
    $data['kelurahan1']	= $kelurahan1;
    $data['propinsi2']	= $provinsi;
    $data['kabupaten2']	= $kabupaten2;
    $data['kecamatan2']	= $kecamatan2;
    $data['kelurahan2']	= $kelurahan2;
    $data['jenis']		= ucfirst($user->jenis);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Pemohon Online ";
    $this->template->build('edit_pemohon_new', $this->session_info);
  }

  public function simpanedit() {
  	//By Nirwan
  	$otherdb = $this->load->database('otherdb',TRUE);
  	$jenis = $this->input->post('jenis');
  	$id = $this->input->post('id');
    $datalama = $otherdb->get_where('tm_pemohon', array('id' => $id,'status'=>'1'))->first_row();
    $usernamelama = $datalama->username;
    $usernamebaru = strtolower($this->input->post('username'));

  	if ($jenis == 'Pemohon') {
  		if (!empty($this->input->post('password'))) {
  			$data = array("username"		     => $usernamebaru,
  						        "password"		     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
  						        "namaPerusahaan" 	 => $this->input->post('nama_pemohon'),
		                  "namaPemohon" 	   => $this->input->post('nama_pemegang_kuasa'),
		                  "npwpPerusahaan" 	 => $this->input->post('no_npwp_pemohon'),
		                  "ktpPerusahaan" 	 => $this->input->post('no_ktp_pemohon'),
		                  "emailPerusahaan"  => $this->input->post('email_pemohon'),
		                  "telpPerusahaan" 	 => $this->input->post('hp_pemohon'),
		                  "telpPemohon" 	   => $this->input->post('hp_pemegang_kuasa'),
		                  "data"			       => "1"
		                 );
  		} else {
  			$data = array("username"		     => $usernamebaru,
  						        "namaPerusahaan" 	 => $this->input->post('nama_pemohon'),
		                  "namaPemohon" 	   => $this->input->post('nama_pemegang_kuasa'),
		                  "npwpPerusahaan" 	 => $this->input->post('no_npwp_pemohon'),
		                  "ktpPerusahaan" 	 => $this->input->post('no_ktp_pemohon'),
		                  "emailPerusahaan"  => $this->input->post('email_pemohon'),
		                  "telpPerusahaan" 	 => $this->input->post('hp_pemohon'),
		                  "telpPemohon" 	   => $this->input->post('hp_pemegang_kuasa'),
		                  "data"			       => "1"
		                 );
  		}

  	} else {
  		if (!empty($this->input->post('password'))) {
  			$data = array("username"			        => $usernamebaru,
	  					        "password"			        => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
	  					        "namaPerusahaan"        => $this->input->post('nama_perusahaan'),
		                  "namaPemohon"           => $this->input->post('nama_pemegang_kuasa'),
		                  "nama_penanggung_jawab" => $this->input->post('nama_direktur'),
		                  "ktpPemohon"            => $this->input->post('no_ktp_direktur'),
		                  "npwpPerusahaan"        => $this->input->post('no_npwp_perusahaan'),
		                  "aktaPerusahaan"        => $this->input->post('no_akta_perusahaan'),
		                  "emailPerusahaan"       => $this->input->post('email_perusahaan'),
		                  "emailPemohon"          => $this->input->post('email_direktur'),
		                  "telpPerusahaan"        => $this->input->post('telp_perusahaan'),
		                  "telp_penanggung_jawab" => $this->input->post('hp_pemegang_kuasa'),
		                  "telpPemohon"           => $this->input->post('hp_direktur'),
		                  "faxPerusahaan"         => $this->input->post('fax_perusahaan'),
		                  "data"                  => "1"
		                 );
  		} else {
  			$data = array("username"			        => $usernamebaru,
	  					        "namaPerusahaan"        => $this->input->post('nama_perusahaan'),
		                  "namaPemohon"           => $this->input->post('nama_pemegang_kuasa'),
		                  "nama_penanggung_jawab" => $this->input->post('nama_direktur'),
		                  "ktpPemohon"            => $this->input->post('no_ktp_direktur'),
		                  "npwpPerusahaan"        => $this->input->post('no_npwp_perusahaan'),
		                  "aktaPerusahaan"        => $this->input->post('no_akta_perusahaan'),
		                  "emailPerusahaan"       => $this->input->post('email_perusahaan'),
		                  "emailPemohon"          => $this->input->post('email_direktur'),
		                  "telpPerusahaan"        => $this->input->post('telp_perusahaan'),
		                  "telp_penanggung_jawab" => $this->input->post('hp_pemegang_kuasa'),
		                  "telpPemohon"           => $this->input->post('hp_direktur'),
		                  "faxPerusahaan"         => $this->input->post('fax_perusahaan'),
		                  "data"                  => "1"
		                 );
  		}
  	}
    $otherdb->where('id', $id);
    //$otherdb->where('status', '1');
    if($otherdb->update('tm_pemohon', $data)){
      //var_dump($usernamelama."<br>".$usernamebaru);die;
      if ($usernamebaru != $usernamelama) {
          ///// RENAME DIREKTORI
          $path = "../assets/userassets/pemohon/".$usernamelama."";
          
          if(is_dir($path)){
            rename($path, "../assets/userassets/pemohon/".$usernamebaru."");
          } else {
            $path = "../assets/userassets/pemohon/".$usernamebaru."";
            $dokumen = "../assets/userassets/pemohon/".$usernamebaru."/dokumen";
            $dokumen_pengajuan = "../assets/userassets/pemohon/".$usernamebaru."/dokumen_pengajuan";
            $pengajuan = "../assets/userassets/pemohon/".$usernamebaru."/pengajuan";

            if(!is_dir($path)){
              mkdir($path,0755,TRUE);
              mkdir($dokumen,0755,TRUE);
              mkdir($dokumen_pengajuan,0755,TRUE);
              mkdir($pengajuan,0755,TRUE);
            } 
          }
        }

      $this->session->set_flashdata('sukses', "Data Berhasil Diubah");
      redirect('pemohon/pemohon_online');
    }else{
      echo "Data Gagal Diubah";die;
    }
  }

  public function getkabupaten(){
    $data = $_POST['data'];
    $str = '|------------------------ Pilih Kabupaten ------------------------,';
    $rowsData = $this->db->query("select * from trkabupaten where kd_prov='".$data."' order by n_kabupaten")->result();
    foreach($rowsData as $row) {
      $kab = $row->n_kabupaten;
      $str = $str . "$row->kd_kab|$kab".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }

  public function getkecamatan(){
    $data = $_POST['data'];
    $str = '';
    $rowsData = $this->db->query("select * from trkecamatan where kd_kab='".$data."' order by n_kecamatan")->result();
    $str = '|------------------------ Pilih Kecamatan ------------------------,';
    foreach($rowsData as $row) {
      $kab = $row->n_kecamatan;
      $str = $str . "$row->kd_kec|$kab".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }

  public function token($token = NULL, $email= NULL) {
    ///// KIRIM E-MAIL
    $emailasli = str_replace("_", ".", $email);
    $sendE = FALSE;
    $base_url         = '../assets/pendaftaran/';
    $host             = "smtp.gmail.com"; //"mail.tasikmalayakab.go.id";
    $emailpengirim    = "pendaftaran.dpmptsptasikmalaya@gmail.com"; //sebelumnya dpmptsptasikmalaya@gmail.com
    $namapengirim     = "DPMPTSP tasikmalaya";
    $password         = "D!p0A&min21";
    // $host             = "mail.tasikmalayakab.go.id";
    // $emailpengirim    = "dpmptsp-online@tasikmalayakab.go.id"; //sebelumnya pendaftaran.dpmptsptasikmalaya@gmail.com
    // $namapengirim     = "DPMPTSP tasikmalaya";
    // $password         = "~tasikmalayajuara2019";
    $targetpengiriman = $emailasli;
    require("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
    require("".$base_url."back/plugins/phpmailer/class.smtp.php");
    $mailer = new PHPMailer();
    $mailer->CharSet = "UTF-8";
    $mailer->IsSMTP();
    $mailer->SMTPDebug  = 2;
    $mailer->SMTPSecure = 'tls';
    $mailer->Host =$host;
    $mailer->Port =587;
    $mailer->SMTPAuth = true;
    $mailer->Username = $emailpengirim;
    $mailer->Password = $password;
    $mailer->FromName = $namapengirim;
    $mailer->From = $emailpengirim;
    $mailer->AddAddress($targetpengiriman,$targetpengiriman);
    $mailer->Subject = 'Token Pendaftaran Akun DPMPTSP Tasikmalaya';
          $isi  = "<img src = 'https://spekta.tasikmalayakab.go.id/spekta/assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
          $isi .= "<h2>Token Pendaftaran Akun DPMPTSP Tasikmalaya</h2><hr>";
          $isi .= "<p>Terimakasih atas pendaftaran anda, berikut ini adalah nomor token anda : </p>";
          $isi .= "<p>".$token."</p>";
          $isi .= "<p>Silahkan masukkan nomor token anda pada halaman berikut : <a href='https://spekta.tasikmalayakab.go.id/spekta/main/pendaftaranbaru/konfirm'>Verifikasi Permohonan Proposal</a></p>";
          $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk menuju halaman aktifasi akun anda : https://spekta.tasikmalayakab.go.id/spekta/main/pendaftaranbaru/konfirm</p>";
          $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP TASIKMALAYA</p>";
          $isi .= "<br><hr>";
          $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya - 2019<br>Jalan Windu Nomor 26<br>Tasikmalaya, Tasikmalaya, Indonesia. 40263.</small></p>";
          $isi .= "<hr>";
          $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
    $mailer->Body = $isi;
    $mailer->AltBody = $isi;
    if($mailer->Send()) $sendE = TRUE;

    if ($sendE == TRUE) {
      $this->session->set_flashdata('sukses', "Berhasil mengirim E-mail Token");
      redirect('pemohon/pemohon_online');
    } else {
      echo "Gagal Kirim E-mail<br>".$mailer->ErrorInfo;die;
    }
    ///// EOF() KIRIM E-MAIL
  }

  public function hapus($id = NULL) {
    $dbmysql = $this->load->database('otherdb',TRUE);
    $dbmysql->query("DELETE FROM tm_pemohon WHERE id = ".$id);
    redirect('pemohon/pemohon_online');
  }

  public function perhubungan_all_old() {
    $sql = $this->sql_info_viewdata();
    //$data = $this->db->query($sql)->result();
    $data = $this->dbmodel_akdp->dbakdp_sql($sql);
    $data['list_data'] = $data;
    
    $this->load->vars($data);
    $js = "$(document).ready(function() {
             oTable = $('#listdataakdp').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Perizinan Bidang Perhubungan";
    $this->template->build('list_perhubungan_all', $this->session_info);
  }

  public function perhubungan_all() {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $kt_cari = $this->input->post('kt_cari');
    $data['kt_cari'] = $kt_cari;
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $list_state = $this->input->post('list_state');
    $mark = $this->input->post('mark');
    $stspermohonan = new trstspermohonan();
    $data['list_state'] = $list_state;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    $data['sekarang'] = $today;
    $obj = $this->permohonan;
    
    if($kt_cari != ''){
      switch ($list_state) {
        case 0:    // untuk nomor kendaraan
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kend LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend LIKE '%".$kt_cari."%'");
          break;
        case 1:    // untuk nomor uji
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_uji LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_uji LIKE '%".$kt_cari."%'");
          break;
        case 2:    // untuk nomor SK
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_sk LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_sk LIKE '%".$kt_cari."%'");
          break;
        case 3:    // untuk nomor KP
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kp LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kp LIKE '%".$kt_cari."%'");
          break;
        case 4:    // untuk nama pemilik
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where nama_pemilik LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where nama_pemilik LIKE '%".$kt_cari."%'");
          break;
        case 5:    // untuk nama perusahaan
          $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where nama_perusahaan LIKE '%".$kt_cari."%'");
          $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where nama_perusahaan LIKE '%".$kt_cari."%'");
          break; 
      }
    }else{
      $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kend = '".$kt_cari."'");
      $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend = '".$kt_cari."'");
    }
        
    $this->load->vars($data);
    
    $js = "$(document).ready(function() {
             oTable = $('#monitoring').dataTable({
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
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Perhubungan per Kategori ";
    $this->template->build('list_perhubungan_cari', $this->session_info);
  }

  public function perhubungan_kdtrayek() {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $list_state = $this->input->post('list_state');
    $mark = $this->input->post('mark');
    $stspermohonan = new trstspermohonan();
    $data['list_state'] = $list_state;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    $data['sekarang'] = $today;
    $obj = $this->permohonan;
    if($list_state == '0') {
      $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
      $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
    }else{
      $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
      $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
    }
        
    $this->load->vars($data);
    
    $js = "$(document).ready(function() {
               oTable = $('#monitoring').dataTable({
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
    
           function finishAjax(id, response){
               $('#'+id).html(unescape(response));
               $('#'+id).fadeIn();
           }
    
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Perhubungan per Trayek";
    $this->template->build('list_perhubungan_kdtrayek', $this->session_info);
  }

  function datatables_viewdata(){
    $iDisplayStart=$this->input->post('iDisplayStart');
    $obj=$this->get_list_viewdata();
    $total=$this->get_total_viewdata();
    if($obj){
      $i=$iDisplayStart;
      foreach ($obj as $list) {
        //$action = anchor(site_url('info/infotracking/detail') .'/'. $list->id, img($img_info));
        $logo = 'assets/images/icon/information.png';
        $title = 'Lihat Detail';
        if($list->masa_berlaku < $this->lib_date->get_date_now()){
          $logo = 'assets/images/icon/r_information.png';
          $title = 'Masa Berlaku SK Telah Habis, Lihat Detail?';
        }
        if($list->tgl_kp_akhir < $this->lib_date->get_date_now()){
          $logo = 'assets/images/icon/r_information.png';
          $title = 'Masa Berlaku KP Telah Habis, Lihat Detail?';
        }
        if($list->tgl_kp_akhir < $this->lib_date->get_date_now() && $list->masa_berlaku < $this->lib_date->get_date_now()){
          $logo = 'assets/images/icon/r_information.png';
          $title = 'Masa Berlaku SK dan KP Telah Habis, Lihat Detail?';
        }
        $img_info = array('src' => base_url().$logo,
                          'alt' => $title,//'Lihat Detail',
                          'title' => $title,
                          'border' => '0',
                         );
        $action = '';//anchor(site_url('arsip/edit') .'/L/'. $list->id.'/3', img($img_info))."&nbsp;";
        $i++;
        $aaData[] = array($i,
                          $list->no_kend .'<br>'. $list->no_uji,
                          $list->no_sk,
                          $this->lib_date->mysql_to_human($list->tgl_sk) .'<br>'.  $this->lib_date->mysql_to_human($list->masa_berlaku),
                          $list->no_kp,
                          $this->lib_date->mysql_to_human($list->tgl_kp_awal) .'<br>'. $this->lib_date->mysql_to_human($list->tgl_kp_akhir),
                          $list->nama_pemilik,
                          $action
                         );
      }
    }else{
      $aaData=array();
    }
    $sOutput = array ("sEcho" => $this->input->post('sEcho'),
                      "iTotalRecords" => $total,
                      "iTotalDisplayRecords" => $total,
                      "aaData" => $aaData
                     );
    echo json_encode($sOutput);
  }

  function get_list_viewdata(){
  	//$db_akdp = $this->load->database('dbakdp',true);        // untuk membuka tabel pada database lain
    $sSearch = $this->input->post('sSearch');
    $iDisplayLength = $this->input->post('iDisplayLength');
    $iDisplayStart = $this->input->post('iDisplayStart');
    $sql = $this->sql_info_viewdata();
  	// Untuk di filter
  	//if ($gerai === '0') {
  	//    $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
  	//} else {
  	//    $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
  	//}
  
  	//$sql .= $this->menu_filter('1', $menu);
    //$sql .= " WHERE t1.c_izin_dicabut = 0 and t1.c_izin_selesai = 0 ";
    //$sql .= " WHERE no_induk LIKE '%03.%' ";
    $sql .= " WHERE no_kend != ''";
    if($sSearch != NULL){
      $colum = array("no_kend","no_uji","no_sk","tgl_sk","masa_berlaku","no_kp","tgl_kp_awal","tgl_kp_akhir","nama_pemilik");
      $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
    }
    //$sql .=" ORDER BY t1.id DESC ";
    $sql .=" LIMIT  $iDisplayStart,$iDisplayLength";
    
    //return $this->db->query($sql)->result();
    return $this->dbmodel_akdp->dbakdp_sql($sql);
  }

  function get_total_viewdata(){
    //$db_akdp = $this->load->database('dbakdp',true);        // untuk membuka tabel pada database lain
    $sSearch = $this->input->post('sSearch');
    $sql = $this->sql_info_viewdata();
    //if ($gerai === '0') {
    //    $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
    //} else {
    //    $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
    //}
        
    //$sql .= $this->menu_filter('1', $menu);
    //$sql .= " WHERE t1.c_izin_dicabut = 0 and t1.c_izin_selesai = 0 ";
    //$sql .= " WHERE t1.c_pendaftaran = 1 ";
    //$sql .= " WHERE no_induk LIKE '%03.%' ";
    $sql .= " WHERE no_kend != ''";
    if($sSearch != NULL){
      $colum = array("no_kend","no_uji","no_sk","tgl_sk","masa_berlaku","no_kp","tgl_kp_awal","tgl_kp_akhir","nama_pemilik");
      $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
    }
    //$sql .= " ORDER BY t1.id DESC ";
    //return $this->db->query($sql)->num_rows();
    return $this->dbmodel_akdp->dbakdp_sql_hit($sql);
  }

  function sql_info_viewdata(){ // ambil semua data
    //$sql1="SELECT t1.pendaftaran_id, t3.n_perizinan, t1.a_izin, t1.trsektor_id, t1.d_terima_berkas, t1.kd_gerai, 
    //       if(t5.n_pemohon IS NULL, b.n_pemohon, t5.n_pemohon) AS n_pemohon, t13.n_permohonan ,t7.n_sts_permohonan, t1.id FROM tmpermohonan as t1
    //       LEFT JOIN tmpermohonan_trperizinan as t2 on t1.id = t2.tmpermohonan_id
    //       LEFT JOIN trperizinan as t3 on t3.id = t2.trperizinan_id
    //       LEFT JOIN tmpemohon_tmpermohonan as t4 on t4.tmpermohonan_id = t1.id
    //       LEFT JOIN tmpemohon as t5 on t5.id = t4.tmpemohon_id
    //       LEFT JOIN tmpermohonan_trstspermohonan as t6 on t1.id = t6.tmpermohonan_id
    //       LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
    //       LEFT JOIN tmpemohon_trkelurahan as t8 ON t8.tmpemohon_id= t5.id
    //       LEFT JOIN trkelurahan as t9 on t9.id = t8.trkelurahan_id
    //       LEFT JOIN tmpermohonan_tmperusahaan as t10 on t10.tmpermohonan_id = t1.id
    //       LEFT JOIN tmperusahaan as t11 on t11.id=t10.tmperusahaan_id
    //       LEFT JOIN tmpermohonan_trjenis_permohonan as t12 on t1.id = t12.tmpermohonan_id
    //       LEFT JOIN trjenis_permohonan as t13 on t12.trjenis_permohonan_id = t13.id
    //       LEFT JOIN tmpemohon_sementara_tmpermohonan AS a ON a.tmpermohonan_id = t1.id
    //       LEFT JOIN tmpemohon_sementara AS b ON b.id = a.tmpemohon_sementara_id
    //       LEFT JOIN tmpermohonan_tmperusahaan_sementara AS c ON t1.id = c.tmpermohonan_id
    //       LEFT JOIN tmperusahaan_sementara AS d ON d.id = c.tmperusahaan_sementara_id
    //      ";
    $sql="select id, no_induk, no_kend, no_uji, no_sk, tgl_sk, masa_berlaku, no_kp, tgl_kp_awal, tgl_kp_akhir,	nama_pemilik from akdpkendaraan";
    return $sql;
  }

  //public function ctk_perhubungan() {
  //  $u_ser = $this->session->userdata('username');
  //  $r_name = $this->lib_date->get_nama_ori($u_ser);
  //  $syarat = $this->input->post('pemohon_syarat');
  //  $syarat_len = count($syarat);
  //  $is_array = NULL;
  //  echo $u_ser .' || ';
  //  echo $syarat_len .' || ';
  //  for ($i = 0; $i < $syarat_len; $i++) {
  //    echo $syarat[$i] .' || ';
  //    $is_array = $syarat[$i];
  //  }
  //}
}