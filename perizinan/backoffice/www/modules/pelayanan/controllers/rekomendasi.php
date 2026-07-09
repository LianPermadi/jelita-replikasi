<?php

/**
 * Description of Permohonan Pengajuan Rekomendasi
 *
 * @author agusnur
 * Created : 02 Sep 2010
 */
class Rekomendasi extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->daftar = new tmpermohonan();
        $this->surat = new tmsurat_permohonan();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '20') {
                $enabled = TRUE;
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    /*
     * edit is a method to show page for updating data
     */
    public function edit($id_daftar = NULL, $id_link = NULL) {
        $daftar = $this->daftar->get_by_id($id_daftar);
        $surat = $daftar->tmsurat_permohonan->get();

        if($surat->id){
            $save = "update";
            $id_surat = $surat->id;
            $no_surat = $surat->no_surat;
            $tgl_surat = $surat->tgl_surat;
			$sifat = $surat->sifat;
            $lampiran = $surat->lampiran;
			$hal = $surat->hal;
            $keterangan = $surat->keterangan;
        }else{
            $save = "save";
            $id_surat = "";
            $no_surat = "";
            $tgl_surat = "";
            $sifat = "Biasa";
            $lampiran = "1 ( Satu ) Berkas";
			$hal = "";
            $keterangan = "";
        }
        $data['save_method'] = $save;
        $data['daftar'] = $daftar;
        $data['id_link'] = $id_link;
        $data['id_daftar'] = $id_daftar;
        $data['id_surat'] = $id_surat;
        $data['no_surat'] = $no_surat;
        $data['tgl_surat'] = $tgl_surat;
		$data['sifat'] = $sifat;
        $data['lampiran'] = $lampiran;
		$data['hal'] = $hal;
        $data['keterangan'] = $keterangan;

        $js =  "
                var base_url = '". base_url() ."';
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $('#form').validate();
                } );
            ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Surat Permohonan Rekomendasi";
        $this->template->build('rekomendasi_edit', $this->session_info);
        
    }

    /*
     * Save and update for manipulating data.
     */
    public function save() {
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        /* Input Data */
        $this->surat->no_surat = $this->input->post('no_surat');
        $this->surat->tgl_surat = $this->input->post('tgl_surat');
        $this->surat->lampiran = $this->input->post('lampiran');
        $this->surat->keterangan = $this->input->post('keterangan');
		$this->surat->sifat = $this->input->post('sifat');
		$this->surat->hal = $this->input->post('hal');

        /* Input Relasi Tabel*/
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id_daftar'));
		$no_pendaftaran = $permohonan->pendaftaran_id;

        /* Input Data Tracking Progress */
        //$sts_izin = new trstspermohonan();
        //$sts_izin->get_by_id('2'); //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        //$data_status = new tmtrackingperizinan_trstspermohonan();
        //$list_tracking = $permohonan->tmtrackingperizinan->get();
        //if($list_tracking){
        //    foreach ($list_tracking as $data_track){
        //        $tracking_id = 0;
        //        $data_status = new tmtrackingperizinan_trstspermohonan();
        //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
        //                    ->where('trstspermohonan_id', $sts_izin->id)->get();
        //        if($data_status->tmtrackingperizinan_id){
        //            $tracking_id = $data_status->tmtrackingperizinan_id;
        //        }
        //    }
        //}
        $tracking_izin = new tmtrackingperizinan();
        //$tracking_izin->get_by_id($tracking_id);
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Entry Data')->get();
		if($tracking_izin->pendaftaran_id){
            $hit_cetak = $tracking_izin->hit_cetak + 1;
   		    $his_cetak = $tracking_izin->his_cetak;
			$tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
    		$tracking_izin->hit_cetak = $hit_cetak;
			$tracking_izin->his_cetak = $his_cetak.'SAVE^'.$r_name.'^'.$this->lib_date->get_date_now().'^No.Surat:'.$this->input->post('no_surat').';';
			$tracking_izin->save();
        }
        //$tracking_izin->status = 'Update';
        //$tracking_izin->d_entry = $this->lib_date->get_date_now();
        //$tracking_izin->save();
//            $tracking_izin->save($sts_izin);
//            $tracking_izin->save($permohonan);

        if(! $this->surat->save(array($permohonan))) {
            echo '<p>' . $this->surat->error->string . '</p>';
        } else {
            redirect('pelayanan/rekomendasi/edit/'.$this->input->post('id_daftar'));
        }
    }

    public function update() {
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $surat = new tmsurat_permohonan();
        $surat->get_by_id($this->input->post('id_surat'));
        $surat->no_surat = $this->input->post('no_surat');
        $surat->tgl_surat = $this->input->post('tgl_surat');
        $surat->lampiran = $this->input->post('lampiran');
        $surat->keterangan = $this->input->post('keterangan');
		$surat->sifat = $this->input->post('sifat');
		$surat->hal = $this->input->post('hal');

        /* Input Relasi Tabel*/
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id_daftar'));
		$no_pendaftaran = $permohonan->pendaftaran_id;

        /* Input Data Tracking Progress */
        //$sts_izin = new trstspermohonan();
        //$sts_izin->get_by_id('2'); //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        //$data_status = new tmtrackingperizinan_trstspermohonan();
        //$list_tracking = $permohonan->tmtrackingperizinan->get();
        //if($list_tracking){
        //    foreach ($list_tracking as $data_track){
        //        $tracking_id = 0;
        //        $data_status = new tmtrackingperizinan_trstspermohonan();
        //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
        //        ->where('trstspermohonan_id', $sts_izin->id)->get();
        //        if($data_status->tmtrackingperizinan_id){
        //            $tracking_id = $data_status->tmtrackingperizinan_id;
        //        }
        //    }
        //}
        $tracking_izin = new tmtrackingperizinan();
        //$tracking_izin->get_by_id($tracking_id);
		$tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Entry Data')->get();
		if($tracking_izin->pendaftaran_id){
            $hit_cetak = $tracking_izin->hit_cetak + 1;
   		    $his_cetak = $tracking_izin->his_cetak;
			$tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
    		$tracking_izin->hit_cetak = $hit_cetak;
			$tracking_izin->his_cetak = $his_cetak.'EDIT^'.$r_name.'^'.$this->lib_date->get_date_now().'^No.Surat:'.$this->input->post('no_surat').';';
			$tracking_izin->save();
        }
        //$tracking_izin->status = 'Update';
        //$tracking_izin->d_entry = $this->lib_date->get_date_now();
        //$tracking_izin->save();
//            $tracking_izin->save($sts_izin);
//            $tracking_izin->save($permohonan);
        
        $update = $surat->save();
        if($update) {
            redirect('pelayanan/rekomendasi/edit/'.$this->input->post('id_daftar'));
        }
    }

    public function cetak($id_daftar = NULL) {
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);

        $nama_surat = "cetak_permohonan";

		// Ambil Nama Jenis perijinan; Create -> Budi
		$kdjenis_ijin = new tmpermohonan_trjenis_permohonan();
		$kdjenis_ijin->get_by_id($id_daftar);
		$kd_jenis_ijin = $kdjenis_ijin->trjenis_permohonan_id;
        $kdjenis_ijin = new trjenis_permohonan();
		$kdjenis_ijin->get_by_id($kd_jenis_ijin);
        $kd_jenis_ijin = $kdjenis_ijin->n_permohonan;
//        $kd_jenis_ijin =  $kdjenis_ijin->tmpermohonan_id->get_by_id($id_daftar);
        // end Create

		$this->settings = new settings();
        $this->settings->where('name','app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name','app_city')->get();

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $pemohon = $permohonan->tmpemohon->get();
        $perusahaan = $permohonan->tmperusahaan->get();
        $surat = $permohonan->tmsurat_permohonan->get();
        $jenis_izin = $permohonan->trperizinan->get();
        $dinas = $permohonan->trperizinan->trunitkerja->get();
		$n_dinas = $dinas->n_unitkerja;
        $kd_dinas = $dinas->id;
		$alamat_perusahaan = $perusahaan->a_perusahaan;
		$alamat_perusahaan1 = '';
		$bidang = "";
		$al_dinas = "";
		$nama_pemohon = $pemohon->n_pemohon;
        $nama_perusahaan = $perusahaan->n_perusahaan;
        switch ($kd_dinas) {
			case 13; $bidang = "Bidang Tata Ruang Kawasan";                            // Kimrum (KBU)
     		         break;
            case 20; $bidang = "Ketua Tim Teknis Perizinan Bidang Kebinamargaan";      // Bina Marga
			         $al_dinas = "Jl. Asia Afrika No. 79"; 
					 $n_dinas = '';
					 break;
		    case 21; $bidang = "(Bidang Bina Manfaat)";                                // PSDA
			         $al_dinas = "Jl. Braga No. 37"; 
					 break;
			case 22; $bidang = "Bidang Mineral Geologi dan Air Tanah";                 // ESDM (ABT)
			         break;
		}

		$kdi = $jenis_izin->id;
		$nama_surat = "cetak_permohonan";  
		switch ($kdi) {
            case  71; $nama_surat = "cetak_permohonan_ispt";                 // untuk ISPT Di Ruang Milik Jalan (Rumija)
			          break;                      
		    case 145; $nama_surat = "cetak_permohonan_ispt";                 // untuk ISPT Di Tanah Jalan Diluar Ruang Milik Jalan (Rumija)
			          break;
            case 216; $nama_surat = "cetak_permohonan_abt";                  // untuk ABT
			          break;
		    case  83; $nama_surat = "cetak_permohonan_kbu";                  // untuk KBU
			          $nama_pemohon = substr($permohonan->dt_teknis1,0,strpos($permohonan->dt_teknis1,'^'));
                      $nama_perusahaan = '';
			          $alamat_perusahaan = substr($permohonan->dt_teknis6,0,strpos($permohonan->dt_teknis6,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis7,0,strpos($permohonan->dt_teknis7,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis8,0,strpos($permohonan->dt_teknis8,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis9,0,strpos($permohonan->dt_teknis9,'^'));
					  $alamat_perusahaan1 = substr($permohonan->dt_teknis2,0,strpos($permohonan->dt_teknis2,'^')).' - ';
                      $alamat_perusahaan1 = $alamat_perusahaan1 . substr($permohonan->dt_teknis3,0,strpos($permohonan->dt_teknis3,'^'));
			          break;
			case 41;  $nama_surat = "cetak_permohonan_sipi";                   // untuk SIPI
			          $alamat_perusahaan = $pemohon->a_pemohon;
					  $alamat_perusahaan1 = '';
			          break;
		}
        
		$nama_izin = $jenis_izin->n_perizinan_cetak;
		if($nama_izin == "") $nama_izin = $jenis_izin->n_perizinan;
        $alenia_1 = $jenis_izin->sartek_alenia1; if($alenia_1 == '-') $alenia_1 = '';
		$alenia_2 = $jenis_izin->sartek_alenia2; if($alenia_2 == '-') $alenia_2 = '';
		$alenia_3 = $jenis_izin->sartek_alenia3; if($alenia_3 == '-') $alenia_3 = '';
		$alenia_4 = $jenis_izin->sartek_alenia4; if($alenia_4 == '-') $alenia_4 = '';

        //* Input Data Tracking Progress */
        $tracking_izin = new tmtrackingperizinan();
		$tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Entry Data')->get();
		if($tracking_izin->pendaftaran_id){
            $hit_cetak = $tracking_izin->hit_cetak + 1;
   		    $his_cetak = $tracking_izin->his_cetak;
			$tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
    		$tracking_izin->hit_cetak = $hit_cetak;
			$tracking_izin->his_cetak = $his_cetak.'CETAK^'.$r_name.'^'.$this->lib_date->get_date_now().';';
			$tracking_izin->save();
        }

		//path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');
        //$odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');
         //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
			  $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
		} else {
              $odf->setVars('logo', ' ');
        }

        // Kelurahan perusahaan
		$id_perusahaan = $perusahaan->id;
        $relasi_kel = new tmperusahaan_trkelurahan();
		$relasi_kel->get_by_id($id_perusahaan);
		$kd_kel = $relasi_kel->trkelurahan_id;
        $nama_kel = new trkelurahan();
		$nama_kel->get_by_id($kd_kel);
   //     $odf->setVars('kelurahan', 'KEL. '.$nama_kel->n_kelurahan);

		// Kecamatan perusahaan
        $relasi_kec = new trkecamatan_trkelurahan();
		$relasi_kec->get_by_id($kd_kel);
		$kd_kec = $relasi_kec->trkecamatan_id;
        $nama_kec = new trkecamatan();
		$nama_kec->get_by_id($kd_kec);
   //     $odf->setVars('kecamatan', 'KEC. '.$nama_kec->n_kecamatan);

		// Kab/Kota Perusahaan
        $relasi_kab = new trkabupaten_trkecamatan();
		$relasi_kab->get_by_id($kd_kec);
		$kd_kab = $relasi_kab->trkabupaten_id;
        $nama_kab = new trkabupaten();
		$nama_kab->get_by_id($kd_kab);
   //     $odf->setVars('kab', $nama_kab->n_kabupaten);

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

		//provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));
		$odf->setVars('badan1', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $n_tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $n_tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $n_fax = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $n_fax->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
//        $odf->setVars('k_kota', $kop_kota->value);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        //fill the template with the variables
        $petugas = 85; //1 -> Jabatan Penandatangan
        $pegawai = new tmpegawai();
        $pegawai->where('id', $petugas)->get();

		// set variable odf
		switch ($kdi) {
            case 41;  $odf->setVars('nm_kapal', $this->lib_date->isi_property($id_daftar, '9', '3'));               // untuk SIPI
                      $odf->setVars('tanda_selar', $this->lib_date->isi_property($id_daftar, '14', '3'));
			          break;
		}

		$odf->setVars('tgl_surat', $this->lib_date->mysql_to_human($surat->tgl_surat));
        $odf->setVars('lampiran', $surat->lampiran);
		$odf->setVars('sifat', $surat->sifat);
		$odf->setVars('hal', $surat->hal);
        //$odf->setVars('baru', $kd_jenis_ijin);
        //$odf->setVars('nama_izin', $nama_izin);
		$odf->setVars('lokasi', $permohonan->a_izin);
        $odf->setVars('no_surat', $surat->no_surat);
		$odf->setVars('alenia_1', $alenia_1);
		$odf->setVars('alenia_2', $alenia_2);
		$odf->setVars('alenia_3', $alenia_3);
		$odf->setVars('alenia_4', $alenia_4);
        
		//eval("\$asd = \"$alenia_4\";"); // fungsi macro untuk mengubah text menjadi command
		//$odf->setVars($alenia_2, $asd);
		

//        if($surat->tgl_surat)
//            $odf->setVars('tgl_rekomendasi', $this->lib_date->get_day($surat->tgl_surat) . ', tanggal ' . $this->lib_date->mysql_to_human($surat->tgl_surat));
//        else
//            $odf->setVars ('tgl_rekomendasi', '');
        $odf->setVars('dinas_teknis', $n_dinas);
        $odf->setVars('bidang', $bidang);
		$odf->setVars('alamat_dinas', $al_dinas);

		$odf->setVars('id_daftar', $permohonan->pendaftaran_id);
 //sahal		
		$odf->setVars('tgl_daftar', $this->lib_date->mysql_to_human($permohonan->d_terima_berkas));
		$odf->setVars('jabatan', $pegawai->n_jabatan);
		if($petugas !== 1) {
		    $odf->setVars('jabatan', 'a.n. KEPALA '.strtoupper($nama_bdan->value));  //$pegawai->n_jabatan);
			$odf->setVars('badan1', strtoupper($nama_prov1->value));                 //strtoupper($nama_bdan->value));
			$odf->setVars('provinsi1', $pegawai->n_jabatan);                         //strtoupper($nama_prov1->value));
		}
        //$odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai)); // huruf besar
		$odf->setVars('nama_pejabat', $pegawai->n_pegawai);
//        $odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
		$pangkat = substr($pegawai->pangkat_gol,0,strpos($pegawai->pangkat_gol,'('));
		$golongan = substr($pegawai->pangkat_gol,strpos($pegawai->pangkat_gol,'(')+1,strpos($pegawai->pangkat_gol,')') - strpos($pegawai->pangkat_gol,'(') - 1);
		$odf->setVars('pangkat_pejabat', $pangkat);
        $odf->setVars('nip_pejabat', $pegawai->nip);
        /*$wilayah = new trkabupaten();
        if($app_city->value !== '0'){
            $wilayah->get_by_id($app_city->value);
            $odf->setVars('kota', ucwords(strtolower($wilayah->n_kabupaten)));
        }else{
            $odf->setVars('kota', '...........');
        }
        $odf->setVars('kota', '');*/
//        $odf->setVars('tglskr', $this->lib_date->mysql_to_human($this->lib_date->get_date_now()));
		$v_tanggal = $this->lib_date->ambil_tanggal($this->lib_date->get_date_now());
		$v_bulan = $this->lib_date->ambil_bulan($this->lib_date->get_date_now());
		$v_tahun = $this->lib_date->ambil_tahun($this->lib_date->get_date_now());
		$odf->setVars('tglskr', $v_bulan.' '.$v_tahun);
		

        if($dinas->id == 20)
            $usaha = "Fas.Yan.Kes";
        else
            $usaha = "Perusahaan";
        
        $odf->setVars('nama_pemohon', $pemohon->n_pemohon);
        $odf->setVars('Nama', $perusahaan->n_perusahaan);
		$odf->setVars('alamat_perusahaan', $alamat_perusahaan);
		$odf->setVars('alamat_perusahaan1', $alamat_perusahaan1);

 //       $listeArticles = array(
 //               array(	'property' => 'Nama Pemohon',
 //                       'content' => $pemohon->n_pemohon,
 //               ),
 //               array(	'property' => 'Alamat',
 //                       'content' => $pemohon->a_pemohon,
 //               ),
 //               array(	'property' => 'Nama '.$usaha,
 //                       'content' => $perusahaan->n_perusahaan,
 //               ),
 //               array(	'property' => 'Alamat',
 //                       'content' => $perusahaan->a_perusahaan,
 //               ),
 //       );
 //       $article = $odf->setSegment('articles');
 //       foreach($listeArticles AS $element) {
 //               $article->titreArticle($element['property']);
 //               $article->texteArticle($element['content']);
 //               $article->merge();
 //       }
 //       $odf->mergeSegment($article);

 //
 
      
 //

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat.'_'.$no_daftar.'.odt');
    }

	public function cetak_OLD($id_daftar = NULL) {
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);

        $nama_surat = "cetak_permohonan";

		// Ambil Nama Jenis perijinan; Create -> Budi
		$kdjenis_ijin = new tmpermohonan_trjenis_permohonan();
		$kdjenis_ijin->get_by_id($id_daftar);
		$kd_jenis_ijin = $kdjenis_ijin->trjenis_permohonan_id;
        $kdjenis_ijin = new trjenis_permohonan();
		$kdjenis_ijin->get_by_id($kd_jenis_ijin);
        $kd_jenis_ijin = $kdjenis_ijin->n_permohonan;
//        $kd_jenis_ijin =  $kdjenis_ijin->tmpermohonan_id->get_by_id($id_daftar);
        // end Create

		$this->settings = new settings();
        $this->settings->where('name','app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name','app_city')->get();

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $pemohon = $permohonan->tmpemohon->get();
        $perusahaan = $permohonan->tmperusahaan->get();
        $surat = $permohonan->tmsurat_permohonan->get();
        $jenis_izin = $permohonan->trperizinan->get();
        $dinas = $permohonan->trperizinan->trunitkerja->get();
		$n_dinas = $dinas->n_unitkerja;
        $kd_dinas = $dinas->id;
		$alamat_perusahaan = $perusahaan->a_perusahaan;
		$alamat_perusahaan1 = '';
		$bidang = "";
		$al_dinas = "";
		$nama_pemohon = $pemohon->n_pemohon;
        $nama_perusahaan = $perusahaan->n_perusahaan;
        switch ($kd_dinas) {
			case 13; $bidang = "Bidang Tata Ruang Kawasan";                            // Kimrum (KBU)
     		         break;
            case 20; $bidang = "Ketua Tim Teknis Perizinan Bidang Kebinamargaan";      // Bina Marga
			         $al_dinas = "Jl. Asia Afrika No. 79"; 
					 $n_dinas = '';
					 break;
		    case 21; $bidang = "(Bidang Bina Manfaat)";                                // PSDA
			         $al_dinas = "Jl. Braga No. 37"; 
					 break;
			case 22; $bidang = "Bidang Mineral Geologi dan Air Tanah";                 // ESDM (ABT)
			         break;
		}

		$kdi = $jenis_izin->id;
		$nama_surat = "cetak_permohonan";  
		switch ($kdi) {
            case  71; $nama_surat = "cetak_permohonan_ispt";                 // untuk ISPT Di Ruang Milik Jalan (Rumija)
			          break;                      
		    case 145; $nama_surat = "cetak_permohonan_ispt";                 // untuk ISPT Di Tanah Jalan Diluar Ruang Milik Jalan (Rumija)
			          break;
            case 216; $nama_surat = "cetak_permohonan_abt";                  // untuk ABT
			          break;
		    case  83; $nama_surat = "cetak_permohonan_kbu";                  // untuk KBU
			          $nama_pemohon = substr($permohonan->dt_teknis1,0,strpos($permohonan->dt_teknis1,'^'));
                      $nama_perusahaan = '';
			          $alamat_perusahaan = substr($permohonan->dt_teknis6,0,strpos($permohonan->dt_teknis6,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis7,0,strpos($permohonan->dt_teknis7,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis8,0,strpos($permohonan->dt_teknis8,'^')).' ';
					  $alamat_perusahaan = $alamat_perusahaan  . substr($permohonan->dt_teknis9,0,strpos($permohonan->dt_teknis9,'^'));
					  $alamat_perusahaan1 = substr($permohonan->dt_teknis2,0,strpos($permohonan->dt_teknis2,'^')).' - ';
                      $alamat_perusahaan1 = $alamat_perusahaan1 . substr($permohonan->dt_teknis3,0,strpos($permohonan->dt_teknis3,'^'));
			          break;
			case 41; $nama_surat = "cetak_permohonan_sipi";                   // untuk SIPI
			          break;
		}
        
		$nama_izin = $jenis_izin->n_perizinan_cetak;
		if($nama_izin == "") $nama_izin = $jenis_izin->n_perizinan;

        //* Input Data Tracking Progress */
        $tracking_izin = new tmtrackingperizinan();
		$tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Entry Data')->get();
		if($tracking_izin->pendaftaran_id){
            $hit_cetak = $tracking_izin->hit_cetak + 1;
   		    $his_cetak = $tracking_izin->his_cetak;
			$tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
    		$tracking_izin->hit_cetak = $hit_cetak;
			$tracking_izin->his_cetak = $his_cetak.'CETAK^'.$r_name.'^'.$this->lib_date->get_date_now().';';
			$tracking_izin->save();
        }

		//path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');
        //$odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');
         //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
			  $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
		} else {
              $odf->setVars('logo', ' ');
        }

        // Kelurahan perusahaan
		$id_perusahaan = $perusahaan->id;
        $relasi_kel = new tmperusahaan_trkelurahan();
		$relasi_kel->get_by_id($id_perusahaan);
		$kd_kel = $relasi_kel->trkelurahan_id;
        $nama_kel = new trkelurahan();
		$nama_kel->get_by_id($kd_kel);
   //     $odf->setVars('kelurahan', 'KEL. '.$nama_kel->n_kelurahan);

		// Kecamatan perusahaan
        $relasi_kec = new trkecamatan_trkelurahan();
		$relasi_kec->get_by_id($kd_kel);
		$kd_kec = $relasi_kec->trkecamatan_id;
        $nama_kec = new trkecamatan();
		$nama_kec->get_by_id($kd_kec);
   //     $odf->setVars('kecamatan', 'KEC. '.$nama_kec->n_kecamatan);

		// Kab/Kota Perusahaan
        $relasi_kab = new trkabupaten_trkecamatan();
		$relasi_kab->get_by_id($kd_kec);
		$kd_kab = $relasi_kab->trkabupaten_id;
        $nama_kab = new trkabupaten();
		$nama_kab->get_by_id($kd_kab);
   //     $odf->setVars('kab', $nama_kab->n_kabupaten);

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

		//provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));
		$odf->setVars('badan1', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $n_tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $n_tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $n_fax = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $n_fax->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
//        $odf->setVars('k_kota', $kop_kota->value);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        //fill the template with the variables
        $petugas = 2; //1 -> Jabatan Penandatangan
        $pegawai = new tmpegawai();
        $pegawai->where('id', $petugas)->get();

		$odf->setVars('tgl_surat', $this->lib_date->mysql_to_human($surat->tgl_surat));
        $odf->setVars('lampiran', $surat->lampiran);
		$odf->setVars('sifat', $surat->sifat);
		$odf->setVars('hal', $surat->hal);
        $odf->setVars('baru', $kd_jenis_ijin);
        $odf->setVars('nama_izin', $nama_izin);
		$odf->setVars('lokasi', $permohonan->a_izin);
        $odf->setVars('no_surat', $surat->no_surat);

//        if($surat->tgl_surat)
//            $odf->setVars('tgl_rekomendasi', $this->lib_date->get_day($surat->tgl_surat) . ', tanggal ' . $this->lib_date->mysql_to_human($surat->tgl_surat));
//        else
//            $odf->setVars ('tgl_rekomendasi', '');
        $odf->setVars('dinas_teknis', $n_dinas);
        $odf->setVars('bidang', $bidang);
		$odf->setVars('alamat_dinas', $al_dinas);

		$odf->setVars('nama_pemohon', $nama_pemohon);
        $odf->setVars('Nama', $nama_perusahaan);

		$odf->setVars('id_daftar', $permohonan->pendaftaran_id);
 //sahal		
		$odf->setVars('tgl_daftar', $this->lib_date->mysql_to_human($permohonan->d_terima_berkas));
		$odf->setVars('jabatan', $pegawai->n_jabatan);
		if($petugas !== 1) {
		    $odf->setVars('jabatan', 'a.n. KEPALA '.strtoupper($nama_bdan->value));  //$pegawai->n_jabatan);
			$odf->setVars('badan1', strtoupper($nama_prov1->value));                 //strtoupper($nama_bdan->value));
			$odf->setVars('provinsi1', $pegawai->n_jabatan);                         //strtoupper($nama_prov1->value));
		}
        //$odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai)); // huruf besar
		$odf->setVars('nama_pejabat', $pegawai->n_pegawai);
//        $odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
		$pangkat = substr($pegawai->pangkat_gol,0,strpos($pegawai->pangkat_gol,'('));
		$golongan = substr($pegawai->pangkat_gol,strpos($pegawai->pangkat_gol,'(')+1,strpos($pegawai->pangkat_gol,')') - strpos($pegawai->pangkat_gol,'(') - 1);
		$odf->setVars('pangkat_pejabat', $pangkat);
        $odf->setVars('nip_pejabat', $pegawai->nip);
        /*$wilayah = new trkabupaten();
        if($app_city->value !== '0'){
            $wilayah->get_by_id($app_city->value);
            $odf->setVars('kota', ucwords(strtolower($wilayah->n_kabupaten)));
        }else{
            $odf->setVars('kota', '...........');
        }
        $odf->setVars('kota', '');*/
//        $odf->setVars('tglskr', $this->lib_date->mysql_to_human($this->lib_date->get_date_now()));
		$v_tanggal = $this->lib_date->ambil_tanggal($this->lib_date->get_date_now());
		$v_bulan = $this->lib_date->ambil_bulan($this->lib_date->get_date_now());
		$v_tahun = $this->lib_date->ambil_tahun($this->lib_date->get_date_now());
		$odf->setVars('tglskr', $v_bulan.' '.$v_tahun);
		

        if($dinas->id == 20)
            $usaha = "Fas.Yan.Kes";
        else
            $usaha = "Perusahaan";

        $odf->setVars('nama_pemohon', $pemohon->n_pemohon);
        $odf->setVars('Nama', $perusahaan->n_perusahaan);
		$odf->setVars('alamat_perusahaan', $alamat_perusahaan);
		$odf->setVars('alamat_perusahaan1', $alamat_perusahaan1);

 //       $listeArticles = array(
 //               array(	'property' => 'Nama Pemohon',
 //                       'content' => $pemohon->n_pemohon,
 //               ),
 //               array(	'property' => 'Alamat',
 //                       'content' => $pemohon->a_pemohon,
 //               ),
 //               array(	'property' => 'Nama '.$usaha,
 //                       'content' => $perusahaan->n_perusahaan,
 //               ),
 //               array(	'property' => 'Alamat',
 //                       'content' => $perusahaan->a_perusahaan,
 //               ),
 //       );
 //       $article = $odf->setSegment('articles');
 //       foreach($listeArticles AS $element) {
 //               $article->titreArticle($element['property']);
 //               $article->texteArticle($element['content']);
 //               $article->merge();
 //       }
 //       $odf->mergeSegment($article);

 //
 
      
 //

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat.'_'.$no_daftar.'.odt');
    }
    
    public function sql()
    {
        $query = "select a.n_kabupaten, a.ibukota from trkabupaten a where
            a.id = (select value from settings where name='app_city')";

        $sql = $this->db->query($query);
        return $sql->row();
    }
}
