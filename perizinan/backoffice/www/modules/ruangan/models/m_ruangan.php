<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 * @author nirwan
 * Created : 08 Apr 2021
 */

class M_ruangan extends Model {
    // public function get_data($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
    //     $result = array();
    //     $sql = "SELECT * 
    //         FROM ruangan_pemakai 
    //         WHERE (DATE(tanggal) BETWEEN ? AND ?) 
    //         ORDER BY tanggal DESC";

    //         $result = $this->db->query($sql, array($tgla, $tglb))->result();

    //     return $result;
    // }

  public function get_data($tgla = NULL, $tglb = NULL) {
    $sql = "SELECT * 
            FROM ruangan_pemakai 
            WHERE (DATE(tanggal) BETWEEN ? AND ?) 
            ORDER BY tanggal DESC";
    $result = $this->db->query($sql, array($tgla, $tglb))->result();
    return $result;
  }
  
  public function get_detail_ruangan($id_ruang = NULL, $tgla = NULL, $tglb = NULL) {
  	//var_dump($id_ruang.' | '.$tgla.' | '.$tglb);
  	if($tgla == 0 && $tglb == 0){
      $sql = "SELECT * 
              FROM ruangan_pemakai 
              WHERE (id_ruangan = ".$id_ruang.") 
              ORDER BY tanggal DESC";
    }else{
      $sql = "SELECT * 
              FROM ruangan_pemakai 
              WHERE (id_ruangan = ".$id_ruang." AND DATE(tanggal) BETWEEN '".$tgla."' AND '".$tglb."') 
              ORDER BY tanggal DESC";
    }
    //var_dump($sql);
    //$result = $this->db->query($sql, array($tgla, $tglb))->result();
    $result = $this->db->query($sql)->result();
    return $result;
  }

    public function get_data_id($id) {
        
            $sql = "SELECT * 
                FROM ruangan_pemakai 
            WHERE id = '$id'
            ORDER BY tanggal DESC";

                $result = $this->db->query($sql)->result();
       
       
        return $result;
    }

    public function get_id_user_pic($id) {
        
        $sql = "SELECT *  FROM `ruangan_pic` WHERE `id_ruangan` = '$id'";
        $result = $this->db->query($sql)->result();
        // var_dump($result);die();
        return $result;
    }

    public function get_pic_one($id_peg, $id) {
        
        $sql = "SELECT *  FROM `ruangan_pic` WHERE `id_ruangan` = '$id' AND id_pegawai = '$id_peg'";
        $result = $this->db->query($sql)->result();
        // var_dump($result);die();
        return $result;
    }
    
  public function get_data_pegawai() {
    $sql = "SELECT * FROM `tmpegawai` WHERE `e_mail` LIKE '%@%' ORDER BY `tmpegawai`.`n_pegawai` ASC";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  
  public function get_master() {
    $result = array();
    $sql = "SELECT * FROM ruangan_master ORDER BY `nama_ruangan` ASC";
    $result = $this->db->query($sql)->result();
    return $result;
  }
    
  public function count_ruangan($id_ruang = null)
{
    $this->db->where('id_ruangan', $id_ruang);
    $this->db->from('ruangan_pemakai');
    return $this->db->count_all_results();
}
  
  public function count_ruangan_batal($id_ruang = null)
{
    $this->db->where('id_ruangan', $id_ruang);
    $this->db->where('status_pembatalan', 1);
    $this->db->from('ruangan_pemakai');
    return $this->db->count_all_results();
}

public function count_dalam_pelaksanaan($id_ruang = null) {
    $this->db->where('id_ruangan', $id_ruang);
    $this->db->where('status_pembatalan', 0);
    $this->db->where('tanggal >=', date('Y-m-d'));
    $total = $this->db->count_all_results('ruangan_pemakai');
    return $total;
}
  
  public function count_ruangan_eviden($id_ruang = NULL) {
    $sql = "SELECT * 
            FROM ruangan_pemakai 
            WHERE (id_ruangan = ".$id_ruang." AND status_pembatalan = 0 ) 
            ORDER BY tanggal DESC";
    $result = $this->db->query($sql)->result();
    $jum_Done=$jum_Red=0;
    foreach ($result as $row) { 
    	$pattern = 'assets/ruangan/notulen/NOTULEN_' . $row->id . '.pdf';
      $pattern_wildcard = 'assets/ruangan/notulen/NOTULEN_*' . $row->id . '*.pdf';
      if(file_exists($pattern) || glob($pattern_wildcard)) {
        $jum_Done++;
      }else{
        $jum_Red++;
      }
    }	
    $var = $jum_Done.','.$jum_Red;
    return explode(',', $var);
  }
    
  public function count_presensi_idcard($id_ruang=null) {
  	$sql = "SELECT * FROM ruangan_pemakai 
            WHERE (id_ruangan = ".$id_ruang." ) 
            ORDER BY tanggal DESC";
    $result = $this->db->query($sql)->result();
    $total = 0;
    foreach ($result as $row) {
      $absensi = new absensi_mpp();
      $absensi->where('kegiatan', $row->id);
      $absensi->where('sys_absen', 2);
      $total = $total + $absensi->count();
    }
    return $total;
  }
  
  public function count_presensi_agenda($id_ruang=null) {
  	$sql = "SELECT * FROM ruangan_pemakai 
            WHERE (id_ruangan = ".$id_ruang." ) 
            ORDER BY tanggal DESC";
    $result = $this->db->query($sql)->result();
    $total = 0;
    foreach ($result as $row) {
      $absensi = new absensi_mpp();
      $absensi->where('kegiatan', $row->id);
      $absensi->where('sys_absen', 0);
      $total = $total + $absensi->count();
    }
    return $total;
  }
  
  public function count_presensi_euis($id_ruang=null) {
  	$sql = "SELECT * FROM ruangan_pemakai 
            WHERE (id_ruangan = ".$id_ruang." ) 
            ORDER BY tanggal DESC";
    $result = $this->db->query($sql)->result();
    $total = 0;
    foreach ($result as $row) {
      $absensi = new absensi_mpp();
      $absensi->where('kegiatan', $row->id);
      $absensi->where('sys_absen', 1);
      $total = $total + $absensi->count();
    }
    return $total;
  }
  
  public function count_all_idcard(){
    $absensi = new absensi_mpp();
    $absensi->where('sys_absen', 2);
    $total = $absensi->count();
    return $total;	
  }
  
  public function count_all_euis(){
    $absensi = new absensi_mpp();
    $absensi->where('sys_absen', 1);
    $total = $absensi->count();
    return $total;
  }
  
  public function count_all_agenda(){
    $absensi = new absensi_mpp();
    $absensi->where('sys_absen', 0);
    $total = $absensi->count();
    return $total;
  }

  public function count_idcard($id_ruang=null){
    $absensi = new absensi_mpp();
    $absensi->where('kegiatan', $id_ruang);
    $absensi->where('sys_absen', 2);
    $total = $absensi->count();
    return $total;	
  }
  
  public function count_euis($id_ruang=null){
    $absensi = new absensi_mpp();
    $absensi->where('kegiatan', $id_ruang);
    $absensi->where('sys_absen', 1);
    $total = $absensi->count();
    return $total;
  }
  
  public function count_agenda($id_ruang=null){
    $absensi = new absensi_mpp();
    $absensi->where('kegiatan', $id_ruang);
    $absensi->where('sys_absen', 0);
    $total = $absensi->count();
    return $total;
  }

  public function get_id_pegawai($id){
    $data = '-';
    $ruangan = $this->db->select('tmpegawai_id')
                    ->from('tmpegawai_user')
                    ->where('user_id', $id)
                    ->get()->row();
    if(!empty($ruangan->tmpegawai_id)){
      $data = $ruangan->tmpegawai_id;
    }
    return $data;
  }

    public function get_ruangan($stat_admin=null) {
    	  if($stat_admin){
          $sql = "SELECT id, nama_ruangan, lantai, kapasitas, status, foto 
                  FROM ruangan_master";
        }else{
        	$sql = "SELECT id, nama_ruangan, lantai, kapasitas, status, foto 
                  FROM ruangan_master where status = 1";
        }        
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_datapakai($id) {
        $ruangan = $this->db->select('*')
                     ->from('ruangan_pemakai')
                     ->where('id', $id)
                     ->get()->row();

        return $ruangan;
    }
    public function get_nippegawai($id) {
        $ruangan = $this->db->select('nip')
                     ->from('tmpegawai')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->nip)) {
            $data = $ruangan->nip;
        }else{
        	$data = 'blank';
        }
        
        return $data;

        //return $ruangan;
    }

    public function get_datamaster($id) {
        $ruangan = $this->db->select('*')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();
        return $ruangan;
    }

    public function get_absensi($id) {
        $absensi = $this->db->select('*')
                     ->from('absensi_mpp')
                     ->where('kegiatan', $id)
                     ->get()->result();

        return $absensi;
    }

    public function get_nama($id) {
        $data = " - ";
        $ruangan = $this->db->select('nama_ruangan')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->nama_ruangan)) {
            $data = $ruangan->nama_ruangan;
        }
        return $data;
    }
    
    public function get_lantai($id) {
        $data = " - ";
        $ruangan = $this->db->select('lantai')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->lantai)) {
            $data = $ruangan->lantai;
        }
        return $data;
    }

    public function get_foto($id) {
        $data = "";
        $ruangan = $this->db->select('foto')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->foto)) {
            $data = $ruangan->foto;
        }
        return $data;
    }

    // public function get_data_cetak_excel($tgla = 0, $tglb = 0, $iduser = NULL, $admin = NULL) {
    //     if ($admin == 1) {
    //         $sql = "SELECT * 
    //             FROM ruangan_pemakai 
    //             WHERE (DATE(tanggal) BETWEEN ? AND ?)
    //             ORDER BY tanggal DESC";

    //             $result = $this->db->query($sql, array($tgla, $tglb))->result();
    //     } else {
    //         $sql = "SELECT * 
    //             FROM ruangan_pemakai 
    //             WHERE (DATE(tanggal) BETWEEN ? AND ?) AND user_id = ?
    //             ORDER BY tanggal DESC";

    //             $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    //     }

    //     return $result;
    // } Memisahkan admin dan user

    public function get_data_cetak_excel($tgla = 0, $tglb = 0) {
            $sql = "SELECT * 
                FROM ruangan_pemakai 
                WHERE (DATE(tanggal) BETWEEN ? AND ?)
                ORDER BY tanggal DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();


        return $result;
    }


    public function get_seksi($nomor) {  // gunakan fungsi get_tot dibawah
        switch ($nomor) {
            case '1':
                 $data = "PPIPM (Urusan Perencanaan dan Pengembangan Iklim Penanaman Modalx";
                 break;
            case '2':
                $data = "PKH (Urusan Promosi, Kerjasama dan Hilirisasi Investasi)x";
                break;
            case '3':
                $data = "INSOS (Urusan Pelayanan Perizinan Infrastruktur dan Sosial)x";
                break;
            case '4':
                $data = "ESDA (Urusan Pelayanan Perizinan Ekonomi dan Sumber Daya Alam)x";
                break;
            case '5':
                $data = "DALLAK (Urusan Pengendalian Pelaksanaan Penanaman Modal)x";
                break;
            case '6':
                $data = "DATIN (Urusan Data dan Informasi)x";
                break;
            case '7':
                $data = "PADUVOK (Urusan Penyuluhan, Pengaduan dan Advokasi)x";
                break; 
            case '8':
                $data = "Sub Bagian Tata Usahax";
                break;
            case '9':
                $data = "Sekretaris Dinas PMPTSPx";
                break;
            case '10':
                $data = "Kepala Dinas PMPTSPx";
                break;
            case '11':
                $data = "Badan Pengelola Kawasan Rebanax";
                break;
            case '12':
                $data = "Aturan dan Kebijakan ( Ranjak)x";
                break;
            case '13':
                $data = "Kemitraan dan Penialian Kinerja (KPK)x";
                break;
            case '14':
                $data = "Pelayanan Advokasi Hukum (ReAvoK)x";
                break;
            case '15':
                $data = "Pembinaan dan Kinerja (Pemkin)x";
                break;
            case '16':
                $data = "Data dan Penyelesaian Permasalahan  (MasLahta)x";
                break;
            case '17':
                $data = "Digitalisasi Internal dan Eksternal (DgIE)x";
                break;
            case '18':
                $data = "Potensi Promosi dan Investasi  (PPI)x";
                break;
            case '19':
                $data = "Pelayanan Perizinan ( DurZin)x";
                break;
            case '20':
                $data = "Pengawasan Pelaku Usaha (WaspelkU)x";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }


  public function get_tot($id) {
    $data = " - ";
    $tot = $this->db->select('nama_tim')
                ->from('koor_tot')
                ->where('id', $id)
                ->where('thn_anggaran', $this->session->userdata('set_year'))
                ->get()->row(); 
    if(!empty($tot->nama_tim)) {
      $data = $tot->nama_tim;
    }
    return $data;
  }

      public function get_set_koor() {
        $result = array();
        $current_year = date('Y');
        $sql = "SELECT * FROM koor_tot WHERE thn_anggaran = ?";

        $result = $this->db->query($sql, array($current_year))->result();

        return $result;
    }
  
  public function update_send_Notif($id,$val_sts_notif,$sender_notif){
    $data = array('sts_notif' => $val_sts_notif,
                  'sender_notif' => $sender_notif);
    $this->db->where('id', $id);
    $save = $this->db->update('ruangan_pemakai', $data);
    if($save){
      $return = true;
    }else{
      $return = false;
    }
    return $return;
  }
  
  public function get_koor($kd_tim=null,$ch=null) {
    $data = " - ";
    $tot = $this->db->select('id_pegawai')
                ->from('koor_tot')
                ->where('kd_tim', $kd_tim)
                ->where('thn_anggaran', $this->session->userdata('set_year'))
                ->get()->row(); 
    if(!empty($tot->id_pegawai)) {
      $data = $tot->id_pegawai;
      if($ch = 'nm'){
        $data = '-';
        $pegawai = $this->db->select('n_pegawai')
                        ->from('tmpegawai')
                        ->where('id', $tot->id_pegawai)
                        ->get()->row();
        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
      }
    }
    return $data;
  }
  
  public function get_n_pegawai($id){
        $data = '-';
        $pegawai = $this->db->select('n_pegawai')
                        ->from('tmpegawai')
                        ->where('id', $id)
                        ->get()->row();
        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        // var_dump($data);die();
        return $data;
  }

  public function get_kt_tim($kd_tim=null,$ch=null) {
    $data = " - ";
    $tot = $this->db->select('id_pegawai')
                ->from('koor_tot')
                ->where('kd_tim', $kd_tim)
                ->where('thn_anggaran', $this->session->userdata('set_year'))
                ->get()->row(); 
    if(!empty($tot->id_pegawai)) {
      $data = $tot->id_pegawai;
      if($ch = 'nm'){
        $data = '-';
        $pegawai = $this->db->select('n_pegawai')
                        ->from('tmpegawai')
                        ->where('id', $tot->id_pegawai)
                        ->get()->row();
        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
      }
    }
    return $data;
  }

    public function get_kegiatan($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Internal";
                break;
            case '1':
                $data = "Eksternal";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function status_booking($id_ruangan, $tanggal, $waktu_awal, $waktu_akhir) {
        $result_hasil = FALSE;
        // $sql = "SELECT * 
        //     FROM ruangan_pemakai 
        //     WHERE (id_ruangan = ? and id_ruangan != 20) AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";
        $sql = "SELECT * FROM ruangan_pemakai WHERE id_ruangan = '$id_ruangan' and id_ruangan != 20 AND tanggal = '$tanggal' AND status_pembatalan = 0";
        // var_dump($sql,$id_ruangan, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir);die();

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql)->result();

        // $result = $this->db->query($sql, array($id_ruangan, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
        foreach ($result as $row) {
            // Cek apakah ada overlap waktu booking
            if ($waktu_awal <= $row->waktu_awal && $waktu_akhir >= $row->waktu_akhir) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
            if ($waktu_awal <= $row->waktu_akhir && $waktu_akhir >= $row->waktu_awal) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
        }
     
        // if (!empty($result)) {
        //     return true;
        // } else {
        //     return false;
        // }
        if($result_hasil){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function ruangan_pic_edit($id, $pegawai) {
        // Hapus data lama dengan id_ruangan tertentu
        $this->db->where('id_ruangan', $id);
        $this->db->delete('ruangan_pic');

        // Tambah data baru untuk setiap pegawai
        // foreach ($pegawai as $row) {
        //     $data = array(
        //         'id_pegawai' => $row,
        //         'id_ruangan' => $id
        //     );
        //     $this->db->insert('ruangan_pic', $data);
        // }

        return true; // Tambahkan nilai kembalian jika diperlukan
    }

    public function update_booking($id, $id_ruangan, $tanggal, $waktu_awal, $waktu_akhir) {
        // $result = array();
        // $sql = "SELECT * 
        //     FROM ruangan_pemakai 
        //     WHERE id = ? AND id_ruangan = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        // $result = $this->db->query($sql, array($id, $id_ruangan, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        // if (!empty($result)) {
        //     return true;
        // } else {
        //     return false;
        // }


        $result_hasil = FALSE;
        $sql = "SELECT * FROM ruangan_pemakai WHERE id_ruangan = '$id_ruangan' and id_ruangan != 20 AND tanggal = '$tanggal' AND status_pembatalan = 0 AND id NOT LIKE '$id'";
        // $sql = "SELECT * FROM ruangan_pemakai WHERE id_ruangan = '$id_ruangan' and id_ruangan != 20 AND tanggal = '$tanggal'";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            // Cek apakah ada overlap waktu booking
            if ($waktu_awal < $row->waktu_awal && $waktu_akhir > $row->waktu_akhir) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
            if ($waktu_awal < $row->waktu_akhir && $waktu_akhir > $row->waktu_awal) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
        }
        if($result_hasil){
            return true;
        }else{
            return false;
        }
    }

    public function penyelenggara($seksi, $tanggal, $waktu_awal, $waktu_akhir) {
        $result = array();
        $sql = "SELECT * 
            FROM ruangan_pemakai 
            WHERE seksi = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql, array($seksi, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function save_tim($id, $tmpegawai_id) { //, $user_id, $ket
        $data = array(
                        'id_ruanganpemakai'          => $id,
                        'id_pegawai'          => $tmpegawai_id
                     );
        $save = $this->db->insert('ruangan_petugas', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function simpan_pegawai($data, $id) {
        
        $data = array(
            'id_pegawai'   => $data,
            'id_ruangan'   => $id
         );
        $save = $this->db->insert('ruangan_pic', $data);
        return $save;
    }

    public function keterangan_pic($id_peg, $id, $notulen) {
        
        $id_pic = FALSE;
        $ruangan = $this->db->select('id')
                     ->from('ruangan_pic')
                     ->where('id_pegawai', $id_peg)
                     ->where('id_ruangan', $id)
                     ->get()->row();

        if (!empty($ruangan->id)) {
            $id_pic = $ruangan->id;
        }

        $data = array(
            'ket'      => $notulen
         );
        $this->db->where('id', $id_pic);
        $save = $this->db->update('ruangan_pic', $data);
        return $save;
    }

    public function del_tim($id_surat) { //, $user_id, $ket

        $up = $this->db->delete('ruangan_petugas', array('id_ruanganpemakai' => $id_surat));

        if ($up) {
                return true;
        } else {
                 return false;
        }
    }

    // public function get_id_dis($id) {
    //     $surat = $this->db->select('id')
    //                  ->from('ruangan_petugas')
    //                  ->where('id_ruanganpemakai', $id)
    //                  ->get()->row();
    //     var_dump($surat);die();
    //     if(!empty($surat)) {
    //         return $surat->id;
    //     } else {
    //         return 0;
    //     }
    // }
//     public function get_id_user_dis($id) {
//           // 
//         // $sql = "SELECT tmpegawai.id 
//         //         FROM tmpegawai 
//         //         INNER JOIN ruangan_petugas ON tmpegawai.id = ruangan_petugas.id_ruanganpemakai 
//         //         WHERE ruangan_petugas.id_ruanganpemakai = ? 
//         //         ORDER BY tmpegawai.n_pegawai";
//          $sql = "SELECT id_pegawai
//                 FROM ruangan_petugas 

//                 WHERE id_ruanganpemakai = ? 
//                ";
// // var_dump($sql);die();
//         $result = $this->db->query($sql, array($id))->result();

//         return $result;
//     }

    public function save_pakai($id_ruangan, $iduser, $seksi, $kegiatan, $acara, $target_undangan, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $keterangan) {
        $data = array(
                        'id_ruangan'      => $id_ruangan,
                        'user_id'         => $iduser,
                        'seksi'           => $seksi,
                        'kegiatan'        => $kegiatan,
                        'acara'           => $acara,
                        'target_undangan' => $target_undangan,
                        'snack'           => $snack,
                        'mamin'           => $mamin,
                        'tanggal'         => $tanggal,
                        'waktu_awal'      => $waktu_awal,
                        'waktu_akhir'     => $waktu_akhir,
                        'keterangan'      => $keterangan
                     );
        $save = $this->db->insert('ruangan_pemakai', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_pakai($id, $id_ruangan, $seksi, $kegiatan, $acara, $target_undangan, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $keterangan) {
        $data = array(
                        'id_ruangan'      => $id_ruangan,
                        'seksi'           => $seksi,
                        'kegiatan'        => $kegiatan,
                        'acara'           => $acara,
                        'target_undangan' => $target_undangan,
                        'snack'           => $snack,
                        'mamin'           => $mamin,
                        'tanggal'         => $tanggal,
                        'waktu_awal'      => $waktu_awal,
                        'waktu_akhir'     => $waktu_akhir,
                        'keterangan'      => $keterangan
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('ruangan_pemakai', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_pakai($id, $iduser) {
        $waktu_sekarang = date('Y-m-d H:i:s');

        $data = array(
            'id_booking' => $id,
            'user_id_del' => $iduser,
            'deleted_at' => $waktu_sekarang
        );
        $del = $this->db->insert('ruangan_pemakai_del', $data);
        $del2 = $this->db->delete('ruangan_pemakai', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function save_master($nama_ruangan, $lantai, $kapasitas, $fasilitas, $status, $oldfoto) {
        $data = array(
                        'nama_ruangan'    => $nama_ruangan,
                        'lantai'          => $lantai,
                        'kapasitas'       => $kapasitas,
                        'fasilitas'       => $fasilitas,
                        'status'          => $status,
                        'foto'            => $oldfoto
                     );
        $save = $this->db->insert('ruangan_master', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_eviden($pegawai, $id_kegiatan) {
        $data = array(
                        'id_pegawai'    => $pegawai,
                        'id_ruangan'    => $id_kegiatan,
                        'tanggal'       => date('Y-m-d G:i:s')
                     );
        $save = $this->db->insert('ruangan_pic', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

  public function update_master($id, $nama_ruangan, $lantai, $kapasitas, $fasilitas, $status, $oldfoto) {
    $data = array('nama_ruangan'    => $nama_ruangan,
                  'lantai'          => $lantai,
                  'kapasitas'       => $kapasitas,
                  'fasilitas'       => $fasilitas,
                  'status'          => $status,
                  'foto'            => $oldfoto
                 );
    $this->db->where('id', $id);
    $save = $this->db->update('ruangan_master', $data);
    if($save){
      $return = true;
    }else{
      $return = false;
    }
    return $return;
  }

    public function update_notulen($id, $notulen) {
        $data = array(
                        'notulen'       => $notulen
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('ruangan_pemakai', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function cancel_master($id) {
        
        $data = array(
                        'status_pembatalan'       => 1
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('ruangan_pemakai', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function pulihkan_master($id) {
        $sql = "SELECT * FROM ruangan_pemakai WHERE id = '$id'";
        $data_booking = $this->db->query($sql)->first_row();
        $tanggal = $data_booking->tanggal;
        $waktu_awal = $data_booking->waktu_awal;
        $waktu_akhir = $data_booking->waktu_akhir;
        $waktu_akhir = $data_booking->waktu_akhir;
        $id_ruangan = $data_booking->id_ruangan;

        $result_hasil = FALSE;
        $sql = "SELECT * FROM ruangan_pemakai WHERE id_ruangan = '$id_ruangan' and id_ruangan != 20 AND tanggal = '$tanggal' AND status_pembatalan = 0";
        // $sql = "SELECT * FROM ruangan_pemakai WHERE id_ruangan = '$id_ruangan' and id_ruangan != 20 AND tanggal = '$tanggal'";
        $result = $this->db->query($sql)->result();
        foreach ($result as $row) {
            // Cek apakah ada overlap waktu booking
            if ($waktu_awal < $row->waktu_awal && $waktu_akhir > $row->waktu_akhir) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
            if ($waktu_awal < $row->waktu_akhir && $waktu_akhir > $row->waktu_awal) {
                // Jika ada overlap, set $result_hasil menjadi TRUE
                $result_hasil = TRUE;
                break; // Keluar dari loop jika sudah ditemukan konflik
            }
        }
        $save = FALSE;
        if($result_hasil){
            $save_hasil = TRUE;
        }else{
            $save_hasil = FALSE;
        }

        if(!$save_hasil){
            $data = array(
                            'status_pembatalan'       => 0
                        );
            $this->db->where('id', $id);
            $save = $this->db->update('ruangan_pemakai', $data);
        }

            if ($save) {
                $return = TRUE;
            } else {
                $return = FALSE;
            }

            return $return;
    }

    public function hapus_master($id) {
        $del = $this->db->delete('ruangan_master', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_eviden($id) {
        $del = $this->db->delete('ruangan_pic', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_absen($id) {
        $del = $this->db->delete('absensi_mpp', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function get_n_user($id) {
        $data = " - ";
        $pegawai = $this->db->select('oriname')
                     ->from('user')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->oriname)) {
            $data = $pegawai->oriname;
        }
        
        return $data;
    }

    public function get_ruang($nomor) {
        switch ($nomor) {
            case '1':
                $data = "Ruang Rapat Melati (Lantai 1 Gedung B)";
                break;
            // case '2':
            //     $data = "BANGPROM (Fasilitasi)";
            //     break;
            case '3':
                $data = "Ruang Rapat Teratai (Lantai 1 Gedung B)";
                break;
            case '4':
                $data = "Aula Besar (Lantai 1 Gedung B)";
                break;
            case '5':
                $data = "Ruang Rapat Anggrek (Lantai 2 Gedung A)";
                break;
            case '6':
                $data = "Ruang Rapat Seruni (Lantai 2 Gedung A)";
                break;
            case '7':
                $data = "Ruang Rapat Anyelir (Lantai 3 Gedung JIH)";
                break;
            case '8':
                $data = "Ruang Rapat Alamanda (Lantai 3 Gedung JIH)";
                break;
            case '9':
                $data = "Ruang Rapat Bougenville (Lantai 3 Gedung JIH)";
                break;
            case '10':
                $data = "Ruang Rapat Kemuning (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '11':
                $data = "Ruang Rapat Soka (Aula Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '12':
                $data = "Ruang Rapat Kenangan (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '13':
                $data = "Ruang Rapat Cempaka (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '14':
                $data = "Ruang Rapat Mawar (Lantai 6 Gedung B)";
                break;
            case '15':
                $data = "Auditorium (Lantai 4 Gedung JIH)";
                break;
            case '16':
                $data = "Ruang Lavender (Lantai 4 Gedung A)";
                break;
            case '17':
                $data = "Zoom Tempat Masing-masing";
                break;
            case '18':
                $data = "Pamoyanan (Lantai 2)";
                break;
            case '19':
                $data = "Sekretariat PPN (Lantai 2 Gedung JIH)";
                break;
            case '20':
                $data = "Ruang Rapat Lain-Lain";
                break;
            case '21':
                $data = "Ruang Teratai (Lantai 1 Gedung B)";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }
}
