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

  public function __construct() {
    $this->ci = & get_instance();
  }

  public function set_menu($module_name = NULL, $title = NULL, $css_class = NULL) {
    $structure = NULL;
    if ($module_name !== NULL || $module_name !== '')
      if ($css_class === NULL) {
        $structure = "<li><a href='" . site_url($module_name) . "'>" . $title . "</a></li>";
      } else {
        $structure = "<li class='" . $css_class . "'><a href='" . site_url($module_name) . "'>" . $title . "</a></li>";
      }
    return $structure;
  }

  public function install() {
    $menu = NULL;
    $menu .= "<li class='dir'>";
    $menu .= "MASTER";
    $menu .= "<ul>";
    $menu .= $this->set_menu('role', 'Setting Peran');
    $menu .= $this->set_menu('pengguna', 'Setting Pengguna');
    $menu .= $this->set_menu('install', 'Konfigurasi', 'last');
    $menu .= "</ul>";
    $menu .= "</li>";
    return $menu;
  }

  public function create_menu($list_role = NULL,$opd=NULL,$user_role = NULL, $role_instansi, $level = NULL, $status_login = NULL) {
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
    $permintaanbarang = FALSE;
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

    $sprinter = array('src' => base_url().'assets/images/icon/sprinter.png','border' => '0');

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
            $ruangan = FALSE;
            break;
        case '36':
            $bukutamu = FALSE;
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
            $permintaanbarang = TRUE;
            break;
        case '45':
            $pengelolabarang = TRUE;
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
            $pengawas_mobil = FALSE;
            break;
        case '49':
            $pengelolamobil = FALSE;
            break;
        case '51':
            $rekapperdin = TRUE;
            break;
        case '52':
            $motionadmin = TRUE;
            break;
        case '53':
            $kegiatandpa = FALSE;
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
            $pengelola_aset = FALSE;
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

    if($setting_perizinan || $setting_sk || $setting_umum || $setting_user || $setting_wilayah || $keamanan_data ) {
      $menu .= "<li class='dir'>";
      $menu .= "KONFIGURASI ";
      $menu .= "<ul>";
        if($setting_perizinan) {
          $menu .= "  <li class='dir'>Setting Perizinan";
          $menu .= "   <ul>";
            $menu .= $this->set_menu('perizinan', 'Jenis Perizinan','first');
			$menu .= $this->set_menu('perizinan/paralel', 'Perizinan Paralel');
			$menu .= $this->set_menu('perizinan/persyaratanizin', 'Persyaratan Izin');
			$menu .= $this->set_menu('property/master', 'Property Pendataan');
			$menu .= $this->set_menu('retribusi', 'Retribusi Izin');
            $menu .= $this->set_menu('perizinan/koefisientarif', 'Koefisien Tarif','last');
          $menu .= "   </ul>";
          $menu .= "  </li>";
        }

        if($setting_sk) {
          $menu .= "  <li class='dir'>Setting Naskah Izin";
          $menu .= "   <ul>";
            $menu .= $this->set_menu('permohonan_sartek', 'Permohonan Saran Teknis','first');
			$menu .= $this->set_menu('dasarhukum', 'Dasar Hukum Surat');
            $menu .= $this->set_menu('ketetapan', 'Ketentuan Surat');
			$menu .= $this->set_menu('menimbang', 'Menimbang SK');
            $menu .= $this->set_menu('mengingat', 'Mengingat SK');
			$menu .= $this->set_menu('memperhatikan', 'Memperhatikan ','last');
          $menu .= "   </ul>";
          $menu .= "  </li>";
        }
			
			  if($setting_umum) {
          $menu .= "  <li class='dir'>Setting Umum";
          $menu .= "   <ul>";
            $menu .= $this->set_menu('header_instansi', 'Instansi','first');
            $menu .= $this->set_menu('holiday', 'Hari Libur');
			$menu .= $this->set_menu('settings/bidang', 'Bidang Perizinan');
			$menu .= $this->set_menu('perusahaan/kegiatan', 'Jenis Kegiatan');
            $menu .= $this->set_menu('perusahaan/investasi', 'Jenis Investasi');
            $menu .= $this->set_menu('settings/satuan', 'Nilai Retribusi');
            $menu .= $this->set_menu('settings/webservice', 'Web Service');
            $menu .= $this->set_menu('settings/webservice/logEsign', 'Log Penandatanganan ESign','last');
            //$menu .= $this->set_menu('settings/unduhBerkas', 'Unduh Berkas','last');
          $menu .= "   </ul>";
          $menu .= "  </li>";
        }
			
			  if($setting_user) {
          $menu .= "  <li class='dir'>Setting User";
          $menu .= "   <ul>";
			$menu .= $this->set_menu('petugas', 'Pegawai','first');
            //$menu .= $this->set_menu('role', 'Setting Peran');
            $menu .= $this->set_menu('unitkerja', 'Unit Kerja');
            $menu .= $this->set_menu('pengguna', 'Pengguna');
			$menu .= $this->set_menu('pemohon/pemohon_online', 'Pemohon OnLine','last');
          $menu .= "   </ul>";
          $menu .= "  </li>";
        }

        if($setting_wilayah) {
          $menu .= "  <li class='dir'>Setting Wilayah";
          $menu .= "   <ul>";
			      $menu .= $this->set_menu('wilayah', 'Provinsi','first');
            $menu .= $this->set_menu('wilayah/kabupaten', 'Kabupaten');
            $menu .= $this->set_menu('wilayah/kecamatan', 'Kecamatan');
            $menu .= $this->set_menu('wilayah/kelurahan', 'Kelurahan', 'last');
            //$menu .= $this->set_menu('wilayah/gis', 'Point GIS', 'last');
          $menu .= "   </ul>";
          $menu .= "  </li>";
        }

        if($keamanan_data) {
          $menu .= "<li class='dir'>";
          $menu .= "Keamanan Data";
          $menu .= "<ul>";
            $menu .= $this->set_menu('log', 'Log Activity', 'first');
            $menu .= $this->set_menu('log/log_backup/backup', 'Backup Database');
            $menu .= $this->set_menu('log/log_backup', 'Restore Database');
			$menu .= $this->set_menu('rbackupdata', 'Backup Folder', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
        }

      $menu .= "<li class='last'></li>";
      $menu .= "</ul>";
      $menu .= "</li>";
    }
		
		//if($pendaftaran || $penadatangan ||$customer_service) {
    $menu .= "<li class='dir'>";
    $menu .= "ADMINISTRASI";
    $menu .= "<ul>";
      if($pendaftaran) {
        $menu .= "  <li class='dir'>Pendaftaran";
        $menu .= "   <ul>";
          $menu .= $this->set_menu('pelayanan/sementara', 'Permohonan OnLine', 'first');
          //$menu .= $this->set_menu('pelayanan/komitmen_oss', 'Komitmen OSS');
          $menu .= $this->set_menu('pelayanan/pendaftaran', 'Permohonan Izin');
          if($admin)
            $menu .= $this->set_menu('permohonan/revisisk', 'Perbaikan Naskah Izin');
            $menu .= $this->set_menu('permohonan/pencabutan', 'Pencabutan Naskah Izin');
          //$menu .= $this->set_menu('pendaftaran/index/2', 'Perubahan Izin');
          //$menu .= $this->set_menu('pendaftaran/index/3', 'Perpanjangan Izin');
          //$menu .= $this->set_menu('pendaftaran/index/4', 'Daftar Ulang Izin');
          $menu .= $this->set_menu('', '<hr>');
          $menu .= $this->set_menu('pemohon', 'Data Pemohon');
          $menu .= $this->set_menu('perusahaan', 'Data Perusahaan', 'last');
        $menu .= "   </ul>";
        $menu .= "  </li>";
      }

      if($persuratan) {
        $menu .= "<li class='dir'>Persuratan";
        $menu .= "<ul>";
        $menu .= "<li class='first'></li>";
          $menu .= $this->set_menu('persuratan', 'Entry Data Surat');
          $menu .= $this->set_menu('persuratan/penomoran', 'Penomoran Surat');
          $menu .= $this->set_menu('persuratan/cetak_surat', 'Cetak Surat');
        $menu .= "<li class='last'></li>";  
        $menu .= "   </ul>";
        $menu .= "  </li>";
      }
      if($jdih) {
        $menu .=    $this->set_menu('jdih', 'JDIH');
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

        // if($level == NULL){
        //   $menu .= "    <li class='dir'>";
        //   $menu .= '      <span style="font-family: Cursive;">Pengelolaan Laptop</span>';
        //   $menu .= "      <ul>";
        //   $menu .= "        <li class='first'></li>";
        //   if($admin || $pengelola_aset){
        //     //$menu .=        $this->set_menu('peminjamanmobil/laptop', 'Pengelolaan Laptop <span style="color:Yellow"><br>(QC Pass)</span>');
        //     $menu .=        $this->set_menu('peminjamanmobil/laptop', 'Pengelolaan Laptop <b><span style="color:Yellow">√</span></b>');
        //   }
        //   //$menu .=          $this->set_menu('peminjamanmobil/peminjaman_laptop', 'Peminjaman Laptop <span style="color:red"><br>(QC Process)</span>');
        //   $menu .=          $this->set_menu('peminjamanmobil/peminjaman_laptop', 'Peminjaman Laptop <b><span style="color:Yellow">√</span></b>');
        //   $menu .= "        <li class='last'></li>";
        //   $menu .= "      </ul>";
        //   $menu .= "    </li>";
        // }
        
        // if($level == NULL){
        //   $menu .= "    <li class='dir'>";
        //   $menu .= '      <span style="font-family: Cursive;">Peminjaman Mobil</span>';
        //   $menu .= "      <ul>";
        //   $menu .= "        <li class='first'></li>";
        //   if($admin || $pengelolamobil){
        //     $menu .=        $this->set_menu('peminjamanmobil/mobil', 'Pengelolaan Mobil');
        //   }
        //   $menu .=          $this->set_menu('peminjamanmobil', 'Peminjaman Mobil');
        //   $menu .= "        <li class='last'></li>";
        //   $menu .= "      </ul>";
        //   $menu .= "    </li>";
        // } 

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
      
        if($barang || $permintaanbarang){
          $menu .= "  <li class='dir'>";
          $menu .= '    <span style="font-family: Cursive;">Si Ola Baper</span>';
          $menu .= "    <ul>";
          $menu .= "      <li class='first'></li>";
          if($admin){
            $menu .=      $this->set_menu('permintaanbarang/setting', 'Setting');
          }
          if($permintaanbarang){
            $menu .=      $this->set_menu('permintaanbarang/barang', 'Pengelola Barang');
          }
          $menu .=      $this->set_menu('permintaanbarang/pengajuan_barang', 'Pengajuan Barang');
          $menu .= "      <li class='last'></li>";
          $menu .= "    </ul>";
          $menu .= "  </li>";
        }

		if($penadatangan) {
        	$menu .= $this->set_menu('pelayanan/tandatangan', 'Penandatanganan');
		    //$menu .= $this->set_menu('pelayanan/sementara', 'Penandatanganan');
      }

		if($opd) {
        	$menu .= $this->set_menu('settings/surat_keluar', 'Surat Masuk');
      	} else {
		  	$menu .= $this->set_menu('settings/surat_keluar', 'Surat Keluar');
		  }

		  $menu .= $this->set_menu('survey/sp_saya', 'Surat Perintah Saya');

      if($customer_service) {
        $menu .= "  <li class='dir'>Customer Service";
        $menu .= "   <ul>";
          $menu .= $this->set_menu('info/infoperizinan', 'Informasi Perizinan', 'first');
          $menu .= $this->set_menu('property/simulasi', 'Simulasi Tarif Retribusi');
		  $menu .= $this->set_menu('info/infotracking', 'Informasi Tracking');
          $menu .= $this->set_menu('info/infomasaberlaku', 'Informasi Masa Berlaku','last');
        $menu .= "   </ul>";
        $menu .= "  </li>";
      }
      
      if($perdin || $rekapperdin || $spperdin){
        $menu .= "  <li class='dir'>";
        $menu .= "    <span style='font-family: Cursive;'>Perdin</span>";
        $menu .= "    <ul>";
        $menu .= "      <li class='first'></li>";
        if($perdin){
          $menu .=      $this->set_menu('perdin', 'E-Perdin');
        }
        if($rekapperdin){
          $menu .=      $this->set_menu('perdin/rekap', 'Rekap Perdin');
        }
        if($spperdin){
          $menu .=      $this->set_menu('perdin/suratperintah', 'Pembuatan SP(Surat Perintah)');
        }

        $menu .= "      <li class='last'></li>";
        $menu .= "    </ul>";
        $menu .= "  </li>";
      }
        // if($level == NULL){
        //   $menu .=      $this->set_menu('info/invesment', 'Invest In West Java');
        // }
    	$menu .= "<li class='last'></li>";
    	$menu .= "</ul>";
    	$menu .= "</li>";
    //}

    if ($pendataan || $tim_teknis || $penetapan || $penomoran || $perpanjangan || $penjadualan_sp) {
			$text = "PENGOLAHAN IZIN";
      if(!$pendataan && !$tim_teknis && !$penetapan && $perpanjangan) $text = "PENOMORAN";
      	$menu .= "<li class='dir'>";
      	$menu .= $text;
      	$menu .= "<ul>";
			$menu .= $this->set_menu('pelayanan/sementara', 'Permohonan OnLine', 'first');
			$menu .= $this->set_menu('pelayanan/komitmen_oss', 'Komitmen OSS');
        if ($pendataan || $penjadualan_sp) {
          $menu .= "<li class='dir'>Pendataan";
          $menu .= "<ul>";
        	if ($pendataan || !$penjadualan_sp) {
            $menu .= $this->set_menu('pendataan', 'Entry Data Perizinan', 'first');
			    }
            $menu .= $this->set_menu('survey', 'Penjadwalan Tinjauan', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
        }

        if ($tim_teknis) {
          $menu .= "<li class='dir'>Tim Teknis";
          $menu .= "<ul>";
            $menu .= $this->set_menu('survey/result', 'Entry Hasil Tinjauan', 'first');
            $menu .= $this->set_menu('permohonan/bap', 'Rekomendasi Teknis', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
        }

        if ($penetapan){           // jika penetapan
        	// $menu .= "<li class='dir'>Penetapan";
         //  $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan Naskah Izin');
			       // $menu .= $this->set_menu('cetakizin/penetapan_kp', 'Penetapan SK/KP', 'last');
          //   $menu .= "</ul>";
          //   $menu .= "</li>";
        }
        if ($penomoran){          // jika penomoran 	
          $menu .= $this->set_menu('permohonan/penetapan', 'Penomoran Izin');
        }
        
        //$menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');

        if ($penetapan){           // jika penetapan
          // $menu .= "<li class='dir'>Pembuatan Izin";
          // $menu .= "<ul>";
             $menu .= $this->set_menu('permohonan/sk', 'Cetak Naskah Izin');
			       // $menu .= $this->set_menu('cetakizin/idx_ctk_kp', 'Cetak Kartu Pengawasan', 'last');
          //    $menu .= "</ul>";
          //    $menu .= "</li>";
        }
        
        //$menu .= $this->set_menu('permohonan/skditolak', 'Layanan Ditolak');
        //$menu .= $this->set_menu('pendaftaran/cabutizin', 'Pencabutan Izin');
        //$menu .= $this->set_menu('permohonan/revisisk', 'Perbaikan SK');  
        
       /*old
        if ($penetapan && $penomoran) {          // jika penetapan dan penomoran
          $menu .= "<li class='dir'>Penetapan";
          $menu .= "<ul>";
				    $menu .= "<li class='dir'>Penetapan Izin";
            $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan/Penomoran Izin', 'first');
			        $menu .= $this->set_menu('cetakizin/penetapan_kp', 'Penetapan SK/KP', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
            $menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');
            $menu .= "<li class='dir'>Pembuatan Izin";
            $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/sk', 'Cetak Naskah Izin', 'first');
					    $menu .= $this->set_menu('cetakizin/idx_ctk_kp', 'Cetak Kartu Pengawasan', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
            $menu .= $this->set_menu('permohonan/skditolak', 'Layanan Ditolak');
            $menu .= $this->set_menu('pendaftaran/cabutizin', 'Pencabutan Izin', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
        }
			 
	      if ($penetapan && !$penomoran) {         // jika hanya penetapan 
          $menu .= "<li class='dir'>Penetapan";
          $menu .= "<ul>";
					  $menu .= "<li class='dir'>Penetapan Izin";
            $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan Izin', 'first');
					    $menu .= $this->set_menu('cetakizin/penetapan_kp', 'Penetapan SK/KP', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
              $menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');
            $menu .= "<li class='dir'>Pembuatan Izin";
            $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/sk', 'Cetak Naskah Izin', 'first');
				      $menu .= $this->set_menu('cetakizin/idx_ctk_kp', 'Cetak Kartu Pengawasan', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
              $menu .= $this->set_menu('permohonan/skditolak', 'Layanan Ditolak');
              $menu .= $this->set_menu('pendaftaran/cabutizin', 'Pencabutan Izin');
              $menu .= $this->set_menu('permohonan/revisisk', 'Perbaikan SK', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
        }

	    	if (!$penetapan && $penomoran) {         // jika hanya penomoran
		    	$menu .= "<li class='dir'>";
          $menu .= "Penomoran";
          $menu .= "<ul>";
            $menu .= $this->set_menu('permohonan/penetapan', 'Penomoran Izin', 'first');
          $menu .= "</ul>";
          $menu .= "</li>";
        }

        $menu .= $this->set_menu('', 'Perpanjangan/Perubahan', 'last');
       //old*/
      
      $menu .= "<li class='last'></li>";
      $menu .= "</ul>";
      $menu .= "</li>";
    }

		if($retribusi) {
			$menu .= "<li class='dir'>";
            $menu .= "RETRIBUSI";
            $menu .= "<ul>";
                $menu .= $this->set_menu('kasir', 'Pembayaran Retribusi', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
		}

		if($penyerahan) {
			$menu .= "<li class='dir'>";
            $menu .= "PENYERAHAN";
            $menu .= "<ul>";
                $menu .= $this->set_menu('pelayanan/ambilsk', 'Penyerahan Izin', 'first');
                $menu .= $this->set_menu('dokumen/pengajuan', 'Pengajuan Salinan', 'last');
                //$menu .= $this->set_menu('dokumen/penyerahan', 'Penyerahan Salinan', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
		}

		if($pengarsipan || $tim_teknis || $tembusan_arsip_ins_lain) {
            $menu .= "<li class='dir'>";
            $menu .= "PENGARSIPAN";
            $menu .= "<ul>";
            if($pengarsipan){
              $menu .= $this->set_menu('arsip', 'Arsip');
            }
            if($tim_teknis || $tembusan_arsip_ins_lain){
              $menu .= $this->set_menu('arsip/timteknis', 'Arsip Perizinan '.img($sprinter));
            }
            $menu .= "<li class='last'></li>";
            $menu .= "</ul>";
            $menu .= "</li>";
		}

		if($pengaduan) {
			$pengaduan = TRUE;
			$menu .= "<li class='dir'>";
            $menu .= "PENGADUAN";
            $menu .= "<ul>";
                $menu .= $this->set_menu('pesan', 'Daftar Pengaduan / Saran', 'first');
                $menu .= $this->set_menu('pesan/pesanpersetujuan', 'Persetujuan Respon Pengaduan');
                $menu .= $this->set_menu('pesan/pesanpengiriman', 'Pengiriman Respon Pengaduan');
                $menu .= $this->set_menu('pesan/pesanbalasan', 'Daftar Balasan', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
		}
        
		if($monitoring) {
		    $menu .= "<li class='dir'>";
            $menu .= "MONITORING";
            $menu .= "<ul>";
                //$menu .= $this->set_menu('monitoring/perhubungan', 'Data Perhubungan', 'first');
           //      $menu .= "  <li class='dir'>Data Perhubungan";
           //      $menu .= "   <ul>";
           //          $menu .= $this->set_menu('monitoring/perhubungan_all', 'Berdasarkan Kategori', 'first');
			        // $menu .= $this->set_menu('monitoring/perhubungan_kdtrayek', 'Berdasarkan Per Trayek');
			        //  $menu .= $this->set_menu('monitoring/perhubungan_terminaltrayek', 'Berdasarkan Terminal/Trayek', 'last');
			        //$menu .= $this->set_menu('monitoring/perhubungan', 'Berdasarkan Tanggal Cetak');
			        //$menu .= $this->set_menu('monitoring/perhubungan', 'Berdasarkan Tanggal Masa Berlaku', 'last');
                // $menu .= "   </ul>";
                // $menu .= "  </li>";
			    $menu .= $this->set_menu('monitoring/perketegori_tertentu', 'Per Kategori', 'first');
			    // $menu .= $this->set_menu('monitoring', 'Per Jenis Perizinan');
			    // $menu .= $this->set_menu('monitoring/persektor', 'Per Bidang');
       //          $menu .= $this->set_menu('monitoring/perwaktu', 'Per Asal Permohonan');
       //          $menu .= $this->set_menu('monitoring/kecamatan', 'Per Wilayah');
                 $menu .= $this->set_menu('monitoring/state', 'Izin Belum Selesai Melebihi Durasi', 'last');
                //$menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan');
                //$menu .= "  <li class='dir'>Status Perizinan";
                //$menu .= "   <ul>";
                    //$menu .= $this->set_menu('info/infoperizinan', 'Izin Disetujui', 'first');
                    //$menu .= $this->set_menu('property/simulasi', 'Izin Ditolak');
			        //$menu .= $this->set_menu('info/infotracking', 'Izin Dicabut');
                // $menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan');
                // $menu .= $this->set_menu('monitoring/integrasi', 'Integrasi Tim Teknis','last');
                //$menu .= "   </ul>";
                //$menu .= "  </li>";
                //$menu .= $this->set_menu('monitoring/pemohon', 'Per Nama Pemohon');
                //$menu .= $this->set_menu('monitoring/perusahaan', 'Per Nama Perusahaan', 'last');
                //$menu .= $this->set_menu('monitoring/pengambilan', 'Per Bulan Pengambilan Izin', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
        }

		if($laporan) {
			$menu .= "<li class='dir'>";
            $menu .= "LAPORAN";
            $menu .= "<ul>";
                //$menu .= $this->set_menu('rekapitulasi/realisasi', 'Realisasi Penerimaan', 'first');
                //$menu .= $this->set_menu('rekapitulasi', 'Rekapitulasi Pendaftaran');
                //$menu .= $this->set_menu('rekapitulasi/izin', 'Rekapitulasi Perizinan', 'first');
				//$menu .= $this->set_menu('rekapitulasi/izin', 'Transaksi Perizinan', 'first');
				//$menu .= $this->set_menu('rekapitulasi/rekap', 'Rekapitulasi Perizinan', 'first');
                //$menu .= $this->set_menu('rekapitulasi/retribusi', 'Rekapitulasi Retribusi');
                //$menu .= $this->set_menu('rekapitulasi/ceklap', 'Rekapitulasi Tinjauan Lapangan');
                //$menu .= $this->set_menu('rekapitulasi/back_lap', 'Rekapitulasi Berkas Kembali');
                //$menu .= $this->set_menu('rekapitulasi/lap_izin', 'Rekapitulasi Izin Tercetak');
                $menu .= $this->set_menu('rekapitulasi/izin/rekaptest', 'Rekapitulasi Perizinan Baru', 'first');
                if ($admin) {
                  $menu .= "<li class='last'></li>";
              //   	$menu .= $this->set_menu('durasiizin/izin', 'Durasi Izin Perbidang');
			    	      // $menu .= $this->set_menu('kinerjaizin/izin', 'Kinerja Izin Perbidang');
				          // $menu .= $this->set_menu('durasisemuabidang', 'Durasi Semua Bidang');
				          // $menu .= $this->set_menu('kinerjasemuabidang', 'Kinerja Semua Bidang','last');
                } else {
                	$menu .= "<li class='last'></li>";
                }
            $menu .= "</ul>";
            $menu .= "</li>";
		}

    if($bisbesar) {
            // $menu .= "<li class='dir'>";
            // $menu .= "BIS BESAR";
            //  $menu .= "<ul>";
            //     //$menu .= $this->set_menu('monitoring/perhubungan', 'Data Perhubungan', 'first');
            //     $menu .= "  <li class='dir'>Data Induk";
            //     $menu .= "   <ul>";
            //         $menu .= $this->set_menu('bisbesar/c_pengusaha', 'Pengusaha', 'first');
            //         $menu .= $this->set_menu('bisbesar/c_kendaraan', 'Kendaraan');
            //         $menu .= $this->set_menu('bisbesar/c_terminal', 'Terminal');
            //         $menu .= $this->set_menu('bisbesar/c_lintasan', 'Lintasan Trayek', 'last');
            //         //$menu .= $this->set_menu('bisbesar/c_kota', 'Kota / Kabupaten','last');
            //     $menu .= "   </ul>";
            //     $menu .= "  </li>";

            //    /* $menu .= "  <li class='dir'>Registrasi";
            //     $menu .= "   <ul>";
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Retribusi Izin Trayek / Operasi', 'first');
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pembaharuan KP','last');
                 
            //     $menu .= "   </ul>";
            //     $menu .= "  </li>";*/
            //      $menu .= "  <li class='dir'>Perizinan";
            //     $menu .= "   <ul>";
            //        // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Permohonan UPTD', 'first');
            //         $menu .= $this->set_menu('bisbesar/c_izintrayek', 'Pengelolaan Data Izin Trayek / Operasi', 'last');
            //        // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pembaharuan Masa Berlaku Izin SK');
            //        // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pertimbangan Teknis','last');
                 
            //    $menu .= "   </ul>";
            //     $menu .= "  </li>";
 
            //   /*   $menu .= "  <li class='dir'>Informasi";
            //     $menu .= "   <ul>";
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Kartu Induk Pengusaha Angkutan', 'first');
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Kartu Induk Kendaraan');
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Informasi Izin SK Habis');
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Persinggungan Lintasan Trayek','last');
                 
            //     $menu .= "   </ul>";
            //     $menu .= "  </li>";

            //     $menu .= "  <li class='dir'>Pelaporan";
            //     $menu .= "   <ul>";
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pencetakan Kartu', 'first');
            //         $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Laporan Bulanan','last');
                 
            //     $menu .= "   </ul>";
            //     $menu .= "  </li>";*/
            //     $menu .= "<li class='last'></li>";
            // $menu .= "</ul>";
            // $menu .= "</li>";
        }

 if($pengenalimpor) {
            // $menu .= "<li class='dir'>";
            // $menu .= "API";
            // $menu .= "<ul>";
            
            //     $menu .= $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan_approve', 'Validasi Laporan Import', 'first');
            //     $menu .= $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan', 'Data Laporan Import','last');
            // $menu .= "</ul>";
            // $menu .= "</li>";
        }
		
		 if($pengarsipan || $tim_teknis) {
            // $menu .= "<li class='dir'>";
            // $menu .= "SIAP";
            // $menu .= "<ul>";
           
            // if($pengarsipan ){
            //  // $menu .= $this->set_menu('arsip', 'Arsip', 'first');
            //    // $menu .= $this->set_menu('upload_arsip', 'Upload FIle Arsip', 'first');
            //    // $menu .= $this->set_menu('upload_arsip/rekapupload', 'Rekap Jumlah Upload File');
            //     $menu .= $this->set_menu('laporan_arsip', 'Daftar Arsip');
            // }
            //  /*if($tim_teknis ){
            //    $menu .= $this->set_menu('upload_arsip/report_arsip', 'Report Arsip','last');
            // } */  

          

            // $menu .= "</ul>";
            // $menu .= "</li>";

        }
		return $menu;
    }

}

// This is the end of Menu_loader class