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

class M_jdih extends Model {
    public function get_data($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM jdih 
             /*   WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND tipe = 1 */
                ORDER BY  id  DESC";

                //$result = $this->db->query($sql, array($tgla, $tglb))->result();
                 $result = $this->db->query($sql)->result();
        } else {
            $sql = "SELECT * 
                FROM jdih 
                -- WHERE user_id = ? AND tipe = 1
                ORDER BY id DESC";

                $result = $this->db->query($sql, array($iduser))->result();
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
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (DATE(tgl_entry) BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL AND tipe = 1
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }

        return $result;
    }

     public function get_kategori($id) {
        $h;
        $surat = $this->db->select('kategori')
                     ->from('jdih_kategori')
                     ->where('id', $id)
                     ->get();

        foreach ($surat->result() as $data2) {
                $h = $data2->kategori;

              
            }

        return $h;
    }

    public function get_institusi($id) {

   
        $h;
        $surat = $this->db->select('institusi')
                     ->from('jdih_institusi')
                     ->where('id', $id)
                     ->get();

        foreach ($surat->result() as $data2) {
                $h = $data2->institusi;

              
            }

        return $h;
      
    }

     public function get_institusi2() {
         $sql = "SELECT * from jdih_institusi";
        $result = $this->db->query($sql)->result();

        return $result;
    }


     public function get_kategori2() {
        $sql = "SELECT * from jdih_kategori";
        $result = $this->db->query($sql)->result();

        return $result;
    }

     public function get_status($nomor) {
        switch ($nomor) {
            case '0':
                $data = "BERLAKU";
                break;
            case '1':
                $data = "TIDAK BERLAKU";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function getdetail_jdih2($id) {
        $jdih = $this->db->select('*')
                     ->from('jdih')
                     ->where('id', $id)
                     ->get()->row();

        return $jdih;
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

    public function save_data($tentang, $status, $nomor, $tahun, $kategori, $tgl_penetapan, $tgl_pengundangan  , $mencabut, $mengubah, $dirubah, $dicabut, $institusi) {
        $data = array(
                         
                         'tentang'          => $tentang,
                         'status'          => $status,
                         'nomor'          => $nomor,
                         'tahun'          => $tahun,
                         'kategori'          => $kategori,
                         'institusi'          => $institusi,
                         'tgl_penetapan'          => $tgl_penetapan,
                         'mencabut'          => $mencabut,
                         'mengubah'          => $mengubah,
                         'dirubah'          => $dirubah,
                         'dicabut'          => $dicabut,
                         'tgl_pengundangan'          => $tgl_pengundangan


                       
                     );
        $save = $this->db->insert('jdih', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }


    public function update_data($id, $tentang, $status, $nomor, $tahun, $kategori, $tgl_penetapan, $tgl_pengundangan , $mencabut, $mengubah, $dirubah, $dicabut, $institusi) {
        $pajak = $this->get_datajdih($id);

        // if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
        //     $approve = 5;
        // } else {
        //     $approve = 1;
        // }

        $data = array(
                        //'user_id'       => $id_user,
                        'tentang'          => $tentang,
                         'status'          => $status,
                         'nomor'          => $nomor,
                         'tahun'          => $tahun,
                         'kategori'          => $kategori,
                         'institusi'          => $institusi,
                         'tgl_penetapan'          => $tgl_penetapan,
                         'mencabut'          => $mencabut,
                         'mengubah'          => $mengubah,
                         'dirubah'          => $dirubah,
                         'dicabut'          => $dicabut,
                         'tgl_pengundangan'          => $tgl_pengundangan
                      
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('jdih', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
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
    
    public function delete_jdih($id) {
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
        $del = $this->db->delete('jdih', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function get_datajdih($id) {
        $surat = $this->db->select('*')
                     ->from('jdih')
                     ->where('id', $id)
                     ->get()->row();

        return $surat;
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
