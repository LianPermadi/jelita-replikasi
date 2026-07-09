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
class Kontak extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminformasi =new Tminformasi();
    }

    function index() {
        $dt =  $this->tminformasi->where("id_informasi = 2")->get();
        $data['isi'] = 'isi_kontak';
        $data['title']=$dt->judul_informasi;
        $data['isi_informasi']=$dt->isi_informasi;
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true); 
        $this->load->view('template', $data);
    }

    
}

?>
