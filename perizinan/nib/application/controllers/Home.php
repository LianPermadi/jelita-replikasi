<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller { 
  
  public function __construct(){
    parent::__construct();
    $this->load->model("absensi_model");
  }
  
  public function index() {
    // Mengambil data pegawai dari model
    $data['pegawai'] = $this->absensi_model->get_pegawai();
    // Memanggil fungsi setting_nib_langsung dari model
    $onoff = $this->absensi_model->setting_nib_langsung();

    // Menyimpan data ke dalam array $data untuk dikirim ke view
    $data['onoff'] = $onoff;
    $data['cek'] = 'cek';
    $data['namampp'] 	= $this->absensi_model->get_namampp();
    // var_dump($data['namampp']);die();
    // Memuat view 'index' dan mengirimkan data ke dalamnya
    $this->load->view('index', $data);
  }

  public function test() {
    // Mengambil data pegawai dari model
    $data['pegawai'] = $this->absensi_model->get_pegawai();
    // var_dump($data['pegawai']);die();
    // Memanggil fungsi setting_nib_langsung dari model
    $onoff = $this->absensi_model->setting_nib_langsung();

    // Menyimpan data ke dalam array $data untuk dikirim ke view
    $data['onoff'] = $onoff;
    $data['cek'] = 'cek';
    $data['namampp'] 	= $this->absensi_model->get_namampp();
    // var_dump($data['namampp']);die();
    // Memuat view 'index' dan mengirimkan data ke dalamnya
    $this->load->view('index_test', $data);
  }

  public function proses_form(){
    $this->load->library('form_validation');
    $nib_status 	= $this->input->post('nib_status');
    $nib_number = '-';
    $kbli_number = '-';
    if($nib_status == 'ya'){
      $nib_number 	= $this->input->post('nib_number');
      $kbli_number 	= $this->input->post('kbli_number');
      if($nib_number == '' || $nib_number == NULL){
        // Validasi gagal, simpan data formulir dalam flashdata
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('nib_number', "NIB Wajib Terisi");
        redirect('/');
      }
      if($kbli_number == '' || $kbli_number == NULL){
        // Validasi gagal, simpan data formulir dalam flashdata
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('kbli_number', "KBLI Wajib Terisi");
        redirect('/');
      }
    }
    $nik 	= $this->input->post('nik');   
    if (!is_numeric($nik) || strlen($nik) !== 16) {
        // Validasi gagal, simpan data formulir dalam flashdata
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('nik', "NIK Harus Angka & 16 digit");
        redirect('/');
    }
    $phone_number 	= $this->input->post('phone_number');
    $email 	= $this->input->post('email');
    $name_ktp 	= $this->input->post('nama');

    $layana_gpt 	= $this->input->post('layanan_gpt[]');
    // var_dump($layana_gpt);die();
    $birthdate 	= $this->input->post('tanggal_lahir');
    $address_ktp 	= $this->input->post('alamat_sesuai_ktp');
    $district_ktp 	= $this->input->post('kecamatan_sesuai_ktp');
    $subdistrict_ktp 	= $this->input->post('kelurahan_sesuai_ktp');
    
    // Jenis usaha
    $business_type 	= $this->input->post('j_usaha');

    $districtbusiness_type_other_ktp = '-';
    if($business_type == 'lainnya'){
      $districtbusiness_type_other_ktp 	= $this->input->post('business_type_other');
      if($districtbusiness_type_other_ktp == '' || $districtbusiness_type_other_ktp == NULL){
        // Validasi gagal, simpan data formulir dalam flashdata
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('districtbusiness_type_other_ktp', "Kecamatan Wajib Terisi");
        redirect('/');
      }
    }
    $business_name 	= '-';
    // $business_address 	= '-';
    $district_business 	= $this->input->post('kecamatan_tempat_usaha');
    $subdistrict_business 	= $this->input->post('kelurahan_tempat_usaha');
    $postal_code_business 	= $this->input->post('kode_pos_tempat_usaha');
    $start_date 	= '-';
    // $business_capital 	= '-';
    // $employees_number 	= '-';
    // var_dump($lama_usaha);die();
    
    $land_area 	= $this->input->post('luas_lahan');
    $business_capital 	= $this->input->post('modal_usaha');
    $employees_number 	= $this->input->post('jumlah_tenaga_kerja');
    $kapasitas_produksi 	= $this->input->post('kapasitas_produksi');
    $business_address 	= $this->input->post('alamat_usaha');
    $lama_usaha 	= $this->input->post('lama_usaha');
    $kegiatan 	= $this->input->post('kegiatan');
    // var_dump($luas_lahan ,$modal_usaha,$jumlah_tenaga_kerja,$kapasitas_produksi,$alamat_usaha,$lama_usaha,$kegiatan );die();
   
    $annual_income 	= '-';
    // Petugas Pendamping
    $Agen_Nib 	= $this->input->post('Agen_Nib');
    $lokasi_nib 	= $this->input->post('lokasi_nib');

    $accompanying_officer 	= '-';
    $location 	= '-';
    $event_name 	= '-';
    $event_location 	= '-';

    $tanggal = date('Y-m-d');
    $cek_nik = $this->absensi_model->cek_nik($nik, $tanggal);
    // var_dump($cek_nik);die();
    if($cek_nik){
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('nik', "NIK Sudah Di Gunakan");
        redirect('/');
    }
    // Atur lokal ke bahasa Indonesia
    setlocale(LC_TIME, 'id_ID');

    // Tanggal awal dalam format "Y-m-d"
    $tanggal_awal = $tanggal;
    $layanan = $this->input->post('layanan');

    // Ubah format tanggal menggunakan strftime()
    $tanggal_baru = strftime("%e %B %Y", strtotime($tanggal_awal));
    
    // $tanggal = '2024-04-01';
    
    if ($layanan == "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)") {
        $noantritidaklangsung = $this->absensi_model->get_no_antri_waiting_list($tanggal);
        if ($noantritidaklangsung == NULL) {
            $no_antri_tidak_langsung = 1;
        } else {
            $no_antri_tidak_langsung = $noantritidaklangsung->no_antri_tidak_langsung;
            $no_antri_tidak_langsung++;
        }
        $status_layanan = 1;
    }else {
      $noantri = $this->absensi_model->get_no_antri($tanggal);
      if($noantri == NULL){
      $no_antri = 1;
      }else{
      $no_antri = $noantri->no_antri;
      $no_antri++;
      }

    }
    if ($layanan == "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)") {
      $status_layanan = 2;
      $no_antri_tidak_langsung = 0;

    } elseif ($layanan == "Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)") {
        $status_layanan = 3;
      $no_antri_tidak_langsung = 0;

    } elseif ($layanan == "Konsultasi dan Pelayanan Sertifikasi Halal") {
        $status_layanan = 4;
      $no_antri_tidak_langsung = 0;

    } elseif ($layanan == "Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)") {
        $status_layanan = 5;
      $no_antri_tidak_langsung = 0;

    } elseif ($layanan == "Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)") {
        $status_layanan = 6;
      $no_antri_tidak_langsung = 0;
    } elseif ($layanan == "Gerakan Pelayanan Terpadu (GPT)") {
      $status_layanan = 7;
      $no_antri_tidak_langsung = 0;
    } elseif ($layanan == "" || $layanan == NULL) {
        $this->session->set_flashdata('form_data', $this->input->post());
        $this->session->set_flashdata('layanan', "Layanan Belum terisi");
        redirect('/');
    }
      // $n_hp = '83822039748';
      $n_hp = $phone_number;
      $nomor = $n_hp;
                          
      // Menghapus karakter selain angka
      $nomor = preg_replace('/\D/', '', $nomor);
                          
      // Menghapus kode negara (62)
      if (substr($nomor, 0, 2) == '62') {
          $nomor = substr($nomor, 2);
      }
                          
      // Menambahkan kode area (0813) jika tidak ada angka 0 di depan
      if (substr($nomor, 0, 1) != '0') {
          $nomor = '0' . $nomor;
      }

      $request_uri = $_SERVER['PHP_SELF'];
      $clean_uri  = $_SERVER['PHP_SELF'];
      // Periksa apakah 'index.php' ada dalam URL
      if (strpos($request_uri, 'index.php') !== false) {
          // Hapus 'index.php' dari URL
          $clean_uri = str_replace('index.php', '', $request_uri);
      }
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] .$clean_uri . "uploads/ktp/";
        $targetFile = $uploadDirectory . basename($_FILES["file"]["name"]);

        // Directory where you want to store uploaded files
        $targetDirectory = $uploadDirectory;


            // Check if file has been uploaded
            if(isset($_FILES["file"])) {
                // Generate a unique ID for the filename
                $uniqueID = uniqid(); // Generate a unique ID
                $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
                $newFileName = $uniqueID . "." . $fileExtension; // Construct the new filename

                $jenisFile = strtolower(pathinfo($newFileName, PATHINFO_EXTENSION));
                if ($jenisFile != 'jpg' && $jenisFile != 'jpeg' && $jenisFile != 'png') {
                    echo "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.";
                    $this->session->set_flashdata('error', "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.");
                    redirect('/');
                    exit();
                }
                // Attempt to move the uploaded file to the target directory with the new filename
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetDirectory . $newFileName)) {
                    echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded and renamed to $newFileName.";
                } else {
                    echo "Sorry, there was an error uploading your file.";die();
                }
            }
                if ($layanan == "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)") {
                  $n_pesan = "Terima kasih telah melakukan registrasi form pendaftaran NIB (Nomor Induk Berusaha) di Program SAkiceup Bos Dinas PMPTSP Prov. Jabar\n
                              No Antrian Anda : ".$no_antri_tidak_langsung."  
                              Silahkan menunggu panggilan sesuai nomor antrian anda\n
                              Mohon menunggu dengan tertib\n
                              Terima kasih \n
                              Tanggal Tanggal ".$tanggal_baru;
              } else {
                  $n_pesan = "Terima kasih telah melakukan registrasi form pendaftaran NIB (Nomor Induk Berusaha) di Program SAkiceup Bos Dinas PMPTSP Prov. Jabar\n
                              No Antrian Anda : ".$no_antri."  
                              Silahkan menunggu panggilan sesuai nomor antrian anda\n
                              Mohon menunggu dengan tertib\n
                              Terima kasih \n
                              Tanggal Tanggal ".$tanggal_baru;
              }
  
          $kirim = $this->absensi_model->postWaSms($nomor, $n_pesan, 'NIB');
          $simpan = $this->absensi_model->save_data_input($nib_status, $nib_number, $kbli_number, $nik, $phone_number, $email, $name_ktp, $birthdate, $address_ktp, $district_ktp, $subdistrict_ktp, $business_type, $districtbusiness_type_other_ktp, $business_name, $business_address, $district_business, $subdistrict_business, $postal_code_business, $start_date, $business_capital, $employees_number, $annual_income, $accompanying_officer, $location, $event_name, $event_location, $land_area, $layanan, $no_antri, $newFileName,$kapasitas_produksi, $lama_usaha , $kegiatan, $no_antri_tidak_langsung,$status_layanan,$Agen_Nib,$lokasi_nib );
          if(!empty($simpan)) {
            $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
            redirect('/home/info_nib/'.$simpan);
          }else{
            $this->session->set_flashdata('error', "Terjadi kesalahan, server tidak merespon, silahkan mengulangi pengisian data.");
            redirect('/home/info_nib/'.$simpan);
          }
  }
    
  public function info($id = NULL){
    if(!empty($id)){
      $this->load->view('info');
    }else{
      $message = "Data Kegiatan Tidak Terpilih";
      $status_code = 400;
      $heading = "Error";
      show_error($message, $status_code, $heading);
    }
  }

  public function info_nib($id = NULL){
    if(!empty($id)){
      $this->load->view('info');
    }else{
      $message = "Data Kegiatan Tidak Terpilih";
      $status_code = 400;
      $heading = "Error";
      show_error($message, $status_code, $heading);
    }
  }
}