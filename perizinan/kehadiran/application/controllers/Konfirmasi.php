<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasi extends CI_Controller { 

	public function __construct()
    {
        parent::__construct();
        $this->load->model("absensi_model");
    }

	public function index()
	{	
		$data['namampp'] = $this->absensi_model->get_namampp();
		$this->load->view('konfirm', $data);
	}

	public function save() {
	    $nama       = $this->input->post('nama');
	    $instansi   = $this->input->post('instansi');
	    $email      = $this->input->post('email');
	    $handphone  = $this->input->post('telepon');
	    if ($this->input->post('namakab') == "Lainnya") {
            $kabupaten  = $this->input->post('kablain');
        } else {
            $kabupaten  = $this->input->post('namakab');
        }

	    $gcaptcha 	= $this->input->post('g-recaptcha-response');
        //Proses Google reCaptcha
        if (!$gcaptcha) {
            $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
            redirect('konfirmasi');
        }

        $secretKey = "6LdIHikeAAAAAPXCIZOvaLjubK00hM7U7DLlpPqa";

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($gcaptcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);

        if($responseKeys["success"]) { //Jika captcha berhasil
        	$simpan = $this->absensi_model->save_konfirm($nama, $instansi, $email, $handphone, $kabupaten);

        	if ($simpan != 0) {
                $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
                redirect('konfirmasi');
        	} else {
        		$this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
            	redirect('konfirmasi');
        	}
        } else {
        	$this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
            redirect('konfirmasi');
        }
        //End Proses Google reCaptcha
	}
}
