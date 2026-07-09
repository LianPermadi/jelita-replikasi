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
class Formulir extends MY_Controller {

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
		redirect('main/formulir/step1', 'refresh');
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
		
		
		$data['title']				= "Download Formulir";
		$data['load']			= "formulir/step1";
		$data['perizinan']	= $query;
		$data['data']			= $query2;
        $this->load->view('template_user',$data);
	
	}
	
    function step2($id) {
	
		$username	= $this->session->userdata("username");
		$session		= $this->session->userdata("userlogin");
		$id=htmlspecialchars($id,ENT_QUOTES);
		
		if(empty($session)){
			redirect('main/login', 'refresh');
			die;
		}
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		$sektor = $otherdb->get_where("trsektor",array("id"=>$id))->first_row();
		
		if(count($sektor)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Data Bidang Perizinan Tidak Ditemukan');
			redirect('main/formulir/step1', 'refresh');
		
		}
		
		$query	= $otherdb->query("select * from trperizinan where id in(select trperizinan_id from trperizinan_trsektor where trsektor_id='".$id."')")->result();
		
		if(count($sektor)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, Tidak Ada Data Perizinan Ditemukan');
			redirect('main/formulir/step1', 'refresh');
		
		}
		
		$query2	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
		
		$data['title']				= "Download Formulir";
		$data['load']			= "formulir/step2";
		$data['perizinan']	= $query;
		$data['data']			= $query2;
		$data['sektor']			= $sektor->n_sektor;
        $this->load->view('template_user',$data);
    
	}
	
    function step3($id) {
	
		$username		= $this->session->userdata("username");
		$session			= $this->session->userdata("userlogin");
		$id		= htmlspecialchars($id,ENT_QUOTES);
		
		$otherdb	= $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
		
		if(empty($session)){
			redirect('main/login', 'refresh');
		}
		
		if(!isset($id)){
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
			redirect('main/formulir/step1', 'refresh');
			die;
		}
		
		$sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
		$sektor = $otherdb->query($sql)->first_row();
		
		$sql 	= "select * from trperizinan where id='".$id."'";
		$query	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, perizinan tidak ditemukan');
			redirect('main/formulir/step1', 'refresh');

		}
		
		$sql 		=	"select trsyarat_perizinan.* 
							from trsyarat_perizinan 
							where trsyarat_perizinan.id IN(select 
								trsyarat_perizinan_id 
								from trperizinan_trsyarat_perizinan 
								where trperizinan_id='".$id."' and status='1')";
		$query 	= $otherdb->query($sql)->result();
		
		if(count($query)==0){
		
			$this->session->set_flashdata('error', 'Terjadi Kesalahan, data persyaratan tidak ditemukan');
			redirect('main/formulir/step2'/$sektor->id, 'refresh');
			die;
		
		}
		
		$judul	= $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
		
		$data['title'] 				= "Download Formulir";
		$data['load'] 				= "formulir/step3";
		$data['syarat']				= $query;
		$data['judul'] 				= $judul;
		$data['id'] 					= $id;
		$data['sektor'] 					= $sektor;
        $this->load->view('template_user',$data);
    }
	
	
}

?>
