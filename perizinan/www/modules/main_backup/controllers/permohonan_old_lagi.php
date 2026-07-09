<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Permohonan extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->tm_pemohon = new Tm_pemohon();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $detect = $this->load->library('Mobile_Detect');
        if ($detect->isMobile()) {
            $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
            $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];


            $base_url = base_url();
            $xx = explode('/', $base_url);
            $x = 0;
            $jumlah_url_1 = count($xx) - 1;
            $jumlah_url = count($xx);
            $url_mobile = NULL;
            foreach ($xx as $apl_mobile_url) {
                $x++;

                if ($jumlah_url_1 == $x) {
                    
                } elseif ($jumlah_url == $x) {
                    
                } else {
                    if ($x == 1) {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '//';
                    } elseif ($x == 2) {
                        
                    } else {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '/';
                    }
                }
            }

            redirect($url_mobile."alp_mobile");
        }
    }

	
	function index(){
	
		redirect('main/permohonan/step1', 'refresh');
		
	}
	
	function step1(){
	
		$username	= $this->session->userdata("username");
		$session		= $this->session->userdata("userlogin");
		
		if(empty($session)){
			redirect('main/login', 'refresh');
			die;
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$otherdb->order_by("urutan","asc");
		$query	= $otherdb->query("select * from trsektor")->result();
		
		$query2	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		$data['title']				= "Permohonan Perizinan";
		$data['load']			= "permohonan/step1";
		$data['perizinan']	= $query;
		$data['data']			= $query2;
        $this->load->view('template_user',$data);
	
	}
	
    function step2($id) {
	
		$username	= $this->session->userdata("username");
		$session		= $this->session->userdata("userlogin");
		
		if(empty($session)){
			redirect('main/login', 'refresh');
			die;
		}
		
		$query	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		if($query->data=="0" || $query->dokumen=="0"){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		$id	= htmlspecialchars($id,ENT_QUOTES);
		
		if(empty($id)){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$sektor = $otherdb->get_where("trsektor",array("id"=>$id))->first_row();
		
		if(count($sektor)==0){
			
			$this->session->set_flashdata('error', "Terjadi kesalahan, mohon mengulangi proses perizinan");
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		$query	= $otherdb->query("select * from trperizinan where id  in(select trperizinan_id from trperizinan_trsektor where trsektor_id='".$id."')")->result();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', "Data Perizinan Tidak Ditemukan Dalam Bidang ".$sektor->n_sektor);
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		$query2	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		$data['title']				= "Permohonan Perizinan";
		$data['load']			= "permohonan/step2";
		$data['bidang']	= $sektor->n_sektor;
		$data['perizinan']	= $query;
		$data['data']			= $query2;
        $this->load->view('template_user',$data);
    
	}
	
    function step3($id) {
	
		$username	= $this->session->userdata("username");
		$session		= $this->session->userdata("userlogin");
		
		if(empty($session)){
			redirect('main/login', 'refresh');
			die;
		}
		
		$query	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		if($query->data=="0" || $query->dokumen=="0"){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		$id	= htmlspecialchars($id,ENT_QUOTES);
		
		if(empty($id)){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$sql		= "select * from trperizinan where id='".$id."'";
		$query	= $otherdb->query($sql)->row_array();
		
		if(count($query)==0){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		$sql = "select * from trperizinan_trsektor where trperizinan_id=".$id."";
		$sektor = $otherdb->query($sql)->first_row();
		
		$sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
		$sektor2 = $otherdb->query($sql)->first_row();
		
		$properti = count($query);
		
		$judul	= $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
		
		$data['title']			= "Permohonan Perizinan";
		$data['load']		= "permohonan/step3";
		$data['property']	= $query;
		$data['id']			= $id;
		$data['id_sektor'] = $sektor->trsektor_id;
		$data['sektor'] = $sektor2->n_sektor;
		$data['jml']			= $properti;
		$data['judul']			= $judul;
        $this->load->view('template_user',$data);
    }

    function step4($id) {
	
		$username		= $this->session->userdata("username");
		$session			= $this->session->userdata("userlogin");
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		if(empty($_POST)){
			redirect('main/permohonan/step1', 'refresh');
		}
		
		if(!isset($id)){
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		$jml_property	= htmlspecialchars($_POST['jml_properti'],ENT_QUOTES);
		
		$id		= htmlspecialchars($id,ENT_QUOTES);
		
		$sql 	= "select * from trperizinan where id='".$id."'";
		$query	= $otherdb->query($sql)->row_array();
		
		if($jml_property>0){
			
			 $array_properti = array();
			 
			$no=1;
			while($no<=$jml_property){
			
				$tek = "var_teknis".$no;
				// $stat = "status_".$no;
				
				// $status = htmlspecialchars($_POST[$stat],ENT_QUOTES);
				// if($status=="Ya"){
					$prop = $query[$tek];
					
					
					if(empty($prop)){
						break;
					}
					
					$array = explode("^",$prop);
					
					// $array_properti[]	= array("var_teknis".$no, $_POST["var_teknis".$no],"Ya");
					$array_properti[]	= array("var_teknis".$no, $_POST["var_teknis".$no]);
				// }else{
					
					// $array_properti[]	= array("var_teknis".$no, "","Tidak");
				// }
				$no++;
			}
			
		}
		
		$query				= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		$id_pemohon	= $query->id;
		
		if($query->data=="0" || $query->dokumen=="0"){
		
			redirect('main/permohonan/step1', 'refresh');
			
		}
		
		$sql 	= "select * from trperizinan where id='".$id."'";
		$query	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			redirect('main/permohonan/step1', 'refresh');

		}
		
		$sql 		=	"select trsyarat_perizinan.* 
							from trsyarat_perizinan 
							where trsyarat_perizinan.id IN(select 
								trsyarat_perizinan_id 
								from trperizinan_trsyarat_perizinan 
								where trperizinan_id='".$id."' and status='1')";
		$query 	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			redirect('main/permohonan/step1', 'refresh');
			die;
		
		}
		
		$judul	= $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
		
		if($jml_property>0){
			
			$data['array_properti']	=	$array_properti;
			
		}
		
		$user		=	$this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
		$syarat	=	$this->db->get_where("tm_pemohon_persyaratan",array("id_pemohon"=>$user->id))->result();
		
		$array	=	array();
		foreach($syarat as $sya){
			
			array_push($array,$sya->id_persyaratan);
			
		}
		
		
		$sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
		$sektor = $otherdb->query($sql)->first_row();
		
		$data['title'] 				= "Permohonan Perizinan Step 2";
		$data['load'] 				= "permohonan/step4";
		$data['syarat']				= $query;
		$data['sektor']				= $sektor->n_sektor;
		$data['judul'] 				= $judul;
		$data['id'] 					= $id;
		$data['user_id'] 			= $user->id;
		$data['id_pemohon']	= $id_pemohon;
		$data['jml'] 					= $jml_property;
		$data['array_syarat'] 	= $array;
        $this->load->view('template_user',$data);
    }
	
	
	function addpermohonanbaru(){
		
		$session		= $this->session->userdata("userlogin");
		$username	= $this->session->userdata("username");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		if(empty($_POST)){
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		if(empty($_POST["tanggung_jawab"])){
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		$tanggung_jawab	=	htmlspecialchars($_POST['tanggung_jawab'],ENT_QUOTES);
		
		if($tanggung_jawab!="on"){
			
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses permohonan');
			redirect('main/permohonan/step1', 'refresh');
			
		}
		
		$lokasi_izin		=	htmlspecialchars($_POST['lokasi_izin'],ENT_QUOTES);
		$jml_properti		=	htmlspecialchars($_POST['jml_properti'],ENT_QUOTES);
		$id					=	htmlspecialchars($_POST['id'],ENT_QUOTES);
		$user				= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		$jenis				= $user->jenis;
		
		///////////////////////// Input permohonan baru
		
		$data = array(
		   'id_pemohon'	=> $user->id,
		   'id_perizinan'	=> $id,
		   'd_entry' 			=> date("Y-m-d h-i-s"),
		   'lokasi_izin'		=> $lokasi_izin,
		);
		
		if($this->db->insert('tmpermohonan_portal',$data)){
		
		///////////////////////// Input permohonan baru
		
			
			/////////////////////// Retrive data permohonan yang baru dimasukkan
			
			$eksis	= $this->db->query("select * from tmpermohonan_portal where id_pemohon=".$user->id." order by id desc")->first_row();
			
			/////////////////////// Retrive data permohonan yang baru dimasukkan
			
			
			/////////////////////// Assign path penyimpanan file persyaratan
			
			$path 			= "assets/userassets/pemohon/".$user->username."/pengajuan/".$eksis->id;
			
			/////////////////////// Assign path penyimpanan file persyaratan
			
		
			//////////////////  fungsi input persyaratan ////////////////////////////////
			
				
				//////////////////////// retrive persyaratan dibutuhkan
				
					$sql 		=	"select trsyarat_perizinan.* 
										from trsyarat_perizinan 
										where trsyarat_perizinan.id IN(select 
											trsyarat_perizinan_id 
											from trperizinan_trsyarat_perizinan 
											where trperizinan_id='".$id."' and status='1')";
					$query 	= $otherdb->query($sql)->result();
				
				//////////////////////// retrive persyaratan dibutuhkan
				
				
				////////////////////// Cek type file
					
					foreach($query as $syarat){
					
						
						////////////////////////// mengecek ekstensi file dan upload atau tidak
						
						if(!empty($_FILES["file_".$syarat->id]["name"])){
						
							$temp	= explode(".",$_FILES["file_".$syarat->id]["name"]); // get file ekstensi
							
							if(end($temp)!="pdf"){
								
								$this->db->delete('tmpermohonan_portal', array('id' => $eksis->id)); 
								
								$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
								redirect('main/permohonan/step1', 'refresh');
							
							}
						}
						
						if(empty($_FILES["file_".$syarat->id]["name"])){
						
							$this->db->delete('tmpermohonan_portal', array('id' => $eksis->id)); 
								
							$this->session->set_flashdata('error', 'Terjadi Kesalahan, mengunggah semua dokumen persyaratan');
							redirect('main/permohonan/step1', 'refresh');
						
						}
						
						////////////////////////// mengecek ekstensi file dan upload atau tidak
						
						
					}
					
				////////////////////// Cek type file
				
				
				////////////////////// bikin folder untuk file persyaratan
				
					if(!is_dir($path)) //create the folder if it's not already exists
					{
					  mkdir($path,0755,TRUE);
					} 
				
				////////////////////// bikin folder untuk file persyaratan
				

				////////////////////// input ke table & upload file
				
					foreach($query as $syarat){
						
						
						///////////////////////////// input data persyaratan ke persyaratan permohonan

						$teknis	= htmlspecialchars($_POST["teknis".$syarat->id]);
						
						if(!empty($_FILES["file_".$syarat->id]["name"]))
						{
							$data = array(
							   'tmpermohonan_id'		=> $eksis->id,
							   'trsyarat_perizinan_id'	=> $syarat->id,
							   'nama_file' 					=> $syarat->id.".pdf",
							   'nomor_surat'				=> $_POST["nomor_surat_".$syarat->id]
							);
							
							if(!empty($_POST["tanggal_".$syarat->id])){
							
							   $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
							
							}
							
							if(!empty($_POST["masa_berlaku_".$syarat->id])){
							
							   $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
							
							}
						}

						if($this->db->insert('tmpermohonan_trsyarat_perizinan',$data)){
						
						///////////////////////////// input data persyaratan ke persyaratan permohonan
						
							// $string = str_replace(' ', '-', $syarat->v_syarat); // Replaces all spaces with hyphens.
							// $string = str_replace('/', '-atau-', $string); // Replaces all spaces with hyphens.
							// $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
							// $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
							// $string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.
							
							
							///////////////////// assign nama file & direktori upload
							
							$file	=	$syarat->id.".pdf";
							
							$dir2=$path."/";
							
							///////////////////// assign nama file & direktori upload
							
							
							//////////////////// upload file pengajuan
							
							$data = array(
									"id_pemohon" 	=> $user->id,
									"id_persyaratan" => $syarat->id,
									"nomor_surat"		=> $_POST["nomor_surat_".$syarat->id]
								);
								
								if(!empty($_POST["tanggal_".$syarat->id])){
							
							   $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
							
								}
								
								if(!empty($_POST["masa_berlaku_".$syarat->id])){
								
								   $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
								
								}
									
								$this->db->insert("tm_pemohon_persyaratan",$data);
								
								$lokasi=$_FILES['file_'.$syarat->id]['tmp_name'];
								move_uploaded_file($lokasi,$dir2.$file);
							
							//////////////////// upload file pengajuan
							
						}
					}
					
				////////////////////// input ke table & upload file
			
			
			//////////////////  fungsi input persyaratan ////////////////////////////////
			
			
			///////////////// fungsi input properti ///////////////////////
			
			if($jml_properti>0){
				
				$sql 	= "select * from trperizinan where id='".$id."'";
				$query	= $otherdb->query($sql)->row_array();
				
				$array_properti = array();
			 
				$no	= 1;
				while($no<=$jml_properti){
				
					$tek		= "var_teknis".$no;
					// $stat		= "stat_".$no;
					
					// $status = htmlspecialchars($_POST[$stat],ENT_QUOTES);
					
					// $prop	= $query[$tek];
					
					// if(empty($prop)){
						// break;
					// }
					
					// $array	= explode("^",$prop);
					
					// $array_properti[]	= array("var_teknis".$no, $_POST["var_teknis".$no]);
					// if($status=="Ya"){
						$data	= array(
						   'dt_teknis'.$no 	=> htmlspecialchars($_POST['var_teknis'.$no],ENT_QUOTES)."^-",
						);
						
						$this->db->where('id', $eksis->id);
						
						$this->db->update('tmpermohonan_portal', $data); 
					// }
					
					$no++;
				}
				
			}
			
			///////////////// fungsi input properti ///////////////////////
			
			
			////////////////////   Input ke database back office
			
			$lasdata		= $otherdb->query("select * from tmpemohon_portal order by id desc")->first_row();
			$perizinan	= $otherdb->query("select * from trperizinan where id=".$id."")->first_row();
			
			if($jenis=="pemohon"){
				
				$data	= array(
				   'namaPemohon'				=> $user->namaPerusahaan,
				   'id_pemohon'					=> $user->id,
				   'id_permohonan_portal'	=> $eksis->id,
				   'referensi'						=> $user->ktpPerusahaan,
				   'telpPemohon'					=> $user->telpPerusahaan,
				   'almtPemohon'				=> $user->almtPerusahaan,
				   'propinsi1'						=> $user->propinsi2,
				   'kabupaten1'					=> $user->kabupaten2,
				   'kecamatan1'					=> $user->kecamatan2,
				   'kelurahan1'					=> $user->kelurahan2,
				   'almtPerusahaan'				=> $user->almtPerusahaan,
				   'propinsi2'						=> $user->propinsi2,
				   'kabupaten2'					=> $user->kabupaten2,
				   'kecamatan2'					=> $user->kecamatan2,
				   'kelurahan2'					=> $user->kelurahan2,
				   'tglPermohonan'				=> date("Y-m-d"),
				   'izin'								=> $id,
				   'urut'								=> $lasdata->urut+1,
				   'isi_izin'							=> $perizinan->n_perizinan,
				   'lokasi_izin'						=> $lokasi_izin,
				   'perantara'						=> $user->telpPemohon." - ".$user->namaPemohon,
				);
				
			}
			
			if($jenis=="perusahaan"){
			
				$data	= array(
				   'namaPemohon'				=> $user->nama_penanggung_jawab,
				   'id_pemohon'					=> $user->id,
				   'id_permohonan_portal'	=> $eksis->id,
				   'referensi'							=> $user->ktpPemohon,
				   'telpPemohon'					=> $user->telpPerusahaan,
				   'telpPerusahaan'				=> $user->telp_penanggung_jawab,
				   'almtPemohon'					=> $user->almtPemohon,
				   'propinsi1'							=> $user->propinsi1,
				   'kabupaten1'					=> $user->kabupaten1,
				   'kecamatan1'					=> $user->kecamatan1,
				   'kelurahan1'						=> $user->kelurahan1,
				   'npwpPerusahaan'			=> $user->npwpPerusahaan,
				   'regPerusahaan'				=> $user->regPerusahaan,
				   'namaPerusahaan'			=> $user->namaPerusahaan,
				   'emailPerusahaan'			=> $user->emailPemohon,
				   'faxPerusahaan'				=> $user->faxPerusahaan,
				   'almtPerusahaan'				=> $user->almtPerusahaan,
				   'tglPermohonan'				=> date("Y-m-d"),
				   'propinsi2'							=> $user->propinsi2,
				   'kabupaten2'					=> $user->kabupaten2,
				   'kecamatan2'					=> $user->kecamatan2,
				   'kelurahan2'						=> $user->kelurahan2,
				   'izin'									=> $id,
				   'urut'									=> $lasdata->urut+1,
				   'isi_izin'								=> $perizinan->n_perizinan,
				   'lokasi_izin'						=> $lokasi_izin,
				   'perantara'						=> $user->telpPemohon." - ".$user->namaPemohon,
				);
				
			}
			
			$otherdb->insert("tmpemohon_portal",$data);
			
			////////////////////   Input ke database back office
			
			
		}
		
		$this->session->set_flashdata('success', 'Berhasil Mengajuakan Permohonan');
		redirect('main/permohonan/success', 'refresh');
	}
	
	public function editpermohonanbaru(){
	
		$session		= $this->session->userdata("userlogin");
		$username	= $this->session->userdata("username");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		if(empty($_POST)){
			redirect('main/permohonan/step1', 'refresh');
			die;
		}
		
		$uuid				= htmlspecialchars($_POST['uuid'],ENT_QUOTES);
		$user_id			= htmlspecialchars($_POST['user_id'],ENT_QUOTES);
		$id_perizinan	= htmlspecialchars($_POST['id'],ENT_QUOTES);
		
		$user				= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		$permohonan	= $this->db->get_where("tmpermohonan_portal",array('uuid'=>$uuid))->first_row();
		
		if(count($permohonan)==0){
		
			redirect('main/user/permohonan', 'refresh');
			die;
		
		}
		
		$path 			= "assets/userassets/pemohon/".$user->username."/pengajuan/".$permohonan->id."/";
		
		$sql 		=	"select trsyarat_perizinan.* 
							from trsyarat_perizinan 
							where trsyarat_perizinan.id IN(select 
								trsyarat_perizinan_id 
								from trperizinan_trsyarat_perizinan 
								where trperizinan_id='".$id_perizinan."')";
		
		$query 			= $otherdb->query($sql)->result();
		$ada_upload	= 0;
		
		foreach($query as $syarat){
			
			if(!empty($_FILES["file_".$syarat->id]["name"])){
				$ada_upload=1;
				$temp	= explode(".",$_FILES["file_".$syarat->id]["name"]); // get file ekstensi
				
				if(end($temp)!="pdf"){
					
					$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
					redirect('main/permohonan/detail/'.$uuid, 'refresh');
				
				}
				
				$data = array(
				   'nomor_surat'		=> $_POST["nomor_surat_".$syarat->id],
				);
				
				$data['tanggal_surat'] = null;
				
				if(!empty($_POST["tanggal_".$syarat->id])){
				
				   $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
				
				}
				
				$data['masa_berlaku_surat'] = null;
				
				if(!empty($_POST["masa_berlaku_".$syarat->id])){
				
				   $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
				
				}
				
				$this->db->where('tmpermohonan_id', $permohonan->id);
				$this->db->where('trsyarat_perizinan_id', $syarat->id);
				if($this->db->update('tmpermohonan_trsyarat_perizinan', $data)){
					
					unlink($path.$syarat->id.".pdf");
					$file = $syarat->id.".pdf";
					$lokasi=$_FILES['file_'.$syarat->id]['tmp_name'];
					move_uploaded_file($lokasi,$path.$file);
					
				}else{
					
					$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
					redirect('main/permohonan/detail/'.$uuid, 'refresh');
				
				}
				
			}			
			////////////////////////// jika mengupload file persyaratan, mengecek ekstensi file	
		}
		
		if($ada_upload==0){
			
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Anda tidak mengunggah file apapun');
			redirect('main/permohonan/detail/'.$uuid, 'refresh');
		
		}
		
		if($ada_upload==1){
			
			$data = array(
			   'editable'		=> "0",
			);
			
			$this->db->where('id', $permohonan->id);
			$this->db->update('tmpermohonan_portal', $data);
		
		}
		
		
		$this->session->set_flashdata('success', 'Persyaratan berhasil diubah');
		redirect('main/permohonan/detail/'.$uuid, 'refresh');
	
	}
	
	function success(){
	
		$session		= $this->session->userdata("userlogin");
		$username	= $this->session->userdata("username");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		
		$data['title']	= "Detail Permohonan Perizinan";
		$data['load']	= "permohonan/success";
        $this->load->view('template_user',$data);
		
	}
	
    function detail($uuid) {
		
		$uuid			=	htmlspecialchars($uuid,ENT_QUOTES);
		$session		= $this->session->userdata("userlogin");
		$username	= $this->session->userdata("username");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		$permohonan	=	$this->db->get_where("tmpermohonan_portal", array("uuid"=>$uuid))->first_row();
		
		if(count($permohonan)==0){
			
			$this->session->set_flashdata('error', 'Data Tidak Ditemukan');
			redirect('main/user/permohonan/', 'refresh');

		}
		
		$belakang = $otherdb->get_where("tmpemohon_portal",array('id_permohonan_portal'=>$permohonan->id))->first_row();
		
		////////////// kalau harus edit
		if($permohonan->editable=="1" && count($belakang)>0){
		
			$sql 	= "select * from trperizinan where id='".$permohonan->id_perizinan."'";
			$query	= $otherdb->query($sql)->first_row();
			
			if(count($query)==0){
			
				redirect('main/permohonan/step1', 'refresh');

			}
	
			$judul	= $query->n_perizinan;
			
			$sql 		=	"select trsyarat_perizinan.* 
								from trsyarat_perizinan 
								where trsyarat_perizinan.id IN(select 
									trsyarat_perizinan_id 
									from trperizinan_trsyarat_perizinan 
									where trperizinan_id='".$permohonan->id_perizinan."' and status='1')";
			$query 	= $otherdb->query($sql)->result();
			
			if(count($query)==0){
			
				redirect('main/permohonan/step1', 'refresh');
				die;
			
			}
			
			$user		=	$this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
			$asistensi	= $this->db->get_where("asistensi",array("id_permohonan"=>$permohonan->id))->result();
			
			$data['title']					= "Ubah Syarat Permohonan Izin";
			$data['load']					= "permohonan/edit";
			$data['judul']					= $judul;
			$data['id'] 						= $permohonan->id_perizinan;
			$data['uuid'] 						= $permohonan->uuid;
			$data['user_id'] 				= $user->id;
			$data['pemohon']				= $user->namaPerusahaan;
			$data['username']			= $username;
			$data['permohonan']			= $permohonan;
			$data['syarat']				= $query;
			$data['asistensi']				= $asistensi;
			return $this->load->view('template_user',$data);
			// die;
		}
		/////////////// kalau harus edit
		
		$sql 	= "select * from trperizinan where id='".$permohonan->id_perizinan."'";
		$nama	= $otherdb->query($sql)->first_row();
			
		$sql 		=	"select trsyarat_perizinan.* 
							from trsyarat_perizinan 
							where trsyarat_perizinan.id IN(select 
								trsyarat_perizinan_id 
								from trperizinan_trsyarat_perizinan 
								where trperizinan_id='".$permohonan->id_perizinan."' and status='1')";
		$query 	= $otherdb->query($sql)->result();
			
		$status	= "Online";
		$track = 0;
		
		if(!empty($permohonan->no_permohonan)){
		
			$databackoffice	= $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$permohonan->no_permohonan))->first_row();
			
			if(count($databackoffice)==1){
			
				$stats	= $otherdb->get_where("tmpermohonan_trstspermohonan",array("tmpermohonan_id"=>$databackoffice->id))->first_row();
				
				$stat	= $otherdb->get_where("trstspermohonan",array("id"=>$stats->trstspermohonan_id))->first_row();
				
				if(count($stat)!=0){
						
					$status = $stat->n_sts_permohonan_2;
					
				}	
			}else{
				$status = "Ditolak";
			}
				
				$track	=	$otherdb->order_by("id","desc");
				$track	=	$otherdb->get_where("tmtrackingperizinan", array("pendaftaran_id"=>$permohonan->no_permohonan))->result();
		}else{
			
			$belakang = $otherdb->get_where("tmpemohon_portal",array('id_permohonan_portal'=>$permohonan->id))->first_row();
			
			if(count($belakang)==0){
				
				$status =  "Ditolak";
				
			}	
		
		}
		
		$asistensi	= $this->db->get_where("asistensi",array("id_permohonan"=>$permohonan->id))->result();
		$user		=	$this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
		
		$data['title']						= "Detail Permohonan Perizinan";
		$data['load']					= "permohonan/detail";
		$data['nama']					= $nama->n_perizinan;
		$data['username']			= $username;
		$data['pemohon']				= $user->namaPerusahaan;
		$data['permohonan']		= $permohonan;
		$data['persyaratan']		= $query;
		$data['status']					= $status;
		$data['track']					= $track;
		$data['asistensi']					= $asistensi;
		$data['belakang']				= count($belakang);
        $this->load->view('template_user',$data);
    }
	
	function addasistensi(){
	
		$session		= $this->session->userdata("userlogin");
		$username	= $this->session->userdata("username");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		if(empty($_POST)){
			redirect('main/user/permohonan/', 'refresh');
		}
		
		$uuid			= htmlspecialchars($_POST['uuid'],ENT_QUOTES);
		$pesan		= htmlspecialchars($_POST['pesan'],ENT_QUOTES);
		$pemohon	= htmlspecialchars($_POST['pemohon'],ENT_QUOTES);
		
		$permohonan = $this->db->get_where("tmpermohonan_portal",array("uuid"=>$uuid))->first_row();
		
		if(count($permohonan)==0){
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/user/permohonan/', 'refresh');
		}
		
		
		$data = array(
		   'id_permohonan'	=> $permohonan->id,
		   'oleh'					=> $pemohon,
		   'pesan' 				=> $pesan
		);
		
		if($this->db->insert('asistensi',$data)){
		
			$this->session->set_flashdata('success', 'Pesan Anda Telah Terkirim');
			redirect('main/permohonan/detail/'.$uuid, 'refresh');
		
		}else{
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/permohonan/detail/'.$uuid, 'refresh');
		
		}
		
	}
	
}

?>
