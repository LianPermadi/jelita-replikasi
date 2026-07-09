<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Lib_date
 * This class created for helping take date data from mysql
 *
 * @author Dichi Al Faridi
 * Update : 01 Sep 2010 (By agusnur)
 *
 */
class Lib_date {
  private $lang;

  public function __construct() {
    $this->CI = & get_instance();
    if($this->CI->session->userdata('lang') === 'en') {
      $this->lang = "en";
    }else{
      $this->lang = "id";
    }
  }

  public function eselon($esl){
    $eselon = array(''   => '',
                    '1'  => 'Eselon I',
                    '2'  => 'Eselon II',
                    '3'  => 'Eselon III',
                    '4'  => 'Eselon IV',
                    '9'  => 'Pelaksana'
                   );
    if(!empty($eselon)){
      $data = $eselon[$esl];
    }else{
      $data = '-';
    }
   	return $data;
  }

  public function pangkat($gol){
    $pangkat = array(''     => '',
                     'IVe'  => 'Pembina Utama',
                     'IVd'  => 'Pembina Utama Madya',
                     'IVc'  => 'Pembina Utama Muda',
                     'IVb'  => 'Pembina Tingkat I',
                     'IVa'  => 'Pembina',
                     'IIId' => 'Penata Tingkat I',
                     'IIIc' => 'Penata',
                     'IIIb' => 'Penata Muda Tingkat I',
                     'IIIa' => 'Penata Muda',
                     'IId'  => 'Pengatur Tingkat I',
                     'IIc'  => 'Pengatur',
                     'IIb'  => 'Pengatur Muda Tingkat I',
                     'IIa'  => 'Pengatur Muda',
                     'Id'   => 'Juru Tingkat I',
                     'Ic'   => 'Juru',
                     'Ib'   => 'Juru Muda Tingkat I',
                     'Ia'   => 'Juru Muda',
                     'HL'   => 'Tenaga Kontrak'
                    );
   	return $pangkat[$gol];
  }

  private function get_date() {
    $this->year = substr($this->mysql_date, 0, 4);
    $this->month = substr($this->mysql_date, 5, 2);
    $this->date = substr($this->mysql_date, 8, 2);
  }
  
  public function get_day($date = NULL) {
    $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    list($yr, $mn, $dt) = explode('-', $date);
    $now = getdate(mktime(0, 0, 0, $mn, $dt, $yr));
    $i = $now['wday'];
    return $hari[$i];
  }
  
  public function tanggal_indo($tanggal){
    $split = array();
    $bulan = array (1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                   );
    $split = explode('-', $tanggal);
    if(isset($split[0]) && isset($split[1]) && isset($split[2])) {
    	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }else{
    	return "Tanggal belum diset.";
    }
  }
  
  public function get_datetime_now() {
    $date_now = date('Y-m-d G:i:s');
    return $date_now;
  }
  
  public function get_date_now($format=null) {
    $date_now = date('Y-m-d G:i:s');
    if($format != null){
      $date_now = date($format);	
    }  
    return $date_now;
  }
  
  public function set_date($date, $length = NULL) {
    if ($length === NULL) $length = 1;
    $day = 86400 * $length;
    $timestamp = strtotime($date);
    $date_value = date('Y-m-d', $timestamp + $day);
    return $date_value;
  }
  
  // Create PBS
  public function get_days($year = NULL, $month = NULL) {
    $tahun = $year;  //Inisialisasi tahun
    $bulan = $month; //Inisialisasi bulan
    $tanggal = 0;
    if($bulan == 0){ // jika 1 tahun
      for($i=1; $i < 12+1; $i++) { 
        $tgl = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
        $tanggal = $tanggal + $tgl;
      }
    }else{	
      $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    }
    return $tanggal;
  } 
  
  public function get_day_year($start_date = NULL, $tenor = NULL) {
  $tahun = 0;//$year;  //Inisialisasi tahun
  $bulan = 0;//$month; //Inisialisasi bulan
  $tanggal = 0;
  if($bulan == 0){
    for($i=1; $i < 12+1; $i++) { 
      //$tgl = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
      //$tanggal = $tanggal + $tgl;
    }
  }else{	
    //$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
  }
  return $tanggal;
  } 
    
  public function get_nama_ori($u_ser = NULL) {
    $user = new user();
    $user->where('username', $u_ser)->get();
    $r_name = $user->oriname;
    return $r_name;
  }
  
  public function hit_durasi($tgl_entry, $vdurasi) {  // mengambil hari terakhir selama vdurasi hari dari v_hari
    $vdurasi_cek = $vdurasi;
    $libur = new tmholiday();
    $i = 0;
    while ($i == 0){
      //$tgl_durasi = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);
      $tgl_durasi = $this->set_date($tgl_entry, $vdurasi_cek);
      $hari_libur = $libur->where('date >=', $tgl_entry)->where('date <=', $tgl_durasi)->count();
      If($vdurasi == $vdurasi_cek-$hari_libur){ // proses selesai
        $i = 1;
      }else{                                    // masih proses
        $vdurasi_cek = $vdurasi_cek + 1;
      }
    }
    return $vdurasi_cek;
  }
  
  public function post_variable($id, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10) {  // menyimpan variabel
    $username = new user();
    $username->where('id', $id)->get();
    if($username->where('id', $id)->count() >= 1){
      $username->gvar1 = $var1;
      $username->gvar2 = $var2;
      $username->gvar3 = $var3;
      $username->gvar4 = $var4;
      $username->gvar5 = $var5;
      $username->gvar6 = $var6;
      $username->gvar7 = $var7;
      $username->gvar8 = $var8;
      $username->gvar9 = $var9;
      $username->gvar10 = $var10;
      $username->save();
    }
    return;
  }
  
  public function lama_durasi($tgl_entry, $tgl_selesai) {  // mengambil banyaknya lama durasi
    if($tgl_selesai == '') {
      $lama_durasi = '-';
    }else{
      $libur = new tmholiday();
      $libur1 = $libur->where("date >= '$tgl_entry' and date <= '$tgl_selesai'")->count();
      
      // memecah string tanggal awal untuk mendapatkan tanggal, bulan, tahun
      $pecah1 = explode("-", $tgl_entry);
      $date1 = $pecah1[2];
      $month1 = $pecah1[1];
      $year1 = $pecah1[0];
      
      // memecah string tanggal akhir untuk mendapatkan tanggal, bulan, tahun
      $pecah2 = explode("-", $tgl_selesai);
      $date2 = $pecah2[2];
      $month2 = $pecah2[1];
      $year2 =  $pecah2[0];
      
      // mencari total selisih hari dari tanggal awal dan akhir
      $jd1 = GregorianToJD($month1, $date1, $year1);
      $jd2 = GregorianToJD($month2, $date2, $year2);
      
      $selisih = $jd2 - $jd1;
      
      // menghitung selisih hari yang bukan tanggal merah dan hari minggu
      $lama_durasi = $selisih-$libur1;
      if($tgl_entry == $tgl_selesai) {
        $lama_durasi = 1;
      }
    }
    return $lama_durasi;
  }
  
  public function jumlah_hari($tgl_entry, $tgl_selesai) {  // mengambil banyaknya hari
    if($tgl_selesai == '') {
      $lama_durasi = '-';
    }else{
      // memecah string tanggal awal untuk mendapatkan tanggal, bulan, tahun
      $pecah1 = explode("-", $tgl_entry);
      $date1 = $pecah1[2];
      $month1 = $pecah1[1];
      $year1 = $pecah1[0];
      
      // memecah string tanggal akhir untuk mendapatkan tanggal, bulan, tahun
      $pecah2 = explode("-", $tgl_selesai);
      $date2 = $pecah2[2];
      $month2 = $pecah2[1];
      $year2 =  $pecah2[0];
      
      // mencari total selisih hari dari tanggal awal dan akhir
      $jd1 = GregorianToJD($month1, $date1, $year1);
      $jd2 = GregorianToJD($month2, $date2, $year2);
      
      $selisih = $jd2 - $jd1;
      
      // menghitung selisih hari yang bukan tanggal merah dan hari minggu
      $lama_durasi = $selisih;
      if($tgl_entry == $tgl_selesai) {
        $lama_durasi = 1;
      }
    }
    return $lama_durasi;
  }
  // EOF() Create PBS

  public function set_month_roman($month = NULL) {
    switch ($month) {
      case '1' :
          $month_text = 'I';
          break;
      case '2' :
          $month_text = 'II';
          break;
      case '3' :
          $month_text = 'III';
          break;
      case '4' :
          $month_text = 'IV';
          break;
      case '5' :
          $month_text = 'V';
          break;
      case '6' :
          $month_text = 'VI';
          break;
      case '7' :
          $month_text = 'VII';
          break;
      case '8' :
          $month_text = 'VIII';
          break;
      case '9' :
          $month_text = 'IX';
          break;
      case '10' :
          $month_text = 'X';
          break;
      case '11' :
          $month_text = 'XI';
          break;
      case '12' :
      default :
          $month_text = 'XII';
          break;
    }
    return $month_text;
  }
  
  public function set_month_name($month = NULL, $lang = NULL) {
    if($lang === 'en') {
      switch ($month) {
        case '1' :
            $month_text = 'January';
            break;
        case '2' :
            $month_text = 'February';
            break;
        case '3' :
            $month_text = 'March';
            break;
        case '4' :
            $month_text = 'April';
            break;
        case '5' :
            $month_text = 'May';
            break;
        case '6' :
            $month_text = 'June';
            break;
        case '7' :
            $month_text = 'July';
            break;
        case '8' :
            $month_text = 'August';
            break;
        case '9' :
            $month_text = 'September';
            break;
        case '10' :
            $month_text = 'October';
            break;
        case '11' :
            $month_text = 'November';
            break;
        case '12' :
        default :
            $month_text = 'December';
            break;
      }
    }else if ($lang === "id") {
      switch ($month) {
        case '1' :
            $month_text = 'Januari';
            break;
        case '2' :
            $month_text = 'Februari';
            break;
        case '3' :
            $month_text = 'Maret';
            break;
        case '4' :
            $month_text = 'April';
            break;
        case '5' :
            $month_text = 'Mei';
            break;
        case '6' :
            $month_text = 'Juni';
            break;
        case '7' :
            $month_text = 'Juli';
            break;
        case '8' :
            $month_text = 'Agustus';
            break;
        case '9' :
            $month_text = 'September';
            break;
        case '10' :
            $month_text = 'Oktober';
            break;
        case '11' :
            $month_text = 'November';
            break;
        case '12' :
        default :
            $month_text = 'Desember';
            break;
      }
    }
    
    return $month_text;
  }
  
  public function set_month_tree($month = NULL) {
    switch ($month) {
      case '1' :
          $month_text = 'Jan';
          break;
      case '2' :
          $month_text = 'Feb';
          break;
      case '3' :
          $month_text = 'Mar';
          break;
      case '4' :
          $month_text = 'Apr';
          break;
      case '5' :
          $month_text = 'May';
          break;
      case '6' :
          $month_text = 'Jun';
          break;
      case '7' :
          $month_text = 'Jul';
          break;
      case '8' :
          $month_text = 'Aug';
          break;
      case '9' :
          $month_text = 'Sep';
          break;
      case '10' :
          $month_text = 'Okt';
          break;
      case '11' :
          $month_text = 'Nov';
          break;
      case '12' :
      default :
          $month_text = 'Des';
          break;
    }
    return $month_text;
  }
  
  function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
    	$temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
    	$temp = $this->penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
    	$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
    } else if ($nilai < 200) {
    	$temp = " seratus" . $this->penyebut($nilai - 100);
    } else if ($nilai < 1000) {
    	$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
    } else if ($nilai < 2000) {
    	$temp = " seribu" . $this->penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
    	$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
    	$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
    	$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
    	$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
  }
  
  function terbilang($nilai) {
    if($nilai<0) {
    	$hasil = "minus ". trim($this->penyebut($nilai));
    }else{
    	$hasil = trim($this->penyebut($nilai));
    }     		
    return ucfirst($hasil);
  }
  
  public function date_range($date_begin = NULL, $date_end = NULL) {
    if($this->lang === 'en') {
      $to = " to ";
    }else{
      $to = " sampai ";
    }
    
    $this->mysql_date = $date_begin;
    $this->get_date();
    
    $year_begin = $this->year;
    $month_begin = $this->month;
    $date_begin = $this->date;
    
    $this->mysql_date = $date_end;
    $this->get_date();
    
    $year_end = $this->year;
    $month_end = $this->month;
    $date_end = $this->date;
    
    if($date_begin === $date_end && $month_begin === $month_end && $year_begin === $year_end) {
      $date_range = $date_begin.' '.$this->set_month_name($month_begin, $this->lang).' '. $year_begin;
    }else
    if($date_begin !== $date_end && $month_begin === $month_end && $year_begin === $year_end) {
      $date_range = $date_begin.$to.$date_end.' '.$this->set_month_name($month_begin, $this->lang).' '.$year_begin;
    }else
    if($date_begin !== $date_end && $month_begin !== $month_end && $year_begin === $year_end) {
      $date_range = $date_begin.' '.$this->set_month_name($month_begin, $this->lang).$to . $date_end . ' ' .
                $this->set_month_name($month_end, $this->lang) . ' ' . $year_begin;
    }else{
      $date_range = $date_begin .' '. $this->set_month_name($month_begin, $this->lang) . ' ' .
                $year_begin . $to . $date_end . ' ' . $this->set_month_name($month_end, $this->lang) . ' ' . $year_end;
    }
    return $date_range;
  }
  
  public function mysql_to_human($mysql_date = NULL, $format = NULL, $lang = 'id') {
    $this->mysql_date = $mysql_date;
    $this->get_date();
    if($this->mysql_date === NULL || $this->mysql_date === '0000-00-00') {
      return "Tanggal belum diset.";
    }else
    if($format === NULL) {
      return $this->date . " " . $this->set_month_name($this->month, $lang) . " " . $this->year;
    }else
    if($format === 1) {
      return $this->date . "-" . $this->month . "-" . $this->year;
    }else{
      return $this->date . " " . $this->set_month_tree($this->month) . " " . $this->year;
    }
  }
  
  public function ambil_tanggal($mysql_date = NULL, $format = NULL, $lang = 'id') {
    $this->mysql_date = $mysql_date;
    $this->get_date();
    if($this->mysql_date === NULL || $this->mysql_date === '0000-00-00') {
      return "Tanggal belum diset.";
    }else{
      return $this->date;
    } 
  }

  public function ambil_bulan($mysql_date = NULL, $format = NULL, $lang = 'id') {
    $this->mysql_date = $mysql_date;
    $this->get_date();
    if($this->mysql_date === NULL || $this->mysql_date === '0000-00-00') {
      return "Tanggal belum diset.";
    }else
    if($format === NULL) {
      return $this->set_month_name($this->month, $lang);
    }else
    if($format === 1) {
      return $this->month;
    }else{
      return $this->set_month_tree($this->month);
    }
  }

  public function ambil_tahun($mysql_date = NULL, $format = NULL, $lang = 'id') {
    $this->mysql_date = $mysql_date;
    $this->get_date();
    if($this->mysql_date === NULL || $this->mysql_date === '0000-00-00') {
      return "Tanggal belum diset.";
    }else{
      return $this->year;
    } 
  }
  
  public function mysql_get_date($mysql_date = NULL, $type = NULL) {
    $this->mysql_date = $mysql_date;
    $this->get_date();
    if($type === 'date') {
      return $this->date;
    }else if ($type === 'month') {
      return $this->set_month_name($this->month, $this->lang);
    }else {
      return $this->year;
    }
  }
  
  //$besok = mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));         // cek besok = d + 1
  //$bulan_kemarin = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));  // bulan kemaren = m -1
  //$tahun_depan = mktime(0, 0, 0, date("m"), date("d"), date("Y")+1);    // tahun depan = Y + 1
  
  public function data_property($v_id = NULL, $pil = NULL) { // mengambil data properti dalam satu record {v_id=no_id_izin, pil = pilihan output}
    $i = 0;
    $n_var = "";
    $n_add = "";
    $property = new trperizinan();
    $property->where('id', $v_id)->get();
    switch($pil) {
      case 1: $kirim = $i; break;      // untuk jumlah
      case 2: $kirim = $n_var; break;  // ambil data nama variabel
      case 3: $kirim = $n_add; break;  // ambil var yang kosong
    }
    if($property->var_teknis1 !== '')   {$i++;$n_var=$property->var_teknis1; $n_add='1';} else return $kirim;
    if($property->var_teknis2 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis2; $n_add='2';}
    if($property->var_teknis3 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis3; $n_add='3';}
    if($property->var_teknis4 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis4; $n_add='4';}
    if($property->var_teknis5 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis5; $n_add='5';}
    if($property->var_teknis6 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis6; $n_add='6';}
    if($property->var_teknis7 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis7; $n_add='7';}
    if($property->var_teknis8 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis8; $n_add='8';}
    if($property->var_teknis9 !== '')   {$i++;$n_var=$n_var.",".$property->var_teknis9; $n_add='9';}
    if($property->var_teknis10 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis10; $n_add='10';}
    if($property->var_teknis11 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis11; $n_add='11';}
    if($property->var_teknis12 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis12; $n_add='12';}
    if($property->var_teknis13 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis13; $n_add='13';}
    if($property->var_teknis14 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis14; $n_add='14';}
    if($property->var_teknis15 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis15; $n_add='15';}
    if($property->var_teknis16 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis16; $n_add='16';}
    if($property->var_teknis17 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis17; $n_add='17';}
    if($property->var_teknis18 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis18; $n_add='18';}
    if($property->var_teknis19 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis19; $n_add='19';}
    if($property->var_teknis20 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis20; $n_add='20';}
    if($property->var_teknis21 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis21; $n_add='21';}
    if($property->var_teknis22 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis22; $n_add='22';}
    if($property->var_teknis23 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis23; $n_add='23';}
    if($property->var_teknis24 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis24; $n_add='24';}
    if($property->var_teknis25 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis25; $n_add='25';}
    if($property->var_teknis26 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis26; $n_add='26';}
    if($property->var_teknis27 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis27; $n_add='27';}
    if($property->var_teknis28 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis28; $n_add='28';}
    if($property->var_teknis29 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis29; $n_add='29';}
    if($property->var_teknis30 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis30; $n_add='30';}
    if($property->var_teknis31 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis31; $n_add='31';}
    if($property->var_teknis32 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis32; $n_add='32';}
    if($property->var_teknis33 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis33; $n_add='33';}
    if($property->var_teknis34 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis34; $n_add='34';}
    if($property->var_teknis35 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis35; $n_add='35';}
    if($property->var_teknis36 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis36; $n_add='36';}
    if($property->var_teknis37 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis37; $n_add='37';}
    if($property->var_teknis38 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis38; $n_add='38';}
    if($property->var_teknis39 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis39; $n_add='39';}
    if($property->var_teknis40 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis40; $n_add='40';}
    if($property->var_teknis41 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis41; $n_add='41';}
    if($property->var_teknis42 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis42; $n_add='42';}
    if($property->var_teknis43 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis43; $n_add='43';}
    if($property->var_teknis44 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis44; $n_add='44';}
    if($property->var_teknis45 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis45; $n_add='45';}
    if($property->var_teknis46 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis46; $n_add='46';}
    if($property->var_teknis47 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis47; $n_add='47';}
    if($property->var_teknis48 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis48; $n_add='48';}
    if($property->var_teknis49 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis49; $n_add='49';}
    if($property->var_teknis50 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis50; $n_add='50';}
    if($property->var_teknis51 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis51; $n_add='51';}
    if($property->var_teknis52 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis52; $n_add='52';}
    if($property->var_teknis53 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis53; $n_add='53';}
    if($property->var_teknis54 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis54; $n_add='54';}
    if($property->var_teknis55 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis55; $n_add='55';}
    if($property->var_teknis56 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis56; $n_add='56';}
    if($property->var_teknis57 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis57; $n_add='57';}
    if($property->var_teknis58 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis58; $n_add='58';}
    if($property->var_teknis59 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis59; $n_add='59';}
    if($property->var_teknis60 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis60; $n_add='60';}
    if($property->var_teknis61 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis61; $n_add='61';}
    if($property->var_teknis62 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis62; $n_add='62';}
    if($property->var_teknis63 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis63; $n_add='63';}
    if($property->var_teknis64 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis64; $n_add='64';}
    if($property->var_teknis65 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis65; $n_add='65';}
    if($property->var_teknis66 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis66; $n_add='66';}
    if($property->var_teknis67 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis67; $n_add='67';}
    if($property->var_teknis68 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis68; $n_add='68';}
    if($property->var_teknis69 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis69; $n_add='69';}
    if($property->var_teknis70 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis70; $n_add='70';}
    if($property->var_teknis71 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis71; $n_add='71';}
    if($property->var_teknis72 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis72; $n_add='72';}
    if($property->var_teknis73 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis73; $n_add='73';}
    if($property->var_teknis74 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis74; $n_add='74';}
    if($property->var_teknis75 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis75; $n_add='75';}
    if($property->var_teknis76 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis76; $n_add='76';}
    if($property->var_teknis77 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis77; $n_add='77';}
    if($property->var_teknis78 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis78; $n_add='78';}
    if($property->var_teknis79 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis79; $n_add='79';}
    if($property->var_teknis80 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis80; $n_add='80';}
    if($property->var_teknis81 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis81; $n_add='81';}
    if($property->var_teknis82 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis82; $n_add='82';}
    if($property->var_teknis83 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis83; $n_add='83';}
    if($property->var_teknis84 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis84; $n_add='84';}
    if($property->var_teknis85 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis85; $n_add='85';}
    if($property->var_teknis86 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis86; $n_add='86';}
    if($property->var_teknis87 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis87; $n_add='87';}
    if($property->var_teknis88 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis88; $n_add='88';}
    if($property->var_teknis89 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis89; $n_add='89';}
    if($property->var_teknis90 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis90; $n_add='90';}
    if($property->var_teknis91 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis91; $n_add='91';}
    if($property->var_teknis92 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis92; $n_add='92';}
    if($property->var_teknis93 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis93; $n_add='93';}
    if($property->var_teknis94 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis94; $n_add='94';}
    if($property->var_teknis95 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis95; $n_add='95';}
    if($property->var_teknis96 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis96; $n_add='96';}
    if($property->var_teknis97 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis97; $n_add='97';}
    if($property->var_teknis98 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis98; $n_add='98';}
    if($property->var_teknis99 !== '')  {$i++;$n_var=$n_var.",".$property->var_teknis99; $n_add='99';}
    if($property->var_teknis100 !== '') {$i++;$n_var=$n_var.",".$property->var_teknis100; $n_add='100';}
    
    //Proses Sort  posisi betul tetapi saat edit dan simpan menimpa property yang sudah ada
    //		if($pil == '2'){
    //            $a = 0;
    //	        $list = explode (",",$n_var);
    //            while ($a < $i) {
    //                $urutan = $this->array_property('4' ,$list[$a]);
    //			    if($a == 0) {
    //                    $opsi_koefisien = array($urutan => $list[$a]);
    //			        $opsi_urutan = array($a+1 => $urutan);
    //                } else {
    //                    $tempArray = array($urutan => $list[$a]);
    //			        $urutanArray = array($a+1 => $urutan);
    //                    $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
    //			        $opsi_urutan = array_merge ($opsi_urutan, $urutanArray);
    //                }
    //		        $a++;
    //            }
    //            foreach($opsi_urutan as $id=>$urut) {
    //			    if($id == 0) {
    //                    $n_var = $opsi_koefisien[$urut-1];
    //			    } else {
    //                    $n_var = $n_var.",".$opsi_koefisien[$urut-1];
    //			    }
    //            }
    //		}
    //EOF Sort
    
    $kirim = "";
    switch ($pil) {
      case 1: $kirim = $i; break;      // untuk jumlah
      case 2: $kirim = $n_var; break;  // ambil data nama variabel
      case 3: $kirim = $n_add; break;  // ambil var yang kosong
    }
    return $kirim;
  }

  public function field_property($v_id = NULL, $var = NULL, $pil = NULL) { // mengambil data properti per field {v_id=no_id_izin, var=nomor filed, pil = pilihan output}
    $property = new trperizinan();
    $property->where('id', $v_id)->get();
    $nilai = '';
    $nama = '';
    switch($var) {
      case 1:   $nilai = $property->var_teknis1;   $nama = 'var_teknis1';  break;      
      case 2:   $nilai = $property->var_teknis2;   $nama = 'var_teknis2';  break;      
      case 3:   $nilai = $property->var_teknis3;   $nama = 'var_teknis3';  break;
      case 4:   $nilai = $property->var_teknis4;   $nama = 'var_teknis4';  break;
      case 5:   $nilai = $property->var_teknis5;   $nama = 'var_teknis5';  break;
      case 6:   $nilai = $property->var_teknis6;   $nama = 'var_teknis6';  break;
      case 7:   $nilai = $property->var_teknis7;   $nama = 'var_teknis7';  break;
      case 8:   $nilai = $property->var_teknis8;   $nama = 'var_teknis8';  break;
      case 9:   $nilai = $property->var_teknis9;   $nama = 'var_teknis9';  break;
      case 10:  $nilai = $property->var_teknis10;  $nama = 'var_teknis10'; break;
      case 11:  $nilai = $property->var_teknis11;  $nama = 'var_teknis11'; break;
      case 12:  $nilai = $property->var_teknis12;  $nama = 'var_teknis12'; break;
      case 13:  $nilai = $property->var_teknis13;  $nama = 'var_teknis13'; break;
      case 14:  $nilai = $property->var_teknis14;  $nama = 'var_teknis14'; break;
      case 15:  $nilai = $property->var_teknis15;  $nama = 'var_teknis15'; break;
      case 16:  $nilai = $property->var_teknis16;  $nama = 'var_teknis16'; break;
      case 17:  $nilai = $property->var_teknis17;  $nama = 'var_teknis17'; break;
      case 18:  $nilai = $property->var_teknis18;  $nama = 'var_teknis18'; break;
      case 19:  $nilai = $property->var_teknis19;  $nama = 'var_teknis19'; break;
      case 20:  $nilai = $property->var_teknis20;  $nama = 'var_teknis20'; break;
      case 21:  $nilai = $property->var_teknis21;  $nama = 'var_teknis21'; break;
      case 22:  $nilai = $property->var_teknis22;  $nama = 'var_teknis22'; break;
      case 23:  $nilai = $property->var_teknis23;  $nama = 'var_teknis23'; break;
      case 24:  $nilai = $property->var_teknis24;  $nama = 'var_teknis24'; break;
      case 25:  $nilai = $property->var_teknis25;  $nama = 'var_teknis25'; break;
      case 26:  $nilai = $property->var_teknis26;  $nama = 'var_teknis26'; break;
      case 27:  $nilai = $property->var_teknis27;  $nama = 'var_teknis27'; break;
      case 28:  $nilai = $property->var_teknis28;  $nama = 'var_teknis28'; break;
      case 29:  $nilai = $property->var_teknis29;  $nama = 'var_teknis29'; break;
      case 30:  $nilai = $property->var_teknis30;  $nama = 'var_teknis30'; break;
      case 31:  $nilai = $property->var_teknis31;  $nama = 'var_teknis31'; break;
      case 32:  $nilai = $property->var_teknis32;  $nama = 'var_teknis32'; break;
      case 33:  $nilai = $property->var_teknis33;  $nama = 'var_teknis33'; break;
      case 34:  $nilai = $property->var_teknis34;  $nama = 'var_teknis34'; break;
      case 35:  $nilai = $property->var_teknis35;  $nama = 'var_teknis35'; break;
      case 36:  $nilai = $property->var_teknis36;  $nama = 'var_teknis36'; break;
      case 37:  $nilai = $property->var_teknis37;  $nama = 'var_teknis37'; break;
      case 38:  $nilai = $property->var_teknis38;  $nama = 'var_teknis38'; break;
      case 39:  $nilai = $property->var_teknis39;  $nama = 'var_teknis39'; break;
      case 40:  $nilai = $property->var_teknis40;  $nama = 'var_teknis40'; break;
      case 41:  $nilai = $property->var_teknis41;  $nama = 'var_teknis41'; break;
      case 42:  $nilai = $property->var_teknis42;  $nama = 'var_teknis42'; break;
      case 43:  $nilai = $property->var_teknis43;  $nama = 'var_teknis43'; break;
      case 44:  $nilai = $property->var_teknis44;  $nama = 'var_teknis44'; break;
      case 45:  $nilai = $property->var_teknis45;  $nama = 'var_teknis45'; break;
      case 46:  $nilai = $property->var_teknis46;  $nama = 'var_teknis46'; break;
      case 47:  $nilai = $property->var_teknis47;  $nama = 'var_teknis47'; break;
      case 48:  $nilai = $property->var_teknis48;  $nama = 'var_teknis48'; break;
      case 49:  $nilai = $property->var_teknis49;  $nama = 'var_teknis49'; break;
      case 50:  $nilai = $property->var_teknis50;  $nama = 'var_teknis50'; break;
      case 51:  $nilai = $property->var_teknis51;  $nama = 'var_teknis51'; break;
      case 52:  $nilai = $property->var_teknis52;  $nama = 'var_teknis52'; break;
      case 53:  $nilai = $property->var_teknis53;  $nama = 'var_teknis53'; break;
      case 54:  $nilai = $property->var_teknis54;  $nama = 'var_teknis54'; break;
      case 55:  $nilai = $property->var_teknis55;  $nama = 'var_teknis55'; break;
      case 56:  $nilai = $property->var_teknis56;  $nama = 'var_teknis56'; break;
      case 57:  $nilai = $property->var_teknis57;  $nama = 'var_teknis57'; break;
      case 58:  $nilai = $property->var_teknis58;  $nama = 'var_teknis58'; break;
      case 59:  $nilai = $property->var_teknis59;  $nama = 'var_teknis59'; break;
      case 60:  $nilai = $property->var_teknis60;  $nama = 'var_teknis60'; break;
      case 61:  $nilai = $property->var_teknis61;  $nama = 'var_teknis61'; break;
      case 62:  $nilai = $property->var_teknis62;  $nama = 'var_teknis62'; break;
      case 63:  $nilai = $property->var_teknis63;  $nama = 'var_teknis63'; break;
      case 64:  $nilai = $property->var_teknis64;  $nama = 'var_teknis64'; break;
      case 65:  $nilai = $property->var_teknis65;  $nama = 'var_teknis65'; break;
      case 66:  $nilai = $property->var_teknis66;  $nama = 'var_teknis66'; break;
      case 67:  $nilai = $property->var_teknis67;  $nama = 'var_teknis67'; break;
      case 68:  $nilai = $property->var_teknis68;  $nama = 'var_teknis68'; break;
      case 69:  $nilai = $property->var_teknis69;  $nama = 'var_teknis69'; break;
      case 70:  $nilai = $property->var_teknis70;  $nama = 'var_teknis70'; break;
      case 71:  $nilai = $property->var_teknis71;  $nama = 'var_teknis71'; break;
      case 72:  $nilai = $property->var_teknis72;  $nama = 'var_teknis72'; break;
      case 73:  $nilai = $property->var_teknis73;  $nama = 'var_teknis73'; break;
      case 74:  $nilai = $property->var_teknis74;  $nama = 'var_teknis74'; break;
      case 75:  $nilai = $property->var_teknis75;  $nama = 'var_teknis75'; break;
      case 76:  $nilai = $property->var_teknis76;  $nama = 'var_teknis76'; break;
      case 77:  $nilai = $property->var_teknis77;  $nama = 'var_teknis77'; break;
      case 78:  $nilai = $property->var_teknis78;  $nama = 'var_teknis78'; break;
      case 79:  $nilai = $property->var_teknis79;  $nama = 'var_teknis79'; break;
      case 80:  $nilai = $property->var_teknis80;  $nama = 'var_teknis80'; break;
      case 81:  $nilai = $property->var_teknis81;  $nama = 'var_teknis81'; break;
      case 82:  $nilai = $property->var_teknis82;  $nama = 'var_teknis82'; break;
      case 83:  $nilai = $property->var_teknis83;  $nama = 'var_teknis83'; break;
      case 84:  $nilai = $property->var_teknis84;  $nama = 'var_teknis84'; break;
      case 85:  $nilai = $property->var_teknis85;  $nama = 'var_teknis85'; break;
      case 86:  $nilai = $property->var_teknis86;  $nama = 'var_teknis86'; break;
      case 87:  $nilai = $property->var_teknis87;  $nama = 'var_teknis87'; break;
      case 88:  $nilai = $property->var_teknis88;  $nama = 'var_teknis88'; break;
      case 89:  $nilai = $property->var_teknis89;  $nama = 'var_teknis89'; break;
      case 90:  $nilai = $property->var_teknis90;  $nama = 'var_teknis90'; break;
      case 91:  $nilai = $property->var_teknis91;  $nama = 'var_teknis91'; break;
      case 92:  $nilai = $property->var_teknis92;  $nama = 'var_teknis92'; break;
      case 93:  $nilai = $property->var_teknis93;  $nama = 'var_teknis93'; break;
      case 94:  $nilai = $property->var_teknis94;  $nama = 'var_teknis94'; break;
      case 95:  $nilai = $property->var_teknis95;  $nama = 'var_teknis95'; break;
      case 96:  $nilai = $property->var_teknis96;  $nama = 'var_teknis96'; break;
      case 97:  $nilai = $property->var_teknis97;  $nama = 'var_teknis97'; break;
      case 98:  $nilai = $property->var_teknis98;  $nama = 'var_teknis98'; break;
      case 99:  $nilai = $property->var_teknis99;  $nama = 'var_teknis99'; break;
      case 100: $nilai = $property->var_teknis100; $nama = 'var_teknis100'; break;
    }
    switch($pil) {
      case 1: $kirim = $nilai; break;      // ambil nilai variabel
      case 2: $kirim = $nama; break;       // ambil nama variabel
    }
    return $kirim;
  }

  public function isi_property($v_id = NULL, $var = NULL, $pil = NULL) { // mengambil isi properti per field {v_id=no_id_permohonan, var=nomor field, pil = pilihan output}
    $property = new tmpermohonan();
    $property->where('id', $v_id)->get();
    $nilai = '';
    $nama = '';
    switch($var) {
      case 1:   $nilai = $property->dt_teknis1;   $nama = 'dt_teknis1';  break;      
      case 2:   $nilai = $property->dt_teknis2;   $nama = 'dt_teknis2';  break;      
      case 3:   $nilai = $property->dt_teknis3;   $nama = 'dt_teknis3';  break;
      case 4:   $nilai = $property->dt_teknis4;   $nama = 'dt_teknis4';  break;
      case 5:   $nilai = $property->dt_teknis5;   $nama = 'dt_teknis5';  break;
      case 6:   $nilai = $property->dt_teknis6;   $nama = 'dt_teknis6';  break;
      case 7:   $nilai = $property->dt_teknis7;   $nama = 'dt_teknis7';  break;
      case 8:   $nilai = $property->dt_teknis8;   $nama = 'dt_teknis8';  break;
      case 9:   $nilai = $property->dt_teknis9;   $nama = 'dt_teknis9';  break;
      case 10:  $nilai = $property->dt_teknis10;  $nama = 'dt_teknis10'; break;
      case 11:  $nilai = $property->dt_teknis11;  $nama = 'dt_teknis11'; break;
      case 12:  $nilai = $property->dt_teknis12;  $nama = 'dt_teknis12'; break;
      case 13:  $nilai = $property->dt_teknis13;  $nama = 'dt_teknis13'; break;
      case 14:  $nilai = $property->dt_teknis14;  $nama = 'dt_teknis14'; break;
      case 15:  $nilai = $property->dt_teknis15;  $nama = 'dt_teknis15'; break;
      case 16:  $nilai = $property->dt_teknis16;  $nama = 'dt_teknis16'; break;
      case 17:  $nilai = $property->dt_teknis17;  $nama = 'dt_teknis17'; break;
      case 18:  $nilai = $property->dt_teknis18;  $nama = 'dt_teknis18'; break;
      case 19:  $nilai = $property->dt_teknis19;  $nama = 'dt_teknis19'; break;
      case 20:  $nilai = $property->dt_teknis20;  $nama = 'dt_teknis20'; break;
      case 21:  $nilai = $property->dt_teknis21;  $nama = 'dt_teknis21'; break;
      case 22:  $nilai = $property->dt_teknis22;  $nama = 'dt_teknis22'; break;
      case 23:  $nilai = $property->dt_teknis23;  $nama = 'dt_teknis23'; break;
      case 24:  $nilai = $property->dt_teknis24;  $nama = 'dt_teknis24'; break;
      case 25:  $nilai = $property->dt_teknis25;  $nama = 'dt_teknis25'; break;
      case 26:  $nilai = $property->dt_teknis26;  $nama = 'dt_teknis26'; break;
      case 27:  $nilai = $property->dt_teknis27;  $nama = 'dt_teknis27'; break;
      case 28:  $nilai = $property->dt_teknis28;  $nama = 'dt_teknis28'; break;
      case 29:  $nilai = $property->dt_teknis29;  $nama = 'dt_teknis29'; break;
      case 30:  $nilai = $property->dt_teknis30;  $nama = 'dt_teknis30'; break;
      case 31:  $nilai = $property->dt_teknis31;  $nama = 'dt_teknis31'; break;
      case 32:  $nilai = $property->dt_teknis32;  $nama = 'dt_teknis32'; break;
      case 33:  $nilai = $property->dt_teknis33;  $nama = 'dt_teknis33'; break;
      case 34:  $nilai = $property->dt_teknis34;  $nama = 'dt_teknis34'; break;
      case 35:  $nilai = $property->dt_teknis35;  $nama = 'dt_teknis35'; break;
      case 36:  $nilai = $property->dt_teknis36;  $nama = 'dt_teknis36'; break;
      case 37:  $nilai = $property->dt_teknis37;  $nama = 'dt_teknis37'; break;
      case 38:  $nilai = $property->dt_teknis38;  $nama = 'dt_teknis38'; break;
      case 39:  $nilai = $property->dt_teknis39;  $nama = 'dt_teknis39'; break;
      case 40:  $nilai = $property->dt_teknis40;  $nama = 'dt_teknis40'; break;
      case 41:  $nilai = $property->dt_teknis41;  $nama = 'dt_teknis41'; break;
      case 42:  $nilai = $property->dt_teknis42;  $nama = 'dt_teknis42'; break;
      case 43:  $nilai = $property->dt_teknis43;  $nama = 'dt_teknis43'; break;
      case 44:  $nilai = $property->dt_teknis44;  $nama = 'dt_teknis44'; break;
      case 45:  $nilai = $property->dt_teknis45;  $nama = 'dt_teknis45'; break;
      case 46:  $nilai = $property->dt_teknis46;  $nama = 'dt_teknis46'; break;
      case 47:  $nilai = $property->dt_teknis47;  $nama = 'dt_teknis47'; break;
      case 48:  $nilai = $property->dt_teknis48;  $nama = 'dt_teknis48'; break;
      case 49:  $nilai = $property->dt_teknis49;  $nama = 'dt_teknis49'; break;
      case 50:  $nilai = $property->dt_teknis50;  $nama = 'dt_teknis50'; break;
      case 51:  $nilai = $property->dt_teknis51;  $nama = 'dt_teknis51'; break;
      case 52:  $nilai = $property->dt_teknis52;  $nama = 'dt_teknis52'; break;
      case 53:  $nilai = $property->dt_teknis53;  $nama = 'dt_teknis53'; break;
      case 54:  $nilai = $property->dt_teknis54;  $nama = 'dt_teknis54'; break;
      case 55:  $nilai = $property->dt_teknis55;  $nama = 'dt_teknis55'; break;
      case 56:  $nilai = $property->dt_teknis56;  $nama = 'dt_teknis56'; break;
      case 57:  $nilai = $property->dt_teknis57;  $nama = 'dt_teknis57'; break;
      case 58:  $nilai = $property->dt_teknis58;  $nama = 'dt_teknis58'; break;
      case 59:  $nilai = $property->dt_teknis59;  $nama = 'dt_teknis59'; break;
      case 60:  $nilai = $property->dt_teknis60;  $nama = 'dt_teknis60'; break;
      case 61:  $nilai = $property->dt_teknis61;  $nama = 'dt_teknis61'; break;
      case 62:  $nilai = $property->dt_teknis62;  $nama = 'dt_teknis62'; break;
      case 63:  $nilai = $property->dt_teknis63;  $nama = 'dt_teknis63'; break;
      case 64:  $nilai = $property->dt_teknis64;  $nama = 'dt_teknis64'; break;
      case 65:  $nilai = $property->dt_teknis65;  $nama = 'dt_teknis65'; break;
      case 66:  $nilai = $property->dt_teknis66;  $nama = 'dt_teknis66'; break;
      case 67:  $nilai = $property->dt_teknis67;  $nama = 'dt_teknis67'; break;
      case 68:  $nilai = $property->dt_teknis68;  $nama = 'dt_teknis68'; break;
      case 69:  $nilai = $property->dt_teknis69;  $nama = 'dt_teknis69'; break;
      case 70:  $nilai = $property->dt_teknis70;  $nama = 'dt_teknis70'; break;
      case 71:  $nilai = $property->dt_teknis71;  $nama = 'dt_teknis71'; break;
      case 72:  $nilai = $property->dt_teknis72;  $nama = 'dt_teknis72'; break;
      case 73:  $nilai = $property->dt_teknis73;  $nama = 'dt_teknis73'; break;
      case 74:  $nilai = $property->dt_teknis74;  $nama = 'dt_teknis74'; break;
      case 75:  $nilai = $property->dt_teknis75;  $nama = 'dt_teknis75'; break;
      case 76:  $nilai = $property->dt_teknis76;  $nama = 'dt_teknis76'; break;
      case 77:  $nilai = $property->dt_teknis77;  $nama = 'dt_teknis77'; break;
      case 78:  $nilai = $property->dt_teknis78;  $nama = 'dt_teknis78'; break;
      case 79:  $nilai = $property->dt_teknis79;  $nama = 'dt_teknis79'; break;
      case 80:  $nilai = $property->dt_teknis80;  $nama = 'dt_teknis80'; break;
      case 81:  $nilai = $property->dt_teknis81;  $nama = 'dt_teknis81'; break;
      case 82:  $nilai = $property->dt_teknis82;  $nama = 'dt_teknis82'; break;
      case 83:  $nilai = $property->dt_teknis83;  $nama = 'dt_teknis83'; break;
      case 84:  $nilai = $property->dt_teknis84;  $nama = 'dt_teknis84'; break;
      case 85:  $nilai = $property->dt_teknis85;  $nama = 'dt_teknis85'; break;
      case 86:  $nilai = $property->dt_teknis86;  $nama = 'dt_teknis86'; break;
      case 87:  $nilai = $property->dt_teknis87;  $nama = 'dt_teknis87'; break;
      case 88:  $nilai = $property->dt_teknis88;  $nama = 'dt_teknis88'; break;
      case 89:  $nilai = $property->dt_teknis89;  $nama = 'dt_teknis89'; break;
      case 90:  $nilai = $property->dt_teknis90;  $nama = 'dt_teknis90'; break;
      case 91:  $nilai = $property->dt_teknis91;  $nama = 'dt_teknis91'; break;
      case 92:  $nilai = $property->dt_teknis92;  $nama = 'dt_teknis92'; break;
      case 93:  $nilai = $property->dt_teknis93;  $nama = 'dt_teknis93'; break;
      case 94:  $nilai = $property->dt_teknis94;  $nama = 'dt_teknis94'; break;
      case 95:  $nilai = $property->dt_teknis95;  $nama = 'dt_teknis95'; break;
      case 96:  $nilai = $property->dt_teknis96;  $nama = 'dt_teknis96'; break;
      case 97:  $nilai = $property->dt_teknis97;  $nama = 'dt_teknis97'; break;
      case 98:  $nilai = $property->dt_teknis98;  $nama = 'dt_teknis98'; break;
      case 99:  $nilai = $property->dt_teknis99;  $nama = 'dt_teknis99'; break;
      case 100: $nilai = $property->dt_teknis100; $nama = 'dt_teknis100'; break;
    }
    switch ($pil) {
      case 1: $kirim = $nilai; break;                                         // ambil nilai variabel awal dan akhir
      case 2: $kirim = $nama; break;                                          // ambil nama variabel
      case 3: 
              if(strpos($nilai,"^") == ''){                                   // ambil nilai variabel awal
                $kirim = str_replace('^', '', $nilai);
      	      }else{
      	        $kirim = substr($nilai,0,strpos($nilai,'^'));
      	      }
              break;      
      case 4:                                                                 // ambil nilai variabel akhir
              $kirim = substr($nilai,strpos($nilai,'^')+0,strlen($nilai));         
              break;
      case 5:                                                                 // ambil nilai variabel dg cek akhir atau awal mana yg terisi
              $kirim = substr($nilai,strpos($nilai,'^')+0,strlen($nilai)); 
    	        if($kirim == ''){
                $kirim = substr($nilai,0,strpos($nilai,'^'));
    	        }
    	        break; 
    }
    return $kirim;
  }

  public function array_property($no_arr = NULL, $val_combo = NULL) {  // mengambil isi dari field var_texnisX untuk dijadikan array {no_arr=no_array_diambil, val_combo = isi combo}
    if($val_combo){
      $hitung = strlen($val_combo);
      $cek_posisi = strpos($val_combo,'^'); 
      $a = 1;
      while($a < 50) {
        $item_combo = substr($val_combo,0,$cek_posisi);
        $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
        $hitung = strlen($val_combo);
        $cek_posisi = strpos($val_combo,'^');
        if($a == 1) {
          $opsi_koefisien = array($a => $item_combo);
        }else{
          $tempArray = array( $a => $item_combo);
          $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
        }
        if($cek_posisi == "") {
          $a = $a + 1;
          $tempArray = array( $a => $val_combo);
          $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
          $a = 51;
        }
        $a = $a + 1;
      }
    }
    return $opsi_koefisien[$no_arr];
  }

  public function sort_property($id_izin = NULL, $text = NULL) {  // mengambubah urutan isi array {id_izin = no id perizinan, text}
    $a = 0;
    $i = $this->data_property($id_izin, '1');  // mengambil jumlah
    $list = explode (",",$text);
    $coba = $list[0];
    while($a < $i) {
      $b = 0;
      $ambil = 0;
      while($b < $i) {
        $isiurut = $this->array_property('4' ,$list[$b]);
        if($a+1 == $isiurut) $ambil = $b;
        $b++;
      }
      $urutan = $this->array_property('4' ,$list[$ambil]); //ambil no urut
      if($a == 0) {
        $opsi_koefisien = array($urutan => $list[$ambil]);
        $opsi_urutan = array($a+1 => $urutan);
      }else{
        $tempArray = array($urutan => $list[$ambil]);
        $urutanArray = array($a+1 => $urutan);
        $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
        $opsi_urutan = array_merge ($opsi_urutan, $urutanArray);
      }
      $a++;
    }
    foreach($opsi_urutan as $id=>$urut) {
      if($id == 0) {
        $n_var = $opsi_koefisien[$urut-1];
      }else{
        $n_var = $n_var.",".$opsi_koefisien[$urut-1];
      }
    }
    return $n_var;
  }

  public function all_property($id_izin=NULL, $id_daftar=NULL) {  // Mengambil seluruh data properti (judul+isinya) result 'propertyname1#conten1^propertyname2#conten2'
    $konten = '';
    $jml_property = $this->data_property($id_izin,'1');
    $stat_property = TRUE;
    $text = $this->data_property($id_izin,'2');
    if($jml_property > 1) { $text = $this->sort_property($id_izin, $text); }
    $list = explode (",",$text);
    foreach ($list as $data) {
      $nm_var = 'vdt_teknis'.$this->array_property('0',$data);  // Nomor Variabel
      $property_aktif = $this->array_property('11',$data);      // Aktifasi Property
      $data_property = $this->isi_property($id_daftar, $this->array_property('0',$data), '4');
      $property_type = $this->array_property('9',$data);     // Type Property
      if($property_type == 'ComboBox'){
        $val_combo = $this->array_property('10',$data);    // Isi Pilihan ComboBox
        if($val_combo){
          $hitung = strlen($val_combo);
          $cek_posisi = strpos($val_combo,';');
          $a = 1;
          while($a < 50) {
            $item_combo = substr($val_combo,0,$cek_posisi);
            $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
            $hitung = strlen($val_combo);
            $cek_posisi = strpos($val_combo,';');
            if($a == 1) {
              $opsi_koefisien = array($item_combo => $item_combo);
            }else{
              $tempArray = array( $item_combo => $item_combo);
              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
            }
            if($cek_posisi == "") {
              $a = $a + 1;
              $tempArray = array( $val_combo => $val_combo);
              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
              $a = 51;
            }
            $a = $a + 1;
          }
        }
        $opsi_koefisien = '';
      }
      if($property_aktif == 'Ya') {
        $n_data = $this->array_property('1',$data);   // Nama Property
        if($data_property == "") {
          $isi_data = '-';
        }else{
          if($property_type == 'Tanggal') {
            $isi_data = $this->mysql_to_human($data_property);
          }else{
            $isi_data = $data_property;
          }
        }
        $konten = $konten .'^'. $n_data .'#'. $isi_data;
      }
    }
    $konten = substr($konten,1);
    return $konten;
  }
  
  // Mengambil seluruh data nama variabel properti dalam bentuk array $pil -> 'var':varname 'isi':isi var 'mix':campuran
  public function all_data_property($id_izin=NULL, $id_daftar=NULL, $pil=NULL) { 
    $konten = '';
    $var_property = '';
    $isi_property = '';
    $jml_property = $this->data_property($id_izin,'1');
    $stat_property = TRUE;
    $text = $this->data_property($id_izin,'2');
    if($jml_property > 1) { $text = $this->sort_property($id_izin, $text); }
    $list = explode (",",$text);
    foreach ($list as $data) {
      $nm_var = 'vdt_teknis'.$this->array_property('0',$data);  // Nomor Variabel
      $property_aktif = $this->array_property('11',$data);      // Aktifasi Property
      $data_property = $this->isi_property($id_daftar, $this->array_property('0',$data), '4');
      $property_type = $this->array_property('9',$data);     // Type Property
      if($property_type == 'ComboBox'){
        $val_combo = $this->array_property('10',$data);    // Isi Pilihan ComboBox
        if($val_combo){
          $hitung = strlen($val_combo);
          $cek_posisi = strpos($val_combo,';');
          $a = 1;
          while($a < 50) {
            $item_combo = substr($val_combo,0,$cek_posisi);
            $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
            $hitung = strlen($val_combo);
            $cek_posisi = strpos($val_combo,';');
            if($a == 1) {
              $opsi_koefisien = array($item_combo => $item_combo);
            }else{
              $tempArray = array( $item_combo => $item_combo);
              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
            }
            if($cek_posisi == "") {
              $a = $a + 1;
              $tempArray = array( $val_combo => $val_combo);
              $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
              $a = 51;
            }
            $a = $a + 1;
          }
        }
        $opsi_koefisien = '';
      }
      if($property_aktif == 'Ya') {
        $n_data = $this->array_property('1',$data);   // Nama Property
        if($data_property == "") {
          $isi_data = '-';
        }else{
          if($property_type == 'Tanggal') {
            $isi_data = $this->mysql_to_human($data_property);
          }else{
            $isi_data = $data_property;
          }
        }
        $var_property .= $n_data .'^';                        // menyimpan nama variabel property keseluruhan
        $isi_property .= str_replace('^', '',$isi_data).'^';  // menyimpan isi property keseluruhan
      }
    }
    switch ($pil) {
      case 'var': // kirim nama variabel property keseluruhan dalam array
                  // contoh a = array('buah1','buah2','buah3')
                  $konten = explode ("^",substr($var_property,0,-1));
                  break;
      case 'isi': // kirim isi property keseluruhan dalam array
                  // contoh b = array('pepaya','mangga','pisang') 
                  $konten = explode ("^",substr($isi_property,0,-1));
                  break;
      case 'mix': // kirim gabungan variabel + isi property keseluruhan dalam array
                  // contoh ab = array('buah1'=>'pepaya','buah2'=>'mangga','buah3'=>'pisang')
                  $konten = array_combine(explode ("^",substr($var_property,0,-1)), explode ("^",substr($isi_property,0,-1)));
                  break;      
      default   : // kirim array kosong
                  $konten = array();
                  break;
    }
    return $konten;
  }

  public function jmlpermohonan($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLPERMOHONAN 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." LIMIT 1";
    $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
// var_dump(query($sql, array($id, $tglawal, $tglakhir)));die();

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLPERMOHONAN;
        }
    }
    // var_dump($sql);die();
    return $jml;

  }

  public function jmltolakfo($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLTOLAKFO
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Ditolak FO' LIMIT 1";
    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLTOLAKFO;
        }
    }

    return $jml;

  }

  public function jmlsetujui($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLSETUJUI 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Disetujui' LIMIT 1";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLSETUJUI;
        }
    }

    return $jml;

  }

  public function jmlsetujuiambil($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLSETUJUIAMBIL 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Disetujui' AND E.d_ambil_izin IS NOT NULL LIMIT 1";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLSETUJUIAMBIL;
        }
    }

    return $jml;

  }

  public function jmlsetujuiblmambil($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLSETUJUIBLMAMBIL 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Disetujui' AND E.d_ambil_izin IS NULL LIMIT 1";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLSETUJUIBLMAMBIL;
        }
    }

    return $jml;

  }

  public function jmltolak($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLTOLAK 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Ditolak' LIMIT 1";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLTOLAK;
        }
    }

    return $jml;

  }

  public function jmlproses($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLPROSES 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'proses' LIMIT 1";

    $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLPROSES;
        }
    }

    return $jml;

  }

  public function jmlsesuai($tipe, $kategori, $id, $tglawal, $tglakhir) {
    $this->CI->load->database();
    $jml = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "A.id = ?";
    } else { //perizinan
        $val = "C.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(I.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(E.d_terima_berkas_asli BETWEEN ? AND ?) AND (I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT A.id, A.n_sektor, COUNT(DISTINCT(E.pendaftaran_id)) AS JMLSESUAI 
        FROM trsektor A 
        LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
        LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
        LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
        LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
        LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
        LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
        LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
        LEFT JOIN tmsk I ON H.tmsk_id = I.id
        WHERE ".$val." AND ".$valfil." AND E.status_berkas = 'Izin Disetujui' AND E.d_selesai_proses > I.tgl_surat_edit LIMIT 1";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }

    if (!empty($result)) {
        foreach ($result as $row) {
            $jml = $row->JMLSESUAI;
        }
    }

    return $jml;

  }

  public function rataproses($tipe, $kategori, $id, $tglawal, $tglakhir, $v_hari, $jumlah_terbit = 0) {
    $this->CI->load->database();
    $realisasi = 0;
    $rata = 0;
    $totrealisasi = 0;

    if ($tipe == 1) { //1 = Sektor
        $val = "e.id = ?";
    } else { //perizinan
        $val = "a.id = ?";
    }

    switch($kategori){
        case 0: // untuk tanggal terima Berkas
            $valfil = "(b.d_terima_berkas_asli BETWEEN ? AND ?)";
          break;
        case 1: // untuk tanggal selesai
            $valfil = "(c.tgl_surat_edit BETWEEN ? AND ?)";
          break;
        case 2: // untuk tanggal terima Berkas dan tanggal selesai
            $valfil = "(b.d_terima_berkas_asli BETWEEN ? AND ?) AND (c.tgl_surat_edit >= ? AND c.tgl_surat_edit <= ?)";
          break;
      }

    $sql = "SELECT a.id, c.tgl_surat_edit, c.tgl_surat, b.d_terima_berkas, b.d_terima_berkas_asli
            FROM trperizinan a
            LEFT JOIN trperizinan_trsektor d ON a.id = d.trperizinan_id
            LEFT JOIN trsektor e ON d.trsektor_id = e.id
            LEFT JOIN tmpermohonan_trperizinan f ON a.id = f.trperizinan_id
            LEFT JOIN tmpermohonan b ON f.tmpermohonan_id = b.id
            LEFT JOIN tmpermohonan_tmsk g ON b.id = g.tmpermohonan_id
            LEFT JOIN tmsk c ON g.tmsk_id = c.id
            WHERE ".$val." AND ".$valfil." AND b.status_berkas = 'Izin Disetujui'";

    if ($kategori == 2) {
        $qtgl = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $qtgl = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }
  
    foreach ($qtgl as $rows) {
        if (!empty($rows->d_terima_berkas_asli)) {
            $tanggal1 = $rows->d_terima_berkas_asli;
        } else {
            $tanggal1 = $rows->d_terima_berkas;
        }

        if (!empty($rows->tgl_surat_edit)) {
            $tanggal2 = $rows->tgl_surat_edit;
        } else {
            $tanggal2 = $rows->tgl_surat;
        }

        //----------------holiday---------------------------------------
        $qholiday="select count(date) libur from tmholiday where date between '$tanggal1' and '$tanggal2'";
        $exeholiday = mysql_query($qholiday);
        while($rowholiday = mysql_fetch_assoc($exeholiday)){
            $holidayperizin = $rowholiday['libur'];
            $date1 = new DateTime($tanggal2); 
            $date2 = new DateTime($tanggal1); 
            $interval = $date2->diff($date1);
            $selisihhari = $interval->format('%a');
            //$sharilibur = substr($selisihhari, 1,5);
            if($tanggal2 == "0000-00-00"){
                $realisasi = $v_hari;
            }else{
                $realisasi = $selisihhari - $holidayperizin;
            }

            $totrealisasi+=$realisasi;
        }
    }

    if ($jumlah_terbit !=0 && round($totrealisasi) == 0) {
        $rata = 1;
    } else {
        if ($jumlah_terbit == 0 || $totrealisasi == 0) {
            $rata = 0;
        } else {
            $rata = $totrealisasi / $jumlah_terbit;
        }
    }

    if (round($rata) == 0 && $jumlah_terbit > 0) {
        $rata = 1;
    }

    return $rata;
    
  }

  public function list_data_rekap($tipe, $id, $state, $kategori, $tglawal, $tglakhir, $jenis_jumlah) {
    $this->CI->load->database();
    $jml = 0;
    $pilihan = 0;

    if ($tipe == 0) { //1 = Sektor
        $val = "A.id = ? ";
    } else { //perizinan
        $val = "C.id = ? ";
    }

    if ($state != 0) {
      $val_state = "AND E.kd_gerai = ? AND ";
    } else {
      $val_state = "AND ";
    }

    if ($kategori == 1) {
      $val_kat = "I.tgl_surat_edit";
    } else {
      $val_kat = "E.d_terima_berkas_asli";
    }

      if ($kategori == 2) {
    	$pilihan = 1;
    }

    switch($jenis_jumlah){
      case 1:  $val_jumlah = ""; $val_mohon = "JUMLAH PERMOHONAN"; $val_kat2 = ""; break;
      case 2:  $val_jumlah = " AND E.status_berkas = 'Izin Ditolak FO'"; $val_mohon = "IZIN DITOLAK FRONT OFFICE"; ($pilihan == 1 ? $val_kat2 = " AND I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?" : $val_kat2 = ""); break;
      case 3:  $val_jumlah = " AND E.status_berkas = 'Izin Disetujui'"; $val_mohon = "JUMLAH IZIN DESETUJUI"; ($pilihan == 1 ? $val_kat2 = " AND I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?" : $val_kat2 = ""); break;
      case 4:  $val_jumlah = " AND (E.status_berkas = 'Izin Disetujui' AND E.d_ambil_izin IS NOT NULL)"; ($pilihan == 1 ? $val_kat2 = " AND I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?" : $val_kat2 = ""); $val_mohon = "IZIN DISETUJUI DIAMBIL"; break;
      case 5:  $val_jumlah = " AND (E.status_berkas = 'Izin Disetujui' AND E.d_ambil_izin IS NULL)"; $val_mohon = "IZIN DISETUJUI BELUM DIAMBIL"; ($pilihan == 1 ? $val_kat2 = " AND I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?" : $val_kat2 = ""); break;
      case 6:  $val_jumlah = " AND E.status_berkas = 'Izin Ditolak'"; $val_mohon = "JUMLAH IZIN DITOLAK"; ($pilihan == 1 ? $val_kat2 = " AND I.tgl_surat_edit >= ? AND I.tgl_surat_edit <= ?" : $val_kat2 = ""); break;
      case 7:  $val_jumlah = ($kategori != 2 ? " AND E.status_berkas = 'proses'" : ""); $val_mohon = ($kategori != 2 ? "JUMLAH DALAM PROSES" : "JUMLAH MELEBIHI PERIODE"); $val_kat2 = ""; break;
    }

    $sql = "SELECT DISTINCT E.id AS tmpermohonan_id, E.pendaftaran_id, E.kd_status, E.desc_arsip, E.nama_file, K.n_pemohon, M.n_perusahaan, E.kd_gerai, E.d_terima_berkas_asli, E.d_selesai_proses, E.c_izin_selesai, I.tgl_penetapan, I.tgl_surat_edit, C.n_perizinan, E.a_izin, E.d_berlaku_izin, E.status_berkas, A.n_sektor, O.id AS id_trkel 
		FROM trsektor A 
		LEFT JOIN trperizinan_trsektor B ON A.id = B.trsektor_id 
		LEFT JOIN trperizinan C ON B.trperizinan_id = C.id 
		LEFT JOIN tmpermohonan_trperizinan D ON C.id = D.trperizinan_id 
		LEFT JOIN tmpermohonan E ON D.tmpermohonan_id = E.id 
		LEFT JOIN tmpermohonan_trstspermohonan F ON E.id = F.tmpermohonan_id 
		LEFT JOIN trstspermohonan G ON F.trstspermohonan_id = G.id 
		LEFT JOIN tmpermohonan_tmsk H ON E.id = H.tmpermohonan_id 
		LEFT JOIN tmsk I ON H.tmsk_id = I.id 
		LEFT JOIN tmpemohon_tmpermohonan J ON E.id = J.tmpermohonan_id 
		LEFT JOIN tmpemohon K ON J.tmpemohon_id = K.id
		LEFT JOIN tmpermohonan_tmperusahaan L ON E.id = L.tmpermohonan_id
		LEFT JOIN tmperusahaan M ON L.tmperusahaan_id = M.id
		LEFT JOIN trkelompok_perizinan_trperizinan N ON C.id = N.trperizinan_id
		LEFT JOIN trkelompok_perizinan O ON N.trkelompok_perizinan_id = O.id
		WHERE ".$val.$val_state."(".$val_kat." BETWEEN ? AND ?)".$val_jumlah.$val_kat2." GROUP BY E.pendaftaran_id";

    if ($kategori == 2) {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir, $tglawal, $tglakhir))->result();
    } else {
        $result = $this->CI->db->query($sql, array($id, $tglawal, $tglakhir))->result();
    }
    // var_dump($sql);die();
    return $result;

  }

  public function statNotif($id) {
    $this->CI->load->database();
    $notif = $this->CI->db->get_where('tmpermohonan_notif_log', array('tmpermohonan_id' => $id))->first_row();
    if (!empty($notif)) {
        return true;
    } else {
        return false;
    }
  }

  public function statBk($resi) {
    $this->CI->load->database();
    $notif = $this->CI->db->get_where('akdp_cetak', array('pendaftaran_id' => $resi))->first_row();
    if (!empty($notif)) {
        return true;
    } else {
        return false;
    }
  }

  public function get_esl2_byizin($id_izin = NULL) {
  	$pendaftaran = new tmpermohonan();
    $u_daftar = $pendaftaran->get_by_id($id_izin);
    $p_pemohon = $u_daftar->trperizinan->get();
    $dinas_pengelola = $p_pemohon->dinas_pengelola;
    $this->CI->load->database();
    $notif = $this->CI->db->select('id,nik,n_pegawai,n_jabatan,nip')
                  ->from('tmpegawai')
                  ->where('tmpegawai.status', '1')                      // Penandatangan SK
                  ->where('tmpegawai.unitkerja_id', $dinas_pengelola)   // 
                  ->get()
                  ->row();
    if(!$notif){
      $xnotif = Array('1'=>'-','2'=>'-','3'=>'-','4'=>'-','5'=>'-');
    }else{
      $xnotif = Array('1'=>$notif->id,'2'=>$notif->nik,'3'=>$notif->n_pegawai,'4'=>$notif->n_jabatan,'5'=>$notif->nip);
    }
    return $xnotif;
  }

  public function opd_pengelola($unit_pengelola=null) {
    $tmpegawai_user = new tmpegawai_user();
    $tmpegawai_user->where('user_id', $this->CI->session->userdata('id_auth'))->get();
    $tmpegawai_trunitkerja = new tmpegawai_trunitkerja();
    $tmpegawai_trunitkerja->where('tmpegawai_id', $tmpegawai_user->tmpegawai_id)->get();
    if($tmpegawai_trunitkerja->trunitkerja_id == $unit_pengelola){
      $status = TRUE;	
    }else{
      $status = FALSE;	
    }
    //$status = $tmpegawai_trunitkerja->trunitkerja_id .' = '.$unit_pengelola;
    return $status;
  }

  public function unitKerjaUser($unit_pengelola=null) {
    $tmpegawai_user = new tmpegawai_user();
    $tmpegawai_user->where('user_id', $this->CI->session->userdata('id_auth'))->get();
    $tmpegawai_trunitkerja = new tmpegawai_trunitkerja();
    $tmpegawai_trunitkerja->where('tmpegawai_id', $tmpegawai_user->tmpegawai_id)->get();
    
    //$status = $tmpegawai_trunitkerja->trunitkerja_id .' = '.$unit_pengelola;
    return $tmpegawai_trunitkerja->trunitkerja_id;
  }

  public function view_title($text=null) {
  	$pegawai = new tmpegawai();
	  $pegawai->where('id', $this->CI->session->userdata('id_pegawai'))->get();
	  $peg_tgl = substr($pegawai->nip, 6, 2);
	  $peg_bln = substr($pegawai->nip, 4, 2);
	  $peg_thn = substr($pegawai->nip, 0, 4);
	  $id_peg = $this->get_date_now('d-m');
    echo '<font size="4">';
    echo '<b>';
    echo '  <span style="color: Blue">';
    echo '    &nbsp'.$text.' ';
    echo '  </span>';
    //if($pegawai->id == 64){
      if(strlen($pegawai->nip) >= 8){
    	  $ultah= $peg_tgl.'-'.$peg_bln.'-'.$peg_thn;
    	  $tanggal_date = new DateTime($ultah);
        $ultah = $tanggal_date->format('d-m');
    	  if($id_peg == $ultah) {
    	  	echo '<br><span style="color: Green; animation: blink 1s infinite;">';
    	  	echo '&nbsp'.'Selamat Ulang Tahun '.$this->CI->session->userdata('realname'),', Semoga Sehat dan Sukses Selalu';
          echo '</span>';
        }
      }
    //}
    echo '  </span>';
    echo '</b>';
    echo '</font>';
    //simpan log modul per user
    //if($pegawai->id == 64){
      // $id_user = $this->CI->session->userdata('id_auth');
      // $log_modul = new log_modul(); // load API models 
	    // $log_modul->where('id_user', $id_user)->where('nm_modul', $text)->get();
	    // $jml_akses = 1;
	    // if($log_modul->id != null){
	    // 	$jml_akses = $log_modul->jml_akses + 1;
	    // }	
      // $log_modul->id_user = $id_user;
      // $log_modul->nm_modul = $text;
      // $log_modul->tgl_akses = $this->get_date_now();
      // $log_modul->tgl_history = $log_modul->tgl_history.','.$this->get_date_now();
      // $log_modul->jml_akses = $jml_akses;
      // $log_modul->save();
    //}
    //EOF() simpan log modul per user
    return;
  }
    
  //Informasi Status Pencabutan
  Public function view_sts_cabut($idizin=null,$pendaftaran_id=null,$asal_menu=null){
  	$trperizinan = new trperizinan();
    $trperizinan->where('id',$idizin)->get();
    if($trperizinan->id_jenis_permohonan == 5){ //khusus pencabutan
    	$tmpermohonan = new tmpermohonan();
      $tmpermohonan->where('pendaftaran_id',$pendaftaran_id)->get();
      if($tmpermohonan->id){ // jika ada
        $dt_dicabut = new tmpermohonan();
        $dt_dicabut->where('pendaftaran_id', $tmpermohonan->id_lama)->get();
        if($dt_dicabut->id){ // jika ada
        	$img_cabut = array('src' => base_url().'assets/images/icon/check.png',
                             'alt' => 'Lihat Detail Resi '.$dt_dicabut->pendaftaran_id,
                             'title' => 'Lihat Detail Resi '.$dt_dicabut->pendaftaran_id,
                             'border' => '0',
                            );
          echo '<b><span style="color: Green">'.'Akan Mencabut No Resi : '.$dt_dicabut->pendaftaran_id.'</span></b>';
          echo '<b><span style="color: Green">'.' [Resi Ditemukan] '.'</span></b>';
          echo anchor(site_url('arsip/edit') .'/L/'.$dt_dicabut->id.'/'.$asal_menu, img($img_cabut))."&nbsp;";
        }else{               // jika tidak ada
          echo '<b><span style="color: Red">'.'No Resi : '.$dt_dicabut->pendaftaran_id.'</span></b>';
          echo '<b><span style="color: Red">'.' Tidak Ditemukan'.'</span></b>';		
        }
        echo '<br>';
      }  
    }
    return;
  }  
  //EOF() Informasi Status Pencabutan
  
  //cek user dengan izin yang akan di cabut
  Public function sts_pencabutan($idizin=null,$pendaftaran_id=null){
  	$lokasi_user = $this->CI->session->userdata('lokasi');
    $recall_status = TRUE;
    $trperizinan = new trperizinan();
    $trperizinan->where('id',$idizin)->get();
    if($trperizinan->id_jenis_permohonan == 5 && $lokasi_user === 'OPD Teknis'){ 
      $tmpermohonan = new tmpermohonan();
      $tmpermohonan->where('pendaftaran_id',$pendaftaran_id)->get();
      if($tmpermohonan->id){ // jika ada
      	$dt_dicabut = new tmpermohonan();
        $dt_dicabut->where('pendaftaran_id', $tmpermohonan->id_lama)->get();
        $p_izin_dicabut = $dt_dicabut->trperizinan->get();
        $id_izin_dicabut = $p_izin_dicabut->id;
        $trperizinan_user = new trperizinan_user();
        $trperizinan_user->where('user_id',$this->CI->session->userdata('id_auth'))->where('trperizinan_id',$id_izin_dicabut)->get();
        $recall_status = FALSE;
        if($trperizinan_user->id){
          $recall_status = TRUE;
        }
      } 
    }
    return $recall_status;
  }
  //EOF() cek user dengan izin yang akan di cabut
  
  //Akhir Status izin di cabut
  Public function real_status($id=null){
  	$tmpermohonan = new tmpermohonan();
    $tmpermohonan->where('id',$id)->get();
  	switch($tmpermohonan->c_izin_dicabut){
      case 1  : echo '<br><span style="color: Red"><b>Dalam Proses Pencabutan</b></span>'; break;
      case 2  : echo '<br><span style="color: Red"><b>Izin Telah Dicabut</b></span>'; break;
      default : echo ''; break;
    }
    return;
  }
  //EOF() Akhir Status izin di cabut

      function formatNomorTelepon($n_hp) {
          // Menghapus karakter selain angka
          $n_hp = preg_replace('/\D/', '', $n_hp);

          // Tentukan kode negara Indonesia
          $kode_negara_indonesia = '62';

          // Cek awalan nomor
          if (substr($n_hp, 0, 1) == '+') {
              $n_hp = substr($n_hp, 1);  // Menghapus tanda "+"
          } elseif (substr($n_hp, 0, 1) == '0') {
              $n_hp = $kode_negara_indonesia . substr($n_hp, 1);  // Mengganti '0' dengan '62'
          } elseif (substr($n_hp, 0, 2) == '62') { 
              // Jika sudah dalam format Indonesia, biarkan
          } else {
              $n_hp = $kode_negara_indonesia . $n_hp;  // Menambahkan kode negara Indonesia
          }

          // Periksa dan pastikan nomor memiliki panjang yang valid
          if (strlen($n_hp) < 9) {
              return false;
          }

          return $n_hp;
      }

  public function postWaSms($n_hp = null, $n_pesan = null, $campaign = null){ // jika dikirim dari Backoffice
    return true;
  }

  // public function postWaSms2($n_hp=null, $n_pesan=null, $campaign=null){
  //   // Membangun kueri
  //   $this->CI->load->database();
  //   $query = $this->CI->db->select('status')
  //                 ->from('db_sicantik_backoffice.settings')
  //                 ->where('name', 'smsGateway')                                    
  //                 ->get()->row();
  //   $statsms = $query->status;
  //   if($statsms == '1'){
  //     $receiver = $n_hp;
  //     $message = $n_pesan;
  //     $url = 'http://103.122.5.111/new/public/messaging/request/T8eDNwF8nw';

  //     // Prepare data array for JSON
  //     $data = ['sender' => 'DPMPTSP JBR',
  //              'msisdn' => $receiver,
  //              'message' => $message,
  //              "campaign" => $campaign
  //             ];

  //     // Encode data array to JSON
  //     $json_data = json_encode($data);

  //     // Initialize cURL session
  //     $ch = curl_init();

  //     // Set cURL options
  //     curl_setopt($ch, CURLOPT_URL, $url);
  //     curl_setopt($ch, CURLOPT_POST, 1);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
  //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //     // Execute cURL session
  //     $response = curl_exec($ch);

  //     // Close cURL session
  //     curl_close($ch);

  //     // Check for errors and handle response
  //     if($response === false){
  //       echo "Error: " . curl_error($ch);
  //       die;
  //     }else{
  //       $json = json_decode($response);
  //       if($json === null && json_last_error() !== JSON_ERROR_NONE){
  //         // Penanganan kesalahan jika gagal dalam mendekode JSON
  //         echo "Error dalam mendekode JSON: " . json_last_error_msg();
  //         return false;
  //       }
  //       if(isset($json->status) && $json->status == "200"){
  //         $result = TRUE;
  //         return $result;
  //       }else{
  //         $result = FALSE;
  //         //echo "Ada Yang Error Kirim SMS: " . $json->message . " " . $json->status;
  //         return $result;
  //         // die;
  //       }
  //     }
  //   }
  //   return;
  // }

  public function postWaSms2($n_hp=null, $n_pesan=null, $campaign=null){
    // Membangun kueri
      return true;
    }

  public function cetak_pemohon_wa($n_hp=null, $n_pesan=null, $campaign=null){

  }
}