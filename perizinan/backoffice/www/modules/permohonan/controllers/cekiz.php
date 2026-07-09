<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* Description of welcome @author PBS 2018 */
class cekiz extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $this->load->helper(array('url','download'));
    $this->curl->option('ssl_verifyhost', false);
    $this->curl->option('ssl_verifypeer', false);
  }

  function index($varOK=NULL) {
  	$isSK = stristr($varOK,'NoSurat');
    if($isSK == ''){
      $id = $varOK;
    }else{
      $id = substr($varOK,4,19);
    }
    $dt = $this->tmwcm->where("C_ID = 3")->get();
    $base_url_websevices = $dt->N_ALAMAT_WAP;
    $this->curl->option('ssl_verifyhost', false);
    $this->curl->option('ssl_verifypeer', false);
    $url = $this->curl->simple_get("$base_url_websevices/api/permohonan/pendaftaran/$id");
    $news_items = $this->xml_parsing_win->element_set('item', $url);
   
    if($news_items == NULL) {
      $item_array = array();
    }else{
      foreach ($news_items as $item) {
        $id = $this->xml_parsing_win->value_in('id', $item);
        $no_pendaftaran = $this->xml_parsing_win->value_in('no_pendaftaran', $item);
        $no_pendaftaran_cabut = $this->xml_parsing_win->value_in('no_pendaftaran_cabut', $item);
		    $sts_berkas = $this->xml_parsing_win->value_in('sts_berkas', $item);
        $nama = $this->xml_parsing_win->value_in('nama', $item);
        $tlp = $this->xml_parsing_win->value_in('telp', $item);
        $alamat = $this->xml_parsing_win->value_in('alamat', $item);
        $permohonan = $this->xml_parsing_win->value_in('permohonan', $item);
        $permohonan_cabut  = $this->xml_parsing_win->value_in('permohonan_cabut', $item);
        $c_izin_dicabut  = $this->xml_parsing_win->value_in('c_izin_dicabut', $item);
        $tracking = $this->xml_parsing_win->value_in('tracking', $item);
        $n_kelompok_izin = $this->xml_parsing_win->value_in('n_kelompok_izin', $item);
		    $kd_status = $this->xml_parsing_win->value_in('kd_status', $item);
		    $no_surat = $this->xml_parsing_win->value_in('no_surat', $item);
		    $approve = $this->xml_parsing_win->value_in('approve', $item);
		    $tgl_surat = $this->xml_parsing_win->value_in('tgl_surat', $item);

        $item_array[] = array('id' => $id,
                              'no_pendaftaran' => $no_pendaftaran,
                              'no_pendaftaran_cabut' => $no_pendaftaran_cabut,
				                      'sts_berkas' => $sts_berkas,
                              'nama' => $nama,
                              'tlp' => $tlp,
                              'alamat' => $alamat,
                              'permohonan' => $permohonan,
                              'permohonan_cabut' => $permohonan_cabut,
                              'c_izin_dicabut' => $c_izin_dicabut,
				                      'n_kelompok_izin' => $n_kelompok_izin,
                              'tracking' => $tracking,
				                      'kd_status' => $kd_status,
				                      'no_surat' => $no_surat,
				                      'approve' => $approve,
				                      'tgl_surat' => $tgl_surat
                             );
      }
    }
    $item_array[] = array('id' => '',
                          'no_pendaftaran' => '',
                          'no_pendaftaran_cabut' => '',
		                      'sts_berkas' => '',
                          'nama' => '',
                          'tlp' => '',
                          'alamat' => '',
                          'permohonan' => '',
                          'permohonan_cabut' => '',
                          'c_izin_dicabut' => '',
		                      'n_kelompok_izin' => '',
                          'tracking' => 'PROSES PERMOHONAN :',
		                      'kd_status' => '',
				                  'no_surat' => '',
				                  'approve' => '',
				                  'tgl_surat' => ''
                         );
    $data['list'] = $item_array;
    $data['isi'] = 'validasi_izin';
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $this->load->view('template', $data);
	}

  function unduh_surat($id = NULL, $kepada = NULL) {  // Download file ber ttE BSrE
    $file = str_replace(' ', '','SRT_'.$id);
    // die($file);
    $lok_esign = 'backoffice/assets/esign-surat/';
    $kepada = base64_decode($kepada);
    
    if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
      $data = file_get_contents($lok_esign.$file.'.pdf');
      force_download('Surat '.$kepada.' - E-Sign.pdf', $data);
    }
  }
	
	function download_pdf($nodaftar = NULL) {  // Download file ber ttE BSrE
  	$file = str_replace(' ', '','SK_'.$nodaftar);
  	$lok_esign = 'backoffice/assets/esignfile/';
  	if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
		  $data = file_get_contents($lok_esign.$file.'.pdf');
		  force_download($file.'.pdf', $data);
	  }
  }
}
?>