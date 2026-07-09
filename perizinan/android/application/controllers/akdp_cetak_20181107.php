<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akdp_cetak extends CI_Controller {

	public function index()
	{
		
		$userid =  $this->session->userdata('id');
		$data['no_kend'] = '';
		$this->load->model('m_akdp_cetak');
		$data['hasilakdp_cetak'] = $this->m_akdp_cetak->ambildata($userid);
		$now = date("Y-m-d");
		$tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
		$tg2 = date("Y-m-d");
		$data['tgl1'] = '';
		$data['tgl2'] = '';
		$this->load->view('v_akdp_cetak', $data);
	}

	public function cari_data()
	{
		$userid =  $this->session->userdata('id');
		$post1 = str_replace(',', '', ($this->input->post('tgl1')));
		$post2 = str_replace(',', '', ($this->input->post('tgl2')));
		$tg1 = date("Y-m-d",strtotime($post1));
		$tg2 = date("Y-m-d",strtotime($post2));
		$data['tgl1'] = $tg1;
		$data['tgl2'] = $tg2;
		$this->load->model('m_akdp_cetak');
		$data['hasilakdp_cetak'] = $this->m_akdp_cetak->caridata($tg1,$tg2,$userid);
		$this->load->view('v_akdp_cetak', $data);
	}
	function update_multiple($iduser) {
		$iduser = $this->input->post('id');
		$submit = $this->input->post('submit');
		$no_sk = $this->input->post('no_sk');
		$tgl_penetapan = $this->input->post('tgl_penetapan');
		$tgl_penetapan_kp = $this->input->post('tgl_penetapan_kp');
		$no_kend = $this->input->post('no_kend');
		$akdpkendaraan_id = $this->input->post('akdpkendaraan_id');
		$update = $this->input->post('msg');
		if($this->input->post('msg')== null){
		redirect('akdp_cetak/pesan_approve');
		}else{
			for ($i=0; $i < count($update) ; $i++) { 
				$id = $update[$i];
			}
		$this->load->model('m_akdp_cetak');
		
			if($submit == 'Revisi'){
				$url = 'akdp_cetak/revisi/?akdpkendaraan_id='.$akdpkendaraan_id.'&id='.$id;
				redirect($url);
			}else if($submit == 'Approve'){
		$this->m_akdp_cetak->update_akdp_cetak($iduser);
		$u_ser = $this->session->userdata('nama');
		$username = '';
		redirect('akdp_cetak/index');
			}else if($submit == 'Proses'){
		$this->m_akdp_cetak->update_akdp_cetak($iduser);
		$u_ser = $this->session->userdata('nama');
		$username = '';
		redirect('akdp_cetak/index');
			}
		}
	}

	public function cari_data_no_mobil()
	{
		$userid =  $this->session->userdata('id');
		$no_kend = $this->input->post('no_kend');
		$data['no_kend'] = $no_kend;
		$this->load->model('m_akdp_cetak');
		$data['hasilakdp_cetak'] = $this->m_akdp_cetak->caridata_nokend($no_kend,$userid);
		$this->load->view('v_akdp_cetak', $data);
	}

	function pesan(){
		$data['pesan'] = 'tes';
		$this->load->view('v_pesan',$data);
	}

	function notifikasi(){
		$iduser =  $this->session->userdata('id');
		$n_judul = 'Pemberitahuan Approve AKDP';
			if ($iduser	== 175){
					$statmail = 1;
					$cek_mail = 1;
					$n_email = 'mrinamutmainah@yahoo.com';//mrinamutmainah@yahoo.com
					$n_pesan = 'Assalamualikum <br><br>Mohon segera cek proses Approve AKDP <br>Data telah diproses sebelumnya .<br>Terima Kasih<br><br>Wassalamualikum';
				}else if($iduser == 176){
					$statmail = 1;
					$cek_mail = 1;
					$n_email = 'dadang_mohamad@yahoo.com';//dadang_mohamad@yahoo.com
					$n_pesan = 'Assalamualikum<br><br>Mohon segera cek proses Approve AKDP <br>Data telah diproses sebelumnya<br>Terima Kasih<br><br>Wassalamualikum';
				}
					$targetpengiriman =	$n_email;
					$n_pesan = 'Assalamualikum <br><br>Mohon segera cek proses Approve AKDP <br>Data telah diproses sebelumnya<br>Terima Kasih<br><br>Wassalamualikum';

					if($statmail == '1' && $cek_mail == 1){ // Kirim mail
	        $host             =	"smtp.gmail.com";
        	$emailpengirim    =	"dpmptspkaltara@gmail.com"; 
    		$namapengirim     =	"DPMPTSP JABAR";
    		$password         =	"~dpmptspkaltaraprovgoid#"; //"~bpmptkaltaraprovgoid#";
    	    
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
                redirect('akdp_cetak/index');
            } else {
                //echo "Berhasil di Send!";
				redirect('akdp_cetak/index');
            }
		}else{
			redirect('akdp_cetak/index');
		}

	}
	
	function revisi(){
		$this->load->view('v_revisi');
	}

	function update_revisi(){
		$id = $this->input->post('id');
		$msg_revisi = $this->input->post('msg_revisi');
		$akdpkendaraan_id = $this->input->post('akdpkendaraan_id');
		$this->load->model('m_akdp_cetak');
		$this->m_akdp_cetak->update_revisi($id,$akdpkendaraan_id,$msg_revisi);
		redirect('akdp_cetak/index');
	}
	function pesan_esign(){	
		$this->load->view('v_pesan_esignakdp');
	}
	function pesan_approve(){
		$this->load->view('v_pesan_approveakdp');
	}

}