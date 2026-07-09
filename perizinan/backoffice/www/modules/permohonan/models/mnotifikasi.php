<?php
class Mnotifikasi extends Model {

    var $tabel = 'api_pesan';

    function __construct() {
        parent::__construct();
    }
	function notif_count($id_tmpemohon) {
        
        $this->db->from($this->tabel);
        $this->db->where('status','belum');
        $this->db->where('id_tmpemohon',$id_tmpemohon);
		$query = $this->db->get();
        return $query->num_rows();
	}

    function getnotifikasi($id_tmpemohon) {
        $this->db->from($this->tabel);
        $this->db->where('status','belum');
        $this->db->where('id_tmpemohon',$id_tmpemohon);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();

        if ($query->num_rows() >0) {
            return $query->result();
        }
    }

    function ginsert($data){
       $this->db->insert($this->tabel, $data);
       return TRUE;
    }

}
?>