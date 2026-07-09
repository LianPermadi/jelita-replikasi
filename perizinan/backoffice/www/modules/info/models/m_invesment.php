<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 22 Jul 2020
 *
 */

class m_invesment extends Model
{
    private $invest_db;

    public function __construct() {
        parent::__construct();
        $this->invest_db = $this->load->database('invest', TRUE);
    }

    public function get_data() {
        $invest_db = $this->load->database('invest', TRUE); // koneksi ke DB 'invest'
        $sql = "SELECT * FROM `investasi`"; // gak perlu sebut nama DB lagi karena koneksi udah ke sana

        $result = $invest_db->query($sql)->result();

        return $result;
    }

    public function get_data_setting() {
        $sql = "SELECT * FROM event_setting";
        return $this->invest_db->query($sql)->result();
    }

    public function get_data_setting_by_id($id) {
        $id = intval($id);
        $sql = "SELECT * FROM event_setting WHERE id = ?";
        $query = $this->invest_db->query($sql, array($id));
        if ($query === FALSE) {
            log_message('error', 'Query gagal di get_data_setting_by_id');
            return [];
        }
        return $query->row();
    }
    public function all_data_rundown() {
        $sql = "SELECT * FROM jadwal_acara";
        $query = $this->invest_db->query($sql);
        if ($query === FALSE) {
            log_message('error', 'Query gagal di all_data_rundown');
            return [];
        }
        return $query->result();
    }
    public function get_sectors() {
        $sql = "SELECT title, Id AS id, isBahasa FROM westjavasectormanagement";
        return $this->invest_db->query($sql)->result_array();
    }

    public function store_with_query($data) {
        $query = $this->invest_db->insert_string('investasi', $data);
        $this->invest_db->query($query);
    }

    public function store_event_setting_with_query($data) {
        $query = $this->invest_db->insert_string('event_setting', $data);
        $this->invest_db->query($query);
    }

    public function Update_event_setting_with_query($id, $data) {
        $this->invest_db->where('id', intval($id));
        $this->invest_db->set('nama_event', $data['nama_event']);
        $this->invest_db->set('jumlah', $data['jumlah']);
        $this->invest_db->set('status_setting_event', $data['status_setting_event']);
        $result = $this->invest_db->update('event_setting');
        return $this->invest_db->affected_rows() > 0;
    }

    public function get_by_id_homepage($id) {
        $sql = "SELECT * FROM investasiptsp_v2_db.homepage WHERE isBahasa = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    public function get_homepage_v2() {
        $sql = "SELECT * FROM investasiptsp_v2_db.homepage_v2";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function update_setting($data) {
        $this->invest_db->where('id', intval($data['id']));
        $this->invest_db->set('status_setting_event', $data['status_setting_event']);
        $this->invest_db->update('event_setting');
        
        // Debug bantu cek query
        // echo $this->db->get_compiled_select(); die;
        return $this->invest_db->affected_rows() > 0;
    }

    public function q_update_status_content($data) {
        $this->invest_db->where('invest_id', intval($data['invest_id']));
        $this->invest_db->set('status_content', $data['status_content']);
        $this->invest_db->update('investasi');
        return $this->invest_db->affected_rows() > 0;
    }

    public function get_attedance() {
        $sql = "SELECT * FROM guest_information";
        return $this->invest_db->query($sql)->result();
    }

    public function get_data_guest_byId($id) {
        $sql = "SELECT * FROM guest_information WHERE id = ?";
        return $this->invest_db->query($sql, array(intval($id)))->row();
    }

    public function get_data_event_setting_selection($id = null) {
        // Note: Parameter $id tidak digunakan. Bisa dihapus jika tidak dipakai.
        $sql = "SELECT jumlah FROM event_setting WHERE nama_event = 'Ceremony'";
        return $this->invest_db->query($sql)->row();
    }
}
?>