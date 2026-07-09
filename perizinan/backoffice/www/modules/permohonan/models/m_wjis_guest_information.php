<?php

class M_wjis_guest_information extends Model{

  function __construct() {
    parent::__construct();
  }

  function tamu_detail($id){
    return $this->db->query("SELECT * FROM `investasiptsp_v2_db`.`guest_information` WHERE id LIKE '$id'")->result();
  }
  public function event_detail($event_ids) {
      $id_array = explode(',', $event_ids);
      $id_array = array_map('trim', $id_array);
      $id_list = implode("','", $id_array);
      $query = "SELECT * FROM `investasiptsp_v2_db`.`jadwal_acara` WHERE id IN ('$id_list')";
      return $this->db->query($query)->result();
  }
   // Method to get event and guest details with joins
   public function get_guest_event_selection_details($guest_id) {
    // Specify the database name
    $database_name = 'investasiptsp_v2_db';

    // Start building the query
    $this->db->select('ja.*, gi.id as guest_information_id, ges.status_checkin, ges.guest_event_selection_id as guest_event_selection_id, ges.tanggal');
    $this->db->from("$database_name.guest_event_selection ges");
    $this->db->join("$database_name.guest_information gi", 'ges.guest_id = gi.id', 'inner');
    $this->db->join("$database_name.jadwal_acara ja", 'ges.project_presentasion_event_id = ja.id', 'inner');
    $this->db->where('gi.id', $guest_id);
    $this->db->limit(25); // Limit the number of records
    $query = $this->db->get();
    return $query->result();
  }
  public function get_guest_event_one_on_one_meeting_selection_details($guest_id) {
    // Specify the database name
    $database_name = 'investasiptsp_v2_db';

    // Start building the query
    $this->db->select('ja.*, gi.id as guest_information_id,ges.status_checkin,ges.guest_event_selection_id,ges.status_checkout, ges.tanggal');
    $this->db->from("$database_name.guest_event_selection_one_on_meeting ges");
    $this->db->join("$database_name.guest_information gi", 'ges.guest_id = gi.id', 'inner');
    $this->db->join("$database_name.jadwal_acara ja", 'ges.one_on_one_meeting_id = ja.id', 'inner');
    $this->db->where('gi.id', $guest_id);
    $this->db->limit(25); // Limit the number of records
    $query = $this->db->get();
    return $query->result();
  }

  public function createMeetingData($data) {
    // Menyimpan data ke tabel `one_on_one_meeting` (atau tabel yang sesuai)
    return $this->db->insert('investasiptsp_v2_db.guest_event_selection_one_on_meeting', $data);
  }
  public function jadwal_acara($id){
    $database_name = 'investasiptsp_v2_db';
    $sql = "SELECT 
                jadwal_acara.id as jadwal_acara_id,
                jadwal_acara.kegiatan,
                jadwal_acara.oom_start as waktu_start,
                jadwal_acara.oom_end as waktu_end,
                jadwal_acara.durasi,
                jadwal_acara.pembicara_talent
            FROM
                $database_name.jadwal_acara
            LEFT JOIN
                $database_name.guest_event_selection_one_on_meeting
            ON
                guest_event_selection_one_on_meeting.one_on_one_meeting_id = jadwal_acara.id
                AND guest_event_selection_one_on_meeting.guest_id = ?
            WHERE
                guest_event_selection_one_on_meeting.one_on_one_meeting_id IS NULL
                AND jadwal_acara.status_tampil = '1'
                AND jadwal_acara.no_urut != 0  -- Tambahkan kondisi ini
            ";

    // Use parameter binding to prevent SQL injection
    return $this->db->query($sql, [$id])->result();
  }



  public function update_absensi($id, $data)
  {
      // Menentukan kondisi WHERE untuk baris yang akan diperbarui
      $this->db->where('guest_event_selection_id', $id);

      // Melakukan pembaruan data
      return $this->db->update('investasiptsp_v2_db.guest_event_selection', $data);
  }
  public function update_absensi_one_on_one_meeting($id, $data)
  {
      // Menentukan kondisi WHERE untuk baris yang akan diperbarui
      $this->db->where('guest_event_selection_id', $id);

      // Melakukan pembaruan data
      return $this->db->update('investasiptsp_v2_db.guest_event_selection_one_on_meeting', $data);
  }
  public function update_absensi_ceremony($id, $data)
  {
      // Menentukan kondisi WHERE untuk baris yang akan diperbarui
      $this->db->where('id', $id);

      // Melakukan pembaruan data
      return $this->db->update('investasiptsp_v2_db.guest_information', $data);
  }
  public function update_souvenir_recipient($id, $data)
  {
      // Menentukan kondisi WHERE untuk baris yang akan diperbarui
      $this->db->where('id', $id);

      // Melakukan pembaruan data
      return $this->db->update('investasiptsp_v2_db.guest_information', $data);
  }
  public function query_tambah_data_oom_by_user($id, $data)
  {
      // Menentukan kondisi WHERE untuk baris yang akan diperbarui
      $this->db->where('id', $id);

      // Melakukan pembaruan data
      return $this->db->update('investasiptsp_v2_db.guest_information', $data);
  }

}
?>