<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller { 

	public function __construct()
    {
        parent::__construct();
        $this->load->model("daftar_model");
    }

	public function index($id = NULL)
	{
        $data['page'] = 'daftar';
		$this->load->view('daftar', $data);
	}
    
	public function save()
	{
    // $email = $this->input->post('email');
    // $nama = $this->input->post('fullname'); // Assuming 'fullname' is the input name for the full name
    // $nik = $this->input->post('nik');
    // $domisili = $this->input->post('domisili');
    // $whatsapp = $this->input->post('telephone'); // Assuming 'telephone' is the input name for WhatsApp number
    // $group_umk = $this->input->post('additional_data[1493]');
    // $jenis_usaha = $this->input->post('additional_data[1497]');
    // $nib = $this->input->post('additional_data[1499]');
    // $layanan_array = $this->input->post('layanan');
    // $persetujuan = $this->input->post('present'); // Assuming 'present' is the input name for agreement
    // $kablain = $this->input->post('kablain');
    // $signed = $this->input->post('signed');

        $nama = $this->input->post('fullname');
        $nik = $this->input->post('nik');
        $email = $this->input->post('email');
        $telephone = $this->input->post('telephone');
        $domisili = $this->input->post('domisili');
        $layanan_array = $this->input->post('layanan');
        $nib = $this->input->post('nib');
        $jenis_usaha = $this->input->post('jenis_usaha');
        $tempat_usaha = $this->input->post('tempat_usaha');
        $modal_usaha = $this->input->post('modal_usaha');
        $luas_lahan = $this->input->post('luas_lahan');
        $jumlah_tenaga = $this->input->post('jumlah_tenaga');
        $pendapatan = $this->input->post('pendapatan');
        $kablain = $this->input->post('kablain');
        $signed = $this->input->post('signed');
        $persetujuan = $this->input->post('present');
    // var_dump($layanan_string);die();

        if ($this->input->post('namakab') == "Lainnya") {
            $kabupaten  = $this->input->post('kablain');
        } else {
            $kabupaten  = $this->input->post('namakab');
        }
        $signed     = $this->input->post('signed');

        // Check if kabupaten is 'Lainnya'
        $kabupaten = ($this->input->post('namakab') == "Lainnya") ? $kablain : $this->input->post('namakab');

        // Convert layanan_array to a string
        $layanan = implode("^", $layanan_array);

        // Save data to the database using the model
        $simpan = $this->daftar_model->save_data($nama, $nik, $email, $telephone, $domisili, $layanan, $nib, $jenis_usaha, $tempat_usaha, $modal_usaha, $luas_lahan, $jumlah_tenaga, $pendapatan, $kablain, $signed, $persetujuan);

    //Create QRCode
		include('./assets/qrcode/qrlib.php');
        $tempDir = $_SERVER['DOCUMENT_ROOT'].'/kehadiran/uploads_registrasi/qr_code/';
        //$link = 'http://dpmptsp.jabarprov.go.id/jelita/main/cekiz/index/';
        $link = 'https://dpmptsp.jabarprov.go.id/jelita/backoffice/konfirmasi/registrasi/'.base64_encode($simpan);
        $codeContents = $simpan;
        $fileName = 'rg_'.md5($codeContents).'.png';  // Create ID Naskah Key
        $pngAbsoluteFilePath = $tempDir.$fileName;
        $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
        if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat
        $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
        $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
        $padding = 0;
        QRCode::png($link,$tempDir.$fileName,$quality,$ukuran,$padding);
        //EOF() Create QRCode
        
        ///// KIRIM E-MAIL
        $base_url         = 'assets/pendaftaran/';
        require_once("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
        require_once("".$base_url."back/plugins/phpmailer/class.smtp.php");
        $send2 = 0;		   
        $targetpengiriman = urlencode($email);
        $tokens = "qffL4YFq8Q";
        $uuids = urlencode(base64_encode($string.'^'.$passworduser));

          $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/daftar?mails='.$targetpengiriman.'&request=1&token='.$tokens.'&uuid='.$uuids.'&id='.$simpan;
        //   var_dump($url);die();

          $data = @file_get_contents($url);
        // var_dump($url);die();
          if ($data) {
            $json = json_decode($data);
            if (isset($json->status)) {
              if ($json->status == 1) {
                $sendE = TRUE;
                $send2 = 1;
              } else {
                $sendE = FALSE;
                $send2 = 0;
              }
            }
          }
        	if ($simpan != 0) {

                if (!empty($signed)) {
                    $folderPath = $_SERVER['DOCUMENT_ROOT'].'/kehadiran/uploads_registrasi/';
                    $image_parts = explode(";base64,", $signed);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                      
                    $file = $folderPath . $simpan . '.'.$image_type;
                      
                    if(file_put_contents($file, $image_base64)) {
                        $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
                        redirect('/daftar/info/'.$simpan);
                    } else {
                        $this->session->set_flashdata('error', "Terjadi kesalahan, server tidak merespon, silahkan mengulangi pengisian data.");
                        redirect('/daftar/info/'.$simpan);
                    }
                } else {
                    $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
                    redirect('/daftar/info/'.$simpan);
                }

        	} else {
        		$this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
            	redirect('/daftar/info/'.$simpan);
        	}
        // } else {
        // 	$this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
        //     redirect('/daftar/info/'.$kegiatan);
        // }
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
