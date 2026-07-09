<?php

/* To change this template, choose Tools | Templates
 * and open the template in the editor.
/* Description of welcome @author PBS 2017 */
class cekbbsk extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $this->load->helper(array('url','download'));
  }
  
  function index($where) {
    $dbmysql2 = $this->load->database('dbakdp',TRUE);
    var_dump($where);die();

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
    // from bb_pit a
    // inner join bb_mobil b
    // on a.PIT_ID = b.PIT_ID
    // where a.PIT_ID =? ORDER BY NO_IK ASC
    // ";
    $sql = "SELECT *  FROM `bb_pit` WHERE `NO_RESI` LIKE '$where' ORDER BY `NO_RESI` DESC";
    $item_array = $dbmysql2->query($sql)->result();
    // $item_array = $dbmysql2->query($sql, $where);

    //var_dump($dbmysql2->last_query());die;
    $data['list'] = $item_array;
    $data['resi'] = $where;
    $data['isi'] = 'cek_bb_sk';
    // $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    // $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $this->load->view('template', $data);
  }

  
  // function download_sk($noip = NULL) {
  //   function tanggal_indo($tanggal)
  //   {
  //     $bulan = array (1 =>   'Januari',
  //           'Februari',
  //           'Maret',
  //           'April',
  //           'Mei',
  //           'Juni',
  //           'Juli',
  //           'Agustus',
  //           'September',
  //           'Oktober',
  //           'November',
  //           'Desember'
  //         );
  //     $split = explode('-', $tanggal);
  //     return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  //   }

  //   $dbmysql2 = $this->load->database('dbakdp',TRUE);

  //   $sql = "
  //   select 
  //   a.PIT_ID
  //   ,a.PEMILIK
  //   ,a.NO_IP
  //   ,a.BERLAKU
  //   ,a.KETERANGAN
  //   ,ALAMAT_PEM
  //   ,a.NO_SK 
  //   ,a.TG_SK
  //   ,a.NAMA_PERUS
  //   ,a.ALAMAT_PER
  //   ,b.NO_IK
  //   ,b.NO_MOBIL
  //   ,b.NO_UJI
  //   ,b.TAHUN_PEMB
  //   ,b.MERK
  //   ,b.DA_ORANG
  //   ,b.KP_ID
  //   ,b.BBM
  //   ,(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID) KODE_TRAYE
  //   ,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID)) NAMATRAYEK
  //   ,(SELECT TG_AKHIR from bb_kp where KP_ID = b.KP_ID) TG_AKHIR
  //   from bb_pit a
  //   inner join bb_mobil b
  //   on a.PIT_ID = b.PIT_ID
  //   where a.PIT_ID =? ORDER BY NO_IK ASC
  //   ";
  //   $item_array = $dbmysql2->query($sql, $noip);

  //   $NO_SK = "";
  //   $TG_SK = "";
  //   $BERLAKU = "";
  //   $NAMA_PERUS ="";
  //   $PEMILIK = "";
  //   $ALAMAT_PEM ="";
  //   $ALAMAT_PER = "";
  //   $NO_IP = "";
  //   $BERLAKU = "";
  //   $KETERANGAN ="";
  //   $PIT_ID = "";

  //   foreach ($item_array->result() as $u) {
  //     $NO_SK =  $u->NO_SK;
  //     $TG_SK = $u->TG_SK;
  //     $BERLAKU = $u->BERLAKU;
  //     $NAMA_PERUS = $u->NAMA_PERUS;
  //     $PEMILIK = $u->PEMILIK;
  //     $ALAMAT_PEM = $u->ALAMAT_PEM;
  //     $ALAMAT_PER = $u->ALAMAT_PER;
  //     $NO_IP = $u->NO_IP;
  //     $BERLAKU =$u->BERLAKU;
  //     $KETERANGAN = $u->KETERANGAN;
  //     $PIT_ID = $u->PIT_ID;
  //   }

  //   $file = str_replace(' ', '','SK_'.$noip);
  //   $lok = 'backoffice/assets/skbisbesar/';
  //   if(file_exists($lok.$file.'.pdf')){
	//     $data = file_get_contents($lok.$file.'.pdf');
	//     force_download('SK '.$NAMA_PERUS.' - '.tanggal_indo($BERLAKU).'.pdf', $data);
	//   }
  // }

  // function download_lamp($noip = NULL) {
  //   function tanggal_indo($tanggal)
  //   {
  //     $bulan = array (1 =>   'Januari',
  //           'Februari',
  //           'Maret',
  //           'April',
  //           'Mei',
  //           'Juni',
  //           'Juli',
  //           'Agustus',
  //           'September',
  //           'Oktober',
  //           'November',
  //           'Desember'
  //         );
  //     $split = explode('-', $tanggal);
  //     return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  //   }

  //   $dbmysql2 = $this->load->database('dbakdp',TRUE);

  //   $sql = "
  //   select 
  //   a.PIT_ID
  //   ,a.PEMILIK
  //   ,a.NO_IP
  //   ,a.BERLAKU
  //   ,a.KETERANGAN
  //   ,ALAMAT_PEM
  //   ,a.NO_SK 
  //   ,a.TG_SK
  //   ,a.NAMA_PERUS
  //   ,a.ALAMAT_PER
  //   ,b.NO_IK
  //   ,b.NO_MOBIL
  //   ,b.NO_UJI
  //   ,b.TAHUN_PEMB
  //   ,b.MERK
  //   ,b.DA_ORANG
  //   ,b.KP_ID
  //   ,b.BBM
  //   ,(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID) KODE_TRAYE
  //   ,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID)) NAMATRAYEK
  //   ,(SELECT TG_AKHIR from bb_kp where KP_ID = b.KP_ID) TG_AKHIR
  //   from bb_pit a
  //   inner join bb_mobil b
  //   on a.PIT_ID = b.PIT_ID
  //   where a.PIT_ID =? ORDER BY NO_IK ASC
  //   ";
  //   $item_array = $dbmysql2->query($sql, $noip);

  //   $NO_SK = "";
  //   $TG_SK = "";
  //   $BERLAKU = "";
  //   $NAMA_PERUS ="";
  //   $PEMILIK = "";
  //   $ALAMAT_PEM ="";
  //   $ALAMAT_PER = "";
  //   $NO_IP = "";
  //   $BERLAKU = "";
  //   $KETERANGAN ="";
  //   $PIT_ID = "";

  //   foreach ($item_array->result() as $u) {
  //     $NO_SK =  $u->NO_SK;
  //     $TG_SK = $u->TG_SK;
  //     $BERLAKU = $u->BERLAKU;
  //     $NAMA_PERUS = $u->NAMA_PERUS;
  //     $PEMILIK = $u->PEMILIK;
  //     $ALAMAT_PEM = $u->ALAMAT_PEM;
  //     $ALAMAT_PER = $u->ALAMAT_PER;
  //     $NO_IP = $u->NO_IP;
  //     $BERLAKU =$u->BERLAKU;
  //     $KETERANGAN = $u->KETERANGAN;
  //     $PIT_ID = $u->PIT_ID;
  //   }

  //   $file = str_replace(' ', '','DAFTAR_KENDARAAN_'.$noip);
  //   $lok = 'backoffice/assets/skbisbesar/';
  //   if(file_exists($lok.$file.'.pdf')){
  //       $data = file_get_contents($lok.$file.'.pdf');
  //       force_download('Lampiran SK '.$NAMA_PERUS.' - '.tanggal_indo($BERLAKU).'.pdf', $data);
  //     }
  // }
}
?>