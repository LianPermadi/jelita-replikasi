<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of monitoring class
 *
 * @author  Royan Sastramanggala
 * @since   2014
 *
 */
 class Mpengaduantriwulan extends Model
 {
	function gettriwulan(){
	 $thn=$this->input->post('tgla');
	$sql="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'01' and '03' ";
			$ambil = $this->db->query("$sql");

			if($ambil->num_rows() > 0)
			{
			foreach($ambil->result() as $baris)
				{
			$hasil[] = $baris;
				}
			return $hasil;
			}
	}
  
  function gettriwulan2(){
	 $thn=$this->input->post('tgla');
	$sql2="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'01' and '03' and c_tindak_lanjut='Ya'";
			$ambil2 = $this->db->query("$sql2");

			if($ambil2->num_rows() > 0)
			{
			foreach($ambil2->result() as $baris2)
				{
			$hasil2[] = $baris2;
				}
			return $hasil2;
			}
	}
	function gettriwulan3(){
	 $thn=$this->input->post('tgla');
	$sql3="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'04' and '06' ";
			$ambil3 = $this->db->query("$sql3");

			if($ambil3->num_rows() > 0)
			{
			foreach($ambil3->result() as $baris3)
				{
			$hasil3[] = $baris3;
				}
			return $hasil3;
			}
	}
	function gettriwulan4(){
	 $thn=$this->input->post('tgla');
	$sql4="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'04' and '06' and c_tindak_lanjut='Ya'";
			$ambil4= $this->db->query("$sql4");

			if($ambil4->num_rows() > 0)
			{
			foreach($ambil4->result() as $baris4)
				{
			$hasil4[] = $baris4;
				}
			return $hasil4;
			}
	}
	
	function gettriwulan5(){
	 $thn=$this->input->post('tgla');
	$sql5="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'07' and '09'";
			$ambil5= $this->db->query("$sql5");

			if($ambil5->num_rows() > 0)
			{
			foreach($ambil5->result() as $baris5)
				{
			$hasil5[] = $baris5;
				}
			return $hasil5;
			}
	}
	function gettriwulan6(){
	 $thn=$this->input->post('tgla');
	$sql6="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'07' and '09' and c_tindak_lanjut='Ya'";
			$ambil6= $this->db->query("$sql6");

			if($ambil6->num_rows() > 0)
			{
			foreach($ambil6->result() as $baris6)
				{
			$hasil6[] = $baris6;
				}
			return $hasil6;
			}
	}
	function gettriwulan7(){
	 $thn=$this->input->post('tgla');
	$sql7="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'10' and '12' ";
			$ambil7= $this->db->query("$sql7");

			if($ambil7->num_rows() > 0)
			{
			foreach($ambil7->result() as $baris7)
				{
			$hasil7[] = $baris7;
				}
			return $hasil7;
			}
	}
	function gettriwulan8(){
	 $thn=$this->input->post('tgla');
	$sql8="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'10' and '12' and c_tindak_lanjut='Ya'";
			$ambil8= $this->db->query("$sql8");

			if($ambil8->num_rows() > 0)
			{
			foreach($ambil8->result() as $baris8)
				{
			$hasil8[] = $baris8;
				}
			return $hasil8;
			}
	}
	function getdata_ketenagakerjaan(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);
  
			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'RENCANA PENEMPATAN TENAGA KERJA ASING (RPTKA)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil = $this->db->query("$sql2");

			if($ambil->num_rows() > 0)
			{
			foreach($ambil->result() as $baris)
				{
			$hasil[] = $baris;
				}
			return $hasil;
			}
  }
  
	function getdata_ketenagakerjaan2(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);
	
			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'IZIN MEMPEKERJAKAN TENAGA ASING (IMTA)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil2 = $this->db->query("$sql2");
  
			if($ambil2->num_rows() > 0)
			{
			foreach($ambil2->result() as $baris2)
				{
			$hasil2[] = $baris2;
				}
			return $hasil2;
			}
  }
  
	function getdata_ketenagakerjaan3(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);
			
			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'PENDIRIAN KANTOR CABANG PELAKSANA PENEMPATAN TENAGA KERJA INDONESIA SWASTA (PPTKIS)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil3 = $this->db->query("$sql2");
  
			if($ambil3->num_rows() > 0)
			{
			foreach($ambil3->result() as $baris3)
				{
			$hasil3[] = $baris3;
				}
			return $hasil3;
			}
  }
  
  function getdata_ketenagakerjaan4(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);

			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'PENDIRIAN LEMBAGA PENEMPATAN  TENAGA KERJA SWASTA ANTAR KERJA LOKAL (LPTKS AKL )' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil4 = $this->db->query("$sql2");
  
			if($ambil4->num_rows() > 0)
			{
			foreach($ambil4->result() as $baris4)
			{
			$hasil4[] = $baris4;
			}
			return $hasil4;
			}
   }
   
   function getdata_ketenagakerjaan5(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);
	
			$sql=$this->sql();
			$sql2="$sql WHERE t3.n_perizinan = 'REKOMENDASI PENGERAHAN TENAGA KERJA  ANTAR KERJA ANTAR DAERAH (RPTK-AKAD)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil5 = $this->db->query("$sql2");
					
			if($ambil5->num_rows() > 0)
			{
			foreach($ambil5->result() as $baris5)
				{
			$hasil5[] = $baris5;
				}
			return $hasil5;
				}
			}
  function getdata_ketenagakerjaan6(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);

			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'IZIN TEMPAT PENAMPUNGAN CALON  TENAGA KERJA INDONESIA' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil6 = $this->db->query("$sql2");
  
			if($ambil6->num_rows() > 0)
			{
			foreach($ambil6->result() as $baris6)
			{
			$hasil6[] = $baris6;
			}
			return $hasil6;
			}
   }
   function getdata_ketenagakerjaan7(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);

			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'REKOMENDASI PENDIRIAN LEMBAGA PENEMPATAN TENAGA KERJA SWASTA  ANTAR KERJA ANTAR DAERAH  (LPTKS AKAD)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil7 = $this->db->query("$sql2");	
  
			if($ambil7->num_rows() > 0)
			{
			foreach($ambil7->result() as $baris7)
				{
			$hasil7[] = $baris7;
				}
			return $hasil7;
			}
   }
   
   function getdata_ketenagakerjaan8(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);

			$sql=$this->sql();
			$sql2="$sql 
					WHERE t3.n_perizinan = 'REKOMENDASI PENGERAHAN TENAGA KERJA  ANTAR KERJA ANTAR DAERAH (RPTK-AKAD)' 
					and t1.d_terima_berkas>='$date' and t1.d_terima_berkas<= '$date2'";
			$ambil8 = $this->db->query("$sql2");
  
			if($ambil8->num_rows() > 0)
			{
			foreach($ambil8->result() as $baris8)
			{
			$hasil8[] = $baris8;
			}
			return $hasil8;
			}
   }
    function getdata_ketenagakerjaan9(){
			$date=$this->input->post('first_date',TRUE);
			$date2=$this->input->post('second_date',TRUE);

			$sql=$this->sql();
			$sql2="$sql 
					WHERE (t3.n_perizinan = 'RENCANA PENEMPATAN TENAGA KERJA ASING (RPTKA)'  and
					t1.d_terima_berkas<= '$date2' and t1.d_terima_berkas>='$date')
					or 
					(t3.n_perizinan ='IZIN MEMPEKERJAKAN TENAGA ASING (IMTA)'  and
t1.d_terima_berkas<= '$date2' and t1.d_terima_berkas>='$date')
or 
					(t3.n_perizinan ='PENDIRIAN KANTOR CABANG PELAKSANA PENEMPATAN TENAGA KERJA INDONESIA SWASTA (PPTKIS)'  and
t1.d_terima_berkas<= '$date2' and t1.d_terima_berkas>='$date') ";
			$ambil9 = $this->db->query("$sql2");
  
			if($ambil9->num_rows() > 0)
			{
			foreach($ambil9->result() as $baris9)
			{
			$hasil9[] = $baris9;
			}
			return $hasil9;
			}
   }
   
  
 }
?>
