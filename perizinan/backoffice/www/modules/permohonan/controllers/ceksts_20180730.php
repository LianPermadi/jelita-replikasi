<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* Description of welcome @author PBS 2017 */
class ceksts extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
    }

    function index($varOK=NULL) {
        $id = substr($varOK,3,19);
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;
        $url = $this->curl->simple_get("$base_url_websevices/api/permohonan/pendaftaran/$id");
        $news_items = $this->xml_parsing_win->element_set('item', $url);
        if ($news_items == NULL) {
            $item_array = array();
        } else {
            foreach ($news_items as $item) {
                $id = $this->xml_parsing_win->value_in('id', $item);
                $no_pendaftaran = $this->xml_parsing_win->value_in('no_pendaftaran', $item);
				$sts_berkas = $this->xml_parsing_win->value_in('sts_berkas', $item);
                $nama = $this->xml_parsing_win->value_in('nama', $item);
                $tlp = $this->xml_parsing_win->value_in('tlp', $item);
                $alamat = $this->xml_parsing_win->value_in('alamat', $item);
                $permohonan = $this->xml_parsing_win->value_in('permohonan', $item);
                $tracking = $this->xml_parsing_win->value_in('tracking', $item);
                $n_kelompok_izin = $this->xml_parsing_win->value_in('n_kelompok_izin', $item);
				$kd_status = $this->xml_parsing_win->value_in('kd_status', $item);
				$no_surat = $this->xml_parsing_win->value_in('no_surat', $item);
				$approve = $this->xml_parsing_win->value_in('approve', $item);

                $item_array[] = array(
                    'id' => $id,
                    'no_pendaftaran' => $no_pendaftaran,
					'sts_berkas' => $sts_berkas,
                    'nama' => $nama,
                    'tlp' => $tlp,
                    'alamat' => $alamat,
                    'permohonan' => $permohonan,
					'n_kelompok_izin' => $n_kelompok_izin,
                    'tracking' => $tracking,
					'kd_status' => $kd_status,
					'no_surat' => $no_surat,
					'approve' => $approve
                );
            }
        }
        $item_array[] = array(
                    'id' => '',
                    'no_pendaftaran' => '',
			        'sts_berkas' => '',
                    'nama' => '',
                    'tlp' => '',
                    'alamat' => '',
                    'permohonan' => '',
			        'n_kelompok_izin' => '',
                    'tracking' => 'PROSES PERMOHONAN :',
			        'kd_status' => '',
					'no_surat' => '',
					'approve' => ''
        );
        $data['list'] = $item_array;
        $data['isi'] = 'cek_nomer';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
	}
}
?>