<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 22 Jul 2020

 Develop by Jonas Januari 2022
 *
 */

class M_ossrba extends Model {
  public function get_data($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL, $statusizin = NULL) {
  	switch ($statusizin) {
      case 0:   // Seluruhnya // OK
      	if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  ORDER BY tanggalpermohonan DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();
        }else{
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?
                  ORDER BY tanggalpermohonan DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result(); 
        }
        break;
      case 1:   // Esselon 4
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();
        }else{
        	$sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
      	break;
      case 4:   // Esselon 3
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();	
        }else{
        	$sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
      	break;
      case 3:   // Esselon 2
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();        
        }else{
        	$sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
      	break;
      case 2:   // Selesai Jelita
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();	
        }else{
        	$sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
      	break;
      case 9:   // Selesai OSS RBA
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();	
        }else{
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();	
        }
      	break;
      case 10:   // Selesai OSS RBA // OK
      	if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  and warning  = 1
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();
        }else{
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?
                  and warning  = 1
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
      	break;
      default:
        if($admin == 1) {
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb))->result();	
        }else{
          $sql = "SELECT * 
                  FROM oss_persetujuanpermohonan 
                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
                  AND id_user = ?  
                  AND esselon = $statusizin
                  ORDER BY  tanggalpermohonan  DESC";
          $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();	
        }
      	break;
    }
  	
    //    if($statusizin==0){
    //      if($admin == 1) {
    //        $sql = "SELECT * 
    //                FROM oss_persetujuanpermohonan 
    //                WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                ORDER BY tanggalpermohonan DESC";
    //        $result = $this->db->query($sql, array($tgla, $tglb))->result();
    //      }else{
    //        $sql = "SELECT * 
    //                FROM oss_persetujuanpermohonan 
    //                WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                AND id_user = ?
    //                ORDER BY tanggalpermohonan DESC";
    //        $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    //      }
    //    }else if($statusizin==10){
    //      if($admin == 1) {
    //        $sql = "SELECT * 
    //                FROM oss_persetujuanpermohonan 
    //                WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                and warning  = 1
    //                ORDER BY  tanggalpermohonan  DESC";
    //        $result = $this->db->query($sql, array($tgla, $tglb))->result();
    //      }else{
    //        $sql = "SELECT * 
    //                FROM oss_persetujuanpermohonan 
    //                WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                AND id_user = ?
    //                and warning  = 1
    //                ORDER BY  tanggalpermohonan  DESC";
    //        $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    //      }
    //    }else{
    //      if($admin == 1) {
    //        if($statusizin == 2){
    //          $sql = "SELECT * 
    //                  FROM oss_persetujuanpermohonan 
    //                  WHERE esselon = $statusizin
    //                  ORDER BY  tanggalpermohonan  DESC";
    //        }else{
    //          $sql = "SELECT * 
    //                  FROM oss_persetujuanpermohonan 
    //                  WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                  AND esselon = $statusizin
    //                  ORDER BY  tanggalpermohonan  DESC";
    //        }    
    //        $result = $this->db->query($sql, array($tgla, $tglb))->result();
    //      }else{
    //        $sql = "SELECT * 
    //                FROM oss_persetujuanpermohonan 
    //                WHERE DATE(tanggalpermohonan) BETWEEN ? AND ?
    //                AND id_user = ?  
    //                AND esselon = $statusizin
    //                ORDER BY  tanggalpermohonan  DESC";
    //        $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    //      }
    //    }
    return $result;
  }

    public function get_tipeapp() {
        $sql = "SELECT * from oss_tipeaplikasi";
        $result = $this->db->query($sql)->result();

        return $result;
    }
      public function get_sektor2() {
        $sql = "SELECT * from trsektor";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_namakabupaten() {
        $sql = "SELECT * FROM trkabupaten WHERE kd_prov = 12";
        $result = $this->db->query($sql)->result();

        return $result;
    }


    public function cekduplikatnomorpermohonan($nomorpermohonan) {
        $h;
        $sql = "SELECT count(*) as jumlah from oss_persetujuanpermohonan where nomorpermohonan = '$nomorpermohonan' ";
        $result = $this->db->query($sql)->result();

        foreach ($result as $row) {
            $h = $row->jumlah;
        }
        return $h;
    }

    public function get_data_cetak($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }

        return $result;
    }

    public function get_data_nomor($tgla = NULL, $tglb = NULL) {
        $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND revisi <> 1 AND tipe = 1
                ORDER BY tgl_surat IS NULL DESC, tgl_entry DESC";
        $result = $this->db->query($sql, array($tgla, $tglb))->result();

        return $result;
    }

    public function get_data_masuk($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND tipe = 2
                ORDER BY  tgl_surat IS NULL DESC, tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND tipe = 2
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
        return $result;
    }

    public function get_ess4() {
        $sql = "SELECT tmpegawai.id, tmpegawai.n_pegawai, tmpegawai.n_jabatan 
        		FROM tmpegawai 
        		INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
        		INNER JOIN user ON tmpegawai_user.user_id = user.id
        		WHERE tmpegawai.eselon = '4' AND user.lokasi = 'DPMPTSP Prov. Jabar'
        		ORDER BY tmpegawai.n_pegawai";
		$result = $this->db->query($sql)->result();

		return $result;
    }

    public function get_ess3() {
        $sql = "SELECT tmpegawai.id, tmpegawai.n_pegawai, tmpegawai.n_jabatan 
        		FROM tmpegawai 
        		INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
        		INNER JOIN user ON tmpegawai_user.user_id = user.id
        		WHERE tmpegawai.eselon = '3' AND user.lokasi = 'DPMPTSP Prov. Jabar'
        		ORDER BY tmpegawai.n_pegawai";
		$result = $this->db->query($sql)->result();

		return $result;
    }

    public function get_sekdis() {
        $sql = "SELECT tmpegawai.id, tmpegawai.n_pegawai, tmpegawai.n_jabatan 
                FROM tmpegawai 
                INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
                INNER JOIN user ON tmpegawai_user.user_id = user.id
                WHERE tmpegawai.id = '742' OR tmpegawai.id = '742' AND user.lokasi = 'DPMPTSP Prov. Jabar'
                ORDER BY tmpegawai.n_pegawai";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_ess2() {
        $sql = "SELECT tmpegawai.id, tmpegawai.n_pegawai, tmpegawai.n_jabatan
        		FROM tmpegawai 
        		INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
        		INNER JOIN user ON tmpegawai_user.user_id = user.id
        		WHERE tmpegawai.eselon = '2' AND user.lokasi = 'DPMPTSP Prov. Jabar'
        		ORDER BY tmpegawai.n_pegawai";
		$result = $this->db->query($sql)->result();

		return $result;
    }

    public function save_data($tipe_aplikasi, $fiktif_positif, $metode_cari, $id_user,$nomorpermohonan,$tanggalpermohonan,$nib,$kbli,$sektor,$jenis_perusahaan,$nama_perusahaan,$modal_usaha,$alamat,$jenis_proyek,$nama_perizinan,$skala_usaha,$risiko,$esselon, $turunan_kbli, $no_dokumen, $tgl_dokumen, $npwp, $no_telp, $alamat_usaha, $kab_usaha, $tgl_nib, $status, $masaberlakuizin) {
        $data = array(
                        'id_user'  => $id_user,
                        'nomorpermohonan'  => $nomorpermohonan,
                        'tipe_aplikasi'  => $tipe_aplikasi,
                        'tanggalpermohonan'  => $tanggalpermohonan,
                        'nib'  => $nib,
                        'fiktif_positif'  => $fiktif_positif,
                        'metode_cari'  => $metode_cari,
                        'tgl_nib'  => $tgl_nib,
                        'kbli'  => $kbli,
                        'sektor'  => $sektor,
                        'jenis_perusahaan'  => $jenis_perusahaan,
                        'nama_perusahaan'  => $nama_perusahaan,
                        'modal_usaha'  => $modal_usaha,
                        'alamat'  => $alamat,
                        'jenis_proyek'  => $jenis_proyek,
                        'nama_perizinan'  => $nama_perizinan,
                        'skala_usaha'  => $skala_usaha,
                        'risiko'  => $risiko,
                        'esselon'  => $esselon,
                        'turunan_kbli'  => $turunan_kbli,
                        'no_dokumen'=>$no_dokumen,
                        'tgl_dokumen'=>$tgl_dokumen,
                        'npwp'=>$npwp,
                        'no_telp'=>$no_telp,
                        'alamat_usaha'=>$alamat_usaha,
                        'kab_usaha'=>$kab_usaha,
                        'status'=>$status,
                        'masaberlakuizin'=>$masaberlakuizin,
                        'created'  => date('Y-m-d H:i:s')


                       
                     );
        $save = $this->db->insert('oss_persetujuanpermohonan', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_data_kirim($id, $esselon, $keterangan_ky, $id_oss) {
        $iduser = $this->session->userdata('id_auth');
        $ossrba = $this->get_dataossrba($id);

        // if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
        //     $approve = 5;
        // } else {
        //     $approve = 1;
        // }

        $data = array(                        
                        'esselon'  => $esselon
                         // 'path '=> $path
                      );
        $this->db->where('id', $id);
        $save = $this->db->update('oss_persetujuanpermohonan', $data);
        if($id_oss != 0){
        $data = array(                        
                        'tg_selesaioss'  => date("Y-m-d H:i:s"),
                        'tg_pengolah' => date("Y-m-d H:i:s"),
                        'id_pengolah' => $iduser,
                        'ket_pengolah' => $keterangan_ky
                         // 'path '=> $path
                      );
        $this->db->where('oss_id', $id);
        $save = $this->db->update('oss_logs', $data);
        }else{
        $data = array(  
                        'oss_id' => $id, 
                        'tg_pengolah' => date("Y-m-d H:i:s"),
                        'id_pengolah' => $iduser,
                        'ket_pengolah' => $keterangan_ky
                     );
        $save = $this->db->insert('oss_logs', $data);
        }
        
        // var_dump($save);die();

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_data_revisi($revisi, $id, $warning) {
        $ossrba = $this->get_dataossrba($id);

        // if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
        //     $approve = 5;
        // } else {
        //     $approve = 1;
        // }

        $data = array(                        
                        'warning'  => $warning,
                        'revisi '=> $revisi
                      );
        $this->db->where('id', $id);
        $save = $this->db->update('oss_persetujuanpermohonan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_data_kirimwarning($id, $warning, $revisi) {
        $ossrba = $this->get_dataossrba($id);

        // if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
        //     $approve = 5;
        // } else {
        //     $approve = 1;
        // }

        $data = array(                        
                        'warning'  => $warning,
                        'revisi '=> $revisi
                      );
        $this->db->where('id', $id);
        $save = $this->db->update('oss_persetujuanpermohonan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_data($tipe_aplikasi, $fiktif_positif, $metode_cari, $id, $nomorpermohonan,$tanggalpermohonan,$nib,$kbli,$sektor,$jenis_perusahaan,$nama_perusahaan,$modal_usaha,$alamat,$jenis_proyek,$nama_perizinan,$skala_usaha,$risiko,$esselon, $turunan_kbli, $no_dokumen, $tgl_dokumen, $npwp, $no_telp, $alamat_usaha, $kab_usaha, $tgl_nib, $status, $masaberlakuizin) {
        $ossrba = $this->get_dataossrba($id);

        // if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
        //     $approve = 5;
        // } else {
        //     $approve = 1;
        // }

        $data = array(
                        'nomorpermohonan'  => $nomorpermohonan,
                        'tanggalpermohonan'  => $tanggalpermohonan,
                         'tipe_aplikasi'  => $tipe_aplikasi,
                        'nib'  => $nib,
                        'fiktif_positif'  => $fiktif_positif,
                        'metode_cari'  => $metode_cari,
                        'tgl_nib'  => $tgl_nib,
                        'kbli'  => $kbli,
                        'sektor'  => $sektor,
                        'jenis_perusahaan'  => $jenis_perusahaan,
                        'nama_perusahaan'  => $nama_perusahaan,
                        'modal_usaha'  => $modal_usaha,
                        'alamat'  => $alamat,
                        'jenis_proyek'  => $jenis_proyek,
                        'nama_perizinan'  => $nama_perizinan,
                        'skala_usaha'  => $skala_usaha,
                        'risiko'  => $risiko,                        
                        'esselon'  => $esselon,
                        'turunan_kbli'  => $turunan_kbli,
                        'no_dokumen'=>$no_dokumen,
                        'tgl_dokumen'=>$tgl_dokumen,
                        'npwp'=>$npwp,
                        'status'=>$status,
                        'no_telp'=>$no_telp,
                        'alamat_usaha'=>$alamat_usaha,
                        'masaberlakuizin'=>$masaberlakuizin,
                        'kab_usaha'=>$kab_usaha

                         // 'path '=> $path
                      
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('oss_persetujuanpermohonan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function get_jenisperusahaan($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Badan Usaha";
                break;
            case '1':
                $data = "Perorangan";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }




     public function get_namaperizinan($nomor) {
        switch ($nomor) {
            case '0':
                $data = "NIB";
                break;
            case '1':
                $data = "Sertifikat Standar";
                break;
            case '2':
                $data = "Izin";
                break;
            case '3':
                $data = "PB-UMKU";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_fiktifpositif($nomor) {
        switch ($nomor) {
            case '0':
                $data = "TIDAK";
                break;
            case '1':
                $data = "YA";
                break;
           
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_status($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Disetujui";
                break;
            case '1':
                $data = "Perbaikan";
                break;
            case '2':
                $data = "Penolakan";
                break;
           
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_statusizin($nomor) {
        switch ($nomor) {
            case '0':
                $data = " - ";
                break;
            case '1':
                $data = "Esselon 4/Ahli Muda";
                break;
            case '4':
                $data = "Esselon 3/Ahli Madya";
                break;
            case '3':
                $data = "Esselon 2";
                break;
            case '2':
                $data = "Selesai Kepala Dinas";
                break;
            case '9':
                $data = "Selesai OSS RBA";
                break;
            case '10':
                $data = "Belum Approve Ess.3 di OSSRBA";
                break;
         
            default:
                $data = " - ";
                break;
        }
        return $data;
    }


     public function get_datapengawasan($id) {
        $surat = $this->db->select('*')
                     ->from('oss_persetujuanpermohonan')
                     ->where('id', $id)
                     ->get()->row();

        return $surat;
    }


    public function get_risiko($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Rendah";
                break;
            case '1':
                $data = "Menengah Rendah";
                break;
            case '2':
                $data = "Menengah Tinggi";
                break;
            case '3':
                $data = "Tinggi";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_n_sektor($id) {
        $data = " - ";
        $sektor = $this->db->select('n_sektor')
                     ->from('trsektor')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($sektor->n_sektor)) {
            $data = $sektor->n_sektor;
        }
        return $data;
    }
    
    public function get_oss_logs($id) {
        $data = 0;
        $oss_logs = $this->db->select('id')
                     ->from('oss_logs')
                     ->where('oss_id', $id)
                     ->get()->row();

        if (!empty($oss_logs->oss_id)) {
            $data = $oss_logs->oss_id;
        }
        return $data;
    }

     public function get_n_tipeapp($id) {
        $data = " - ";
        $sektor = $this->db->select('nama_aplikasi')
                     ->from('oss_tipeaplikasi')
                     ->where('id', $id)
                     ->get()->row();
                     
        if (!empty($sektor->nama_aplikasi)) {
            $data = $sektor->nama_aplikasi;
        }
        return $data;
    }
     public function get_n_sektor2($id) {
        $data = " - ";
        $sektor = $this->db->select('nama_aplikasi')
                     ->from('oss_tipeaplikasi')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($sektor->n_sektor)) {
            $data = $sektor->n_sektor;
        }
        return $data;
    }

    public function get_n_kabupaten($id) {
        $data = " - ";
        $kab = $this->db->select('n_kabupaten')
                     ->from('trkabupaten')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($kab->n_kabupaten)) {
            $data = $kab->n_kabupaten;
        }
        return $data;
    }


public function get_sektor($nomor) {
        switch ($nomor) {
            case '0':
                $data = "PENDIDIKAN";
                break;
            case '1':
                $data = "KESEHATAN";
                break;
            case '2':
                $data = "PEKERJAAN UMUM DAN PENATAAN RUANG";
                break;
            case '3':
                $data = "PERUMAHAN DAN KAWASAN PERMUKIMAN";
                break;         
            case '4':
                $data = "SOSIAL";
                break;
            case '5':
                $data = "TENAGA KERJA";
                break;
            case '6':
                $data = "PERTANAHAN";
                break;
            case '7':
                $data = "LINGKUNGAN HIDUP";
                break;
            case '8':
                $data = "PERHUBUNGAN";
                break;
            case '9':
                $data = "KOPERASI, USAHA KECIL DAN MENENGAH";
                break;
            case '10':
                $data = "PENANAMAN MODAL";
                break;
            case '11':
                $data = "KEBUDAYAAN";
                break;
            case '12':
                $data = "KELAUTAN DAN PERIKANAN";
                break;
            case '13':
                $data = "PARIWISATA";
                break;
            case '14':
                $data = "PERTANIAN";
                break;
            case '15':
                $data = "KEHUTANAN";
                break;
            case '16':
                $data = "ENERGI DAN SUMBER DAYA MINERAL";
                break;
            case '17':
                $data = "PERDAGANGAN";
                break;
            case '18':
                $data = "PERINDUSTRIAN";
                break;



            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function update_penomoran($id, $no_surat, $tgl_surat) {
        $data = array(
                        'nomor_surat' => $no_surat,
                        'tgl_surat' => $tgl_surat,
                        'approve' => 1
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('persuratan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_path($id, $fileBaru) {
        $data = array(
                        'path' => $fileBaru
                     );

        $this->db->where('id', $id);
        $up = $this->db->update('persuratan', $data);

        if ($up) {
            return true;
        } else {
            return false;
        }
    }

    public function ajukan_delete($id) {
    	$data = array('hapus' => 1 );
      $this->db->where('id', $id);
      $save = $this->db->update('persuratan', $data);
      if($save){
        $return = true;
      }else{
        $return = false;
      }
      return $return;
    }
    
    public function delete_ossrba($id) {
       // $up = $this->db->delete('persuratan_log', array('persuratan_id' => $id));

        // if ($up) {
        //     $del = $this->db->delete('persuratan', array('id' => $id));
        //     if ($del) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
        $del = $this->db->delete('oss_persetujuanpermohonan', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function get_dataossrba($id) {
        $ossrba = $this->db->select('*')
                     ->from('oss_persetujuanpermohonan')
                     ->where('id', $id)
                     ->get()->row();

        return $ossrba;
    }
    public function get_datapajakbendahara() {
        $surat = $this->db->select('*')
                     ->from('euis_pajak_bendahara')
                     // ->where('id', $id)
                     ->get()->row();

        return $surat;
    }
    public function get_n_eselon($id) {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
                     ->from('tmpegawai')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function get_id_pegawai($id) {
        $data = " - ";
        $pegawai = $this->db->select('tmpegawai_id')
                     ->from('tmpegawai_user')
                     ->where('user_id', $id)
                     ->get()->row();

        if (!empty($pegawai->tmpegawai_id)) {
            $data = $pegawai->tmpegawai_id;
        }
        return $data;
    }

    public function get_eselon_pegawai($id) {
        $data = " - ";
        $pegawai = $this->db->select('eselon')
                     ->from('tmpegawai')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->eselon)) {
            $data = $pegawai->eselon;
        }
        return $data;
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

    public function get_data_tolak($id) {
        $data = $this->db->select('id')
                     ->from('persuratan_tmpermohonan')
                     ->where('persuratan_id', $id)
                     ->get()->row();

        if (!empty($data->id)) {
            return true;
        } else {
            return false;
        }
    }
}
