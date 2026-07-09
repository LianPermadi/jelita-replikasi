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

class M_Pengembangan extends Model {
    public function get_data($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
            FROM pengembangan 
            WHERE (DATE(tanggal) BETWEEN ? AND ?) 
            ORDER BY  tanggal";

            $result = $this->db->query($sql, array($tgla, $tglb))->result();

        return $result;
    }

    
    // public function get_data_nib($tgla = NULL, $tglb = NULL) {
    //     $result = array();
    //     	$sql = "SELECT * 
    //               FROM pelayanan_nib 
    //               WHERE (DATE(tanggal) BETWEEN ? AND ?) 
    //               ORDER BY 
    //                 no_antri ASC"; 
    //             //ORDER BY DATE(tanggal) desc";
    //             $result = $this->db->query($sql, array($tgla, $tglb))->result();
    //     return $result;
    // }
    public function get_data_nib($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
                FROM pelayanan_nib 
                WHERE (DATE(tanggal) BETWEEN ? AND ?)
                AND (status_pelayanan IS NULL OR status_pelayanan = '' OR (status_pelayanan <> '1' AND status_pelayanan <> '7'))"; 
        $result = $this->db->query($sql, array($tgla, $tglb))->result();
        return $result;
    }
    public function get_data_nib_tidak_langsung($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
                FROM pelayanan_nib 
                WHERE (DATE(tanggal) BETWEEN ? AND ?) 
                AND (status_pelayanan = 1) 
                ORDER BY 
                status_panggil ASC"; 
        $result = $this->db->query($sql, array($tgla, $tglb))->result();
        return $result;
    }
public function query_get_data_gpt($tgla = NULL, $tglb = NULL, $layanan_gpt = NULL, $leveling = NULL) {
    // Pastikan parameter tanggal tidak NULL
    if (is_null($tgla) || is_null($tglb)) {
        return []; // Mengembalikan array kosong jika tanggal tidak diberikan
    }

    // Siapkan query dengan parameter binding
if ($layanan_gpt == NULL) {
    $sql = "
        SELECT * 
        FROM public.pelayanan_gpt 
        WHERE DATE(tanggal) BETWEEN ? AND ?
        ORDER BY 
            CASE 
                WHEN status_panggil = 1 THEN 1
                WHEN status_panggil = 0 THEN 2
                WHEN status_panggil = 2 THEN 3
                ELSE 4
            END ASC,
            tanggal ASC"; // Urutkan tanggal setelah status_panggil
    $query = $this->db->query($sql, array($tgla, $tglb));
} else {
    $sql = "
        SELECT * 
        FROM public.pelayanan_gpt 
        WHERE DATE(tanggal) BETWEEN ? AND ?
        AND layanan_gpt LIKE ?
        ORDER BY 
            CASE 
                WHEN status_panggil = 1 THEN 1
                WHEN status_panggil = 0 THEN 2
                WHEN status_panggil = 2 THEN 3
                ELSE 4
            END ASC,
            tanggal ASC"; // Urutkan tanggal setelah status_panggil
    $query = $this->db->query($sql, array($tgla, $tglb, $layanan_gpt));
}


    if($leveling == 'admin'){
        var_dump($query->result());die();
    }

    // Mengembalikan hasil sebagai array
    return $query->result();
}
public function query_get_data_gpt_fetch($tgla = NULL, $tglb = NULL, $layanan_gpt = NULL, $leveling = NULL) {
    // Pastikan parameter tanggal tidak NULL
    if (is_null($tgla) || is_null($tglb)) {
        return []; // Mengembalikan array kosong jika tanggal tidak diberikan
    }
    // Siapkan query dengan parameter binding
if ($layanan_gpt == NULL) {
    $sql = "
        SELECT * 
        FROM public.pelayanan_gpt 
        WHERE DATE(tanggal) BETWEEN ? AND ?
        AND status_tamu = '0'
        AND status_gpt_prov = '0'
        AND status_checkin = '1'
        ORDER BY 
            CASE 
                WHEN status_panggil = 1 THEN 1
                WHEN status_panggil = 0 THEN 2
                WHEN status_panggil = 2 THEN 3
                ELSE 4
            END ASC,
            tanggal ASC"; // Urutkan tanggal setelah status_panggil
    $query = $this->db->query($sql, array($tgla, $tglb));
} else {
    $sql = "
        SELECT * 
        FROM public.pelayanan_gpt 
        WHERE DATE(tanggal) BETWEEN ? AND ?
        AND layanan_gpt LIKE ?
        AND status_tamu = '0'
        AND status_gpt_prov = '0'
        AND status_checkin = '1'
        ORDER BY 
            CASE 
                WHEN status_panggil = 1 THEN 1
                WHEN status_panggil = 0 THEN 2
                WHEN status_panggil = 2 THEN 3
                ELSE 4
            END ASC,
            tanggal ASC"; // Urutkan tanggal setelah status_panggil
    $query = $this->db->query($sql, array($tgla, $tglb, $layanan_gpt));
}

    if($leveling == 'admin'){
        var_dump($query->result());die();
    }

    // Mengembalikan hasil sebagai array
    return $query->result();
}

public function query_get_data_gpt_fetch_kab_kota($tgla = NULL, $tglb = NULL, $layanan_gpt = NULL, $leveling = NULL) {
    // Pastikan parameter tanggal tidak NULL
    if (is_null($tgla) || is_null($tglb)) {
        return []; // Mengembalikan array kosong jika tanggal tidak diberikan
    }
    
    // Query untuk mendapatkan data kab/kota berdasarkan layanan_gpt
    $sel = "SELECT * FROM `public`.`tb_layanan_gpt` WHERE kode_kab != 0 AND id = ?";
    $kab_kota = $this->db->query($sel, array($layanan_gpt))->first_row();

    if(!empty($kab_kota)){
        $sql = "SELECT * 
            FROM `public`.`pelayanan_gpt` 
            WHERE status_gpt_prov = ? ";
        // var_dump($sql);die();
        $query = $this->db->query($sql, array($kab_kota->kode_kab));
    }

    return $query->result();
}

public function get_layanan_gpt($id) {
    $sql = "SELECT * 
            FROM public.tb_layanan_gpt 
            WHERE id = '$id'"; 

    $result = $this->db->query($sql)->first_row();

    // Debugging
    if (!$result) {
        log_message('error', "Data layanan GPT dengan ID $id tidak ditemukan.");
    }

    return $result ? $result->instansi_lembaga : null;
}

public function layanan_gpt() {
    $result = array();
    $sql = "SELECT id, layanan 
            FROM public.tb_layanan_gpt 
            WHERE layanan != '' AND layanan IS NOT NULL"; 
    $query = $this->db->query($sql);
    
    $result[0] = '-';
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $result[$row->id] = $row->layanan; // Key-value pair
        }
    }
    
    return $result;
}

    public function get_data_gpt($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
                FROM pelayanan_nib 
                WHERE (DATE(tanggal) BETWEEN ? AND ?) 
                AND (status_pelayanan = 7) 
                ORDER BY 
                status_panggil ASC"; 
        $result = $this->db->query($sql, array($tgla, $tglb))->result();
        return $result;
    }

    public function grapik_petugas($tglc, $tgld){
        $sql = "SELECT 
                    user as user_identifier,
                    user,
                    COUNT(user) AS jumlah
                FROM 
                    pelayanan_nib 
                WHERE 
                    DATE(tanggal) BETWEEN '$tglc' AND '$tgld'
                    AND user <> 0
                    AND Agen_Nib LIKE ''
                GROUP BY 
                    user
                ORDER BY 
                    jumlah DESC LIMIT 10;
                ";
        // var_dump($sql, $tglc, $tgld);die();
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function grapik_lokasi_event($tglc, $tgld){
        $sql = "SELECT lokasi_event, COUNT(lokasi_event) AS jumlah
                FROM pelayanan_nib 
                WHERE DATE(tanggal) BETWEEN ? AND ?
                AND lokasi_event NOT REGEXP '^[0-9-]+$'
                GROUP BY lokasi_event
                ORDER BY jumlah DESC;";
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function get_nama_user($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function grapik_petugas2($tglc, $tgld){
        // $sql = "SELECT 
        //             user,
        //             Agen_Nib AS user_identifier, 
        //             COUNT(Agen_Nib) AS jumlah
        //         FROM 
        //             pelayanan_nib 
        //         WHERE 
        //             DATE(tanggal) BETWEEN '$tglc' AND '$tgld'
        //             AND Agen_Nib NOT LIKE ''
        //             AND user LIKE 0
        //         GROUP BY 
        //             user_identifier
        //         ORDER BY 
        //             jumlah DESC";
        $sql = "SELECT 
                    Agen_Nib AS user_identifier, 
                    COUNT(Agen_Nib) AS jumlah, 
                    COUNT(CASE WHEN user != 0 THEN 1 ELSE NULL END) AS jumlah_inisiasi, 
                    COUNT(CASE WHEN user = 0 THEN 1 ELSE NULL END) AS jumlah_belum_inisiasi 
                FROM 
                    pelayanan_nib 
                WHERE 
                    DATE(tanggal) BETWEEN '$tglc 00:00:00' AND '$tgld 23:59:59' 
                        AND Agen_Nib <> '' 
                        AND Agen_Nib <> '-' 
                GROUP BY 
                    user_identifier 
                ORDER BY 
                    jumlah DESC";
        // var_dump($sql, $tglc, $tgld);die();
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function grapik_petugas4($tglc, $tgld){
        $sql = "SELECT 
                    user,
                    Agen_Nib AS user_identifier, 
                    COUNT(Agen_Nib) AS jumlah
                FROM 
                    pelayanan_nib 
                WHERE 
                    DATE(tanggal) BETWEEN '$tglc' AND '$tgld'
                    AND Agen_Nib NOT LIKE ''
                GROUP BY 
                    user_identifier
                ORDER BY 
                    jumlah DESC";
        // var_dump($sql, $tglc, $tgld);die();
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function grapik_petugas3($tglc, $tgld){
        $sql = "SELECT 
                    user,
                    Agen_Nib AS user_identifier, 
                    COUNT(Agen_Nib) AS jumlah
                FROM 
                    pelayanan_nib 
                WHERE 
                    DATE(tanggal) BETWEEN '$tglc' AND '$tgld'
                    AND Agen_Nib NOT LIKE ''
                    AND user NOT LIKE 0

                GROUP BY 
                    user_identifier
                ORDER BY 
                    jumlah DESC";
        // var_dump($sql, $tglc, $tgld);die();
        
    // $iduser         = $this->session->userdata('id_auth');
    // if($iduser == 680){
    //   var_dump($sql);die();
    // }
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function grapik_lokasi_event2($tglc, $tgld){
        $sql = "SELECT lokasi_event, COUNT(lokasi_event) AS jumlah
                FROM pelayanan_nib 
                WHERE DATE(tanggal) BETWEEN ? AND ?
                AND lokasi_event NOT REGEXP '^[0-9-]+$'
                AND Agen_Nib NOT LIKE ''
                GROUP BY lokasi_event
                ORDER BY jumlah DESC;";
        $result = $this->db->query($sql, array($tglc, $tgld))->result();
        return $result;
    }
    
    public function get_nama_user2($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_pegawai')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_pegawai)) {
            $data = $pegawai->n_pegawai;
        }
        return $data;
    }

    public function get_kab_kota($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_kabupaten')
            ->from('trkabupaten')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_kabupaten)) {
            $data = $pegawai->n_kabupaten;
        }
        return $data;
    }

      public function get_n_user($id)
    {
        $data = " - BELUM DIINISIASI -";
        $pegawai = $this->db->select('oriname')
            ->from('user')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->oriname)) {
            $data = $pegawai->oriname;
        }
        return $data;
    }

    public function add_pengajuan($iduser, $pengajuan, $desk, $date, $tingkat, $bidang, $nama) {
        $data = array(
                        'isi_pengajuan'     => $pengajuan,
                        'deskripsi_pengembangan'     => $desk,
                        'tanggal'           => $date,
                        'tingkat_kebutuhan' => $tingkat,
                        'bidang'            => $bidang,
                        'nama_pengaju'      => $nama
                     );
        $save = $this->db->insert('pengembangan', $data);
        
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function get_user_id($id_user)
    {
        $jumlah = $this->db->select('tmpegawai_id')
            ->from('tmpegawai_user')
            ->where('user_id', $id_user)
            ->get()->row();

        if (!empty($jumlah->tmpegawai_id)) {
            $data = $jumlah->tmpegawai_id;
        return $data;
        }
    }

    public function get_master() {
        $result = array();
        $sql = "SELECT * FROM ruangan_master";

        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_ruangan() {
        $sql = "SELECT *
                FROM pengembangan";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_datapakai($id) {
        $ruangan = $this->db->select('*')
                     ->from('pengembangan')
                     ->where('id', $id)
                     ->get()->row();

        return $ruangan;
    }

    public function get_datamaster($id) {
        $ruangan = $this->db->select('*')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();

        return $ruangan;
    }

    public function get_nama($id) {
        $data = " - ";
        $ruangan = $this->db->select('nama_ruangan')
                     ->from('ruangan_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->nama_ruangan)) {
            $data = $ruangan->nama_ruangan;
        }
        return $data;
    }

    public function get_seksi($nomor) {
        switch ($nomor) {
            case '1':
                $data = "Evaluasi dan Pelaporan";
                break;
            case '2':
                $data = "Fasilitasi";
                break;
            case '3':
                $data = "Pemantauan dan Pembinaan";
                break;
            case '4':
                $data = "Pengawasan";
                break;
            case '5':
                $data = "Pengaduan dan Advokasi";
                break;
            case '6':
                $data = "Pengembangan Sistem Informasi";
                break;
            case '7':
                $data = "Pengembangan dan Kebijakan";
                break;
            case '8':
                $data = "Pengolahan data";
                break;
            case '9':
                $data = "Promosi dan Kerjasama";
                break;
            case '10':
                $data = "Sektor Ekonomi dan Parawisata";
                break;
            case '11':
                $data = "Sektor Kehutanan lingkungan hidup energi dan sumber daya mineral";
                break;
            case '12':
                $data = "Sektor Pendidikan, Kesehatan dan Sosial";
                break;
            case '13':
                $data = "Sektor Perhubungan Komunikasi dan Informatika";
                break;
            case '14':
                $data = "Sektor Pertanian, Perikanan dan Tenaga Kerja";
                break;
            case '15':
                $data = "Sektor Pertanahan Pekerjaan Umum dan Penataan Ruang";
                break;
            case '16':
                $data = "Keuangan dan Aset";
                break;
            case '17':
                $data = "Kepegawaian, Umum dan Kehumasan";
                break;
            case '18':
                $data = "Perencanaan dan Pelaporan";
                break;
            case '19':
                $data = "Kepala Dinas PMPTSP";
                break;
            case '20':
                $data = "Sekretaris Dinas PMPTSP";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_kegiatan($nomor) {
        switch ($nomor) {
            case '0':
                $data = "Internal";
                break;
            case '1':
                $data = "Eksternal";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function status_booking($id_ruangan, $tanggal, $waktu_awal, $waktu_akhir) {
        $result = array();
        $sql = "SELECT * 
            FROM ruangan_pemakai 
            WHERE id_ruangan = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql, array($id_ruangan, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function save_pakai($id_ruangan, $iduser, $seksi, $kegiatan, $acara, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $keterangan) {
        $data = array(
                        'id_ruangan'  => $id_ruangan,
                        'user_id'     => $iduser,
                        'seksi'       => $seksi,
                        'kegiatan'    => $kegiatan,
                        'acara'       => $acara,
                        'snack'       => $snack,
                        'mamin'       => $mamin,
                        'tanggal'     => $tanggal,
                        'waktu_awal'  => $waktu_awal,
                        'waktu_akhir' => $waktu_akhir,
                        'keterangan'  => $keterangan
                     );
        $save = $this->db->insert('ruangan_pemakai', $data);
        
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_pakai($iduser, $id, $pengajuan, $desk, $date, $tingkat, $bidang, $nama) {
        $data = array(
                        'isi_pengajuan'     => $pengajuan,
                        'deskripsi_pengembangan'     => $desk,
                        'tanggal'           => $date,
                        'tingkat_kebutuhan' => $tingkat,
                        'bidang'            => $bidang,
                        'nama_pengaju'      => $nama
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('pengembangan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function approve_text($id, $id_user, $status, $pesan) {
        $data = array(
                        'status'     => $status,
                        'approve'    => $id_user,
                        'keterangan'     => $pesan
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('pengembangan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function approve($id, $id_user, $status) {
        $data = array(
                        'status'     => $status,
                        'approve'    => $id_user
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('pengembangan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_pakai($id) {
        // var_dump($id);die();
        $del = $this->db->delete('pengembangan', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function save_master($nama_ruangan, $lantai, $kapasitas, $fasilitas) {
        $data = array(
                        'nama_ruangan'    => $nama_ruangan,
                        'lantai'          => $lantai,
                        'kapasitas'       => $kapasitas,
                        'fasilitas'       => $fasilitas
                     );
        $save = $this->db->insert('ruangan_master', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_master($id, $nama_ruangan, $lantai, $kapasitas, $fasilitas) {
        $data = array(
                        'nama_ruangan'    => $nama_ruangan,
                        'lantai'          => $lantai,
                        'kapasitas'       => $kapasitas,
                        'fasilitas'       => $fasilitas
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('ruangan_master', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_master($id) {
        $del = $this->db->delete('ruangan_master', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }


}
