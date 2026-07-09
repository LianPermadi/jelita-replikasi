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
class Admin_profil extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        $this->tmuser=new tmuser();
        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login) {
            redirect('admin');
        }
        if ($peran != 'Operator'){
            redirect('admin');
        }
        $this->load->library('session');
    }

    function index(){
        
        $login= $this->session->userdata('c_user');
        
        $dt = $this->tmuser->where("c_user = '$login'")->get();        
        
        
        $data['alert']="";
        $data['c_user']=$dt->c_user;
        $data['c_password']=$dt->c_password;
        $data['email']=$dt->email;
        
        $data['isi']='form';
        $data['title']='Ganti Password';
        $data['judul']='Ganti Password';
        
        $this->load->view('template_admin',$data);  
    }
    
    function update(){
        $id= $this->session->userdata('id');
        $passwL = md5($this->input->post('passwordL'));
        $this->db->where('c_password',$passwL);
        $hasil = $this->db->get('truser')->row();
        if (empty($hasil->c_password))
        {
            $this->session->set_flashdata('konf','<p style="color:red; font-weight:bold;">Data Password lama anda salah</p>');
            redirect('admin_profil'); 
        }else
        {   
        
            $data_user = array(
                    'c_password'  =>  md5($this->input->post('password'))
                    //'email'    =>$this->input->post('email')
            );
            
            $this->tmuser->update($data_user, $id); 
            $this->session->set_flashdata('konf','<p style="color:green; font-weight:bold;">Data Password berhasil diganti</p>');   
            redirect('admin_profil'); 
        }
    }
    

    
   
    

    
    

   
}

?>
