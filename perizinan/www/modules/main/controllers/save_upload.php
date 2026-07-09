<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of save_upload
 *
 * @author Obi
 */
class save_upload extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->upload_path = realpath(APPPATH . '../uploads');
    }

    function upload() {
//     echo $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
        $this->load->helper('uploadify');
        img_uploadify();
        

//        $config = array(
//            'source_image' => $img_data['full_path'],
//            'new_image' => $this->upload_path . '/thumbs',
//            'maintain_ration' => true,
//            'width' => 150,
//            'height' => 100
//        );
//
//        $this->load->library('image_lib', $config);
    //    $this->image_lib->resize();
       
    }

}

?>
