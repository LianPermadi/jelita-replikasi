<?php

class M_izintrayek extends Model
{
		function get_all_izintrayek()
	{
		//$query = $this->db->get('bb_pau');
		//$this->db->select('DISTINCT bb_pau.*',false);
		//$this->db->from('bb_pau');
		//$this->db->join('bb_kodya', 'bb_pau.KODYA_ID_P = bb_kodya.KODYA_ID');
		/*$this->db->join('table3', 'table1.id = table3.id');*/
		//$query = $this->db->get();


 /*$sql = "select  
a.TGL_BAND,
a.JENIS_KP,
c.JENIS,
a.TELAT_TH,
a.TELAT_BL,
a.TARIF_BAND,
a.DENDA_BAND,

c.NO_IK,
b.NAMA_PERUS,
b.ALAMAT_PER,

b.NAMA_PEMIL,
b.ALAMAT_PEM,

a.NO_SK,
a.TG_SK,
a.TG_AKHIR
from bb_pau b 
INNER JOIN bb_kp a
on a.PAU_ID = b.PAU_ID 
INNER JOIN bb_mobil c
on a.KP_ID = c.KP_ID
ORDER BY NO_SK DESC"; 
$sql = "select * from bb_kp";

		
		return $this->db->query($sql);*/
		/*$query = $this->db->get('bb_kp');
		
		*/
		/*$query = $this->db->select('
			bb_kp.PIT_ID,
			bb_kp.NO_SK,
			bb_kp.TGL_BAND,
			bb_kp.JENIS_KP,
			bb_mobil.JENIS,

			bb_mobil.NO_IK,
			bb_pau.NAMA_PERUS,
			bb_pau.ALAMAT_PER,
			')
         ->from('bb_kp')
         ->join('bb_pau', 'bb_pau.PAU_ID = bb_kp.PAU_ID', 'join')
         ->join('bb_mobil', 'bb_mobil.KP_ID = bb_kp.KP_ID', 'join')
         ->order_by('NO_IK', 'ASC')
         //->where($where)
         ->get();
         return $query->result();*/
        $dbmysql2 = $this->load->database('dbakdp',TRUE);
		$query = $dbmysql2->select('*')
         ->from('bb_pit')
         ->order_by('BERLAKU', 'DESC')
         ->get();
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

		//return $this->db->insert_id();
		return $dbmysql2->insert_id();
	}


//----------------------akhir tambah pengusaha
	function input_data($data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->insert($table,$data);
	}
	//----------------------update data
	function edit_data($where,$table){		
	//return $this->db->get_where($table,$where);
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		return $dbmysql2->select('*')
         ->from('bb_pau')
         ->join('bb_kodya', 'bb_pau.KODYA_ID_P = bb_kodya.KODYA_ID', 'join')
         ->where($where)
         ->get();
	}

	function daftar_kendaraan($where){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	/*return $this->db->select('*')
         ->from('bb_kp')
         ->join('bb_pau', 'bb_pau.PAU_ID = bb_kp.PAU_ID', 'join')
        ->where($where)
         ->get();*/
 		/*$sql = "(SELECT (SELECT NAMA_TRAYE FROM bb_traak where KODE_TRAYE = z.KODE_TRAYE) NAMATRAYEK,z.* from (select c.JENIS,a.NO_SK,a.TG_SK,b.NAMA_PERUS,b.ALAMAT_PER,
c.NO_IK,c.NO_MOBIL,c.NO_UJI,c.TAHUN_PEMB,c.MERK,c.DA_ORANG,a.KODE_TRAYE
 from bb_kp a
INNER JOIN bb_pau b 
on a.PAU_ID = b.PAU_ID 
INNER JOIN bb_mobil c 
ON c.KP_ID =  a.KP_ID 
where a.PIT_ID =?)z)";*/

$sql = "
select 
a.PIT_ID
,a.PEMILIK
,a.NO_IP
,a.BERLAKU
,a.KETERANGAN
,ALAMAT_PEM
,a.NO_SK 
,a.TG_SK
,a.NAMA_PERUS
,a.ALAMAT_PER
,b.NO_IK
,b.NO_MOBIL
,b.NO_UJI
,b.TAHUN_PEMB
,b.MERK
,b.DA_ORANG
,b.KP_ID
,b.BBM
,(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID) KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID)) NAMATRAYEK
,(SELECT TG_AKHIR from bb_kp where KP_ID = b.KP_ID) TG_AKHIR
from bb_pit a
inner join bb_mobil b
on a.PIT_ID = b.PIT_ID

where a.PIT_ID =? ORDER BY NO_IK ASC

";
/*$sql = "
select 
a.NO_IK
,a.NO_MOBIL
,a.NO_UJI
,a.TAHUN_PEMB
,a.MERK
,a.DA_ORANG
,a.KP_ID
,a.BBM
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = a.KP_ID)) NAMATRAYEK
,(SELECT TG_AKHIR from bb_kp where KP_ID = a.KP_ID) TG_AKHIR
from 
bb_mobil a


where PIT_ID =? ORDER BY NO_IK ASC

";*/
        return $dbmysql2->query($sql, $where);
	}
function kendaraan($where){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	/*return $this->db->select('*')
         ->from('bb_kp')
         ->join('bb_pau', 'bb_pau.PAU_ID = bb_kp.PAU_ID', 'join')
        ->where($where)
         ->get();*/
 		/*$sql = "(SELECT (SELECT NAMA_TRAYE FROM bb_traak where KODE_TRAYE = z.KODE_TRAYE) NAMATRAYEK,z.* from (select c.JENIS,a.NO_SK,a.TG_SK,b.NAMA_PERUS,b.ALAMAT_PER,
c.NO_IK,c.NO_MOBIL,c.NO_UJI,c.TAHUN_PEMB,c.MERK,c.DA_ORANG,a.KODE_TRAYE
 from bb_kp a
INNER JOIN bb_pau b 
on a.PAU_ID = b.PAU_ID 
INNER JOIN bb_mobil c 
ON c.KP_ID =  a.KP_ID 
where a.PIT_ID =?)z)";*/

/*$sql = "
select 
a.PIT_ID
,a.PEMILIK
,a.NO_IP
,a.BERLAKU
,a.KETERANGAN
,ALAMAT_PEM
,a.NO_SK 
,a.TG_SK
,a.NAMA_PERUS
,a.ALAMAT_PER
,b.NO_IK
,b.NO_MOBIL
,b.NO_UJI
,b.TAHUN_PEMB
,b.MERK
,b.DA_ORANG
,b.KP_ID
,b.BBM
,(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID) KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = b.KP_ID)) NAMATRAYEK
,(SELECT TG_AKHIR from bb_kp where KP_ID = b.KP_ID) TG_AKHIR
from bb_pit a
inner join bb_mobil b
on a.PIT_ID = b.PIT_ID

where a.PIT_ID =? ORDER BY NO_IK ASC

";*/
$sql = "
select 
a.NO_IK
,a.NO_MOBIL
,a.NO_UJI
,a.TAHUN_PEMB
,a.MERK
,a.DA_ORANG
,a.KP_ID
,a.BBM
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE =(SELECT KODE_TRAYE from bb_kp where KP_ID = a.KP_ID)) NAMATRAYEK
,(SELECT TG_AKHIR from bb_kp where KP_ID = a.KP_ID) TG_AKHIR
from 
bb_mobil a


where PIT_ID =? ORDER BY NO_IK ASC

";
        return $dbmysql2->query($sql, $where);
	}
function daftar_kendaraan2($where){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
	
$sql = "
select * from bb_pit
where PIT_ID =?

";
        return $dbmysql2->query($sql, $where);
	}

function editkp_izintrayek($where){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
	/*return $this->db->select('*')
         ->from('bb_kp')
         ->join('bb_pau', 'bb_pau.PAU_ID = bb_kp.PAU_ID', 'join')
        ->where($where)
         ->get();*/
 		/*$sql = "(SELECT DISTINCT (SELECT NAMA_TRAYE FROM bb_traak where KODE_TRAYE = z.KODE_TRAYE) NAMATRAYEK,z.* from (select c.JENIS,a.NO_SK,a.TG_SK,b.NAMA_PERUS,b.ALAMAT_PER,
			c.NO_IK,c.NO_MOBIL,c.NO_UJI,c.TAHUN_PEMB,c.MERK,c.DA_ORANG,a.KODE_TRAYE,b.NAMA_PEMIL,b.ALAMAT_PEM,a.CATATAN,a.HISTORI,a.NOMOR_KP,c.DA_BARANG,c.BBM,c.AC,c.TOILET,c.RCSET,a.SP_KE,a.PELAYANAN,a.TG_KP,a.TG_KPSK,a.TG_MULAI,a.TG_AKHIR,a.EX_NO_MOBI,a.EX_NO_UJI,a.TARIF_BAND,a.DENDA_BAND,a.TELAT_TH,a.TELAT_BL
			 from bb_kp a
			INNER JOIN bb_pau b 
			on a.PAU_ID = b.PAU_ID 
			INNER JOIN bb_mobil c 
			ON c.KP_ID =  a.KP_ID 
			where a.NO_IK =?)z)";*/
			$sql = "(SELECT DISTINCT (SELECT NAMA_TRAYE FROM bb_traak where KODE_TRAYE = z.KODE_TRAYE) NAMATRAYEK,z.* from (select c.JENIS,a.NO_SK,a.TG_SK,a.PIT_ID,a.TRA_ID,
			c.NO_IK,c.NO_MOBIL,c.NO_UJI,c.TAHUN_PEMB,c.MERK,c.DA_ORANG,a.KODE_TRAYE,a.CATATAN,a.HISTORI,a.NOMOR_KP,c.DA_BARANG,c.BBM,c.AC,c.TOILET,c.RCSET,a.SP_KE,a.PELAYANAN,a.TG_KP,a.TG_KPSK,a.TG_MULAI,a.TG_AKHIR,a.EX_NO_MOBI,a.EX_NO_UJI,a.TARIF_BAND,a.DENDA_BAND,a.TELAT_TH,a.TELAT_BL,c.NAMA_STNK,c.ALAMAT_STN,a.JENIS_KP,a.TARIF,a.SP,b.NAMA_PERUS,b.ALAMAT_PER,b.NAMA_PEMIL,b.NO_IP	
			 from bb_kp a
			INNER JOIN bb_mobil c 
			ON c.KP_ID =  a.KP_ID 
			INNER JOIN bb_pau b
on b.PAU_ID = a.PAU_ID
			where a.NO_IK =?)z)";
			/*$sql = "select * from bb_pau where PAU_ID =?";*/
        return $dbmysql2->query($sql, $where);

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

		return $dbmysql2->query($sql, $where2);
	}
	function update_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}	

function update_kp_data($where,$data,$table){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}
function add_kp_datamobil($data,$table){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->insert($table,$data);
	}



function editsp_izintrayek($where){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select 
TGL_BAND
,JENIS_SK
,JENIS_ANGK
,TARIF_BAND
,DENDA_BAND
,TELAT_TH
,TELAT_BL
,NO_IP
,NAMA_PERUS
,ALAMAT_PER
,(SELECT NAMA_KODYA from bb_kodya where KODYA_ID = bb_pit.KODYA_ID ) as KOTA
,KODYA_ID
,PEMILIK
,ALAMAT_PEM
,PIT_ID
	,NO_SK
	,TG_SK
	,BERLAKU
	,NO_SK_LAMA
,TG_SK_LAMA
	from bb_pit
where PIT_ID = ?";
        return $dbmysql2->query($sql, $where);

	}
function daftar_tarif2($PIT_ID){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select 
a.*, $PIT_ID as PIT_ID from bb_tarif a";
        return $dbmysql2->query($sql);

	}
	function daftar_tarif(){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select 
* from bb_tarif ";
        return $dbmysql2->query($sql);

	}
	
	function no_sk($KP_ID){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select 
* from bb_kp where KP_ID = ?";
        return $dbmysql2->query($sql,$KP_ID);

	}
	function no_sk2($PIT_ID){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select a.*, (select DISTINCT PAU_ID from bb_pau where NO_IP = a.NO_IP)as PAU_ID from(select * from bb_pit
where PIT_ID =?)a
";
        return $dbmysql2->query($sql,$PIT_ID);

	}

	function daftar_pengusaha($PAU_ID){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);
			$sql = "select DISTINCT a.*,(select DISTINCT NAMA_KODYA from bb_kodya where KODYA_ID = a.KODYA_ID_P LIMIT 1) as NAMA_KODYA  from (select 
* from bb_pau where PAU_ID = ?			)a";
        return $dbmysql2->query($sql,$PAU_ID);

	}

	function update_sk_data($where,$data,$table){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
	}


//--------------------------------- awal twdp
	function daftar_twdp($where){
	
$dbmysql2 = $this->load->database('dbakdp',TRUE);
$sql = "
select 
a.PAU_ID
,a.KP_ID
,a.TRA_ID
,a.PIT_ID
,a.TPDWP_ID
,b.NAMA_PERUS
,b.ALAMAT_PER
,c.NO_MOBIL
,c.NO_UJI
,c.NOMOR_KP
,c.TG_MULAI
,c.TG_AKHIR
,c.KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE = c.KODE_TRAYE) as NAMA_TRAYE
,c.NO_SK
,c.TG_SK
,TERMINAL_I
,NAMA_TERM3
,a.JARAK
,a.PP1_1
,a.PP1_2
,a.PP2_1
,a.PP2_2
,a.PP3_1
,a.PP3_2
,a.PP4_1
,a.PP4_2
,a.PP5_1
,a.PP5_2
,a.PP6_1
,a.PP6_2

 from 
bb_tp_dwp a
inner join bb_pau b on a.PAU_ID = b.PAU_ID
inner join bb_kp c on a.KP_ID = c.KP_ID
where 
a.KP_ID =?
";
      //  return $this->db->query($sql, $where);
return $dbmysql2->query($sql, $where);

	}

	function edit_twdp($where){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);

			$sql = "
			select 
			*
			from bb_tp_dwp
			where 
			TPDWP_ID =?
			";
        return $dbmysql2->query($sql, $where);
	}
//-------------------------------------SEBELUM DIPECAH
	/*function list_twdp($where){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);

$sql = "
select 
a.KP_ID
,a.PIT_ID
,a.PAU_ID
,a.TRA_ID
,a.TPDWP_ID
,b.NAMA_PERUS
,b.ALAMAT_PER
,c.NO_MOBIL
,c.NO_UJI
,c.NOMOR_KP
,c.TG_MULAI
,c.TG_AKHIR
,c.KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE = c.KODE_TRAYE) as NAMA_TRAYE
,c.NO_SK
,c.TG_SK
,TERMINAL_I
,NAMA_TERM3
,a.JARAK
,a.PP1_1
,a.PP1_2
,a.PP2_1
,a.PP2_2
,a.PP3_1
,a.PP3_2
,a.PP4_1
,a.PP4_2
,a.PP5_1
,a.PP5_2
,a.PP6_1
,a.PP6_2

 from 
bb_tp_dwp a
inner join bb_pau b on a.PAU_ID = b.PAU_ID
inner join bb_kp c on a.KP_ID = c.KP_ID
where 
a.KP_ID = ?
";
        return $dbmysql2->query($sql, $where);
	}*/
		function list_twdp($where){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);

$sql = "
select 
a.KP_ID
,a.PIT_ID
,a.PAU_ID
,a.TRA_ID
,a.TPDWP_ID

,TERMINAL_I
,NAMA_TERM3
,a.JARAK
,a.PP1_1
,a.PP1_2
,a.PP2_1
,a.PP2_2
,a.PP3_1
,a.PP3_2
,a.PP4_1
,a.PP4_2
,a.PP5_1
,a.PP5_2
,a.PP6_1
,a.PP6_2

 from 
bb_tp_dwp a
where 
a.KP_ID = ?
";
        return $dbmysql2->query($sql, $where);
	}
function list_twdp_perus($where){
	$dbmysql2 = $this->load->database('dbakdp',TRUE);

$sql = "
select
c.PIT_ID
,c.KP_ID
,b.PAU_ID 
,c.TRA_ID
,b.NAMA_PERUS
,b.ALAMAT_PER
,c.NO_MOBIL
,c.NO_UJI
,c.NOMOR_KP
,c.TG_MULAI
,c.TG_AKHIR
,c.KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE = c.KODE_TRAYE) as NAMA_TRAYE
,c.NO_SK
,c.TG_SK


 from 
 bb_pau b
inner join bb_kp c on b.PAU_ID = c.PAU_ID
where 
c.KP_ID = ?
";
        return $dbmysql2->query($sql, $where);
	}	
function daftar_twdp_cetakkp($where){
	
$dbmysql2 = $this->load->database('dbakdp',TRUE);
$sql = "
select 
a.TPDWP_ID
,b.NAMA_PERUS
,b.ALAMAT_PER
,c.NO_MOBIL
,c.NO_UJI
,c.NOMOR_KP
,c.TG_MULAI
,c.TG_AKHIR
,c.KODE_TRAYE
,(SELECT NAMA_TRAYE from bb_traak where KODE_TRAYE = c.KODE_TRAYE) as NAMA_TRAYE
,c.NO_SK
,c.TG_SK
,TERMINAL_I
,NAMA_TERM3
,a.JARAK
,a.PP1_1
,a.PP1_2
,a.PP2_1
,a.PP2_2
,a.PP3_1
,a.PP3_2
,a.PP4_1
,a.PP4_2
,a.PP5_1
,a.PP5_2
,a.PP6_1
,a.PP6_2

 from 
bb_tp_dwp a
inner join bb_pau b on a.PAU_ID = b.PAU_ID
inner join bb_kp c on a.KP_ID = c.KP_ID
where 
a.KP_ID =(select KP_ID from bb_kp where NO_IK = ?)
";
        //return $this->db->query($sql, $where);
return $dbmysql2->query($sql, $where);
	}

function update_tpdwp($where,$data,$table,$where2,$where3){
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->where($where);
		$dbmysql2->update($table,$data);
		/*$sql = "UPDATE bb_tp_dwp SET NAMA_TERM3 = '$where3', TERMINAL_I = (SELECT ID from bb_kota where NAMA_KOTA = '$where3') WHERE TPDWP_ID = ?";
		$dbmysql2->query($sql, $where2);*/
	}
	function hapus_datatpdwp($where){
			$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$sql = "DELETE from bb_tp_dwp WHERE TPDWP_ID = ?";
		$dbmysql2->query($sql, $where);
	}
}