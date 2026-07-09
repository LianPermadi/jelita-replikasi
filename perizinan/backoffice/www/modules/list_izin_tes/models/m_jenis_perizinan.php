<?php

class M_jenis_perizinan extends Model
{
		function get_all_jenis_perizinan()
	{
	$this->db->select('*');
		$this->db->from('trperizinan');
		$query = $this->db->get();
		return $query->result();
	}

	//-----------------------------input data
	function input_data($data,$table){
		$this->db->insert($table,$data);
	}
	//----------------------------akhir input data

	//----------------------update data
	function edit_data($where,$table){		
	return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}	
	//----------------------akhir update data
}