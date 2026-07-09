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
class Cek_kend extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
    }

    function index() {

        $data['isi'] = 'isi_kend';
        $this->load->view('template', $data);
    }

    function get() {
        $id = str_replace(" ","_", $this->input->post('id_cak'));

        //start Web Service Dishub
        $nokenddishub = preg_replace('/\s/i', '%20', $this->input->post('id_cak'));

        $url = 'http://as.jasaraharja.co.id/dasi_ws/SP_WServices.ashx?cat=DISHUB_SW&ApiKey=02145dKrW&params='.$nokenddishub.'|DIS03';

        $get = file_get_contents($url);

        $json_array = array();
        if ($get) {
            $json = json_decode($get);
        }
        //var_dump($json);
        if (!empty($json)) {
            foreach ($json->DISHUB_SW as $val) {
                if (!isset($val->STATUS)) {
                    $json_array[] = array(
                        'tgl_transaksi' => $val->TGL_TRANSAKSI,
                        'tgl_mati_yad' => $val->TGL_MATI_YAD,
                        'no_rangka' => $val->NO_RANGKA,
                        'no_mesin' => $val->NO_MESIN);
                    }
                }
        }
        

        //end Web Service Dishub

        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $alamat = $base_url_websevices."/api/kendaraan/nomor/".$id;

        //var_dump($alamat);die();

        $url = $this->curl->simple_get($alamat);
        $news_items = $this->xml_parsing_win->element_set('item', $url);
        //var_dump($news_items);die;

        if ($news_items === false) {
            $item_array = array();
        } else {
            foreach ($news_items as $item) {
                $item_array[] = array(
                    'no_kend' => $this->xml_parsing_win->value_in('no_kend', $item),
                    'no_uji' => $this->xml_parsing_win->value_in('no_uji', $item),
                    'nama_pemilik' => $this->xml_parsing_win->value_in('nama_pemilik', $item),
                    'nama_perusahaan' => $this->xml_parsing_win->value_in('nama_perusahaan', $item),
                    'tahun_pembuatan' => $this->xml_parsing_win->value_in('tahun_pembuatan', $item),
                    'merk' => $this->xml_parsing_win->value_in('merk', $item),
                    'jenis_kendaraan' => $this->xml_parsing_win->value_in('jenis_kendaraan', $item),
                    'no_sk' => $this->xml_parsing_win->value_in('no_sk', $item),
                    'no_kp' => $this->xml_parsing_win->value_in('no_kp', $item),
                    'tgl_penetapan_sk' => $this->xml_parsing_win->value_in('tgl_penetapan_sk', $item),
                    'tgl_penetapan_kp' => $this->xml_parsing_win->value_in('tgl_penetapan_kp', $item),
                    'tgl_sk' => $this->xml_parsing_win->value_in('tgl_sk', $item),
                    'tgl_kp' => $this->xml_parsing_win->value_in('tgl_kp', $item),
                    'masa_berlaku_sk' => $this->xml_parsing_win->value_in('masa_berlaku_sk', $item),
                    'masa_berlaku_kp' => $this->xml_parsing_win->value_in('masa_berlaku_kp', $item)
                );
            }
        }

        $data['list'] = $item_array;
        $data['listdishub'] = $json_array; //Kirim hasil Web Service Dishub ke view

        $data['isi'] = 'cek_kend';

        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $this->load->view('template', $data);

    //die;
    }

}

?>
