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
class Pendaftaranbaru extends MY_Controller {

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
		
		// $hostip = $_SERVER['10.18.1.10'];
		// $hostname = gethostbyaddr("10.18.1.10");
		
		// echo $hostname;
		
		// die;
		
		// $a = exec("e:\iqbal\TEMP\gammu\bin\gammu-smsd-inject.exe -c e:\iqbal\TEMP\gammu\bin\smsdrc TEXT 08999476257 -text 'nomor token anda adalah : ' ");
		// $a = exec("/usr/bin/gammu-smsd-inject -c /etc/gammu-smsdrc TEXT 085624884792 -text 'test' ");
		// echo $a;
		// die;
		
		$session = $this->session->userdata("userlogin");
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
		
		}
		
		$provinsi		= $otherdb->query('select * from trpropinsi order by n_propinsi')->result();
		$kabupaten	= $otherdb->query("select * from trkabupaten where kd_prov='12' order by n_kabupaten")->result();
		
		$data['menu']			= $this->load->view('parsing/menu_right', '', true);
        $data['menu1']		= $this->load->view('parsing/menu_right_2', '', true);
		$data['isi']				= "pendaftaranbaru";
		$data['provinsi']		= $provinsi;
		$data['kabupaten']	= $kabupaten;
        $this->load->view('template',$data);
    }
	
	function getkabupaten(){
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$data = $_POST['data'];
		
		// alert($data);
		
		$str = '|------------------------ Pilih Kabupaten ------------------------,';
		$rowsData = $otherdb->query("select * from trkabupaten where kd_prov='".$data."' order by n_kabupaten")->result();

		
		foreach($rowsData as $row)
		{
			$kab = $row->n_kabupaten;
			$str = $str . "$row->kd_kab|$kab".",";
		}
		
		
		$str = substr($str,0,(strLen($str)-1)); 
		
		echo json_encode($str);
		
	}
	
	function getkecamatan(){
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$data = $_POST['data'];
		
		// alert($data);
		
		$str = '';
		$rowsData = $otherdb->query("select * from trkecamatan where kd_kab='".$data."' order by n_kecamatan")->result();

		$str = '|------------------------ Pilih Kecamatan ------------------------,';
		foreach($rowsData as $row)
		{
			$kab = $row->n_kecamatan;
			$str = $str . "$row->kd_kec|$kab".",";
		}
		
		
		$str = substr($str,0,(strLen($str)-1)); 
		
		echo json_encode($str);
		
	}
	
	function getkelurahan(){
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$data = $_POST['data'];
		
		// alert($data);
		
		$str = '';
		$rowsData = $otherdb->query("select * from trkelurahan where kd_kel  IN (SELECT trkelurahan_id FROM trkecamatan_trkelurahan WHERE trkecamatan_id ='".$data."') order by n_kelurahan")->result();
		
		$str = '|------------------------ Pilih Kelurahan ------------------------,';
		
		foreach($rowsData as $row)
		{
			$kab = $row->n_kelurahan;
			$str = $str . "$row->kd_kel|$kab".",";
		}
		
		
		$str = substr($str,0,(strLen($str)-1)); 
		
		echo json_encode($str);
		
	}
	
	function dopendaftaran(){
	
		$session = $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
			die;
		
		}
		
		// $jenis = htmlspecialchars($_POST['jenis'],ENT_QUOTES);
		
		// if(!empty($jenis)){
			
			
			///////////////////// CEK EMAIL & HP EKSISTING
			
			$email					= htmlspecialchars($_POST['email_pemohon'],ENT_QUOTES);
			$telp_pemohon	= htmlspecialchars($_POST['telp_pemohon'],ENT_QUOTES);
			
			$query	= $this->db->get_where('tm_pemohon', array('emailPerusahaan' => $email))->first_row();
			
			if(count($query)>0){
				
				$this->session->set_flashdata('error', "Mohon Maaf, Email Sudah Terdaftar atas nama <i>".$query->namaPerusahaan."</i>");
				redirect('main/pendaftaranbaru', 'refresh');
				die;
			
			}
			
			$query	= $this->db->get_where('tm_pemohon', array('telpPerusahaan' => $telp_pemohon))->first_row();
			
			if(count($query)>0){
				
				$this->session->set_flashdata('error', "Mohon Maaf, Nomor Telpon Sudah Terdaftar atas nama <i>".$query->namaPerusahaan."</i>");
				redirect('main/pendaftaranbaru', 'refresh');
				die;
			
			}
			
			///////////////////// END CEK EMAIL & HP EXISTING
			
			
			
			///////////////////// GENERATE TOKEN
			
			$no 		= 1;
			$token	= "";
			
			while($no<=3){
			
				$token	.= substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
				
				if($no<3){ 
					
					$token	.= "-"; 
				
				}
				
				$no++;
			
			}
			
			///////////////////// END GENERATE TOKEN
			
			
			// if($jenis=="perorangan"){
				
				// $nama		= htmlspecialchars($_POST['nama'],ENT_QUOTES);
				// $hp			= htmlspecialchars($_POST['hp'],ENT_QUOTES);
				// $email		= htmlspecialchars($_POST['email'],ENT_QUOTES);
				// $alamat	= nl2br(htmlspecialchars($_POST['alamat'],ENT_QUOTES));
				
				// $data = array(
				   // 'nama_pemohon' 		=> $nama ,
				   // 'telp_pemohon' 		=> $hp ,
				   // 'email_pemohon' 		=> $email,
				   // 'alamat_pemohon' 	=> $alamat,
				   // 'token' 						=> $token,
				   // 'jenis' 						=> "perorangan"
				// );
				
				
			// }else if($jenis="perusahaan"){
				
				$nama_pemohon					= htmlspecialchars($_POST['nama_pemohon'],ENT_QUOTES);
				$nama_pemegang_kuasa		= htmlspecialchars($_POST['nama_pemegang_kuasa'],ENT_QUOTES);
				$telp_pemegang_kuasa			= htmlspecialchars($_POST['telp_pemegang_kuasa'],ENT_QUOTES);
				$email_pemohon						= htmlspecialchars($_POST['email_pemohon'],ENT_QUOTES);
				$alamat_pemohon					= nl2br(htmlspecialchars($_POST['alamat_pemohon'],ENT_QUOTES));
				$provinsi									=	htmlspecialchars($_POST['provinsi'],ENT_QUOTES);
				$kabupaten								=	htmlspecialchars($_POST['kabupaten'],ENT_QUOTES);
				$kecamatan								=	htmlspecialchars($_POST['kecamatan'],ENT_QUOTES);
				$kelurahan								=	htmlspecialchars($_POST['kelurahan'],ENT_QUOTES);
				$jenis										=	htmlspecialchars($_POST['jenis'],ENT_QUOTES);
				
				if($jenis=="pemohon"){
					
					$penanggung_jawab = $nama_pemohon;
					
				}else if($jenis=="perusahaan"){
					
					$penanggung_jawab	=	htmlspecialchars($_POST['nama_direktur'],ENT_QUOTES);
					
				}
				else{
					$this->session->set_flashdata('error', "Mohon Maaf, Terjadi kesalahan, mohon mengulangi proses pendaftaran");
					redirect('main/pendaftaranbaru', 'refresh');
					die;
					
				}
				
				$data = array(
				   'namaPerusahaan' 				=> $nama_pemohon ,
				   'namaPemohon'					=> $nama_pemegang_kuasa ,
				   'telpPerusahaan' 					=> $telp_pemohon ,
				   'telpPemohon'						=> $telp_pemegang_kuasa ,
				   'emailPerusahaan'				=> $email_pemohon,
				   'almtPerusahaan' 					=> $alamat_pemohon,
				   'token' 									=> $token,
				   'propinsi2' 							=> $provinsi,
				   'kabupaten2' 						=> $kabupaten,
				   'kecamatan2'						=> $kecamatan,
				   'kelurahan2' 							=> $kelurahan,
				   'tgl_daftar' 							=> date("Y-m-d"),
				   'jenis' 									=> $jenis,
				   'nama_penanggung_jawab'	=> $penanggung_jawab
				);
				
			// }else{
				
				// $this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses Pendaftaran');
				// redirect('main/pendaftaranbaru', 'refresh');
				// die;
			
			// }
			
			
			// $hostname='adminbppt-MS-7529.local';
			// $hostname='10.18.1.10:3306';
			// $username='fromsicantik';
			// $password='adminbppt2012';
			// $dbname='smsd';

			// mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
			// mysql_select_db($dbname);

			// $query = 'SELECT * FROM outbox';
			// $result = mysql_query($query);
			// if($result) {
				// print_r($result);
			// }
			// else {
			// print "Database NOT Found ";
			// mysql_close($db_handle);
			// }
			
			// die;
			
			// $gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
			
			// $data = array(
			   // 'DestinationNumber'	=> $telp_pemohon,
			   // 'TextDecoded'		=> "Nomor token pendaftaran Anda adalah :\n".$token,
			   // 'CreatorID' 			=> "Gammu",
			// );
			
			// $gammu->insert('outbox',$data);
			// die;
			if($this->db->insert('tm_pemohon', $data)){
				
				$base_url 				= 'assets/pendaftaran/';
				$host						=	"smtp.gmail.com";
				$emailpengirim		=	"bpmptjabar@gmail.com";
				$namapengirim		=	"BPMPT JABAR";
				$password				=	"bpmptjabarprovgoid";
				$targetpengiriman	=	$email;
				
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

				$mailer->Subject = 'Token Pendaftaran Akun BPMPT Jawa Barat';
				
				$isi = "<p>Terimakasih atas pendaftaran anda, berikut ini adalah nomor token anda : </p>";
				$isi .= "<p>".$token."</p>";
				$isi .= "<p>Silahkan Masukkan Nomor Token Anda Pada Halaman Berikut : <a href='http://10.18.1.2/webbppt/sicantik/main/pendaftaranbaru/konfirm'>Verifikasi Permohonan Proposal</a></p>";
				$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT JAWA BARAT</p>";
				
				$mailer->Body = $isi;
				$mailer->AltBody = $isi;
				
				if($mailer->Send()){
					
					// $a = exec("/usr/bin/gammu-smsd-inject -c /etc/gammu-smsdrc TEXT 085624884792 -text 'test' ");
					// echo $a;
					
					$gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
					
					$data = array(
					   'DestinationNumber'	=> $telp_pemohon,
					   'TextDecoded'		=> "Nomor token pendaftaran Anda adalah :\n".$token,
					   // 'CreatorID' 			=> "Gammu",
					);
					
					$gammu->insert('outbox',$data);
					
					if(!empty($_POST['telp_pemegang_kuasa'])){
					$data = array(
					   'DestinationNumber'	=> $telp_pemegang_kuasa,
					   'TextDecoded'		=> "Nomor token pendaftaran Anda adalah :\n".$token,
					   // 'CreatorID' 			=> "Gammu",
					);
					
					$gammu->insert('outbox',$data);
					}
					// $query = "INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID)VALUES ('$tujuan', '$message', 'Gammu')";
					// $hasil = mysql_query($query);
					// if ($hasil) echo "SMS berhasil dikirim";
					// else echo "SMS gagal dikirim";
					
					redirect('main/pendaftaranbaru/konfirm', 'refresh');
					
				}else{
					
					$this->db->where('emailPerusahaan', $email);
					$this->db->delete('tm_pemohon'); 
					
					$this->session->set_flashdata('error', 'Mohon Maaf, Koneksi Tidak Stabil, Harap Mengulangi Proses Pendaftaran');
					redirect('main/pendaftaranbaru', 'refresh');
					die;
				
				}
			}else{
				
				$this->session->set_flashdata('error', 'Mohon Maaf, Terjadi Kesalahan, Mohon Ulangi Proses Pendaftaran');
				redirect('main/pendaftaranbaru', 'refresh');
				die;
				
			}
		// }
	}
	
	function konfirm(){
	
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
		
		}
		
		$data['menu']		= $this->load->view('parsing/menu_right', '', true);
        $data['menu1']	= $this->load->view('parsing/menu_right_2', '', true);
		$data['isi']			= "konfirmpendaftaran";
        $this->load->view('template',$data);
	
	}
	
	function dokonfirm(){
		
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
		
		}
		
		if(empty($_POST['token'])){
			
			redirect('main/pendaftaranbaru/konfirm', 'refresh');
		
		}
		
		$token = htmlspecialchars($_POST['token'],ENT_QUOTES);
		$query	= $this->db->get_where('tm_pemohon', array('token' => $token,'status'=>'0'))->first_row();
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Mohon Maaf, Nomor Token Tidak Terhubung Dengan Akun Manapun');
			redirect('main/pendaftaranbaru/konfirm', 'refresh');
		
		}else if(count($query)==1){
			
			
			$telp_pemohon = $query->telpPerusahaan;
			$telp_pemegang_kuasa = $query->telpPemohon;
			
			$string		= $query->namaPerusahaan;
			$search	= array('CV.', 'PT.','CV','PT');
			$replace	= "";
			$string 	= str_replace($search, $replace, $string);
			$string 	= str_replace(' ', '', $string); // Replaces all spaces with hyphens.
			$string 	= preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
			$string 	= strtolower(preg_replace('/-+/', '', $string));
			
			$query		= $this->db->get_where('tm_pemohon', array('username' => $string))->result();
			
			function cekusername($string){
			
				$token		= substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 3);
				$uname	= $string."".$token;
				
				return $uname;
			
			}

			if(count($query)>0){
			
				$string	= cekusername($string);
			
			}
			
			$passworduser		= substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 6);
			$query						= $this->db->get_where('tm_pemohon', array('token' => $token,'status'=>'0'))->first_row();
			$base_url 				= 'assets/pendaftaran/';
			$host						=	"smtp.gmail.com";
			$emailpengirim		=	"bpmptjabar@gmail.com";
			$namapengirim		=	"BPMPT JABAR";
			$password				=	"bpmptjabarprovgoid";
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

			$mailer->Subject = 'Pendaftaran Akun BPMPT Jawa Barat';
			
			$isi = "<p>Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda : </p>";
			$isi = "<p><table><tr><td>Username</td><td>: ".$string."</td></tr><tr><td>Password</td><td>: ".$passworduser."</td></tr></table></p>";
			$isi .= "<p>Silahkan Login Untuk Melengkapi Data anda, <a href='http://10.18.1.2/webbppt/sicantik/main/login'>Login Disini</a></p>";
			$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT JAWA BARAT</p>";
			
			$mailer->Body = $isi;
			$mailer->AltBody = $isi;
			
			if($mailer->Send()){
				
				$gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
				$data = array(
				   'DestinationNumber'	=> $telp_pemohon,
				   'TextDecoded'		=> "Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda: \n Username : ".$string." \n Password : ".$passworduser."",
				   // 'CreatorID' 			=> "Gammu",
				);
				
				$gammu->insert('outbox',$data);
				
				if($telp_pemegang_kuasa!=""){
					$data = array(
					   'DestinationNumber'	=> $telp_pemegang_kuasa,
					   'TextDecoded'		=> "Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda: \n Username : ".$string." \n Password : ".$passworduser."",
					   // 'CreatorID' 			=> "Gammu",
					);
				}
				
				$gammu->insert('outbox',$data);
				
				$data = array(
				   'username'	=> $string,
				   'password'	=> md5($passworduser),
				   'status'			=> "1"
				);
				

				/////////////////// CREATE DIREKTORI
				
				$path 								= "assets/userassets/pemohon/".$string."";
				$dokumen 						= "assets/userassets/pemohon/".$string."/dokumen";
				$dokumen_pengajuan 	= "assets/userassets/pemohon/".$string."/dokumen_pengajuan";
				$pengajuan 					= "assets/userassets/pemohon/".$string."/pengajuan";

				if(!is_dir($path)) //create the folder if it's not already exists
				{
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
	
	function suksestoken(){
	
		$session	= $this->session->userdata("userlogin");
		
		if(!empty($session)){
			
			redirect('main/user', 'refresh');
		
		}
		
		$data['menu']		= $this->load->view('parsing/menu_right', '', true);
        $data['menu1']	= $this->load->view('parsing/menu_right_2', '', true);
		$data['isi']			= "suksestoken";
        $this->load->view('template',$data);
	}
}

?>
