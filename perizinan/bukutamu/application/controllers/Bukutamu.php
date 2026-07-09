<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bukutamu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("bukutamu_model");
        //$this->load->library('form_validation');
      //  $this->load->model("user_model");
		//if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
    }
    public function index($info = null)
    {   
 
         $data['list2'] = $this->bukutamu_model->get_sektor2();
         $data['namampp'] = $this->bukutamu_model->get_namampp();
        $this->load->view("index", $data);
    }
      public function tampil()
    {   

         $data['list2'] = $this->bukutamu_model->get_sektor2();
         $data['namampp'] = $this->bukutamu_model->get_namampp();
        $this->load->view("index", $data);
    }
    public function add(){
        
        $buku = $this->bukutamu_model;
        $simpan = $buku->save();
        if($simpan == false){
            $this->session->set_flashdata('success', 'Periksa Koneksi anda');
            header( "refresh:1;url=$protocol:///$domain$clean_path" );
        }
        $this->session->set_flashdata('success', 'Data Tamu Berhasil disimpan');
        $tujuan =  $this->input->post["tujuan"]; 
        $email =  $this->input->post["email"];
        $protocol = $_SERVER['REQUEST_SCHEME'];
        $domain = $_SERVER['HTTP_HOST'];
        $app_uri = $_SERVER['SCRIPT_NAME'];
        $script_name = $app_uri;
        $clean_path = str_replace("index.php", "", $script_name);
        $uri_app = $clean_path;
        if($tujuan = '5'){
            $isi  = "<img src = $protocol://$domain$clean_path/uploads_registrasi/qr_code/rg_".md5($simpan).".png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
             $this->session->set_flashdata('success', 'Data Tamu Berhasil disimpan, Untuk Event Gempita silahkan save  QR Code berikut (QR Code juga telah dikirim ke email anda '.$email.'). QRCode diperlukan untuk penukaran Merchandise pada saat acara GEMPITA <br>'.$isi);
        }
        //redirect('https://dpmptsp.jabarprov.go.id/schedule/');
        $this->load->view("index");
        header( "refresh:1;url=$protocol:///$domain$clean_path" );
    }
    

    public function februari()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 3307458931;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatfeb"] = $this->realisasi_model->getSekreFeb();
        $data["datinfeb"] = $this->realisasi_model->getDatinFeb();
        $data["esdafeb"] = $this->realisasi_model->getEsdaFeb();
        $data["insosfeb"] = $this->realisasi_model->getInsosFeb();
        $data["bangpromfeb"] = $this->realisasi_model->getBangpromFeb();
        $data["pengendalianfeb"] = $this->realisasi_model->getPengendalianFeb();
         $data["dpa_sekrefeb"] = $this->realisasi_model->getSumSekreFeb();
             $data["dpa_datinfeb"] = $this->realisasi_model->getSumDatinFeb();
             $data["dpa_esdafeb"] = $this->realisasi_model->getSumEsdaFeb();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromfeb"] = $this->realisasi_model->getSumBangpromFeb();
             $data["dpa_pengendalianfeb"] = $this->realisasi_model->getSumPengendalianFeb();
             $data["dpa_seluruhfeb"] = $this->realisasi_model->getSumAllFeb();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vfebruari", $data);
    }
     public function info($id = NULL)
    {
        if (!empty($id)) {
            $kegiatan = $this->daftar_model->get_kegiatan($id);
            $data['kegiatan']   = $kegiatan;
            $data['namampp']    = $this->daftar_model->get_namampp();
            $this->load->view('daftar_info', $data);
        } else {
            $message = "Data Kegiatan Tidak Terpilih";
            $status_code = 400;
            $heading = "Error";
            show_error($message, $status_code, $heading);
        }
    }
}
