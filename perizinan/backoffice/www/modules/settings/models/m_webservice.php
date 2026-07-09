<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 31 Aug 2021
 *
 */

class M_webservice extends Model {
    public function get_data($tgla = NULL, $tglb = NULL) {
            $sql = "SELECT * 
                FROM log_esign 
                WHERE (DATE(tgl_ttd) BETWEEN ? AND ?) 
                ORDER BY tgl_ttd DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        
        return $result;
    }

    public function get_detail($id) {
        $detail = $this->db->select('*')
                     ->from('log_esign')
                     ->where('id', $id)
                     ->get()->row();

        return $detail;
    }

    public function get_namauser($nik) {
        $pegawai = $this->db->select('n_pegawai')
                     ->from('tmpegawai')
                     ->where('nik', $nik)
                     ->get()->row();

        if(!empty($pegawai)) {
            return $pegawai->n_pegawai;
        } else {
            return " - ";
        }
    }


}
