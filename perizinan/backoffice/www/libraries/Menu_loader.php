<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  * Description of Menu_loader class
  * Use this class to applicated your module here.
  * @author  Dichi Al Faridi @since 1.0
  * @edit PBS : 16-04-2015
*/
class Menu_loader {

  public function __construct(){
    $this->ci = &get_instance();
  }
  
  public function set_menu($module_name = NULL, $title = NULL,  $css_class = NULL){
    $structure = NULL;
    if($module_name !== NULL || $module_name !== '')
      if($css_class === NULL) {
        $structure = "<li><a href='" . site_url($module_name) . "'>" . $title . "</a></li>";
      }else{
        $structure = "<li class='" . $css_class . "'><a href='" . site_url($module_name) . "'>" . $title . "</a></li>";
      }
    return $structure;
  }
  
  public function install(){
    $menu = NULL;
    $menu .= "<li class='dir'>";
    $menu .= "  MASTER";
    $menu .= "  <ul>";
    $menu .= "    <li class='first'></li>";
    $menu .=      $this->set_menu('role', 'Setting Peran');
    $menu .=      $this->set_menu('pengguna', 'Setting Pengguna');
    $menu .=      $this->set_menu('install', 'Konfigurasi');
    $menu .= "    <li class='last'></li>";
    $menu .= "  </ul>";
    $menu .= "</li>";
    return $menu;
  }
  
  public function create_menu($list_role = NULL, $opd = NULL,$user_role = NULL, $role_instansi, $level = NULL, $status_login = NULL){
    // $id_user = $this->session->userdata('id_auth');
    $menu = NULL;
    $admin = FALSE;
    $setting_perizinan = FALSE;
    $setting_sk = FALSE;
    $setting_umum = FALSE;
    $setting_user = FALSE;
    $setting_wilayah = FALSE;
    $keamanan_data = FALSE;
    $pendaftaran = FALSE;
    $pendataan = FALSE;
    $tim_teknis = FALSE;
    $penetapan = FALSE;
    $penomoran = FALSE;
    $customer_service = FALSE;
    $perpanjangan = FALSE;
    $retribusi = FALSE;
    $penyerahan = FALSE;
    $pengarsipan = FALSE;
    $pengaduan = FALSE;
    $monitoring = FALSE;

    $laporan = FALSE;
    $penadatangan = FALSE;
    $suratkeluar = FALSE;
    $penjadualan_sp = FALSE;
    $bisbesar = FALSE;
    $pengenalimpor = FALSE;
    $komitmen_oss = FALSE;
    $persuratan = FALSE;
    $tembusan_arsip_ins_lain = FALSE;
    $timeline = FALSE;
    $bukutamu = FALSE;
    $ruangan = FALSE;
    $admin_ruangan = FALSE;
    $pajak = FALSE;
    $jdih = FALSE;
    $investasi = FALSE;
    $pengembangan = FALSE;
    $inputtkk = FALSE;
    $trackingspj = FALSE;
    $datakabkota = FALSE;
    //$permintaanbarang = FALSE;
    $pengelola_barang = FALSE;
    $barang = FALSE;
    $anpeg = FALSE;
    $perdin = FALSE;
    $spperdin = FALSE;
    

    $pengawas_mobil = FALSE;
    $pengelolamobil = FALSE;
    $pengelola_aset = FALSE;
    $rekapperdin = FALSE;
    $motionadmin = FALSE;
    $kegiatandpa = FALSE;
    $nib = FALSE;
    $callcenter = FALSE;
    $aspri = FALSE;
    $pengolah_data = FALSE;
    $event_wjis = FALSE;
    $survei = FALSE;
    $lkpm = FALSE;
    $CmsInvestasi = FALSE;
    $skm = FALSE;
    
    
    $sprinter = array('src' => base_url() . 'assets/images/icon/sprinter.png', 'border' => '0');
    foreach ($list_role as $list) {
      switch ($list->id_role) {
        case '1':
            $setting_perizinan = TRUE;
            break;
        case '2':
            $setting_sk = TRUE;
            break;
        case '3':
            $setting_umum = TRUE;
            break;
        case '4':
            $setting_user = TRUE;
            break;
        case '5':
            $setting_wilayah = TRUE;
            break;
        case '6':
            $keamanan_data = TRUE;
            break;
        case '7':
            $tembusan_arsip_ins_lain = TRUE;
            break;
        case '8':
            $monitoring = TRUE;
            break;
        case '9':
            $pendaftaran = TRUE;
            break;
        case '10':
            $laporan = TRUE;
            break;
        case '11':
            $pendataan = TRUE;
            break;
        case '12':
            $tim_teknis = TRUE;
            break;
        case '13':
            $penetapan = TRUE;
            $perpanjangan = TRUE;
            break;
        case '14':
            $pengaduan = TRUE;
            break;
        case '15':
            $penyerahan = TRUE;
            break;
        case '16':
            $retribusi = TRUE;
            break;
        case '17':
            $customer_service = TRUE;
            break;
        case '18':
            $admin = TRUE;
            break;
        case '19':
            $penomoran = TRUE;
            break;
        case '21':
            $pengarsipan = TRUE;
            break;
        case '26':
            $penadatangan = TRUE;
            break;
        case '28':
            $penjadualan_sp = TRUE;
            break;
        case '29':
            $suratkeluar = TRUE;
            break;
        case '30':
            $bisbesar = TRUE;
            break;
        case '31':
            $pengenalimpor = TRUE;
            break;
        case '32':
            $persuratan = TRUE;
            break;
        case '33':
            $komitmen_oss = TRUE;
            break;
        case '34':
            $timeline = TRUE;
            break;
        case '35':
            $ruangan = TRUE;
            break;
        case '36':
            $bukutamu = TRUE;
            break;
        case '37':
            $pajak = TRUE;
            break;
        case '38':
            $investasi = TRUE;
            break;
        case '39':
            $jdih = TRUE;
            break;
        case '40':
            $pengembangan = TRUE;
            break;
        case '41':
            $inputtkk = TRUE;
            break;
        case '42':
            $trackingspj = TRUE;
            break;
        case '43':
            $datakabkota = TRUE;
            break;
        case '44':
            $pengelola_barang = TRUE;
            break;
        case '45':
            //$pengelolabarang = TRUE;
            break;
        case '46':
            $perdin = TRUE;
            break;
        case '47':
            $barang = TRUE;
            break;
        case '48':
            $anpeg = TRUE;
            break;
        case '50':
            $pengawas_mobil = TRUE;
            break;
        case '49':
            $pengelolamobil = TRUE;
            break;
        case '51':
            $rekapperdin = TRUE;
            break;
        case '52':
            $motionadmin = TRUE;
            break;
        case '53':
            $kegiatandpa = TRUE;
            break;
        case '54':
            $nib = TRUE;
            break;
        case '55':
            $callcenter = TRUE;
            break;
        case '56':
            $aspri = TRUE;
            break;
        case '57':
            $pengolah_data = TRUE;
            break;
        case '58':
            $event_wjis = TRUE;
            break;
        case '59':    
            $pengelola_aset = TRUE;
            break;
        case '60':    
            $admin_ruangan = TRUE;
            break;
        case '61':    
            $survei = TRUE;
            break;
        case '62':    
            $lkpm = TRUE;
            break;
        case '63':
            $spperdin = TRUE;
            break;
        case '64':
            $CmsInvestasi = TRUE;
            break;      
        case '65':
            $skm = TRUE;
            break;      
        case '99':
            $menu .= "<li class='dir'>";
            $menu .= "  API MAINTAINER";
            $menu .= "  <ul>";
            $menu .= "    <li class='first'></li>";
            $menu .=      $this->set_menu('api/maintainer', 'API');
            $menu .= "    <li class='last'></li>";
            $menu .= "  </ul>";
            $menu .= "</li>";
            break;
        case '100':
            $menu .= "<li class='dir'>";
            $menu .= "  MASTER";
            $menu .= "  <ul>";
            $menu .= "    <li class='first'></li>";
            $menu .=      $this->set_menu('role', 'Setting Peran');
            $menu .=      $this->set_menu('pengguna', 'Setting Pengguna');
            $menu .= "    <li class='last'></li>";
            $menu .= "  </ul>";
            $menu .= "</li>";
            break;
      }
    }
    
    $khusus_wjis = FALSE;

    if(!$monitoring && $event_wjis){ // khusus tim BI untuk WJIS pilih non Monitoring tetapi event_monitoring
      $khusus_wjis = TRUE;
      $menu .= "<li class='dir'>";
      $menu .= "  MONITORING";
      $menu .= "  <ul>";
      $menu .= "    <li class='first'></li>";
      $menu .=        $this->set_menu('monitoring/wjisguest', 'Tamu WJIS');
      $menu .= "    <li class='last'></li>";
      $menu .= "  </ul>";
      $menu .= "</li>";

    }else{

      if($CmsInvestasi){ // untuk Content Management System Investasi-jabar
        $menu .= "<li class='dir'>";
        $menu .= "Content Management System ";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        
        // Menu utama ke Cms Investasi Jabar, berisi submenu
        $menu .= "      <li class='dir'> Investasi Jabar";
        $menu .= "        <ul>";
        $menu .= "          <li class='first'></li>";
        $menu .=            $this->set_menu('monitoring/CmsInvestasi/beranda', 'beranda');
        $menu .=            $this->set_menu('monitoring/CmsInvestasi/project', 'project');
        $menu .=            $this->set_menu('monitoring/CmsInvestasi/contact', 'contact');
        $menu .=            $this->set_menu('monitoring/CmsInvestasi/news', 'berita ');
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "      </li>";
    
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
    }
    
      // Menu KONFIGURASI
      if($setting_perizinan || $setting_sk || $setting_umum || $setting_user || $setting_wilayah || $keamanan_data){
        $menu .= "<li class='dir'>";
        $menu .= "  KONFIGURASI ";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        if($setting_perizinan) {
          $menu .= "  <li class='dir'>Setting Perizinan";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('perizinan', 'Jenis Perizinan');
          $menu .=        $this->set_menu('perizinan/paralel', 'Perizinan Paralel');
          $menu .=        $this->set_menu('perizinan/persyaratanizin', 'Persyaratan Izin');
          $menu .=        $this->set_menu('property/master', 'Property Pendataan');
          $menu .=        $this->set_menu('retribusi', 'Retribusi Izin');
          $menu .=        $this->set_menu('perizinan/koefisientarif', 'Koefisien Tarif');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($setting_sk) {
          $menu .= "  <li class='dir'>Setting Naskah Izin";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('permohonan_sartek', 'Permohonan Saran Teknis');
          $menu .=        $this->set_menu('dasarhukum', 'Dasar Hukum Surat');
          $menu .=        $this->set_menu('ketetapan', 'Ketentuan Surat');
          $menu .=        $this->set_menu('menimbang', 'Menimbang SK');
          $menu .=        $this->set_menu('mengingat', 'Mengingat SK');
          $menu .=        $this->set_menu('memperhatikan', 'Memperhatikan');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        $menu .= "  <li class='dir'>Setting Umum";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        $menu .= "      <li class='dir'> TOOLS";
        $menu .= "        <ul>";
        $menu .= "          <li class='first'></li>";
        if($admin) {
          $menu .=            $this->set_menu('settings/tools/index_sql', 'Export Excel Tools');
          $menu .=            $this->set_menu('settings/webservice/cronjob', 'PESTA');
        }
          $menu .=            $this->set_menu('settings/ravina/', 'Ravina AI');
          $menu .=            $this->set_menu('settings/tools/qr', 'QR Code');
          $menu .=            $this->set_menu('settings/tools/short', 'Short URL');
          $menu .=            $this->set_menu('settings/tools/number', 'Converter Nomor to Huruf');
          $menu .=            $this->set_menu('settings/tools/snake', 'Char');
        if($setting_umum) {
          $menu .=            $this->set_menu('settings/tools/', 'List Short Admin');
        }
          $menu .= "        <li class='last'></li>";
          $menu .= "      </ul>";
        $menu .= "      </li>";
        //$menu .=        $this->set_menu('log/log_user', 'Aktivitas Saya');
        if($setting_umum) {
          $menu .=        $this->set_menu('header_instansi', 'Instansi');
          $menu .=        $this->set_menu('holiday', 'Hari Libur');
          $menu .=        $this->set_menu('settings/bidang', 'Bidang Perizinan');
          $menu .=        $this->set_menu('perusahaan/kegiatan', 'Jenis Kegiatan');
          $menu .=        $this->set_menu('perusahaan/investasi', 'Jenis Investasi');
          $menu .=        $this->set_menu('settings/satuan', 'Nilai Retribusi');
          $menu .=        $this->set_menu('settings/webservice', 'Web Service');
          $menu .=        $this->set_menu('settings/setting_pelayanan', ' Setting Pelayanan');

            // if($id_user == 680){
            //   $menu .=        $this->set_menu('settings/webservice/setting_struktural', 'Setting Struktural');
            // }
          $menu .=        $this->set_menu('settings/webservice/logEsign', 'Log Penandatanganan Esign');
        }
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        
        if($setting_user || $tembusan_arsip_ins_lain) {
          $menu .= "  <li class='dir'>Setting User";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          
          if(!$tembusan_arsip_ins_lain) {
            $menu .=      $this->set_menu('petugas', 'Pegawai');
          }
          
          if($admin){
            $menu .=      $this->set_menu('unitkerja', 'Unit Kerja'); 
          }
          $menu .=        $this->set_menu('pengguna', 'Pengguna');
          
          if($admin || $customer_service){	
            $menu .=      $this->set_menu('pemohon/pemohon_online', 'Pemohon OnLine');
            if($admin){
             	$menu .=    $this->set_menu('pemohon/login_ssoguest', 'Login GUEST by SSO');
            }	
          }
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($setting_wilayah) {
          $menu .= "  <li class='dir'>Setting Wilayah";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('wilayah', 'Provinsi');
          $menu .=        $this->set_menu('wilayah/kabupaten', 'Kabupaten');
          $menu .=        $this->set_menu('wilayah/kecamatan', 'Kecamatan');
          $menu .=        $this->set_menu('wilayah/kelurahan', 'Kelurahan');
          $menu .=        $this->set_menu('wilayah/gis', 'Point GIS');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($keamanan_data) {
          $menu .= "  <li class='dir'>";
          $menu .= "    Keamanan Data";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('log', 'Log Activity');
          $menu .=        $this->set_menu('log/log_backup/backup', 'Backup Database');
          $menu .=        $this->set_menu('log/log_backup', 'Restore Database');
          $menu .=        $this->set_menu('rbackupdata', 'Backup Folder');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu KONFIGURASI
      
      // Menu ADMINISTRASI
      $menu .= "<li class='dir'>";
      $menu .= "  ADMINISTRASI";
      $menu .= "  <ul>";
      $menu .= "    <li class='first'></li>";
      
      if($pendaftaran || $customer_service) { 
        $menu .= "  <li class='dir'>Pendaftaran";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        $menu .=        $this->set_menu('pelayanan/sementara', 'Permohonan OnLine');
        if($pendaftaran) {
          $menu .=      $this->set_menu('pelayanan/komitmen_oss', 'Komitmen OSS');
          $menu .=      $this->set_menu('pelayanan/pendaftaran', 'Permohonan Izin');
          if($admin){
            $menu .=    $this->set_menu('permohonan/revisisk', 'Perbaikan Naskah Izin');
          }  
          $menu .=      $this->set_menu('permohonan/cabut', 'Pencabutan Naskah Izin');
          $menu .=      $this->set_menu('', '<hr>');
          $menu .=      $this->set_menu('pemohon', 'Data Pemohon');
          $menu .=      $this->set_menu('perusahaan', 'Data Perusahaan');
        }
        $menu .= "      <li class='last'></li>";
        $menu .= "    </ul>";
        $menu .= "  </li>";
      }
      
      if($persuratan) {
        $menu .= "  <li class='dir'>Persuratan";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        $menu .=        $this->set_menu('persuratan', 'Entry Data Surat');
        $menu .=        $this->set_menu('persuratan/penomoran', 'Penomoran Surat');
        $menu .=        $this->set_menu('persuratan/cetak_surat', 'Cetak Surat');
        $menu .=        $this->set_menu('#', '<hr>');
        $menu .=        $this->set_menu('persuratan/surat_masuk', 'Entry Surat Masuk');
        $menu .=        $this->set_menu('persuratan/surat_disposisi', 'Surat Keluar / Nota Dinas');
        $menu .=        $this->set_menu('persuratan/surat_saya', 'Surat Masuk Saya');
        $menu .= "      <li class='last'></li>";
        $menu .= "    </ul>";
        $menu .= "  </li>";
      }
      // if(substr($user_role, 0, 5) != 'GUEST' || substr($user_role) != 'OPD Teknis' ) {	
      if( ($role_instansi == 'Pusat' && substr($user_role, 0, 5) != 'GUEST' ) || $level != NULL) {	
        $menu .= "    <li class='dir'>";
        $menu .= '      <span style="font-family: Cursive;">Suite Aplikasi (Program) </span>';
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        
        if($jdih) {
          $menu .=    $this->set_menu('jdih', 'JDIH');
        }
      
        if($timeline) {
          $menu .= "  <li class='dir'>Timeline";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('timeline', 'Timeline Kegiatan');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($bukutamu) {
          $menu .= "  <li class='dir'>BukuTamu/E-Report";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('bukutamu', 'Daftar Buku Tamu/E-Report');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($inputtkk) {
          $menu .= "  <li class='dir'>Input Aktivitas Non PNS";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('evencal', 'Input Aktivitas Non PNS');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
      
        if($pajak) {
          $menu .= "  <li class='dir'>e-BuPot 21";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('pajak', 'Bukti Potong PAJAK');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($trackingspj) {
          $menu .= "  <li class='dir'>Tracking SPJ";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($admin) {
            $menu .=      $this->set_menu('trackingspj/kegiatan', 'Kegiatan');
          }
          $menu .=        $this->set_menu('trackingspj', 'Tracking SPJ');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($investasi) {
          $menu .= "  <li class='dir'>Realisasi Investasi";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('investasi', 'Realisasi Investasi');
          $menu .=        $this->set_menu('investasi/invsektor', 'Realisasi Investasi Sektor');
          $menu .=        $this->set_menu('investasi/invlokasi', 'Realisasi Investasi Kab/Kota');
          $menu .=        $this->set_menu('investasi/invnegara', 'Realisasi Investasi Berdasarkan Asal Negara');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($level == NULL){
          $menu .= "    <li class='dir'>";
          $menu .= '      <span style="font-family: Cursive;">E-Tiket</span>';
          $menu .= "      <ul>";
          $menu .= "        <li class='first'></li>";
            
          // if($pengembangan){
            $menu .=        $this->set_menu('pengembangan', 'Si PAPA');
          // }
          //if($motionadmin){
            $menu .=        $this->set_menu('motion', 'Motion');
          //}
          
          $menu .= "        <li class='last'></li>";
          $menu .= "      </ul>";
          $menu .= "    </li>";
        }
      
        if($ruangan){
          $menu .= "  <li class='dir'>Manajemen Ruangan";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($admin || $admin_ruangan) {
            $menu .=      $this->set_menu('ruangan/master', 'Master Ruangan');
          }
          $menu .=        $this->set_menu('ruangan', 'Booking Ruangan');
          if($admin || $admin_ruangan) {
            $menu .=      $this->set_menu('ruangan/monitoring', 'Monitoring Kegiatan');
          }
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
      
        if($kegiatandpa){
          $menu .= "  <li class='dir'>SIMON beRAksi";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          
          $menu .=        $this->set_menu('kegiatandpa/tot', 'Tim Of Tim');
          $menu .=        $this->set_menu('kegiatandpa/renaksi', 'Sasaran Program /Kegiatan/Sub Kegiatan');
          if($admin) {
            $menu .=      $this->set_menu('kegiatandpa/kode_ring', 'Anggaran by Kode Ring');
            // $menu .=      $this->set_menu('kegiatandpa/aktivitas', 'Tes');
            $menu .=      $this->set_menu('kegiatandpa/set_koor', 'Setting Koordinator');
          }
          // $menu .= $this->set_menu('kegiatandpa', 'Rencana AKsi');
        
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
      
        if($level == NULL){
          $menu .= "    <li class='dir'>";
          $menu .= '      <span style="font-family: Cursive;">Pengelolaan Laptop</span>';
          $menu .= "      <ul>";
          $menu .= "        <li class='first'></li>";
          if($admin || $pengelola_aset){
            //$menu .=        $this->set_menu('peminjamanmobil/laptop', 'Pengelolaan Laptop <span style="color:Yellow"><br>(QC Pass)</span>');
            $menu .=        $this->set_menu('peminjamanmobil/laptop', 'Pengelolaan Laptop <b><span style="color:Yellow">√</span></b>');
          }
          //$menu .=          $this->set_menu('peminjamanmobil/peminjaman_laptop', 'Peminjaman Laptop <span style="color:red"><br>(QC Process)</span>');
          $menu .=          $this->set_menu('peminjamanmobil/peminjaman_laptop', 'Peminjaman Laptop <b><span style="color:Yellow">√</span></b>');
          $menu .= "        <li class='last'></li>";
          $menu .= "      </ul>";
          $menu .= "    </li>";
        }
      
        if($barang || $pengelola_barang){
          $menu .= "  <li class='dir'>";
          $menu .= '    <span style="font-family: Cursive;">Si Ola Baper</span>';
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($admin){
            $menu .=      $this->set_menu('permintaanbarang/setting', 'Setting');
          }
          if($pengelola_barang){
            $menu .=      $this->set_menu('permintaanbarang/barang', 'Pengelola Barang');
          }
          $menu .=      $this->set_menu('permintaanbarang/pengajuan_barang', 'Pengajuan Barang');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($admin || $pengelola_aset){
          $menu .= "  <li class='dir'>Aset (E-KIR)";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('permintaanbarang/aset', 'E-KIR <b><span style="color:red">( Under Cons )</span></b>');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
      
        if($pengolah_data){
          $menu .= "  <li class='dir'>";
          $menu .= '    <span style="font-family: Cursive;">Pengolah Data</span>';
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($admin){
            $menu .=      $this->set_menu('pengelola_data', 'Data Indikator');
            $menu .=      $this->set_menu('pengelola_data/data_rinvestasi', 'Data Rekapitulasi OSS');
          }
          $menu .=      $this->set_menu('pengelola_data/data_penduduk', 'Data Penduduk Wirausaha');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
      
        if($level == NULL){
          $menu .= "    <li class='dir'>";
          $menu .= '      <span style="font-family: Cursive;">Peminjaman Mobil</span>';
          $menu .= "      <ul>";
          $menu .= "        <li class='first'></li>";
          if($admin || $pengelolamobil){
            $menu .=        $this->set_menu('peminjamanmobil/mobil', 'Pengelolaan Mobil');
          }
          $menu .=          $this->set_menu('peminjamanmobil', 'Peminjaman Mobil');
          $menu .= "        <li class='last'></li>";
          $menu .= "      </ul>";
          $menu .= "    </li>";
        } 
      
        if($perdin || $rekapperdin){
          $menu .= "  <li class='dir'>";
          $menu .= "    <span style='font-family: Cursive;'>Perdin</span>";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($rekapperdin){
            $menu .=      $this->set_menu('perdin', 'E-Perdin');
          }
          if($rekapperdin){
            $menu .=      $this->set_menu('perdin/rekap', 'Rekap Perdin');
          }
        
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
          if($spperdin || $role_instansi == 'Pusat'){
          $menu .= "  <li class='dir'>";
          $menu .= "    <span style='font-family: Cursive;'>Perdin</span>";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
      
          $menu .=      $this->set_menu('perdin/suratperintah', 'Pembuatan SP(Surat Perintah)');
        
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
          }
        // }
        //if($admin || $nib){
        if($nib || $level != NULL){
          $menu .= "  <li class='dir'>";
          if($level == NULL){
            $menu .= "    <span style='font-family: Cursive;'>NIB</span>";
            $menu .= "    <ul>";
            $menu .= "      <li class='first'></li>";
            if($level == NULL){
              $menu .=      $this->set_menu('pengembangan/nib', 'Pelayanan NIB');
              $menu .=      $this->set_menu('pengembangan/gpt', 'Pelayanan GPT');
            }
          }
          if($status_login){
            if($status_login == 1){
              $menu .=      $this->set_menu('pengembangan/gpt', 'Pelayanan GPT');
            }
          }
          if($level == 1){
          $menu .=      $this->set_menu('pengelola_data/pengawasan_lkpm', 'LKPM');
          $menu .=      $this->set_menu('pengelola_data/pengawasan_lkpm', 'LKPM');
          }
          if($level == 2){
          $menu .=      $this->set_menu('pengelola_data/pengawas_tenaga_kerja', 'Tenagakerja');
          }
          if($level == NULL){
            $menu .= "      <li class='last'></li>";
            $menu .= "    </ul>";
          }
            $menu .= "  </li>";
        }
        if($level == NULL){
          $menu .=      $this->set_menu('info/invesment', 'Invest In West Java');
        }
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
      }
      
      //if(substr($user_role, 0, 5) == 'GUEST'){
      if(substr($user_role, 8) == 'PAMUDI BUDI SUHARSONO, S.Si.'){ 
        $menu .= "  <li class='dir'>Manajemen Ruangan";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        $menu .=        $this->set_menu('ruangan', 'Booking Ruangan');
        $menu .= "      <li class='last'></li>";
        $menu .= "    </ul>";
        $menu .= "  </li>";
      }
      
      if($penadatangan) {
        $menu .=    $this->set_menu('pelayanan/tandatangan', 'Penandatanganan');
      }
      
      if($level == NULL){
        $menu .=        $this->set_menu('log/log_user', 'Aktivitas Saya Hari ini');
        if($opd){
          if($tembusan_arsip_ins_lain){
            $menu .=  $this->set_menu('settings/surat_keluar', 'Surat Permohonan Pertek');
          }else{
            $menu .=  $this->set_menu('settings/surat_keluar', 'Surat Masuk');
          }
        }else{
          $menu .=    $this->set_menu('settings/surat_keluar', 'Surat Keluar');
        }
        if(!$tembusan_arsip_ins_lain){
          $menu .=    $this->set_menu('survey/sp_saya', 'Surat Perintah Saya');
        }
      }
      
      if($customer_service){
        $menu .= "  <li class='dir'>Customer Service";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        $menu .=        $this->set_menu('info/infoperizinan', 'Informasi Perizinan');
        $menu .=        $this->set_menu('property/simulasi', 'Simulasi Tarif Retribusi');
        $menu .=        $this->set_menu('info/infotracking', 'Informasi Tracking');
        $menu .=        $this->set_menu('info/infomasaberlaku', 'Informasi Masa Berlaku');
        $menu .= "      <li class='last'></li>";
        $menu .= "    </ul>";
        $menu .= "  </li>";
      }
      
      $menu .= "    <li class='last'></li>";
      $menu .= "  </ul>";
      $menu .= "</li>";
      // EOF() Menu ADMINISTRASI
      
      // Menu PENGOLAHAN IZIN atau PENOMORAN
      if($pendataan || $tim_teknis || $penetapan || $penomoran || $perpanjangan || $penjadualan_sp){
        $text = "PENGOLAHAN IZIN";
        if(!$pendataan && !$tim_teknis && !$penetapan && $perpanjangan) $text = "PENOMORAN";
        $menu .= "<li class='dir'>";
        $menu .=    $text;
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .=      $this->set_menu('pelayanan/sementara', 'Permohonan OnLine');
        $menu .=      $this->set_menu('pelayanan/komitmen_oss', 'Persetujuan Permohonan OSS RBA');
        if($pendataan || $penjadualan_sp){
          $menu .= "  <li class='dir'>Pendataan";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($pendataan || !$penjadualan_sp){
            $menu .=      $this->set_menu('pendataan', 'Entry Data Perizinan');
          }
          $menu .=        $this->set_menu('survey', 'Penjadwalan Tinjauan');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($tim_teknis){
          $menu .= "  <li class='dir'>Tim Teknis";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('survey/result', 'Entry Hasil Tinjauan');
          $menu .=        $this->set_menu('permohonan/bap', 'Pertimbangan Teknis');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($penetapan) {           // jika penetapan
          $menu .= "  <li class='dir'>Penetapan";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('permohonan/penetapan', 'Penetapan Naskah Izin');
          $menu .=        $this->set_menu('permohonan/penetapan/revisi', 'Revisi Naskah Izin');
          $menu .=        $this->set_menu('cetakizin/penetapan_kp', 'Penetapan SK/KP');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        if($penomoran){          // jika penomoran  
          $menu .=    $this->set_menu('permohonan/penetapan', 'Penomoran Izin');
        }
        
        if($penetapan){           // jika penetapan
          $menu .= "  <li class='dir'>Pembuatan Izin";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('permohonan/sk', 'Cetak Naskah Izin');
          $menu .=        $this->set_menu('cetakizin/idx_ctk_kp', 'Cetak Kartu Pengawasan');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }
        
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu PENGOLAHAN IZIN atau PENOMORAN
      
      // Menu RETRIBUSI
      if($retribusi){
        $menu .= "<li class='dir'>";
        $menu .= "  RETRIBUSI";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .=      $this->set_menu('kasir', 'Pembayaran Retribusi');
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu RETRIBUSI
      
      // Menu PENYERAHAN
      if($penyerahan){
        $menu .= "<li class='dir'>";
        $menu .= "  PENYERAHAN";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .=      $this->set_menu('pelayanan/ambilsk', 'Penyerahan Izin');
        $menu .=      $this->set_menu('dokumen/pengajuan', 'Pengajuan Salinan');
        //$menu .=      $this->set_menu('dokumen/penyerahan', 'Penyerahan Salinan');
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu PENYERAHAN
      
      // Menu PENGARSIPAN
      if($pengarsipan || $tim_teknis || $tembusan_arsip_ins_lain){
        $menu .= "<li class='dir'>";
        $menu .= "PENGARSIPAN";
        $menu .= "<ul>";
        $menu .= "<li class='first'></li>";
        if($pengarsipan){
          $menu .= $this->set_menu('arsip', 'Administrasi Pengarsipan');
          $menu .= $this->set_menu('arsip/timteknis', 'Arsip Perizinan ' . img($sprinter));
        }else{
          if($tim_teknis || $tembusan_arsip_ins_lain){
            $menu .= $this->set_menu('arsip/timteknis', 'Arsip Perizinan ' . img($sprinter));
          }
        }
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu PENGARSIPAN
      
      // Menu PENGADUAN
      if($pengaduan){
        $pengaduan = TRUE;
        $menu .= "<li class='dir'>";
        $menu .= "  PENGADUAN";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .=      $this->set_menu('pesan', 'Daftar Pengaduan / Saran');
        $menu .=      $this->set_menu('pesan/pesanpersetujuan', 'Persetujuan Respon Pengaduan');
        $menu .=      $this->set_menu('pesan/pesanpengiriman', 'Pengiriman Respon Pengaduan');
        $menu .=      $this->set_menu('pesan/pesanbalasan', 'Daftar Balasan');
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu PENGADUAN
      
      // Menu MONITORING
      if($monitoring || $anpeg || $pengawas_mobil || $lkpm){
        $menu .= "<li class='dir'>";
        $menu .= "  MONITORING";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        if($role_instansi == 'Pusat'){

        $menu .= "    <li class='dir'>PENGAWASAN";
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        
        if($monitoring || $anpeg){
          $menu .=        $this->set_menu('monitoring/pengawasan_oss/m', ' OSS-RBA');
          $menu .=        $this->set_menu('monitoring/pengawasan_jelita/m', 'JELITA');
          $menu .=        $this->set_menu('monitoring/pembinaan/m', 'PEMBINAAN & PEMANTAUAN');
        }
        
        if($role_instansi == 'Pusat' && ($pengawas_mobil || $admin)){
          $menu .=        $this->set_menu('peminjamanmobil/pengawas_mobil', ' PENGAWAS MOBIL');
        }
        if($role_instansi == 'Pusat' && ($lkpm || $admin)){
        $menu .=        $this->set_menu('pengelola_data/pengawasan_lkpm', ' LKPM Pride');
        }
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
        }
      
        if($monitoring || $anpeg || $skm){
          $menu .= "  <li class='first'></li>";
          $menu .= "  <li class='dir'>DATA PERHUBUNGAN";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('monitoring/perhubungan_all', 'Berdasarkan Kategori');
          // $menu .=        $this->set_menu('monitoring/perhubungan_kdtrayek', 'Berdasarkan Tanggal Cetak');
          $menu .=        $this->set_menu('monitoring/perhubungan', 'Berdasarkan Tanggal Cetak');
          $menu .=        $this->set_menu('monitoring/perhubungan_terminaltrayek', 'Berdasarkan Terminal/Trayek');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
          if($role_instansi == 'Pusat' && ($callcenter || $admin)){
          $menu .=    $this->set_menu('monitoring/callcenter', 'Call Center');
          }
          $menu .=    $this->set_menu('monitoring/perketegori_tertentu', 'Per Kategori');
          if($role_instansi == 'Pusat'){
          $menu .= "  <li class='dir'>DATA KATEGORI";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('monitoring/perketegori_tertentu', 'Per Kategori');
          $menu .=        $this->set_menu('monitoring/perketegori_tertentu_map', 'Titik Lokasi Kategori');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
          }
          if($role_instansi == 'Pusat' && ($skm || $admin)){
            $menu .=    $this->set_menu('monitoring/skm', 'SKM');
          }
          if($role_instansi == 'Pusat'){
            $menu .=    $this->set_menu('monitoring/b_survei_ipak', 'Survey Ipak');
            $menu .= "  <li class='dir'>Izin Belum Selesai Melebihi Durasi";
            $menu .= "    <ul>";
            $menu .= "      <li class='first'></li>";
            $menu .=        $this->set_menu('monitoring/state', 'JELITA');
            $menu .=        $this->set_menu('monitoring/mon_izin_oss', 'OSS RBA');
            $menu .= "      <li class='last'></li>";
            $menu .= "    </ul>";
            $menu .= "  </li>";
            $menu .=    $this->set_menu('monitoring/approve_izin', 'Penandatanganan Izin');
          }
            $menu .=    $this->set_menu('monitoring/persektor', 'Per Bidang');
            $menu .=    $this->set_menu('monitoring', 'Per Jenis Perizinan');
          if($role_instansi == 'Pusat'){
            $menu .=    $this->set_menu('monitoring/perwaktu', 'Per Asal Permohonan');
          }
        
          if($role_instansi == 'Pusat'){
          if($anpeg || $admin){
            $menu .= "<li class='first'></li>";
            $menu .= "<li class='dir'>DATA KEPEGAWAIAN";
            $menu .= "  <ul>";
            $menu .= "    <li class='first'></li>";
            $menu .=      $this->set_menu('monitoring/daftar_pensiun', 'Pegawai yang akan pensiun');
            $menu .= "    <li class='last'></li>";
            $menu .= "  </ul>";
            $menu .= "</li>";
          }
          }
        
          if($role_instansi == 'Pusat'){
          $menu .= "  <li class='dir'>APPROVAL ESSELON";
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          $menu .=        $this->set_menu('monitoring/monitoring_persuratan', 'Persuratan');
          $menu .=        $this->set_menu('monitoring/monitoring_tte', 'Perizinan');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
          }

          if($role_instansi == 'Pusat'){
            $menu .= "  <li class='dir'>Monitoring ASET";
            $menu .= "    <ul>";
            $menu .= "      <li class='first'></li>";
            $menu .= $this->set_menu('monitoring/peminjaman_laptop', 'Peminjaman Laptop');
            $menu .= $this->set_menu('monitoring/peminjaman_mobil', 'Peminjaman Mobil');
            $menu .= $this->set_menu('monitoring/peminjaman_ruangan', 'Peminjaman Ruangan');
            $menu .= $this->set_menu('monitoring/monitoring_perdin', 'Monitoring Perdin');
            $menu .= "      <li class='last'></li>";
            $menu .= "    </ul>";
            $menu .= "  </li>";
          }
          
          if($role_instansi == 'Pusat'){
            if($survei){
            $menu .= "  <li class='dir'>Survei";
            $menu .= "    <ul>";
            $menu .= "      <li class='first'></li>";
            $menu .=        $this->set_menu('monitoring/survei_zez', 'Survei Zero Emission Zone');
            $menu .=        $this->set_menu('monitoring/Blasting_gpt', 'Survei Pelaku Usaha');

            $menu .= "      <li class='last'></li>";
            $menu .= "    </ul>";
            $menu .= "  </li>";
            }
          }

          if($role_instansi == 'Pusat'){
          $menu .= $this->set_menu('monitoring/wjisguest', 'Tamu WJIS');
          $menu .= $this->set_menu('monitoring/gpt_list', 'Pendaftar GPT');
          }


        }
        
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu MONITORING
      
      // Menu LAPORAN
      if($laporan){
        $menu .= "<li class='dir'>";
        $menu .= "  LAPORAN";
        $menu .= "  <ul>";
        
        $menu .= "    <li class='first'></li>";
        $menu .= "    <li class='dir'>PENGAWASAN";
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        $menu .=          $this->set_menu('monitoring/pengawasan_oss/l', ' OSS-RBA');
        $menu .=          $this->set_menu('monitoring/pengawasan_jelita/l', 'JELITA');
        $menu .=          $this->set_menu('monitoring/pembinaan/l', 'PEMBINAAN & PEMANTAUAN');
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
        
        $menu .= "    <li class='first'></li>";
        
        if($admin || $pengolah_data){
          $menu .=    $this->set_menu('rekapitulasi/izin', 'Rekapitulasi Perizinan (Admin)');
          $menu .=    $this->set_menu('rekapitulasi/izin/rekaptest', 'Rekapitulasi Perizinan');
        }else{
          $menu .=    $this->set_menu('rekapitulasi/izin/rekaptest', 'Rekapitulasi Perizinan');
        }
        
        $menu .=      $this->set_menu('durasiizin/izin', 'Durasi Izin Perbidang');
        $menu .=      $this->set_menu('kinerjaizin/izin', 'Kinerja Izin Perbidang');
        
        if($admin){
          $menu .=    $this->set_menu('durasisemuabidang', 'Durasi Semua Bidang (Admin)');
          $menu .=    $this->set_menu('kinerjasemuabidang', 'Kinerja Semua Bidang (Admin)');
        }
        $menu .=    $this->set_menu('monitoring/pencabutan', 'Pencabutan Izin');
        
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu LAPORAN
      
      // Menu DATA
      if($datakabkota){
        $menu .= "<li class='dir'>";
        $menu .= "  DATA";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .=      $this->set_menu('datakabkota', 'REKONSILIASI NIB KAB/KOTA');
        $menu .= "    <li class='dir'>Perizinan";
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        $menu .=          $this->set_menu('bisbesar/c_izintrayek', 'Pengelolaan Data Izin Trayek / Operasi');
        $menu .=          $this->set_menu('bisbesar/approve_bb', 'Penetapan SK/KP');
        $menu .=          $this->set_menu('bisbesar/approve_bb/cetak_naskah', 'Cetak Naskah SK/KP');
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu DATA
      
      // Menu BIS BESAR
      if($bisbesar){
        $menu .= "<li class='dir'>";
        $menu .= "  BIS BESAR";
        $menu .= "  <ul>";
        $menu .= "    <li class='first'></li>";
        $menu .= "    <li class='dir'>Data Induk";
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        $menu .=          $this->set_menu('bisbesar/c_pengusaha', 'Pengusaha');
        $menu .=          $this->set_menu('bisbesar/c_kendaraan', 'Kendaraan');
        $menu .=          $this->set_menu('bisbesar/c_terminal', 'Terminal');
        $menu .=          $this->set_menu('bisbesar/c_lintasan', 'Lintasan Trayek');
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
        $menu .= "    <li class='dir'>Perizinan";
        $menu .= "      <ul>";
        $menu .= "        <li class='first'></li>";
        $menu .=          $this->set_menu('bisbesar/c_izintrayek', 'Pengelolaan Data Izin Trayek / Operasi');
        $menu .=          $this->set_menu('bisbesar/approve_bb', 'Penetapan SK/KP');
        $menu .=          $this->set_menu('bisbesar/approve_bb/cetak_naskah', 'Cetak Naskah SK/KP');
        
        $menu .= "          <li class='dir'>Cetak Excel";
        $menu .= "            <ul>";
        $menu .= "              <li class='first'></li>";
        $menu .=                $this->set_menu('bisbesar/approve_bb/cetak_excel', 'Bis Besar');
        $menu .=                $this->set_menu('bisbesar/approve_bb/cetak_excel_bis_kecil', 'Bis Kecil');
        $menu .= "              <li class='last'></li>";
        $menu .= "            </ul>";
        $menu .= "          </li>";
        $menu .= "        <li class='last'></li>";
        $menu .= "      </ul>";
        $menu .= "    </li>";
        $menu .= "    <li class='last'></li>";
        $menu .= "  </ul>";
        $menu .= "</li>";
      }
      // EOF() Menu BIS BESAR
      
      // Menu API
      //if($pengenalimpor){
      //  $menu .= "<li class='dir'>";
      //  $menu .= "  API";
      //  $menu .= "  <ul>";
      //  $menu .= "    <li class='first'></li>";
      //  $menu .=      $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan_approve', 'Validasi Laporan Import');
      //  $menu .=      $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan', 'Data Laporan Import');
      //  $menu .= "    <li class='last'></li>";
      //  $menu .= "  </ul>";
      //  $menu .= "</li>";
      //}
      // EOF() Menu API
      
      // Menu SIAP
      //if($pengarsipan){
      //  $menu .= "<li class='dir'>";
      //  $menu .= "  SIAP";
      //  $menu .= "  <ul>";
      //  $menu .= "    <li class='first'></li>";
      //  if($pengarsipan) {
      //    //$menu .=    $this->set_menu('arsip', 'Arsip');
      //    //$menu .=    $this->set_menu('upload_arsip', 'Upload FIle Arsip');
      //    //$menu .=    $this->set_menu('upload_arsip/rekapupload', 'Rekap Jumlah Upload File');
      //    $menu .=    $this->set_menu('laporan_arsip', 'Daftar Arsip');
      //  }
      //  /*if($tim_teknis ){
      //    $menu .=    $this->set_menu('upload_arsip/report_arsip', 'Report Arsip');
      //  } */
      //  $menu .= "    <li class='last'></li>";
      //  $menu .= "  </ul>";
      //  $menu .= "</li>";
      //}
      // EOF() Menu SIAP 
    }    
 
    // Menu SSO & INFORMASI PUBLIK
    if($level == NULL){
      $menu .= "<li class='dir'>";
      $menu .= "  SSO & INFORMASI PUBLIK";
      $menu .= "  <ul>";
      $menu .= "    <li class='first'></li>";
      $menu .=      $this->set_menu('info/super_apps', 'Super Apps (SMART JABAR)');  
      $menu .=      $this->set_menu('info/fitur_jelita', 'Fitur Adm Perkantoran');
      $menu .=      $this->set_menu('info/infoperizinan', 'Daftar Layanan Publik');
      $menu .=      $this->set_menu('info/video_tutor', 'Video Tutorial Jelita');
      $menu .=      $this->set_menu('info/info_sp', 'Daftar Standar Pelayanan');
      $menu .=      $this->set_menu('info/skm', 'Survey Kepuasan Masyarakat (SKM)');
      $menu .=      $this->set_menu('info/a_keg_dinas', 'Kalender Kegiatan');
      $menu .=      $this->set_menu('info/ruang_rapat', 'Penggunaan Ruang Rapat');
      $menu .=      $this->set_menu('info/super_apps/etanamya', 'E-Tanam Modal Ya');
      $menu .=      $this->set_menu('info/super_apps/mppdigital', 'MPP Digital Jabar');
      $menu .=      $this->set_menu('info/super_apps/peta_ijin', 'Peta Sebaran Perijinan');
      $menu .=      $this->set_menu('info/super_apps/peta_potensi', 'Peta Sebaran Potensi Investasi Jabar');
      $menu .=      $this->set_menu('info/super_apps/cambuk_nib', 'Capaian Penerbitan NIB "Cambuk-NIB"');
      $menu .= "    <li class='last'></li>";
      $menu .= "  </ul>";
      $menu .= "</li>";
    }
    // EOF() Menu SSO & INFORMASI PUBLIK
    
    return $menu;
  }
}
