<?php

class M_pengusaha extends Model
{
		function get_all_pau()
	{
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$query = $dbmysql2->get('bb_pau');

		return $query->result();
	}

//----------------------tambah pengusaha
	function get_active_kodya()
	{
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->select('DISTINCT *',false);
		$dbmysql2->from('bb_kodya');
		//$this->db->where('book_genreactive',1);
		$dbmysql2->order_by('NAMA_KODYA','ASC');
		$query = $dbmysql2->get();

		return $query->result();
	}

	function post_pengusaha()
	{
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->insert('bb_pau', $this->input->post());

		return $this->db->insert_id();
	}


//----------------------akhir tambah pengusaha
	function input_data($data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->insert($table,$data);
	}
	//----------------------update data
	function edit_data($where,$table){	
	$dbmysql2 = $this->load->database('dbakdp',TRUE);	
	//return $this->db->get_where($table,$where);
		return $dbmysql2->select('*')
         ->from('bb_pau')
         ->join('bb_kodya', 'bb_pau.KODYA_ID_P = bb_kodya.KODYA_ID', 'join')
         ->where($where)
         ->get();
	}

	function daftar_kendaraan($where2,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	

        $sql = "select a.NOMOR_KP,a.TG_AKHIR,a.NO_MOBIL,a.NO_UJI,c.TAHUN_PEMB,c.DA_ORANG,a.STATUS,a.KODE_TRAYE,b.NAMA_TRAYE
				from bb_kp a
				inner join bb_traak b on a.KODE_TRAYE = b.KODE_TRAYE
				inner join bb_mobil c on a.NO_MOBIL = c.NO_MOBIL
				where 
				a.PAU_ID = (select DISTINCT PAU_ID From bb_pau WHERE NO_IP=?)"; 

		return $dbmysql2->query($sql, $where2);
	}

	function rekap_trayek_pengusaha($where2,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
        $sql = "select x.*,count(NO_MOBIL) as BIS, 
CASE WHEN STATUS <> 'AKTIF' THEN COUNT(STATUS) ELSE 0 END AS KP_HABIS,
CASE WHEN STATUS = 'AKTIF' THEN COUNT(STATUS) ELSE 0 END AS KP_BERLAKU
from(
select DISTINCT a.NAMA_PERUS,a.NAMA_PEMIL,a.ALAMAT_PER,b.KODE_TRAYE,c.NAMA_TRAYE,NO_MOBIL ,B.STATUS
from bb_pau a
inner join bb_kp b on a.PAU_ID = b.PAU_ID
inner join bb_traak c on b.KODE_TRAYE = c.KODE_TRAYE 
WHERE NO_IP=?
) x
GROUP BY KODE_TRAYE"; 

		//return $this->db->query($sql, $where2);
return $dbmysql2->query($sql, $where2);
	}

	function update_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}	
}