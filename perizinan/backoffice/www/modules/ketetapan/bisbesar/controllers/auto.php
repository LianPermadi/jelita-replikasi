<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto extends WRC_AdminCont
{
	public function __construct()
	{
		parent::__construct();
	}
	/*public function search()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
			$dbmysql2 = $this->load->database('dbakdp',TRUE);
		//$data = $this->db->from('bb_traak')->like('NAMA_TRAYE',$keyword)->get();	
$data = $dbmysql2->from('bb_traak')->like('NAMA_TRAYE',$keyword)->get();	
		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->NAMA_TRAYE,
				'nim'	=>$row->KODE_TRAYE,
				'jurusan'	=>$row->TRA_ID,

			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	*/
	public function search()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
			$dbmysql2 = $this->load->database('dbakdp',TRUE);
		//$data = $this->db->from('bb_traak')->like('NAMA_TRAYE',$keyword)->get();	
$data = $dbmysql2->from('bb_traak')->like('KODE_TRAYE',$keyword)->get();	
		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->KODE_TRAYE,
				'nama'	=>$row->NAMA_TRAYE,
				'jurusan'	=>$row->TRA_ID,

			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	function search_pengusaha()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		//$data = $this->db->from('bb_pau')->like('NO_IP',$keyword)->get();	
$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->select('(select NAMA_KODYA from bb_kodya where KODYA_ID = a.KODYA_ID_P) as KODYA,a.*');
		$dbmysql2->from('bb_pau a');
		$dbmysql2->like('NO_IP',$keyword);

	//$this->db->select('(select NAMA_KODYA from bb_kodya where KODYA_ID = a.KODYA_ID_P) as KODYA,a.*');
		//$this->db->from('bb_pau a');
		//$this->db->like('NO_IP',$keyword);

		$data = $dbmysql2->get();

	//	return $query->result();

		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->NO_IP,
				'nama_perus'	=>$row->NAMA_PERUS ,
				'alamat_per'	=>$row->ALAMAT_PER,
				'kodya_id' =>$row->KODYA_ID_P,
				'kodya' =>$row->KODYA,
				'nama_pem' =>$row->NAMA_PEMIL,
				'alamat_pem' =>$row->ALAMAT_PEM
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	function search_terminal()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);
		$dbmysql2 = $this->load->database('dbakdp',TRUE);
		$dbmysql2->select('*');
		$dbmysql2->from('bb_kota');
		$dbmysql2->like('NAMA_KOTA',$keyword);
		$data = $dbmysql2->get();


		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->NAMA_KOTA,
				'ID'	=>$row->ID 
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	function search_PP1_1()
	{
		// tangkap variabel keyword dari URL

		$keyword = $this->uri->segment(3);
		$dbmysql2 = $this->load->database('dbakdp',TRUE);

   		$TERMINAL_I = $this->input->post('TERMINAL_I');
   		//$TERMINAL_I =324;
		
		$dbmysql2->distinct();
		$dbmysql2->select('*');
		$dbmysql2->from('bb_tp_dwp');
		//$dbmysql2->where("(PP1_1 LIKE '%%' OR another_row LIKE '%%' )")
		$dbmysql2->where('TERMINAL_I',$TERMINAL_I);
		$dbmysql2->like('PP1_1',$keyword);//->and('TERMINAL_I',324);
		//$bbmysql2->where('TERMINAL_I','324')
		$data = $dbmysql2->get();


		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->PP1_1
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

function search_PP1_2()
	{
		// tangkap variabel keyword dari URL

		$keyword = $this->uri->segment(3);
		$dbmysql2 = $this->load->database('dbakdp',TRUE);

   		$TERMINAL_I = $this->input->post('xTERMINAL_I');
		
		$dbmysql2->distinct();
		$dbmysql2->select('*');
		$dbmysql2->from('bb_tp_dwp');
		//$dbmysql2->where("(PP1_1 LIKE '%%' OR another_row LIKE '%%' )")
		//$dbmysql2->where('xTERMINAL_I',$TERMINAL_I);
		$dbmysql2->like('PP1_2',$keyword)->and('TERMINAL_I',$TERMINAL_I);
		//$bbmysql2->where('TERMINAL_I','324')
		$data = $dbmysql2->get();


		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->PP1_2
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
}
?>