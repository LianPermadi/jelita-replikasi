<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Menu_loader class
 * Use this class to applicated your module here.
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
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
        $menu .= "Master";
        $menu .= "<ul>";
        $menu .= $this->set_menu('role', 'Setting Peran');
        $menu .= $this->set_menu('pengguna', 'Setting Pengguna');
        $menu .= $this->set_menu('install', 'Konfigurasi', 'last');
        $menu .= "</ul>";
        $menu .= "</li>";
        return $menu;
    }

    public function create_menu($list_role = NULL) {
		$menu = NULL;
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
		

        foreach ($list_role as $list) {
            switch ($list->id_role) {
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
                    $menu .= "<li class='dir'>";
                    $menu .= "Monitoring";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('monitoring', 'Per Jenis Perizinan', 'first');
					$menu .= $this->set_menu('monitoring/persektor', 'Per Sektor');
                    $menu .= $this->set_menu('monitoring/perwaktu', 'Per Jangka Waktu');
                    $menu .= $this->set_menu('monitoring/kecamatan', 'Per Desa Dan Kecamatan');
                    $menu .= $this->set_menu('monitoring/state', 'Perizinan Belum/Sudah Jadi Dan Kadaluarsa');
// PBS Created
//                    $menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan');
                    $menu .= "  <li class='dir'>Status Perizinan";
                    $menu .= "   <ul>";
                    //$menu .= $this->set_menu('info/infoperizinan', 'Izin Disetujui', 'first');
                    //$menu .= $this->set_menu('property/simulasi', 'Izin Ditolak');
				    //$menu .= $this->set_menu('info/infotracking', 'Izin Dicabut');
                    $menu .= $this->set_menu('monitoring/status', 'Per Status Perizinan','last');
                    $menu .= "   </ul>";
                    $menu .= "  </li>";
// EOF PBS
                    $menu .= $this->set_menu('monitoring/pemohon', 'Per Nama Pemohon');
                    $menu .= $this->set_menu('monitoring/perusahaan', 'Per Nama Perusahaan');
                    $menu .= $this->set_menu('monitoring/pengambilan', 'Per Bulan Pengambilan Izin', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '9' :  
                    $pendaftaran = TRUE;
                    break;
				case '10':
                    $menu .= "<li class='dir'>";
                    $menu .= "Laporan";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('rekapitulasi/realisasi', 'Realisasi Penerimaan', 'first');
                    $menu .= $this->set_menu('rekapitulasi', 'Rekapitulasi Pendaftaran');
                    $menu .= $this->set_menu('rekapitulasi/izin', 'Rekapitulasi Perizinan');
                    $menu .= $this->set_menu('rekapitulasi/retribusi', 'Rekapitulasi Retribusi');
                    $menu .= $this->set_menu('rekapitulasi/ceklap', 'Rekapitulasi Tinjauan Lapangan');
                    $menu .= $this->set_menu('rekapitulasi/back_lap', 'Rekapitulasi Berkas Kembali');
                    $menu .= $this->set_menu('rekapitulasi/lap_izin', 'Rekapitulasi Izin Tercetak');
					$menu .= "  <li class='dir'>Tingkat Ketepatan";
                    $menu .= "   <ul>";
                    $menu .= $this->set_menu('durasiizin/izin', 'Ketepatan Perbidang','first');
                    $menu .= $this->set_menu('durasisemuabidang', 'Ketepatan Semua Bidang','last');
                    $menu .= "   </ul>";
                    $menu .= "  </li>";
					$menu .= "  <li class='dir'>Tingkat Penyelesaian";
                    $menu .= "   <ul>";
                    $menu .= $this->set_menu('kinerjaizin/izin', 'Penyelesaian Perbidang','first');
                    $menu .= $this->set_menu('kinerjasemuabidang', 'Penyelesaian Semua Bidang','last');
                    $menu .= "   </ul>";
                    $menu .= "  </li>";
					
					$menu .= "  <li class='dir'>Resume Evaluasi";
                    $menu .= "   <ul>";
                    $menu .= $this->set_menu('resume','Resume Perbidang','first');
                    $menu .= $this->set_menu('total', 'Resume Perbulan','last');
                    $menu .= "   </ul>";
                    $menu .= "  </li>";
					$menu .= "  <li class='dir'>Indeks Kepuasan Masyarakat";
                    $menu .= "   <ul>";
                    $menu .= $this->set_menu('ikm/filterdata','IKM Perbidang','first');
                    $menu .= $this->set_menu('ikm/filterdatasemuabidang', 'IKM Total','last');
                    $menu .= "   </ul>";
                    $menu .= "  </li>";
					$menu .= $this->set_menu('pengaduantriwulan', 'Pengaduan Pertriwulan','last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '11':
                    $pendataan = TRUE;
                    break;
                case '12':
                    $tim_teknis = TRUE;
                    break;
                case '13':
                    $penetapan = TRUE;
                    break;
				case '14' :
					$menu .= "<li class='dir'>";
                    $menu .= "Pengaduan";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('pesan', 'Daftar Pengaduan / Saran', 'first');
                    $menu .= $this->set_menu('pesan/pesanpersetujuan', 'Persetujuan Respon Pengaduan');
                    $menu .= $this->set_menu('pesan/pesanpengiriman', 'Pengiriman Respon Pengaduan');
                    $menu .= $this->set_menu('pesan/pesanbalasan', 'Daftar Balasan', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '15':
                    $menu .= "<li class='dir'>";
                    $menu .= "Izin";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('pelayanan/ambilsk', 'Penyerahan Izin', 'first');
                    $menu .= $this->set_menu('dokumen/pengajuan', 'Pengajuan Salinan');
                    $menu .= $this->set_menu('dokumen/penyerahan', 'Penyerahan Salinan', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '16':
                    $menu .= "<li class='dir'>";
                    $menu .= "Kasir";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('kasir', 'Pembayaran Retribusi', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '17':
                    $customer_service = TRUE;
                    break;
				case '19':
                    $penomoran = TRUE;
                    break;
				case '21' :
                    $menu .= "<li class='dir'>";
                    $menu .= "Pengarsipan";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('arsip', 'Arsip', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
				case '99':
                    $menu .= "<li class='dir'>";
                    $menu .= "API Maintainer";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('api/maintainer', 'API', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
                    break;
                case '100':
                    $menu .= "<li class='dir'>";
                    $menu .= "Master";
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
            $menu .= "Konfigurasi";
            $menu .= "<ul>";
            if($setting_perizinan) {
                $menu .= "  <li class='dir'>Setting Perizinan";
                $menu .= "   <ul>";
                $menu .= $this->set_menu('perizinan', 'Jenis Perizinan','first');
				$menu .= $this->set_menu('perizinan/paralel', 'Perizinan Paralel');
				$menu .= $this->set_menu('perizinan/persyaratanizin', 'Persyaratan Izin');
				$menu .= $this->set_menu('property/master', 'Property Pendataan');
				$menu .= $this->set_menu('retribusi', 'Nilai Retribusi');
                $menu .= $this->set_menu('perizinan/koefisientarif', 'Koefisien Tarif');
				$menu .= $this->set_menu('ikm', 'Indeks Kepuasan Masyarakat','last');
				
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
//                $menu .= $this->set_menu('role', 'Setting Peran');
                $menu .= $this->set_menu('unitkerja', 'Unit Kerja');
                $menu .= $this->set_menu('pengguna', 'Pengguna');
                $menu .= "   </ul>";
                $menu .= "  </li>";
            }

            if($setting_wilayah)
                {
                $menu .= "  <li class='dir'>Setting Wilayah";
                $menu .= "   <ul>";
				$menu .= $this->set_menu('wilayah', 'Provinsi','first');
                $menu .= $this->set_menu('wilayah/kabupaten', 'Kabupaten');
                $menu .= $this->set_menu('wilayah/kecamatan', 'Kecamatan');
                $menu .= $this->set_menu('wilayah/kelurahan', 'Kelurahan', 'last');
                $menu .= "   </ul>";
                $menu .= "  </li>";
            }

            if($keamanan_data)
                {
                $menu .= "<li class='dir'>";
                    $menu .= "Keamanan Data";
                    $menu .= "<ul>";
                    $menu .= $this->set_menu('log', 'Log Activity', 'first');
                    $menu .= $this->set_menu('log/log_backup/backup', 'Backup Database');
                    $menu .= $this->set_menu('log/log_backup', 'Restore Database', 'last');
                    $menu .= "</ul>";
                    $menu .= "</li>";
              
            }

            $menu .= "<li class='last'></li>";
            $menu .= "</ul>";
            $menu .= "</li>";
        }
		
		if($pendaftaran || $customer_service) {
            $menu .= "<li class='dir'>";
//            $menu .= "Pelayanan";
            $menu .= "Administrasi";
            $menu .= "<ul>";
            if($pendaftaran) {
                $menu .= "  <li class='dir'>Pendaftaran";
                $menu .= "   <ul>";
                $menu .= $this->set_menu('pelayanan/sementara', 'Permohonan Sementara', 'first');
                $menu .= $this->set_menu('pelayanan/pendaftaran', 'Permohonan Izin Baru');
                $menu .= $this->set_menu('pendaftaran/index/2', 'Perubahan Izin');
                $menu .= $this->set_menu('pendaftaran/index/3', 'Perpanjangan Izin');
                $menu .= $this->set_menu('pendaftaran/index/4', 'Daftar Ulang Izin');
                $menu .= $this->set_menu('', '<hr>');
                $menu .= $this->set_menu('pemohon', 'Data Pemohon');
                $menu .= $this->set_menu('perusahaan', 'Data Perusahaan', 'last');
                $menu .= "   </ul>";
                $menu .= "  </li>";
            }

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
        }

        if ($pendataan || $tim_teknis || $penetapan || $penomoran) {
			$text = "Pelayanan";
            if(!$pendataan && !$tim_teknis && !$penetapan) $text = "Penomoran";
            $menu .= "<li class='dir'>";
            $menu .= $text;
            $menu .= "<ul>";

            if ($pendataan) {
                $menu .= "<li class='dir'>Pendataan";
                $menu .= "<ul>";
                $menu .= $this->set_menu('pendataan', 'Entry Data Perizinan', 'first');
                $menu .= $this->set_menu('survey', 'Penjadwalan Tinjauan');
                $menu .= "<li class='last'></li>";
                $menu .= "</ul>";
                $menu .= "</li>";
            }

            if ($tim_teknis) {
                $menu .= "<li class='dir'>Tim Teknis";
                $menu .= "<ul>";
                $menu .= $this->set_menu('survey/result', 'Entry Hasil Tinjauan', 'first');
                $menu .= $this->set_menu('permohonan/bap', 'Pembuatan Berita Acara Pemeriksaan', 'last');
                $menu .= "</ul>";
                $menu .= "</li>";
            }

		    if ($penetapan && $penomoran) {          // jika penetapan dan penomoran
                $menu .= "<li class='dir'>Penetapan";
                $menu .= "<ul>";
                $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan/Penomoran Izin', 'first');
                $menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');
                $menu .= $this->set_menu('permohonan/sk', 'Pembuatan Izin');
                $menu .= $this->set_menu('permohonan/skditolak', 'Layanan Ditolak');
                $menu .= $this->set_menu('pendaftaran/cabutizin', 'Pencabutan Izin', 'last');
                $menu .= "</ul>";
                $menu .= "</li>";
            }
 
	    	if ($penetapan && !$penomoran) {         // jika hanya penetapan 
                $menu .= "<li class='dir'>Penetapan";
                $menu .= "<ul>";
                $menu .= $this->set_menu('permohonan/penetapan', 'Penetapan Izin', 'first');
                $menu .= $this->set_menu('permohonan/skrd', 'Pembuatan SKRD');
                $menu .= $this->set_menu('permohonan/sk', 'Pembuatan Izin');
                $menu .= $this->set_menu('permohonan/skditolak', 'Layanan Ditolak');
                $menu .= $this->set_menu('pendaftaran/cabutizin', 'Pencabutan Izin', 'last');
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

			$menu .= "<li class='last'></li>";
            $menu .= "</ul>";
            $menu .= "</li>";

        }

        return $menu;
    }

}

// This is the end of Menu_loader class
