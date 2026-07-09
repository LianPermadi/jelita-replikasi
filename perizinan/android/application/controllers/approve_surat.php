<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_surat extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('m_approve_surat');
  }

  public function index() {
    $userid =  $this->session->userdata('id');
    
    $data['data_surat'] = $this->m_approve_surat->ambildata($userid);
    
    $now = date("Y-m-d");
    $tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
    $tg2 = date("Y-m-d");
    $data['tgl1'] = '';
    $data['tgl2'] = '';
    $data['no_surat'] = '';
    $this->load->view('v_approve_surat', $data);
  }

  public function preview($id) {
    $surat = $this->m_approve_surat->data_surat($id);

    if (empty($surat)) {
      $this->session->set_flashdata('gagal', 'Data Tidak Ditemukan.');
      redirect('approve_surat');
    }

    $n_file = $surat->id.".pdf";
    
    $data['id'] = $surat->id;
    $data['n_file'] = 'SRT_'.$n_file;
    $data['n_file_draft'] = 'SRTDRAFT_'.$n_file;
    $data['tgl_entry'] = $surat->tgl_entry;
    $data['no_surat'] = $surat->nomor_surat;
    $data['tgl_surat'] = $surat->tgl_surat;
	  $data['id_ess2'] = $surat->ess2;
	  $data['id_sekdis'] = $surat->sekdis;
	  $data['id_ess3'] = $surat->ess3;
	  $data['id_ess4'] = $surat->ess4;
	  $data['id_konseptor'] = $surat->user_id;
    $this->load->view('v_preview_surat',$data);
  }

  public function update_multiple() {
    $iduser = $this->input->post('id_user');
    $update = $this->input->post('msg');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $angka = 0;
    // var_dump($_SERVER);die();

    if(empty($this->input->post('msg'))){
      redirect('approve_surat/pesan_approve');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
      if ($iduser == "114") {
         $model = $this->m_approve_surat->update_permohonan($iduser, $update[$i], $passphrase);
       } 
        $model = $this->m_approve_surat->update_permohonan($iduser, $update[$i], $passphrase);
        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
        redirect('approve_surat/pesan_suksesesign');
      } else {
        redirect('approve_surat/pesan_permohonanesign');
      }
    }
  }

  public function update_revisi() {
    $id = $this->input->post('id');
    $msg = $this->input->post('msg_revisi');

    $simpan = $this->m_approve_surat->update_revisi($id, $msg);
    if ($simpan) {
      redirect('approve_surat');
    }
  }

  function revisi($id = NULL){
    $data['id'] = $id;
    $this->load->view('v_revisi_surat', $data);
  }
  
  function pesan_permohonanesign() {
    $this->load->view('v_pesan_approveesign');
  }

  function pesan_suksesesign() {
    $this->load->view('v_pesan_approveesign_sukses');
  }
  
  function pesan_approve() {
    $this->load->view('v_pesan_approve');
  }

  function tespath() {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $path_jar    = $root.'/spekta/android/assets/esign/signer/JSignPdf.jar';

    var_dump($path_jar);die;
  }

  function tesverif() {
    $n_file = 'SRT_121.pdf';

    $hasil = $this->m_approve_surat->cek_ttd($n_file);

    var_dump($hasil);die;

    if (strpos($hasil[0], 'DOCUMENT VALID !!!') !== false) {
      echo "Found";
    } else {
      echo "Not Found";
    }
    
  }

}