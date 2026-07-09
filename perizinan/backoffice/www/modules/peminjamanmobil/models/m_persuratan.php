<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 22 Jul 2020
 *
 */

class M_persuratan extends Model {
    public function get_data($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND tipe = 1
                ORDER BY  tgl_surat IS NULL DESC, tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            //$sql = "SELECT * 
            //    FROM persuratan 
            //    WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND tipe = 1
            //    ORDER BY tgl_entry DESC";
            $sql = "SELECT * 
                FROM persuratan 
                WHERE  (DATE(tgl_entry) BETWEEN ? AND ?) AND tipe = 1
                AND user_id = ? AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
               //  var_dump($result);die();
        }
       
        return $result;
    }

    public function get_data_cetak($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            //$sql = "SELECT * 
            //    FROM persuratan 
            //    WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
            //    ORDER BY tgl_entry DESC";
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";
                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        //$sql = "SELECT * 
        //        FROM persuratan 
        //        WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND (user_id = ".$iduser.
		//			                                       " OR ess4 = ".$this->get_ess4().
		//			                                       " OR ess3 = ".$this->get_ess3().
		//			                                       " OR sekdis = ".$this->get_sekdis().
		//			                                       " OR ess2 = ".$$this->get_ess2().") ". 
		//		"AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
          //      ORDER BY tgl_entry DESC";
        //        $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        return $result;
    }

    public function get_data_cetak_excel($tgla = 0, $tglb = 0, $iduser = NULL, $admin = NULL) {
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
            $sql = "SELECT persuratan.*, persuratan_disposisi.id AS id_dis  
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE (DATE(persuratan.tgl_entry) BETWEEN ? AND ?) AND persuratan.tipe = 2
                ORDER BY  persuratan.tgl_surat IS NULL DESC, persuratan.tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT persuratan.*, persuratan_disposisi.id AS id_dis  
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE (DATE(persuratan.tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND persuratan.tipe = 2
                ORDER BY  persuratan.tgl_surat IS NULL DESC, persuratan.tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
        return $result;
    }

    public function get_data_disposisi($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND revisi <> 1 AND approve = 0 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve = 0 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }

        return $result;
    }

    public function get_data_surat_saya($iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT persuratan.*, persuratan_disposisi.id AS id_dis, persuratan_disposisi.tgl_disposisi, persuratan_disposisi.keterangan as ket_dis  
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                INNER JOIN persuratan_disposisi_kepada ON persuratan_disposisi.id = persuratan_disposisi_kepada.disposisi_id 
                INNER JOIN tmpegawai ON persuratan_disposisi_kepada.tmpegawai_id = tmpegawai.id 
                INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
                GROUP BY persuratan.id";

                $result = $this->db->query($sql)->result();
        } else {
            $sql = "SELECT persuratan.* 
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                INNER JOIN persuratan_disposisi_kepada ON persuratan_disposisi.id = persuratan_disposisi_kepada.disposisi_id 
                INNER JOIN tmpegawai ON persuratan_disposisi_kepada.tmpegawai_id = tmpegawai.id 
                INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id 
                WHERE tmpegawai_user.user_id = ? 
                GROUP BY persuratan.id";

                $result = $this->db->query($sql, array($iduser))->result();
        }

        return $result;
    }

    public function get_data_disposisi_done($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT persuratan.* 
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE (DATE(persuratan.tgl_entry) BETWEEN ? AND ?) AND persuratan.revisi <> 1 AND persuratan.approve = 0 AND persuratan.tgl_surat IS NOT NULL AND persuratan.tipe = 1
                ORDER BY persuratan.tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT persuratan.* 
                FROM persuratan 
                INNER JOIN persuratan_disposisi ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE (DATE(persuratan.tgl_entry) BETWEEN ? AND ?) AND persuratan.user_id = ? AND persuratan.revisi <> 1 AND persuratan.approve = 0 AND persuratan.tgl_surat IS NOT NULL AND persuratan.tipe = 1
                ORDER BY persuratan.tgl_entry DESC";

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
        $sekdis = $this->db->select('id_pegawai')
                     ->from('struktural')
                     ->where('id_posisi', 3)
                     ->get()
                     ->row();
        $id_sekdis = $sekdis->id_pegawai;
        // var_dump($id_sekdis);die();
        $sql = "SELECT tmpegawai.id, tmpegawai.n_pegawai, tmpegawai.n_jabatan 
                FROM tmpegawai 
                INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id
                INNER JOIN user ON tmpegawai_user.user_id = user.id
                WHERE tmpegawai.id = '$id_sekdis' AND user.lokasi = 'DPMPTSP Prov. Jabar'
                -- WHERE tmpegawai.eselon = '5' AND user.lokasi = 'DPMPTSP Prov. Jabar'
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

    public function save_data($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $approve, $logo, $tipe, $analis_hukum) {
        $data = array(
                        'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'analis_hukum'  => $analis_hukum,
                        'tgl_entry'     => date('Y-m-d H:i:s'),
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'approve'       => $approve, 
                        'logo_bsre'     => $logo,
                        'tipe'          => $tipe
                     );
        $save = $this->db->insert('persuratan', $data);
        // var_dump($save);die();
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function save_data_pdf($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $approve, $logo, $tipe, $analis_hukum, $format) {
        $data = array(
                        'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'analis_hukum'  => $analis_hukum,
                        'tgl_entry'     => date('Y-m-d H:i:s'),
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'approve'       => $approve, 
                        'logo_bsre'     => $logo,
                        'tipe'          => $tipe,
                        'format_file'   => $format
                     );
        $save = $this->db->insert('persuratan', $data);
        // var_dump($save);die();
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function save_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $approve, $logo, $tipe, $analis_hukum, $idmobil) {
        $data = array(
                        'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'analis_hukum'  => $analis_hukum,
                        'tgl_entry'     => date('Y-m-d H:i:s'),
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'approve'       => $approve, 
                        'logo_bsre'     => $logo,
                        'tipe'          => $tipe,
                        'id_mobil'      => $idmobil
                     );
        $save = $this->db->insert('persuratan', $data);
        // var_dump($save);die();
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $approve, $logo, $tipe, $analis_hukum, $idmobil, $id_surat) {
        $data = array(
                        'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'analis_hukum'  => $analis_hukum,
                        'tgl_entry'     => date('Y-m-d H:i:s'),
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'approve'       => $approve, 
                        'logo_bsre'     => $logo,
                        'tipe'          => $tipe,
                        'id_mobil'      => $idmobil
                     );
        $this->db->where('id', $id_surat);
        $save = $this->db->update('persuratan', $data);
        // var_dump($save);die();
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_disposisi($id_surat, $user_id, $ket) {
        $data = array(
                        'id_surat'          => $id_surat,
                        'user_id'           => $user_id,
                        'tgl_disposisi'     => date('Y-m-d H:i:s'),
                        'keterangan'        => $ket
                     );
        $save = $this->db->insert('persuratan_disposisi', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

     public function save_tim_kepada($surat_id, $tmpegawai_id) {
        $data = array(
                        'surat_id'      => $surat_id,
                        'tmpegawai_id'      => $tmpegawai_id
                     );
        $save = $this->db->insert('keu_tim', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }


    public function save_disposisi_kepada($disposisi_id, $user_id) {
        $data = array(
                        'disposisi_id'      => $disposisi_id,
                        'tmpegawai_id'      => $user_id
                     );
        $save = $this->db->insert('persuratan_disposisi_kepada', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_disposisi_perintah($disposisi_id, $val_perintah_id) {
        $data = array(
                        'disposisi_id'      => $disposisi_id,
                        'val_perintah_id'   => $val_perintah_id
                     );
        $save = $this->db->insert('persuratan_disposisi_perintah', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_data($id, $id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $logo, $analis_hukum) {
        $surat = $this->get_datasurat($id);

        if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
            $approve = 5;
        } else {
            if ($ess4 == "0") {
	        	$approve = 4;
	        } else {
	        	$approve = 1;
	        }
        }

        $data = array(
                        //'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'analis_hukum'  => $analis_hukum,
                        'ess2'          => $ess2,
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'logo_bsre'     => $logo,
                        'approve'       => $approve,
                        'revisi'        => 0
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

    public function update_data_masuk($id, $id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $logo) {
        $surat = $this->get_datasurat($id);

        $data = array(
                        //'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada,
                        'logo_bsre'     => $logo,
                        'revisi'        => 0
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

    public function update_penomoran($id, $no_surat, $tgl_surat) {
    	$ess4 = $this->db->select('ess4')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()
                     ->row()
                     ->ess4;

        $approve = 1;
        if ($ess4 == "0") {
        	$approve = 4;
        }

        $data = array(
                        'nomor_surat' => $no_surat,
                        'tgl_surat' => $tgl_surat,
                        'approve' => $approve
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

    public function update_penomoran_pdf($id, $no_surat, $tgl_surat) {
    	$ess4 = $this->db->select('ess4')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()
                     ->row()
                     ->ess4;
        $ess3 = $this->db->select('ess3')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()
                     ->row()
                     ->ess3;
        $sekdis = $this->db->select('sekdis')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()
                     ->row()
                     ->sekdis;
        $ess2 = $this->db->select('ess2')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()
                     ->row()
                     ->ess2;
        $approve = 1;
        if ($ess4 == "0") {
        	// $approve = 4;
                if($ess3 != 0){
	        	$approve = 4;
                }elseif($sekdis != 0){
	        	$approve = 3;
                }elseif($ess2 != 0){
	        	$approve = 2;
                }else{
	        	$approve = 0;
                }
        }
        // var_dump($approve);die();

        $data = array(
                        'nomor_surat' => $no_surat,
                        'tgl_surat' => $tgl_surat,
                        'approve' => $approve
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('persuratan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }
        // var_dump($return);die();
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

    public function update_ket($id, $ket) {
        $data = array(
                        'keterangan' => $ket
                     );

        $this->db->where('id', $id);
        $up = $this->db->update('persuratan_disposisi', $data);

        if ($up) {
            return true;
        } else {
            return false;
        }
    }

    public function get_kabupaten() {
        $sql = "SELECT * from trkabupaten where kd_prov = '12' ";
        $result = $this->db->query($sql)->result();

        return $result;
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
    
    public function delete_surat($id) {
        $up = $this->db->delete('persuratan_log', array('persuratan_id' => $id));

        if ($up) {
            $del = $this->db->delete('persuratan', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setkepada($id) {
        $del = $this->db->delete('persuratan_disposisi_kepada', array('disposisi_id' => $id));
        if ($del) {
            return true;
        } else {
            return false;
        }
    }

    public function setperintah($id) {
        $del = $this->db->delete('persuratan_disposisi_perintah', array('disposisi_id' => $id));
        if ($del) {
            return true;
        } else {
            return false;
        }
    }

    public function get_datasurat($id) {
        $surat = $this->db->select('*')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()->row();

        return $surat;
    }

    public function get_datadis($id) {
        $surat = $this->db->select('id')
                     ->from('persuratan_disposisi')
                     ->where('id_surat', $id)
                     ->get()->row();

        return $surat;
    }

    public function struktural($id) {
        // 1. Kepala Dinas
        // 2. Sekdis
        // 3. KasubagTU
        // 4. Pengelola Mobil
        // 5. Pengelola Barang
        // 6. Pengelola Barang
        // 7. Pengelola Barang
        $surat = $this->db->select('id_pegawai')
                     ->from('struktural')
                     ->where('id_posisi', $id)
                     ->get()->row();

        if(!empty($surat)) {
            return $surat->id_pegawai;
        } else {
            return 0;
        }
    }

    public function get_ket($id) {
        $surat = $this->db->select('keterangan')
                     ->from('persuratan_disposisi')
                     ->where('id_surat', $id)
                     ->get()
                     ->row()
                     ->keterangan;

        return $surat;
    }

    public function get_disposisi($id) {
        $surat = $this->db->select('*')
                     ->from('persuratan_disposisi')
                     ->where('id_surat', $id)
                     ->get()->row();

        if(!empty($surat)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_id_dis($id) {
        $surat = $this->db->select('id')
                     ->from('persuratan_disposisi')
                     ->where('id_surat', $id)
                     ->get()->row();

        if(!empty($surat)) {
            return $surat->id;
        } else {
            return 0;
        }
    }

    public function get_id_surat_mobil($id) {
        $surat = $this->db->select('id')
                     ->from('persuratan')
                     ->where('id_mobil', $id)
                     ->get()->row();

        if(!empty($surat)) {
            return $surat->id;
        } else {
            return 0;
        }
    }

    public function user_id($id_user) {
        $surat = $this->db->select('tmpegawai_id')
                     ->from('tmpegawai_user')
                     ->where('user_id', $id_user)
                     ->get()->row();

        if(!empty($surat)) {
            return $surat->tmpegawai_id;
        } else {
            return 0;
        }
    }

    public function get_valdisposisi() {
        $surat = $this->db
                      ->get('persuratan_val_perintah')
                      ->result();

        return $surat;
    }

    public function get_kepada($id) {
        $pegawai = $this->db->select('n_pegawai')
                     ->from('tmpegawai')
                     ->join('persuratan_disposisi_kepada', 'tmpegawai.id = persuratan_disposisi_kepada.tmpegawai_id')
                     ->where('persuratan_disposisi_kepada.disposisi_id', $id)
                     ->get()
                     ->result();

        return $pegawai;
    }

    public function get_dis_perintah($id) {
        $perintah = $this->db->select('val_perintah')
                     ->from('persuratan_val_perintah')
                     ->join('persuratan_disposisi_perintah', 'persuratan_val_perintah.id = persuratan_disposisi_perintah.val_perintah_id')
                     ->where('persuratan_disposisi_perintah.disposisi_id', $id)
                     ->get()
                     ->result();

        return $perintah;
    }

    public function get_n_eselon($id) {
        $data = " - ";

        if ($data != "0") {
        	$pegawai = $this->db->select('n_pegawai')
	                     ->from('tmpegawai')
	                     ->where('id', $id)
	                     ->get()->row();

	        if (!empty($pegawai->n_pegawai)) {
	            $data = $pegawai->n_pegawai;
	        }
        }
        
        return $data;
    }

    public function get_id_peminjam($id) {
        $data = " - ";

        if ($data != "0") {
        	$pegawai = $this->db->select('peminjam')
	                     ->from('peminjaman_mobil')
	                     ->where('id', $id)
	                     ->get()->row();

	        if (!empty($pegawai->peminjam)) {
	            $data = $pegawai->peminjam;
	        }
        }
        
        return $data;
    }

    public function get_id_sekdis() {
        $data = " - ";
        $pegawai = $this->db->select('id')
                     ->from('tmpegawai')
                     ->where('id', '1035') //masih manual
                     ->get()->row();

        if (!empty($pegawai->id)) {
            $data = $pegawai->id;
        }
        return $data;
    }

    public function get_id_kadis() {
        $data = " - ";
        $pegawai = $this->db->select('id')
                     ->from('tmpegawai')
                     ->where('id', '89') //masih manual
                     ->get()->row();

        if (!empty($pegawai->id)) {
            $data = $pegawai->id;
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

    public function get_id_user_dis($id) {
        $sql = "SELECT tmpegawai.id 
                FROM tmpegawai 
                INNER JOIN persuratan_disposisi_kepada ON tmpegawai.id = persuratan_disposisi_kepada.tmpegawai_id 
                INNER JOIN persuratan_disposisi ON persuratan_disposisi.id = persuratan_disposisi_kepada.disposisi_id
                INNER JOIN persuratan ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE persuratan_disposisi.id_surat = ? 
                ORDER BY tmpegawai.n_pegawai";
        $result = $this->db->query($sql, array($id))->result();

        return $result;
    }

    public function get_id_val_dis($id, $idval) {
        $sql = "SELECT persuratan_disposisi_perintah.id  
                FROM persuratan_disposisi_perintah 
                INNER JOIN persuratan_disposisi ON persuratan_disposisi.id = persuratan_disposisi_perintah.disposisi_id 
                INNER JOIN persuratan ON persuratan.id = persuratan_disposisi.id_surat 
                WHERE persuratan_disposisi.id_surat = ? AND persuratan_disposisi_perintah.val_perintah_id = ?";
        $result = $this->db->query($sql, array($id, $idval))->first_row();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_tolak($id) {
        $data = $this->db->select('id')
                     ->from('persuratan_tmpermohonan')
                     ->where('persuratan_id', $id)
                     ->where('tipe', 0)
                     ->get()->row();

        if (!empty($data->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_cabut($id) {
        $data = $this->db->select('id')
                     ->from('persuratan_tmpermohonan')
                     ->where('persuratan_id', $id)
                     ->where('tipe', 1)
                     ->get()->row();

        if (!empty($data->id)) {
            return true;
        } else {
            return false;
        }
    }

    // peminjaman mobil

        
    public function get_idmobil($id)
    {
        $data = " - ";
        $idmobil = $this->db->select('id_mobil')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($idmobil->id_mobil)) {
            $data = $idmobil->id_mobil;
        }
        return $data;
    }

    public function get_idpeminjam_mobil($id)
    {
        $data = " - ";
        $idmobil = $this->db->select('peminjam')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($idmobil->peminjam)) {
            $data = $idmobil->peminjam;
        }
        return $data;
    }

    public function get_peminjam_mobil($id)
    {
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

    public function get_jabatan_mobil($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_jabatan')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_jabatan)) {
            $data = $pegawai->n_jabatan;
        }
        return $data;
    }

    public function get_nip_mobil($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('nip')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->nip)) {
            $data = $pegawai->nip;
        }
        return $data;
    }

    public function get_trunitkerja($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_unitkerja')
            ->from('trunitkerja')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_unitkerja)) {
            $data = $pegawai->n_unitkerja;
        }
        return $data;
    }

    public function get_nama_unit($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('unitkerja_id')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->unitkerja_id)) {
            $data = $pegawai->unitkerja_id;
        }
        return $data;
    }

    public function get_platnomor_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('plat')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->plat)) {
            $data = $mobil->plat;
        }
        return $data;
    }

    public function tanggal_pinjam($id)
    {
        $data = " - ";
        $mobil = $this->db->select('tanggal_pinjam')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->tanggal_pinjam)) {
            $data = $mobil->tanggal_pinjam;
        }
        return $data;
    }

    public function tanggal_kembali($id)
    {
        $data = " - ";
        $mobil = $this->db->select('tanggal_kembali')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->tanggal_kembali)) {
            $data = $mobil->tanggal_kembali;
        }
        return $data;
    }

    public function tujuan($id)
    {
        $data = " - ";
        $mobil = $this->db->select('tujuan')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->tujuan)) {
            $data = $mobil->tujuan;
        }
        return $data;
    }

    public function get_mobil_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('mobil')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->mobil)) {
            $data = $mobil->mobil;
        }
        return $data;
    }

    public function get_driver_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('driver')
            ->from('peminjaman_mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->driver)) {
            $data = $mobil->driver;
        }
        return $data;
    }

    public function id_pihak_satu($id)
    {
        $data = " - ";
        $mobil = $this->db->select('ess3')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->ess3)) {
            $data = $mobil->ess3;
        }
        return $data;
    }

    public function id_pihak_dua($id)
    {
        $data = " - ";
        $mobil = $this->db->select('ess4')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->ess4)) {
            $data = $mobil->ess4;
        }
        return $data;
    }

    public function nip_pihak_satu($id)
    {
        $data = " - ";
        $mobil = $this->db->select('nip')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->nip)) {
            $data = $mobil->nip;
        }
        return $data;
    }

}
