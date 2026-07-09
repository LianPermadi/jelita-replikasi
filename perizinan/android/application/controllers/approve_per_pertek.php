<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_per_pertek extends CI_Controller {

  public function index(){
    $userid =  $this->session->userdata('id');
    $this->load->model('m_approve_per_pertek');
    $data['hasilakdp_cetak'] = $this->m_approve_per_pertek->ambildata($userid);
    $now = date("Y-m-d");
    $tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
    $tg2 = date("Y-m-d");
    $data['tgl1'] = '';
    $data['tgl2'] = '';
    $data['no_surat'] = '';
    $this->load->view('v_approve_per_pertek', $data);
  }

  function preview($id=NULL){
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.no_surat,tmsurat_keluar.tgl_surat');
    $otherdb->from('tmsurat_keluar');
    $otherdb->where('tmsurat_keluar.id',$id);
    $ambildata =  $otherdb->get();
    foreach($ambildata->result() as $row) {
    	$no_surat = $row->no_surat;
      $tgl_surat = $row->tgl_surat;
    }
    $i_urut = strlen($no_surat);
    $bcno_urut_pertek = $no_surat;
    for($i = 5; $i > $i_urut; $i--) {
      $bcno_urut_pertek = "0" . $bcno_urut_pertek;
    }
    $cod_bar_thn = $bcno_urut_pertek.date("Y",strtotime($tgl_surat));
    $n_file = $cod_bar_thn.'.pdf';
    $data['id'] = $id;
    $data['n_file'] = 'PT_'.$n_file;
    $data['n_file_draft'] = 'PTDRAFT_'.$n_file;
    $data['no_surat'] = $no_surat;
    $data['tgl_surat'] = $tgl_surat;
    // var_dump($_SERVER);die();
    $this->load->view('v_preview_per_pertek',$data);
  }
	
  public function cari_data_surat(){
    $userid =  $this->session->userdata('id');
    $no_surat = $this->input->post('no_surat');
    //echo $userid.' | ' .$no_surat; die;
    $data['no_surat'] = $no_surat;
    $this->load->model('m_approve_per_pertek');
    $data['hasilakdp_cetak'] = $this->m_approve_per_pertek->caridata_surat($no_surat,$userid);
    $this->load->view('v_approve_per_pertek', $data);
  }

  function update_multiple($iduser=NULL) {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $hitung = count($update);
    $passphrase = $this->input->post('passphrase');
    $angka = 0;

    if($this->input->post('msg') == null){
      redirect('approve_per_pertek/pesan_approve');
    }else{
      $this->load->model('m_approve_per_pertek');
      for ($i=0; $i < $hitung; $i++) { 
        $model = $this->m_approve_per_pertek->update_permohonan($iduser, $update[$i], $passphrase);
        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
        //$this->session->set_flashdata('success', 'OK');
        redirect('approve_per_pertek/pesan_suksesesign');
      } else {
        redirect('approve_per_pertek/pesan_permohonanesign');
      }
      
    }
  }
  
  /*
	public function detail($id){
    $this->load->model('m_approve_per_pertek');
    $data['detail_cetak'] = $this->m_approve_per_pertek->detail_data($id);
    $this->load->view('v_detail_akdp', $data);
  }
	*/
	
  public function detail_permohonan($id){
    $this->load->model('m_approve_per_pertek');
    $data['detail_cetak'] = $this->m_approve_per_pertek->detail_datapermohonan($id);
    $this->load->view('v_detail_per_pertek', $data);
  }
  
  /*
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
      redirect('approve_per_pertek/index');
    }else{
      //echo "Berhasil di Send!";
      redirect('approve_per_pertek/index');
    }
  }
  */
  
  /*
  function revisi_approve($id_permohonan){	
    $data['id']	= $id_permohonan;
    $this->load->model('m_approve_per_pertek');
    $data['kode_tmsk']= $this->m_approve_per_pertek->ambil_tmsk($id_permohonan);
    $this->load->view('v_revisi_approve',$data);
  }
  */
  
  /*
  function update_revisi(){
    $id = $this->input->post('id');
    $msg_revisi = $this->input->post('msg_revisi');
    $kode = $this->input->post('kode_tmsk');
    $this->load->model('m_approve_per_pertek');
    $this->m_approve_per_pertek->update_revisi($id,$msg_revisi,$kode);
    redirect('approve_per_pertek/index');
  }
  */
  
  /*
  function tes_watermark($no_pendaftaran){
    $data['no_pendaftaran'] = $no_pendaftaran; 
    $this->load->view('testfile',$data);
  }
  */
  
  /*
  public function list_approve(){
    $userid =  $this->session->userdata('id');
    $this->load->model('m_approve_per_pertek');
    $data['hasilakdp_cetak'] = $this->m_approve_per_pertek->list_approve($userid);
    $data['tg1'] = date("Y-m-d");;
    $data['tg2'] = date("Y-m-d");
    $this->load->view('v_listapprove_permohonan', $data);
  }
	*/
	
	/*
  public function cari_list_approve(){
    $userid =  $this->session->userdata('id');
    $tg1 = date("Y-m-d",strtotime($this->input->post('tg1')));
    $tg2 = date("Y-m-d",strtotime($this->input->post('tg2')));
    $this->load->model('m_approve_per_pertek');
    $data['hasilakdp_cetak'] = $this->m_approve_per_pertek->cari_list_approve($userid,$tg1,$tg2);
    $data['tg1'] = $tg1;
    $data['tg2'] = $tg2;
    $this->load->view('v_listapprove_permohonan', $data);
  }
  */

    function pesan_suksesesign(){
    $this->load->view('v_pesan_approveesign_sukses_per_pertek');
  }
  
  
  function pesan_permohonanesign(){
    $this->load->view('v_pesan_approveesign_per_pertek');
  }
  
  function pesan_approve(){
    $this->load->view('v_pesan_approve_per_pertek');
  }
}