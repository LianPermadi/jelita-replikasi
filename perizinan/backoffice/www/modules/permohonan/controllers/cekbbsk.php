<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* Description of welcome @author PBS 2017 */
class cekbbsk extends MY_Controller {
  
  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    // $this->dbmysql2 = $this->load->database('dbakdp',TRUE);
  }
  
  function index($where) {
    // $sql = "
    // select 
    // a.PIT_ID
    // ,a.PEMILIK
    // ,a.NO_IP
    // ,a.BERLAKU
    // ,a.KETERANGAN
    // ,ALAMAT_PEM
    // ,a.NO_SK 
    // ,a.TG_SK
    // ,a.NAMA_PERUS
    // ,a.ALAMAT_PER
    // ,b.NO_IK
    // ,b.NO_MOBIL
    // ,b.NO_UJI
    // ,b.TAHUN_PEMB
    // ,b.MERK
    // ,b.DA_ORANG
    // ,b.KP_ID
    // ,b.BBM
    // ,(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID) KODE_TRAYE
    // ,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID)) NAMATRAYEK
    // ,(SELECT TG_AKHIR from bb_kp where KP_ID = b.KP_ID) TG_AKHIR
    // from `dbakdp`.`bb_pit a
    // inner join bb_mobil b
    // on a.PIT_ID = b.PIT_ID
    // where a.PIT_ID =? ORDER BY NO_IK ASC
    // ";
    $sql = "SELECT *  FROM `dbakdp`.`bb_pit` WHERE `NO_RESI` LIKE '$where' ORDER BY `NO_RESI` DESC";
    $item_array = $this->db->query($sql)->result();
   $data['list'] = $item_array;
    $data['resi'] = $where;
    $data['isi'] = 'cek_bb_sk';
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $this->load->view('template', $data);
	}

    
  function download_sk($noip = NULL) {
    $file = str_replace(' ', '','KP_'.$noip);
    $lok = base_url().'backoffice/assets/esignfile/';
    
    redirect('https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/esignfile/KP_0173940601072023674.pdf','refresh');
    
    // var_dump($lok.$file.'.pdf');die();
    // if(file_exists($lok.$file.'.pdf')){
	//     $data = file_get_contents($lok.$file.'.pdf');
	//     force_download('SK '.$noip.' - '.date('d-m-Y').'.pdf', $data);
	//   }
  }
}