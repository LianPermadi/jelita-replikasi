<?php 
 
class M_login extends CI_Model{	
  function cek_login($table,$where){		
    $otherdb = $this->load->database('otherdb',TRUE);
    return $otherdb->get_where($table,$where);
  }	
  
  function user_login($table,$where){		
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = $otherdb->get_where('user',$where);
    return $data->result_array();
  }	
  
  function get_perdin($tgla, $tglb) {
      // Pastikan parameter tanggal tidak kosong dan memiliki format yang valid
      if (empty($tgla) || empty($tglb)) {
          return []; // Mengembalikan array kosong jika parameter tidak valid
      }

      // Gunakan koneksi otherdb
      $otherdb = $this->load->database('otherdb', TRUE);

      // Mulai transaksi
      $otherdb->trans_start();

      $sql = "SELECT * FROM keu_perdin 
              WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
              GROUP BY id_pegawai
              ORDER BY tanggal_berangkat ASC";

      // Eksekusi query dengan koneksi otherdb
      $query = $otherdb->query($sql, array($tgla, $tglb));

      // Selesaikan transaksi
      $otherdb->trans_complete();

      // Periksa apakah transaksi sukses
      if ($otherdb->trans_status() === FALSE) {
          return []; // Mengembalikan array kosong jika query gagal
      }

      return $query->result(); // Kembalikan hasil query
  }
}