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
class Pengaduan extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->tm_pengaduan = new Tm_pengaduan();
        $this->tmwcm=new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
//pb        $detect = $this->load->library('Mobile_Detect');
//pb        if ($detect->isMobile()) {
//pb            $link = "http" .((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
//pb            $server = isset($_SERVER['HTTP_HOST']) ?$_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
            
             //cara ke 2

//pb            $base_url = base_url();
//pb            $xx = explode('/', $base_url);
//pb            $x = 0;
//pb            $jumlah_url_1 = count($xx) - 1;
//pb            $jumlah_url = count($xx);
//pb            $url_mobile = NULL;
//pb            foreach ($xx as $apl_mobile_url) {
//pb                $x++;

//pb                if ($jumlah_url_1 == $x) {
                    
//pb                } elseif ($jumlah_url == $x) {
                    
//pb                } else {
//pb                    if ($x == 1) {
//pb                        $url_mobile.= $apl_mobile_url;
//pb                        $url_mobile.= '//';
//pb                    } elseif ($x == 2) {
                        
//pb                    } else {
//pb                        $url_mobile.= $apl_mobile_url;
//pb                        $url_mobile.= '/';
//pb                    }
//pb                }
//pb            }

//pb            redirect($url_mobile."alp_mobile");
            //redirect($link . $server . "/alp_mobile");
            //redirect($link.$server."/alp_mobile");
//pb        }
    }

    function index() {
        $data['isi'] = 'isi_pengaduan';  // views/isi_pengaduan.php
        $dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;
        
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

		$url_my_status = $this->curl->simple_get("$base_url_websevices/api/status_pesan");
        $dt_status = $this->xml_parsing_win->element_set('item', $url_my_status);
        foreach ($dt_status as $item_stat) {
            $id_status = $this->xml_parsing_win->value_in('id', $item_stat);
            $nama_status = $this->xml_parsing_win->value_in('n_sts_pesan', $item_stat);
			$sts_status = $this->xml_parsing_win->value_in('status', $item_stat);

            $list_status[] = array(
                'id' => $id_status,
                'n_status' => $nama_status,
				'status' => $sts_status
            );
        }

        //var_dump($item_array);
        $data['list_propinsi'] = $list_prop;
		$data['list_status'] = $list_status;
        
        // $data['list_propinsi'] = $this->tr_propinsi->order_by("n_propinsi ASC")->get();
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
//		redirect('main/pengaduan/get_dt_pengaduan');   // kalo mau cek langsung tampilan
    }

    function save() {
        $dt_web=  $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices=$dt_web->N_ALAMAT_WAP;

        $jenis = $this->input->post('jenis');
        $nomor = $this->input->post('nomor');
		$nama = $this->input->post('nama');
        $kontak = $this->input->post('kontak_person');
		$no_hp = $this->input->post('no_hp');
		$n_email = $this->input->post('n_email');
        $alamat = $this->input->post('alamat');
        $propinsi1 = $this->input->post('propinsi1');
        $kabupaten1 = $this->input->post('kabupaten1');
        $kecamatan1 = $this->input->post('kecamatan1');
        $kelurahan1 = $this->input->post('kelurahan1');
        $e_pesan = $this->input->post('e_pesan');
        $tanggal = date("Y-m-d");
        $gt_urut = $this->tm_pengaduan->get_urut();
        if ($gt_urut->urut != NULL) {
            $no_urut = $gt_urut->urut + 1;
        } else {
            $no_urut = 1;
        }

        $dt = array(
			'jns_pengaduan' => $jenis,
            'pendaftaran_id' => $nomor,
            'nama' => $nama,
            'kontak_person' => $kontak,
			'no_hp' => $no_hp,
			'email' => $n_email,
            'alamat' => $alamat,
            'propinsi1' => $propinsi1,
            'kabupaten1' => $kabupaten1,
            'kecamatan1' => $kecamatan1,
            'kelurahan1' => $kelurahan1,
            'e_pesan' => $e_pesan,
            'tanggal_input' => $tanggal,
            'urut' => $no_urut
        );

        $this->session->set_userdata('no_uniq_pengaduan', $no_urut);
        $this->tm_pengaduan->insert($dt);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$base_url_websevices" . "/api/pengaduan/");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "propinsi=" . $propinsi1
                . "&kabupaten=" . $kabupaten1
                . "&kecamatan=" . $kecamatan1
                . "&alamat=" . $alamat
                . "&kelurahan=" . $kelurahan1
			    . "&jns_pengaduan=" . $jenis
                . "&pendaftaran_id=" . $nomor
                . "&nama=" . $nama
			    . "&kontak_person=" . $kontak
  	            . "&no_hp=" . $no_hp
			    . "&n_email=" . $n_email
                . "&e_pesan=" . $e_pesan
                . "&d_entry=" . $tanggal . "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        // echo $result;
        curl_close($ch);
        redirect('main/pengaduan/get_dt_pengaduan');
    }

    function get_dt_pengaduan() {
		$id = $this->session->userdata('no_uniq_pengaduan');
        $dt = $this->tm_pengaduan->where("urut = $id")->get();
        $id_sts = $dt->jns_pengaduan;
		$pendaftaran_id = $dt->pendaftaran_id;
		$tanggal_input = $dt->tanggal_input;
		$nama = $dt->nama;
		$no_hp = $dt->no_hp;
		$email = $dt->email;
		$kontak_person = $dt->kontak_person;
		$e_pesan = $dt->e_pesan;

		$dt = $this->tmwcm->where("C_ID = 3")->get();
        $base_url_websevices = $dt->N_ALAMAT_WAP;

		$url_my_status = $this->curl->simple_get("$base_url_websevices/api/status_pesan");
        $dt_status = $this->xml_parsing_win->element_set('item', $url_my_status);
		$status = "";
        foreach ($dt_status as $item_stat) {
            $id_status = $this->xml_parsing_win->value_in('id', $item_stat);
            if($id_status == $id_sts) {
				$status = $this->xml_parsing_win->value_in('n_sts_pesan', $item_stat);
				break;
			}
        }

		$data['status'] = $status;
		$data['pendaftaran_id'] = $pendaftaran_id;
		$data['tanggal_input'] = $tanggal_input;
		$data['nama'] = $nama;
		$data['no_hp'] = $no_hp;
		$data['email'] = $email;
		$data['kontak_person'] = $kontak_person;
		$data['e_pesan'] = $e_pesan;
        $data['isi'] = 'view_pengaduan';
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $this->load->view('template', $data);
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
}
?>