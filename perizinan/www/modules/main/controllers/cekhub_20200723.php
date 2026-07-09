<?php

/* To change this template, choose Tools | Templates
 * and open the template in the editor.
/* Description of welcome @author PBS 2017 */
class cekhub extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $this->load->helper(array('url','download'));
  }
  
  function index($varOK=NULL) {
    $var_sample = substr($varOK,9,25);
    $isNo_uji = strpos($var_sample,'No_Uji');
    $id = $varOK;//substr($var_sample,0,$isNo_uji-1);  // contoh X_0000_XX
    //$isSK = stristr($varOK,'idkeySK');
    //if($isSK == '') $isSK = FALSE; else $isSK = TRUE;
    $dt = $this->tmwcm->where("C_ID = 3")->get();
    $base_url_websevices = $dt->N_ALAMAT_WAP;
    $url = $this->curl->simple_get("$base_url_websevices/api/perhubungan/idtrayek/$id");
    $news_items = $this->xml_parsing_win->element_set('item', $url);
    if($news_items == NULL) {
      $item_array = array();
    }else{
      foreach ($news_items as $item) {
        $valid            = $this->xml_parsing_win->value_in('valid', $item);
        $kypengolah       = $this->xml_parsing_win->value_in('kypengolah', $item);
        $kyEsl4           = $this->xml_parsing_win->value_in('kyEslempat', $item);
        $kyEsl3           = $this->xml_parsing_win->value_in('kyEsltiga', $item);
        $kyKa             = $this->xml_parsing_win->value_in('kyKa', $item);
        $pendaftaran_id   = $this->xml_parsing_win->value_in('pendaftaran_id', $item);
        
        //group SK
        $no_sk            = $this->xml_parsing_win->value_in('no_sk', $item);
        $nama_perusahaan  = $this->xml_parsing_win->value_in('nama_perusahaan', $item);
        $nama_pimpinan    = $this->xml_parsing_win->value_in('nama_pimpinan', $item);
        $almt_perusahaan  = $this->xml_parsing_win->value_in('almt_perusahaan', $item);
        $almt_pimpinan    = $this->xml_parsing_win->value_in('almt_pimpinan', $item);
        $no_induk         = $this->xml_parsing_win->value_in('no_induk', $item);
        $masa_berlaku     = $this->xml_parsing_win->value_in('masa_berlaku', $item);
        $ket              = $this->xml_parsing_win->value_in('ket', $item);
          
        //group KP
        $no_kp            = $this->xml_parsing_win->value_in('no_kp', $item);
        $berlaku_kp       = $this->xml_parsing_win->value_in('berlaku_kp', $item);
        $no_kend          = $this->xml_parsing_win->value_in('no_kend', $item);
        $no_uji           = $this->xml_parsing_win->value_in('no_uji', $item);
        $daya_angkut_org  = $this->xml_parsing_win->value_in('daya_angkut_org', $item);
        $daya_angkut_brg  = $this->xml_parsing_win->value_in('daya_angkut_brg', $item);
        $jenis_kend       = $this->xml_parsing_win->value_in('jenis_kend', $item);
        $merek            = $this->xml_parsing_win->value_in('merek', $item);
        $bahan_bakar      = $this->xml_parsing_win->value_in('bahan_bakar', $item);
        $jenis_pel        = $this->xml_parsing_win->value_in('jenis_pel', $item);
        $kode_trayek      = $this->xml_parsing_win->value_in('kode_trayek', $item);
        $sifat_pel        = $this->xml_parsing_win->value_in('sifat_pel', $item);
        $nama_pemilik     = $this->xml_parsing_win->value_in('nama_pemilik', $item);
        $trayek           = $this->xml_parsing_win->value_in('trayek', $item);
        $item_array[] = array('no_sk' => $no_sk,
                              'nama_perusahaan' => $nama_perusahaan,
                              'nama_pimpinan' => $nama_pimpinan,
                              'almt_perusahaan' => $almt_perusahaan,
                              'almt_pimpinan' => $almt_pimpinan,
                              'no_induk' => $no_induk,
                              'masa_berlaku' => $masa_berlaku,
                              'ket' => $ket,
                              'no_kp' => $no_kp,
                              'berlaku_kp' => $berlaku_kp,
                              'no_kend' => $no_kend,
                              'no_uji' => $no_uji,
                              'daya_angkut_org' => $daya_angkut_org,
                              'daya_angkut_brg' => $daya_angkut_brg,
                              'jenis_kend' => $jenis_kend,
                              'merek' => $merek,
                              'bahan_bakar' => $bahan_bakar,
                              'jenis_pel' => $jenis_pel,
                              'kode_trayek' => $kode_trayek,
                              'sifat_pel' => $sifat_pel,
                              'nama_pemilik' => $nama_pemilik,
                              'trayek' => $trayek,
                              'valid' => $valid,
                              'kypengolah' => $kypengolah,
                              'kyEsl4' => $kyEsl4,
                              'kyEsl3' => $kyEsl3,
                              'kyKa' => $kyKa,
                              'pendaftaran_id' => $pendaftaran_id);
      }
    }
    //$data['isSK'] = $isSK;
    $data['list'] = $item_array;
    $data['isi'] = 'cek_trayek';
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $this->load->view('template', $data);
  }
  
  function download_sk($nodaftar = NULL) {  // Download file ber ttE BSrE
    $file = str_replace(' ', '','SK_'.$nodaftar);
    $lok_esign = 'backoffice/assets/skpdf/';
    if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
	    $data = file_get_contents($lok_esign.$file.'.pdf');
	    force_download($file.'.pdf', $data);
	  }
  }
  
  function download_kp($nodaftar = NULL) {  // Download file ber ttE BSrE
    $file = str_replace(' ', '','KP_'.$nodaftar);
    $lok_esign = 'backoffice/assets/skpdf/';
    if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
	    $data = file_get_contents($lok_esign.$file.'.pdf');
	    force_download($file.'.pdf', $data);
	  }
  }
}
?>