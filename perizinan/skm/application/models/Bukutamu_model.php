<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bukutamu_model extends CI_Model
{	
	private $_table = "euis_bukutamu";
	public $nama;
	public $email;
	public $instansi;
	public $keperluan;
	public $waktu;
	public $esselon;
	public $lokasi;
	public $bidang;
	public $solusi;
	public $telepon;

	 public function get_sektor2() {
        $sql = "SELECT * from trsektor";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function get_namampp() {
      $sql = "SELECT * from trkabupaten WHERE kd_prov = '12'";
      $result = $this->db->query($sql)->result(); 

      return $result;
    }

    public function ceknik($nik) {
        $sql = "SELECT * from euis_bukutamu where tujuan = '5' and nik = $nik ";
        $result = $this->db->query($sql)->result();

        return $result;
    }

	public function save()
	{
		date_default_timezone_set("Asia/Jakarta");
		$post = $this->input->post();
        $this->nama = $post["nama"];
        $this->nik = $post["nik"];
        $this->waktu = date('Y-m-d H:i:s');
        $this->email = $post["email"]; 
        $email = $post["email"]; 
        $nik = $post["nik"]; 
        $this->instansi = $post["instansi"]; 
        $this->keperluan = $post["keperluan"];
        $this->lokasi = $post["namampp"];
        $this->bidang = $post["list2"];
        $this->nama_petugas = '-';
        $this->nib = $post["nib"];
        $this->tujuan = $post["tujuan"];
        $this->layanan = $post["layanan"];
        $this->jenis_izin = $post["jenis_izin"];
      //  $this->solusi = $post["solusi"];
        $this->telepon = $post["telepon"];
   		$gcaptcha = $this->input->post('g-recaptcha-response');
         //Proses Google reCaptcha
        if (!$gcaptcha) {
            $this->session->set_flashdata('error', "Terjadi kesalahan, silahkan mengulangi pengisian Captcha.");
            redirect('/');
        }
        $ceknik = $this->ceknik($nik);
        if($ceknik != null){
            $this->session->set_flashdata('error', "NIK Sudah Terdaftar, Silahkan cek email anda untuk mendapatkan QRCODE");
            redirect('bukutamu');$this->session->set_flashdata('error', "NIK Sudah Terdaftar, Silahkan cek email anda untuk mendapatkan QRCODE");
        }

        $secretKey = "6LdIHikeAAAAAPXCIZOvaLjubK00hM7U7DLlpPqa";

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($gcaptcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);

        if($responseKeys["success"]) { //Jika captcha berhasil      
            $this->db->insert($this->_table, $this); 
             $simpan = $this->db->insert_id();
              //Create QRCode
            include('./assets/qrcode/qrlib.php');
            $tempDir = $_SERVER['DOCUMENT_ROOT'].'/bukutamu/uploads_registrasi/qr_code/';
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
            
            $send2 = 0;        
            $targetpengiriman = urlencode($email);
            $tokens = "qffL4YFq8Q";
            $uuids = '';// urlencode(base64_encode($string.'^'.$passworduser));

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
        
        }
        return $simpan;
	}


}