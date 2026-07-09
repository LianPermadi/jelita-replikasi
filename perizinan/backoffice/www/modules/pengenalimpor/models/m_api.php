<?php

class M_api extends Model
{
	function get_data_api($no_api) {
		$dbmysql2 = $this->load->database('otherdb',TRUE);
		$query = $dbmysql2->select('*')
        ->from('api_realisasi_import')
        ->where('no_api',$no_api)
        //->where('flag','ok')
        //->order_by('BERLAKU', 'DESC')
        ->get();
        return $query->result();
     }

    function get_data_perusahaanapi($no_api) {
		$dbmysql2 = $this->load->database('otherdb',TRUE);

        $sql = "select a.*,b.*,(select n_kabupaten from api_kabupaten where kd_kab = a.kabupaten2) as namaKabupaten from tm_pemohon a
			inner join api_no_api b on a.id = b.id_tmpemohon";
		return $dbmysql2->query($sql)->result();
		
     }

    function get_datadetail_api($no_api,$tgl1,$tgl2) {
		
        $dbmysql2 = $this->load->database('otherdb',TRUE);
		if($tgl1 == '' || $tgl2 == ''){
		$query = $dbmysql2->select('*')
        ->from('api_realisasi_import')
        //->order_by('BERLAKU', 'DESC')
        ->where('no_api',$no_api)
        //->where('flag <>','ok')
        ->order_by('flag', 'desc')
        ->get();
		
        }else{

		$query = $dbmysql2->select('*')
        ->from('api_realisasi_import')
        //->order_by('BERLAKU', 'DESC')
        ->where('no_api',$no_api)
        ->where('tgl_pib >=',$tgl1)
        ->where('tgl_pib <=',$tgl2)
        //->where('flag','ok')
        ->get();
		}
		
        return $query->result();
     }
     
    function get_data_perusahaanapiapprove($no_api) {
        $dbmysql2 = $this->load->database('otherdb',TRUE);
        $sql = "select distinct a.*,b.*,(select n_kabupaten from api_kabupaten where kd_kab = a.kabupaten2) as namaKabupaten,c.flag from tm_pemohon a
            inner join api_no_api b on a.id = b.id_tmpemohon
            inner join api_realisasi_import c on b.no_api = c.no_api
            where c.flag = 'not'
            ";
        return $dbmysql2->query($sql)->result();
        
     }

    function approve($noapi) {
    
        $dbmysql2 = $this->load->database('otherdb',TRUE);
        $dbmysql2->from('api_realisasi_import');
        $dbmysql2->where('flag','not');
        $dbmysql2->where('no_api',$noapi);
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

    function perusahaan_approve($noapi) {
    
    $dbmysql2 = $this->load->database('otherdb',TRUE);
    $sql = "select * from tm_pemohon a
            inner join api_no_api b on a.id = b.id_tmpemohon
            inner join api_realisasi_import c on b.no_api = c.no_api
            where c.flag = 'not' and b.no_api = ?";
        $ambildata = $dbmysql2->query($sql,$noapi);

        if ($ambildata->num_rows() > 0) {
            foreach ($ambildata->result() as $data) {
                $tbl_perusahaan_approve[] = $data;
            }
            return $tbl_perusahaan_approve;
        }
    }

    function update_approve() {
        $otherdb = $this->load->database('otherdb',TRUE);
        $submit = $this->input->post('submit');
        if($submit == 'Approve'){
            $flag = 'ok';
        }else{
            $flag = 'revisi';
        }
        
        $update = $this->input->post('msg');
        for ($i=0; $i < count($update) ; $i++) { 
            $data=array('flag'=>$flag);
            $otherdb->where('id', $update[$i]);
            $otherdb->update('api_realisasi_import',$data);
        }
        
    }

    function get_data_pesan($id_tmpemohon) {
          $dbmysql2 = $this->load->database('otherdb',TRUE);
        $query = $dbmysql2->select('*')
         ->from('api_pesan')
         ->where('id_tmpemohon',$id_tmpemohon)
         //->where('flag','ok')
         ->order_by('tgl_pesan', 'DESC')
         ->get();
         return $query->result();
     }

}