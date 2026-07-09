<?php
class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();

    }
    protected $table = 'users'; // Ganti dengan nama tabel pengguna di aplikasi Anda

    public function get_users() {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function insert_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
        return $this->db->affected_rows();
    }

    public function get_banner($banner_id)
    {
        $this->db->where('id', $banner_id);
        $query = $this->db->get('banner');
        return $query->row();
    }
}
?>
