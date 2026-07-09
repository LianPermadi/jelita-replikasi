<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
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

    public function get_data() {
        // Logika untuk mengambil data dari database
        $query = $this->db->get('your_table');
        return $query->result();
    }

    public function save_data($data) {
        // Logika untuk menyimpan data ke database
        $this->db->insert('your_table', $data);
    }

    public function setting_nib_langsung() {
        $data = " - ";

        if ($data != "0") {
        	$nib_langsung = $this->db->select('status')
	                     ->from('settings')
	                     ->where('name', 'nib_langsung')
	                     ->get()->row();
                      //  var_dump($nib_langsung->status);die();

	        if (!empty($nib_langsung)) {
	            $data = $nib_langsung->status;
	        }
        }
        
        return $data;
    }

    public function get_namampp() {
        $sql = "SELECT * from trkabupaten WHERE kd_prov = '12'";
        $result = $this->db->query($sql)->result(); 

        return $result;
    }

    public function get_user() {
        $sql = "SELECT * from user  WHERE lokasi = 'DPMPTSP Prov. Jabar' order by oriname";
        $result = $this->db->query($sql)->result(); 

        return $result;
    }

    public function cek_nik($nik, $tanggal) {
        $sql = "SELECT * from pelayanan_nib  WHERE nik = '$nik' && tanggal LIKE '$tanggal%'";
        // var_dump($sql);die();
        $result = $this->db->query($sql)->result(); 
        if($result){
          $result = TRUE;
        }else{
          $result = FALSE;
        }

        return $result;
    }

    public function kota_kabupaten() {
        // Logika untuk menyimpan data ke database
        $sql = 'SELECT * FROM `trkabupaten` WHERE `kd_prov` = 12';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_kegiatan($idkegiatan) {
        $sql = "SELECT * from ruangan_pemakai WHERE id = ?";
        $result = $this->db->query($sql, $idkegiatan)->first_row();

        return $result;
    }

    public function get_no_antri($tanggal) {
        $sql = "SELECT tanggal,no_antri from pelayanan_nib WHERE `tanggal` LIKE '$tanggal%' ORDER BY `no_antri` DESC";
        $result = $this->db->query($sql)->first_row();

        return $result;
    }
    public function get_no_antri_waiting_list($tanggal) {
      $sql = "SELECT tanggal, no_antri_tidak_langsung FROM pelayanan_nib WHERE `tanggal` LIKE '$tanggal%' ORDER BY `no_antri_tidak_langsung` DESC";
      $result = $this->db->query($sql)->first_row();
  
      return $result;
  }
   public function postWaSms($n_hp = null, $n_pesan = null, $campaign = null)
  {
    $settings = "SELECT * FROM settings WHERE `name` LIKE 'smsGateway'";
    $settings = $this->db->query($settings)->result();
    $statsms = $settings[0]->status;
    // var_dump($statsms);
    // die();
    if ($statsms == '1') {
      $receiver = $n_hp;
      $message = $n_pesan;
      $url = 'http://103.122.5.111/new/public/messaging/request/T8eDNwF8nw';

      // Prepare data array for JSON
      $data = [
        'sender' => 'DPMPTSP JBR',
        'msisdn' => $receiver,
        'message' => $message,
        "campaign" => $campaign
      ];

      // Encode data array to JSON
      $json_data = json_encode($data);

      // Initialize cURL session
      $ch = curl_init();

      // Set cURL options
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute cURL session
      $response = curl_exec($ch);

      // Close cURL session
      curl_close($ch);

      // Check for errors and handle response
      if ($response === false) {
        echo "Error: " . curl_error($ch);
        die;
      } else {
        $json = json_decode($response);
        if (isset($json->status) && $json->status == "200") {
          $result = TRUE;
          return $result;
        } else {
          $result = FALSE;
          echo "Ada Yang Error Kirim SMS: " . $json->message . " " . $json->status;
          return $result;
          // die;
        }
      }
    }
    return;
  }

	public function save_data_input($nib_status,
                                $nib_number, $kbli_number, 
                                $nik, 
                                $phone_number, 
                                $email, $name_ktp, 
                                $birthdate, 
                                $address_ktp, 
                                $district_ktp, 
                                $subdistrict_ktp, 
                                $business_type, 
                                $districtbusiness_type_other_ktp, 
                                $business_name, 
                                $business_address, 
                                $district_business, 
                                $subdistrict_business, 
                                $postal_code_business, 
                                $start_date, 
                                $business_capital, 
                                $employees_number, 
                                $annual_income, 
                                $accompanying_officer, 
                                $location, 
                                $event_name, 
                                $event_location, 
                                $land_area, 
                                $layanan,
                                $no_antri,
                                $newFileName,
                                $kapasitas_produksi,$lama_usaha,$kegiatan,
                                $no_antri_tidak_langsung,$status_layanan,$Agen_Nib,$lokasi_nib)
	{
    // var_dump($Agen_Nib);die();
        $data = array(
            'nib' => $nib_number,
            // 'user' => $user,
            'kbli' => $kbli_number,
            'no_wa' => $phone_number,		
            'nik' => $nik,		
            'email' => $email,	
            'nama' => $name_ktp,
            'tanggal_lahir' => $birthdate,	
            'alamat' => $address_ktp,
            'kecamatan' => $district_ktp,	
            'kelurahan' => $subdistrict_ktp,	
            'j_usaha' => $business_type,	
            'n_usaha' => $business_name,	
            'luas_lahan' => $land_area,	
            'alamat_usaha' => $business_address,	
            'kecamatan_usaha' => $district_business,
            'kelurahan_usaha' => $subdistrict_business,
            'bulan_tahun_berdiri' => $start_date,	
            'modal_usaha' => $business_capital,	
            'jumlah_tenaga_kerja' => $employees_number,	
            'pndapatan' => $annual_income,	
            'petugas_pendamping' => $accompanying_officer,	
            'lokasi' => $location,
            'event' => $event_name,
            'lokasi_event' => $event_location,
            'tanggal' => date('Y-m-d G:i:s'),
            'layanan' => $layanan,
            'no_antri' => $no_antri,
            'file' => $newFileName,
            'kapasitas_produksi_pertahun' 	=> $kapasitas_produksi,
            'lama_usaha' => $lama_usaha,
            'kegiatan' => $kegiatan,
            'kode_pos_tempat_usaha' => $postal_code_business,
            'no_antri_tidak_langsung' => $no_antri_tidak_langsung,
            'status_pelayanan' => $status_layanan,
            'Agen_Nib' => $Agen_Nib,
            'lokasi_nib' => $lokasi_nib

            // Add more fields as needed
        );

        $save = $this->db->insert('pelayanan_nib', $data);

        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : 0;
        // return $save;

	}
  public function get_pegawai() {
    $result = array();
    $sql = "SELECT * FROM tmpegawai WHERE unitkerja_id = 1 OR unitkerja_id = 0 ORDER BY n_pegawai ASC";
    $result = $this->db->query($sql)->result();
    return $result;
  }
}