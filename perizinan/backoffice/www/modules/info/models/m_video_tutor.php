<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author DPMPTSP
 * Created : 22 Jul 2023
 *
 */

class M_video_tutor extends Model
{
    public function get_data($kat=null){
    	if($kat == null){
        $sql = "SELECT * FROM mobil  
                ORDER BY mobil.status DESC";
      }else{
      	$sql = "SELECT * FROM mobil WHERE kategori = '".$kat."' ORDER BY mobil.status DESC";
      }
      $result = $this->db->query($sql)->result();
      return $result;
    }

    public function get_user_id($id_user)
    {
        $jumlah = $this->db->select('tmpegawai_id')
            ->from('tmpegawai_user')
            ->where('user_id', $id_user)
            ->get()->row();

        if (!empty($jumlah->tmpegawai_id)) {
            $data = $jumlah->tmpegawai_id;
        return $data;
        }
    }
    public function insert_video($data) {
        return $this->db->insert('tb_video_tutorials', $data);
    }

    // Mendapatkan semua video dari database
    public function get_all_videos() {
        $query = $this->db->get_where('tb_video_tutorials', array('status' => 1));
        return $query->result_array();
    }
    public function get_all_videos_list() {
        $query = $this->db->get('tb_video_tutorials');
        return $query->result_array();
    }
    
    // Mendapatkan video berdasarkan ID
    public function get_video_by_id($id) {
        $query = $this->db->get_where('tb_video_tutorials', array('id' => $id));
        return $query->row_array();
    }

    public function update_video($id, $data) {
        // var_dump($id, $data);die();
    
        // Menambahkan nama tabel di depan kolom
        $this->db->where('tb_video_tutorials.id', $id);
        return $this->db->update('tb_video_tutorials', $data);
    }

    // Menghapus video berdasarkan ID
    public function delete_video($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tb_video_tutorials');
    }
}


