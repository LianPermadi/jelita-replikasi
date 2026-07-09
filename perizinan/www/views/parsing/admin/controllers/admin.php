<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Anto
 */
class Admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->main_model =new tmuser();
    }

    function index(){
        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
         if ($login){
            redirect('admin_home');
        }
        
        $data['isi']='form';
        $data['title']='Login';
        $data['judul']='Login';
        $data['error']="";
        
        $this->load->view('template_admin',$data);
    }

    function proses_login(){
        $data['isi']='form';
        $data['title']='Login';
        $data['judul']='Login';
        
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $jumlah_dt = $this->main_model->where("c_user = '$username' and c_password = '$password'")->count();
        if ($jumlah_dt == 1) {
            $gt_dt = $this->main_model->where("c_user = '$username' and c_password = '$password'")->get();
            $data = array(
                'n_otoritas' => $gt_dt->n_otoritas,
                'c_user' => $gt_dt->c_user,
                'id'=>$gt_dt->id,
                'login' => TRUE
            );
            $this->session->set_userdata($data);
            redirect('admin_home');
        } else {
            $data['error']="User Login dan Password Salah, silahkan dicoba lagi";
           $this->load->view('template_admin',$data);
        }
    }


    function logout(){
          $data = array(
                'n_otoritas' => '',
                'c_user' => '',
                'login' => FALSE
            );
        $this->session->unset_userdata($data);
         redirect('admin');
    }
    
   
}

?>
