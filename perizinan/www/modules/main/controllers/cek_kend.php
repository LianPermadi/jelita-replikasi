<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of welcome
 * @author PBS 
 */
class Cek_kend extends MY_Controller {
  
  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $this->curl->option('ssl_verifyhost', false);
    $this->curl->option('ssl_verifypeer', false);
  }
  
  function index() {
    $data['isi'] = 'isi_kend';
    $this->load->view('template', $data); 
  }
  
  function get() {
  	$id = str_replace(" ","_", $this->input->post('id_cak'));
    //start Web Service Jasa Raharja
    $nokenddishub = preg_replace('/\s/i', '%20', $this->input->post('id_cak'));
    //Web Service Informasi Masa Laku Sumbangan Wajib Dana Kecelakaan Lalu Lintas Jalan (SWDKLLJ)
    //Output {"DISHUB_SW": [{ "NO_POLISI": "BL-6503-B","TGL_TRANSAKSI": "2017-05-15T00:00:00","MASA_LAKU_AKHIR": "2018-05-19T00:00:00",
    //                        "NO_RANGKA": "MH1JB9121AK110817","NO_MESIN": "JB91E2104535"} ]}
    $url = 'http://as.jasaraharja.co.id/dasi_ws/SP_WServices.ashx?cat=DISHUB_SW&ApiKey=02145dKrW&params='.$nokenddishub.'|DIS03';
    $get = file_get_contents($url);
    $swdkllj = array();
    if($get) {
      $json = json_decode($get);
    }
    if(!empty($json)) {
      foreach ($json->DISHUB_SW as $val) {
        if(!isset($val->STATUS)) {
          $swdkllj[] = array('tgl_transaksi' => $val->TGL_TRANSAKSI,
                             'tgl_mati_yad' => $val->TGL_MATI_YAD,
                             'no_rangka' => $val->NO_RANGKA,
                             'no_mesin' => $val->NO_MESIN);
        }
      }
    }
    
    //Web Service Informasi History Kecelakaan
    //Output {"DISHUB_HISTORY_LAKA": [{"NOPOL": "BL-6503-B","TGL_KEJADIAN": "2018-03-09T11:00:00",
    //                                 "DESKRIPSI_LOKASI": "LAKA LANTAS DIJLN UMUM BLANGKEJERENTAKENGON DESA TUNGEL INDUK KEC.RIKIT GAIB KAB.GAYO LUES",
    //                                 "DESKRIPSI": "KEC. RIKIT GAIB, KAB. GAYO LUES"} ]}
    $url = 'http://as.jasaraharja.co.id/dasi_ws/SP_WServices.ashx?cat=DISHUB_HISTORY_LAKA&ApiKey=02145dKrW&params='.$nokenddishub.'|DIS03';
    $get = file_get_contents($url);
    $kresh = array();
    if($get) {
      $json = json_decode($get);
    }
    if(!empty($json)) {
      foreach ($json->DISHUB_HISTORY_LAKA as $val) {
        if(!isset($val->HASIL)) {
          $kresh[] = array('tgl_kejadian' => $val->TGL_KEJADIAN,
                           'des_lokasi' => $val->DESKRIPSI_LOKASI,
                           'deskripsi' => $val->DESKRIPSI);
        }
      }
    }
    
    //Web Service Informasi Iuran Wajib Kendaraan Bermotor Umum (IWKBU)
    //Output {"DISHUB_IWKBU": [{"NOPOL": "R-1014-CB", "NAMA_PO": "PERORANGAN SAMSAT CILACAP", "TARIF_PER_BULAN": 95000.0,
    //                          "TGL_TRANSAKSI": "2014-12-30T00:00:00", "TGL_MATI_AKHIR": "2014-12-13T00:00:00", "NOMINAL_PELUNASAN": 3800000.0}]}
    $nokenddishub = str_replace(" ","-", $this->input->post('id_cak'));
    $url = 'http://as.jasaraharja.co.id/dasi_ws/SP_WServices.ashx?cat=DISHUB_IWKBU&ApiKey=02145dKrW&params='.$nokenddishub.'|DIS03';
    $get = file_get_contents($url);
    $iwkbu = array();
    if($get) {
      $json = json_decode($get);
    }
    //var_dump($json);die();
    if(!empty($json) && !isset($json->FalseReturn)) {
      foreach ($json->DISHUB_IWKBU as $val) {
        //if(!isset($val->STATUS)) {
        if($val->STATUS != '0') {
          $iwkbu[] = array('nama_po' => $val->NAMA_PO,
                           'tarif_per_bulan' => $val->TARIF_PER_BULAN,
                           'tgl_tansaksi' => $val->TGL_TRANSAKSI,
                           'tgl_mati_akhir' => $val->TGL_MATI_AKHIR,
                           'nominal_pelunasan' => $val->NOMINAL_PELUNASAN,
                           'deskripsi' => 'undefined');
        }else{
          $iwkbu[] = array('nama_po' => '',
                           'tarif_per_bulan' => '',
                           'tgl_tansaksi' => '',
                           'tgl_mati_akhir' => '',
                           'nominal_pelunasan' => '',
                           'deskripsi' => '');	
        }
      }
    }
    //EOF() Web Service Jasa Raharja
    
    $dt = $this->tmwcm->where("C_ID = 3")->get();
    $base_url_websevices = $dt->N_ALAMAT_WAP;
    $alamat = $base_url_websevices."/api/kendaraan/nomor/".$id;
    $this->curl->option('ssl_verifyhost', false);
    $this->curl->option('ssl_verifypeer', false);
    $url = $this->curl->simple_get($alamat);
    $news_items = $this->xml_parsing_win->element_set('item', $url);
    
    if($news_items === false) {
      $item_array = array();
    }else{
      foreach ($news_items as $item) {
        $item_array[] = array('no_kend' => $this->xml_parsing_win->value_in('no_kend', $item),
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
    
    $data['no_mobil'] = $this->input->post('id_cak');
    $data['list'] = $item_array;
    $data['swdkllj'] = $swdkllj; //Kirim hasil Web Service SWDKLLJ ke view
    $data['kresh'] = $kresh;     //Kirim hasil Web Service kecelakaan ke view
    $data['iwkbu'] = $iwkbu;     //Kirim hasil Web Service IWKBU ke view
    $data['isi'] = 'cek_kend';
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $this->load->view('template', $data);
  }
}
?>
