<?php

class M_kendaraan extends Model
{
		function get_all_kendaraan()
	{
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	$dbmysql2->select('*');
		$dbmysql2->from('bb_mobil');
		$query = $dbmysql2->get();
		//SELECT (select NAMA_KODYA from bb_kodya where KODYA_ID= a.KODYA_ID),a.* from bb_terminal a
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
	function edit_data2($where,$table){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);		
	


return $dbmysql2->select('*')
         ->from('bb_traak')
         ->join('bb_kp','bb_traak.KODE_TRAYE = bb_kp.KODE_TRAYE', 'join')
         ->join('bb_pau','bb_kp.PAU_ID = bb_pau.PAU_ID','join')
         ->where($where)
         ->get();

	

	}
	function edit_data3($where){	
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		return $dbmysql2->select('DISTINCT bb_traak.NAMA_TRAYE')
         ->from('bb_traak')
         ->join('bb_kp', 'bb_traak.KODE_TRAYE = bb_kp.KODE_TRAYE', 'join')
         ->where($where)
         ->get();
	
	}




	function update_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}	
	//----------------------akhir update data
}