<?php

class M_approve_esign extends CI_Model {

	function ambildata($userid) {
$otherdb = $this->load->database('otherdb',TRUE);
		$tg1 = date("Y-m-d");
		$tg2 = date("Y-m-d");
		$h= '9';
		
        $otherdb->select('(case when eselon = 4 then 1 
        	when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
       
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}
		

		$trperizinan_id = '';
        $otherdb->select('trperizinan_id');
        $otherdb->from('trperizinan_user');
        $otherdb->where('user_id',$userid);
       	$ambilperizinanid =  $otherdb->get();
        foreach ($ambilperizinanid->result() as $data3) {
				$trperizinan_id[] = $data3->trperizinan_id;
			}

		$otherdb->select('tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
						  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas');
		$otherdb->from('tmpermohonan');
		$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
		$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
		$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
		$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
		$otherdb->where('tmpermohonan.approve',$h);
		$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
		$otherdb->where('trperizinan.e_sertifikat','1');
		//$otherdb->where('trperizinan.e_ttd = "1");
		$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
		$otherdb->where_in('trperizinan.id',$trperizinan_id);
		//$otherdb->or_where('trperizinan.e_ttd','2');

		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}

function caridata($tg1,$tg2,$userid) {
	if ($userid == 48){
			//$sts = '1';
			 $where = 'approve = 1';
		}else if ($userid == 257){
			//$sts = '4';
			 $where = 'approve = 4';
		}
		else if ($userid == 178){
			//$sts = '3';
			 $where = 'approve = 3';
		}else{
			 $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
		}
		$otherdb = $this->load->database('otherdb',TRUE);
		//$ambildata = $otherdb->get('akdp_cetak');

		$otherdb->select('*');
		$otherdb->from('akdp_cetak');
		$otherdb->where($where);
		$otherdb->where('tgl_kp_awal <=',$tg2);
		$otherdb->where('tgl_kp_awal >=',$tg1);
		
		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}
	function update_permohonanemail($iduser) {
		$otherdb = $this->load->database('otherdb',TRUE);
		
		$otherdb->select(' n_pegawai,eselon ,trperizinan_user.trperizinan_id');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->join('user','user.id = tmpegawai_user.user_id','left');
        $otherdb->join('trperizinan_user','trperizinan_user.user_id = user.id','left');
        $otherdb->join('tmpermohonan_trperizinan','trperizinan_user.trperizinan_id = tmpermohonan_trperizinan.trperizinan_id','left');
         $otherdb->join('tmpermohonan','tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id','left');
        $otherdb->where('tmpermohonan.id','94062');
        $otherdb->where('eselon','3');
        $otherdb->where('trperizinan_user.trperizinan_id','249');
         //$otherdb->where('user.email <>','');
       	$ambileselon =  $otherdb->get();
        if ($ambileselon->num_rows() > 0) {
			foreach ($ambileselon->result() as $data) {
				$hasilemail[] = $data;
			}
			return $hasilemail;
		}
			
	}

	function update_permohonan($iduser) {



		date_default_timezone_set("Asia/Bangkok");
		
		$otherdb = $this->load->database('otherdb',TRUE);
		
		$otherdb->select('eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$iduser);
       	$ambileselon =  $otherdb->get();
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}



			$update = $this->input->post('msg');
		$nodaftar= $this->input->post('nodaftar'); 
			$passphrase = $this->input->post('passphrase');

			?>
			<script src="<?php echo base_url(); ?>assets/esign/jquery-latest.js"></script>
		<?php

			for ($i=0; $i < count($update) ; $i++) {

				if ($h	== 4){
					$data=array('approve'=>'4');
					
					$this->load->library('cfpdf');
					$this->load->library('cfpdi');

					$pdf = new FPDI();

					$filepdf = $_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/skpdf/SK_'.$nodaftar[$i].'.pdf';
					
try {
	$pageCount = $pdf->setSourceFile($filepdf);


					for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
					    $templateId = $pdf->importPage($pageNo);
					    $size = $pdf->getTemplateSize($templateId);
					    if ($size['w'] > $size['h']) {
					        $pdf->AddPage('L', array($size['w'], $size['h']));
					        $img = base_url('assets/img/bsre.jpg');

						//$pdf->cell(12);
						
						//$pdf->Image($img,17,190,180,12);
						$pdf->Image($img,17,190,185,12);
					    } else {
					        $pdf->AddPage('P', array($size['w'], $size['h']));
					        $img = base_url('assets/img/bsre.jpg');

						//$pdf->cell(12);
						$pdf->Image($img,17,310,180,12);
						//$pdf->Image($img,17,308,180,12);
						//$pdf->Image($img,17,330,180,12);
					    }
					    $pdf->useTemplate($templateId);
					/*if($pageNo == 1){
						$kop = base_url('assets/img/kop.jpg');
						$pdf->Image($kop,15,12,185,28);
					}	*/					
					}
						//$pdf->Output($filepdf,'F');
					$pdf->Output($filepdf,'F');
						//echo base_url('assets/img/bsre.png');

//$img =  base_url('assets/img/bsre.jpg');

				/*		//$img = $_SERVER['DOCUMENT_ROOT'].'/android_online/android/assets/img/bsre.jpg';
				$img = $_SERVER['DOCUMENT_ROOT'].'/android/assets/img/bsre.jpg';
						echo $img;
	$this->load->library('pdf');

						function footer() 
						{  
						 //$this->SetY(-25);  
						$this->cell(12);
						
						$this->Image($img,12,280,180,12);                                                     
						}  
						
						
						$pdf = new pdf(); 
						$pdf->aliasnbpages();  
						$pagecount = $pdf->setsourcefile($filepdf); 
						for($pageno = 1; $pageno <= $pagecount; $pageno++) {  
						$templateid = $pdf->importpage($pageno);    
						$size = $pdf->gettemplatesize($templateid); 
						    
						if ($size['w'] > $size['h']) {         
						$pdf->addpage('l', array($size['w'], $size['h']));     } else {         
						$pdf->addpage('p', array($size['w'], $size['h']));     }     
						$pdf->usetemplate($templateid); }   
						$pdf->Output("");

						*/

} catch (Exception $e) {
	
}
//die;
				}else if($h == 3){
					$data=array('approve'=>'3');

				}else if($h == 2){
					$data=array('approve'=>'2');
$this->load->library('cfpdf');
					$this->load->library('cfpdi');

					$pdf = new FPDI();

					$filepdf = $_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/skpdf/SK_'.$nodaftar[$i].'.pdf';
					
try {
	$pageCount = $pdf->setSourceFile($filepdf);


					for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
					    $templateId = $pdf->importPage($pageNo);
					    $size = $pdf->getTemplateSize($templateId);
					    if ($size['w'] > $size['h']) {
					        $pdf->AddPage('L', array($size['w'], $size['h']));
					        $img = base_url('assets/img/bsre.jpg');

						//$pdf->cell(12);
						
						//$pdf->Image($img,17,190,180,12);
						$pdf->Image($img,17,190,185,12);
					    } else {
					        $pdf->AddPage('P', array($size['w'], $size['h']));
					        $img = base_url('assets/img/bsre.jpg');

						//$pdf->cell(12);
						$pdf->Image($img,17,310,180,12);
						//$pdf->Image($img,17,308,180,12);
						//$pdf->Image($img,17,330,180,12);
					    }
					    $pdf->useTemplate($templateId);
					/*if($pageNo == 1){
						$kop = base_url('assets/img/kop.jpg');
						$pdf->Image($kop,15,12,185,28);
					}*/						
					}
						//$pdf->Output($filepdf,'F');
					$pdf->Output($filepdf,'F');
						//echo base_url('assets/img/bsre.png');

//$img =  base_url('assets/img/bsre.jpg');

				/*		//$img = $_SERVER['DOCUMENT_ROOT'].'/android_online/android/assets/img/bsre.jpg';
				$img = $_SERVER['DOCUMENT_ROOT'].'/android/assets/img/bsre.jpg';
						echo $img;
	$this->load->library('pdf');

						function footer() 
						{  
						 //$this->SetY(-25);  
						$this->cell(12);
						
						$this->Image($img,12,280,180,12);                                                     
						}  
						
						
						$pdf = new pdf(); 
						$pdf->aliasnbpages();  
						$pagecount = $pdf->setsourcefile($filepdf); 
						for($pageno = 1; $pageno <= $pagecount; $pageno++) {  
						$templateid = $pdf->importpage($pageno);    
						$size = $pdf->gettemplatesize($templateid); 
						    
						if ($size['w'] > $size['h']) {         
						$pdf->addpage('l', array($size['w'], $size['h']));     } else {         
						$pdf->addpage('p', array($size['w'], $size['h']));     }     
						$pdf->usetemplate($templateid); }   
						$pdf->Output("");

						*/

} catch (Exception $e) {
	
}
//------------------------- ttd digital
				$path_jar = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/JSignPdf.jar';
				//$path_jar = $_SERVER['DOCUMENT_ROOT'].'/android_online/android/assets/esign/signer/JSignPdf.jar';
				$path_pdf = $_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/skpdf/SK_'.$nodaftar[$i].'.pdf'; 
				//$path_pdf = 'http://124.81.122.226/nrspdf/web/assets/skpdf/SK_0814410601042018243.pdf'; 
				//$path_p12 = $_SERVER['DOCUMENT_ROOT'].'/android_online/android/assets/esign/signer/kepala.p12';
				$path_p12 = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/kepala.p12';  
        		$output_path = $_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/esignfile/';
        		$tsa_url = "http://tsa-osd.lemsaneg.go.id/";
        		$ocsp = "http://cvs-osd.lemsaneg.go.id/ocsp";

        		$command = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Dinas PMPTSP Jawa Barat" -r "Pengesahan Naskah Perizinan" -c "kontak yang bisa dihubungi" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
        		exec($command, $val, $er);
						if($er == 0 || $er == 3){
						
						}else{
							redirect('approve_esign/pesan_permohonanesign');
						}
//------------------------- akhir ttd digital
       	 }else{

        }

				$otherdb->where('id', $update[$i]);
				$otherdb->update('tmpermohonan',$data);


				$ambildata = $otherdb->select('*')
         ->from('tmpermohonan_ky')
         ->where('tmpermohonan_id',$update[$i])
         ->get();

		if ($ambildata->num_rows() > 0) {
			if ($h	== 4){
					$data=array('tg_kyEsl4PTSP'=>date("Y-m-d H:i:s"));
				}else if($h == 3){
					$data=array('tg_kyEsl3PTSP'=>date("Y-m-d H:i:s"));
				}else if($h == 2){
					$data=array('tg_kyKaPTSP'=>date("Y-m-d H:i:s"));	
				}
				
				$otherdb->where('tmpermohonan_id', $update[$i]);
				$otherdb->update('tmpermohonan_ky',$data);
		}else{
				if ($h	== 4){
					$data=array(
						'tmpermohonan_id'=>$update[$i],
						'tg_kyEsl4PTSP'=>date("Y-m-d H:i:s")
					);
				}else if($h == 3){
					$data=array(
						'tmpermohonan_id'=>$update[$i],
						'tg_kyEsl3PTSP'=>date("Y-m-d H:i:s")
					);
				}else if($h == 2){
					$data=array(
						'tmpermohonan_id'=>$update[$i],
						'tg_kyKaPTSP'=>date("Y-m-d H:i:s")
					);	
				}
				
				$otherdb->insert('tmpermohonan_ky',$data);	
		}
			}

			
		//}
	}

function detail_data($id) {
		$otherdb = $this->load->database('otherdb',TRUE);
		$ambildata = $otherdb->select('akdp_cetak.*,akdptrayek.trayek')
         ->from('akdp_cetak')
         ->join('akdptrayek', 'akdp_cetak.kode_trayek = akdptrayek.kode_trayek', 'left')
         ->where('akdp_cetak.id',$id)
         ->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}

	function detail_datapermohonan($id) {
		$otherdb = $this->load->database('otherdb',TRUE);
		$ambildata = $otherdb->select('
			tmperusahaan.n_perusahaan,
			tmperusahaan.a_perusahaan,
			tmpermohonan.pendaftaran_id,
			tmpermohonan.id,
			trperizinan.n_perizinan,
			tmpermohonan.d_terima_berkas,
			tmpermohonan.no_per_pertek,
			tmpermohonan.tg_per_pertek,
			tmpermohonan.d_survey,
			tmpermohonan.survey_sd,
			tmpermohonan.d_selesai_proses,
			tmpermohonan.status_berkas,
			trperizinan.n_perizinan,
			tmpermohonan.bidang,
			trperizinan.bid_teknis,
			tmpemohon.n_pemohon,
			tmpemohon.a_pemohon
			')
         ->from('tmpermohonan')
         ->join('tmpermohonan_trperizinan', 'tmpermohonan_trperizinan.tmpermohonan_id = tmpermohonan.id', 'left')
         ->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left')
         ->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left')
		 ->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left')
		 ->join('tmpemohon_tmpermohonan', 'tmpermohonan.id = tmpemohon_tmpermohonan.tmpermohonan_id', 'left')
		 ->join('tmpemohon', ' tmpemohon_tmpermohonan.tmpemohon_id = tmpemohon.id', 'left')
         ->where('tmpermohonan.id',$id)
         ->where('trperizinan.e_sertifikat','1')
         ->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}

	function caridata_no_pendaftaran($no_pendaftaran,$userid) {
	/*if ($userid == 48){
			//$sts = '1';
			 $where = 'approve = 1';
		}else if ($userid == 257){
			//$sts = '4';
			 $where = 'approve = 4';
		}
		else if ($userid == 178){
			//$sts = '3';
			 $where = 'approve = 3';
		}else{
			 $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
		}*/


		$otherdb = $this->load->database('otherdb',TRUE);
		//$ambildata = $otherdb->get('akdp_cetak');

		/*$otherdb->select('*');
		$otherdb->from('tmpermohonan');
		$otherdb->where($where);
		$otherdb->like('pendaftaran_id',$no_pendaftaran);
		
		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}*/

		$h= '9';
		
        $otherdb->select('(case when eselon = 4 then 1 when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}
	
        $otherdb->select('trperizinan_id');
        $otherdb->from('trperizinan_user');
        $otherdb->where('user_id',$userid);
       	$ambilperizinanid =  $otherdb->get();
        foreach ($ambilperizinanid->result() as $data3) {
				$trperizinan_id[] = $data3->trperizinan_id;
			}
		$otherdb->select('tmpermohonan.bidang,tmpermohonan.pendaftaran_id,tmpermohonan.id,tmperusahaan.n_perusahaan,
						  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas');
		$otherdb->from('tmpermohonan');
		$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
		$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
		$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
		$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
		$otherdb->where('tmpermohonan.approve',$h);
		$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
		$otherdb->where('trperizinan.e_sertifikat','1');
		$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
		$otherdb->where_in('trperizinan.id',$trperizinan_id);
		//$otherdb->like('tmpermohonan.pendaftaran_id',$no_pendaftaran);
		$otherdb->where("(tmpermohonan.pendaftaran_id like '%$no_pendaftaran%' OR tmperusahaan.n_perusahaan like '%$no_pendaftaran%' OR trperizinan.n_perizinan like '%$no_pendaftaran%')", NULL, FALSE);
		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}
	function update_revisi($id,$msg_revisi,$kode){
		
			$otherdb = $this->load->database('otherdb',TRUE);
			$data=array('approve'=>'0');
			$otherdb->where('id',$id);
			$cek = $otherdb->update('tmpermohonan',$data);
if($cek)
{
			$data=array('pesan_revisi'=>$msg_revisi);
			$otherdb->where('id',$kode);
			$otherdb->update('tmsk',$data);

			$data=array(
			'tg_kyStafPTSP'=>'',
				'tg_kyEsl4PTSP'=>'',
				'tg_kyEsl3PTSP'=>'',
				'tg_kyKaPTSP'=>'',
				'kyStafPTSP'=>'',
				'kyEsl4PTSP'=>'',
				'kyEsl3PTSP'=>'',
				'kyKaPTSP'=>''
				);
			$otherdb->where('tmpermohonan_id',$id);
			$otherdb->update('tmpermohonan_ky',$data);

}
				redirect('approve_esign/index');
	}
	function ambil_tmsk($id_permohonan){
		
		$otherdb = $this->load->database('otherdb',TRUE);
		$ambildata = $otherdb->select('tmsk.id')
         ->from('tmsk')
         ->join('tmpermohonan_tmsk', 'tmpermohonan_tmsk.tmsk_id=tmsk.id', 'left')
         ->where('tmpermohonan_tmsk.tmpermohonan_id',$id_permohonan)
         ->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$kode_tmsk[] = $data;
			}
			return $kode_tmsk;
		}
	}

	function list_approve($userid) {
$otherdb = $this->load->database('otherdb',TRUE);

  $otherdb->select('eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
       
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}


		$tg1 = date('Y-m-d');
		$tg2 = date('Y-m-d');
			

		$trperizinan_id = '';
        $otherdb->select('trperizinan_id');
        $otherdb->from('trperizinan_user');
        $otherdb->where('user_id',$userid);
       	$ambilperizinanid =  $otherdb->get();
        foreach ($ambilperizinanid->result() as $data3) {
				$trperizinan_id[] = $data3->trperizinan_id;
			}

		$otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
						  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,
tmpermohonan_ky.tg_kyEsl4PTSP,tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP');
		$otherdb->from('tmpermohonan');
		$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
		$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
		$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
		$otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
		$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
		$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
		$otherdb->where('trperizinan.e_sertifikat','1');
		$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
		
		
		if($h == '4'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
			}else if($h=='3'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
			}else if($h=='2'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
			}
			else{

			}
		$otherdb->where('tmpermohonan.approve <>','0');
		$otherdb->where_in('trperizinan.id',$trperizinan_id);

		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}
	function cari_list_approve($userid,$tg1,$tg2) {
$otherdb = $this->load->database('otherdb',TRUE);

  $otherdb->select('eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
       
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}


		//$tg1 = date('Y-m-d');
		//$tg2 = date('Y-m-d');
			

		$trperizinan_id = '';
        $otherdb->select('trperizinan_id');
        $otherdb->from('trperizinan_user');
        $otherdb->where('user_id',$userid);
       	$ambilperizinanid =  $otherdb->get();
        foreach ($ambilperizinanid->result() as $data3) {
				$trperizinan_id[] = $data3->trperizinan_id;
			}

		$otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
						  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,
tmpermohonan_ky.tg_kyEsl4PTSP,tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP');
		$otherdb->from('tmpermohonan');
		$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
		$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
		$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
		$otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
		$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
		$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
		$otherdb->where('trperizinan.e_sertifikat','1');
		$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
		
		
		if($h == '4'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
			}else if($h=='3'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
			}else if($h=='2'){
$otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
$otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
			}
			else{

			}
		$otherdb->where('tmpermohonan.approve <>','0');
		$otherdb->where_in('trperizinan.id',$trperizinan_id);

		$ambildata = $otherdb->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}
	
}
?>