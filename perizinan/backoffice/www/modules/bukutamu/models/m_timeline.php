<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author Jonas
 * Created : 22 Maret 2021
 *
 */

class M_timeline extends Model {

	public function get_data($tgla = NULL, $tglb = NULL) {
            $sql = "SELECT * 
                FROM euis_calendar order by create_at desc";

                $result = $this->db->query($sql)->result();
        
        return $result;
    }

    public function get_datakegiatan($id) {
        $kegiatan = $this->db->select('*')
                     ->from('euis_calendar')
                     ->where('id', $id)
                     ->get()->row();

        return $kegiatan;
    }
     public function get_namabidang() {
         $sql = "select * from euis_cal_bidang";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function update_data($id, $id_user, $title, $description, $bidang,$namabidang, $start_date, $end_date, $startdate) {
        $timeline = $this->get_datakegiatan($id);

        switch ($namabidang) {
                case '3': //DATIN
                    $warna = "#0071c5";
                    break;
                case '1': //SEKRETARIAT
                    $warna = "#40E0D0";
                    break;
                case '2': //BANGPROM
                    $warna = "#008000";
                    break;
                case '4': //PENGENDALIAN
                    $warna = "#FFD700";
                    break;
                case '5': //ESDA
                    $warna = "#FF8C00";
                    break;
                case '6': //INSOS
                    $warna = "#FF0000";
                    break;
                default:
                    $warna = "";
                    break;
                }
        $data = array(
                       // 'user_id'       => $id_user,
                        'title'          => $title,
                        'description'    => $description,
                        'namabidang'        => $namabidang,
                        'start_date'  => $start_date,
                      //  'startdate'          => $startdate,
                       // 'enddate'          => $enddate,
                        'modified_at'          => $id_user,
                        'color' => $warna,
                        'end_date'   => $end_date,
                        'modified_at'     => date('Y-m-d H:i:s')
                      
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('euis_calendar', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

     public function save_data($id, $id_user, $title, $description, $bidang,$namabidang, $start_date, $end_date, $startdate) {
          switch ($namabidang) {
                case '3': //DATIN
                    $warna = "#0071c5";
                    break;
                case '1': //SEKRETARIAT
                    $warna = "#40E0D0";
                    break;
                case '2': //BANGPROM
                    $warna = "#008000";
                    break;
                case '4': //PENGENDALIAN
                    $warna = "#FFD700";
                    break;
                case '5': //ESDA
                    $warna = "#FF8C00";
                    break;
                case '6': //INSOS
                    $warna = "#FF0000";
                    break;
                default:
                    $warna = "";
                    break;
                }
        $data = array(
                       // 'user_id'       => $id_user,
                        'title'          => $title,
                        'description'    => $description,
                        'namabidang'        => $namabidang,
                        'start_date'  => $start_date,
                        //'startdate'          => $startdate,
                       // 'enddate'          => $enddate,
                         'create_by'          => $id_user,
                        'color' => $warna,
                        'end_date'   => $end_date,
                        'create_at'     => date('Y-m-d H:i:s')
                      
                     );
        $save = $this->db->insert('euis_calendar', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function delete_timeline($id) {
     
            $del = $this->db->delete('euis_calendar', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
        
    }
}
