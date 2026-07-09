<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete_ extends WRC_AdminCont
{
	public function __construct()
	{
		parent::__construct();
	}
	public function search()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(3);

		// cari di database
		$data = $this->db->from('bb_traak')->like('NAMA_TRAYE',$keyword)->get();	

		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->NAMA_TRAYE,
				'nim'	=>$row->KODE_TRAYE,
				'jurusan'	=>$row->TRA_ID

			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
}
?>