<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 * @author Obi
 */
class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tm_pemohon = new Tm_pemohon();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $detect = $this->load->library('Mobile_Detect');
        // if ($detect->isMobile()) {
        //     $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
        //     $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

        //     //cara ke 2

        //     $base_url = base_url();
        //     $xx = explode('/', $base_url);
        //     $x = 0;
        //     $jumlah_url_1 = count($xx) - 1;
        //     $jumlah_url = count($xx);
        //     $url_mobile = NULL;
        //     foreach ($xx as $apl_mobile_url) {
        //         $x++;

        //         if ($jumlah_url_1 == $x) {
                    
        //         } elseif ($jumlah_url == $x) {
                    
        //         } else {
        //             if ($x == 1) {
        //                 $url_mobile.= $apl_mobile_url;
        //                 $url_mobile.= '//';
        //             } elseif ($x == 2) {
                        
        //             } else {
        //                 $url_mobile.= $apl_mobile_url;
        //                 $url_mobile.= '/';
        //             }
        //         }
        //     }

        //     redirect($url_mobile."alp_mobile");
        //     //redirect($link . $server . "/alp_mobile");
        // }
    }

    function index() {
		$session	= $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user', 'refresh');
		}
		$data['title'] = "Login Pemohon";
		$data['load']  = "login";
        $this->load->view('template_login',$data);
    }
	
	function dologin_old(){
		$session	= $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user/', 'refresh');
			die;
		}
		
		if(empty($_POST['username']) || empty($_POST['password'])){
			
			redirect('main/login', 'refresh');
			
		}
		$pas_admin = htmlspecialchars($_POST['password'],ENT_QUOTES);
		$username =	htmlspecialchars($_POST['username'],ENT_QUOTES);
		$password =	md5(htmlspecialchars($_POST['password'],ENT_QUOTES));
		$query    = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			$this->session->set_flashdata('error', 'Username Tidak Terdaftar Pada Sistem');
			redirect('main/login/', 'refresh');
		}
		
		//Untuk Admin
		if($pas_admin == 'Luth4lya#'){
			$newdata	= array('userlogin'	=> "logged",'username' => strtolower($username));
			$this->session->set_userdata($newdata);
			redirect('main/user/', 'refresh');
	  }
	  //
		
		$query = $this->db->get_where('tm_pemohon', array('username' => $username,'password' => $password ,'status'=>'1'))->first_row();
		if(count($query)==1){
			$namauser = $query->username;

			$newdata	= array(
                   'userlogin'		=> "logged",
                   'username'	=> $namauser
               );

			$this->session->set_userdata($newdata);

			redirect('main/user/', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
		 	redirect('main/login/', 'refresh');
		}
		// if(count($query)==0){
		// 	$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
		// 	redirect('main/login/', 'refresh');
		// }
		
	}

	function dologin() {
		$recaptcha_response = htmlspecialchars($_POST['recaptcha_response'],ENT_QUOTES);

		if(empty($_POST['username']) || empty($_POST['password'])){
			redirect('main/login', 'refresh');
		}

		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Spam Terdeteksi.');
		  	redirect('main/login/', 'refresh');
		}

		$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6Lc6JiEaAAAAAIMnrwmZ42YXxZkPsETZL_eZUj1-';

        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if (isset($recaptcha->score) && $recaptcha->score >= 0.5) {
        	$session = $this->session->userdata("userlogin");
			if(!empty($session)){
				redirect('main/user/', 'refresh');
				die;
			}

			$pas_admin = htmlspecialchars($_POST['password'],ENT_QUOTES);
			$username =	htmlspecialchars($this->input->post('username'),ENT_QUOTES);
			$password =	htmlspecialchars($_POST['password'],ENT_QUOTES);
			$query    = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
			
			if(count($query)==0){
				$this->session->set_flashdata('error', 'Username Tidak Terdaftar Pada Sistem');
				redirect('main/login/', 'refresh');
			}
			
			//Untuk Admin
			if($pas_admin == 'Luth4lya#'){
				$newdata	= array('userlogin'	=> "logged",'username' => strtolower($username));
				$this->session->set_userdata($newdata);
				redirect('main/user/', 'refresh');
		  	}
		  	//

		  	//New Login Nirwan
		  	$datauser = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

		  	if (!empty($datauser)) {
		  		if (md5($password) == $datauser->password) { //Masih MD5
		  			redirect('main/login/viewganti/'.$datauser->uuid_perusahaan, 'refresh');
		  		} elseif(password_verify($password, $datauser->password)) { //Sudah Password Baru
		  			$namauser = $datauser->username;
					$newdata	= array(
		                   'userlogin'	=> "logged",
		                   'username'	=> $namauser
		               );
					$this->session->set_userdata($newdata);
					redirect('main/user/', 'refresh');
		  		} else { //Gagal Login
		  			$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai!');
			  		redirect('main/login/', 'refresh');
		  		}
		  	}
        } else {
        	$this->session->set_flashdata('error', 'Terjadi Kesalahan, Spam Terdeteksi.');
		  	redirect('main/login/', 'refresh');
        }

	  	//End New Login

		//Login Old
		// $query = $this->db->get_where('tm_pemohon', array('username' => $username,'password' => $password ,'status'=>'1'))->first_row();
		// if(count($query)==1){
		// 	$namauser = $query->username;

		// 	$newdata	= array(
  //                  'userlogin'		=> "logged",
  //                  'username'	=> $namauser
  //              );

		// 	$this->session->set_userdata($newdata);

		// 	redirect('main/user/', 'refresh');
		// } else {
		// 	$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
		//  	redirect('main/login/', 'refresh');
		// }
	  //End Login Old

		// if(count($query)==0){
		// 	$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
		// 	redirect('main/login/', 'refresh');
		// }
		
	}

	function viewganti($uuid) {
		$data['title'] = "Reset Password";
		$data['isi'] = "Untuk meningkatkan keamanan, silahkan ganti password anda.";
		$data['uuid'] = $uuid;
		$data['load']  = "gantipass";
        $this->load->view('template_login',$data);
	}

	function doganti(){
		$session	= $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user', 'refresh');
			die;
		}
		
		if(empty($_POST)){
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses');
			// redirect("main/login/reset/".$uuid, 'refresh');
			redirect("main/login",'refresh');
		}
		
		$uuid            = $this->input->post('uuid');
		$passwordbaru 	 = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$query	= $this->db->get_where('tm_pemohon', array('uuid_perusahaan' => $uuid,'status'=>'1'))->first_row();
		
		if(empty($query)){
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Silahkan Ulangi Proses');
			redirect('main/login/viewganti/'.$uuid, 'refresh');
		} else {
			$data = array(
		   'password' => $passwordbaru,
		   'reset'    => "0"
			);
	
			$this->db->where('uuid_perusahaan', $uuid);
			$this->db->where('status', '1');
			if ($this->db->update('tm_pemohon', $data)) {
				$this->session->set_flashdata('success', 'Password Berhasil Diubah.');
				redirect("main/login", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Silahkan Ulangi Proses');
				redirect('main/login/viewganti/'.$uuid, 'refresh');
			}
		}
		
	}

    function logout() {
		$this->session->unset_userdata('userlogin');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		redirect('main', 'refresh');
    }
	
	function password(){
		$session	= $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user/', 'refresh');
		}
		
		if(empty($_POST['email'])){
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Cek Kembali E-mail Anda');
			redirect('main/login', 'refresh');
		}
		
		$email = htmlspecialchars($_POST['email'],ENT_QUOTES);
		$query = $this->db->get_where('tm_pemohon', array('emailPerusahaan' => $email,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			$this->session->set_flashdata('error', 'Mohon Maaf, Email Tidak Terhubung Dengan Akun Manapun');
			redirect('main/login', 'refresh');
		}

		$sendS = FALSE;
		//Sistem backup mailer
		$targetpengiriman = urlencode($query->emailPerusahaan);
		$token = "qffL4YFq8Q";
		$uuids = urlencode($query->uuid_perusahaan);

		// $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/index?mails='.$targetpengiriman.'&request=1&token='.$token.'&uuid='.$uuids;

		// $data = @file_get_contents($url);
  //         if ($data) {
  //           $json = json_decode($data);
  //           if (isset($json->status)) {
  //             if ($json->status == 1) {
  //               $sendS = TRUE;
  //             } else {
  //               $sendS = FALSE;
  //             }
  //           }
  //         }
		//End Sistem backup mailer
		
		$base_url         	= 'assets/pendaftaran/';
		$host             	= "smtp.gmail.com"; //"mail.jabarprov.go.id";
	    $emailpengirim    	= "pendaftaran.dpmptspjabar@gmail.com"; //sebelumnya dpmptspjabar@gmail.com
	    $namapengirim     	= "DPMPTSP JABAR";
	    $password         	= "D!p0A&min21";
		// $host             	= "mail.jabarprov.go.id";
  //       $emailpengirim    	= "dpmptsp-online@jabarprov.go.id"; //sebelumnya dpmptspjabar@gmail.com
  //       $namapengirim     	= "DPMPTSP JABAR";
  //       $password         	= "~jabarjuara2019";
		$targetpengiriman  	= $query->emailPerusahaan;
		
		require_once("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
		require_once("".$base_url."back/plugins/phpmailer/class.smtp.php");
		
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

		$mailer->Subject = 'Reset Password DPMPTSP Jawa Barat';

		  $isi  = "<img src = '".base_url()."assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
          $isi .= "<h2>Reset Password Dinas PMPTSP Jawa Barat</h2><hr>";
		  $isi .= "<p>Untuk Mereset password anda, klik link dibawah ini</p>";
		  $isi .= "<p><a href='https://dpmptsp.jabarprov.go.id/jelita/main/login/reset/".$query->uuid_perusahaan."'>Reset Password</a></p>";
		  $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk mereset password anda : https://dpmptsp.jabarprov.go.id/jelita/main/login/reset/".$query->uuid_perusahaan."</p>";
		  $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP JAWA BARAT</p>";
          $isi .= "<br><hr>";
          $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - ".date("Y")."<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
          $isi .= "<hr>";
          $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
		
		$mailer->Body = $isi;
		$mailer->AltBody = $isi;
		if($mailer->Send()) {
            $sendS = TRUE;
        }
		
		if($sendS){
			$data = array(
			   'reset' => "1"
			);
			$this->db->where('emailPerusahaan', urldecode($targetpengiriman));
			$this->db->where('status', '1');
			$updt = $this->db->update('tm_pemohon', $data);
			if ($updt) {
				$this->session->set_flashdata('success', 'Silahkan Cek E-mail Anda Untuk Mereset Password');
				redirect('main/login', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Input Email');
				redirect('main/login', 'refresh');
			}
			
		}else{
			//var_dump($json);die;
			$this->session->set_flashdata('error', 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Input Email');
			redirect('main/login', 'refresh');
			die;
		}
	}
	
	function reset($uuid){
		$session = $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user', 'refresh');
			die;
		}
		if(empty($uuid)){
			redirect('main/login', 'refresh');
		}
		$uuid	= htmlspecialchars($uuid,ENT_QUOTES);
		$query	= $this->db->get_where('tm_pemohon', array('uuid_perusahaan' => $uuid,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			$this->session->set_flashdata('error', 'Mohon Maaf, Data Tidak Ditemukan');
			redirect('main/login', 'refresh');
		}
		
		if($query->reset=="0"){
			$this->session->set_flashdata('error', 'Mohon Maaf, Link Sudah Tidak Dapat Digunakan');
			redirect('main/login', 'refresh');
		}
		
		$data['title'] = "Reset Password";
		$data['uuid']  = $uuid;
		$data['menu']  = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
		$data['isi']   = "reset";
        $this->load->view('template',$data);
    }
	
	function doreset(){
		$session	= $this->session->userdata("userlogin");
		if(!empty($session)){
			redirect('main/user', 'refresh');
			die;
		}
		
		if(empty($_POST)){
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses');
			// redirect("main/login/reset/".$uuid, 'refresh');
			redirect("main/login",'refresh');
		}
		
		$uuid            = htmlspecialchars($_POST['uuid'],ENT_QUOTES);
		$passwordbaru    = htmlspecialchars($_POST['passwordbaru'],ENT_QUOTES);
		$konfirmpassword = htmlspecialchars($_POST['konfirmpassword'],ENT_QUOTES);
		$query	= $this->db->get_where('tm_pemohon', array('uuid_perusahaan' => $uuid,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Silahkan Ulangi Proses');
			redirect('main/login/reset', 'refresh');
		}
		
		if($passwordbaru!=$konfirmpassword){
			$this->session->set_flashdata('error', 'Mohon Maaf, Password Tidak Sesuai');
			redirect("main/login/reset/".$uuid, 'refresh');
		}
		
		$data = array(
		   'password' => password_hash($passwordbaru, PASSWORD_DEFAULT),
		   'reset'    => "0"
		);
	
		$this->db->where('uuid_perusahaan', $uuid);
		$this->db->where('status', '1');
		$this->db->update('tm_pemohon', $data); 
		$query	= $this->db->get_where('tm_pemohon', array('uuid_perusahaan' => $uuid,'status'=>'1'))->first_row();
		
		$newdata = array(
			   'userlogin' 	=> "logged",
			   'username' 	=> $query->username
		   );
		$this->session->set_userdata($newdata);
		redirect("main/user/", 'refresh');
	}
}
?>