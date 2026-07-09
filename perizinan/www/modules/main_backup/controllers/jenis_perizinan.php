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
class Jenis_perizinan extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
    }

    function index() {

		$dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $url = $this->curl->simple_get("$base_url_websevices/api/jenisperizinanlist/index.php");
//$data = $this->curl->simple_get("http://127.0.0.1/alp_backoffice/api/jenisperizinanlist/index.php");

        $news_items = $this->xml_parsing_win->element_set('item', $url);
        foreach ($news_items as $item) {
            $id = $this->xml_parsing_win->value_in('id', $item);
            $jenis = $this->xml_parsing_win->value_in('jenis_perizinan', $item);
            $v_hari = $this->xml_parsing_win->value_in('v_hari', $item);
			$c_aktif = $this->xml_parsing_win->value_in('c_aktif', $item);

            $item_array[] = array(
                'id' => $id,
                'jenis_perizinan' => $jenis,
                'v_hari' => $v_hari,
                'c_aktif' => $c_aktif
            );
        }
        $data['list'] = $item_array;
////$dt=  $this->tmwcm->where("C_ID = 3")->get();
////        $base_url_websevices=$dt->N_ALAMAT_WAP;
////        
////        $xmlfile ="$base_url_websevices/api/jenisperizinanlist";
////        $data_xml = simplexml_load_file($xmlfile);
////        $data['list'] = $data_xml;
//        
        $data['isi'] = 'isi_jenis_perizinan';
        $data['title'] = 'Daftar Jenis Perizinan';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
    }

    function syarat($id = NULL) {
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $url_nama = $this->curl->simple_get("$base_url_websevices/api/jenisnama/id/$id");
        $nama_jenisperizinan = $this->xml_parsing_win->element_set('item', $url_nama);
        foreach ($nama_jenisperizinan as $item) {
            $nama = $this->xml_parsing_win->value_in('naam', $item);
        }

        $data['nama_jenis'] = $nama;

        $url = $this->curl->simple_get("$base_url_websevices/api/syaratPerizinan/perizinan/$id");

        $syaratxml = $this->xml_parsing_win->element_set('item', $url);
        if ($syaratxml == NULL) {
            $array[] = array(
                'id' => '',
                'syarat_perizinan' => 'Belum Tersedia Syarat Perizinan',
				'keterangan' => '',
            );
        } else {
            foreach ($syaratxml as $item) {

                $id = $this->xml_parsing_win->value_in('id', $item);
                $syarat = $this->xml_parsing_win->value_in('syarat_perizinan', $item);

                $array[] = array(
                    'id' => $id,
                    'syarat_perizinan' => $syarat,
					'keterangan' => '',
                );
            }
        }

        $data['list'] = $array;
        $data['isi'] = 'isi_jenis_perizinan_syarat';
        $data['title'] = 'Daftar Jenis Perizinan';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
    }

    function cetak_syarat($id = NULL) {
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $url_nama = $this->curl->simple_get("$base_url_websevices/api/jenisnama/id/$id");
        $nama_jenisperizinan = $this->xml_parsing_win->element_set('item', $url_nama);
        foreach ($nama_jenisperizinan as $item) {
            $nama = $this->xml_parsing_win->value_in('naam', $item);
        }

        $data['nama_jenis'] = $nama;
		$judul = '';
		$judul_kolom = array('No' => 'No', 'Persyaratan' => 'Nama Izin / Persyaratan');
	
        $url = $this->curl->simple_get("$base_url_websevices/api/syaratPerizinan/perizinan/$id");

        $syaratxml = $this->xml_parsing_win->element_set('item', $url);
        if ($syaratxml == NULL) {
            $array[] = array(
                'No' => '',
                'Persyaratan' => 'Belum Tersedia Syarat Perizinan',
				'Keterangan' => ''
            );
        } else {
			$n=1;
            foreach ($syaratxml as $item) {

                $id = $this->xml_parsing_win->value_in('id', $item);
                $syarat = $this->xml_parsing_win->value_in('syarat_perizinan', $item);
                
				if ($n == 1) {
					$array[] = array('No' => 'NO', 'Persyaratan' => 'PERSYARATAN', 'Keterangan' => 'KET',);
				}

                $array[] = array(
                    'No' => $n.".",
                    'Persyaratan' => $syarat,
					'Keterangan' => ""
                );
				$n++;
            }
        }

        $data['list'] = $array;
        $data['isi'] = 'isi_jenis_perizinan_syarat';
        $data['title'] = 'Daftar Jenis Perizinan';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
	
		$this->load->library('cezpdf');
        $this->load->helper('pdf');
        prep_pdf();
		$this->cezpdf->ezText('');
		$this->cezpdf->ezText('PEMERINTAH PROVINSI JAWA BARAT', 12, array('justification'=>'center'));
    	$this->cezpdf->ezText('BADAN PENANAMAN MODAL DAN PERIZINAN TERPADU', 13, array('justification'=>'center'));
		$this->cezpdf->ezText('');
		$this->cezpdf->ezText('DAFTAR PERSYARATAN', 11, array('justification'=>'center'));
		$this->cezpdf->ezText('', 11, array('justification'=>'center'));
		$this->cezpdf->ezText('IZIN / NON IZIN (REKOMENDASI)', 11, array('justification'=>'center'));
		$this->cezpdf->ezText($nama, 11, array('justification'=>'center'));
		$this->cezpdf->ezText('');
        $this->cezpdf->ezTable($data['list'], $judul_kolom, $judul, array('showHeadings'=>0, 'shaded'=>0,'xPos'=>'center',
			   'xOrientation'=>'center','width'=>500, 'showLines'=>2));
		$this->cezpdf->ezStream();
    }
}
?>
