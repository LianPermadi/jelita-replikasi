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
class Download extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmdownload=new Tmdownload();
                
    }

    function index() {
        $data['isi'] = 'isi_download';
        $data['title'] = 'Daftar File Download ';
        
        
        $data['download'] = $this->tmdownload->where("C_STATUS_LINK = 1")->get();
        
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true);
        
        $this->load->view('template', $data);
    }

    
}

?>
