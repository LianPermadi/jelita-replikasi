<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Cviebrock\EloquentSluggable\Sluggable;

class WestJavaSectorManagement_model extends CI_Model {

    protected $table = 'westJavaSectorManagement';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_sector($lang = 'id') {
        $this->db->where('isBahasa', ($lang === 'id' ? 0 : 1));
        $this->db->order_by('title', 'asc');
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

}
