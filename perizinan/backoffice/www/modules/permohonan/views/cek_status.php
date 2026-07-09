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
class Cek_status extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
    }

    function index() {
        
    }

    function get($id = NULL) {
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        $url = $this->curl->simple_get("$base_url_websevices/api/permohonan/pendaftaran/$id");

        $news_items = $this->xml_parsing_win->element_set('item', $url);
        if ($news_items == NULL) {
            echo "<h3 align=center style='font-size:12px;'><p>Data Hasil Pencarian</p></h3> <hr/>";
            echo "           <div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>
               Nomer pendaftaran yang anda masukan tidak diketahui,,,
           </div>";
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

                $item_array[] = array(
                    'id' => $id,
                    'no_pendaftaran' => $no_pendaftaran,
                    'sts_berkas' => $sts_berkas,
                    'nama' => $nama,
                    'tlp' => $tlp,
                    'alamat' => $alamat,
                    'permohonan' => $permohonan,
                    'n_kelompok_izin' => $n_kelompok_izin,
                    'tracking' => $tracking
                );
            }
		}
            //$xmlfile = "$base_url_websevices/api/permohonan/pendaftaran/$id";
            //$data_xml = simplexml_load_file($xmlfile);
//      Create Budi
        $item_array[] = array(
                    'id' => '',
                    'no_pendaftaran' => '1',
			        'sts_berkas' => '',
                    'nama' => '',
                    'tlp' => '',
                    'alamat' => '',
                    'permohonan' => '',
			        'n_kelompok_izin' => '',
                    'tracking' => 'PROSES PERMOHONAN :',
        );

        $url = $this->curl->simple_get("$base_url_websevices/api/stspermohonanlist/index.php");
        $news_items = $this->xml_parsing_win->element_set('item', $url);
        foreach ($news_items as $item) {
                $status = $this->xml_parsing_win->value_in('jenis_status', $item);
                if ($status != 'Izin Disetujui' && $status != 'Izin Ditolak' && $status != 'Izin Dicabut'){
				$item_array[] = array(
                    'id' => '',
                    'no_pendaftaran' => '2',
					'sts_berkas' => '',
                    'nama' => '',
                    'tlp' => '',
                    'alamat' => '',
                    'permohonan' => '',
					'n_kelompok_izin' => '',
                    'tracking' => $status
                );
		        }
        }
//      End Create

            $data['list'] = $item_array;
            $this->load->view("cek_no", $data);
//        }
    }

    function get2() {
        $id = $this->input->post('id_cak');

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
        //$xmlfile = "$base_url_websevices/api/permohonan/pendaftaran/$id";
        //$data_xml = simplexml_load_file($xmlfile);

//      Create Budi
        $item_array[] = array(
                    'id' => '',
                    'no_pendaftaran' => '',
			        'sts_berkas' => '',
                    'nama' => '',
                    'tlp' => '',
                    'alamat' => '',
                    'permohonan' => '',
			        'n_kelompok_izin' => '',
                    'tracking' => 'STATUS PERMOHONAN :',
			        'kd_status' => '',
					'no_surat' => '',
					'approve' => ''
        );

        //$url = $this->curl->simple_get("$base_url_websevices/api/stspermohonanlist/index.php");
        //$news_items = $this->xml_parsing_win->element_set('item', $url);
        //foreach ($news_items as $item) {
        //        $status = $this->xml_parsing_win->value_in('jenis_status', $item);
		//	    if ($status != 'Izin Disetujui' && $status != 'Izin Ditolak' && $status != 'Izin Dicabut'){
        //        $item_array[] = array(
        //            'id' => '',
        //            'no_pendaftaran' => '',
		//			'sts_berkas' => '',
        //             'nama' => '',
        //            'tlp' => '',
        //            'alamat' => '',
		//			'permohonan' => '',
        //            'n_kelompok_izin' => '',
        //            'tracking' => $status,
		//			'kd_status' => ''
        //        );
		//	    }
        //}
//      End Create

        $data['list'] = $item_array;

        $data['isi'] = 'cek_nomer';

        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $this->load->view('template', $data);
    }

	function get2_OLD() {
        $id = $this->input->post('id_cak');

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

                $item_array[] = array(
                    'id' => $id,
                    'no_pendaftaran' => $no_pendaftaran,
					'sts_berkas' => $sts_berkas,
                    'nama' => $nama,
                    'tlp' => $tlp,
                    'alamat' => $alamat,
                    'permohonan' => $permohonan,
					'n_kelompok_izin' => $n_kelompok_izin,
                    'tracking' => $tracking
                );
            }
        }
//        $xmlfile = "$base_url_websevices/api/permohonan/pendaftaran/$id";
//        $data_xml = simplexml_load_file($xmlfile);

//      Create Budi
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
        );

        $url = $this->curl->simple_get("$base_url_websevices/api/stspermohonanlist/index.php");
        $news_items = $this->xml_parsing_win->element_set('item', $url);
        foreach ($news_items as $item) {
                $status = $this->xml_parsing_win->value_in('jenis_status', $item);
			    if ($status != 'Izin Disetujui' && $status != 'Izin Ditolak' && $status != 'Izin Dicabut'){
                $item_array[] = array(
                    'id' => '',
                    'no_pendaftaran' => '',
					'sts_berkas' => '',
                    'nama' => '',
                    'tlp' => '',
                    'alamat' => '',
					'permohonan' => '',
                    'n_kelompok_izin' => '',
                    'tracking' => $status
                );
			    }
        }
//      End Create

        $data['list'] = $item_array;

        $data['isi'] = 'cek_nomer';

        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $this->load->view('template', $data);
    }

}

?>
