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

class M_petugas extends Model {
    public function get_pegawai($id) {
        $sql = "SELECT * FROM tmpegawai WHERE id = '$id' LIMIT 1";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}
