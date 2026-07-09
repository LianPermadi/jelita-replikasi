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

class M_super_apps extends Model
{
    public function get_data(){
      $sql = "SELECT * FROM super_apps  
              WHERE status LIKE '1'
              ORDER BY super_apps.no_urut ASC";
      $result = $this->db->query($sql)->result();
      return $result;
    }

    public function get_link($id){
      $data = " - ";
      $apps = $this->db->select('link')
                   ->from('super_apps')
                   ->where('id', $id)
                   ->get()->row();

      if(!empty($apps->link)){
        $data = $apps->link;
      }
      return $data;
    }
    
    public function get_modul($id){
      $data = " - ";
      $apps = $this->db->select('name')
                   ->from('super_apps')
                   ->where('id', $id)
                   ->get()->row();

      if(!empty($apps->name)){
        $data = $apps->name;
      }
      return $data;
    }
    
    public function counterdb($id, $kunjungan, $tanggal, $ipaddress, $id_user)
    {
        // $sql  = "INSERT INTO counter_super_apps (counter, id_apps, date, id_user, ip) 
        //         VALUES ( '$kunjungan', '$id', '$tanggal', '$id_user', '$ipaddress')";
        // $result = $this->db->query($sql)->result();
        // return $result;
        $data = array(
            'counter' => $kunjungan,
            'id_apps' => $id,
            'date' => $tanggal,
            'id_user' => $id_user,
            'ip' => $ipaddress
        );
        $save = $this->db->insert('counter_super_apps', $data);
        // var_dump($save);die();
    }

    public function get_hari_ini()
    {
        $sql = 'SELECT sum(counter) AS hari_ini FROM counter_super_apps WHERE date LIKE "'.date("Y-m-d").'%"';
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_kemarin($kemarin)
    {
        $sql = 'SELECT sum(counter) AS kemarin FROM counter_super_apps WHERE date LIKE "'.$kemarin.'%"';
        $result = $this->db->query($sql)->result();
        return $result;
    }
}
?>