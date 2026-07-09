<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Description of api class
 * @author  Muhammad Rizky
 * @since   1.0 PBS Edit 2014
 */

class Api extends REST_Controller {

  public function perhubungan_get() {
		$perhubungan = array();
    if(! $this->get('idtrayek')) {
      $this->response(NULL, 400);
    }
		$nokendaraan = str_replace("_"," ",$this->get('idtrayek'));
    $akdp_cetak = new akdp_cetak();
    $akdp_cetak->where('no_kend', $nokendaraan)->get();
		$akdptrayek = new akdptrayek();
    $akdptrayek = $akdptrayek->where('kode_trayek', $akdp_cetak->kode_trayek)->get();
    $data = array();
		if($akdp_cetak->no_kend) { // jika ditemukan
		  $kypengolah = $akdp_cetak->kyStafPTSP;
			$kyEsl4     = $akdp_cetak->kyEsl4PTSP;
			$kyEsl3     = $akdp_cetak->kyEsl3PTSP;
			$kyKa       = $akdp_cetak->kyKaPTSP;
			$dttek      = $akdp_cetak->id_perusahaan.$akdp_cetak->jenis_kend.$akdp_cetak->no_kend.$akdp_cetak->no_uji.$akdp_cetak->merek.$akdp_cetak->tahun.
			$akdp_cetak->daya_angkut_org.$akdp_cetak->daya_angkut_brg.$akdp_cetak->bahan_bakar.$akdp_cetak->jenis_pel.$akdp_cetak->kode_trayek.
			$akdp_cetak->masa_berlaku.$akdp_cetak->ket.$akdp_cetak->no_sartek.$akdp_cetak->tgl_sartek.$akdp_cetak->no_sk.$akdp_cetak->tgl_sk.
			$akdp_cetak->golongan.$akdp_cetak->nama_pemilik.$akdp_cetak->alamat_pemilik.$akdp_cetak->no_induk_kend.$akdp_cetak->tgl_penetepan.
			$akdp_cetak->keterangan_histori.$akdp_cetak->no_induk.$akdp_cetak->user_bo.$akdp_cetak->kp_id.$akdp_cetak->ex_no_kend.$akdp_cetak->ex_no_uji.
			$akdp_cetak->ex_nama_pemilik.$akdp_cetak->ex_alamat_pemilik.$akdp_cetak->ex_kode_trayek.$akdp_cetak->status.$akdp_cetak->no_kp.
			$akdp_cetak->tgl_kp_awal.$akdp_cetak->tgl_kp_akhir.$akdp_cetak->fasilitas.$akdp_cetak->sifat_pel.$akdp_cetak->nama_perusahaan.
			$akdp_cetak->alamat_perusahaan.$akdp_cetak->nama_pimpinan.$akdp_cetak->alamat_pimpinan.$akdp_cetak->info.$akdp_cetak->id_gol.$akdp_cetak->x.
			$akdp_cetak->tgl_penetapan_kp.$akdp_cetak->penetapan_oleh.$akdp_cetak->print_kp.$akdp_cetak->print_sk.$akdp_cetak->skkp.$akdp_cetak->tgl_masuk.
			$akdp_cetak->tgl_ambil.$akdp_cetak->retribusi;
      $dttek = str_replace(' ','',$dttek);
      $kytek = $kypengolah; //$kytek = md5($dttek);
			$valid = 'TIDAK BENAR';
			if($kypengolah == $kytek && $kyEsl4 == $kytek && $kyEsl3 == $kytek && $kyKa == $kytek) $valid = 'BENAR SESUAI DENGAN ASLINYA'; 
      $data['valid']            = $valid;
			$data['kypengolah']       = $kypengolah;
			$data['kyEslempat']       = $kyEsl4;
			$data['kyEsltiga']        = $kyEsl3;
			$data['kyKa']             = $kyKa;
			$data['pendaftaran_id']   = $akdp_cetak->pendaftaran_id;

		  //group SK
			$data['no_sk']            = $akdp_cetak->no_sk;
			$data['nama_perusahaan']  = $akdp_cetak->nama_perusahaan;
      $data['nama_pimpinan']    = $akdp_cetak->nama_pimpinan;
      $data['almt_perusahaan']  = $akdp_cetak->alamat_perusahaan;
      $data['almt_pimpinan']    = $akdp_cetak->alamat_pimpinan;
      $data['no_induk']         = $akdp_cetak->no_induk;
      $data['masa_berlaku']     = $this->lib_date->mysql_to_human($akdp_cetak->masa_berlaku);
      $data['ket']              = $akdp_cetak->ket;

			//group KP
			$data['no_kp']            = $akdp_cetak->no_kp;
			$data['berlaku_kp']       = $this->lib_date->mysql_to_human($akdp_cetak->tgl_kp_akhir);
      $data['no_kend']          = $akdp_cetak->no_kend;
			$data['no_uji']           = $akdp_cetak->no_uji;
      $data['daya_angkut_org']  = $akdp_cetak->daya_angkut_org.' Orang';
			$data['daya_angkut_brg']  = $akdp_cetak->daya_angkut_brg.' Kg';
      $data['jenis_kend']       = $akdp_cetak->jenis_kend;
      $data['merek']            = $akdp_cetak->merek." / ".$akdp_cetak->tahun;
			$data['bahan_bakar']      = $akdp_cetak->bahan_bakar;
      $data['jenis_pel']        = $akdp_cetak->jenis_pel;
      $data['kode_trayek']      = $akdp_cetak->kode_trayek;
      $data['sifat_pel']        = $akdp_cetak->sifat_pel;
      $data['nama_pemilik']     = $akdp_cetak->nama_pemilik;
	    $data['trayek']           = $akdptrayek->trayek;
    }else{                  // jika tidak ditemukan
		  $data['valid']            = 'DATA TIDAK DITEMUKAN';
			$data['kypengolah']       = '-';
			$data['kyEslempat']       = '-';
			$data['kyEsltiga']        = '-';
			$data['kyKa']             = '-';

		  //group SK
      $data['no_sk']            = 'DATA TIDAK DITEMUKAN';
			$data['nama_perusahaan']  = '-';
      $data['nama_pimpinan']    = '-';
      $data['almt_perusahaan']  = '-';
      $data['almt_pimpinan']    = '-';
      $data['no_induk']         = '-';
      $data['masa_berlaku']     = '-';
      $data['ket']              = '-';

			//group KP
			$data['no_kp']            = 'DATA TIDAK DITEMUKAN';
      $data['no_kend']          = '-';
			$data['no_uji']           = '-';
      $data['daya_angkut_org']  = '-';
			$data['daya_angkut_brg']  = '-';
      $data['jenis_kend']       = '-';
      $data['merek']            = '-';
			$data['bahan_bakar']      = '-';
      $data['jenis_pel']        = '-';
      $data['kode_trayek']      = '-';
      $data['sifat_pel']        = '-';
      $data['nama_pemilik']     = '-';
	    $data['trayek']           = '-';
    }
		
    $perhubungan[] = $data;
		$this->response($perhubungan, 200);
  }

  public function permohonan_get() {
    if(! $this->get('pendaftaran')) {
      $this->response(NULL, 400);
    }
    $pendaftaran = $this->get('pendaftaran');
    $pendaftaran_id = $pendaftaran;

    // Get permohonan
    $permohonan = new tmpermohonan();
    $permohonan->where('pendaftaran_id', $pendaftaran_id);
    $list = $permohonan->get();
    
    
    // Create PBS
    $kode_izin = substr($pendaftaran_id, 5, 3);
    $kelompok_perizinan_trperizinan = new trkelompok_perizinan_trperizinan();
    $kelompok_perizinan_trperizinan->get_by_id($kode_izin);
    $kode_kelompok = $kelompok_perizinan_trperizinan->trkelompok_perizinan_id;
    $kelompok_perizinan = new trkelompok_perizinan();
    $kelompok_perizinan->get_by_id($kode_kelompok);
    $nama_kelompok = $kelompok_perizinan->n_kelompok;
    // EOF PBS
    
    $permohonan = array();
    foreach($list as $dt){
      // Get who has jenis Izin
      $dt->trperizinan->get();

      // Get who has permohonan
      $dt->tmpemohon->get();

      // Get who far these permohonan
      $dt->trstspermohonan->get();

      // Get who has tangal sirvey
      $dt->trtanggal_survey->get();
      
      // Get who has tmsk
      $tmsk = $dt->tmsk->get();
      $no_surat = $tmsk->no_surat_edit;
      $tg_surat = $tmsk->tgl_surat_edit;
      if($no_surat == '') {
        $no_surat = $tmsk->no_surat;
        $tg_surat = $tmsk->tgl_surat;
      }
      
      $data = array();
      $data['id'] = $dt->id;
      $data['no_pendaftaran'] = $dt->pendaftaran_id;
      $data['sts_berkas'] =  $dt->status_berkas;
      $data['approve'] =  $dt->approve;
      if($dt->trstspermohonan->id=='1'){               //jika sementara
        $data['nama'] = $dt->tmpemohon_sementara->n_pemohon;
        $data['telp'] = $dt->tmpemohon_sementara->telp_pemohon;
        $data['alamat'] = $dt->tmpemohon_sementara->a_pemohon;
      }else{
        $data['nama'] = $dt->tmpemohon->n_pemohon;
        $data['telp'] = $dt->tmpemohon->telp_pemohon;
        $data['alamat'] = $dt->tmpemohon->a_pemohon;
      }
      $data['permohonan'] = $dt->trperizinan->n_perizinan;
      $data['n_kelompok_izin'] = $nama_kelompok;
      $data['kd_status'] = $dt->kd_status;
      $data['tracking'] = $dt->trstspermohonan->n_sts_permohonan;
      $data['no_surat'] = $no_surat;  //$dt->trtanggal_survey->no_surat;
      $data['tgl_surat'] = $this->lib_date->mysql_to_human($tg_surat); //$dt->trtanggal_survey->no_surat;
      
      // Get what Izin is
      $permohonan[] = $data;
    }

    if($permohonan) {
      $this->response($permohonan, 200);
    }else{
      $this->response(array('error' => 'Tidak ada data..'), 404);
    }
  }

  public function kendaraan_get() {
    if(! $this->get('nomor')) {
      $this->response(NULL, 400);
    }
    $pendaftaran = $this->get('nomor');
    $pendaftaran_id = str_replace("_", " ", $pendaftaran);

    // Get permohonan
    $akdp_cetak = new akdp_cetak();
    $list = $akdp_cetak->where('no_kend', $pendaftaran_id)->get();

    $data = array();
    foreach ($list as $row) {
      $data['no_kend'] = $row->no_kend;
      $data['no_uji'] = $row->no_uji;
      $data['nama_pemilik'] = $row->nama_pemilik;
      $data['nama_perusahaan'] = $row->nama_perusahaan;
      $data['tahun_pembuatan'] = $row->tahun;
      $data['merk'] = $row->merek;
      $data['jenis_kendaraan'] = $row->jenis_kend;
      $data['no_sk'] = $row->no_sk;
      $data['no_kp'] = $row->no_kp;
      $data['tgl_penetapan_sk'] = $row->tgl_penetepan;
      $data['tgl_penetapan_kp'] = $row->tgl_penetapan_kp;
      $data['tgl_sk'] = $row->tgl_sk;
      $data['tgl_kp'] = $row->tgl_kp_awal;
      $data['masa_berlaku_sk'] = $row->masa_berlaku;
      $data['masa_berlaku_kp'] = $row->tgl_kp_akhir;
    }
      
      // Get what Izin is
      $permohonan[] = $data;

        $this->response($permohonan, 200);
    }
    
    public function propinsi_get() {
        $prop = new trpropinsi();
        $list_prop = $prop->order_by('n_propinsi','ASC')->get();

        $data1 = array();
        $i=0;
        foreach ($list_prop as $all) {
            $data1[$i]['id'] = $all->id;
            $data1[$i]['nama_propinsi'] = $all->n_propinsi;
            $i++;
        }

        if($data1) {
            $this->response($data1, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    function jenisnama_get(){
        if (! $this->get('id')) {
            $this->response(NULL, 400);
        }
        $id = $this->get('id');

        $dt = new trperizinan();
        $list= $dt->where("id = $id")->get();

        $data = array();
        $i=0;
        foreach ($list as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['naam'] = $all->n_perizinan;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }
    }
    
    
    public function kabupaten_get() {

        if (! $this->get('id_prop')) {
            $this->response(NULL, 400);
        }
        $propinsi_id = $this->get('id_prop');
        
        // Get permohonan
        $propinsi = new trpropinsi();
        $propinsi->where('id', $propinsi_id)->get();
        
        // Get what Izin is
        $list = $propinsi->trkabupaten->order_by('n_kabupaten','ASC')->get();

         $data = array();
        $i=0;
        foreach ($list as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['nama_kabupaten'] = $all->n_kabupaten;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }

    }

    public function kelurahan_get() {

        if (!$this->get('id_kec')) {
            $this->response(NULL, 400);
        }
        $id = $this->get('id_kec');

        
        $dt = new trkecamatan();
        $dt->where('id', $id)->get();

        // Get what Izin is
        $list = $dt->trkelurahan->order_by('n_kelurahan','ASC')->get();

         $data = array();
        $i=0;
        foreach ($list as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['nama_kelurahan'] = $all->n_kelurahan;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }

    }
    
    public function kecamatan_get() {

        if (!$this->get('id_kab')) {
            $this->response(NULL, 400);
        }
        $kabupaten_id = $this->get('id_kab');
        $kabupaten = new trkabupaten();
        $kabupaten->where('id', $kabupaten_id)->get();
        
        
        $list = $kabupaten->trkecamatan->order_by('n_kecamatan','ASC')->get();

        $data = array();
        $i=0;
        foreach ($list as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['nama_kecamatan'] = $all->n_kecamatan;
            $i++;
        }
     //   echo $i;
        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }

    }
    
    //------------------------------

     public function jumlahIzinGangguan_get() {

        if (! $this->get('izin')) {
            $this->response(NULL, 400);
        }
        $izin = $this->get('izin');
        $d_izin = $izin;
        $id_kab =$this->uri->segment('5');

//        $ok = $this->get('ok');
//        $d_ok = $ok;


        // Get kabupaten
        $kabupaten = new trkabupaten();
        $kabupaten->get_by_id($id_kab);

        $perizinan = new trperizinan();
        $perizinan->where('d_entry', $d_izin);
        $total = $perizinan->count();
        
        $data = array();
        $data['jumlahizin'] = $total;
        $data['Kabupaten'] = $kabupaten->n_kabupaten;

        $perizinan = array();
        $perizinan[] = $data;

        if($perizinan) {
            $this->response($perizinan, 200);
        } else {
            $this->response(array('error' => 'Tidak ada data..'), 404);
        }
    }


     public function jumlahPerizinan_get() {

        // Get perizinan

        $perizinan = new trperizinan();
        
        $data = array();
        $data['jumlahPerizinan'] = $perizinan->count();
       
//        $data['no_pendaftaran'] = $permohonan->pendaftaran_id;
//        $data['nama'] = $permohonan->tmpemohon->n_pemohon;
//        $data['telp'] = $permohonan->tmpemohon->telp_pemohon;
//        $data['alamat'] = $permohonan->tmpemohon->a_pemohon;
//        $data['permohonan'] = $permohonan->trperizinan->n_perizinan;
//        $data['tracking'] = $permohonan->trstspermohonan->n_sts_permohonan;

        $permohonan = array();
        $permohonan[] = $data;

        if($permohonan) {
            $this->response($permohonan, 200);
        } else {
            $this->response(array('error' => 'Tidak ada data..'), 404);
        }
    }



    public function ambilPermohonan_get() {

        if (! $this->get('permohonan')) {
            $this->response(NULL, 400);
        }
        $d_entry = $this->get('permohonan');
        $entry = $d_entry;

        // Get permohonan

        $permohonan_tetap = new tmpermohonan();
        $permohonan_tetap = $permohonan_tetap->where_related('trstspermohonan','id >',8)
                                  ->where('d_terima_berkas',$d_entry)
                                  ->where_related('trstspermohonan','id !=',9);

        $permohonan_proses = new tmpermohonan();
        $permohonan_proses = $permohonan_proses->where_related('trstspermohonan','id <=',9)
                                  ->where('d_terima_berkas',$d_entry)
                                  ->where_related('trstspermohonan','id !=',8);

        $data = array();
        $data['ditetapkan'] = $permohonan_tetap->count();
        $data['diproses'] = $permohonan_proses->count();
//        $data['no_pendaftaran'] = $permohonan->pendaftaran_id;
//        $data['nama'] = $permohonan->tmpemohon->n_pemohon;
//        $data['telp'] = $permohonan->tmpemohon->telp_pemohon;
//        $data['alamat'] = $permohonan->tmpemohon->a_pemohon;
//        $data['permohonan'] = $permohonan->trperizinan->n_perizinan;
//        $data['tracking'] = $permohonan->trstspermohonan->n_sts_permohonan;

        $permohonan = array();
        $permohonan[] = $data;

        if($permohonan) {
            $this->response($permohonan, 200);
        } else {
            $this->response(array('error' => 'Tidak ada data..'), 404);
        }
    }

    public function perusahaan_get() {

        if (! $this->get('getdatawpbynpwp')) {
            $this->response(NULL, 400);
        }
        $npwp = $this->get('getdatawpbynpwp');
        echo $npwp;
       // // Get permohonan
//        $perusahaan = new tmperusahaan();
//        $perusahaan->where('npwp', $npwp);
//        $perusahaan->get();
//
//        $data = array();
//        if($perusahaan->id) $getdata = "1";
//        else $getdata = "2";
//        $data['getdata'] = $getdata;
//        $data['id_perusahaan'] = $perusahaan->id;
//        $data['npwp'] = $perusahaan->npwp;
//        $data['nodaftar'] = $perusahaan->no_daftar;
//        $data['nama_perusahaan'] = $perusahaan->n_perusahaan;
//        $data['alamat_usaha'] = $perusahaan->a_perusahaan;
//        $data['rt'] = $perusahaan->rt;
//        $data['rw'] = $perusahaan->rw;
//        $data['telp_perusahaan'] = $perusahaan->i_telp_perusahaan;
//        $data['fax'] = $perusahaan->i_fax;
//        $data['email'] = $perusahaan->email;
//
//        $perusahaan = array();
//        $perusahaan[] = $data;
//
//        if($perusahaan) {
//            $this->response($perusahaan, 200);
//        } else {
//            $this->response(array('error' => 'Tidak ada data..'), 404);
//        }
    }

    public function pengaduan_post() {
        $pesan = new tmpesan();
        $sumber = new trsumber_pesan();
        $sumber->get_by_id('5');
        $stat = new trstspesan();
        $stat->get_by_id('9');

        $token = $this->post('token');

        if (base64_decode($token) === "h1x7HrZ4eG") {
          $pesan->jns_pengaduan = $this->post('jns_pengaduan');
          $pesan->pendaftaran_id = $this->post('pendaftaran_id');
          $pesan->nama = $this->post('nama');
          $pesan->alamat = $this->post('alamat');
          $pesan->kelurahan = $this->post('kelurahan');
          $pesan->kecamatan = $this->post('kecamatan');
          $pesan->e_pesan = $this->post('e_pesan');
          $pesan->d_entry = $this->post('d_entry');
          $pesan->telp = $this->post('kontak_person');
          $pesan->no_hp = $this->post('no_hp');
          $pesan->email = $this->post('n_email');
          //$pesan->trsumber_pesan->

          if(empty($this->post('e_pesan'))) {
              $message = array(
                  'status' => 'failed'
              );

              $this->response($message, 200);
          } else {
              if($pesan->save(array($sumber,$stat))) {
                  $message = array(
                      'status' => 'success'
                  );
      
                  $this->response($message, 200); // 200 being the HTTP response code
              } else {
                  $message = array(
                      'status' => 'failed'
                  );
      
                  $this->response($message, 200); // 200 being the HTTP response code
              }
          }
        } else {
          $message = array(
              'status' => 'failed'
          );
          
          $this->response($message, 200);
        }

    }
    
	public function status_pesan_get() {
        $stat_pesan = new trstspesan();
        $list_stat = $stat_pesan->order_by('urutan','ASC')->get();

        $data1 = array();
        $i=0;
        foreach ($list_stat as $all) {
            $data1[$i]['id'] = $all->id;
            $data1[$i]['n_sts_pesan'] = $all->n_sts_pesan;
			$data1[$i]['status'] = $all->status;
            $i++;
        }

        if($data1) {
            $this->response($data1, 200);
        } else {
            $this->response(NULL, 404);
        }
    } 

    public function pendaftaran_post() {
		
        /* Input Data Pemohon_portal */
        $pemohon = new tmpemohon_portal();
		    $pemohon->referensi = $this->post('v_referensi');
        $pemohon->namaPemohon = $this->post('v_namaPemohon');
        $pemohon->telpPemohon = $this->post('v_telpPemohon');
        $pemohon->almtPemohon = $this->post('v_almtPemohon');
        $pemohon->propinsi1 = $this->post('v_propinsi1');
        $pemohon->kabupaten1 = $this->post('v_kabupaten1');
        $pemohon->kecamatan1 = $this->post('v_kecamatan1');
        $pemohon->kelurahan1 = $this->post('v_kelurahan1');
        $pemohon->npwpPerusahaan = $this->post('v_npwpPerusahaan');
        $pemohon->regPerusahaan = $this->post('v_regPerusahaan');
        $pemohon->namaPerusahaan = $this->post('v_namaPerusahaan');
        $pemohon->almtPerusahaan = $this->post('v_almtPerusahaan');
        $pemohon->telpPerusahaan = $this->post('v_telpPerusahaan');
        $pemohon->tglPermohonan = $this->post('v_tglPermohonan');
        $pemohon->propinsi2 = $this->post('v_propinsi2');
        $pemohon->kabupaten2 = $this->post('v_kabupaten2');
        $pemohon->kecamatan2 = $this->post('v_kecamatan2');
        $pemohon->kelurahan2 = $this->post('v_kelurahan2');
        $pemohon->izin = $this->post('v_izin');
		    $pemohon->urut = $this->post('v_urut');
        $pemohon->lampiran = $this->post('v_lampiran');
        $pemohon->isi_izin = $this->post('v_isi_izin');
        $pemohon->save();

	}

    public function OLD_pendaftaran_post() {

        $perizinan = new trperizinan();
        $perizinan->get_by_id($this->post('jenis_izin_id'));

        $jenis_permohonan = new trjenis_permohonan();
        $jenis_permohonan->get_by_id($this->post('jenis_permohonan_id'));
		
        /* Penomoran Pendaftaran
         * Awal
         */
        $data_id = new tmpermohonan();

        $data_id->select_max('id')->get();
        $data_id->get_by_id($data_id->id);

        $data_tahun = date("Y");
        //Per Tahun Auto Restart NoUrut
        if ($data_id->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
        else {
            $data_urut = 1;
            $year = new year();
            $year->tahun = $data_tahun;
            $year->save();
        }

        $i_urut = strlen($data_urut);
        for ($i = 5; $i > $i_urut; $i--) {
            $data_urut = "0" . $data_urut;
        }

        $data_izin = $perizinan->id;
        $i_izin = strlen($data_izin);
        for ($i = 3; $i > $i_izin; $i--) {
            $data_izin = "0" . $data_izin;
        }

        $data_jenis = $jenis_permohonan->id;
        $i_izin = strlen($data_jenis);
        for ($i = 2; $i > $i_izin; $i--) {
            $data_jenis = "0" . $data_jenis;
        }

        $data_bulan = date("n");
        $i_bulan = strlen($data_bulan);
        for ($i = 2; $i > $i_bulan; $i--) {
            $data_bulan = "0" . $data_bulan;
        }

        $permohonan = new tmpermohonan();
        $permohonan->i_urut = $data_urut;
        $permohonan->d_tahun = $data_tahun;

        $app_folder = new settings();
        $app_folder->where('name', 'app_folder')->get();
        $app_folder = $app_folder->value;
        // menyusun nomor pendaftaran
        if ($app_folder === "Bantul") {   // untuk bantul
            $nomor_pendaftaran = $data_urut . "/" . $data_izin . "/" . $data_jenis . "/" . $data_bulan . "/" . $data_tahun;
        } else {
//            $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun;
            $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun . "000";
        }


        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        if ($username->id)
            $user = $username->realname;
        else
            $user = "................................";


        $permohonan->i_entry = $user;
        $permohonan->pendaftaran_id = $nomor_pendaftaran;
        $permohonan->d_terima_berkas = date('Y-m-d');
		$permohonan->d_terima_berkas_asli = date('Y-m-d');
        $permohonan->d_survey = date('Y-m-d');
        $permohonan->a_izin = " ";
        $permohonan->keterangan = $this->input->post('keterangan');
        $permohonan->c_pendaftaran = '2';  // diisi 
        
        //-------upload file
        
        $config['upload_path'] = './assets/upload/';
		$config['allowed_types'] = 'pdf|doc|docx|word|xlsx|xl';
		$config['max_size']	= '2000';
		$this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file');
        
        $permohonan->file_ttd = $this->input->post('file');
        
        //------upload file
        $tgl_skr = $this->lib_date->get_date_now();
        $permohonan->d_entry = $tgl_skr;
        
        $tgl_entry = $this->input->post('tgl_daftar');
        $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS

        $permohonan->save($perizinan);
        /* Penomoran Pendaftaran
         * Akhir
         */

        $permohonan_akhir = new tmpermohonan();
        $permohonan_akhir->select_max('id')->get();
        //$permohonan_akhir->where('i_urut', $data_urut)->where('d_tahun', $data_tahun)->get();

        /* Input Data Pemohon */
        $pemohon = new tmpemohon_sementara();
        $pemohon->no_referensi = $this->post('no_refer');
        $pemohon->source = $this->post('cmbsource');
        $pemohon->n_pemohon = $this->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->post('no_telp');
        $pemohon->a_pemohon = $this->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = " ";
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->post('kelurahan_pemohon'));
        $pemohon->save(array($permohonan_akhir, $kelurahan_p));

        /* Input Data Perusahaan okok */
        // edited by mucktar
        if($this->post('nama_perusahaan')){
            $perusahaan = new tmperusahaan_sementara();
            $perusahaan->n_perusahaan = $this->post('nama_perusahaan');
            $perusahaan->npwp = $this->post('npwp');
            $perusahaan->i_telp_perusahaan = $this->post('telpPerusahaan');
            $perusahaan->a_perusahaan = $this->post('alamat_usaha');
            $perusahaan->no_reg_perusahaan = $this->post('no_registrasi');
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->post('kelurahan_usaha'));
            $perusahaan->save(array($permohonan_akhir, $kelurahan_u));
        }

        /* Input Data Syarat Perizinan */
        $syarat_pendaftaran = new tmpermohonan_trsyarat_perizinan();
        $syarat_pendaftaran->where('tmpermohonan_id', $permohonan_akhir->id)->get();
        $syarat_pendaftaran->delete();

        $syarat = $this->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $is_array = NULL;
        for($i=0;$i < $syarat_len;$i++) {
            if($is_array !== $syarat[$i]) {
                $syarat_daftar = new tmpermohonan_trsyarat_perizinan();
                $syarat_daftar->tmpermohonan_id = $permohonan_akhir->id;
                $syarat_daftar->trsyarat_perizinan_id = $syarat[$i];
                $syarat_daftar->save();
            }
            $is_array = $syarat[$i];
        }

        /* Input Data Tracking Progress */
        $tracking_izin = new tmtrackingperizinan();
        $tracking_izin->pendaftaran_id = $nomor_pendaftaran;
        $tracking_izin->status = 'Insert';
        $tracking_izin->d_entry = $this->lib_date->get_date_now();
        $sts_izin = new trstspermohonan();
        $sts_izin->get_by_id('1'); //pendaftaran sementara [Lihat Tabel trstspermohonan()]
		$permohonan_akhir->save($sts_izin);
        $tracking_izin->save($sts_izin);
        $tracking_izin->save($permohonan_akhir);

        if($permohonan_akhir->save($jenis_permohonan)) {
            $message = array(
                'status' => 'success',
                'no_pendaftaran' => $nomor_pendaftaran
            );

            $this->response($message, 200); // 200 being the HTTP response code
        } else {
            $message = array(
                'status' => 'failed',
                'no_pendaftaran' => ' '
            );

            $this->response($message, 200); // 200 being the HTTP response code
        }
    }

  public function jenisPerizinanList_get() {
    $perizinan = new trperizinan();
    //$list_perizinan = $perizinan->get();
    $list_perizinan = $perizinan->order_by('kd_izin', 'ASC')->get();
    
    $data = array();
    $i=0;
    foreach ($list_perizinan as $all) {
      $data[$i]['id'] = $all->id;
      $data[$i]['jenis_perizinan'] = $all->n_perizinan;
      $data[$i]['v_hari'] = $all->v_hari;
    	$data[$i]['c_aktif'] = $all->c_aktif;
    	$data[$i]['c_online'] = $all->c_online;
      $i++;
    }
    
    if($data) {
      $this->response($data, 200);
    }else{
      $this->response(NULL, 404);
    }
  }

//    public function jenisPerizinanList_get() {
//        $perizinan = new trperizinan();
//        $list_perizinan = $perizinan->get();

//        $data = array();
//        $i=0;
//        foreach ($list_perizinan as $all) {
            // Get who has kelompok perizinan
//            $all->trkelompok_perizinan->get();

//            $data[$i]['id'] = $all->id;
//            $data[$i]['jenis_perizinan'] = $all->n_perizinan;
//            $data[$i]['v_hari'] = $all->v_hari;
//			$data[$i]['kelompok'] = $all->trkelompok_perizinan->n_kelompok;
//            $i++;
//        }

//        if($data) {
//            $this->response($data, 200);
//        } else {
//            $this->response(NULL, 404);
//        }
//    }

    // mengambil semua status permohonan ( Create PBS )
	public function stsPermohonanList_get() {
        $status = new trstspermohonan();
        $list_stspermohonan = $status->get();

        $data = array();
        $i=0;
        foreach ($list_stspermohonan as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['jenis_status'] = $all->n_sts_permohonan;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    // mengambil jumlah syarat perizinan berdasarkan id izin
    public function syaratPerizinan_get()
    {
        if (! $this->get('perizinan')) {
            $this->response(NULL, 400);
        }
        $perizinan = $this->get('perizinan');
        $perizinan_id = $perizinan;
        
        $izin = new trsyarat_perizinan();
        $syarat = $izin->where_related('trperizinan','id',$perizinan_id)
			           ->where('c_show_type !=','0')
                 ->order_by('urutan','ASC')->get();
  
        $data = array();
        $i=0;
		foreach ($syarat as $all) {
			$ttp = new trperizinan_syarat();
			$ttp = $ttp->where('trperizinan_id',$perizinan_id)->where('trsyarat_perizinan_id',$all->id)->get();
            $data[$i]['id'] = $all->id;
    		$data[$i]['syarat_perizinan'] = $all->v_syarat;
			$data[$i]['c_show_type'] = $ttp->c_show_type;
			$data[$i]['status'] = $ttp->status;
			$data[$i]['status_new'] = $ttp->status_new;
      $data[$i]['nama_formulir'] = $all->nama_formulir;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }
    }
    
    // mengambil jumlah dasar hukum berdasarkan id izin
    
    public function dasarHukum_get()
    {
        if (! $this->get('perizinan')) {
            $this->response(NULL, 400);
        }
        $perizinan = $this->get('perizinan');
        $perizinan_id = $perizinan;
        
        $hukum = new trdasar_hukum();
        $list = $hukum->where_related('trperizinan','id',$perizinan_id)->get();
  
        $data = array();
        $i=0;
        foreach ($hukum as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['dasar hukum'] = $all->deskripsi;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    // mengambil jumlah dasar hukum berdasarkan id izin
    
    // mengambil nilai retribusi berdasarkan id izin
    
    public function nilaiRetribusi_get()
    {
        if (! $this->get('perizinan')) {
            $this->response(NULL, 400);
        }
        $perizinan = $this->get('perizinan');
        $perizinan_id = $perizinan;
        
        // Get perizinan
        $izin = new trperizinan();
        $izin->where('id', $perizinan_id)->get();
        
        $v_retribusi = NULL;
        if ($izin->trretribusi->m_perhitungan=="0")
        {
            $v_retribusi = $izin->trretribusi->v_retribusi;
        }
        elseif ($izin->trretribusi->m_perhitungan=="1")
        {
            $v_retribusi = "Perhitungan Manual";
        }
        
  
        $data = array();
        $data['nama_perizinan'] = $izin->n_perizinan;
        $data['retribusi'] = $v_retribusi;
        

        $izin = array();
        $izin[] = $data;

        if($izin) {
            $this->response($izin, 200);
        } else {
            $this->response(array('error' => 'Tidak ada data..'), 404);
        }
    }
    
    // mengambil nilai retribusi berdasarkan id izin
    
    public function jenisPermohonanList_get() {
        $permohonan = new trjenis_permohonan();
        $list_permohonan = $permohonan->get();

        $data = array();
        $i=0;
        foreach ($list_permohonan as $all) {
            $data[$i]['id'] = $all->id;
            $data[$i]['jenis_permohonan'] = $all->n_permohonan;
            $i++;
        }

        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    public function pengaduanViaSMS_get() {
        $pesan = new tmpesan();
        $sumber_pesan = new trsumber_pesan();

        $sumber_pesan->where('id','2')->get();
        $list_pesan = $pesan->get($sumber_pesan);

        $data = array();
        $i = 0;

        foreach ($list_pesan as $all) {
            $data[$i]['id'] = $all->id;
            $pengirim = $all->telp;
            $len = strlen($all->telp) - 3;
            $data[$i]['pengirim'] = substr($all->telp, 0, $len) . 'xxx' ;
            $data[$i]['pesan'] = $all->e_pesan;
            $i++;
        }
        
        if($data) {
            $this->response($data, 200);
        } else {
            $this->response(NULL, 404);
        }

    }

//    public function sql($entry)
//    {
//        $query = "select * from tmpermohonan as a
//                  inner join tmpermohonan_trstspermohonan as b on b.tmpermohonan_id=a.id
//                  inner join trstspermohonan as c on b.trstspermohonan_id=c.id
//                  where (c.id>=8 and c.id != 9) and a.d_terima_berkas = '".$entry."';
//                  ";
//        $hasil = $this->db->query($query);
//        return $hasil->num_rows();
//
//    }

}

// This is the end of api class