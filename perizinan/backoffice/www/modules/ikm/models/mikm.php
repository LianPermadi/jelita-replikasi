<?php
class Mikm extends Model{
function tambah(){

//$id = $this->input->post('id');
$semester = $this->input->post('semester');
$tahun = $this->input->post('tahun');
$sektor_id = $this->input->post('sektor_id');
$u1 = $this->input->post('u1');
$u2 = $this->input->post('u2');
$u3 = $this->input->post('u3');
$u4 = $this->input->post('u4');
$u5 = $this->input->post('u5');
$u6 = $this->input->post('u6');
$u7 = $this->input->post('u7');
$u8 = $this->input->post('u8');
$u9 = $this->input->post('u9');
$u10 = $this->input->post('u10');
$u11 = $this->input->post('u11');
$u12 = $this->input->post('u12');
$u13 = $this->input->post('u13');
$u14 = $this->input->post('u14');

$data = array 
(//'id'=>$id,
'semester'=>$semester,
'tahun'=>$tahun,
'sektor_id'=>$sektor_id,
'u1'=>$u1,
'u2'=>$u2,
'u3'=>$u3,
'u4'=>$u4,
'u5'=>$u5,
'u6'=>$u6,
'u7'=>$u7,
'u8'=>$u8,
'u9'=>$u9,
'u10'=>$u10,
'u11'=>$u11,
'u12'=>$u12,
'u13'=>$u13,
'u14'=>$u14
);

$this->db->insert('tmikmnilai',$data);
}

function ambildata(){

//$ambildata=$this->db->get('tmikmnilai');
$ambildata=$this->db->query("select * from tmikmnilai order by tahun desc");

if($ambildata->num_rows() > 0){
foreach($ambildata->result() as $data){
$hasilikm[] = $data;
}
return $hasilikm;
}
}
function update($id){
$semester = $this->input->post('semester');
$tahun = $this->input->post('tahun');
$sektor_id = $this->input->post('sektor_id');
$u1 = $this->input->post('u1');
$u2 = $this->input->post('u2');
$u3 = $this->input->post('u3');
$u4 = $this->input->post('u4');
$u5 = $this->input->post('u5');
$u6 = $this->input->post('u6');
$u7 = $this->input->post('u7');
$u8 = $this->input->post('u8');
$u9 = $this->input->post('u9');
$u10 = $this->input->post('u10');
$u11 = $this->input->post('u11');
$u12 = $this->input->post('u12');
$u13 = $this->input->post('u13');
$u14 = $this->input->post('u14');

$data = array 
(//'id'=>$id,
'semester'=>$semester,
'tahun'=>$tahun,
'sektor_id'=>$sektor_id,
'u1'=>$u1,
'u2'=>$u2,
'u3'=>$u3,
'u4'=>$u4,
'u5'=>$u5,
'u6'=>$u6,
'u7'=>$u7,
'u8'=>$u8,
'u9'=>$u9,
'u10'=>$u10,
'u11'=>$u11,
'u12'=>$u12,
'u13'=>$u13,
'u14'=>$u14
);
$this->db->where('id',$id);
$this->db->update('tmikmnilai',$data);
}
function select($id){
return $this->db->get_where('tmikmnilai',array('id'=>$id))->row();
}
//function hapus($id){
//$this->db->delete('tmikmnilai',array('id'=>$id));
//}
}
?>
