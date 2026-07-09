<?php
	
	class Ceksyarat extends CI_Controller {

		function index() {

			$otherdb = $this->load->database('otherdb',TRUE);
			$bidang = $otherdb->query('select * from trsektor')->result();
			$izin = $otherdb->query('select * from trperizinan')->result();
			$data['bidang']		= $bidang;
			$data['izin']	= $izin;
	        $this->load->view('v_ceksyarat',$data);
	    }
		
		function getizin(){

			$otherdb = $this->load->database('otherdb',TRUE);
			$data = $_POST['data'];
			$str = '|Pilih Perizinan,';
			$rowsData	= $otherdb->query("select * from trperizinan where id in(select trperizinan_id from trperizinan_trsektor where trsektor_id='".$data."')")->result();
			
			foreach($rowsData as $row)
			{
				$kab = $row->n_perizinan;
				$str = $str . "$row->id|$kab".",";
			}
			
			$str = substr($str,0,(strLen($str)-1)); 
			
			echo json_encode($str);
			
		}

		function getsyarat(){

			$otherdb = $this->load->database('otherdb',TRUE);
			$data = $_POST['data'];
			$sql 		=	"select trsyarat_perizinan.* 
								from trsyarat_perizinan 
								where trsyarat_perizinan.id IN(select 
									trsyarat_perizinan_id 
									from trperizinan_trsyarat_perizinan 
									where trperizinan_id='".$data."' and status='1')";
			$rowsData 	= $otherdb->query($sql)->result();

			$str = "";
			foreach($rowsData as $row)
			{
				$str .= "<li>".$row->v_syarat."</li>";
			}
			$str = substr($str,0,(strLen($str)-1)); 
			echo json_encode($str);
			
		}
	}
?>