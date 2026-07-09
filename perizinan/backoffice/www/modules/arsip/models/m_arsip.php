<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Model Arsip class
 * @author PBS
 * Created : 05 Jan 2023
 */

class M_arsip extends Model {
  
  public function get_pegawai($id) {
    $data = " - ";
    $ruangan = $this->db->select('oriname')
                    ->from('user')
                    ->where('id', $id)
                    ->get()->row();
    if(!empty($ruangan->oriname)) {
      $data = $ruangan->oriname;
    }
    return $data;
  }
}
