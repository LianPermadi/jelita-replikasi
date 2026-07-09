<?php

/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 * Description of welcome @author Obi
 * Edited PBS April 2017
 */

class Pendaftaranbaru extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->tm_pemohon = new Tm_pemohon();
    $this->tmwcm = new Tmwcm();
    $otherdb = $this->load->database('otherdb', TRUE);
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $sql = "select settings.status from settings where name='smsGateway'";
    $a = $otherdb->query($sql)->first_row();
    $this->kdsms = $a->status;
    $sql = "select settings.status from settings where name='send_mail'";
    $a = $otherdb->query($sql)->first_row();
    $this->kdmail = $a->status;
  }
  
  function index() {
    $session = $this->session->userdata("userlogin");
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    
    $provinsi = $otherdb->query('select * from trpropinsi order by n_propinsi')->result();
    $kabupaten = $otherdb->query("select * from trkabupaten where kd_prov='12' order by n_kabupaten")->result();
    
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $data['isi'] = "isi_pendaftaranbaru";
    $data['provinsi'] = $provinsi;
    $data['kabupaten'] = $kabupaten;
    $data['sms'] = $this->kdsms;
    $data['mail'] = $this->kdmail;
    $this->load->view('template',$data);
  }

  function perizinanonline() {
    $session = $this->session->userdata("userlogin");
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    
    $sektor = $otherdb->query('select * from trsektor')->result();
    
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $data['isi'] = "isi_perizinanonline";
    $data['sektor'] = $sektor;
    $data['sms'] = $this->kdsms;
    $data['mail'] = $this->kdmail;
    $this->load->view('template',$data);
  }

  function pilihizin() {
    $session = $this->session->userdata("userlogin");
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }

    $data = $this->input->post('perizinan');
    
    $queryget = "SELECT * FROM trperizinan 
    			 WHERE c_online = '0' AND id = ? LIMIT 1";
    $rowsData = $otherdb->query($queryget, array($data))->result();
    foreach($rowsData as $row) {
      $via = $row->via;
    }

    if ($via == 0) {
    	redirect('main/pendaftaranbaru', 'refresh');
    } else {
    	redirect("https://sicantikui.layanan.go.id/");
    }
    
  }

  function getperizinan(){
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    //Update Anti SQL Inject Nirwan
    $data = $this->input->post('data');
    $str = '|------------------------ Pilih Perizinan ------------------------,';
    $queryget = "select A.* from trperizinan A 
    			       INNER JOIN trperizinan_trsektor B ON A.id = B.trperizinan_id 
    			       WHERE B.trsektor_id=? AND (A.c_online = 0) AND A.id <> 237 ORDER BY A.n_perizinan";
    $rowsData = $otherdb->query($queryget, array($data))->result();
    foreach($rowsData as $row) {
      $izin = str_replace(", ", ".", $row->n_perizinan);
      $str = $str . "$row->id|$izin".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }
  
  function getkabupaten(){
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    //Update Anti SQL Inject Nirwan
    $data = $this->input->post('data');
    $str = '|------------------------ Pilih Kabupaten ------------------------,';
    $queryget = "select * from trkabupaten where kd_prov=? order by n_kabupaten";
    $rowsData = $otherdb->query($queryget, array($data))->result();
    foreach($rowsData as $row) {
      $kab = $row->n_kabupaten;
      $str = $str . "$row->kd_kab|$kab".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }
	
  function getkecamatan(){
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    //Update anti SQL Inject Nirwan
    $data = $this->input->post('data');
    $str = '';
    $queryget = "select * from trkecamatan where kd_kab=? order by n_kecamatan";
    $rowsData = $otherdb->query($queryget, array($data))->result();
    $str = '|------------------------ Pilih Kecamatan ------------------------,';
    foreach($rowsData as $row) {
      $kab = $row->n_kecamatan;
      $str = $str . "$row->kd_kec|$kab".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }
	
  function getkelurahan(){
    $otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    //Update anti SQL Inject Nirwan
    $data = $this->input->post('data');
    $str = '';
    $queryget = "select * from trkelurahan where kd_kel  IN (SELECT trkelurahan_id FROM trkecamatan_trkelurahan WHERE trkecamatan_id =?) order by n_kelurahan";
    $rowsData = $otherdb->query($queryget, array($data))->result();
    $str = '|------------------------ Pilih Kelurahan ------------------------,';
    foreach($rowsData as $row) {
      $kab = $row->n_kelurahan;
      $str = $str . "$row->kd_kel|$kab".",";
    }
    $str = substr($str,0,(strLen($str)-1)); 
    echo json_encode($str);
  }
	
  function dopendaftaran(){
    $session = $this->session->userdata("userlogin");
    // $cp_as = htmlspecialchars($_POST['isi_capca'],ENT_QUOTES);
    // $cp_kt = htmlspecialchars($_POST['isi_capca2'],ENT_QUOTES);
    $gcaptcha = $this->input->post('g-recaptcha-response');

    //Proses Google reCaptcha
    if (!$gcaptcha) {
        $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
        redirect('main/pendaftaranbaru', 'refresh');
    }

    $secretKey = "6LdJzMgZAAAAAPovppwJu02lDQtIjX1DJ9VD7lEM";

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($gcaptcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);

    if($responseKeys["success"]){
      if(!empty($session)) {
        redirect('main/user', 'refresh');
        die;
      }
      		
      ///// CEK EMAIL & HP EKSISTING
      $email = htmlspecialchars($_POST['email_pemohon'],ENT_QUOTES);
      $telp_pemohon = htmlspecialchars($_POST['telp_pemohon'],ENT_QUOTES);
      
      $query	= $this->db->get_where('tm_pemohon', array('emailPerusahaan' => $email))->first_row();
      if(count($query)>0) {
        $this->session->set_flashdata('error', "Mohon Maaf, Email Sudah Terdaftar atas nama <i>".$query->namaPerusahaan."</i>");
        redirect('main/pendaftaranbaru', 'refresh');
      }
      
      $query	= $this->db->get_where('tm_pemohon', array('telpPerusahaan' => $telp_pemohon))->first_row();
      if(count($query)>0) {
        $this->session->set_flashdata('error', "Mohon Maaf, Nomor Telpon Sudah Terdaftar atas nama <i>".$query->namaPerusahaan."</i>");
        redirect('main/pendaftaranbaru', 'refresh');
      }
      ///// END CEK EMAIL & HP EXISTING
      
      ///// GENERATE TOKEN
      $no = 1;
      $token = "";
      while($no<=3) {
        $token	.= substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        if($no<3){ 
          $token	.= "-"; 
        }
        $no++;
      }
      ///// END GENERATE TOKEN
      
      $nama_pemohon = htmlspecialchars($_POST['nama_pemohon'],ENT_QUOTES);
      $nama_pemegang_kuasa = htmlspecialchars($_POST['nama_pemegang_kuasa'],ENT_QUOTES);
      $telp_pemegang_kuasa = htmlspecialchars($_POST['telp_pemegang_kuasa'],ENT_QUOTES);
      $email_pemohon = htmlspecialchars($_POST['email_pemohon'],ENT_QUOTES);
      $alamat_pemohon = nl2br(htmlspecialchars($_POST['alamat_pemohon'],ENT_QUOTES));
      $provinsi =	htmlspecialchars($_POST['provinsi'],ENT_QUOTES);
      $kabupaten = htmlspecialchars($_POST['kabupaten'],ENT_QUOTES);
      $kecamatan = htmlspecialchars($_POST['kecamatan'],ENT_QUOTES);
      $kelurahan = htmlspecialchars($_POST['kelurahan'],ENT_QUOTES);
      $jenis = htmlspecialchars($_POST['jenis'],ENT_QUOTES);
      	
      if($jenis=="pemohon") {
        $penanggung_jawab = $nama_pemohon;
      } else { 
        if($jenis=="perusahaan") {
          $penanggung_jawab	=	htmlspecialchars($_POST['nama_direktur'],ENT_QUOTES);
        } else {
          $this->session->set_flashdata('error', "Mohon Maaf, Terjadi kesalahan, mohon mengulangi proses pendaftaran");
          redirect('main/pendaftaranbaru', 'refresh');
        }
      }
      	
      $data = array('namaPerusahaan'        => $nama_pemohon ,
                    'namaPemohon'           => $nama_pemegang_kuasa ,
                    'telpPerusahaan'        => $telp_pemohon ,
                    'telpPemohon'           => $telp_pemegang_kuasa ,
                    'emailPerusahaan'       => $email_pemohon,
                    'almtPerusahaan'        => $alamat_pemohon,
                    'token'                 => $token,
                    'propinsi2'             => $provinsi,
                    'kabupaten2'            => $kabupaten,
                    'kecamatan2'            => $kecamatan,
                    'kelurahan2'            => $kelurahan,
                    'tgl_daftar'            => date("Y-m-d"),
                    'jenis'                 => $jenis,
                    'nama_penanggung_jawab' => $penanggung_jawab);
      
      if($this->db->insert('tm_pemohon', $data)) {
        ///// KIRIM E-MAIL
        $sendE = FALSE;
        if($this->kdmail == 1) {
          $send1 = 0;

          $targetpengiriman = urlencode($email);
          $tokens = "qffL4YFq8Q";
          $uuids = urlencode($token);

          // $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/index?mails='.$targetpengiriman.'&request=2&token='.$tokens.'&uuid='.$uuids;

          // $data = @file_get_contents($url);
          // if ($data) {
          //   $json = json_decode($data);
          //   if (isset($json->status)) {
          //     if ($json->status == 1) {
          //       $sendE = TRUE;
          //       $send1 = 1;
          //     } else {
          //       $sendE = FALSE;
          //       $send1 = 0;
          //     }
          //   }
          // }

          if ($sendE == FALSE && $send1 == 0) {
          	$base_url         = 'assets/pendaftaran/';
          	require_once("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
          	require_once("".$base_url."back/plugins/phpmailer/class.smtp.php");
            $host             = "smtp.gmail.com";
          	$emailpengirim    = "pendaftaran.dpmptspjabar@gmail.com"; //sebelumnya dpmptspjabar@gmail.com
          	$namapengirim     = "DPMPTSP JABAR";
          	$password         = "D!p0A&min21";
            $targetpengiriman = $email;
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
            $mailer->From = $emailpengirim;
            $mailer->AddAddress($targetpengiriman,$targetpengiriman);
            $mailer->Subject = 'Token Pendaftaran Akun DPMPTSP Jawa Barat';
            $isi  = "<img src = '".base_url()."assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
            $isi .= "<h2>Token Pendaftaran Akun DPMPTSP Jawa Barat</h2><hr>";
            $isi .= "<p>Terimakasih atas pendaftaran anda, berikut ini adalah nomor token anda : </p>";
            $isi .= "<p>".$token."</p>";
            $isi .= "<p>Silahkan masukkan nomor token anda pada halaman berikut : <a href='https://dpmptsp.jabarprov.go.id/sicantik/main/pendaftaranbaru/konfirm'>Verifikasi Permohonan Proposal</a></p>";
            $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk menuju halaman aktifasi akun anda : https://dpmptsp.jabarprov.go.id/sicantik/main/pendaftaranbaru/konfirm</p>";
            $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP JAWA BARAT</p>";
            $isi .= "<br><hr>";
            $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - ".date("Y")."<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
            $isi .= "<hr>";
            $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
            $mailer->Body = $isi;
            $mailer->AltBody = $isi;
            if($mailer->Send()) {
            $sendE = TRUE;
            }
          }
        }
        ///// EOF() KIRIM E-MAIL
        
        ///// KIRIM SMS
        $sendS = FALSE;
        $campaign = 'Token';
        if($this->kdsms == 1) {
          $username   = 'dpmptspjbr';
          $password   = '4RrtRM5X';
          if (!empty($_POST['telp_pemegang_kuasa'])) {
            $receiver = $telp_pemohon.",".$telp_pemegang_kuasa;
            $method   = 'multiple';
          } else {
            $receiver = $telp_pemohon;
            $method   = 'single';
          }
          $message  = urlencode("Token pendaftaran akun Perizinan Online DPMPTSP Jabar anda adalah :\n".$token);

          $url = 'http://103.122.5.111/eskalasi/public/messaging/request?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message.'&campaign='.$campaign;

          $data = @file_get_contents($url);
          if ($data) {
            $json = json_decode($data);
            if (isset($json->status)) {
              if ($json->status == "200") {
                $sendS = TRUE;
              } else {
                $sendS = FALSE;
              }
            }
          }
        }
        ///// EOF() KIRIM SMS
        
        if($sendE || $sendS) {
          redirect('main/pendaftaranbaru/konfirm', 'refresh');
        } else {
          $this->db->where('emailPerusahaan', $email);
          $this->db->delete('tm_pemohon'); 
          $this->session->set_flashdata('error', 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Pendaftaran');
          echo 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Pendaftaran';
          echo '<script type="text/javascript">console.log("'.htmlentities($mailer->ErrorInfo).'");</script>';
          die;
        }
      } else {
        $this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses Pendaftaran');
        redirect('main/pendaftaranbaru', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'Captcha gagal, Mohon Ulangi Proses Pendaftaran');
      redirect('main/pendaftaranbaru', 'refresh');
    }
  }
	
  function konfirm(){
    $session = $this->session->userdata("userlogin");
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    $data['menu']  = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $data['isi']   = "konfirmpendaftaran";
    $this->load->view('template',$data);
  }
	
  function dokonfirm(){
    $session = $this->session->userdata("userlogin");
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    if(empty($_POST['token'])){
      redirect('main/pendaftaranbaru/konfirm', 'refresh');
    }
    
    $token = htmlspecialchars($_POST['token'],ENT_QUOTES);
    $query = $this->db->get_where('tm_pemohon', array('token' => $token,'status'=>'0'))->first_row();
    if(count($query)==0){
      $this->session->set_flashdata('error', 'Mohon Maaf, Nomor Token Tidak Terhubung Dengan Akun Manapun');
      redirect('main/pendaftaranbaru/konfirm', 'refresh');
    }else{ 
      if(count($query)==1){
        $telp_pemohon = $query->telpPerusahaan;
        $telp_pemegang_kuasa = $query->telpPemohon;
        $string  = $query->namaPerusahaan;
        $search	 = array('CV.', 'PT.','CV','PT');
        $replace = "";
        $string  = str_replace($search, $replace, $string);
        $string  = str_replace(' ', '', $string);                 // Replaces all spaces with hyphens.
        $string  = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string  = strtolower(preg_replace('/-+/', '', $string));
        $query   = $this->db->get_where('tm_pemohon', array('username' => $string))->result();
        
        function cekusername($string){
          $token = substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 3);
          $uname = $string."".$token;
          return $uname;
        }
        
        if(count($query)>0){
          $string	= cekusername($string);
        }
        
        $passworduser = substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 6);
        $query = $this->db->get_where('tm_pemohon', array('token' => $token,'status'=>'0'))->first_row();
              
        ///// KIRIM E-MAIL
        $base_url         = 'assets/pendaftaran/';
        require_once("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
        require_once("".$base_url."back/plugins/phpmailer/class.smtp.php");
        $sendE = FALSE;
        if($this->kdmail == 1){	
          $send2 = 0;		    
          //$base_url         = 'assets/pendaftaran/';
          $host             = "smtp.gmail.com"; //"mail.jabarprov.go.id";
          $emailpengirim    = "pendaftaran.dpmptspjabar@gmail.com"; //sebelumnya dpmptspjabar@gmail.com
          $namapengirim     = "DPMPTSP JABAR";
          $password         = "D!p0A&min21";
          $targetpengiriman =	$query->emailPerusahaan;
          // require("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
          // require("".$base_url."back/plugins/phpmailer/class.smtp.php");
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
          $mailer->From = $emailpengirim;
          $mailer->AddAddress($targetpengiriman,$targetpengiriman);
          $mailer->Subject = 'Pendaftaran Akun DPMPTSP Jawa Barat';
          $isi  = "<img src = '".base_url()."assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
          $isi .= "<h2>Data Pendaftaran Akun DPMPTSP Jawa Barat</h2><hr>";
          $isi .= "<p>Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda : </p>";
          $isi .= "<p><table><tr><td>Username</td><td>: ".$string."</td></tr><tr><td>Password</td><td>: ".$passworduser."</td></tr></table></p>";
          $isi .= "<p>Silahkan Login Untuk Melengkapi Data anda, <a href='https://dpmptsp.jabarprov.go.id/sicantik/main/login'>Login Disini</a></p>";
          $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk menuju halaman login : https://dpmptsp.jabarprov.go.id/sicantik/main/login</p>";
          $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP JAWA BARAT</p>";
          $isi .= "<br><hr>";
          $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - ".date("Y")."<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
          $isi .= "<hr>";
          $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
          $mailer->Body = $isi;
          $mailer->AltBody = $isi;
          if($mailer->Send()) {
            $sendE = TRUE;
            $send2 = 1;
          }

          // $targetpengiriman = urlencode($query->emailPerusahaan);
          // $tokens = "qffL4YFq8Q";
          // $uuids = urlencode(base64_encode($string.'^'.$passworduser));

          // $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/index?mails='.$targetpengiriman.'&request=3&token='.$tokens.'&uuid='.$uuids;

          // $data = @file_get_contents($url);
          // if ($data) {
          //   $json = json_decode($data);
          //   if (isset($json->status)) {
          //     if ($json->status == 1) {
          //       $sendE = TRUE;
          //       $send2 = 1;
          //     } else {
          //       $sendE = FALSE;
          //       $send2 = 0;
          //     }
          //   }
          // }
          
          if ($sendE == FALSE && $send2 == 0) {
          	$host             = "mail.jabarprov.go.id";
          	$emailpengirim    = "dpmptsp-online@jabarprov.go.id"; //sebelumnya dpmptspjabar@gmail.com
          	$namapengirim     = "DPMPTSP JABAR";
          	$password         = "~jabarjuara2019";
            $targetpengiriman = $query->emailPerusahaan;
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
            $mailer->From = $emailpengirim;
            $mailer->AddAddress($targetpengiriman,$targetpengiriman);
            $mailer->Subject = 'Pendaftaran Akun DPMPTSP Jawa Barat';
            $isi  = "<img src = '".base_url()."assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
            $isi .= "<h2>Data Pendaftaran Akun DPMPTSP Jawa Barat</h2><hr>";
            $isi .= "<p>Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda : </p>";
            $isi .= "<p><table><tr><td>Username</td><td>: ".$string."</td></tr><tr><td>Password</td><td>: ".$passworduser."</td></tr></table></p>";
            $isi .= "<p>Silahkan Login Untuk Melengkapi Data anda, <a href='https://dpmptsp.jabarprov.go.id/sicantik/main/login'>Login Disini</a></p>";
            $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk menuju halaman login : https://dpmptsp.jabarprov.go.id/sicantik/main/login</p>";
            $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP JAWA BARAT</p>";
            $isi .= "<br><hr>";
            $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - 2019<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
            $isi .= "<hr>";
            $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
            $mailer->Body = $isi;
            $mailer->AltBody = $isi;
              if($mailer->Send()) {
              $sendE = TRUE;
              }
          }
        }
        ///// EOF() KIRIM E-MAIL
                
        ///// KIRIM SMS
        $sendS = FALSE;
        if($this->kdsms == 1){
          // $sendS = TRUE;
          // $gammu = $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
          // $data = array('DestinationNumber' => $telp_pemohon, 
          //               'TextDecoded' => "Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda: \n Username : ".$string.
          //               " \n Password : ".$passworduser."");
          // $gammu->insert('outbox',$data);
          
          // if($telp_pemegang_kuasa!=""){
          //   $data = array('DestinationNumber' => $telp_pemegang_kuasa,
          //                 'TextDecoded' => "Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda: \n Username : ".$string.
          //                 " \n Password : ".$passworduser."");
          //   $gammu->insert('outbox',$data);
          // }
          $campaign = 'Authentication';
          $username   = 'dpmptspjbr';
          $password   = '4RrtRM5X';
          if ($telp_pemegang_kuasa!="") {
            $receiver = $telp_pemohon.",".$telp_pemegang_kuasa;
            $method   = 'multiple';
          } else {
            $receiver = $telp_pemohon;
            $method   = 'single';
          }
          $message  = urlencode("Terima Kasih atas pendaftaran anda berikut adalah username dan password akun DPMPTSP anda: \n Username : ".$string." \n Password : ".$passworduser);

          // $url = 'https://portal.smsblast.id/api/send'.$method.'.json?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message.'&campaign='.$campaign;

          // $data = file_get_contents($url);
          // if ($data) {
          //   $json = json_decode($data);
          //   if (isset($json->code)) {
          //     if ($json->code == 1) {
          //       $sendS = TRUE;
          //     } else {
          //       $sendS = FALSE;
          //     }
          //   }
          // }

          $url = 'http://103.122.5.111/eskalasi/public/messaging/request?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message.'&campaign='.$campaign;
                
          $data = @file_get_contents($url);
          if ($data) {
            $json = json_decode($data);
            if (isset($json->status)) {
              if ($json->status == "200") {
                $sendS = TRUE;
              } else {
                $sendS = FALSE;
              }
            }
          }
        }
        ///// EOF() KIRIM SMS
        
        if($sendE || $sendS){
          $data = array('username' => $string, 'password'	=> password_hash($passworduser, PASSWORD_DEFAULT),'status' => "1");
          
          ///// CREATE DIREKTORI
          $path = "assets/userassets/pemohon/".$string."";
          $dokumen = "assets/userassets/pemohon/".$string."/dokumen";
          $dokumen_pengajuan = "assets/userassets/pemohon/".$string."/dokumen_pengajuan";
          $pengajuan = "assets/userassets/pemohon/".$string."/pengajuan";
          
          if(!is_dir($path)){ //create the folder if it's not already exists
            mkdir($path,0755,TRUE);
            mkdir($dokumen,0755,TRUE);
            mkdir($dokumen_pengajuan,0755,TRUE);
            mkdir($pengajuan,0755,TRUE);
          } 
          
          $this->db->where('token', $token);
          $this->db->where('status', '0');
          $this->db->update('tm_pemohon', $data); 
          redirect('main/pendaftaranbaru/suksestoken', 'refresh');
        }else{
          $this->session->set_flashdata('error', 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Konfirmasi Token');
          redirect('main/pendaftaranbaru/konfirm', 'refresh');
          die;
        }
      }
    }
  }
	
  function suksestoken(){
    $session = $this->session->userdata("userlogin");
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $data['isi'] = "suksestoken";
    $this->load->view('template',$data);
  }

  //get_capcha================================================================================
  function get_capcha() {
    $capcha = $this->captcha();
    $data['img'] = $capcha['img'];
    $data['word'] = $capcha['word'];
    $this->load->view('isi_capcha', $data);
  }
  
  function captcha() {
    $this->load->plugin('captcha');
    $str = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
    $random_word = str_shuffle($str);
    $random_word = substr($random_word, 0, 5);
    $vals = array('word' => $random_word,
                  'img_path' => 'captcha/',
                  'img_url' => base_url() . '/captcha/',
                  'img_width' => '200',
                  'img_height' => 50,
                  'expiration' => 7200
                 );
    $cap = create_captcha($vals);
    $data = array('captcha_time' => $cap['time'],
                  'ip_address' => $this->input->ip_address(),
                  'word' => $cap['word']
                 );
    $cap_conf = array('img' => $cap['image'],
                      'word' => $cap['word']
                     );
    return $cap_conf;
  }

}
?>