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
class Admin_config extends MY_Controller {

    function __construct() {
        parent::__construct();
        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login){
            redirect('admin');
        }
        
        $this->tmHeader=new TmHeader();
        
        $this->tmlink=new Tmlink();
       
        $this->tmbg= new Tmbg();
    }

    function index(){
        
        $data['isi']='header';
        $data['title']='Pengaturan Header Website';
        $data['judul']='Pengaturan Header Website';
        
        $data['list'] = $this->tmHeader->get();
        
        
        $this->load->view('template_admin',$data);
    }
    
    function template_css(){
	    $data['isi']='template_css';
        $data['title']='Pengaturan Template Website';
        $data['judul']='Pengaturan Template Website';
        
        $data['list'] = $this->tmbg->get();
        
        $this->load->view('template_admin',$data);
    }
    
    function link_service(){
        
        $data['isi']='link_service';
        $data['title']='Pengaturan Alamat Link Service';
        $data['judul']='Pengaturan Alamat Link Service';
        
        $data['link'] = $this->tmlink->where("C_ID = 3")->get();
        
        $this->load->view('template_admin',$data);
    }    
    
    
    function save_header(){
        $uploads = $_FILES['xfile']['name'];
        if (!empty($uploads)) {
            $config['overwrite'] = false;
            $config['upload_path'] = './uploads/header_file/';
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field = 'xfile';
            if (!$this->upload->do_upload($field)) {
//                $x = array('<p>', '</p>');
//                $error = str_replace($x, '', $this->upload->display_errors());
//                $data['error'] = $error;
//                $this->load->view('template_admin', $data);
            } else {
                $uploaded = $this->upload->data();
                $file = $uploaded['file_name'];

                $data_user = array(
                    'n_image' => $file,
                    'n_judul'=> $this->input->post('nama_header'),
                    'c_status'=>0
                );
                $this->tmHeader->insert($data_user);
                redirect('admin_config');
            }
        } else {
            $data['error'] = "File Galeri Belum Terpilih";
            $this->load->view('header', $data);
        }
    }
    
    
     function delete($id) {
        $this->tmHeader->delete($id);
        redirect('admin_config');
    }
    
    function update($id) {
        
        $data = array(
            'c_status'=>0
        );        
        $this->tmHeader->update_all($data);
        
        $data = array(
            'c_status'=>1
        );
        $this->tmHeader->update($id, $data);
        redirect('admin_config');
    }    
    
    function update_css($id) {
        
        $data = array(
            'link_status'=>0
        );        
        $this->tmbg->update_all($data);
        
        $data = array(
            'link_status'=>1
        );
        $this->tmbg->update($id, $data);
        redirect('admin_config/template_css');
    }
    
    function update_link() {
        
        $data = array(
            'N_ALAMAT_WAP'=>$this->input->post('link'),
        );        
 

        $this->tmlink->update('3', $data);
        redirect('admin_config/link_service');
    }   
   
}

?>
