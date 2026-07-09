<?php
class M_pemohon extends CI_Model {

	function ambildata() {
		$otherdb = $this->load->database('otherdb',TRUE);
		$ambildata = $otherdb->get('tmpemohon');
		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasiltmpemohon[] = $data;
			}
			return $hasiltmpemohon;
		}
	}

	function update_pemohon() {
		$otherdb = $this->load->database('otherdb',TRUE);
		
			$update = $this->input->post('msg');
			for ($i=0; $i < count($update) ; $i++) { 
				$data=array('i_user'=>'tes');
$otherdb->where('id', $update[$i]);
$otherdb->update('tmpemohon',$data);
			}
		
	}

}
?>