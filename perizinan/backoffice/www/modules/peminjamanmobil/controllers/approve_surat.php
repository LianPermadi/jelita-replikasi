<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve_surat extends WRC_AdminCont {
  public function __construct() {
      parent::__construct();
      $this->load->model('m_approve_surat');
      $this->load->model('m_mobil');
        $this->load->library('upload');
        $base_url = base_url();
        $this->All = FALSE;
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

  public function pencabutan() {
    $userid =  $this->session->userdata('id');
    
    $data['data_surat'] = $this->m_approve_surat->ambilcabut($userid);
    
    $now = date("Y-m-d");
    $tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
    $tg2 = date("Y-m-d");
    $data['tgl1'] = '';
    $data['tgl2'] = '';
    $data['no_surat'] = '';
    $this->load->view('v_approve_surat', $data);
  }

  public function penolakan() {
    $userid =  $this->session->userdata('id');
    
    $data['data_surat'] = $this->m_approve_surat->ambiltolak($userid);
    
    $now = date("Y-m-d");
    $tg1 = date('Y-m-d', strtotime($now . ' -5 day'));
    $tg2 = date("Y-m-d");
    $data['tgl1'] = '';
    $data['tgl2'] = '';
    $data['no_surat'] = '';
    $this->load->view('v_approve_surat', $data);
  }

  public function cari_data_surat(){
    $userid =  $this->session->userdata('id');
    $no_surat = $this->input->post('no_surat');
    $data['no_surat'] = $no_surat;
    $this->load->model('m_approve_surat');
    $data['data_surat'] = $this->m_approve_surat->caridata_surat($no_surat,$userid);
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
    $data['page'] = 'surat';
    $data['no_surat'] = $surat->nomor_surat;
    $data['tgl_surat'] = $surat->tgl_surat;
	  $data['id_ess2'] = $surat->ess2;
	  $data['id_sekdis'] = $surat->sekdis;
	  $data['id_ess3'] = $surat->ess3;
	  $data['id_ess4'] = $surat->ess4;
    $data['id_jfah'] = $surat->jfah;
    $data['analis_hukum'] = $surat->analis_hukum;
	  $data['id_konseptor'] = $surat->user_id;
    $this->load->view('v_preview_surat',$data);
  }

  public function preview_peminjaman_mobil($id) {
    $surat = $this->m_approve_surat->data_surat($id);
    if (empty($surat)) {
      $this->session->set_flashdata('gagal', 'Data Tidak Ditemukan.');
      redirect('approve_surat');
    }

    $n_file = $surat->id.".pdf";
    
    $data['id'] = $surat->id;
    $data['n_file'] = 'SRT_'.$n_file;
    $data['n_file_draft'] = 'SRTDRAFT_'.$n_file;
    $data['page'] = 'mobil';
    $data['tgl_entry'] = $surat->tgl_entry;
    $data['no_surat'] = $surat->nomor_surat;
    $data['tgl_surat'] = $surat->tgl_surat;
	  $data['id_ess2'] = $surat->ess2;
	  $data['id_sekdis'] = $surat->sekdis;
	  $data['id_ess3'] = $surat->ess3;
	  $data['id_ess4'] = $surat->ess4;
    $data['id_jfah'] = $surat->jfah;
    $data['analis_hukum'] = $surat->analis_hukum;
	  $data['id_konseptor'] = $surat->user_id;
    $this->load->view('v_preview_surat',$data);
  }

  public function update_multiple() {
    
    // $iduser = $this->input->post('id_user');
    // $update = $this->input->post('msg');
    // $hitung = count($update);
    // $passphrase = base64_encode($this->input->post('passphrase'));
    // $angka = 0;

    // if(empty($this->input->post('msg'))){
    //   redirect('approve_surat/pesan_approve');
    // }else{
    //   $this->load->model('m_approve_surat');
    //   for ($i=0; $i < $hitung; $i++) {
    //   if ($iduser == "114") { //114 = lucky 443 Jonas
    //      $model = $this->m_approve_surat->update_permohonan2($iduser, $update[$i], $passphrase);
    //    } 
    //     $model = $this->m_approve_surat->update_permohonan($iduser, $update[$i], $passphrase);
    //     if ($model == 1) {
    //       $angka++;
    //     }
    //   }
    //   if ($hitung == $angka) {
    //     redirect('approve_surat/pesan_suksesesign');
    //   } else {
    //     redirect('approve_surat/pesan_permohonanesign');
    //   }
    // }
    
    $iduser = $this->input->post('id');
    if($this->input->post('msg')== null){
      redirect('approve_esign/pesan_approve');
    }else{
      $this->load->model('m_approve_esign');
      $this->m_approve_esign->update_permohonan($iduser);
      $this->session->set_flashdata('gagal', "Gagal Controller.");
      redirect('approve_esign/pesan_suksesesign');
    }
  }

  public function update_multiple_mobil() {
    $iduser = $this->input->post('id_user');
    // var_dump($iduser);die();
    $update = $this->input->post('msg');
    $hitung = count($update);
    $passphrase = base64_encode($this->input->post('passphrase'));
    $angka = 0;
    // var_dump($update);die();
    if(empty($this->input->post('msg'))){
      $this->session->set_flashdata('sukses', $this->input->post('msg'));
      redirect('peminjamanmobil/history_user');
    }else{
      $this->load->model('m_approve_surat');
      for ($i=0; $i < $hitung; $i++) {
      if ($iduser == "114") { //114 = lucky 443 Jonas
         $model = $this->m_approve_surat->update_permohonan2($iduser, $update[$i], $passphrase);
       } 
        $model = $this->m_approve_surat->update_permohonan($iduser, $update[$i], $passphrase);
        if ($model == 1) {
          $angka++;
        }
      }
      if ($hitung == $angka) {
        $sql = 'SELECT id_mobil
                FROM persuratan
                WHERE id = '.$update.' LIMIT 1 ';
        // var_dump($sql);die();
        $id_mobil = $this->m_mobil->id_peminjaman_mobil($update);
        // var_dump($id_mobil);die();
        // var_dump($id_mobil);die();
        $this->session->set_flashdata('sukses', "TTE berhasil");
        redirect('https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/approve/'.$id_mobil);
      } else {
        $this->session->set_flashdata('gagal', "Passphrase Tidak Sesuai !<br>Penanda Tanganan Dokumen Gagal<br>Silahkan Ulangi Proses Approve<br>");
        redirect('https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/history_user');
      }
    }
  }

  public function update_revisi() { 
    $id = $this->input->post('id');
    $msg = $this->input->post('msg_revisi');
    $ess = $this->m_approve_surat->get_eselon($this->session->userdata('id'));
    switch ($ess) {
      case 1:
        $esl = "sekdis";
        break;
      case 2:
        $esl = "ess II";
        break;
      case 3:
        $esl = "Koordinator"; //"ess III";
        break;
      case 4:
        $esl = "JF Ahmud"; //"ess IV";
        break;
      default:
        $esl = "";
        break;
    }
    $msg = $msg.' ('.$esl.' '.date("d-m-Y h:i:sa").')';
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
    $this->load->view('v_pesan_approveesign_surat');
  }

  function pesan_suksesesign() {
    $this->load->view('v_pesan_approveesign_sukses_surat');
  }
  
  function pesan_approve() {
    $this->load->view('v_pesan_approve_surat');
  }

  public function testqrcode() {
  	$this->load->library('cfpdf');
    $this->load->library('cfpdi');
    $pdf = new FPDI();

    $id = "1";
    $kepada = "Nirwan";

    $link = 'https://dpmptsp.jabarprov.go.id';
    $codeContents = $id.'/'.base64_encode($kepada);
    $codeContents = $link;//.'_idkeyST.'.$key;
    $fileName = 'iz_'.md5($codeContents).'.png';
  
    $filepdf = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/sktest/SRT_TEST.pdf';
    $filepdf2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/sktest/SRT_TEST_HASIL.pdf';
    
    try{
      $pageCount = $pdf->setSourceFile($filepdf);
      for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $size = array();
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage('P', array($size['w'], $size['h']));
            $img = base_url('assets/img/footer_bsre.png');
            $pdf->Image($img,30,310,165,12);

            $img2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/uploads/data_qrcode_naskah/'.$fileName;
            $pdf->Image($img2,15,310,12);
        $pdf->useTemplate($templateId);
      }
      $pdf->Output($filepdf2,'F');
    }
    catch (Exception $e) {
      //exception?
    }
  }

}