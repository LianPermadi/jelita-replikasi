<?php

class M_lintasan extends Model
{
		function get_all_lintasan()
	{

		//$query = $this->db->get('bb_traak');

		$dbmysql2 = $this->load->database('dbakdp',TRUE);
 		$query = $dbmysql2->get('bb_traak');
		
		return $query->result();
	}
function get_all_lintasan2()
	{
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$query = $dbmysql2->get('bb_traakdet');
		
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

	function create_traakdet($where2,$table){	
	$dbmysql2 = $this->load->database('dbakdp',TRUE);	
		return $dbmysql2->select('*')
         ->from('bb_traak')
         ->join('bb_traakdet', 'bb_traak.TRA_ID = bb_traakdet.TRA_ID', 'join')
         ->where($where2)
         ->get();
	}

	function update_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}	
	//----------------------akhir update data
}