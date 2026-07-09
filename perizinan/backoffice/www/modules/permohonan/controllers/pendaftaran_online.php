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
class Pendaftaran_online extends MY_Controller {

    function __construct() {
        parent::__construct();
       
        
//        $this->tr_propinsi = new trpropinsi();
//        $this->tr_kabupaten = new trkabupaten();
//        $this->tr_keluarahan = new trkelurahan();
//        $this->tr_kecamatan = new trkecamatan();
        
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');

         $detect = $this->load->library('Mobile_Detect');
        if ($detect->isMobile()) {
            $link = "http" .((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
            $server = isset($_SERVER['HTTP_HOST']) ?$_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

             //cara ke 2

            $base_url = base_url();
            $xx = explode('/', $base_url);
            $x = 0;
            $jumlah_url_1 = count($xx) - 1;
            $jumlah_url = count($xx);
            $url_mobile = NULL;
            foreach ($xx as $apl_mobile_url) {
                $x++;

                if ($jumlah_url_1 == $x) {
                    
                } elseif ($jumlah_url == $x) {
                    
                } else {
                    if ($x == 1) {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '//';
                    } elseif ($x == 2) {
                        
                    } else {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '/';
                    }
                }
            }

            redirect($url_mobile."alp_mobile");
            
            //redirect($link . $server . "/alp_mobile");
            //redirect($link.$server."/alp_mobile");
        }
    }

   

    //get_capcha================================================================================

    function get_capcha() {
        $capcha = $this->captcha();
        $data['img'] = $capcha['img'];
        $data['word'] = $capcha['word'];
        $this->load->view('isi_capcha', $data);
    }

    function captcha() {
        $this->load->plugin('captcha');
        $str = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
        $random_word = str_shuffle($str);
        $random_word = substr($random_word, 0, 5);
        $vals = array(
            'word' => $random_word,
            'img_path' => 'captcha/',
            'img_url' => base_url() . '/captcha/',
            'img_width' => '200',
            'img_height' => 50,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);


        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
//        $query = $this->db->insert_string('captcha', $data);
//        $this->db->query($query);


        $cap_conf = array(
            'img' => $cap['image'],
            'word' => $cap['word']
        );
        return $cap_conf;
    }

}

?>
