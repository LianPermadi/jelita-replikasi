<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of petugas class
 * @author  Dichi Al Faridi
 * @since   1.0
 */

class Petugas extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->petugas = new tmpegawai();
    $this->load->model("m_petugas");
    $this->unitkerja = new trunitkerja();
    $this->user = new user();
    $this->kabupaten = new trkabupaten;
    $enabled = FALSE;
    $this->set_pegawai = FALSE;
    
    /* Untuk Upload */
    $this->load->helper(array("html","form","url","text"));
    /* EOF() Untuk Upload */
    
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '4') {  // Seting User
        $enabled = TRUE;
      }
      
      if($list_auth->id_role === '27') {  // Seting Pegawai
        $this->set_pegawai = TRUE;
      }
    }
      
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index($uid=NULL, $mn=NULL) {
    $data['list'] = $this->petugas->order_by('eselon', "ASC")->order_by('golongan', "DESC")->get();
    $data['ket_exist'] = NULL;
    $data['set_pegawai'] = $this->set_pegawai;
    $data['uid'] = $uid;
    $data['menu'] = $mn;
    $page_name = "Setting Pegawai";
    if($mn == 1) $page_name = "Sinkronisasi Data Pegawai dengan User";
    $this->load->vars($data);
    
    $js =  "
         function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
            $(document).ready(function() {
                    oTable = $('#petugas').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = $page_name;
    $this->template->build('list', $this->session_info);
  }

  public function index_list($exist = NULL) {
    $data['list'] = $this->petugas->order_by('golongan', "DESC")->get();
    $data['ket_exist'] = $exist;
    $data['set_pegawai'] = $this->set_pegawai;
    $this->load->vars($data);
    
    $js =  "
         function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
            $(document).ready(function() {
                    oTable = $('#petugas').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Pegawai";
    $this->template->build('list', $this->session_info);
  }

  public function create() {
    $now = $this->lib_date->get_date_now();
    $data['status_sign'] = "";
    $data['nik']  = "";
    $data['nip']  = "";
    $data['n_jabatan']  = "";
    $data['tmt_jabat'] = $this->lib_date->set_date($now, 0);
    $data['tmt_pensiun'] = $this->lib_date->set_date($now, 0);
    $data['unit_kerja_id'] = "";
    $data['n_pegawai']  = "";
    $data['pangkat_gol']="";
    $data['eselon']="";
    $data['golongan']="";
    $data['status'] = "";
    $data['e_mail'] = "";
    $data['save_method'] = "save";
    $data['id'] = "";
    $data['status_cont'] = "0";    //ttd sk & Nota
    $data['status_cont2'] = "0";   //ttd penolakan
    $data['status_cont3'] = "0";   //ttd Sartek
    $data['status_cont4'] = "0";    //ttd Surat/Persuratan
    $data['nm_file'] = '';
    $data['nm_file_SE'] = '';
    $data['unit_kerja'] = $this->unitkerja->get();
    
    $js = "
            $(document).ready(function() {
                $('#form').validate();
                $(\"#tabs\").tabs();

            } );
        ";
    $this->template->set_metadata_javascript($js);
    
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Pegawai";
    $this->template->build('edit', $this->session_info);
  }

  public function save() {
    $golongan = $this->input->post('pangkat_gol'); 
    switch ($golongan) {
      case ''     : $pangkat = ''; break;
      case 'IVe'  : $pangkat = 'Pembina Utama'; break;
      case 'IVd'  : $pangkat = 'Pembina Utama Madya'; break;
      case 'IVc'  : $pangkat = 'Pembina Utama Muda'; break;
      case 'IVb'  : $pangkat = 'Pembina Tingkat I'; break;
      case 'IVa'  : $pangkat = 'Pembina'; break;
      case 'IIId' : $pangkat = 'Penata Tingkat I'; break;
      case 'IIIc' : $pangkat = 'Penata'; break;
      case 'IIIb' : $pangkat = 'Penata Muda Tingkat I'; break;
      case 'IIIa' : $pangkat = 'Penata Muda'; break;
      case 'IId'  : $pangkat = 'Pengatur Tingkat I'; break;
      case 'IIc'  : $pangkat = 'Pengatur'; break;
      case 'IIb'  : $pangkat = 'Pengatur Muda Tingkat I'; break;
      case 'IIa'  : $pangkat = 'Pengatur Muda'; break;
      case 'Id'   : $pangkat = 'Juru Tingkat I'; break;
      case 'Ic'   : $pangkat = 'Juru'; break;
      case 'Ib'   : $pangkat = 'Juru Muda Tingkat I'; break;
      case 'Ia'   : $pangkat = 'Juru Muda'; break;
      case 'HL'   : $pangkat = 'Tenaga Kontrak'; break;
    } 
    
    $nama = $this->input->post('n_pegawai');
    $status = $this->input->post('ststtd');
    $pegawai = new tmpegawai();
    $pegawai = $pegawai->get();
    $cek_data = FALSE;
    $cek_nip = str_replace(" ", "",$this->input->post('nip'));
    foreach ($pegawai as $data){
      $nip = str_replace(" ", "",$data->nip);
      if($nip == $cek_nip) {
        $cek_data = TRUE;
      }
    }
    if($cek_data){
      redirect('petugas/index_list/'.str_replace("-", "", strtolower(url_title($nama)).' Atau NIP : '.$this->input->post('nip') ));
    }else{
      $this->petugas->nik = $this->input->post('nik');
      $this->petugas->nip = $this->input->post('nip');
      $this->petugas->n_jabatan = intval($this->input->post('n_jabatan'));
      $this->petugas->n_pegawai = $nama;
      $this->petugas->n_jabatan = $this->input->post('n_jabatan');
      $this->petugas->tgl_jabat = $this->input->post('tmt_jabat');
      $this->petugas->tgl_pensiun = $this->input->post('tmt_pensiun');
      $this->petugas->eselon = $this->input->post('eselon');
      $this->petugas->pangkat_gol = $pangkat;
      $this->petugas->golongan = $golongan;
      $this->petugas->status = $this->input->post('ststtd');
      $this->petugas->ttd_penolakan = $this->input->post('ttdpenolakan');
      $this->petugas->ttd_sartek = $this->input->post('ttdsartek');
      $this->petugas->ttd_surat = $this->input->post('stssrt');
      $this->petugas->e_mail = $this->input->post('e_mail');
      $this->unitkerja->where('id', $this->input->post('unitkerja'))->get();
      $save = $this->petugas->save($this->unitkerja);
      
      if(! $save) {
        echo '<p>' . $this->petugas->error->string . '</p>';
      }else{
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
        //$p = $this->db->query("call log ('Setting User','Insert pegawai ".$nama."','".$tgl."','".$g->description."')");
        redirect('petugas');
      }
    }
  }

  public function edit($id_petugas = NULL) {
    $this->petugas->where('id', $id_petugas);
    $this->petugas->get();
    $this->petugas->trunitkerja->get();
    $now = $this->lib_date->get_date_now();
    $nm_file = str_replace(' ', '', $this->petugas->nip).'.png';
    $nm_file_SE = str_replace(' ', '', $this->petugas->nip).'.p12';
    if(!file_exists('uploads/logo/'.$nm_file)){
      $nm_file = '';
    }
    if(!file_exists('../android/assets/esign/signer/'.$nm_file_SE)){
      $nm_file_SE = '';
    }

    $kabupaten = array();
    if (!empty($this->petugas->val_kab)) {
      $kabupaten = explode("^", $this->petugas->val_kab);
    }

    $querykab = "select * from trkabupaten where kd_prov = '12' order by n_kabupaten";
    $hasilkab = $this->db->query($querykab);
    $list_kab  = $hasilkab->result();

    $status_sign = "";

    if ($this->petugas->nik != "") {
      // $path_jar_new = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/esign_client.jar';
    // var_dump($path_jar_new);die();

      // $command = "java -jar ".$path_jar_new." -m cek_status_user -nik ".$this->petugas->nik;

      // exec($command, $val, $er);

      // if ($er == 0 || $er == 3) {
      //   $output = explode(" : ", str_replace('"', "", $val[3]));
      //   $status_sign = $output[1];
      // } else {
      //   $status_sign = "Gagal Koneksi API";
      // }
      // $curl = curl_init();

      // curl_setopt_array($curl, array(
      //   CURLOPT_URL => 'http://103.179.89.34/api/user/status/'.$this->petugas->nik,
      //   CURLOPT_RETURNTRANSFER => true,
      //   CURLOPT_ENCODING => '',
      //   CURLOPT_MAXREDIRS => 10,
      //   CURLOPT_TIMEOUT => 0,
      //   CURLOPT_FOLLOWLOCATION => true,
      //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      //   CURLOPT_CUSTOMREQUEST => 'GET',
      //   CURLOPT_HTTPHEADER => array(
      //     'Authorization: Basic c3Bla3RhOnB0c3AyMDIzIQ=='
      //   ),
      // ));

      // $response = curl_exec($curl);

      // curl_close($curl);
      // $array_json = array();
      // if($response) {
      //   $json = json_decode($response);
      // }
      // $array = (array) $json;
      $status_sign = 'Aktif';
    }
    

    $data['status_sign'] = $status_sign;
    $data['kabupaten'] = $kabupaten;
    $data['list_kab'] = $list_kab;
    $data['unit_kerja'] = $this->unitkerja->get();
    $data['nik']  = $this->petugas->nik;
    $data['nip']  = $this->petugas->nip;
    $data['id'] = $this->petugas->id;
    $data['n_jabatan']  = $this->petugas->n_jabatan;
    $data['tmt_jabat'] = (!empty($this->petugas->tgl_jabat) ? $this->petugas->tgl_jabat : $this->lib_date->set_date($now, 0));
    $data['tmt_pensiun'] = (!empty($this->petugas->tgl_pensiun) ? $this->petugas->tgl_pensiun : $this->lib_date->set_date($now, 0));
    $data['n_pegawai']  = $this->petugas->n_pegawai;
    $data['eselon']=  $this->petugas->eselon;
    $data['pangkat_gol'] = $this->petugas->golongan;
    $data['golongan'] = $this->petugas->golongan;
    $data['status_cont'] = $this->petugas->status;         //ttd sk & Nota
    $data['status_cont2'] = $this->petugas->ttd_penolakan; //ttd penolakan
    $data['status_cont3'] = $this->petugas->ttd_sartek;    //ttd Sartek
    $data['status_cont4'] = $this->petugas->ttd_surat;    //ttd Surat/Persuratan
    $data['e_mail'] = $this->petugas->e_mail;
    $data['nm_file'] = $nm_file;
    $data['nm_file_SE'] = $nm_file_SE;
    $data['unit_kerja_id'] = $this->petugas->trunitkerja->id;
    $data['save_method'] = "update";
    
    $js = "$(document).ready(function(){
                $(\"#tabs\").tabs();
                 $('#form').validate();

                 oTable = $('#peran_list').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
           });
           $(document).ready(function() {
               $('#form').validate();
               $(\"#tabs\").tabs();
					     $('a[rel*=upload_box]').facebox();
             } );";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Pegawai";
    $this->template->build('edit', $this->session_info);
  }
  
  function showformSE($nip = Null){
    $judul = "Upload File SE BSrE";
		$data["judulapp"]=$judul;
		$data["nip"]=$nip; // Nomor Induk Pegawai
		$viewfile="v_SEload_form";
		$this->load->view($viewfile,$data);
  }
  
  function uploadfileSE(){   // Upload File SE
	  $nip = $this->input->post('nip');  // Nomor pendaftaran
	  $file_name = basename($_FILES["fileToUpload"]["name"]);
  	$ext = '.p12';
  	$target_dir = "../android/assets/esign/signer/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        $uploadOk = 0;
      }
    }
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    }else{
    }
		$fileBaru = $target_dir.$nip.$ext;
		//unlink("naskah_izin/".$nopendaftaran.'.pdf');  // jika lebih dari satu tipe file
    rename($target_file, $fileBaru); // mengubah nama file
		redirect('petugas');
  }
  
  function showform($nip = Null){
    $judul = "Upload File ttd (.png)";
		$data["judulapp"]=$judul;
		$data["nip"]=$nip; // Nomor Induk Pegawai
		$viewfile="v_ttdload_form";
		$this->load->view($viewfile,$data);
  }
  
  function uploadfile(){   // Upload File TTD
	  $nip = $this->input->post('nip');  // Nomor pendaftaran
	  $file_name = basename($_FILES["fileToUpload"]["name"]);
  	$ext = '.png';
  	$target_dir = "uploads/logo/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        $uploadOk = 0;
      }
    }
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    }else{
    }
		$fileBaru = $target_dir.$nip.$ext;
		//unlink("naskah_izin/".$nopendaftaran.'.pdf');  // jika lebih dari satu tipe file
    rename($target_file, $fileBaru); // mengubah nama file
		redirect('petugas');
  }
  
  public function update() {
    $eselon = $this->input->post('eselon');
    if($eselon == 0) $eselon = 9;
    $golongan = $this->input->post('pangkat_gol'); 
    switch ($golongan) {
      case ''     : $pangkat = ''; break;
      case 'IVe'  : $pangkat = 'Pembina Utama'; break;
      case 'IVd'  : $pangkat = 'Pembina Utama Madya'; break;
      case 'IVc'  : $pangkat = 'Pembina Utama Muda'; break;
      case 'IVb'  : $pangkat = 'Pembina Tingkat I'; break;
      case 'IVa'  : $pangkat = 'Pembina'; break;
      case 'IIId' : $pangkat = 'Penata Tingkat I'; break;
      case 'IIIc' : $pangkat = 'Penata'; break;
      case 'IIIb' : $pangkat = 'Penata Muda Tingkat I'; break;
      case 'IIIa' : $pangkat = 'Penata Muda'; break;
      case 'IId'  : $pangkat = 'Pengatur Tingkat I'; break;
      case 'IIc'  : $pangkat = 'Pengatur'; break;
      case 'IIb'  : $pangkat = 'Pengatur Muda Tingkat I'; break;
      case 'IIa'  : $pangkat = 'Pengatur Muda'; break;
      case 'Id'   : $pangkat = 'Juru Tingkat I'; break;
      case 'Ic'   : $pangkat = 'Juru'; break;
      case 'Ib'   : $pangkat = 'Juru Muda Tingkat I'; break;
      case 'Ia'   : $pangkat = 'Juru Muda'; break;
      case 'HL'   : $pangkat = 'Tenaga Kontrak'; break;
    } 
    
    $id_petugas = $this->input->post('id');
    $update = $this->petugas
                   ->where('id', $id_petugas)
                   ->update(array('nik' => $this->input->post('nik'),
                                  'nip' => $this->input->post('nip'),
                                  'n_jabatan' => $this->input->post('n_jabatan'),
                                  'unitkerja_id' => $this->input->post('unitkerja'),
                                  'tgl_jabat' => $this->input->post('tmt_jabat'),
                                  'tgl_pensiun' => $this->input->post('tmt_pensiun'),
                                  'status' => $this->input->post('ststtd'),
                                  'e_mail' => $this->input->post('e_mail'),
                                  'ttd_penolakan' => $this->input->post('ttdpenolakan'),
                                  'ttd_sartek' => $this->input->post('ttdsartek'),
                                  'ttd_surat' => $this->input->post('stssrt'),
                                  'eselon' => $eselon,
                                  'pangkat_gol' => $pangkat,
                                  'golongan' => $golongan,
                                  'n_pegawai' => $this->input->post('n_pegawai')
                                )
                 );
    
    if($update) {
      $rel_unit_kerja = new tmpegawai_trunitkerja();           
      $pegawai_unitkerja = New tmpegawai_trunitkerja();
      $pegawai_unitkerja = $pegawai_unitkerja->where('tmpegawai_id', $id_petugas)->get();
      if($pegawai_unitkerja->trunitkerja_id == '') {
        $rel_unit_kerja->tmpegawai_id = $id_petugas;
        $rel_unit_kerja->trunitkerja_id = $this->input->post('unitkerja');
        $rel_unit_kerja->save();
      }else{
        $rel_unit_kerja->where('tmpegawai_id', $id_petugas)
                       ->update(array('trunitkerja_id' => $this->input->post('unitkerja')));
      }
    }
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting User','Update pegawai ".$this->input->post('n_pegawai')."','".$tgl."','".$g->description."')");
    redirect('petugas');
  }

  public function delete($id = NULL) {
    $this->petugas->where('id', $id)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting User','Delete pegawai ".$this->petugas->n_pegawai."','".$tgl."','".$g->description."')");
    
    if($this->petugas->delete()) {
      redirect('petugas');
    }
  }
  
  public function create_qr_code_view() {
    $this->load->vars($data);
    
    $js =  "
         function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
            $(document).ready(function() {
                    oTable = $('#petugas').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Pegawai";
    $this->template->build('qrcode', $this->session_info);
  }

public function create_qr_code($id) {
  // var_dump($id);die();

include('./assets/qrcode/qrlib.php');

$pegawai = $this->m_petugas->get_pegawai($id);
$nik = $pegawai[0]->nik;
$n_pegawai = $pegawai[0]->n_pegawai;
$n_jabatan = $pegawai[0]->n_jabatan;
$nip = $pegawai[0]->nip;
$eselon = $pegawai[0]->eselon;
$pangkat_gol = $pegawai[0]->pangkat_gol;
$golongan = $pegawai[0]->golongan;
$status = $pegawai[0]->status;
$level_pegawai = $pegawai[0]->level_pegawai;
$signature = $pegawai[0]->signature;
$e_mail = $pegawai[0]->e_mail;
$tgl_jabat = $pegawai[0]->tgl_jabat;
$tgl_pensiun = $pegawai[0]->tgl_pensiun;
$ttd_penolakan = $pegawai[0]->ttd_penolakan;
$ttd_sartek = $pegawai[0]->ttd_sartek;
$ttd_surat = $pegawai[0]->ttd_surat;
$val_kab = $pegawai[0]->val_kab;

$data['nik'] = $nik;
$data['n_pegawai'] = $n_pegawai;
$data['n_jabatan'] = $n_jabatan;
$data['nip'] = $nip;
$data['eselon'] = $eselon;
$data['pangkat_gol'] = $pangkat_gol;
$data['golongan'] = $golongan;
$data['status'] = $status;
$data['level_pegawai'] = $level_pegawai;
$data['signature'] = $signature;
$data['e_mail'] = $e_mail;
$data['tgl_jabat'] = $tgl_jabat;
$data['tgl_pensiun'] = $tgl_pensiun;
$data['ttd_penolakan'] = $ttd_penolakan;
$data['ttd_sartek'] = $ttd_sartek;
$data['ttd_surat'] = $ttd_surat;
$data['val_kab'] = $val_kab;

// Data yang akan dijadikan QR code
$idToEncode = $id; // Data yang akan diencode
$encoded = base64_encode($idToEncode);
$qr_code_content = 'https://spekta.tasikmalayakab.go.id/spekta/main/ttd/' . $encoded;

$post_SE = str_replace(' ', '', $nip);

// Nama file QR code yang akan disimpan
if($nip != NULL) {
    $fileName = $post_SE.'.png';
} else {
    $fileName = $nik.'.png';
}

// Lokasi penyimpanan QR code
$tempDir = FCPATH . 'uploads/qrcode/';

// Buat direktori jika belum ada
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}

// Jalankan QRlib untuk membuat QR code
// QRcode::png($qr_code_content, $tempDir . $fileName);
QRcode::png($qr_code_content, $tempDir . $fileName, 'L', 20, 4); // Sesuaikan parameter dengan ukuran yang cukup besar

// Memuat gambar QR code
$qrCode = imagecreatefrompng($tempDir . $fileName);

// Memuat logo kecil yang akan ditambahkan
$smallLogo = imagecreatefrompng('https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/qrcode/tasik150px.png');
// Load the logo image

// Get the dimensions of the QR code and logo images
$qrWidth = imagesx($qrCode);
$qrHeight = imagesy($qrCode);
$logoWidth = imagesx($smallLogo);
$logoHeight = imagesy($smallLogo);

// Mengambil dimensi QR code dan logo kecil
$smallLogoWidth = imagesx($smallLogo);
$smallLogoHeight = imagesy($smallLogo);
// Mengatur ukuran logo kecil

// Menghitung posisi logo kecil di tengah QR code
$centerX = ($qrWidth - $smallLogoWidth) / 2;
$centerY = ($qrHeight - $smallLogoHeight) / 2;
// Memeriksa apakah ukuran logo lebih besar dari QR code

// Menggabungkan QR code dengan logo kecil di tengah
imagecopy($qrCode, $smallLogo, $centerX, $centerY, 0, 0, $smallLogoWidth, $smallLogoHeight);


// Menyimpan gambar QR code dengan logo kecil di tengah
imagepng($qrCode, $tempDir . $fileName);

// URL QR code dengan logo kecil di tengah
$qr_code_url = 'https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/qrcode/' . $fileName;

// Meneruskan URL QR code dengan logo kecil di tengah ke tampilan Anda
$data['qr_code11'] = $qr_code_url;

// Meneruskan data ke tampilan
$this->load->vars($data);
$this->session_info['page_name'] = "Setting Pegawai";
$this->template->build('qrcode', $this->session_info);
    }
  
  public function insertAsUser($id = NULL) {
    $this->petugas->where('id', $id)->get();
    $username = url_title($this->petugas->n_pegawai, 'underscore', TRUE);
    $username = substr($username, 0, 30);
    $password = md5('123456');
    
    $this->user->username = $username;
    $this->user->realname = $this->petugas->n_pegawai;
    $this->user->oriname = $this->petugas->n_pegawai;
    $this->user->password = $password;
    
    $this->session_info['from'] = 'petugas';
    
    if($this->user->save()) {
      $this->user->where('username', $username)->get();
      $this->petugas->where('id', $id)->get();
      $this->petugas->save($this->user);
      redirect('pengguna/edit/' . $this->user->id);
    }
  }
  
  public function sql($u_ser) {
    $query = "select a.description from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')
             ";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function kabupaten($id = NULL, $cek_all = NULL) {
    if($id == NULL) $id = $this->input->post('id');
    if($cek_all == NULL) $cek_all = $this->input->post('cek_all');
    $data['backto']=$this->uri->segment(4,'');
    $this->petugas->where('id', $id);
    $this->petugas->get();

    $kabupaten = array();
    if (!empty($this->petugas->val_kab)) {
      $kabupaten = explode("^", $this->petugas->val_kab);
    }

    $query = "select * from trkabupaten where kd_prov = '12' order by n_kabupaten";
    $hasil = $this->db->query($query);
    $list  = $hasil->result();

    $js =  "
            $(document).ready(function() {
              $(\"#tabs\").tabs();
            } );
            function check_uncheckAll(field,nilai){
              for(i=0; i< field.length; i++){
                field[i].checked=nilai;
              }
            }
           ";

    $this->template->set_metadata_javascript($js);

    $data['cek_all'] = $cek_all;
    $data['id'] = $this->petugas->id;
    $data['real_name'] = $this->petugas->n_pegawai;
    //$data['user_name'] = $this->user->username;
    $data['list'] = $list;
    $data['kabupaten'] = $kabupaten;

    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Kabupaten Petugas";
    $this->template->build('kabupaten', $this->session_info);
  }

  public function flush() {
    $id = $this->input->post('id');
    $kab_list = $this->input->post('kabupaten');
    if($kab_list > 0) {
      $val_kab = implode("^", $kab_list);

      $data = array('val_kab' => $val_kab);

      $this->db->where('id', $id);
      $updt = $this->db->update('tmpegawai', $data);
      
      if ($updt) {
        $this->session->set_flashdata('sukses', "Berhasil menambahkan kabupaten.");
        redirect('petugas/edit' . "/" . $id);
      } else {
        $this->session->set_flashdata('gagal', "Gagal menambahkan kabupaten.");
        redirect('petugas/edit' . "/" . $id);
      }
    } else {
      $this->session->set_flashdata('gagal', "Terjadi kesalahan, data yang akan di input tidak ditemukan.");
      redirect('petugas/edit' . "/" . $id);
    }
    
    //redirect('pengguna/edit' . "/" . $id);
  }

  public function deletekab($id, $id_kab) {
    $this->petugas->where('id', $id);
    $this->petugas->get();

    $kabupaten = array();
    if (!empty($this->petugas->val_kab)) {
      $kabupaten = explode("^", $this->petugas->val_kab);
      $index = array_search($id_kab,$kabupaten);
      unset($kabupaten[$index]);

      $val_kab = implode("^", $kabupaten);

      $data = array('val_kab' => $val_kab);

      $this->db->where('id', $id);
      $updt = $this->db->update('tmpegawai', $data);
      
      if ($updt) {
        $this->session->set_flashdata('sukses', "Berhasil menghapus kabupaten.");
        redirect('petugas/edit' . "/" . $id);
      } else {
        $this->session->set_flashdata('gagal', "Gagal menghapus kabupaten.");
        redirect('petugas/edit' . "/" . $id);
      }
    } else {
      $this->session->set_flashdata('gagal', "Terjadi kesalahan, data yang akan di hapus tidak ditemukan.");
        redirect('petugas/edit' . "/" . $id);
    }
  }

}
// This is the end of petugas class