<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investasi_model extends CI_Model {

    protected $table = 'investasi';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_investasi($lang = 'id', $sector = null) {
        $this->db->select('investasi.*, sector.*');
        $this->db->from('investasi');
        $this->db->join('westjavasectormanagement AS sector', 'investasi.fk_sector = sector.id', 'left');
        // $this->db->where('investasi.isBahasa', ($lang === 'id' ? 0 : 1));
        
        // Kondisi untuk sektor
        if ($sector !== null) {
            $this->db->where('investasi.fk_sector', $sector);
        }
    
        // Kondisi untuk status
        $this->db->where('investasi.status_content', 1);
    
        $this->db->order_by('investasi.judul_investasi', 'asc');
        $query = $this->db->get();
    
        return $query->result_array();
    }
    
    public function get_investasi_with_sector($id)
    {
        // Get investasi data by ID with sector
        $this->db->select('investasi.*');
        $this->db->from('investasi');
        $this->db->where('investasi.invest_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_investasi_by_id($id) {
        return $this->db->get_where('investasi', array('invest_id' => $id))->row();
    }

    public function record_view($id) {
        $this->db->set('viewable_id', 'viewable_id+1', FALSE);
        $this->db->where('viewable_id', $id); // Assuming 'viewable_id' is the column name in the 'views' table
        $this->db->update('views'); // Update the 'views' table
    }

    public function get_investasi_paginated($lang = 'id', $sector = null, $limit = 9, $offset = 0) {
        $this->db->select('
            investasi.*, 
            sector.id,
            sector.title,
            sector.headline,
            sector.content,
            sector.isActive,
            sector.isBahasa,
            sector.users_id,
            sector.slug,
            sector.created_at,
            sector.updated_at
        ');
        $this->db->from('investasi');
        $this->db->join('westjavasectormanagement AS sector', 'investasi.fk_sector = sector.id', 'left');
    
        // ✅ Pastikan perbandingan $lang bukan array!
        $isBahasa = ($lang === 'id') ? 0 : 1;
        $this->db->where('investasi.isBahasa', $isBahasa);
        $this->db->where('investasi.status_content', 1);
    
        if (!is_null($sector)) {
            $this->db->where('investasi.fk_sector', $sector);
        }
    
        $this->db->order_by('investasi.judul_investasi', 'asc');
        $this->db->limit($limit, $offset);
    
        // Debug bantu cek query
        // echo $this->db->get_compiled_select(); die;
    
        $query = $this->db->get();
        return $query->result_array();
    }

    // public function get_investasi_paginated() {
    //     $sql = "
    //         SELECT 
    //             investasi.*, 
    //             sector.id,
    //             sector.title,
    //             sector.headline,
    //             sector.content,
    //             sector.isActive,
    //             sector.isBahasa,
    //             sector.users_id,
    //             sector.slug,
    //             sector.created_at,
    //             sector.updated_at
    //         FROM investasi
    //         LEFT JOIN westjavasectormanagement AS sector 
    //             ON investasi.fk_sector = sector.id
    //         WHERE investasi.isBahasa = 0 
    //           AND investasi.status_content = 1
    //           AND investasi.fk_sector = 3
    //         ORDER BY investasi.judul_investasi ASC
    //         LIMIT 9 OFFSET 0
    //     ";
    
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }
}
