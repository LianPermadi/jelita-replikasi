<?php 

class M_daftar_standar_pelayanan extends Model{
	
  function __construct() {
    parent::__construct();
  }
  
  function get_kategori(){
    return $this->db->query("SELECT * FROM `daftar_standar_pelayanan`")->result();
  }
}
?>