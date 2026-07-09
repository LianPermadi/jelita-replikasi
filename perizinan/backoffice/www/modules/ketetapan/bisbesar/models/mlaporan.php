<?php
class Mlaporan extends Model {
 
    var $tabel = 'tb_barang';
 
    function __construct() {
        parent::__construct();
    }
    function getAllItem() {
        $this->db->from($this->tabel);
        $query = $this->db->get();
        return $query->result();
    }
 
}
?>