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

  public function create_menu($list_role = NULL,$opd=NULL) {
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

    foreach ($list_role as $list) {
      switch ($list->id_role) {
        //case '24' :              // sementara hanya untuk keperluan pa dindin dan harap hapus kembali sytax dibawah ini pada folder pelayanan/pendaftaran
		    //                         //	if ($list_auth->id_role === '24') {    // khusus pa dindin
        //                         //       $enabled = TRUE;
        //                         //   }
        //    $menu .= "<li class='dir'>";
        //    $menu .= "PENDAFTARAN";
        //    $menu .= "<ul>";
				//		$menu .= $this->set_menu('pelayanan/pendaftaran', 'Pendaftaran', 'last');
        //    $menu .= "</ul>";
        //    $menu .= "</li>";
        //    break;
				case '1' :
          $setting_perizinan = TRUE;
          break;
				case '2' :
          $setting_sk = TRUE;
          break;
				case '3' :
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
        case '8' :
					$monitoring = TRUE;
          break;
        case '9' :  
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
				case '14' :
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
				case '21' :
					$pengarsipan = TRUE;
          break;
				case '26' :
					$penadatangan = TRUE;
          break;
				case '28' :
					$penjadualan_sp = TRUE;
          break;
				case '29' :
					$suratkeluar = TRUE;
          break;
          case '30' :
          $bisbesar = TRUE;
          break;
        case '31' :
          $pengenalimpor = TRUE;
          break;
        case '32' :  
          $komitmen_oss = TRUE;
          break;
				case '99':
          $menu .= "<li class='dir'>";
          $menu .= "API MAINTAINER";
          $menu .= "<ul>";
            $menu .= $this->set_menu('api/maintainer', 'API', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
          break;
        case '100':
          $menu .= "<li class='dir'>";
          $menu .= "MASTER";
          $menu .= "<ul>";
            $menu .= $this->set_menu('role', 'Setting Peran');
            $menu .= $this->set_menu('pengguna', 'Setting Pengguna', 'last');
          $menu .= "</ul>";
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
			      $menu .= $this->set_menu('retribusi', 'Nilai Retribusi');
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
            $menu .= $this->set_menu('settings/satuan', 'Satuan');
            $menu .= $this->set_menu('settings/webservice', 'Web Service','last');
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
          $menu .= $this->set_menu('pelayanan/komitmen_oss', 'Komitmen OSS');
          $menu .= $this->set_menu('pelayanan/pendaftaran', 'Permohonan Izin');
          if($admin)
            $menu .= $this->set_menu('permohonan/revisisk', 'Perbaikan Naskah Izin');
          //$menu .= $this->set_menu('pendaftaran/index/2', 'Perubahan Izin');
          //$menu .= $this->set_menu('pendaftaran/index/3', 'Perpanjangan Izin');
          //$menu .= $this->set_menu('pendaftaran/index/4', 'Daftar Ulang Izin');
          $menu .= $this->set_menu('', '<hr>');
          $menu .= $this->set_menu('pemohon', 'Data Pemohon');
          $menu .= $this->set_menu('perusahaan', 'Data Perusahaan', 'last');
        $menu .= "   </ul>";
        $menu .= "  </li>";
      }
            
		  if($penadatangan) {
        $menu .= $this->set_menu('pelayanan/tandatangan', 'Penandatanganan');
		    //$menu .= $this->set_menu('pelayanan/sementara', 'Penandatanganan');
      }

		  if($opd) {
        $menu .= $this->set_menu('settings/surat_keluar', 'Surat Masuk');
      }else{
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
            $menu .= $this->set_menu('permohonan/bap', 'Pertimbangan Teknis', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
        }

        if ($penetapan){           // jika penetapan
        	$menu .= "<li class='dir'>Penetapan";
          $menu .= "<ul>";
              $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan Naskah Izin', 'first');
			        $menu .= $this->set_menu('cetakizin/penetapan_kp', 'Penetapan SK/KP', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
        }
        if ($penomoran){          // jika penomoran 	
          $menu .= $this->set_menu('permohonan/penetapan', 'Penomoran Izin');
        }
        
        //$menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');

        if ($penetapan){           // jika penetapan
          $menu .= "<li class='dir'>Pembuatan Izin";
          $menu .= "<ul>";
            $menu .= $this->set_menu('permohonan/sk', 'Cetak Naskah Izin', 'first');
				    $menu .= $this->set_menu('cetakizin/idx_ctk_kp', 'Cetak Kartu Pengawasan', 'last');
          $menu .= "</ul>";
          $menu .= "</li>";
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
                $menu .= $this->set_menu('dokumen/pengajuan', 'Pengajuan Salinan');
                $menu .= $this->set_menu('dokumen/penyerahan', 'Penyerahan Salinan', 'last');
            $menu .= "</ul>";
            $menu .= "</li>";
		}

		if($pengarsipan) {
            $menu .= "<li class='dir'>";
            $menu .= "PENGARSIPAN";
            $menu .= "<ul>";
                $menu .= $this->set_menu('arsip', 'Arsip', 'last');
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
                $menu .= "  <li class='dir'>Data Perhubungan";
                $menu .= "   <ul>";
                    $menu .= $this->set_menu('monitoring/perhubungan_all', 'Berdasarkan Kategori', 'first');
			        $menu .= $this->set_menu('monitoring/perhubungan_kdtrayek', 'Berdasarkan Per Tayek', 'last');
			        //$menu .= $this->set_menu('monitoring/perhubungan', 'Berdasarkan Tanggal Cetak');
			        //$menu .= $this->set_menu('monitoring/perhubungan', 'Berdasarkan Tanggal Masa Berlaku', 'last');
                $menu .= "   </ul>";
                $menu .= "  </li>";
			    $menu .= $this->set_menu('monitoring/perketegori_tertentu', 'Per Kategori');
			    $menu .= $this->set_menu('monitoring', 'Per Jenis Perizinan');
			    $menu .= $this->set_menu('monitoring/persektor', 'Per Bidang');
                $menu .= $this->set_menu('monitoring/perwaktu', 'Per Asal Permohonan');
                $menu .= $this->set_menu('monitoring/kecamatan', 'Per Wilayah');
                $menu .= $this->set_menu('monitoring/state', 'Perizinan Belum/Sudah Jadi Dan Kadaluarsa');
                //$menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan');
                //$menu .= "  <li class='dir'>Status Perizinan";
                //$menu .= "   <ul>";
                    //$menu .= $this->set_menu('info/infoperizinan', 'Izin Disetujui', 'first');
                    //$menu .= $this->set_menu('property/simulasi', 'Izin Ditolak');
			        //$menu .= $this->set_menu('info/infotracking', 'Izin Dicabut');
                $menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan','last');
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
                $menu .= $this->set_menu('rekapitulasi/izin', 'Rekapitulasi Perizinan', 'first');
				//$menu .= $this->set_menu('rekapitulasi/izin', 'Transaksi Perizinan', 'first');
				//$menu .= $this->set_menu('rekapitulasi/rekap', 'Rekapitulasi Perizinan', 'first');
                //$menu .= $this->set_menu('rekapitulasi/retribusi', 'Rekapitulasi Retribusi');
                //$menu .= $this->set_menu('rekapitulasi/ceklap', 'Rekapitulasi Tinjauan Lapangan');
                //$menu .= $this->set_menu('rekapitulasi/back_lap', 'Rekapitulasi Berkas Kembali');
                //$menu .= $this->set_menu('rekapitulasi/lap_izin', 'Rekapitulasi Izin Tercetak');
		    	$menu .= $this->set_menu('durasiizin/izin', 'Durasi Izin Perbidang');
		    	$menu .= $this->set_menu('kinerjaizin/izin', 'Kinerja Izin Perbidang');
			    $menu .= $this->set_menu('durasisemuabidang', 'Durasi Semua Bidang');
			    $menu .= $this->set_menu('kinerjasemuabidang', 'Kinerja Semua Bidang','last');
            $menu .= "</ul>";
            $menu .= "</li>";
		}

    if($bisbesar) {
            $menu .= "<li class='dir'>";
            $menu .= "BIS BESAR";
             $menu .= "<ul>";
                //$menu .= $this->set_menu('monitoring/perhubungan', 'Data Perhubungan', 'first');
                $menu .= "  <li class='dir'>Data Induk";
                $menu .= "   <ul>";
                    $menu .= $this->set_menu('bisbesar/c_pengusaha', 'Pengusaha', 'first');
                    $menu .= $this->set_menu('bisbesar/c_kendaraan', 'Kendaraan');
                    $menu .= $this->set_menu('bisbesar/c_terminal', 'Terminal');
                    $menu .= $this->set_menu('bisbesar/c_lintasan', 'Lintasan Trayek', 'last');
                    //$menu .= $this->set_menu('bisbesar/c_kota', 'Kota / Kabupaten','last');
                 
                $menu .= "   </ul>";
                $menu .= "  </li>";

               /* $menu .= "  <li class='dir'>Registrasi";
                $menu .= "   <ul>";
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Retribusi Izin Trayek / Operasi', 'first');
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pembaharuan KP','last');
                 
                $menu .= "   </ul>";
                $menu .= "  </li>";*/
                 $menu .= "  <li class='dir'>Perizinan";
                $menu .= "   <ul>";
                   // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Permohonan UPTD', 'first');
                    $menu .= $this->set_menu('bisbesar/c_izintrayek', 'Pengelolaan Data Izin Trayek / Operasi', 'last');
                   // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pembaharuan Masa Berlaku Izin SK');
                   // $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pertimbangan Teknis','last');
                 
               $menu .= "   </ul>";
                $menu .= "  </li>";
 
              /*   $menu .= "  <li class='dir'>Informasi";
                $menu .= "   <ul>";
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Kartu Induk Pengusaha Angkutan', 'first');
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Kartu Induk Kendaraan');
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Informasi Izin SK Habis');
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Persinggungan Lintasan Trayek','last');
                 
                $menu .= "   </ul>";
                $menu .= "  </li>";

                $menu .= "  <li class='dir'>Pelaporan";
                $menu .= "   <ul>";
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Pencetakan Kartu', 'first');
                    $menu .= $this->set_menu('bisbesar/perhubungan_all', 'Laporan Bulanan','last');
                 
                $menu .= "   </ul>";
                $menu .= "  </li>";*/
                $menu .= "<li class='last'></li>";
            $menu .= "</ul>";
            $menu .= "</li>";
        }

 if($pengenalimpor) {
            $menu .= "<li class='dir'>";
            $menu .= "API";
            $menu .= "<ul>";
            
                $menu .= $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan_approve', 'Validasi Laporan Import', 'first');
                $menu .= $this->set_menu('pengenalimpor/c_pengenalimpor/perusahaan', 'Data Laporan Import','last');
            $menu .= "</ul>";
            $menu .= "</li>";
        }
		
		 if($pengarsipan || $tim_teknis) {
            $menu .= "<li class='dir'>";
            $menu .= "SIAP";
            $menu .= "<ul>";
           
            if($pengarsipan ){
             // $menu .= $this->set_menu('arsip', 'Arsip', 'first');
               // $menu .= $this->set_menu('upload_arsip', 'Upload FIle Arsip', 'first');
               // $menu .= $this->set_menu('upload_arsip/rekapupload', 'Rekap Jumlah Upload File');
                $menu .= $this->set_menu('laporan_arsip', 'Daftar Arsip');
            }
             /*if($tim_teknis ){
               $menu .= $this->set_menu('upload_arsip/report_arsip', 'Report Arsip','last');
            } */  

          

            $menu .= "</ul>";
            $menu .= "</li>";

        }
		return $menu;
    }

}

// This is the end of Menu_loader class