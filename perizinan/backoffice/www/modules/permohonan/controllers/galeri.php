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
class Galeri extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmgaleri=new Tmgaleri();
    }
    function index()
    {
        $this->galerilist();
    }

    function galerilist() 
    {
        $this->load->library('pagination');
        $data['isi'] = 'isi_galeri';
        $data['title'] = 'Daftar Galeri ';
        
        $config['base_url'] = base_url().'main/galeri/galerilist';
        $config['total_rows'] = $this->tmgaleri->where("C_STATUS_LINK = 1")->count();
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<p class="paging">';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);

        $data['link_pagging']= $this->pagination->create_links();


        $hal=$this->uri->segment(4,0);
        $data['data_galeri'] = $this->tmgaleri->where("C_STATUS_LINK = 1")->limit(6, $hal)->get();
        
        
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true);
        
        $this->load->view('template', $data);
    }

    
}

?>
