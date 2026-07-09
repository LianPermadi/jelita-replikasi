<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author PBS
 * Created : 24 Jul 2024
 *
 */

class m_invesment extends Model{
	
  public function get_data(){
    $sql = "SELECT * FROM `investasiptsp_v2_db`.`investasi`";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  public function tamu_detail($id) {
    // Pastikan ID di-safe dan bersih
    $id = intval($id); // Pastikan ID adalah integer

    // Menyusun query SQL dengan WHERE clause
    $sql = "SELECT * FROM `investasiptsp_v2_db`.`guest_information` WHERE id = ?";
    
    // Menjalankan query dengan parameter
    $query = $this->db->query($sql, array($id));
    
    // Mengembalikan hasil sebagai objek
    return $query->row(); // row() digunakan untuk mendapatkan satu baris data
  }

  
  public function get_attedance(){
    $sql = "SELECT * FROM `investasiptsp_v2_db`.`guest_information` ORDER BY `id` DESC";
    $result = $this->db->query($sql)->result();
    return $result;
  }
  public function get_data_unconfirm($status) {
    // Pastikan $status aman untuk digunakan dalam query
    $status = intval($status); // Jika $status adalah integer 
    $sql = "SELECT * FROM `investasiptsp_v2_db`.`guest_information` WHERE `status` = ?";
    $result = $this->db->query($sql, array($status))->result();
    return $result;
}
  public function get_data_project_excel($status) {
    // Pastikan $status aman untuk digunakan dalam query
    $status = intval($status); // Jika $status adalah integer 
    $sql = "SELECT * FROM `investasiptsp_v2_db`.`investasi` WHERE `status_content` = ?";
    $result = $this->db->query($sql, array($status))->result();
    return $result;
  }

  
  public function get_row_attedance($id=null){
    $data = $this->db->select('*')
                 ->from('investasiptsp_v2_db.guest_information')
                 ->where('id', $id)
                 ->get()->row();
    return $data;
  }
  public function get_souvenir_data(){
    $sql = "SELECT 
                SUM(souvenir) AS souvenir,
                SUM(souvenir_bank_indonesia) AS souvenir_bank_indonesia,
                SUM(CASE WHEN souvenir_recipient NOT LIKE '0000-00-00 00:00:00' THEN 1 ELSE 0 END) AS total_souvenir,
                SUM(CASE WHEN souvenir_recipient_bank_indonesia NOT LIKE '0000-00-00 00:00:00' THEN 1 ELSE 0 END) AS total_souvenir_bank_indonesia
            FROM 
                `investasiptsp_v2_db`.`guest_information`";
    $result = $this->db->query($sql)->result();
    return $result;
}

  public function get_user($id=null){
    $data = $this->db->select('*')
                 ->from('user')
                 ->where('id', $id)
                 ->get()->row();
    return $data;
  }
  
  public function update_proses($id_tamu=null, $id_user = null) {
    $data = array('id_pegawai' => $id_user,
                  'status' => 1
                 );
    $this->db->where('id', $id_tamu);
    $save = $this->db->update('investasiptsp_v2_db.guest_information', $data);
    if($save){
      $return = true;
    }else{
      $return = false;
    }
    return $return;
  }
  
     public function get_data_setting() {
        $sql = "SELECT * FROM `investasiptsp_v2_db`.`event_setting`";

        $result = $this->db->query($sql)->result();
        // var_dump($result);die();

        return $result;
    }
    public function get_sectors() {
        $sql = "SELECT title, Id AS id, isBahasa FROM `investasiptsp_v2_db`.`westjavasectormanagement`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function store_with_query($data) {
        // Menyimpan data investasi dengan query SQL
        $query = $this->db->insert_string('investasiptsp_v2_db.investasi', $data);
        $this->db->query($query);
    }
    
    public function update_setting($data) {
        // var_dump($data);die(); // Ini bisa Anda hapus setelah memastikan semuanya berjalan baik
        $this->db->where('id', $data['id']);
        $this->db->set('status_setting_event', $data['status_setting_event']);
        $this->db->update('investasiptsp_v2_db.event_setting');

        return $this->db->affected_rows() > 0; // Mengembalikan true jika ada baris yang terpengaruh
    }
      public function update_status_terkirim_whatsapp($data) {
          // var_dump($data);die(); // Ini bisa Anda hapus setelah memastikan semuanya berjalan baik
          $this->db->where('id', $data['id']);
          $this->db->set('status_send_wa_email', $data['status_send_wa_email']);
          $this->db->set('sum_notif', $data['sum_notif']);
          $this->db->update('investasiptsp_v2_db.guest_information');
          return $this->db->affected_rows() > 0; // Mengembalikan true jika ada baris yang terpengaruh
      }
      public function get_data_rowndown() {
        $sql = "SELECT * FROM `investasiptsp_v2_db`.`jadwal_acara` 
                WHERE status_tampil = 1 OR status_tampil = 2";
        
        $result = $this->db->query($sql)->result();
        // var_dump($result);die();
        
        return $result;
    }
    public function postWaSms($n_hp = null, $n_pesan = null, $campaign = null)
    {
        $settings = "SELECT * FROM db_sicantik_backoffice.settings WHERE `name` LIKE 'smsGateway'";
        $settings = $this->db->query($settings)->result();
        $statsms = $settings[0]->status;
        
        if($statsms == '1') {
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
          // var_dump($response);die();
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
              // echo "Ada Yang Error Kirim SMS: " . $json->message . " " . $json->status;
              return $result;
              // die;
            }
          }
        }
        return;
    }
    
    public function all_data_rundown() {
      $sql = "SELECT * FROM `investasiptsp_v2_db`.`jadwal_acara`";
  
      $result = $this->db->query($sql)->result();
      // var_dump($result);die();
  
      return $result;
    }
    
    public function get_data_event_selection($id) {
      $sql = "SELECT * FROM `investasiptsp_v2_db`.`guest_event_selection` WHERE guest_id = $id";
  
      $result = $this->db->query($sql)->result();
      // var_dump($result);die();
  
      return $result;
    }

    public function get_data_event_selection_one_on_meeting($id) {
      $sql = "SELECT * FROM `investasiptsp_v2_db`.`guest_event_selection_one_on_meeting` WHERE guest_id = $id";
  
      $result = $this->db->query($sql)->result();
      // var_dump($result);die();
  
      return $result;
    }
  
    public function q_update_guest_information($data) {
      if (!isset($data['id'])) {
          return false;
      }
  
      $sql = "UPDATE investasiptsp_v2_db.guest_information SET 
                  full_name = ?, 
                  phone_number = ?, 
                  address = ?, 
                  email = ?, 
                  date_of_birth = ?, 
                  status = ?, 
                  keterangan = ?,
                  countries = ?, 
                  investation = ?, 
                  position = ?, 
                  company = ?, 
                  id_pegawai = ?,
                  souvenir = ?,
                  souvenir_bank_indonesia = ?,
                  no_kursi = ?,
                  RSVP_Information = ?
              WHERE id = ?";
  
      $params = array(
          isset($data['full_name']) ? $data['full_name'] : null,
          isset($data['phone_number']) ? $data['phone_number'] : null,
          isset($data['address']) ? $data['address'] : null,
          isset($data['email']) ? $data['email'] : null,
          isset($data['date_of_birth']) ? $data['date_of_birth'] : null,
          isset($data['status']) ? $data['status'] : null,
          isset($data['keterangan']) ? $data['keterangan'] : null,
          isset($data['countries']) ? $data['countries'] : null,
          isset($data['investation']) ? $data['investation'] : null,
          isset($data['position']) ? $data['position'] : null,
          isset($data['company']) ? $data['company'] : null,
          isset($data['id_pegawai']) ? $data['id_pegawai'] : null,
          isset($data['souvenir']) ? $data['souvenir'] : null,
          isset($data['souvenir_bank_indonesia']) ? $data['souvenir_bank_indonesia'] : null,
          isset($data['no_kursi']) ? $data['no_kursi'] : null,
          isset($data['RSVP_Information']) ? $data['RSVP_Information'] : null,
          $data['id']
      );
      // var_dump($data);die();
  
      $this->db->query($sql, $params);
      return $this->db->affected_rows() > 0;
  }
  
  public function update_guest_event_selection($guest_id, $event_id_integers) {
      // Hapus entri lama
    // var_dump($event_id_integers);die();

      $this->db->where('guest_id', $guest_id);
      $this->db->delete('investasiptsp_v2_db.guest_event_selection');
  
      // Tambahkan entri baru
      foreach ($event_id_integers as $event_id) {
          $data = array(
              'guest_id' => $guest_id,
              'project_presentasion_event_id' => $event_id
          );
          $this->db->insert('investasiptsp_v2_db.guest_event_selection', $data);
      }
  }
  public function update_guest_event_selection_one_on_one_meeting($guest_id, $one_on_one_meeting_event_id_integers) {
    // Hapus entri lama

    $this->db->where('guest_id', $guest_id);
    $this->db->delete('investasiptsp_v2_db.guest_event_selection_one_on_meeting');

    // Tambahkan entri baru
    foreach ($one_on_one_meeting_event_id_integers as $event_id) {
        $data = array(
            'guest_id' => $guest_id,
            'one_on_one_meeting_id' => $event_id
        );
        $this->db->insert('investasiptsp_v2_db.guest_event_selection_one_on_meeting', $data);
  }


}
  public function q_delete_kehadiran($id) {
    // Mulai transaksi
    $this->db->trans_start();

    // Hapus entri lama
    $this->db->where('guest_id', $id);
    $this->db->delete('investasiptsp_v2_db.guest_event_selection_one_on_meeting');

    $this->db->where('guest_id', $id);
    $this->db->delete('investasiptsp_v2_db.guest_event_selection');

    $this->db->where('id', $id);
    $this->db->delete('investasiptsp_v2_db.guest_information');

    // Selesaikan transaksi
    $this->db->trans_complete();

    // Cek apakah transaksi berhasil
    if ($this->db->trans_status() === FALSE) {
        return false;
    } else {
        return true;
    }
  }
  public function get_data_event_setting_ceremony_selection() {
    $sql = "SELECT jumlah FROM `investasiptsp_v2_db`.`event_setting` WHERE nama_event = 'Ceremony'";
    // var_dump($sql);die() ;
    // Menggunakan parameterized query untuk aman dari SQL injection
    $result = $this->db->query($sql, array())->row();
    
    // Mengembalikan satu baris hasil query atau null jika tidak ada data yang sesuai
    return $result;
  }
  public function get_data_event_setting_souvenir_dpmptsp_selection() {
    $sql = "SELECT jumlah FROM `investasiptsp_v2_db`.`event_setting` WHERE nama_event = 'Souvenir DPMPTSP'";
    // var_dump($sql);die() ;
    // Menggunakan parameterized query untuk aman dari SQL injection
    $result = $this->db->query($sql, array())->row();
    
    // Mengembalikan satu baris hasil query atau null jika tidak ada data yang sesuai
    return $result;
  }
  public function get_data_event_setting_souvenir_bank_indonesi_selection() {
    $sql = "SELECT jumlah FROM `investasiptsp_v2_db`.`event_setting` WHERE nama_event = 'Souvenir Bank Indonesia'";
    // var_dump($sql);die() ;
    // Menggunakan parameterized query untuk aman dari SQL injection
    $result = $this->db->query($sql, array())->row();
    
    // Mengembalikan satu baris hasil query atau null jika tidak ada data yang sesuai
    return $result;
  }


}
?>