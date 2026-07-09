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

        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $url = $this->curl->simple_get("$base_url_websevices/api/kendaraan/nomor/$id");
        $news_items = $this->xml_parsing_win->element_set('item', $url);

        if ($news_items === false) {
            $item_array = array();
        } else {
            foreach ($news_items as $item) {
                // $no_kend = $this->xml_parsing_win->value_in('no_kend', $item);
                // $no_uji = $this->xml_parsing_win->value_in('no_uji', $item);
                // $nama_pemilik = $this->xml_parsing_win->value_in('nama_pemilik', $item);
                // $nama_perusahaan = $this->xml_parsing_win->value_in('nama_perusahaan', $item);
                // $no_sk = $this->xml_parsing_win->value_in('no_sk', $item);
                // $no_kp = $this->xml_parsing_win->value_in('no_kp', $item);
                // $tgl_penetapan_sk = $this->xml_parsing_win->value_in('tgl_penetapan_sk', $item);
                // $tgl_penetapan_kp = $this->xml_parsing_win->value_in('tgl_penetapan_kp', $item);
                // $tgl_sk = $this->xml_parsing_win->value_in('tgl_sk', $item);
                // $tgl_kp = $this->xml_parsing_win->value_in('tgl_kp', $item);
                // $masa_berlaku_sk = $this->xml_parsing_win->value_in('masa_berlaku_sk', $item);
                // $masa_berlaku_kp = $this->xml_parsing_win->value_in('masa_berlaku_kp', $item);

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

        $data['isi'] = 'cek_kend';

        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $this->load->view('template', $data);

    //die;
    }

}

?>
