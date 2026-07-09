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
                WHERE (tgl_entry BETWEEN ? AND ?)
                ORDER BY  tgl_surat IS NULL DESC, tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (tgl_entry BETWEEN ? AND ?) AND user_id = ?
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
        return $result;
    }

    public function get_data_cetak($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (tgl_entry BETWEEN ? AND ?) AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM persuratan 
                WHERE (tgl_entry BETWEEN ? AND ?) AND user_id = ? AND revisi <> 1 AND approve <> 5 AND tgl_surat IS NOT NULL
                ORDER BY tgl_entry DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }

        return $result;
    }

    public function get_data_nomor($tgla = NULL, $tglb = NULL) {
        $sql = "SELECT * 
                FROM persuratan 
                WHERE tgl_entry BETWEEN ? AND ? AND revisi <> 1
                ORDER BY tgl_surat IS NULL DESC, tgl_entry DESC";
        $result = $this->db->query($sql, array($tgla, $tglb))->result();

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
                WHERE tmpegawai.id = '3' AND user.lokasi = 'DPMPTSP Prov. Jabar'
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

    public function save_data($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada) {
        $data = array(
                        'user_id'       => $id_user,
                        'ess4'          => $ess4,
                        'ess3'          => $ess3,
                        'sekdis'        => $sekdis,
                        'ess2'          => $ess2,
                        'tgl_entry'     => date('Y-m-d'),
                        'sifat_surat'   => $sifat_surat,
                        'lampiran'      => $lampiran,
                        'hal'           => $hal,
                        'kepada'        => $kepada
                     );
        $save = $this->db->insert('persuratan', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_data($id, $id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada) {
        $surat = $this->get_datasurat($id);

        if (empty($surat->tgl_surat) || empty($surat->nomor_surat)) {
            $approve = 5;
        } else {
            $approve = 1;
        }

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

    public function get_datasurat($id) {
        $surat = $this->db->select('*')
                     ->from('persuratan')
                     ->where('id', $id)
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
}
