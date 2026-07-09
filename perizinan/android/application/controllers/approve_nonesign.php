<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_nonesign extends CI_Controller {

	public function index()
	{
		
        $userid =  $this->session->userdata('id');

		$this->load->model('m_approve_nonesign');
		$data['hasilakdp_cetak'] = $this->m_approve_nonesign->ambildata($userid);
		$now = date("Y-m-d");
		$tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
		$tg2 = date("Y-m-d");

		$data['tgl1'] = '';
		$data['tgl2'] = '';

$data['no_pendaftaran'] = '';
		$this->load->view('v_approve_nonesign', $data);
	}

	public function cari_data()
	{
		//$iduser = $this->input->post('id');
		$userid =  $this->session->userdata('id');
		$post1 = str_replace(',', '', ($this->input->post('tgl1')));
		$post2 = str_replace(',', '', ($this->input->post('tgl2')));


		$tg1 = date("Y-m-d",strtotime($post1));
		$tg2 = date("Y-m-d",strtotime($post2));
			$data['tgl1'] = $tg1;
		$data['tgl2'] = $tg2;
		$this->load->model('m_approve_nonesign');
		$data['hasilakdp_cetak'] = $this->m_approve_nonesign->caridata($tg1,$tg2,$userid);

		$this->load->view('v_approve_nonesign', $data);
	}
	function update_multiple_edit($iduser) {
			$iduser = $this->input->post('id');
			$u_ser = $this->session->userdata('nama');
			$this->load->model('m_approve_nonesign');

			//$data['hasilemail'] = $this->m_approve_nonesign->update_permohonanemail($iduser);
			
			$this->m_approve_nonesign->update_permohonan($iduser);
			
		//$username = new user();
		$username = '';
		$this->load->view('v_email', $data);
		
	}
		function update_multiple($iduser) {
			$iduser = $this->input->post('id');
			if($this->input->post('msg')== null){
		redirect('approve_nonesign/pesan_approve');
		}else{
			$this->load->model('m_approve_nonesign');
			$this->m_approve_nonesign->update_permohonan($iduser);
			redirect('approve_nonesign/index');
		}
	}

	public function detail($id)
	{
		

		$this->load->model('m_approve_nonesign');
		$data['detail_cetak'] = $this->m_approve_nonesign->detail_data($id);
		$this->load->view('v_detail_akdp', $data);
	}
	public function detail_permohonan($id)
	{
		

		$this->load->model('m_approve_nonesign');
		$data['detail_cetak'] = $this->m_approve_nonesign->detail_datapermohonan($id);
		$this->load->view('v_detail_permohonannonesign', $data);
	}

	public function cari_data_no_pendaftaran()
	{
		//$iduser = $this->input->post('id');
		$userid =  $this->session->userdata('id');
		$no_pendaftaran = $this->input->post('no_pendaftaran');
		
			$data['no_pendaftaran'] = $no_pendaftaran;
		
		
		$this->load->model('m_approve_nonesign');
		$data['hasilakdp_cetak'] = $this->m_approve_nonesign->caridata_no_pendaftaran($no_pendaftaran,$userid);

		$this->load->view('v_approve_nonesign', $data);
	}
function notifikasi(){
		$tujuanemail = $this->input->post('email');
		$n_judul = 'Pemberitahuan Approve Permohonan';
		$n_pesan = 'Assalamualikum<br><br>Mohon segera cek proses Approve permohonan <br>Data telah diproses sebelumnya <br>Pada tanggal : '.date("Y-m-d") . ' '. date("h:i:sa").'<br>Terima Kasih<br><br>Wassalamualikum';
		$host             =	"smtp.gmail.com";
        	$emailpengirim    =	"dpmptspkabtsm@gmail.com"; 
    		$namapengirim     =	"DPMPTSP KAB TASIKMALAYA";
    		$password         =	"irmaruhyati"; 
    	    $targetpengiriman =	$tujuanemail;
    	    
        	require("assets/plugins/phpmailer/class.phpmailer.php");
        	require("assets/plugins/phpmailer/class.smtp.php");
    		$mailer = new PHPMailer();
    		$mailer->CharSet = "UTF-8";
    	    $mailer->IsSMTP();
			$mailer->SMTPDebug = 2;
        	$mailer->SMTPSecure = 'tls';
        	$mailer->Host =$host;
    		$mailer->Port =587;
    		$mailer->SMTPAuth = true;
    	    $mailer->Username = $emailpengirim;
        	$mailer->Password = $password;
        	$mailer->FromName = $namapengirim;
    		$mailer->From     = $emailpengirim;
    		$mailer->AddAddress($targetpengiriman,$targetpengiriman);
    	    //Isi Data untuk e-mail
        	$mailer->Subject = $n_judul;
			$isi = $n_pesan;
    	    $mailer->Body = $isi;
   		    $mailer->AltBody = $isi;
            //$mailer->Send();
			if (!$mailer->send()) {
                //echo "Ada Yang Error Gan: " . $mailer->ErrorInfo;
                redirect('approve_nonesign/index');
            } else {
                //echo "Berhasil di Send!";
				redirect('approve_nonesign/index');
            }
	}
	function revisi_approve($id_permohonan){	
	$data['id']	= $id_permohonan;
	$this->load->model('m_approve_nonesign');
	$data['kode_tmsk']= $this->m_approve_nonesign->ambil_tmsk($id_permohonan);

	$this->load->view('v_revisi_approve',$data);
	}
	function update_revisi(){
		$id = $this->input->post('id');
		$msg_revisi = $this->input->post('msg_revisi');
		$kode = $this->input->post('kode_tmsk');
		$this->load->model('m_approve_nonesign');
		$this->m_approve_nonesign->update_revisi($id,$msg_revisi,$kode);

		redirect('approve_nonesign/index');
	}
function preview($pendaftaran_id,$no_id){
		$data['no_pendaftaran'] = $pendaftaran_id;
		$data['no_id'] = $no_id;
		$this->load->view('v_previewnonesign',$data);
	}
function tes_watermark($no_pendaftaran){
$data['no_pendaftaran'] = $no_pendaftaran; 
$this->load->view('testfile',$data);

}

public function list_approve()
	{
		
        $userid =  $this->session->userdata('id');

		$this->load->model('m_approve_nonesign');
		$data['hasilakdp_cetak'] = $this->m_approve_nonesign->list_approve($userid);
		//$now = date("Y-m-d");
		//$tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
		//$tg2 = date("Y-m-d");
		$data['tg1'] = date("Y-m-d");;
		$data['tg2'] = date("Y-m-d");
		$this->load->view('v_listapprove_nonesign', $data);
	}
	
	public function cari_list_approve()
	{
		
        $userid =  $this->session->userdata('id');
		$tg1 = date("Y-m-d",strtotime($this->input->post('tg1')));
		$tg2 = date("Y-m-d",strtotime($this->input->post('tg2')));
		$this->load->model('m_approve_nonesign');
		$data['hasilakdp_cetak'] = $this->m_approve_nonesign->cari_list_approve($userid,$tg1,$tg2);
		//$now = date("Y-m-d");
		//$tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
		//$tg2 = date("Y-m-d");
		$data['tg1'] = $tg1;
		$data['tg2'] = $tg2;
		$this->load->view('v_listapprove_nonesign', $data);
	}

	function pesan_esign(){
		
		$this->load->view('v_pesan_esign');
	}
	function pesan_approve(){
		
		$this->load->view('v_pesan_approvenonesign');
	}
}