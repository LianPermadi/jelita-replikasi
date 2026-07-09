
<?php

class M_jenisizin extends Model
{
function get_all_jenisizin()
	{
		$query = $this->db->select('*')
         ->from('trperizinan')
		 ->where('c_aktif' ,"0")
         ->get();
         return $query->result();
	}
	function get_detail_syarat($where)
	{
	$sql = "
select a.v_syarat , c.n_perizinan , a.id,a.formulir,a.nama_formulir
from trsyarat_perizinan a
INNER JOIN trperizinan_trsyarat_perizinan b
on a.id = b.trsyarat_perizinan_id 
INNER JOIN trperizinan c
on c.id = b.trperizinan_id
where b.trperizinan_id=?
";
        return $this->db->query($sql, $where);
	}
}
?>
