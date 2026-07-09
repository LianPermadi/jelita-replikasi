<?php 

class Crud_model extends Model
{

	function __construct(){
		parent::__construct();		
	}

	function create(){
		$this->db->insert("member",array("nama"=>""));
		return $this->db->insert_id();
	}


	function read(){
		$this->db->order_by("id","desc");
		$query=$this->db->get("member");
		return $query->result_array();
	}


	function update($id,$value,$modul){
		$this->db->where(array("id"=>$id));
		$this->db->update("member",array($modul=>$value));
	}

	function delete($id){
		$this->db->where("id",$id);
		$this->db->delete("member");
	}


}