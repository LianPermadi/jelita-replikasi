<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author Arif Ahmadi
 * Created :  05-01-2022
 *
 */

class M_nib extends Model {
    public function edit_nib($id) {
        $result = array();
        $sql = "SELECT *  FROM `pelayanan_nib` WHERE `id` = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function edit_akun($id) {
        $result = array();
        $sql    = "SELECT *  FROM `public`.`event` WHERE `id` = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_gpt_id($id) {
        $result = array();
        $sql = "SELECT *  FROM `public`.`pelayanan_gpt` WHERE `id` = $id";
        $result = $this->db->query($sql)->first_row();
        return $result;
    }
    public function data_gpt_by_nik($nik) {
        $sql = "SELECT lg.layanan 
                FROM `public`.`pelayanan_gpt` pg
                JOIN `public`.`tb_layanan_gpt` lg ON pg.layanan_gpt = lg.id
                WHERE pg.`nik` LIKE ?";
        return $this->db->query($sql, ['%' . $nik . '%'])->result();
    }
    
    
    public function layanan_gpt($id) {
        $result = array();
        $sql = "SELECT *  FROM `public`.`tb_layanan_gpt` WHERE `id` = $id";
        $result = $this->db->query($sql)->first_row();
        return $result;
    }

    public function layanan_status_gpt_prov($id) {
        $result = array();
        $sql = "SELECT *  FROM `public`.`tb_layanan_gpt` WHERE `kode_kab` = $id";
        $result = $this->db->query($sql)->first_row();
        return $result;
    }

    public function tb_layanan_gpt() {
        $result = array();
        $sql = "SELECT *  FROM `public`.`tb_layanan_gpt`";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    
    public function get_data_nib($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
            FROM pelayanan_nib 
            WHERE (DATE(tanggal) BETWEEN ? AND ?) 
            ORDER BY  id ASC";

            $result = $this->db->query($sql, array($tgla, $tglb))->result();

        return $result;
    }
    
    public function get_pegawai() {
        $result = array();
        $sql = "SELECT * FROM tmpegawai";

            $result = $this->db->query($sql)->result();

        return $result;
    }
    
    public function get_n_pegawai($id) {
        $data = " - ";

        if ($data != "0") {
        	$pegawai = $this->db->select('n_pegawai')
	                     ->from('tmpegawai')
	                     ->where('id', $id)
	                     ->get()->row();

	        if (!empty($pegawai->n_pegawai)) {
	            $data = $pegawai->n_pegawai;
	        }
        }
        
        return $data;
    }

    public function on_mic($id) {
        $data = '';
        $pegawai = $this->db->select('id')
                            ->from('pelayanan_panggil')
                            ->where('id_nib', $id)
                            ->get()
                            ->row();  // Use the row() method to get the first row

        if (!empty($pegawai->id)) {
            $data = $pegawai->id;
        }

        return $data;
    }

    public function get_user_loket($id) {
        $data = " 0 ";

        	$pegawai = $this->db->select('loket')
	                     ->from('user')
	                     ->where('id', $id)
	                     ->get()->row();

	        if (!empty($pegawai->loket)) {
	            $data = $pegawai->loket;
	        }
        
        return $data;
    }

	public function update_loket($id, $loket){
        $iduser         = $this->session->userdata('id_auth');
        $update = array(
            'loket' => $loket
            // Add more fields as needed
        );

        $this->db->where('id', $iduser);
        $save = $this->db->update('user', $update);
    // var_dump($save);die();

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;
        // return $save;

	}

	public function cek_status_panggil($id){
        $iduser         = $this->session->userdata('id_auth');
        $update = array(
            'status_panggil' => 1
            // Add more fields as needed
        );
        $this->db->where('id', $id);
        $save = $this->db->update('public.pelayanan_gpt', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;
        // return $save;

	}

	public function update_akun_gpt($id, $n_event, $lokasi, $username, $password, $level, $session_token){
        $iduser         = $this->session->userdata('id_auth');
        $update = array(
            'n_event' => $n_event,
            'lokasi' => $lokasi,
            'username' => $username,
            'password' => $password,
            'level' => $level,
            'session_token' => ''
            // Add more fields as needed
        );

        $this->db->where('id', $id);
        $save = $this->db->update('public.event', $update);
    // var_dump($save);die();

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;
        // return $save;

	}
    
    public function cek_status($id, $iduser) {
        $data = NULL;

        if ($data != "0") { 
        	$pegawai = $this->db->select('id_user')
	                     ->from('pelayanan_panggil')
	                     ->where('id_nib', $id)
	                     ->get()->row();

	        if (!empty($pegawai->id_user)) {
	            $data = $pegawai->id_user;
	        }
        }
            return $data;
    }

public function cek_status_gpt($id, $iduser, $nik) {
    // Menyusun query untuk memeriksa status_panggil berdasarkan nik
    $this->db->select('status_panggil');
    $this->db->from('public.pelayanan_gpt');
    $this->db->where('nik', $nik);
    $this->db->where('(status_panggil = 1)', NULL, FALSE);

    // Menjalankan query dan mengambil hasilnya
    $query = $this->db->get();

    // Memeriksa apakah hasilnya ada
    if ($query->num_rows() > 0) {
        return $query->row()->status_panggil;
    } else {
        return NULL; // Jika tidak ada hasil
    }
}

    public function cek_suara($id, $iduser) {
        $data = NULL;
        if ($data !== "0") { 
            $result = $this->db->select('id')
                            ->from('pelayanan_panggil')
                            ->where('id_nib', $id)
                            ->get()->row();

                    if (!empty($result->id)) {
                        $data = $result->id;
                    }
        }
        return $data;
    }

    public function layanan_gpt_byid($id) {
        $sql = "SELECT *
                FROM public.pelayanan_gpt 
                WHERE id = $id"; 
        $query = $this->db->query($sql)->first_row();
        
        return $query;
    }

    public function cek_suara_gpt($id, $iduser) {
        $data = NULL;
        if ($data !== "0") { 
            $result = $this->db->select('id')
                            ->from('public.panggil_antrian')
                            ->where('id_relasi', $id)
                            ->get()->row();

                    if (!empty($result->id)) {
                        $data = $result->id;
                    }
        }
        return $data;
    }

	public function ubah_status_bynik($nik){
        $iduser         = $this->session->userdata('id_auth');
        // var_dump($iduser);die();
        $update = array(
            'no_antri_tidak_langsung' => 1
            // Add more fields as needed
        );

        $this->db->where('nik', $nik);
        $save = $this->db->update('public.pelayanan_gpt', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}

	public function batal_antri_bynik($nik){
        $iduser         = $this->session->userdata('id_auth');
        // var_dump($iduser);die();
        $update = array(
            'no_antri_tidak_langsung' => 0
            // Add more fields as needed
        );

        $this->db->where('nik', $nik);
        $save = $this->db->update('public.pelayanan_gpt', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}

	public function status_panggil($id){
        $iduser         = $this->session->userdata('id_auth');
        // var_dump($iduser);die();
        $update = array(
            'status' => 1,
            'status_panggil' => 1,
            'user_manggil' => $iduser
            // Add more fields as needed
        );

        $this->db->where('id', $id);
        $save = $this->db->update('pelayanan_nib', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}

	public function status_panggil_gpt($id){
        $iduser         = $this->session->userdata('id_auth');
        // var_dump($iduser);die();
        $update = array(
            'status' => 1,
            'status_panggil' => 1,
            'user_manggil' => $iduser
            // Add more fields as needed
        );

        $this->db->where('id', $id);
        $save = $this->db->update('public.pelayanan_gpt', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}

    public function akun_antrian() {
        $result = array();
        $sql = "SELECT *  FROM `public`.`event`";
        $result = $this->db->query($sql)->result();
        return $result;
    }

	public function status_panggil_gpt_selesai($id, $status){
        $iduser         = $this->session->userdata('id_auth');
        // var_dump($iduser);die();
        $update = array(
            'status_panggil' => $status
            // Add more fields as needed
        );

        $this->db->where('id', $id);
        $save = $this->db->update('public.pelayanan_gpt', $update);
        // Gunakan parameterized query untuk select
        $sql = "SELECT * FROM public.panggil_antrian WHERE id_relasi = ?";
        $antrian = $this->db->query($sql, array($id))->row();

        if (!empty($antrian)) {
            // Gunakan parameterized query untuk delete
            $sql_delete_antrian = "DELETE FROM public.panggil_antrian WHERE id_relasi = ?";
            $this->db->query($sql_delete_antrian, array($id));
        }
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}

	public function batal_panggil_gpt($id){
        $iduser = $this->session->userdata('id_auth');
        // var_dump($iduser);die();

        $update = array(
            'status' => 0,
            'status_panggil' => 0,
            'user_manggil' => NULL
            // Tambahkan kolom lain jika diperlukan
        );

        // Gunakan query builder untuk update data
        $this->db->where('id', $id);
        $save = $this->db->update('public.pelayanan_gpt', $update);

        // Gunakan parameterized query untuk select
        // $sql = "SELECT * FROM public.panggil_antrian WHERE id_relasi = ?";
        // $antrian = $this->db->query($sql, array($id))->row();

        if ($save) {
            // Gunakan parameterized query untuk delete
            $sql_delete_antrian = "DELETE FROM public.panggil_antrian WHERE id_relasi = ?";
            $this->db->query($sql_delete_antrian, array($id));
            // Gunakan parameterized query untuk delete
            $sql_panggil_antrian_all = "DELETE FROM public.panggil_antrian_all WHERE id_relasi = ?";
            $this->db->query($sql_panggil_antrian_all, array($id));
            // Gunakan parameterized query untuk delete
            $sql_display_log = "DELETE FROM public.display_log WHERE tenan = ?";
            $this->db->query($sql_display_log, array($id));
        }

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;

	}
    
    public function user_nib_langsung($id) {
        $data = NULL;

            if ($data !== "0") { 
                $result = $this->db->select('nib_langsung')
                                ->from('user')
                                ->where('id', $id)
                                ->get()->row();

                        if (!empty($result)) {
                            $data = $result->nib_langsung;
                        }
            }
            return $data;
    }

    public function nib_langsung() {
        $data = NULL;

            if ($data !== "0") { 
                $result = $this->db->select('status')
                                ->from('settings')
                                ->where('name', 'nib_langsung')
                                ->get()->row();

                        if (!empty($result)) {
                            $data = $result->status;
                        }
            }
            return $data;
    }

	public function ubah_switch_on(){
        // var_dump($iduser);die();
        $update = array(
            'status' => 1
            // Add more fields as needed
        );

        $this->db->where('name', 'nib_langsung');
        $save = $this->db->update('settings', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}
    
	public function ubah_switch_off(){
        // var_dump($iduser);die();
        $update = array(
            'status' => 0
            // Add more fields as needed
        );

        $this->db->where('name', 'nib_langsung');
        $save = $this->db->update('settings', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;

	}
    
    public function insert_panggil($id, $keterangan,$iduser, $antri, $loket){
    $insert = array(
            'keterangan' => $keterangan,
            'id_nib' => $id,
            'status' => 0,
            'id_user' => $iduser,
            'no_antri' => $antri,
            'loket' => $loket
        );
        $save1 = $this->db->insert('pelayanan_panggil', $insert);
        return $save1;
    }

    public function insert_panggil_gpt($id, $keterangan, $iduser, $antri, $loket, $lokasi, $antrian_id,$status_prov){
    $insert = array(
            'keterangan' => $keterangan,
            'nik' => $id,
            'status' => 0,
            'kab_kota' => $lokasi,
            'id_user' => $iduser,
            'id_relasi' => $antrian_id,
            'layanan' => $loket,
            'no_antri' => $antri,
            'loket' => $loket,
            'status_prov' => $status_prov
        );
        $save1 = $this->db->insert('public.panggil_antrian', $insert);
        return $save1;
    }
    
    public function insert_panggil_gpt_all($id, $keterangan, $iduser, $antri, $loket, $lokasi, $antrian_id,$status_prov){
    $insert = array(
            'keterangan' => $keterangan,
            'nik' => $id,
            'status' => 0,
            'kab_kota' => $lokasi,
            'id_user' => $iduser,
            'id_relasi' => $antrian_id,
            'layanan' => $loket,
            'no_antri' => $antri,
            'loket' => $loket,
            'status_prov' => $status_prov
        );
        $save1 = $this->db->insert('public.panggil_antrian_all', $insert);
        return $save1;
    }

	public function save_data_update($id, 
    $nib_number, 
    $kbli_number, 
    $nik, 
    $phone_number, 
    $email, 
    $name_ktp, 
    $birthdate, 
    $address_ktp, 
    $district_ktp, $subdistrict_ktp, $business_type, 
    $business_name, $business_address, $district_business, $start_date, 
    $business_capital, $annual_income, $accompanying_officer, $location, 
    $event_name, $event_location, $land_area, $employees_number, $newFileName, 
    $newFileNamepdf, $petugas_kbli, $petugas_nib,$kapasitas_produksi,$lama_usaha,$kegiatan,
    $user_nib_pemohon,$password_nib_pemohon, $layanan,$subdistrict_business,$postal_code_business){
        
        $iduser         = $this->session->userdata('id_auth');
        $insert = array(
            'id_user' => $iduser,
            'status' => '1',
            'id_pelayanan_nib' => $id
        );
        $save1 = $this->db->insert('pelayanan_nib_logs', $insert);

        $update = array(
            'nib' => $nib_number,
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
            'modal_usaha' => $business_capital,	
            'jumlah_tenaga_kerja' => $employees_number,	
            'pndapatan' => $annual_income,	
            'petugas_pendamping' => $accompanying_officer,	
            'lokasi' => $location,
            'event' => $event_name,
            'user' => $iduser,
            'layanan' => $layanan,
            'lokasi_event' => $event_location,
            'file' => $newFileName,
            'file_nib_pdf' => $newFileNamepdf,
            'petugas_kbli' => $petugas_kbli,
            'petugas_nib' => $petugas_nib,
            'kapasitas_produksi_pertahun' => $kapasitas_produksi,
            'lama_usaha' => $lama_usaha,
            'kegiatan' => $kegiatan,
            'user_nib_pemohon' => $user_nib_pemohon,
            'password_nib_pemohon' => $password_nib_pemohon,
            'status' => 2,
            'kelurahan_usaha' => $subdistrict_business,
            'kode_pos_tempat_usaha' => $postal_code_business,
            'status_panggil' => 2
            // Add more fields as needed
        );
        // var_dump($address_ktp,$district_ktp,$subdistrict_ktp);die();

        // var_dump($update);die();

        $this->db->where('id', $id);
        $save = $this->db->update('pelayanan_nib', $update);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $save;
        // return $save;

	}
    
    public function hapus_nib($id) {
        $iduser         = $this->session->userdata('id_auth');
        $insert = array(
            'id_user' => $iduser,
            'status' => '0',
            'id_pelayanan_nib' => $id
        );
        $save1 = $this->db->insert('pelayanan_nib_logs', $insert);
        $del = $this->db->delete('pelayanan_nib', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }
 
    public function mute_hapus_mic($id) {
        $del = $this->db->delete('pelayanan_panggil', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }
    public function postWaSms($n_hp = null, $n_pesan = null, $campaign = null)
    {
      $settings = "SELECT * FROM db_sicantik_backoffice.settings WHERE `name` LIKE 'smsGateway'";
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


}
