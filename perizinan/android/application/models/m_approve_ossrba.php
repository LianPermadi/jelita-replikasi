<?php
class M_approve_ossrba extends CI_Model {

  function ambilesselon($iduser){
        $h = 9;
        $otherdb = $this->load->database('otherdb',TRUE);
        $otherdb->select('eselon');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$iduser);
        $ambileselon =  $otherdb->get();
          
        foreach($ambileselon->result() as $data2) {
          $h = $data2->eselon;
        }
        return $h;
  }

	function ambildataoss($userid){
		$otherdb = $this->load->database('otherdb',TRUE); // inisiasi database
		$query_userid = $otherdb->query("SELECT c.id FROM user a 
				left join tmpegawai_user b on a.id = b.user_id 
				left join tmpegawai c on b.tmpegawai_id = c.id
				where a.id = '".$userid."' ")->result();

		  
		// $query_eselon = $otherdb->query(" Select (case when eselon = 4 then 1 
  //       	when eselon = 3 then 4 when eselon = 2 then 3 END )eselon
		// 	from tmpegawai  a
		// 	left join tmpegawai_user b on a.id = b.tmpegawai_id
		// 	where b.user_id = '".$userid."' ")->result();

		  $otherdb->select('(case when eselon = 4 then 1 
        	when eselon = 3 then 4 when eselon = 2 then 3 END )eselon, tmpegawai_user.tmpegawai_id');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
      	
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;

				$u = $data2->tmpegawai_id;
			}
		
		// $query_ossrba = $otherdb->query("Select * from oss_persetujuanpermohonan 
		// 	where  esselon = '".$h."'
		// 	")->result();

		// $otherdb->distinct();
		// $otherdb->select('trperizinan_id');
	 //    $otherdb->from('trperizinan_user');
	 //    $otherdb->where('user_id',$userid);
	 //    $ambilperizinanid =  $otherdb->get();

	 //    foreach($ambilperizinanid->result() as $data3) {
	 //      	$trperizinan_id[] = $data3->trperizinan_id;
	 //    	//echo "<br>".$data3->trperizinan_id;
	 //    }//die;

		// $otherdb->distinct();
	 //    $otherdb->select('trsektor.id');
	 //    $otherdb->from('trsektor');
	 //    $otherdb->join('trperizinan_trsektor', 'trsektor.id = trperizinan_trsektor.trsektor_id', 'left');
	 //    $otherdb->join('trperizinan', 'trperizinan.id = trperizinan_trsektor.trperizinan_id', 'left');
	 //    $otherdb->where_in('trperizinan.id',$trperizinan_id);
	 //    $ambildata = $otherdb->get();

	 //    foreach($ambildata->result() as $data) {
	 //        $hasilakdp_cetak2[] = $data; //disable
	 //        //echo "<br>".$data3->trperizinan_id;
	 //      }

	    //$arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9,10);
$trperizinan_id[]='' ;

	    if($h==4){
		    $otherdb->distinct();
			$otherdb->select('id');
		    $otherdb->from('trsektor');
		    $otherdb->where('ttd_nota',$u);
		    $ambilperizinanid =  $otherdb->get();

		    foreach($ambilperizinanid->result() as $data3) {
		      	$trperizinan_id[] = $data3->id;
		    	//echo "<br>".$data3->id;
		    }//die;
			
		if($userid == 101){
			// var_dump($trperizinan_id);die();
		}
		    	$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();

				$hasilakdp_cetak3 = array();
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		else if($h==1){
			 $otherdb->distinct();
			$otherdb->select('id');
		    $otherdb->from('trsektor');
		    $otherdb->where('esl4_tolak',$u);
		    $ambilperizinanid =  $otherdb->get();
			// var_dump($ambilperizinanid->result());die();
		    foreach($ambilperizinanid->result() as $data3) {
		      	$trperizinan_id[] = $data3->id;
		    	// echo "<br>".$data3->id;
		    }
			// die;
		    	$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();

				$hasilakdp_cetak3 = array();
				
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		else{
				$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				//$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();

				$hasilakdp_cetak3 = array();
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		 

	

		

	}

	

	public function get_fiktifpositif($nomor) {
        switch ($nomor) {
            case '0':
                $data = "TIDAK";
                break;
            case '1':
                $data = "YA";
                break;
           
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_status($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Disetujui";
                break;
            case '1':
                $data = "Perbaikan";
                break;
            case '2':
                $data = "Penolakan";
                break;
           
            default:
                $data = " - ";
                break;
        }
        return $data;
    }
    
	public function get_n_sektor($id) {
		$otherdb = $this->load->database('otherdb',TRUE); // inisiasi database
        $data = " - ";
        	$sektor = $otherdb->query("SELECT n_sektor FROM trsektor
				where id = '".$id."' ")->row();

        // $sektor = $this->otherdb->select('n_sektor')
        //              ->from('trsektor')
        //              ->where('id', $id)
        //              ->get()->row();

        if (!empty($sektor->n_sektor)) {
            $data = $sektor->n_sektor;
        }
        return $data;
    }

    public function get_tipe_aplikasi($id) {
		$otherdb = $this->load->database('otherdb',TRUE); // inisiasi database
        $data = " - ";
        	$sektor = $otherdb->query("SELECT nama_aplikasi FROM oss_tipeaplikasi
				where id = '".$id."' ")->row();

        // $sektor = $this->otherdb->select('n_sektor')
        //              ->from('trsektor')
        //              ->where('id', $id)
        //              ->get()->row();

        if (!empty($sektor->nama_aplikasi)) {
            $data = $sektor->nama_aplikasi;
        }
        return $data;
    }

    public function get_namaperizinan($nomor) {
        switch ($nomor) {
            case '0':
                $data = "NIB";
                break;
            case '1':
                $data = "Sertifikat Standar";
                break;
            case '2':
                $data = "Izin";
                break;
            case '3':
                $data = "PB-UMKU";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }
    public function get_risiko($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Rendah";
                break;
            case '1':
                $data = "Menengah Rendah";
                break;
            case '2':
                $data = "Menengah Tinggi";
                break;
            case '3':
                $data = "Tinggi";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }


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
      	//var_dump($ambileselon);die;
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;
			}

			if($this->session->userdata("group") == 1) {
				$h = '3';
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
		$otherdb->where('trperizinan.e_sertifikat','0');
		//$otherdb->where('trperizinan.e_ttd = "1");
		$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
		$otherdb->where_in('trperizinan.id',$trperizinan_id);
		//$otherdb->or_where('trperizinan.e_ttd','2');
		$ambildata = $otherdb->get();

		$hasilakdp_cetak = array();

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
		else if ($userid == 259){
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

	function update_permohonanossrba($iduser, $keterangan_ky) {

		date_default_timezone_set("Asia/Bangkok");
		echo date_default_timezone_get();
		
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
			// var_dump($update);die;
			for ($i=0; $i < count($update) ; $i++) { 
				if ($h	== 4){
					$data=array('esselon'=>'4');
				}else if($h == 3){
					$data=array('esselon'=>'3');
				}else if($h == 2){
					$data=array('esselon'=>'2');	
				}
				

				$otherdb->where('id', $update[$i]);
				$otherdb->update('oss_persetujuanpermohonan',$data);


			$ambildata = $otherdb->select('*')
	         ->from('oss_logs')
	         ->where('oss_id',$update[$i])
	         ->get();

			if ($ambildata->num_rows() > 0) {
				if ($h == 4) {
					$data = array(
						'tg_kyEsl4PTSP' => date("Y-m-d H:i:s"),
						'id_ess4' => $iduser,
						'ket_esl4' => $keterangan_ky
					);
				} else if ($h == 3) {
					$data = array(
						'tg_kyEsl3PTSP' => date("Y-m-d H:i:s"),
						'id_ess3' => $iduser,
						'ket_esl3' => $keterangan_ky
					);
				} else if ($h == 2) {
					$data = array(
						'tg_kyKaPTSP' => date("Y-m-d H:i:s"),
						'id_ess2' => $iduser,
						'ket_esl2' => $keterangan_ky
					);
				}				
					$otherdb->where('oss_id', $update[$i]);
					$otherdb->update('oss_logs',$data);
			}else{
				if ($h == 4) {
					$data = array(
						'oss_id' => $update[$i],
						'tg_kyEsl4PTSP' => date("Y-m-d H:i:s"),
						'id_ess4' => $iduser,
						'ket_esl4' => $keterangan_ky
					);
				} else if ($h == 3) {
					$data = array(
						'oss_id' => $update[$i],
						'tg_kyEsl3PTSP' => date("Y-m-d H:i:s"),
						'id_ess3' => $iduser,
						'ket_esl3' => $keterangan_ky
					);
				} else if ($h == 2) {
					$data = array(
						'oss_id' => $update[$i],
						'tg_kyKaPTSP' => date("Y-m-d H:i:s"),
						'id_ess2' => $iduser,
						'ket_esl2' => $keterangan_ky
					);  
				}

				$otherdb->insert('oss_logs',$data);

					
				}
		}

			
		//}
	}

	function update_permohonan($iduser) {

		date_default_timezone_set("Asia/Bangkok");
		echo date_default_timezone_get();
		
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
			for ($i=0; $i < count($update) ; $i++) { 
				if ($h	== 4){
					$data=array('approve'=>'4');
				}else if($h == 3){
					$data=array('approve'=>'3');
				}else if($h == 2){
					$data=array('approve'=>'2');	
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
			*
			')
         ->from('oss_persetujuanpermohonan')
         
         ->where('id',$id)
        
         ->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}

	
	function oss_logs($id) {
		$filename = $id;

// Get the file extension
$fileInfo = pathinfo($filename);
$extension = $fileInfo['extension'];

// Remove the file extension
$id = str_replace('.' . $extension, '', $filename);
		$otherdb = $this->load->database('otherdb',TRUE);
		$ambildata = $otherdb->select('
			*
			')
         ->from('oss_logs')
         
         ->where('oss_id',$id)
        
         ->get();

		if ($ambildata->num_rows() > 0) {
			foreach ($ambildata->result() as $data) {
				$hasilakdp_cetak[] = $data;
			}
			return $hasilakdp_cetak;
		}
	}

	 public function get_jenisperusahaan($nomor) {
	        switch ($nomor) {
	            case '0':
	                $data = "Badan Usaha";
	                break;
	            case '1':
	                $data = "Perorangan";
	                break;
	            default:
	                $data = " - ";
	                break;
	        }
	        return $data;
	    }

	function caridata_no_pendaftaran($no_pendaftaran,$userid) {
		$otherdb = $this->load->database('otherdb',TRUE);

		$otherdb->select('(case when eselon = 4 then 1 
        	when eselon = 3 then 4 when eselon = 2 then 3 END )eselon, tmpegawai_user.tmpegawai_id');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$userid);
       	$ambileselon =  $otherdb->get();
      	//var_dump($ambileselon);die;
        foreach ($ambileselon->result() as $data2) {
				$h = $data2->eselon;

				$u = $data2->tmpegawai_id;
			}
		//var_dump($h);die();
		if($h==4){
		    $otherdb->distinct();
			$otherdb->select('id');
		    $otherdb->from('trsektor');
		    $otherdb->where('ttd_nota',$u);
		    $ambilperizinanid =  $otherdb->get();

		    foreach($ambilperizinanid->result() as $data3) {
		      	$trperizinan_id[] = $data3->id;
		    	//echo "<br>".$data3->id;
		    }//die;
		    	$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				$otherdb->where("(nib like '%$no_pendaftaran%' OR nama_perusahaan like '%$no_pendaftaran%' OR nomorpermohonan like '%$no_pendaftaran%')", NULL, FALSE);
				$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();

				$hasilakdp_cetak3 = array();
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		else if($h==1){
			 $otherdb->distinct();
			$otherdb->select('id');
		    $otherdb->from('trsektor');
		    $otherdb->where('esl4_tolak',$u);
		    $ambilperizinanid =  $otherdb->get();

		    foreach($ambilperizinanid->result() as $data3) {
		      	$trperizinan_id[] = $data3->id;
		    	//echo "<br>".$data3->id;
		    }//die;

		    	$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				$otherdb->where("(nib like '%$no_pendaftaran%' OR nama_perusahaan like '%$no_pendaftaran%' OR nomorpermohonan like '%$no_pendaftaran%')", NULL, FALSE);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();

				$hasilakdp_cetak3 = array();
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		else{
				$otherdb->select('*');
				$otherdb->from('oss_persetujuanpermohonan');
				$otherdb->where('esselon',$h);
				$otherdb->where("(nib like '%$no_pendaftaran%' OR nama_perusahaan like '%$no_pendaftaran%' OR nomorpermohonan like '%$no_pendaftaran%')", NULL, FALSE);
				//$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
				//$otherdb->where('trperizinan.e_sertifikat','0');
				//$otherdb->where('trperizinan.e_ttd = "1");
				//$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
				//$otherdb->where_in('sektor',$trperizinan_id);
				//$otherdb->or_where('trperizinan.e_ttd','2');
				$ambildata = $otherdb->get();
				//var_dump($ambildata);die();

				$hasilakdp_cetak3 = array();
				if ($ambildata->num_rows() > 0) {
					foreach ($ambildata->result() as $data) {
						$hasilakdp_cetak3[] = $data;
					}
					//return $hasilakdp_cetak;
				}

				return $hasilakdp_cetak3;
		}
		
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
		$otherdb->where('trperizinan.e_sertifikat','0');
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
				redirect('approve_nonesign/index');
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
		$otherdb->where('trperizinan.e_sertifikat','0');
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
		$otherdb->where('trperizinan.e_sertifikat','0');
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
	
function get_tmpegawai_id($id) {
    $otherdb = $this->load->database('otherdb', TRUE);
    $ambildata = $otherdb->select('tmpegawai_id')
        ->from('tmpegawai_user')
        ->where('user_id', $id)
        ->get();

    if ($ambildata->num_rows() > 0) {
        foreach ($ambildata->result() as $data) {
            // Assuming you want to return the 'tmpegawai_id' as a string
            return $data->tmpegawai_id;
        }
    }

    // Return a default value or handle the case when no data is found
    return "Not found";
}
	
function id_pengolah($id) {
    $otherdb = $this->load->database('otherdb', TRUE);
    $ambildata = $otherdb->select('id_user')
        ->from('oss_persetujuanpermohonan')
        ->where('id', $id)
        ->get();

    if ($ambildata->num_rows() > 0) {
        foreach ($ambildata->result() as $data) {
            // Assuming you want to return the 'tmpegawai_id' as a string
            return $data->id_user;
        }
    }

    // Return a default value or handle the case when no data is found
    return "Not found";
}

function keterangan($id) {
    $otherdb = $this->load->database('otherdb', TRUE);
    $ambildata = $otherdb->select('turunan_kbli')
        ->from('oss_persetujuanpermohonan')
        ->where('id', $id)
        ->get();

    if ($ambildata->num_rows() > 0) {
        foreach ($ambildata->result() as $data) {
            // Assuming you want to return the 'tmpegawai_id' as a string
            return $data->turunan_kbli;
        }
    }

    // Return a default value or handle the case when no data is found
    return "Not found";
}

function created_date($id) {
    $otherdb = $this->load->database('otherdb', TRUE);
    $ambildata = $otherdb->select('created')
        ->from('oss_persetujuanpermohonan')
        ->where('id', $id)
        ->get();

    if ($ambildata->num_rows() > 0) {
        foreach ($ambildata->result() as $data) {
            // Assuming you want to return the 'tmpegawai_id' as a string
            return $data->created;
        }
    }

    // Return a default value or handle the case when no data is found
    return "Not found";
}

function get_tmpegawai_n_pegawai($id) {
    $otherdb = $this->load->database('otherdb', TRUE);
    $ambildata = $otherdb->select('n_pegawai')
        ->from('tmpegawai')
        ->where('id', $id)
        ->get();

    if ($ambildata->num_rows() > 0) {
        foreach ($ambildata->result() as $data) {
            // Assuming you want to return the 'tmpegawai_id' as a string
            return $data->n_pegawai;
        }
    }

    // Return a default value or handle the case when no data is found
    return "Not found";
}

}
?>