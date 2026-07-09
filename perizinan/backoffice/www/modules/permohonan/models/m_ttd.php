<?php
class M_ttd extends Model {
    public function get_pegawai($id) {
        $sql = "SELECT * FROM spekta_backoffice.tmpegawai WHERE id = '$id' LIMIT 1";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}
?>