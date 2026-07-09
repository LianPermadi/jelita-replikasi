<?php

class M_import extends Model
{


function caridata($tg1,$tg2) {
	
		//$otherdb = $this->load->database('otherdb',TRUE);
		//$ambildata = $otherdb->get('akdp_cetak');

		/*$otherdb->select('*');
		$otherdb->from('akdp_cetak');
		$otherdb->where($where);
		$otherdb->where('tgl_kp_awal <=',$tg2);
		$otherdb->where('tgl_kp_awal >=',$tg1);*/
		
		//$ambildata = $otherdb->get();

		$this->db->from('api_realisasi_import');
		//$this->db->where($where);
		//$otherdb->where('tgl_kp_awal <=',$tg2);
		//$otherdb->where('tgl_kp_awal >=',$tg1);
		$ambildata = $this->db->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$tabel_api[] = $data;
			}
			return $tabel_api;
		}
	}

	function approve($tg1,$tg2) {
	
		
		//$ambildata = $otherdb->get();
$dbmysql2 = $this->load->database('otherdb',TRUE);
		$dbmysql2->from('api_realisasi_import');
		$dbmysql2->where('flag','not');
		//$otherdb->where('tgl_kp_awal <=',$tg2);
		//$otherdb->where('tgl_kp_awal >=',$tg1);
		$ambildata = $dbmysql2->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$tabel_api[] = $data;
			}
			return $tabel_api;
		}
	}
	function perusahaan_approve($tg1,$tg2) {
	
	$dbmysql2 = $this->load->database('otherdb',TRUE);
	$sql = "select distinct namaPerusahaan,c.no_api from tm_pemohon a
			inner join api_no_api b on a.id = b.id_tmpemohon
			inner join api_realisasi_import c on b.no_api = c.no_api
			where c.flag = 'not'";
		$ambildata = $dbmysql2->query($sql);

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$tbl_perusahaan_approve[] = $data;
			}
			return $tbl_perusahaan_approve;
		}
	}
}