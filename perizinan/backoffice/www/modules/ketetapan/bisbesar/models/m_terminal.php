<?php

class M_terminal extends Model
{
		function get_all_terminal()
	{

		//$query = $this->db->get('bb_terminal');
		//$this->db->select('DISTINCT bb_pau.*',false);
		//$this->db->from('bb_pau');
		//$this->db->join('bb_kodya', 'bb_pau.KODYA_ID_P = bb_kodya.KODYA_ID');
		/*$this->db->join('table3', 'table1.id = table3.id');*/
		//$query = $this->db->get();
		//$this->db->select('(select NAMA_KODYA from bb_kodya where KODYA_ID= a.KODYA_ID) as KOTA,a.*');
	


		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$query = $dbmysql2->get('bb_terminal');

		return $query->result();
	}

	//-----------------------------input data
	function input_data($data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->insert($table,$data);
	}
	//----------------------------akhir input data

	//----------------------update data
	function edit_data($where,$table){		
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	return $dbmysql2->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}	
	//----------------------akhir update data
}