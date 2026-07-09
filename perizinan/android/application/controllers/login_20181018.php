<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->model('m_login');
  }
  
  function index(){
    $this->load->helper(array('form'));
    $this->load->view('login');
  }
  
  function login_form(){
    $this->load->helper(array('form'));
    $data['error_login'] = '';
    $this->load->view('v_login', $data);
  }
  
  function aksi_login(){
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $otherdb = $this->load->database('otherdb',TRUE);
		$user = $otherdb->get_where("user",array("username"=>$username))->first_row();
		if(count($user) == 0){
			$data['error_login'] = 'Username salah !!!!';
   	  $this->load->view('v_login', $data);
	  }else{
      if(password_verify($password, $user->password)) {
        $data_session = array('id' => $user->id,
 			                        'oriname' => $user->oriname,
 			                        'nama' => $username,
 			                        'status' => "login"
                             );
  
 	      $this->session->set_userdata($data_session);
        redirect(base_url("admin"));
      }else{
   	    $data['error_login'] = 'Password salah !!!!';
   	    $this->load->view('v_login', $data);
	    }
    }
  }

  function aksi_loginOLD(){
    $username = $this->input->post('username');
    $password = $this->input->post('password');
	  $where = array('username' => $username,
	 		             'password' => md5($password)
	 	            	);
  
	  $data = $this->m_login->user_login("user",$where);
	  foreach ($data as $col) {
	 	  $id = $col['id'];
	 	  $oriname = $col['oriname'];
    }
  
    $cek = $this->m_login->cek_login("user",$where)->num_rows();
    if($cek > 0){
      $data_session = array('id' => $id,
	 			                    'oriname' => $oriname,
	 			                    'nama' => $username,
	 			                    'status' => "login"
                           );
  
	 	  $this->session->set_userdata($data_session);
      redirect(base_url("admin"));
    }else{
	 	  $data['error_login'] = 'Username atau Password salah !!!!';
      $this->load->view('v_login', $data);
	  }
  }
    
	function logout(){
	 	$this->session->sess_destroy();
	 	redirect(base_url('login'));
	}
}

?>