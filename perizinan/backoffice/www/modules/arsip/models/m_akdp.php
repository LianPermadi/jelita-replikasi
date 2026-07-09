<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pencabutan Model
 *
 * @author dpmptsp
 * Created : 25 Mar 2022
 *
 */

class M_akdp extends Model {
  function get_stat_sk($resi) {
    $return = 0;
    $db = $this->load->database('db_bb',TRUE);
    $sql = "SELECT count(*) as itung
            FROM bb_counter
            WHERE resi = ? AND tipe = 1";
    $result = $db->query($sql, array($resi));
    $row = $result->row();
    if(!empty($row->itung)){
    	$return = $row->itung;
    }
    return $return;
  }
  
  function get_stat_kp($resi) {
    $return = 0;
    $db = $this->load->database('db_bb',TRUE);
    $sql = "SELECT count(*) as itung
    		    FROM bb_counter
    		    WHERE resi = ? AND tipe = 2";
    $result = $db->query($sql, array($resi));
    $row = $result->row();
    if (!empty($row->itung)) {
      $return = $row->itung;
    }
    return $return;
  }
  
  function get_data_sk($resi) {
    $db = $this->load->database('db_bb',TRUE);
    $sql = "SELECT user_id FROM bb_counter
    		    WHERE resi = ? AND tipe = 1";
    $result = $db->query($sql, array($resi))->result();
    return $result;
  }
  
  function get_data_kp($resi) {
    $db = $this->load->database('db_bb',TRUE);
    $sql = "SELECT user_id FROM bb_counter
    		    WHERE resi = ? AND tipe = 2";
    $result = $db->query($sql, array($resi))->result();
    return $result;
  }
}
