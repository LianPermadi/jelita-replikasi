<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_esign extends CI_Controller {

  public function index(){
    $userid =  $this->session->userdata('id');
    $this->load->model('m_approve_esign');
    $data['hasilakdp_cetak'] = $this->m_approve_esign->ambildata($userid);
    $now = date("Y-m-d");
    $tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
    $tg2 = date("Y-m-d");
    $data['tgl1'] = '';
    $data['tgl2'] = '';
    $data['no_pendaftaran'] = '';
    $this->load->view('v_approve_esign', $data);
  }

  public function cari_data(){
    $userid =  $this->session->userdata('id');
    $post1 = str_replace(',', '', ($this->input->post('tgl1')));
    $post2 = str_replace(',', '', ($this->input->post('tgl2')));
    $tg1 = date("Y-m-d",strtotime($post1));
    $tg2 = date("Y-m-d",strtotime($post2));
    $data['tgl1'] = $tg1;
    $data['tgl2'] = $tg2;
    $this->load->model('m_approve_esign');
    $data['hasilakdp_cetak'] = $this->m_approve_esign->caridata($tg1,$tg2,$userid);
    $this->load->view('v_approve_esign', $data);
  }
  
  function update_multiple_edit($iduser) {
    $iduser = $this->input->post('id');
    $u_ser = $this->session->userdata('nama');
    $this->load->model('m_approve_esign');
    $this->m_approve_esign->update_permohonan($iduser);
    $username = '';
    $this->load->view('v_email', $data);
  }
	
  function update_multiple($iduser) {
    $iduser = $this->input->post('id');
    if($this->input->post('msg')== null){
      redirect('approve_esign/pesan_approve');
    }else{
      $this->load->model('m_approve_esign');
      $this->m_approve_esign->update_permohonan($iduser);
      redirect('approve_esign/index');
    }
  }

	public function detail($id){
    $this->load->model('m_approve_esign');
    $data['detail_cetak'] = $this->m_approve_esign->detail_data($id);
    $this->load->view('v_detail_akdp', $data);
  }
	
  public function detail_permohonan($id){
    $this->load->model('m_approve_esign');
    $data['detail_cetak'] = $this->m_approve_esign->detail_datapermohonan($id);
    $this->load->view('v_detail_esign', $data);
  }

  public function cari_data_no_pendaftaran(){
    $userid =  $this->session->userdata('id');
    $no_pendaftaran = $this->input->post('no_pendaftaran');
    $data['no_pendaftaran'] = $no_pendaftaran;
    $this->load->model('m_approve_esign');
    $data['hasilakdp_cetak'] = $this->m_approve_esign->caridata_no_pendaftaran($no_pendaftaran,$userid);
    $this->load->view('v_approve_esign', $data);
  }
	
  function notifikasi(){
    $tujuanemail = $this->input->post('email');
    $n_judul = 'Pemberitahuan Approve Permohonan';
    $n_pesan = 'Assalamualikum<br><br>Mohon segera cek proses Approve permohonan <br>Data telah diproses sebelumnya <br>Pada tanggal : '.date("Y-m-d") . ' '. date("h:i:sa").'<br>Terima Kasih<br><br>Wassalamualikum';
    $host             =	"smtp.gmail.com";
    $emailpengirim    =	"dpmptspkaltara@gmail.com"; 
    $namapengirim     =	"DPMPTSP JABAR";
    $password         =	"~dpmptspkaltaraprovgoid#"; //"~bpmptkaltaraprovgoid#";
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
    if(!$mailer->send()) {
      //echo "Ada Yang Error Gan: " . $mailer->ErrorInfo;
      redirect('approve_esign/index');
    }else{
      //echo "Berhasil di Send!";
      redirect('approve_esign/index');
    }
  }

  function revisi_approve($id_permohonan){	
    $data['id']	= $id_permohonan;
    $this->load->model('m_approve_esign');
    $data['kode_tmsk']= $this->m_approve_esign->ambil_tmsk($id_permohonan);
    $this->load->view('v_revisi_approve',$data);
  }
  
  function update_revisi(){
    $id = $this->input->post('id');
    $msg_revisi = $this->input->post('msg_revisi');
    $kode = $this->input->post('kode_tmsk');
    $this->load->model('m_approve_esign');
    $this->m_approve_esign->update_revisi($id,$msg_revisi,$kode);
    redirect('approve_esign/index');
  }
  
  function preview($pendaftaran_id,$no_id){
    $data['no_pendaftaran'] = $pendaftaran_id;
    $data['no_id'] = $no_id;
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('trperizinan.kertas,trperizinan.kordinatttd,trperizinan.kordinatqr');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmpermohonan.pendaftaran_id',$pendaftaran_id);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $kordinatqr = $data3->kordinatqr;
      $kordinatttd = $data3->kordinatttd;
      $kertas = $data3->kertas;
    }
    $data['kordinatttd'] = $kordinatttd;
    $data['kordinatqr'] = $kordinatqr;
    $data['kertas'] = $kertas;
    $this->load->view('v_previewesign',$data);
  }
	
  function tes_watermark($no_pendaftaran){
    $data['no_pendaftaran'] = $no_pendaftaran; 
    $this->load->view('testfile',$data);
  }

  public function list_approve(){
    $userid =  $this->session->userdata('id');
    $this->load->model('m_approve_esign');
    $data['hasilakdp_cetak'] = $this->m_approve_esign->list_approve($userid);
    $data['tg1'] = date("Y-m-d");;
    $data['tg2'] = date("Y-m-d");
    $this->load->view('v_listapprove_permohonan', $data);
  }
	
  public function cari_list_approve(){
    $userid =  $this->session->userdata('id');
    $tg1 = date("Y-m-d",strtotime($this->input->post('tg1')));
    $tg2 = date("Y-m-d",strtotime($this->input->post('tg2')));
    $this->load->model('m_approve_esign');
    $data['hasilakdp_cetak'] = $this->m_approve_esign->cari_list_approve($userid,$tg1,$tg2);
    $data['tg1'] = $tg1;
    $data['tg2'] = $tg2;
    $this->load->view('v_listapprove_permohonan', $data);
  }
  
  function pesan_permohonanesign(){
    $this->load->view('v_pesan_approveesign');
  }
  
  function pesan_approve(){
    $this->load->view('v_pesan_approveesign2');
  }
}