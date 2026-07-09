<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 * @author Jonas
 * Created : 22 Maret 2021
 */

class M_perdin extends CI_Model {
  
public function get_data($tgla = NULL, $tglb = NULL, $admin = NULL, $iduser = NULL) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($tgla) || empty($tglb)) {
        return []; // Jika tanggal kosong, kembalikan array kosong
    }

    $sql = "SELECT * FROM keu_perdin WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?";
    $params = [$tgla, $tglb];

    if (!($admin == 1 || in_array($iduser, [197, 218, 550, 543]))) {
        $sql .= " AND user_id = ?";
        $params[] = $iduser;
    }

    $sql .= " ORDER BY tanggal_berangkat DESC";

    return $this->otherdb->query($sql, $params)->result();
}

  
  public function get_data_old($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
    $sql = "SELECT * FROM euis_bukutamu order by waktu desc";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  public function get_datakegiatan($id) {
    $kegiatan = $this->db->select('*')
                         ->from('euis_calendar')
                         ->where('id', $id)
                         ->get()->row();
    return $kegiatan;
  }
  
  public function get_sektor2() {
    $sql = "SELECT * from trsektor";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  public function get_namampp() {
    $sql = "SELECT * from euis_bukutamu_mpp";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  public function getperingkatnegara(){
    $sql = "SELECT * ,sum(jum_rp) as Total from euis_rinv_country group by id_negara ORDER BY Total DESC "; //LIMIT 10
    $result = $this->db->query($sql); 
    return $result->result();
  }
  
  public function getsektor($tgla = NULL, $tglb = NULL){
    $sql = "SELECT * ,count(bidang) as Total from euis_bukutamu  WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by bidang ORDER BY Total DESC "; //LIMIT 10
    $result = $this->db->query($sql);
    return $result->result();
  }
  
  public function gettujuandatang($tgla = NULL, $tglb = NULL){
    $sql = "SELECT * ,count(tujuan) as Totaltujuan from euis_bukutamu  WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by tujuan ORDER BY Totaltujuan DESC "; //LIMIT 10
    $result = $this->db->query($sql);
    return $result->result();
  }
  
  public function getlokasimpp($tgla = NULL, $tglb = NULL){
    $sql = "SELECT * ,count(lokasi) as lok from euis_bukutamu WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by lokasi ORDER BY lok DESC "; //LIMIT 10
    $result = $this->db->query($sql);
    return $result->result();
  }
  
  public function getnamalokasimpp(){
    $sql = "SELECT * ,count(lokasi) as lok from euis_bukutamu group by lokasi ORDER BY lok DESC "; //LIMIT 10
    $result = $this->db->query($sql);
    return $result->result();
  }
  
  public function getpetugas($tgla = NULL, $tglb = NULL){
    $sql = "SELECT * ,count(nama_petugas) as petugas from euis_bukutamu WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by nama_petugas ORDER BY petugas DESC "; //LIMIT 10
    $result = $this->db->query($sql);
    // var_dump($sql);die();
    return $result->result();
  }
  
  public function getmpp(){
    $sql = "SELECT  
            count(IF(lokasi='JIH DPMPTSP Jabar', lokasi, NULL)) AS jdpmptsp,
            count(IF(lokasi='Lobby DPMPTSP Jabar', lokasi, NULL)) AS ldpmptsp,
            count(IF(lokasi='MPP Kota Bandung', lokasi, NULL)) AS mkotabandung,
            count(IF(lokasi='GPP Kota Bandung', lokasi, NULL)) AS gkotabandung,
            count(IF(lokasi='MPP Kab. Bandung', lokasi, NULL)) AS kabbandung,
            count(IF(lokasi='GPP Kota Cirebon', lokasi, NULL)) AS kotacirebon,
            count(IF(lokasi='GPP Kab. Cirebon', lokasi, NULL)) AS kabcirebon,
            count(IF(lokasi='MPP Kota Tasikmalaya', lokasi, NULL)) AS kotatasik,
            count(IF(lokasi='GPP Kab. Garut', lokasi, NULL)) AS kabgarut,
            count(IF(lokasi='MPP Kab. Purwakarta', lokasi, NULL)) AS kabpurwakarta,
            count(IF(lokasi='MPP Kab. Karawang', lokasi, NULL)) AS kabkarawang,
            count(IF(lokasi='MPP Kota Bekasi', lokasi, NULL)) AS kotabekasi,
            count(IF(lokasi='MPP Kab. Bekasi', lokasi, NULL)) AS kabbekasi,
            count(IF(lokasi='MPP Kota Bogor', lokasi, NULL)) AS kotabogor,
            count(IF(lokasi='GPP Plasa Cibubur', lokasi, NULL)) AS cibubur,
            count(IF(lokasi='MPP Kab. Sumedang', lokasi, NULL)) AS sumedang
            FROM euis_bukutamu 
           ";
    // var_dump($sql);die();
    $result = $this->db->query($sql);
    return $result->row();
  }
  
  public function getSum2019TW1(){
    $sql = "SELECT  SUM(IF(tw='1', proyek, 0)) AS proyek,
            SUM(IF(tw='1', total_invest, 0)) AS total_invest,
            SUM(IF(tw='1', tenaga_kerja, 0)) AS naker,
            SUM(IF(tw='2', proyek, 0)) AS proyek2,
            SUM(IF(tw='2', total_invest, 0)) AS total_invest2,
            SUM(IF(tw='2', tenaga_kerja, 0)) AS naker2,
            SUM(IF(tw='3', proyek, 0)) AS proyek3,
            SUM(IF(tw='3', total_invest, 0)) AS total_invest3,
            SUM(IF(tw='3', tenaga_kerja, 0)) AS naker3,
            SUM(IF(tw='4', proyek, 0)) AS proyek4,
            SUM(IF(tw='4', total_invest, 0)) AS total_invest4,
            SUM(IF(tw='4', tenaga_kerja, 0)) AS naker4 FROM euis_investratio where tahun = '2019'
           ";
    $result = $this->db->query($sql);
    return $result->row();
  }
  
  public function getSum2021PMA(){
    $sql = "SELECT  SUM(IF(tw='1', proyek, 0)) AS proyek,
            SUM(IF(tw='1', total_invest, 0)) AS total_invest,
            SUM(IF(tw='1', tenaga_kerja, 0)) AS naker,
            SUM(IF(tw='2', proyek, 0)) AS proyek2,
            SUM(IF(tw='2', total_invest, 0)) AS total_invest2,
            SUM(IF(tw='2', tenaga_kerja, 0)) AS naker2,
            SUM(IF(tw='3', proyek, 0)) AS proyek3,
            SUM(IF(tw='3', total_invest, 0)) AS total_invest3,
            SUM(IF(tw='3', tenaga_kerja, 0)) AS naker3,
            SUM(IF(tw='4', proyek, 0)) AS proyek4,
            SUM(IF(tw='4', total_invest, 0)) AS total_invest4,
            SUM(IF(tw='4', tenaga_kerja, 0)) AS naker4 FROM euis_investratio where tahun = '2021'and jenis = 'pma'
           ";
    $result = $this->db->query($sql);
    return $result->row();
  }
  
public function get_perdin($id) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($id) || !is_numeric($id)) {
        return null; // Validasi jika ID kosong atau bukan angka
    }

    $query = $this->otherdb->select('*')
                           ->from('keu_perdin')
                           ->where('id', $id)
                           ->get();

    return $query->row(); // Langsung return hasil query
}

  
  public function get_n_sektor($id) {
    $data = " - ";
    if($id==2){
      $data = 'ESDM';
    }else if($id==1){
      $data = 'PUPR';
    }else if($id==22){
      $data = 'KUKM';
    }else{
      $sektor = $this->db->select('n_sektor')
                         ->from('trsektor')
                         ->where('id', $id)
                         ->get()->row();
      
      if(!empty($sektor->n_sektor)) {
        $data = $sektor->n_sektor;
      }
    }
    return $data;
  }
  
  public function get_n_mpp($id) {
    $data = " - ";
    $mpp = $this->db->select('nama_mpp')
                    ->from('euis_bukutamu_mpp')
                    ->where('id', $id)
                    ->get()->row();
    if(!empty($mpp->nama_mpp)) {
      $data = $mpp->nama_mpp;
    }
    return $data;
  }
  
  public function get_n_user($id) {
    $data = " - BELUM DIINISIASI -";
    $pegawai = $this->db->select('oriname')
                        ->from('user')
                        ->where('id', $id)
                        ->get()->row();
    if(!empty($pegawai->oriname)) {
      $data = $pegawai->oriname;
    }
    return $data;
  }
  
public function get_n_pegawai($id) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb
    
    if (empty($id)) {
        return " - "; // Jika ID kosong, kembalikan default " - "
    }

    $pegawai = $this->otherdb->select('n_pegawai')
                             ->from('tmpegawai')
                             ->where('id', $id)
                             ->get()
                             ->row();

    return !empty($pegawai) ? $pegawai->n_pegawai : " - ";
}

  
public function get_data_per_month_old($id, $bulan, $tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb
    
    if (empty($id) || empty($bulan) || empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter yang kosong, langsung return '0'
    }

    $sql = "SELECT SUM(jumlah_uang) AS jumlah_uang 
            FROM keu_perdin 
            WHERE MONTH(tanggal_berangkat) = ? 
            AND DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND id_pegawai = ?";

    $query = $this->otherdb->query($sql, [$bulan, $tgla, $tglb, $id]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

  
public function get_data_per_month($id, $bulan, $tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb
    
    if (empty($id) || empty($bulan) || empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter yang kosong, langsung return '0'
    }

    $sql = "SELECT SUM(uang_hari) AS jumlah_uang 
            FROM keu_perdin 
            WHERE MONTH(tanggal_berangkat) = ? 
            AND DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND id_pegawai = ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$bulan, $tgla, $tglb, $id]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

public function get_total_uangperjalanan($id, $tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($id) || empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter yang kosong, langsung return '0'
    }

    $sql = "SELECT SUM(jumlah_uang) AS jumlah_uang 
            FROM keu_perdin 
            WHERE id_pegawai = ?  
            AND DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$id, $tgla, $tglb]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

  
public function get_total_jumlahperjalanan($id, $tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($id) || empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter yang kosong, langsung return '0'
    }

    $sql = "SELECT SUM(uang_hari) AS jumlah_uang 
            FROM keu_perdin 
            WHERE id_pegawai = ?  
            AND DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$id, $tgla, $tglb]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

      
public function get_total_jumlahperjalanan_semua($tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($tgla) || empty($tglb)) {
        return '0'; // Jika tanggal kosong, langsung return '0'
    }

    $sql = "SELECT SUM(jumlah_uang) AS jumlah_uang 
            FROM keu_perdin 
            WHERE DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$tgla, $tglb]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

  
public function get_data_perbulan($bulan, $tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($bulan) || empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter kosong, langsung return '0'
    }

    $sql = "SELECT SUM(uang_hari) AS jumlah_uang 
            FROM keu_perdin 
            WHERE MONTH(tanggal_berangkat) = ? 
            AND DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$bulan, $tgla, $tglb]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

      
public function get_data_perbulan_jumlah($tgla, $tglb) {
    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($tgla) || empty($tglb)) {
        return '0'; // Jika ada parameter kosong, langsung return '0'
    }

    $sql = "SELECT SUM(uang_hari) AS jumlah_uang 
            FROM keu_perdin 
            WHERE DATE(tanggal_berangkat) BETWEEN ? AND ? 
            AND YEAR(tanggal_berangkat) = YEAR(CURDATE())";

    $query = $this->otherdb->query($sql, [$tgla, $tglb]);
    $result = $query->row();

    return !empty($result->jumlah_uang) ? $result->jumlah_uang : '0';
}

      
  public function get_n_nip($id) {
    $data = " - ";
    if($data != "") {
      $pegawai = $this->db->select('nip')
                          ->from('tmpegawai')
                          ->where('id', $id)
                          ->get()->row();
      if(!empty($pegawai->nip)) {
        $data = $pegawai->nip;
      }
    }
    return $data;
  }

  public function get_kabupaten() {
    $sql = "SELECT * from trkabupaten";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  public function get_pegawai() {
    $sql = "SELECT * from tmpegawai";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  
  function get_number($number){
    // var_dump($number);die();
    $result =  filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    return $result;
  }
  
  public function get_n_kabupaten($id) {
    $data = " - ";
    if($data != "") {
      $pegawai = $this->db->select('n_kabupaten')
                          ->from('trkabupaten')
                          ->where('id', $id)
                          ->get()->row();
      if(!empty($pegawai->n_kabupaten)) {
        $data = $pegawai->n_kabupaten;
      }
    }
    return $data;
  }
      
  public function get_n_nik($id) {
    $data = " - ";
    if($data != "") {
      $pegawai = $this->db->select('nik')
                          ->from('tmpegawai')
                          ->where('id', $id)
                          ->get()->row();
      if(!empty($pegawai->nik)) {
        $data = $pegawai->nik;
      }
    }
    return $data;
  }
      
  public function get_n_jabatan($id) {
    $data = " - ";
    if($data != "") {
      $pegawai = $this->db->select('n_jabatan')
                          ->from('tmpegawai')
                          ->where('id', $id)
                          ->get()->row();
      
      if(!empty($pegawai->n_jabatan)) {
        $data = $pegawai->n_jabatan;
      }
    }
    return $data;
  }
  
  public function get_namabidang() {
    $sql = "select * from euis_cal_bidang";
    $result = $this->db->query($sql)->result();
    return $result;
  }
      
  public function update_data($tgl_pembayaran, $user_id,  $lama_perjalanan_dinas,$id,$id_pegawai, $no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_saku_peserta_jumlah, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $sewa_taksi_kota_asal_hari, $sewa_taksi_kota_asal_harga, $sewa_taksi_kota_asal_jumlah, $sewa_taksi_kota_tujuan_hari, $sewa_taksi_kota_tujuan_harga, $sewa_taksi_kota_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $informasi_tiket_berangkat_maskapai, $informasi_tiket_berangkat_no_tiket, $informasi_tiket_berangkat_kodebooking, $informasi_tiket_berangkat_no_penerbangan, $informasi_tiket_berangkat_asal_daerah, $informasi_tiket_berangkat_tujuan, $informasi_tiket_berangkat_tanggal, $informasi_tiket_berangkat_kelas, $informasi_tiket_berangkat_harga_tiket, $informasi_tiket_kembali_maskapai, $informasi_tiket_kembali_nama, $informasi_tiket_kembali_no_tiket, $informasi_tiket_kembali_kode_booking, $informasi_tiket_kembali_no_penerbangan, $informasi_tiket_kembali_asal_daerah, $informasi_tiket_kembali_tujuan, $informasi_tiket_kembali_tanggal, $informasi_tiket_kembali_kelas, $informasi_tiket_kembali_harga_tiket, $nama_penginapan, $keterangan) {
    $data = array('lama_perjalanan_dinas' => $lama_perjalanan_dinas,
                  'no_bku' => $no_bku,
                  'uraian' => $uraian,
                  'tujuan' => $tujuan,
                  'user_id' => $user_id,
                  'skpd' => $skpd,
                  'tgl_pembayaran' => $tgl_pembayaran,
                  'no__sppd' => $no__sppd,
                  'tanggal_berangkat' => $tanggal_berangkat,
                  'tgl_surat' => $tgl_surat,
                  'tanggal_kembali' => $tanggal_kembali,
                  'uang_hari' => $uang_hari,
                  'harga_hari' => $harga_hari,
                  'jumlah_uang' => $jumlah_uang,
                  'representasi_hari' => $representasi_hari,
                  'representasi_harga' => $representasi_harga,
                  'jumlah_representasi' => $jumlah_representasi,
                  'uang_sakuhari' => $uang_sakuhari,
                  'uang_sakuharga' => $uang_sakuharga,
                  'uang_saku_peserta_jumlah' => $uang_saku_peserta_jumlah,
                  'penginapan_malam' => $penginapan_malam,
                  'penginapan_harga' => $penginapan_harga,
                  'penginapan_jumlah' => $penginapan_jumlah,
                  'tikettol_pulang' => $tikettol_pulang,
                  'tikettol_pergi' => $tikettol_pergi,
                  'tikettol_jumlah' => $tikettol_jumlah,
                  'sewa_taksi_kota_asal_hari' => $sewa_taksi_kota_asal_hari,
                  'sewa_taksi_kota_asal_harga' => $sewa_taksi_kota_asal_harga,
                  'sewa_taksi_kota_asal_jumlah' => $sewa_taksi_kota_asal_jumlah,
                  'sewa_taksi_kota_tujuan_hari' => $sewa_taksi_kota_tujuan_hari,
                  'sewa_taksi_kota_tujuan_harga' => $sewa_taksi_kota_tujuan_harga,
                  'sewa_taksi_kota_tujuan_jumlah' => $sewa_taksi_kota_tujuan_jumlah,
                  'sewa_kendaraan_hari' => $sewa_kendaraan_hari,
                  'sewa_kendaraan_harga' => $sewa_kendaraan_harga,
                  'sewa_kendaraan_jumlah' => $sewa_kendaraan_jumlah,
                  'bbm_liter' => $bbm_liter,
                  'bbm_harga' => $bbm_harga,
                  'bbm_jumlah' => $bbm_jumlah,
                  'swabdi_kota_asal' => $swabdi_kota_asal,
                  'swabdi_kota_tujuan' => $swabdi_kota_tujuan,
                  'swab_jumlah' => $swab_jumlah,
                  'jumlah_total' => $jumlah_total,
                  'informasi_tiket_berangkat_maskapai' => $informasi_tiket_berangkat_maskapai,
                  'informasi_tiket_berangkat_no_tiket' => $informasi_tiket_berangkat_no_tiket,
                  'informasi_tiket_berangkat_kodebooking' => $informasi_tiket_berangkat_kodebooking,
                  'informasi_tiket_berangkat_no_penerbangan' => $informasi_tiket_berangkat_no_penerbangan,
                  'informasi_tiket_berangkat_asal_daerah' => $informasi_tiket_berangkat_asal_daerah,
                  'informasi_tiket_berangkat_tujuan' => $informasi_tiket_berangkat_tujuan,
                  'informasi_tiket_berangkat_tanggal' => $informasi_tiket_berangkat_tanggal,
                  'informasi_tiket_berangkat_kelas' => $informasi_tiket_berangkat_kelas,
                  'informasi_tiket_berangkat_harga_tiket' => $informasi_tiket_berangkat_harga_tiket,
                  'informasi_tiket_kembali_maskapai' => $informasi_tiket_kembali_maskapai,
                  'informasi_tiket_kembali_nama' => $informasi_tiket_kembali_nama,
                  'informasi_tiket_kembali_no_tiket' => $informasi_tiket_kembali_no_tiket,
                  'informasi_tiket_kembali_kode_booking' => $informasi_tiket_kembali_kode_booking,
                  'informasi_tiket_kembali_no_penerbangan' => $informasi_tiket_kembali_no_penerbangan,
                  'informasi_tiket_kembali_asal_daerah' => $informasi_tiket_kembali_asal_daerah,
                  'informasi_tiket_kembali_tujuan' => $informasi_tiket_kembali_tujuan,
                  'informasi_tiket_kembali_tanggal' => $informasi_tiket_kembali_tanggal,
                  'informasi_tiket_kembali_kelas' => $informasi_tiket_kembali_kelas,
                  'informasi_tiket_kembali_harga_tiket' => $informasi_tiket_kembali_harga_tiket,
                  'nama_penginapan' => $nama_penginapan,
                  'keterangan' => $keterangan
                 );

    $this->otherdb = $this->load->database('otherdb', TRUE); // Gunakan koneksi otherdb

    if (empty($id) || !is_numeric($id)) {
        return false; // Validasi jika ID kosong atau bukan angka
    }

    $this->otherdb->where('id', $id);
    return $this->otherdb->update('keu_perdin', $data); // Langsung return hasil update
  }
  
public function save_data($tgl_pembayaran, $user_id, $tmpegawai, $lama_perjalanan_dinas, $no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_saku_peserta_jumlah, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $sewa_taksi_kota_asal_hari, $sewa_taksi_kota_asal_harga, $sewa_taksi_kota_asal_jumlah, $sewa_taksi_kota_tujuan_hari, $sewa_taksi_kota_tujuan_harga, $sewa_taksi_kota_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $informasi_tiket_berangkat_maskapai, $informasi_tiket_berangkat_no_tiket, $informasi_tiket_berangkat_kodebooking, $informasi_tiket_berangkat_no_penerbangan, $informasi_tiket_berangkat_asal_daerah, $informasi_tiket_berangkat_tujuan, $informasi_tiket_berangkat_tanggal, $informasi_tiket_berangkat_kelas, $informasi_tiket_berangkat_harga_tiket, $informasi_tiket_kembali_maskapai, $informasi_tiket_kembali_nama, $informasi_tiket_kembali_no_tiket, $informasi_tiket_kembali_kode_booking, $informasi_tiket_kembali_no_penerbangan, $informasi_tiket_kembali_asal_daerah, $informasi_tiket_kembali_tujuan, $informasi_tiket_kembali_tanggal, $informasi_tiket_kembali_kelas, $informasi_tiket_kembali_harga_tiket, $nama_penginapan, $keterangan) {
    
    // Load database kedua (otherdb)
    $otherdb = $this->load->database('otherdb', TRUE);

    $data = array(
        'id_pegawai' => $tmpegawai,
        'lama_perjalanan_dinas' => $lama_perjalanan_dinas,
        'no_bku' => $no_bku,
        'uraian' => $uraian,
        'tujuan' => $tujuan,
        'user_id' => $user_id,
        'skpd' => $skpd,
        'no__sppd' => $no__sppd,
        'tanggal_berangkat' => $tanggal_berangkat,
        'tgl_pembayaran' => $tgl_pembayaran,
        'tgl_surat' => $tgl_surat,
        'tanggal_kembali' => $tanggal_kembali,
        'uang_hari' => $uang_hari,
        'harga_hari' => $harga_hari,
        'jumlah_uang' => $jumlah_uang,
        'representasi_hari' => $representasi_hari,
        'representasi_harga' => $representasi_harga,
        'jumlah_representasi' => $jumlah_representasi,
        'uang_sakuhari' => $uang_sakuhari,
        'uang_sakuharga' => $uang_sakuharga,
        'uang_saku_peserta_jumlah' => $uang_saku_peserta_jumlah,
        'penginapan_malam' => $penginapan_malam,
        'penginapan_harga' => $penginapan_harga,
        'penginapan_jumlah' => $penginapan_jumlah,
        'tikettol_pulang' => $tikettol_pulang,
        'tikettol_pergi' => $tikettol_pergi,
        'tikettol_jumlah' => $tikettol_jumlah,
        'sewa_taksi_kota_asal_hari' => $sewa_taksi_kota_asal_hari,
        'sewa_taksi_kota_asal_harga' => $sewa_taksi_kota_asal_harga,
        'sewa_taksi_kota_asal_jumlah' => $sewa_taksi_kota_asal_jumlah,
        'sewa_taksi_kota_tujuan_hari' => $sewa_taksi_kota_tujuan_hari,
        'sewa_taksi_kota_tujuan_harga' => $sewa_taksi_kota_tujuan_harga,
        'sewa_taksi_kota_tujuan_jumlah' => $sewa_taksi_kota_tujuan_jumlah,
        'sewa_kendaraan_hari' => $sewa_kendaraan_hari,
        'sewa_kendaraan_harga' => $sewa_kendaraan_harga,
        'sewa_kendaraan_jumlah' => $sewa_kendaraan_jumlah,
        'bbm_liter' => $bbm_liter,
        'bbm_harga' => $bbm_harga,
        'bbm_jumlah' => $bbm_jumlah,
        'swabdi_kota_asal' => $swabdi_kota_asal,
        'swabdi_kota_tujuan' => $swabdi_kota_tujuan,
        'swab_jumlah' => $swab_jumlah,
        'jumlah_total' => $jumlah_total,
        'informasi_tiket_berangkat_maskapai' => $informasi_tiket_berangkat_maskapai,
        'informasi_tiket_berangkat_no_tiket' => $informasi_tiket_berangkat_no_tiket,
        'informasi_tiket_berangkat_kodebooking' => $informasi_tiket_berangkat_kodebooking,
        'informasi_tiket_berangkat_no_penerbangan' => $informasi_tiket_berangkat_no_penerbangan,
        'informasi_tiket_berangkat_asal_daerah' => $informasi_tiket_berangkat_asal_daerah,
        'informasi_tiket_berangkat_tujuan' => $informasi_tiket_berangkat_tujuan,
        'informasi_tiket_berangkat_tanggal' => $informasi_tiket_berangkat_tanggal,
        'informasi_tiket_berangkat_kelas' => $informasi_tiket_berangkat_kelas,
        'informasi_tiket_berangkat_harga_tiket' => $informasi_tiket_berangkat_harga_tiket,
        'informasi_tiket_kembali_maskapai' => $informasi_tiket_kembali_maskapai,
        'informasi_tiket_kembali_nama' => $informasi_tiket_kembali_nama,
        'informasi_tiket_kembali_no_tiket' => $informasi_tiket_kembali_no_tiket,
        'informasi_tiket_kembali_kode_booking' => $informasi_tiket_kembali_kode_booking,
        'informasi_tiket_kembali_no_penerbangan' => $informasi_tiket_kembali_no_penerbangan,
        'informasi_tiket_kembali_asal_daerah' => $informasi_tiket_kembali_asal_daerah,
        'informasi_tiket_kembali_tujuan' => $informasi_tiket_kembali_tujuan,
        'informasi_tiket_kembali_tanggal' => $informasi_tiket_kembali_tanggal,
        'informasi_tiket_kembali_kelas' => $informasi_tiket_kembali_kelas,
        'informasi_tiket_kembali_harga_tiket' => $informasi_tiket_kembali_harga_tiket,
        'nama_penginapan' => $nama_penginapan,
        'keterangan' => $keterangan
    );

    $save = $otherdb->insert('keu_perdin', $data);

    if ($save) {
        return $otherdb->insert_id();
    } else {
        return 0;
    }
}

      
  public function get_tujuan($nomor) {
    switch ($nomor) {
      case '1':
        $data = "Informasi";
        break;
      case '2':
        $data = "OSS";
        break;
      case '3':
        $data = "LKPM";
        break;
      case '4':
        $data = "Pengaduan";
        break;
      default:
        $data = " - BELUM DIINISIASI - ";
        break;
    }
    return $data;
  }

public function delete_perdin($id) {
    $del = $this->otherdb->delete('keu_perdin', array('id' => $id));
    return $del ? true : false;
}

}