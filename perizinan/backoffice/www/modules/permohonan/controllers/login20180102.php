<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
//        $this->tr_propinsi = new trpropinsi();
//        $this->tr_kabupaten = new trkabupaten();
//        $this->tr_keluarahan = new trkelurahan();
//        $this->tr_kecamatan = new trkecamatan();

        $this->tm_pemohon = new Tm_pemohon();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $detect = $this->load->library('Mobile_Detect');
        if ($detect->isMobile()) {
            $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
            $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

            //cara ke 2

            $base_url = base_url();
            $xx = explode('/', $base_url);
            $x = 0;
            $jumlah_url_1 = count($xx) - 1;
            $jumlah_url = count($xx);
            $url_mobile = NULL;
            foreach ($xx as $apl_mobile_url) {
                $x++;

                if ($jumlah_url_1 == $x) {
                    
                } elseif ($jumlah_url == $x) {
                    
                } else {
                    if ($x == 1) {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '//';
                    } elseif ($x == 2) {
                        
                    } else {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '/';
                    }
                }
            }

            redirect($url_mobile."alp_mobile");
            //redirect($link . $server . "/alp_mobile");
        }
    }

    function index() {
	
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
			
		}
		
		$data['title']		= "Login Pemohon";
		$data['load']	= "login";
        $this->load->view('template_login',$data);
    }
	
	function dologin(){
		
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user/', 'refresh');
			die;
		
		}
		
		if(empty($_POST['username']) || empty($_POST['password'])){
			
			redirect('main/login', 'refresh');
			
		}
		
		$username	=	htmlspecialchars($_POST['username'],ENT_QUOTES);
		$password	=	md5(htmlspecialchars($_POST['password'],ENT_QUOTES));
		
		$query	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Username Tidak Terdaftar Pada Sistem');
			redirect('main/login/', 'refresh');
			
		}
		
		$query	= $this->db->get_where('tm_pemohon', array('username' => $username,'password' => $password ,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
			redirect('main/login/', 'refresh');
			
		}
		
		if(count($query)==1){
			
			$newdata	= array(
                   'userlogin'		=> "logged",
                   'username'	=> $username,
                   // 'jenis'     	=> $query->jenis,
                   // 'nama'     		=> $query->nama_pemohon
               );

			$this->session->set_userdata($newdata);
			
			redirect('main/user/', 'refresh');
			
		}
	}

    function logout() {
		
		$this->session->unset_userdata('userlogin');
		$this->session->unset_userdata('username');
		// $this->session->unset_userdata('jenis');
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
		
		$email	= htmlspecialchars($_POST['email'],ENT_QUOTES);
		$query	= $this->db->get_where('tm_pemohon', array('emailPerusahaan' => $email,'status'=>'1'))->first_row();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Mohon Maaf, Email Tidak Terhubung Dengan Akun Manapun');
			redirect('main/login', 'refresh');
			
		}
		
		
		$base_url 				= 'assets/pendaftaran/';
		$host						=	"smtp.gmail.com";
		$emailpengirim		=	"dpmptspjabar@gmail.com";
		$namapengirim		=	"DPMPTSP JABAR";
		$password				=	"~dpmptspjabarprovgoid#";
		$targetpengiriman	=	$query->emailPerusahaan;
		
		require("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
		require("".$base_url."back/plugins/phpmailer/class.smtp.php");
		
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
		
		$isi = "<p>Untuk Mereset password anda, klik link dibawah ini</p>";
		// $isi .= "<p><a href='localhost/webbppt/sicantik/main/login/reset/".$query->uuid_perusahaan."'>Reset Password</a></p>";
		$isi .= "<p><a href='http://bpmpt.jabarprov.go.id/sicantik/main/login/reset/".$query->uuid_perusahaan."'>Reset Password</a></p>";
		$isi .= "<p>Terima kasih atas perhatiannya<br>- DPMPTSP JAWA BARAT</p>";
		
		$mailer->Body = $isi;
		$mailer->AltBody = $isi;
		
		if($mailer->Send()){
			
			$data = array(
			   'reset' => "1"
			);
		
			$this->db->where('emailPerusahaan', $targetpengiriman);
			$this->db->where('status', '1');
			
			$this->db->update('tm_pemohon', $data); 
			
			$this->session->set_flashdata('success', 'Silahkan Cek E-mail Anda Untuk Mereset Password');
			redirect('main/login', 'refresh');
		
		}else{
			
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
		
		$data['title']			= "Reset Password";
		$data['uuid']		= $uuid;
		$data['menu']		= $this->load->view('parsing/menu_right', '', true);
        $data['menu1']	= $this->load->view('parsing/menu_right_2', '', true);
		$data['isi'] 			= "reset";
        $this->load->view('template',$data);
		
    }
	
	function doreset(){
		
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
			die;
		
		}
		
		if(empty($_POST)){
			
			// $uuid	=	htmlspecialchars($_POST['uuid'],ENT_QUOTES);
			
			$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses');
			// redirect("main/login/reset/".$uuid, 'refresh');
			redirect("main/login",'refresh');
		
		}
		
		$uuid 						= htmlspecialchars($_POST['uuid'],ENT_QUOTES);
		$passwordbaru 		= md5(htmlspecialchars($_POST['passwordbaru'],ENT_QUOTES));
		$konfirmpassword 	= md5(htmlspecialchars($_POST['konfirmpassword'],ENT_QUOTES));
		
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
		   'password' 	=> $passwordbaru,
		   'reset' 			=> "0"
		);
	
		$this->db->where('uuid_perusahaan', $uuid);
		$this->db->where('status', '1');
		
		$this->db->update('tm_pemohon', $data); 
		
		$query	= $this->db->get_where('tm_pemohon', array('uuid_perusahaan' => $uuid,'status'=>'1'))->first_row();
		
		$newdata = array(
			   'userlogin' 	=> "logged",
			   'username' 	=> $query->username,
			   // 'jenis'     		=> $query->jenis
		   );

		$this->session->set_userdata($newdata);
		
		redirect("main/user/", 'refresh');
	}
	
}

?>
