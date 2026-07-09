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
class Upload_Formulir extends MY_Controller {

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
	
		$session	= $this->session->userdata("formulir");
		
		if(!empty($session)){
			
			redirect('main/upload_formulir/step1', 'refresh');
			
		}
		
		$data['title']		= "Login";
		$data['load']		= "login_formulir";
        $this->load->view('template_login',$data);
		
	}
	
	function dologin(){
	
		$session	= $this->session->userdata("formulir");
		
		if(!empty($session)){
			
			redirect('main/upload_formulir/step1', 'refresh');
			
		}
		
		if(empty($_POST['username']) || empty($_POST['password'])){
			
			redirect('main/upload_formulir/', 'refresh');
			
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
	
		$username	=	htmlspecialchars($_POST['username'],ENT_QUOTES);
		$password	=	md5(htmlspecialchars($_POST['password'],ENT_QUOTES));
		
		$query	= $otherdb->get_where('user', array('username' => $username,'group'=>'1'))->first_row();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Username Tidak Terdaftar Pada Sistem');
			redirect('main/upload_formulir/', 'refresh');
			
		}
		
		$query	= $otherdb->get_where('user', array('username' => $username,'password' => $password ,'group'=>'1'))->first_row();
		
		if(count($query)==0){
			
			$this->session->set_flashdata('error', 'Username dan Password Tidak Sesuai');
			redirect('main/upload_formulir/', 'refresh');
			
		}
		
		if(count($query)==1){
			
			$newdata	= array(
                   'formulir'	=> $username,
                   // 'jenis'     	=> $query->jenis,
                   // 'nama'     		=> $query->nama_pemohon
               );

			$this->session->set_userdata($newdata);
			
			redirect('main/upload_formulir/step1', 'refresh');
			
		}
		
	}
	
	
    function logout() {
		
		$this->session->unset_userdata('formulir');
		
		redirect('main/upload_formulir/', 'refresh');
    }

	function step1(){
	
		$session		= $this->session->userdata("formulir");
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
			// die;
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$query	= $otherdb->query('select * from trsektor')->result();
		
		
		$data['title']				= "Upload Formulir";
		$data['load']			= "upload_formulir/step1";
		$data['perizinan']	= $query;
        $this->load->view('template_formulir',$data);
		
	}
		
    function step2($id) {
	
		$session		= $this->session->userdata("formulir");
		$id = htmlspecialchars($id,ENT_QUOTES);
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
			// die;
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$sektor = $otherdb->get_where("trsektor",array("id"=>$id))->first_row();
		
		if(count($sektor)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Data Bidang Perizinan Tidak Ditemukan');
			redirect('main/upload_formulir/step1', 'refresh');
		
		}
		
		$query	= $otherdb->query("select * from trperizinan where id in(select trperizinan_id from trperizinan_trsektor where trsektor_id='".$id."')")->result();
		
		if(count($sektor)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Tidak Ada Data Perizinan Ditemukan');
			redirect('main/upload_formulir/step1', 'refresh');
		
		}
		
		
		$data['title']				= "Upload Formulir";
		$data['load']			= "upload_formulir/step2";
		$data['perizinan']	= $query;
		$data['sektor']	= $sektor;
        $this->load->view('template_formulir',$data);
    
	}
	
    function step3($id) {
	
		$session			= $this->session->userdata("formulir");
		
		$id		= htmlspecialchars($id,ENT_QUOTES);
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
		}
		
		if(!isset($id)){
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step1', 'refresh');
			die;
		}
		
		$sql 	= "select * from trperizinan where id='".$id."'";
		$query	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, perizinan tidak ditemukan');
			redirect('main/upload_formulir/step1', 'refresh');

		}
		
		$sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
		$sektor = $otherdb->query($sql)->first_row();
		
		
		$sql 		=	"select trsyarat_perizinan.* 
							from trsyarat_perizinan 
							where trsyarat_perizinan.id IN(select 
								trsyarat_perizinan_id 
								from trperizinan_trsyarat_perizinan 
								where trperizinan_id='".$id."' and status='1')";
		$query 	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, data persyaratan tidak ditemukan');
			redirect('main/upload_formulir/step1', 'refresh');
			die;
		
		}
		
		$judul	= $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
		
		$data['title'] 				= "Upload Formulir";
		$data['load'] 				= "upload_formulir/step3";
		$data['syarat']			= $query;
		$data['judul'] 				= $judul;
		$data['id'] 					= $id;
		$data['sektor'] 					= $sektor;
        $this->load->view('template_formulir',$data);
    }
	
	function doupload(){
		
		$session			= $this->session->userdata("formulir");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
		}
		
		if(empty($_POST)){
			redirect('main/upload_formulir/step1', 'refresh');
		}
		
		$id_syarat 		= htmlspecialchars($_POST['id_syarat'],ENT_QUOTES);
		$id_perizinan	= htmlspecialchars($_POST['id_perizinan'],ENT_QUOTES);
		
		$temp	= explode(".",$_FILES["formulir"]["name"]); // get file ekstensi
							
		if(end($temp)!="pdf"){
			
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
		
		}
		
		$path	= "assets/userassets/formulir/";
		
		$file = $_FILES["formulir"]["name"];
		$string = str_replace('.pdf', '', $file); // Replaces all spaces with hyphens.
		$string = str_replace('.', '_', $string); // Replaces all spaces with hyphens.
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = str_replace('/', '-atau-', $string); // Replaces all spaces with hyphens.
		// $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		$string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
		$string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.
		$string.= ".pdf";
		
		$sql = "SELECT * FROM `trsyarat_perizinan` WHERE nama_formulir like '%".str_replace(".pdf","",$string)."%'";
		$cari_nama = $otherdb->query($sql)->result();
		
		
		if(count($cari_nama)>0){
			
			$no = count($cari_nama)+1;
			$string = str_replace('.pdf', '', $string); // Replaces all spaces with hyphens.
			$string.= "_".$no;
			$string.=".pdf";
		
		}
		
		$cari	= $otherdb->get_where("trsyarat_perizinan",array("id"=>$id_syarat))->first_row();
		
		if($cari->formulir=="1"){
			
			unlink($path.$cari->nama_formulir);
			
		}
		
		$data = array(
			"formulir" 			=> "1",
			"nama_formulir"	=> $string
		);
		
		$otherdb->where('id', $id_syarat);
		$update = $otherdb->update('trsyarat_perizinan', $data); 
		
		if($update){
			
			$lokasi=$_FILES["formulir"]["tmp_name"];
			move_uploaded_file($lokasi,$path.$string);
			
			$this->session->set_flashdata('success', 'Formulir persyaratan berhasil diupload');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
			
		}else{
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
		}
		
	}
	
	function hapus($id_perizinan,$id_syarat){
	
		$session			= $this->session->userdata("formulir");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
		}
		
		$id_syarat		= htmlspecialchars($id_syarat,ENT_QUOTES);
		$id_perizinan	= htmlspecialchars($id_perizinan,ENT_QUOTES);
		
		$cari	= $otherdb->get_where("trsyarat_perizinan",array("id"=>$id_syarat))->first_row();
		
		$cari2	= $otherdb->get_where("trperizinan",array("id"=>$id_perizinan))->first_row();
		
		if(count($cari2)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step1', 'refresh');
		
		}
		
		if(count($cari)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
		
		}
		
		$data['title'] 				= "Hapus Formulir";
		$data['load'] 				= "upload_formulir/hapus";
		$data['syarat']			= $cari;
		$data['id_perizinan']		= $id_perizinan;
        $this->load->view('template_formulir',$data);
		
	}
	
	function dodelete(){
	
		$session			= $this->session->userdata("formulir");
		$otherdb		= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/upload_formulir/', 'refresh');
		}
		
		$id_syarat		= htmlspecialchars($_POST['id_persyaratan'],ENT_QUOTES);
		$id_perizinan	= htmlspecialchars($_POST['id_perizinan'],ENT_QUOTES);
		
		
		$cari	= $otherdb->get_where("trsyarat_perizinan",array("id"=>$id_syarat))->first_row();
		
		$cari2	= $otherdb->get_where("trperizinan",array("id"=>$id_perizinan))->first_row();
		
		if(count($cari2)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step1', 'refresh');
		
		}
		
		if(count($cari)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
		
		}
		
		$data = array(
			"formulir" 			=> "0",
			"nama_formulir"	=> null
		);
		
		$otherdb->where('id', $id_syarat);
		$update = $otherdb->update('trsyarat_perizinan', $data); 
		
		if($update){
			
			$path	= "assets/userassets/formulir/";
			unlink($path.$cari->nama_formulir);
			$this->session->set_flashdata('success', 'Formulir persyaratan berhasil dihapus');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
			
		}else{
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/upload_formulir/step2/'.$id_perizinan, 'refresh');
		}
		
	}
}
?>
