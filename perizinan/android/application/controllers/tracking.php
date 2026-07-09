<?php 
	class Tracking extends CI_Controller {
		
		function index() {
			$input = htmlspecialchars($_POST['no_permohonan'],ENT_QUOTES);
			$permohonan = $this->db->get_where("tmpermohonan_portal", array("no_permohonan"=>$input))->first_row();
			$otherdb = $this->load->database('otherdb',TRUE);
			$belakang = $otherdb->get_where("tmpermohonan", array('pendaftaran_id'=>$input))->first_row();
			
			if(count($permohonan)==0) {
				if(count($belakang)==0) {
					$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
					redirect('cekmohon', 'refresh');
				}else{  // Jika Ditemukan
					$sql = "select * from tmpermohonan_trperizinan where tmpermohonan_id=".$belakang->id."";
					$data_perizinan = $otherdb->query($sql)->first_row();
					
					$sql = "select * from trperizinan where id='".$data_perizinan->trperizinan_id."'";
					$nama = $otherdb->query($sql)->first_row();

					$sql = "select * from tmpemohon_tmpermohonan where tmpermohonan_id = '".$belakang->id."'";
					$pemohon_id = $otherdb->query($sql)->first_row();

					$sql = "select * from tmpemohon where id = '".$pemohon_id->tmpemohon_id."'";
					$pemohon = $otherdb->query($sql)->first_row();

					$sql = "select trsyarat_perizinan.* from trsyarat_perizinan 
					        where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan
							where trperizinan_id='".$data_perizinan->trperizinan_id."' and status='1')";

					$query = $otherdb->query($sql)->result();

					$track = 0;
					$asistensi = 0;
					$status = $belakang->status_berkas;
                    if($belakang->status_berkas == 'proses') {
    					switch ($belakang->kd_status) {
                 			case 0:  $status = 'Pendaftaran Izin (FO)';         break;
                            case 1:  $status = 'Entry Data';                    break; 
                            case 2:  $status = 'Penjadualan Tinjauan Lapangan'; break;
                            case 3:  $status = 'Entri Hasil Tinjauan';          break;
		    	            case 4:  $status = 'Penyusunan BAP';                break;
                			case 5:  $status = 'Penetapan';                     break;
			                case 6:  $status = 'Izin Ditetapkan';               break;
                 			case 7:  $status = 'Berkas Izin Dicetak';           break;
                 			case 8:  $status = 'Berkas Siap Diserahkan';        break;
		    	            case 9:  $status = 'Berkas Sudah Diserahkan';       break;
                            default: $status = '-';                             break;
                        }
                    }
					$stats = $otherdb->get_where("tmpermohonan_trstspermohonan", array("tmpermohonan_id"=>$belakang->id))->first_row();
					//$stat = $otherdb->get_where("tmpermohonan", array("id"=>$stats->trstspermohonan_id))->first_row();

					//if(count($stat)!=0) {
					//	$status = $stat->n_sts_permohonan_2;
					//}

					$track = $otherdb->order_by("id","desc");
					$track = $otherdb->get_where("tmtrackingperizinan", array("pendaftaran_id"=>$belakang->pendaftaran_id))->result();
					
					$asistensi = 0;
					
					$data['title'] 			= "Detail Permohonan Perizinan";
					$data['load'] 			= "nologin/detail";
					$data['nm_pemohon'] 	= $pemohon->n_pemohon;
					$data['nama'] 			= $nama->n_perizinan;
					$data['no_permohonan'] 	= $belakang->pendaftaran_id;
					$data['d_entry'] 		= $belakang->d_entry;
					$data['status'] 		= $status;
					$data['track'] 			= $track;
					$data['asistensi'] 		= $asistensi;
					$data['belakang'] 		= count($belakang);
					
					return $this->load->view('v_detail', $data);
					die;
				}
			}else{
    			if($permohonan->editable=="1" && count($belakang)>0) {
    				$sql = "select * from trperizinan where id='".$permohonan->id_perizinan."'";
    				$query = $otherdb->query($sql)->first_row();
	    			if(count($query)==0) {
		    			redirect('cekmohon', 'refresh');
			    	}
    				$status = "membutuhkan revisi";
	    			$judul = $query->n_perizinan;
		    	}
    			$sql = "select * from trperizinan where id='".$permohonan->id_perizinan."'";
	    		$nama = $otherdb->query($sql)->first_row();

		    	$sql = "select trsyarat_perizinan.* from trsyarat_perizinan
    					where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan
						where trperizinan_id='".$permohonan->id_perizinan."' and status='1')";

    			$query = $otherdb->query($sql)->result();

	    		$status = "Online";
		    	$track = 0;

			    if(!empty($permohonan->no_permohonan)) {
				    $databackoffice = $otherdb->get_where("tmpermohonan", array("pendaftaran_id"=>$permohonan->no_permohonan))->first_row();
    				if(count($databackoffice)==1) {
	    				$stats = $otherdb->get_where("tmpermohonan_trstspermohonan", array("tmpermohonan_id"=>$databackoffice->id))->first_row();
    					$stat = $otherdb->get_where("tmpermohonan", array("id"=>$stats->trstspermohonan_id))->first_row();
    					if(count($stat)!=0) {
	    					$status = $stat->n_sts_permohonan_2;
		    			}
			    	} else {
				    	$status = "Ditolak";
    				}
    				$track = $otherdb->order_by("id","desc");
	    			$track = $otherdb->get_where("tmtrackingperizinan", array("pendaftaran_id"=>$permohonan->no_permohonan))->result();
    			} else {
    				$belakang = $otherdb->get_where("tmpermohonan_portal", array('id_permohonan_portal'=>$permohonan->id))->first_row();
    				if(count($belakang)==0) {
	    				$status = "Ditolak";
		    		}
			    }

    			$asistensi = $this->db->get_where("asistensi", array("id_permohonan"=>$permohonan->id))->result();
				$data['title'] 			= "Detail Permohonan Perizinan";
	    		$data['load'] 			= "nologin/detail";
				$data['nm_pemohon'] 	= '-';
		    	$data['nama'] 			= $nama->n_perizinan;
        		$data['no_permohonan'] 	= $permohonan->no_permohonan;
		    	$data['d_entry'] 		= $permohonan->d_entry;
			    $data['status'] 		= $status;
    			$data['track'] 			= $track;
	    		$data['asistensi'] 		= $asistensi;
		    	$data['belakang'] 		= count($belakang);
    			return $this->load->view('v_detail', $data);
	    		die;
			}
		}
	}
?>