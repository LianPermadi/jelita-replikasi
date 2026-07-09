<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller { 
  
  public function __construct(){
    parent::__construct();
    $this->load->model("absensi_model");
  }
  
  public function index($id = NULL){
    $hashedPassword = base64_decode($id);
    // echo $hashedPassword;die();
    
    if(!empty($id)){
      $kegiatan = $this->absensi_model->get_kegiatan($id);
      $data['kegiatan'] 	= $kegiatan;
      $data['namampp'] 	= $this->absensi_model->get_namampp();
      $data['user'] = $this->absensi_model->get_user();
      $this->load->view('index', $data);
    }else{
      $message = "Data Kegiatan Tidak Terpilih";
      $status_code = 400;
      $heading = "Error";
      show_error($message, $status_code, $heading);
    }
  }
  
  public function test($id = NULL){
    $short_url = md5($id);
    if(!empty($id)) {
      $kegiatan = $this->absensi_model->get_kegiatan($id);
      $data['kegiatan'] 	= $kegiatan;
      $data['namampp'] 	= $this->absensi_model->get_namampp();
      $this->load->view('index', $data);
    }else{
      $message = "Data Kegiatan Tidak Terpilih";
      $status_code = 400;
      $heading = "Error";
      show_error($message, $status_code, $heading);
    }
  }
  
  public function save(){
    $kegiatan 	= $this->input->post('idkegiatan');
    $nama       = $this->input->post('nama');
    $gender     = $this->input->post('gender');
    $instansi   = $this->input->post('instansi');
    $jabatan   = $this->input->post('jabatan');
    $email      = $this->input->post('email');
    $handphone  = $this->input->post('telepon');
    if($this->input->post('namakab') == "Lainnya"){
      $kabupaten  = $this->input->post('kablain');
    }else{
      $kabupaten  = $this->input->post('namakab');
    }
    $signed     = $this->input->post('signed');
    $gcaptcha 	= $this->input->post('g-recaptcha-response');
    //Proses Google reCaptcha
    if(!$gcaptcha){
      $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
      redirect('/absensi/index/'.$kegiatan);
    }
    
    $secretKey = "6LdIHikeAAAAAPXCIZOvaLjubK00hM7U7DLlpPqa";
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($gcaptcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    if($responseKeys["success"]) { //Jika captcha berhasil
      $simpan = $this->absensi_model->save($kegiatan, $nama, $gender, $instansi, $email, $handphone, $kabupaten, $jabatan);
      if($simpan != 0){
        if(!empty($signed)){
          $folderPath = $_SERVER['DOCUMENT_ROOT'].'/kehadiran/uploads/';
          $image_parts = explode(";base64,", $signed);
          $image_type_aux = explode("image/", $image_parts[0]); 
          $image_type = $image_type_aux[1];
          $image_base64 = base64_decode($image_parts[1]);
          $file = $folderPath . $simpan . '.'.$image_type;
          if(file_put_contents($file, $image_base64)) {
            $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
            redirect('/absensi/info/'.$kegiatan);
          }else{
            $this->session->set_flashdata('error', "Terjadi kesalahan, server tidak merespon, silahkan mengulangi pengisian data.");
            redirect('/absensi/info/'.$kegiatan);
          }
        }else{
          $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
          redirect('/absensi/info/'.$kegiatan);
        }
      }else{
        $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
        redirect('/absensi/info/'.$kegiatan);
      }
    }else{
      $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
      redirect('/absensi/info/'.$kegiatan);
    }
    //End Proses Google reCaptcha
  }
  
  public function info($id = NULL){
    if(!empty($id)){
      $kegiatan = $this->absensi_model->get_kegiatan($id);
      $data['kegiatan']   = $kegiatan;
      $data['namampp']    = $this->absensi_model->get_namampp();
      $this->load->view('info', $data);
    }else{
      $message = "Data Kegiatan Tidak Terpilih";
      $status_code = 400;
      $heading = "Error";
      show_error($message, $status_code, $heading);
    }
  }
}