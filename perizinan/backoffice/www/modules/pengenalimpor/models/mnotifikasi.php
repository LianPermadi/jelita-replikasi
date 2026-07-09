<?php
class Mnotifikasi extends Model {

    var $tabel = 'api_pesan';

    function __construct() {
        parent::__construct();
    }
	function notif_count() {
        $dbmysql2 = $this->load->database('otherdb',TRUE);
        $dbmysql2->from($this->tabel);
        $dbmysql2->where('status_admin','belum');
        
        //$dbmysql2->where('id_tmpemohon',$id_tmpemohon);
		$query = $dbmysql2->get();
        return $query->num_rows();
	}

    function getnotifikasi() {
         $dbmysql2 = $this->load->database('otherdb',TRUE);
        $dbmysql2->from($this->tabel);
        $dbmysql2->where('status_admin','belum');
        //$dbmysql2->where('id_tmpemohon',$id_tmpemohon);
        $dbmysql2->order_by('id', 'DESC');
        $dbmysql2->limit(10);
        $query = $dbmysql2->get();

        if ($query->num_rows() >0) {
            return $query->result();
        }
    }

    function ginsert($data){
         $dbmysql2 = $this->load->database('otherdb',TRUE);
       $dbmysql2->insert($this->tabel, $data);
       return TRUE;
    }

}
?>