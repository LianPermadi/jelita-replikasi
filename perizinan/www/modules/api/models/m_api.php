<?php
class M_api extends Model {
    public function get_pegawai($id) {
        $sql = "SELECT * FROM spekta_backoffice.tmpegawai WHERE id = '$id' LIMIT 1";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_from_database(){
        $sql = "SELECT 
                    trperizinan.id as id_perizinan, 
                    trperizinan.kd_izin, 
                    trperizinan.n_perizinan, 
                    trperizinan.bid_teknis, 
                    trperizinan.indeks, 
                    tmpermohonan.id as id_permohonan,
                    tmpermohonan.pendaftaran_id,
                    tmpermohonan.id_pemohon_portal,
                    tmpermohonan.a_izin,
                    tmpermohonan.i_entry,
                    trsektor.n_sektor
                FROM 
                    spekta_backoffice.trperizinan 
                JOIN 
                    spekta_backoffice.tmpermohonan_trperizinan 
                ON 
                    spekta_backoffice.tmpermohonan_trperizinan.trperizinan_id = spekta_backoffice.trperizinan.id
                JOIN 
                    spekta_backoffice.tmpermohonan 
                ON 
                    spekta_backoffice.tmpermohonan.id = spekta_backoffice.tmpermohonan_trperizinan.tmpermohonan_id
                JOIN 
                    spekta_backoffice.tmpermohonan_tmsk 
                ON 
                    spekta_backoffice.tmpermohonan_tmsk.tmpermohonan_id = spekta_backoffice.tmpermohonan.id
                JOIN 
                    spekta_backoffice.tmsk 
                ON 
                    spekta_backoffice.tmsk.id = spekta_backoffice.tmpermohonan_tmsk.tmsk_id
                JOIN 
                    spekta_backoffice.trsektor 
                ON 
                    spekta_backoffice.trsektor.id = spekta_backoffice.tmpermohonan.trsektor_id";

                $query = $this->db->query($sql);

                if ($query->num_rows() > 0) {
                    $result = $query->result_array();
                    // Mengonversi hasil kueri menjadi format JSON
                    $json_result = json_encode($result);
                    // Mengembalikan data JSON
                    echo $json_result;
                } else {
                    echo json_encode(array());
                }
    }
}
?>