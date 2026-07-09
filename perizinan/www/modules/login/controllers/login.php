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
class login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->main_model = new tm_pengguna();
    }

    function proses_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $jumlah_dt = $this->main_model->where("username = '$username' and password = '$password'")->count();
        if ($jumlah_dt == 1) {
            $gt_dt = $this->main_model->where("username = '$username' and password = '$password'")->get();
            $data = array(
                'username' => $username,
                'id_pengguna' => $gt_dt->id_pengguna,
                'login' => TRUE
            );
            $this->session->set_userdata($data);
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function proses_logout(){
        $this->session->sess_destroy();
    }

   
}

?>
