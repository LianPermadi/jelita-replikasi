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
class Admin_home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login){
            redirect('admin');
        }
       
    }

    function index(){

        
        $data['isi']='isi';
        $data['title']='Selamat Datang';
        $data['judul']='Selamat Datang';
        
        
        $this->load->view('template_admin',$data);
    }
    
    
 
   
}

?>
