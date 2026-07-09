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
class Admin_info_public extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminfopublic =new tminfopublic();

        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login){
            redirect('admin');
        }
       
    }

    function index(){

        
        $data['isi']='isi';
        $data['title']='Mengelola Info Publik';
        $data['judul']='Mengelola Info Publik';
        
        $data['list']=  $this->tminfopublic->order_by("D_BERITA desc")->get();
        $this->load->view('template_admin',$data);
    }
    
    
    function tambah(){
        $data['id']="";
        $data['judul_berita']="";
        $data['deskipsi']="";
        $data['status']=1;
        
        
        $data['isi']='form';
        $data['title']='Tambah Info Publik';
        $data['judul']='Tambah Info Publik';
        $this->load->view('template_admin',$data);        
    }   
    
    
    function edit($id=null){
        $dt =  $this->tminfopublic->where("C_BERITA = '$id'")->get();
        
        $data['id']=$id;
        $data['judul_berita']=$dt->N_JUDUL_BERITA;
        $data['deskipsi']=$dt->N_ISI_BERITA;
        $data['status']=$dt->C_STATUS_BERITA;
        
        
        
        $data['isi']='form';
        $data['title']='Ubah Info Publik';
        $data['judul']='Ubah Info Publik';
        $this->load->view('template_admin',$data);
    }
    
    function save(){
            
            $des=  str_replace("\"../assets/", "\"../../assets/", $this->input->post('deskipsi'));
            
            $data_user = array(
                    'N_JUDUL_BERITA'  =>$this->input->post('judul_berita'),
                    'N_ISI_BERITA'    =>$des,
                    'C_STATUS_BERITA' =>$this->input->post('status'),
                    'D_BERITA'    =>  date('Y-m-d H:i:s')
                    
            );
                        
            
            $id=$this->input->post('id');
            
            if($id=="")
                $this->tminfopublic->insert($data_user);
            else
                $this->tminfopublic->update($id, $data_user);
            // kembalikan ke halaman manajemen user
            redirect('admin_info_public');        
    }    
    
        
    function delete($id){
        $this->tminfopublic->delete($id); 
        redirect('admin_info_public');
    }
   
}

?>
