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
class Pendaftaran_online2 extends MY_Controller {

    function __construct() {
        parent::__construct();
//        $this->tr_propinsi = new trpropinsi();
//        $this->tr_kabupaten = new trkabupaten();
//        $this->tr_keluarahan = new trkelurahan();
//        $this->tr_kecamatan = new trkecamatan();

        $this->tm_pemohon = new Tm_pemohon();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $detect = $this->load->library('Mobile_Detect');
        if ($detect->isMobile()) {
            $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
            $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

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
        }
    }

    function index() {
        // mengambil format xml
//        $dt=  $this->tmwcm->where("C_ID = 3")->get();
//        $base_url_websevices=$dt->N_ALAMAT_WAP;
//        $xmlfile = "$base_url_websevices/api/jenisperizinanlist";
//        $data_xml = simplexml_load_file($xmlfile);

        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;
        $url = $this->curl->simple_get("$base_url_websevices/api/jenisperizinanlist");

        $news_items = $this->xml_parsing_win->element_set('item', $url);
        foreach ($news_items as $item) {
            $id = $this->xml_parsing_win->value_in('id', $item);
            $jenis = $this->xml_parsing_win->value_in('jenis_perizinan', $item);
			$c_aktif = $this->xml_parsing_win->value_in('c_aktif', $item);
            if($jenis <> 'IZIN LAIN-LAIN'){
    			if($c_aktif == 0){
                    $item_array[] = array(
                        'id' => $id,
                        'jenis_perizinan' => $jenis,
                    );
			    }
			}
        }

        $url_my_prop = $this->curl->simple_get("$base_url_websevices/api/propinsi");
        $dt_prop = $this->xml_parsing_win->element_set('item', $url_my_prop);
        foreach ($dt_prop as $item2) {
            $id_prop = $this->xml_parsing_win->value_in('id', $item2);
            $nama_propinsi = $this->xml_parsing_win->value_in('nama_propinsi', $item2);

            $list_prop[] = array(
                'id' => $id_prop,
                'n_propinsi' => $nama_propinsi
            );
        }
        //var_dump($item_array);
        $data['list_prop'] = $list_prop;
        $data['list_trperizinan'] = $item_array;
        //$data['list_trperizinan'] = $data_xml;
        $data['list_propinsi'] = ''; // $this->tr_propinsi->order_by("n_propinsi ASC")->get();

        $data['error'] = NULL;
        $data['referensi'] = NULL;
        $data['namaPemohon'] = NULL;
        $data['telpPemohon'] = NULL;
        $data['almtPemohon'] = NULL;
        $data['propinsi1'] = NULL;
        $data['kabupaten1'] = NULL;
        $data['kecamatan1'] = NULL;
        $data['kelurahan1'] = NULL;
        $data['npwpPerusahaan'] = NULL;
        $data['regPerusahaan'] = NULL;
        $data['namaPerusahaan'] = NULL;
        $data['almtPerusahaan'] = NULL;
        $data['telpPerusahaan'] = NULL;
        $data['tglPermohonan'] = NULL;
        $data['propinsi2'] = NULL;
        $data['kabupaten2'] = NULL;
        $data['kecamatan2'] = NULL;
        $data['kelurahan2'] = NULL;
        $data['izin'] = NULL;

        $data['list_kabupaten1'] = NULL;
        $data['list_kecamatan1'] = NULL;
        $data['list_kelurahan1'] = NULL;

        $data['list_kabupaten2'] = NULL;
        $data['list_kecamatan2'] = NULL;
        $data['list_kelurahan2'] = NULL;

        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $data['isi'] = 'isi_Pendaftaran';   // views/isi_pendaftaran.php
        $this->load->view('template', $data);  // tampilan di file -> sicantik\www\modules\main\views\isi_Pendaftaran.php
    }

    function save_pendaftaran() {
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;
		$url = $this->curl->simple_get("$base_url_websevices/api/jenisperizinanlist/index.php");

        $news_items = $this->xml_parsing_win->element_set('item', $url);
        foreach ($news_items as $item) {
            $id = $this->xml_parsing_win->value_in('id', $item);
            $jenis = $this->xml_parsing_win->value_in('jenis_perizinan', $item);
//			$kelompok = $this->xml_parsing_win->value_in('kelompok', $item);    // PBS

            $item_array[] = array(
                'id' => $id,
                'jenis_perizinan' => $jenis,
//				'kelompok' => $kelompok,                      // PBS
            );
        }

        //var_dump($item_array);
        $data['list_trperizinan'] = $item_array;
        //$data['list_trperizinan'] = $data_xml;

        $data['list_propinsi'] = ''; //$this->tr_propinsi->order_by("n_propinsi ASC")->get();
        //data propinsi webservices
        $url_my_prop = $this->curl->simple_get("$base_url_websevices/api/propinsi");
        $dt_prop = $this->xml_parsing_win->element_set('item', $url_my_prop);
        foreach ($dt_prop as $item2) {
            $id_prop = $this->xml_parsing_win->value_in('id', $item2);
            $nama_propinsi = $this->xml_parsing_win->value_in('nama_propinsi', $item2);

            $list_prop[] = array(
                'id' => $id_prop,
                'n_propinsi' => $nama_propinsi
            );
        }
        //var_dump($item_array);
        $data['list_prop'] = $list_prop;

        $data['isi'] = 'isi_Pendaftaran';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);

        $data['referensi'] = $this->input->post('referensi');
        $data['namaPemohon'] = $this->input->post('namaPemohon');
        $data['telpPemohon'] = $this->input->post('telpPemohon');
        $data['almtPemohon'] = $this->input->post('almtPemohon');
        $data['propinsi1'] = $this->input->post('propinsi1');
        $data['kabupaten1'] = $this->input->post('kabupaten1');
        $data['kecamatan1'] = $this->input->post('kecamatan1');
        $data['kelurahan1'] = $this->input->post('kelurahan1');
        $data['npwpPerusahaan'] = $this->input->post('npwpPerusahaan');
        $data['regPerusahaan'] = $this->input->post('regPerusahaan');
        $data['namaPerusahaan'] = $this->input->post('namaPerusahaan');
        $data['almtPerusahaan'] = $this->input->post('almtPerusahaan');
        $data['telpPerusahaan'] = $this->input->post('telpPerusahaan');
        $data['tglPermohonan'] = $this->input->post('tglPermohonan');
        $data['propinsi2'] = $this->input->post('propinsi2');
        $data['kabupaten2'] = $this->input->post('kabupaten2');
        $data['kecamatan2'] = $this->input->post('kecamatan2');
        $data['kelurahan2'] = $this->input->post('kelurahan2');

        $data['cmbsource'] = $this->input->post('cmbsource');

        $data['list_kabupaten1'] = ''; // $this->tr_kabupaten->get_result($data['propinsi1']);
        $data['list_kecamatan1'] = ''; //$this->tr_kecamatan->get_result($data['kabupaten1']);
        $data['list_kelurahan1'] = ''; //$this->tr_keluarahan->get_result($data['kecamatan1']);

        $data['list_kabupaten2'] = ''; // $this->tr_kabupaten->get_result($data['propinsi2']);
        $data['list_kecamatan2'] = ''; //$this->tr_kecamatan->get_result($data['kabupaten2']);
        $data['list_kelurahan2'] = ''; //$this->tr_keluarahan->get_result($data['kecamatan2']);

        $data['izin'] = $this->input->post('izin');
        $isi_data_izin = $this->input->post('gt' . $data['izin']);
//PBS        $uploads = $_FILES['file_upload']['name'];    // Upload File
//PBS        if (!empty($uploads)) {                       // Upload File
	    $BypassPBS = '1';
	    if ($BypassPBS == '1') {
            $configs['overwrite'] = FALSE;
            $config['upload_path'] = './uploads/lampiran/';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
//PBS            $field = 'file_upload';              // Upload File
//PBS            if (!$this->upload->do_upload($field)) {    //diganti $BypassPBS == '2'
            if ($BypassPBS == '2') {
                $x = array('<p>', '</p>');
                $error = str_replace($x, '', $this->upload->display_errors());
                $data['error'] = $error;
                $this->load->view('template', $data);
            } else {
                $no_urut = $this->tm_pemohon->get_urut();
                $no_urut = $no_urut->urut;
                if ($no_urut != NULL) {
                    $no_uniq = $no_urut + 1;
                } else {
                    $no_uniq = 1;
                }
//PBS                $uploaded = $this->upload->data();   // Upload File
//PBS                $file = $uploaded['file_name'];      // Upload File

                $data2['referensi'] = $this->input->post('referensi');
                $data2['namaPemohon'] = $this->input->post('namaPemohon');
                $data2['telpPemohon'] = $this->input->post('telpPemohon');
                $data2['almtPemohon'] = $this->input->post('almtPemohon');
                $data2['propinsi1'] = $this->input->post('propinsi1');
                $data2['kabupaten1'] = $this->input->post('kabupaten1');
                $data2['kecamatan1'] = $this->input->post('kecamatan1');
                $data2['kelurahan1'] = $this->input->post('kelurahan1');
                $data2['npwpPerusahaan'] = $this->input->post('npwpPerusahaan');
                $data2['regPerusahaan'] = $this->input->post('regPerusahaan');
                $data2['namaPerusahaan'] = $this->input->post('namaPerusahaan');
                $data2['almtPerusahaan'] = $this->input->post('almtPerusahaan');
                $data2['telpPerusahaan'] = $this->input->post('telpPerusahaan');
                $data2['tglPermohonan'] = $this->input->post('tglPermohonan');
                $data2['propinsi2'] = $this->input->post('propinsi2');
                $data2['kabupaten2'] = $this->input->post('kabupaten2');
                $data2['kecamatan2'] = $this->input->post('kecamatan2');
                $data2['kelurahan2'] = $this->input->post('kelurahan2');
                $data2['izin'] = $this->input->post('izin');
				$data2['urut'] = $no_uniq;
//PBS                $data2['lampiran'] = base_url() . 'uploads/lampiran/' . $file;     // Upload File
				$data2['lampiran'] = base_url() . 'uploads/lampiran/Logo Jabar.Jpg';
                $data2['isi_izin'] = $isi_data_izin;
//				$data2['n_kelompok'] = $isi_data_izin;    //PBS
                $this->tm_pemohon->insert($data2);
                $this->session->set_userdata('no_uniq', $no_uniq);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "$base_url_websevices/api/pendaftaran/");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                /* OLD 
				curl_setopt($ch, CURLOPT_POSTFIELDS, 
				        "jenis_izin_id=" . $data2['izin'] .
                        "&alamat_pemohon=" . $data2['almtPemohon'] .
                        "&no_refer=" . $data2['referensi'] .
                        "&nama_pemohon=" . $data2['namaPemohon'] .
                        "&nama_perusahaan=" . $data2['namaPerusahaan'] .
                        "&npwp=" . $data2['npwpPerusahaan'] .
                        "&alamat_usaha=" . $data2['almtPerusahaan'] .
                        "&no_telp=" . $data2['telpPemohon'] .
                        "&jenis_permohonan_id=1" .
                        "&file=" . $data2['lampiran'] .
                        "&kelurahan_pemohon=" . $data2['kelurahan1'] .
                        "&kelurahan_usaha=" . $data2['kelurahan2'] .
                        "&telpPerusahaan=" . $data2['telpPerusahaan'] .
                        "&no_registrasi=" . $data2['regPerusahaan'] .
                        "&cmbsource=" . $data['cmbsource']
                );
				*/
				curl_setopt($ch, CURLOPT_POSTFIELDS, 
					    "v_referensi=" . $data2['referensi'].
                        "&v_namaPemohon=" . $data2['namaPemohon'].
                        "&v_telpPemohon=" . $data2['telpPemohon'].
                        "&v_almtPemohon=" . $data2['almtPemohon'].
                        "&v_propinsi1=" . $data2['propinsi1'].
                        "&v_kabupaten1=" . $data2['kabupaten1'].
                        "&v_kecamatan1=" . $data2['kecamatan1'].
                        "&v_kelurahan1=" . $data2['kelurahan1'].
                        "&v_npwpPerusahaan=" . $data2['npwpPerusahaan'].
                        "&v_regPerusahaan=" . $data2['regPerusahaan'].
                        "&v_namaPerusahaan=" . $data2['namaPerusahaan'].
                        "&v_almtPerusahaan=" . $data2['almtPerusahaan'].
                        "&v_telpPerusahaan=" . $data2['telpPerusahaan'].
                        "&v_tglPermohonan=" . $data2['tglPermohonan'].
                        "&v_propinsi2=" . $data2['propinsi2'].
                        "&v_kabupaten2=" . $data2['kabupaten2'].
                        "&v_kecamatan2=" . $data2['kecamatan2'].
                        "&v_kelurahan2=" . $data2['kelurahan2'].
                        "&v_izin=" . $data2['izin'].
		                "&v_urut=" . $data2['urut'].
                        "&v_lampiran=" . $data2['lampiran'].
                        "&v_isi_izin=" . $data2['isi_izin']
                );

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $result = curl_exec($ch);
                $xml = $this->xml_parsing_win->element_set('xml', $result);
                foreach ($xml as $item) {
                    $noPendaf = $this->xml_parsing_win->value_in('no_pendaftaran', $item);
                }
                curl_close($ch);

				// manipulasi PBS hack
				$noPendaf = '00'.DATE("H").DATE("i").DATE("s").DATE("d").DATE("m").DATE("Y").'000';
		        // EOF
                redirect('main/pendaftaran_online2/dt_pemohon/' . $noPendaf);
            }
        } else {
            $data['error'] = "File Lampiran Harus Tersedia";
            $this->load->view('template', $data);
        }
    }

    function dt_pemohon($id) {
        $id_uniq = 0;
        $id_uniq = $this->session->userdata('no_uniq');
        $data['dt'] = $this->tm_pemohon->where("urut = $id_uniq")->get();
        $data['isi'] = 'data_pemohon';
        $data['dt_pemohon'] = $id;
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
    }

    function back() {
        $izin = $this->input->post('izin');
        $almtPemohon = $this->input->post('almtPemohon');
        $referensi = $this->input->post('referensi');
        $namaPemohon = $this->input->post('namaPemohon');
        $namaPerusahaan = $this->input->post('namaPerusahaan');
        $npwpPerusahaan = $this->input->post('npwpPerusahaan');
        $almtPerusahaan = $this->input->post('almtPerusahaan');
        $telpPemohon = $this->input->post('telpPemohon');
        $file = $_FILES['uploaded']['name'];
        $kelurahan1 = $this->input->post('kelurahan1');
        $kelurahan2 = $this->input->post('kelurahan2');
        $telpPerusahaan = $this->input->post('telpPerusahaan');
        $regPerusahaan = $this->input->post('regPerusahaan');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://192.168.0.5/alp_backoffice" . "/api/pendaftaran/");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "jenis_izin_id=" . $izin . "&alamat_pemohon=" . $almtPemohon .
                "&no_refer=" . $referensi . "&nama_pemohon=" . $namaPemohon . "&nama_perusahaan=" . $namaPerusahaan
                . "&npwp=" . $npwpPerusahaan . "&alamat_usaha=" . $almtPerusahaan .
                "&no_telp=" . $telpPemohon . "&jenis_permohonan_id=1" . "&file=" . $file . "&kelurahan_pemohon=" . $kelurahan1
                . "&kelurahan_usaha=" . $kelurahan2 . "&telpPerusahaan=" . $telpPerusahaan . "&no_registrasi=" . $regPerusahaan);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $xmldoc = new SimpleXMLElement($result);
        $noPendaf = $xmldoc->no_pendaftaran;
        curl_close($ch);
        $xmldoc;
    }

    function list_daerah($list, $id) {
        $data['jenis_list'] = $list;
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

        if ($list == 1 || $list == 10) {
            $url = $this->curl->simple_get("$base_url_websevices/api/kabupaten/id_prop/$id");
            $news_items = $this->xml_parsing_win->element_set('item', $url);
            foreach ($news_items as $item) {
                $id = $this->xml_parsing_win->value_in('id', $item);
                $nama = $this->xml_parsing_win->value_in('nama_kabupaten', $item);

                $item_array[] = array(
                    'id' => $id,
                    'n_kabupaten' => $nama,
                );
            }
            $data['list'] = $item_array;
            //$data['list'] = $this->tr_kabupaten->get_result($id);
        } elseif ($list == 2 || $list == 20) {
            $url = $this->curl->simple_get("$base_url_websevices/api/kecamatan/id_kab/$id");
            $news_items = $this->xml_parsing_win->element_set('item', $url);
            foreach ($news_items as $item) {
                $id = $this->xml_parsing_win->value_in('id', $item);
                $nama = $this->xml_parsing_win->value_in('nama_kecamatan', $item);

                $item_array[] = array(
                    'id' => $id,
                    'nama' => $nama,
                );
            }
            $data['list'] = $item_array;

            //$data['list'] = $this->tr_kecamatan->get_result($id);
        } elseif ($list == 3 || $list == 30) {
            $url = $this->curl->simple_get("$base_url_websevices/api/kelurahan/id_kec//$id");
            $news_items = $this->xml_parsing_win->element_set('item', $url);
            foreach ($news_items as $item) {
                $id = $this->xml_parsing_win->value_in('id', $item);
                $nama = $this->xml_parsing_win->value_in('nama_kelurahan', $item);

                $item_array[] = array(
                    'id' => $id,
                    'nama' => $nama,
                );
            }
            $data['list'] = $item_array;

            //$data['list'] = $this->tr_keluarahan->get_result($id);
        }
        $this->load->view('list_daerah_web_services', $data);
        //$this->load->view('list_daerah', $data);
    }

    //get_capcha================================================================================

    function get_capcha() {
        chmod(base_url() . '/captcha/', 0755);
        $capcha = $this->captcha();
        $data['img'] = $capcha['img'];
        $data['word'] = $capcha['word'];
        $this->load->view('isi_capcha', $data);
    }

    function captcha() {

        chmod(base_url() . '/captcha/', 0755);

        $this->load->plugin('captcha');
        $str = 'ABCDEFGHJKLMNOPQRSTUVWXYZ1234567890abcdefghjklmnopqrstuvwxyz';
        $random_word = str_shuffle($str);
        $random_word = substr($random_word, 0, 5);
        $vals = array(
            'word' => $random_word,
            'img_path' => 'captcha/',
            'img_url' => base_url() . '/captcha/',
            'font_path' => './path/to/fonts/LACURG__.TTF',
            'img_width' => '200',
            'img_height' => 50,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);


//        $data = array(
//            'captcha_time' => $cap['time'],
//            'ip_address' => $this->input->ip_address(),
//            'word' => $cap['word']
//        );
////        $query = $this->db->insert_string('captcha', $data);
////        $this->db->query($query);


        $cap_conf = array(
            'img' => $cap['image'],
            'word' => $cap['word']
        );
        return $cap_conf;
    }

}

?>
