<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('m_login');
 }

 function index()
 {
   $this->load->helper(array('form'));
   $this->load->view('login');
 }
  function login_form()
 {
   $this->load->helper(array('form'));
 $data['error_login'] = '';
   $this->load->view('v_login', $data);
 }
function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
		//$data['iduser'] = $this->m_login->cek_login("user",$where)->result();

		$data =  $this->m_login->user_login("user",$where);
		foreach ($data as $col) {
			//echo "Nama : ".$col['id']."<br>";
			$id = $col['id'];
			$oriname = $col['oriname'];
			//echo $id;
			
		}

		$cek = $this->m_login->cek_login("user",$where)->num_rows();
		if($cek > 0){
 

			$data_session = array(
				'id' => $id,
				'oriname' => $oriname,
				'nama' => $username,
				'status' => "login"
				);

			$this->session->set_userdata($data_session);

		//	$data['iduser'] = $this->m_login->cek_login("user",$where)->result();
 
			redirect(base_url("admin"));

		}else{
			//echo "Username dan password salah !";
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