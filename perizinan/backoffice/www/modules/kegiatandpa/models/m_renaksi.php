<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author Arif
 * Created :  23-01-2024 
 *
 */

class M_renaksi extends Model {


    public function get_data($tgla = NULL, $tglb = NULL) {
        
            $sql = "SELECT * 
                FROM ruangan_pemakai 
            WHERE (DATE(tanggal) BETWEEN ? AND ?) 
            ORDER BY tanggal DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
       
       
        return $result;
    }


        public function get_master() {
            $result = array();
            $current_year = date('Y'); // Mendapatkan tahun saat ini
            $sql = "SELECT * FROM nama_tot WHERE thn_anggaran = ?";

            $result = $this->db->query($sql, array($current_year))->result();

            return $result;
        }

    public function get_masterid($id) {
        $ruangan = $this->db->select('*')
                     ->from('nama_tot')
                     ->where('id', $id)
                     ->get()->row();

        return $ruangan;
    }

    public function get_master2() {
        $query = $this->db
            ->select('nama_tot_anggota.id_pegawai')
            ->from('nama_tot_anggota')
            ->join('nama_tot', 'nama_tot_anggota.kd_tim = nama_tot.id', 'inner')
            ->get();

        return $query->result();
    }

    public function get_set_koor() {
        $result = array();
        $current_year = date('Y');
        $sql = "SELECT * FROM koor_tot WHERE thn_anggaran = ?";

        $result = $this->db->query($sql, array($current_year))->result();

        return $result;
    }

    public function get_set_ketua() {
        $result = array();
        $current_year = date('Y'); // Mendapatkan tahun saat ini
        $sql = "SELECT * FROM ketua_tot WHERE thn_anggaran = ?";

        // $result = $this->db->query($sql)->result();
         $result = $this->db->query($sql, array($current_year))->result();

        return $result;
    }

    public function get_kode_ring() {
        $result = array();
        $current_year = date('Y'); // Mendapatkan tahun saat ini
        $sql = "SELECT * FROM anggaran_kodering WHERE tahun = ?";

        $result = $this->db->query($sql, array($current_year))->result();

        return $result;
    }

    public function get_kode_ring_subkeg() {
        $result = array();
        $current_year = date('Y'); // Mendapatkan tahun saat ini
        $sql = "SELECT * FROM anggaran_kodering_sub_kegiatan WHERE tahun = ?";

        $result = $this->db->query($sql, array($current_year))->result();

        return $result;
    }

    public function get_pegawai() {
        // $sql = "SELECT * from tmpegawai where unitkerja_id = 1";
        $sql = "SELECT * from tmpegawai";
        
        $result = $this->db->query($sql)->result();
// where kd_prov = '12' ";
        return $result;
    }

    public function get_pegawai_koordinator() {
        // $sql = "SELECT * from tmpegawai where eselon = 3 AND unitkerja_id = 1";
        $sql = "SELECT * from tmpegawai where eselon = 3";
        
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_pegawai_ketua() {
        // $sql = "SELECT * from tmpegawai where eselon = 4 AND unitkerja_id = 1";
        $sql = "SELECT * from tmpegawai where eselon = 4";
        
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

    public function get_nama_tim($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('nama_tim')
                         ->from('nama_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->nama_tim)) {
                $data = $pegawai->nama_tim;
            }
        }
        
        return $data;
    }

    public function get_anggaran($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('anggaran')
                         ->from('nama_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->anggaran)) {
                $data = $pegawai->anggaran;
            }
        }
        
        return $data;
    }

    public function get_koordinator($id) {
    $query = $this->db->select('*')
                     ->from('koor_tot')
                     ->where('id', $id)
                     ->get();

    $result = $query->row();

    return $result;
    }


 
    public function get_nama_tim_koor($id_koor) {
        $this->db->select('koor_tot.id_pegawai');
        $this->db->from('koor_tot');
        $this->db->where('koor_tot.id', $id_koor);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->id_pegawai;
        } else {
            return '-'; // Jika tidak ada data
        }
    
}

    public function get_katim($id) {
    $query = $this->db->select('*')
                     ->from('ketua_tot')
                     ->where('id', $id)
                     ->get();

    $result = $query->row();

    return $result;
    }

    public function get_kodering_anggaran($id) {
    $query = $this->db->select('*')
                     ->from('anggaran_kodering')
                     ->where('id', $id)
                     ->get();

    $result = $query->row();

    return $result;
    }

    public function get_kodering_subkeg_anggaran($id) {
    $query = $this->db->select('*')
                     ->from('anggaran_kodering_sub_kegiatan')
                     ->where('id', $id)
                     ->get();

    $result = $query->row();

    return $result;
    }

    public function get_kodering_anggaran_kd($id) {
        $data = " - ";

        if ($data != "0") {
            $kode = $this->db->select('kode_ring')
                         ->from('anggaran_kodering')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($kode->kode_ring)) {
                $data = $kode->kode_ring;
            }
        }
        
        return $data;
    }


    public function get_sasaran_renaksi($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('sasaran_renaksi')
                         ->from('renaksi_tot')
                         ->where('program_id', $id)
                         ->get()->row();

            if (!empty($pegawai->sasaran_renaksi)) {
                $data = $pegawai->sasaran_renaksi;
            }
        }
        
        return $data;
    }

    public function get_sasaran_program_id($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('sasaran_program')
                         ->from('program_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->sasaran_program)) {
                $data = $pegawai->sasaran_program;
            }
        }
        
        return $data;
    }

    public function get_sasaran_renaksi_sub($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('sasaran_renaksi')
                         ->from('renaksi_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->sasaran_renaksi)) {
                $data = $pegawai->sasaran_renaksi;
            }
        }
        
        return $data;
    }

    public function get_program() {
        // $result = array();
        // $current_year = date('Y');
        // $sql = "SELECT * FROM nama_tot INNER JOIN program_tot
        //         ON program_tot.kd_tim = nama_tot.id
        //         WHERE program_tot.thn_anggaran = ?";
        // $result = $this->db->query($sql, array($current_year))->result();
        $result = array();
        $sql = "SELECT * FROM nama_tot INNER JOIN program_tot
                ON program_tot.kd_tim = nama_tot.id";
        $result = $this->db->query($sql)->result();
// var_dump($result); die();
        return $result;
        
    }

    public function get_anggaran_program($id) {
        $result = array();
        $sql = "SELECT * FROM r_anggaran_tot WHERE r_anggaran_tot.program_id = $id";
        
        $result = $this->db->query($sql)->result();
// var_dump($result); die();
        return $result;
        
}

public function get_total_anggaran_program($id) {
        $result = array();
        $sql = "SELECT program_id, SUM(realisasi_anggaran) AS total_realisasi
                FROM r_anggaran_tot
                WHERE program_id = $id
                GROUP BY program_id";
        $result = $this->db->query($sql)->row();
// var_dump($result); die();
        return $result;
        
}

    public function get_renaksi($id) {
        $result = array();
        $sql = "SELECT * FROM renaksi_tot where renaksi_tot.program_id = $id";
        $result = $this->db->query($sql)->result();
        // var_dump($result); die();
        return $result;
        
    }

    public function get_renaksi_ubah($id) {
        $result = array();
        $sql = "SELECT * FROM renaksi_tot where renaksi_tot.id = $id";
        $result = $this->db->query($sql)->result();
        // var_dump($result); die();
        return $result;
        
    }

    public function get_sub_renaksi($id) {
        $result = array();
        $sql = "SELECT *FROM sub_renaksi_tot WHERE sub_renaksi_tot.renaksi_id = $id";
        
        $result = $this->db->query($sql)->result();
// var_dump($result); die();
        return $result;
        
}
        public function get_sub_renaksi_id($id) {
        $result = array();
        $sql = "SELECT *FROM sub_renaksi_tot WHERE sub_renaksi_tot.id = $id";
        
        $result = $this->db->query($sql)->result();
// var_dump($result); die();
        return $result;
        
    }

    public function get_targetkinerja() {
        // $sql = "SELECT t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,r1,r2,r3,r4,r5,r6,r7,r8,r9,r10,r11,r12 FROM program_tot";
        $sql = "SELECT * FROM program_tot";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_dataprogram($id) {
        $result = $this->db->select('*')
                     ->from('program_tot')
                     ->where('id', $id)
                     ->get()->row();

        return $result;
    }

    public function get_datarenaksi_id($id) {
        $result = $this->db->select('*')
                     ->from('renaksi_tot')
                     ->where('id', $id)
                     ->get()->row();

        return $result;
    }

    public function get_subrenaksi_id($id) {
        $result = $this->db->select('*')
                     ->from('sub_renaksi_tot')
                     ->where('id', $id)
                     ->get()->row();

        return $result;
    }

//     public function get_datarenaksi($id) {
//     $result = $this->db
//         ->select('renaksi_tot.*, nama_tot.nama_tim AS nama_tim_tot, nama_tot.pengampu AS pengampu_tot, nama_tot.ketua AS ketua_tot, nama_tot.anggota AS anggota_tot, nama_tot.anggaran AS anggaran_tot, sub_renaksi_tot.*, nama_tot_anggota.*')
//         ->from('renaksi_tot')
//         ->join('nama_tot', 'renaksi_tot.kd_tim = nama_tot.id', 'left')
//         ->join('sub_renaksi_tot', 'renaksi_tot.id = sub_renaksi_tot.renaksi_id', 'left')
//         ->where('renaksi_tot.id', $id)
//         ->get()
//         ->row();

//     return $result;
// }

public function get_datarenaksi($id) {
    $query = $this->db
        ->select('renaksi_tot.*, nama_tot.nama_tim AS nama_tim_tot, nama_tot.pengampu AS pengampu_tot, nama_tot.ketua AS ketua_tot, nama_tot.anggota AS anggota_tot, nama_tot.anggaran AS anggaran_tot, sub_renaksi_tot.*, nama_tot_anggota.*')
        ->from('renaksi_tot')
        ->join('nama_tot', 'renaksi_tot.kd_tim = nama_tot.id', 'left')
        ->join('nama_tot_anggota', 'renaksi_tot.kd_tim = nama_tot_anggota.kd_tim', 'left')
        ->where('renaksi_tot.id', $id)
        ->get();

    $result = $query->row();

    return $result;
}

public function get_dataprogram_id($id) {
    $query = $this->db
        ->select('program_tot.id AS id_prog, program_tot.kd_tim AS kd_tim, program_tot.sasaran_program AS sasaran_program, nama_tot.nama_tim AS nama_tim_tot, nama_tot.pengampu AS pengampu_tot, nama_tot.ketua AS ketua_tot, nama_tot.anggota AS anggota_tot, nama_tot.anggaran AS anggaran_tot, r_anggaran_tot.id AS id_anggaran, r_anggaran_tot.program_id AS program_id, r_anggaran_tot.kegiatan AS kegiatan, r_anggaran_tot.tanggal AS tanggal, r_anggaran_tot.realisasi_anggaran AS realisasi_anggaran, r_anggaran_tot.keterangan AS keterangan, nama_tot_anggota.*')
        ->from('program_tot')
        ->join('nama_tot', 'program_tot.kd_tim = nama_tot.id', 'left')
        ->join('r_anggaran_tot', 'program_tot.id = r_anggaran_tot.program_id', 'left')
        ->join('nama_tot_anggota', 'program_tot.kd_tim = nama_tot_anggota.kd_tim', 'left')
        ->where('program_tot.id', $id)
        ->get();

    $result = $query->row();

    return $result;
}


    public function get_nippegawai($id) {
        $ruangan = $this->db->select('nip')
                     ->from('tmpegawai')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($ruangan->nip)) {
            $data = $ruangan->nip;
        }
        return $data;

        return $ruangan;
    }

    // public function get_datamaster($id) {
    //     $tim = $this->db->select('*')
    //                  ->from('nama_tot_anggota')
    //                  ->where('kd_tim', $id)
    //                  ->get()->row();

    //     return $tim;
    // }

    public function get_datamaster($id) {
    $query = $this->db->select('nama_tot.*, nama_tot_anggota.*')
                     ->from('nama_tot')
                     ->join('nama_tot_anggota', 'nama_tot.id = nama_tot_anggota.kd_tim', 'left') // Sesuaikan kondisi JOIN
                     ->where('nama_tot_anggota.kd_tim', $id)
                     ->get();

    $result = $query->row();

    return $result;
}

public function get_anggota($id) {
        $sql = "SELECT * FROM nama_tot
INNER JOIN nama_tot_anggota ON nama_tot_anggota.kd_tim = nama_tot.id WHERE nama_tot.id = '$id' ORDER BY nama_tot_anggota.id_pegawai DESC";
        
        $result = $this->db->query($sql, array($id))->result();
// where kd_prov = '12' ";
        return $result;
    }

    // public function get_kdtim($id){
    //     $data = " - ";

    //         $pegawai = $this->db->select('kd_tim')
    //                      ->from('renaksi_tot')
    //                      ->where('id', $id)
    //                      ->get()->row();

    //         if (!empty($pegawai->kd_tim)) {
    //             $data = $pegawai->kd_tim;
    //         }
    //     var_dump($data); die();
    //     return $data;

    // }

    public function get_kdtim_prog($id){
        $data = " - ";

            $pegawai = $this->db->select('kd_tim')
                         ->from('program_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->kd_tim)) {
                $data = $pegawai->kd_tim;
            }
        
        return $data;

    }

    public function get_program_id($id){
        $data = " - ";

            $pegawai = $this->db->select('id')
                         ->from('program_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->id)) {
                $data = $pegawai->id;
            }
        
        return $data;

    }

    public function get_id_ketua($id){
        $data = " - ";

            $pegawai = $this->db->select('ketua')
                         ->from('nama_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->ketua)) {
                $data = $pegawai->ketua;
            }
        
        return $data;

    }

    public function get_id_pengampu($id){
        $data = " - ";

            $pegawai = $this->db->select('pengampu')
                         ->from('nama_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->pengampu)) {
                $data = $pegawai->pengampu;
            }
        
        return $data;

    }


    public function get_anggota_tim($id) {
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

    public function get_sasaran_program($id) {
        $data = " - ";

            $pegawai = $this->db->select('sasaran_program')
                         ->from('program_tot')
                         ->where('kd_tim', $id)
                         ->get()->row();

            if (!empty($pegawai->sasaran_program)) {
                $data = $pegawai->sasaran_program;
            }
        
        return $data;
    }

    public function get_sasaran($id) {
        $data = " - ";

            $pegawai = $this->db->select('sasaran_program')
                         ->from('program_tot')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->sasaran_program)) {
                $data = $pegawai->sasaran_program;
            }
        
        return $data;
    }

    // public function get_anggaran($id) {
    //     $data = " - ";

    //         $pegawai = $this->db->select('anggaran')
    //                      ->from('nama_tot')
    //                      ->where('kd_tim', $id)
    //                      ->get()->row();

    //         if (!empty($pegawai->anggaran)) {
    //             $data = $pegawai->anggaran;
    //         }
        
    //     return $data;
    // }

    public function get_anggota_tim2($id) {
        $result = array();
        $sql = "SELECT *
            FROM nama_tot_anggota where nama_tot_anggota.kd_tim = '$id'";

        $result = $this->db->query($sql)->result();

        return $result;
    }


    public function get_data_cetak_excel($iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT *
                    FROM nama_tot
                    INNER JOIN program_tot ON program_tot.kd_tim = nama_tot.id
                    INNER JOIN renaksi_tot ON renaksi_tot.program_id = program_tot.id
                    ORDER BY pengampu ASC";

                $result = $this->db->query($sql)->result();
        } else {
            $sql = "SELECT *
                    FROM nama_tot
                    INNER JOIN program_tot ON program_tot.kd_tim = nama_tot.id
                    INNER JOIN renaksi_tot ON renaksi_tot.program_id = program_tot.id
                    ORDER BY pengampu ASC";

                $result = $this->db->query($sql)->result();
        }

        return $result;
    }


    // public function get_pengampu($nomor) {
    //     switch ($nomor) {
    //         case '1':
    //             $data = "DENI RUSYANA, A.Md.LLAJ., S.A.P., M.S.E";
    //             break;
    //         case '2':
    //             $data = "Dr. H. DODIN RUSMIN NURYADIN, Drs., M.Si.";
    //             break;
    //         case '3':
    //             $data = "Drs. H. DIDING ABIDIN, M.Si.";
    //             break;
    //         case '4':
    //             $data = "DINDIN JAMALUDIN, S.H., M.H.";
    //             break;
    //         case '5':
    //             $data = "HENY RAHMAWATI, A.K.S., M.P.";
    //             break;
    //         case '6':
    //             $data = "PIQHI RIZQI, S.T., M.T.";
    //             break;
    //         case '7':
    //             $data = "PAMUDI BUDI SUHARSONO, S.Si.";
    //             break;
    //         case '8':
    //             $data = "ANNY MIRNA APRIANY, S.T.";
    //             break;
    //         case '9':
    //             $data = "KARINA RACHMADIANI HENDRAWAN, S.E.";
    //             break;
    //         case '10':
    //             $data = "ARINAL LEGIA SUHERMAN, S.A.B.";
    //             break;
    //         default:
    //             $data = " - ";
    //             break;
    //     }
    //     return $data;
    // }

//     public function get_pengampu($nomor) {
//     $sql = 'SELECT * FROM koor_tot';
//     $data_koor = $this->db->query($sql)->result();
    
//     $found = false;
//     $data = " - ";
    
//     // Iterate over the data to find a match
//     foreach ($data_koor as $row) {
//         if ($row->pengampu == $nomor) {
//             $found = true;
//             $data = $row->id_pegawai;
//             break; // Exit the loop once a match is found
//         }
//     }
    
//     // Switch statement is not necessary anymore
//     return $found ? $data : " - ";
// }

// public function get_pengampu($nomor) {
//     // Query to fetch data from koor_tot table
//     $sql = 'SELECT * FROM koor_tot';
//     $data_koor = $this->db->query($sql)->result();

//     // Query to fetch data from tmpegawai table
//     $sql_nama_pegawai = 'SELECT * FROM tmpegawai';
//     $data_nama_pegawai = $this->db->query($sql_nama_pegawai)->result();

//     // Iterate over the data to find a match
//     foreach ($data_koor as $row) {
//         if ($row->pengampu == $nomor) {
//             // Search for matching id_pegawai in tmpegawai table
//             foreach ($data_nama_pegawai as $pegawai) {
//                 if ($pegawai->id == $row->id_pegawai) {
//                     // Return n_pegawai if data matches
//                     return $pegawai->n_pegawai;
//                 }
//             }
//             // If no match is found, return "-"
//             return " - ";
//         }
//     }
//     // If no data is found, return "-"
//     return " - ";
// }

    public function get_pengampu_chart($nomor) {
        switch ($nomor) {
            case '1':
                $data = "DENI RUSYANA";
                break;
            case '2':
                $data = "DODIN RUSMIN";
                break;
            case '3':
                $data = "DIDING ABIDIN";
                break;
            case '4':
                $data = "DINDIN JAMALUDIN";
                break;
            case '5':
                $data = "HENY RAHMAWATI";
                break;
            case '6':
                $data = "PIQHI RIZQI";
                break;
            case '7':
                $data = "PAMUDI BUDI SUHARSONO";
                break;
            case '8':
                $data = "ANNY MIRNA APRIANY";
                break;
            case '9':
                $data = "KARINA RACHMADIANI HENDRAWAN";
                break;
            case '10':
                $data = "ARINAL LEGIA SUHERMAN";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function get_ketua($nomor) {
        $no = 1;
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('id_pegawai')
                         ->from('ketua_tot')
                         ->where('id_pegawai', $nomor)
                         ->get()->row();

            if (!empty($pegawai->id_pegawai)) {
                $id_pegawai = $pegawai->id_pegawai;
            }
        }

        $data = $this->get_n_pegawai($id_pegawai);
        return $data;
    }

    public function get_pengampu($nomor) {
        $no = 1;
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('id_pegawai')
                         ->from('koor_tot')
                         ->where('id_pegawai', $nomor)
                         ->get()->row();

            if (!empty($pegawai->id_pegawai)) {
                $id_pegawai = $pegawai->id_pegawai;
            }
        }

        $data = $this->get_n_pegawai($id_pegawai);
        return $data;
    }

    public function get_ketua_OLD($nomor) {
        switch ($nomor) {
            case '1':
                $data = "AEP SAEPULOH, S.T";
                break;
            case '2':
                $data = "AHMAD FAUZAN NURUL ILMI, S.E.";
                break;
            case '3':
                $data = "ARINAL LEGIA SUHERMAN, S.A.B.";
                break;
            case '4':
                $data = "BOYKE TRISTIADI, S.E., M.M.";
                break;
            case '5':
                $data = "DESKA YUDA AMELLIA, S.E.";
                break;
            case '6':
                $data = "DIAN PRAMANITA, S.H.";
                break;
            case '7':
                $data = "Dra. TETI RACHMAWATI, M.A.B";
                break;
            case '8':
                $data = "FARIDHA DWI ASTUTI, S.I.P.";
                break;
            case '9':
                $data = "FIKRI AZMI ARIF S, S.I.Kom.";
                break;
            case '10':
                $data = "GEMA ADES SUBEKTI, ST.,M.K.P";
                break;
            case '11':
                $data = "GITA WIRANTIKA, S.E.,M.M.";
                break;
            case '12':
                $data = "GUGUN GUNAWAN, S.T.";
                break;
            case '13':
                $data = "IRWANSYAH, S.I.P.";
                break;
            case '14':
                $data = "IYAN DARMANSYAH BIMANTARA, SH";
                break;
            case '15':
                $data = "JONAS MEYLAN FREDDY BANUREA, S.ST";
                break;
            case '16':
                $data = "MUSTIKA LADIA PUTRI, S.Si.";
                break;
            case '17':
                $data = "RADEN MUHAMMAD DARAJAT, SE. MPP., M.S.E";
                break;
            case '18':
                $data = "SAHAL FAUZI, S.KOM., M.KOM.";
                break;
            case '19':
                $data = "SUBAGYO, S.Sos., M.M.";
                break;
            case '20':
                $data = "THONGKU HAMONANGAN SIREGAR, S.E., M.M.";
                break;
            case '21':
                $data = "WAWAN RUSTIYAN, S.Si., M.Si.";
                break;
            case '22':
                $data = "WIWIN WIDIANTINI, S.Pd.";
                break;
            case '23':
                $data = "YUNAN FELDY LESNUSA, ST, M.M";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }


    public function save_tim($id, $tmpegawai_id) { //, $user_id, $ket
        $data = array(
                        'id_ruanganpemakai'          => $id,
                        'id_pegawai'          => $tmpegawai_id
                     );
        $save = $this->db->insert('ruangan_petugas', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function save_ket($ket, $program_id) { //, $user_id, $ket
        $data = array(
                        'program_id'          => $program_id,
                        'keterangan'          => $ket
                     );
        $save = $this->db->insert('aktivitas_keterangan', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function del_tim($id_surat) { //, $user_id, $ket

        $up = $this->db->delete('ruangan_petugas', array('id_ruanganpemakai' => $id_surat));

        if ($up) {
                return true;
        } else {
                 return false;
        }
    }


    public function save_tot($id_user,$nama_tim, $pengampu, $ketua, $anggota, $anggaran, $realisasi_anggaran, $kode_ring, $tahun) {
        $data = array(
                        'id_user'    => $id_user,
                        'nama_tim'    => $nama_tim,
                        'pengampu'          => $pengampu,
                        'ketua'       => $ketua,
                        'anggota'          => $anggota,
                        'anggaran'          => $anggaran,
                        'realisasi_anggaran'          => $realisasi_anggaran,
                        'kode_ring'          => $kode_ring,
                        'thn_anggaran'          => $tahun
                     );
        $save = $this->db->insert('nama_tot', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_anggota($id, $row, $tahun) {
        $data = array(
                        'kd_tim'    => $id,
                        'id_pegawai'=> $row,
                        'tahun'=> $tahun
                     );
        $save = $this->db->insert('nama_tot_anggota', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_anggota($id) {
        $del = $this->db->delete('nama_tot_anggota', array('kd_tim' => $id));
        if ($del) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_anggota($id, $simpan, $row, $tahun) {
        $data = array(
                        'kd_tim'    => $id,
                        'id_pegawai'=> $row,
                        'tahun'=> $tahun
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('nama_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_tot($id, $id_user, $nama_tim, $pengampu, $ketua, $anggota, $anggaran, $realisasi_anggaran, $kode_ring, $tahun) {
        $data = array(
                        'id_user'    => $id_user,
                        'nama_tim'    => $nama_tim,
                        'pengampu'          => $pengampu,
                        'ketua'       => $ketua,
                        'anggota'          => $anggota,
                        'anggaran'          => $anggaran,
                        'realisasi_anggaran'       => $realisasi_anggaran,
                        'kode_ring'       => $kode_ring,
                        'thn_anggaran'       => $tahun
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('nama_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_tot($id) {
        $del = $this->db->delete('nama_tot', array('id' => $id));
        $del1aja = $this->db->delete('nama_tot_anggota', array('kd_tim' => $id));
            if ($del && $del1aja) {
                return true;
            } else {
                return false;
            }
    }

    public function save_koor($id_pegawai,$nama_tim, $kode_pengampu, $tahun, $kode_tim, $status) {
        $data = array(
                        'pengampu'    => $kode_pengampu,
                        'id_pegawai'=> $id_pegawai,
                        'nama_tim'=> $nama_tim,
                        'kode_tim'=> $kode_tim,
                        'status'=> $status,
                        'thn_anggaran'=> $tahun
                     );
        $save = $this->db->insert('koor_tot', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_ketua($id_pegawai,$nama_tim, $kode_ketua, $tahun, $kode_tim, $id_koor) {
        $data = array(
                        'id_koor'    => $id_koor,
                        'id_ketua'    => $kode_ketua,
                        'id_pegawai'=> $id_pegawai,
                        'nama_tim'=> $nama_tim,
                        'kode_tim'=> $kode_tim,
                        'thn_anggaran'=> $tahun
                     );
        $save = $this->db->insert('ketua_tot', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function ubah_koor($id, $id_pegawai,$nama_tim, $kode_pengampu, $tahun, $kode_tim, $status) {
        $data = array(
                        'pengampu'    => $kode_pengampu,
                        'id_pegawai'=> $id_pegawai,
                        'nama_tim'=> $nama_tim,
                        'kode_tim'=> $kode_tim,
                        'status'=> $status,
                        'thn_anggaran'=> $tahun
                     );
         $this->db->where('id', $id);
        $save = $this->db->update('koor_tot', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function ubah_ketua($id, $id_pegawai,$nama_tim, $kode_ketua, $tahun, $kode_tim, $id_koor) {
        $data = array(
                        'id_koor'    => $id_koor,
                        'id_ketua'    => $kode_ketua,
                        'id_pegawai'=> $id_pegawai,
                        'nama_tim'=> $nama_tim,
                        'kode_tim'=> $kode_tim,
                        'thn_anggaran'=> $tahun
                     );
         $this->db->where('id', $id);
        $save = $this->db->update('ketua_tot', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_kode_ring($kode_ring, $uraian_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12) {
        $data = array(
                        'kode_ring'    => $kode_ring,
                        'uraian_kegiatan'=> $uraian_kegiatan,
                        'anggaran'=> $anggaran,
                        'tahun'=> $tahun,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12
                     );
        $save = $this->db->insert('anggaran_kodering', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_kode_ring_subkeg($id_kode_ring, $kode_sub_ring, $uraian_sub_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $keterangan) {
        $data = array(
                        'id_kode_ring'    => $id_kode_ring,
                        'kode_sub_ring'=> $kode_sub_ring,
                        'uraian_sub_kegiatan'=> $uraian_sub_kegiatan,
                        'anggaran'=> $anggaran,
                        'tahun'=> $tahun,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12,
                        'keterangan'          => $keterangan
                     );
        $save = $this->db->insert('anggaran_kodering_sub_kegiatan', $data);
    
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_kode_ring($id, $kode_ring, $uraian_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12) {
        $data = array(
                        'kode_ring'    => $kode_ring,
                        'uraian_kegiatan'=> $uraian_kegiatan,
                        'anggaran'=> $anggaran,
                        'tahun'=> $tahun,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('anggaran_kodering', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_kode_ring_subkeg($id, $id_kode_ring, $kode_sub_ring, $uraian_sub_kegiatan, $anggaran, $tahun, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $keterangan) {
        $data = array(
                        'id_kode_ring'    => $id_kode_ring,
                        'kode_sub_ring'=> $kode_sub_ring,
                        'uraian_sub_kegiatan'=> $uraian_sub_kegiatan,
                        'anggaran'=> $anggaran,
                        'tahun'=> $tahun,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12,
                        'keterangan'          => $keterangan
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('anggaran_kodering_sub_kegiatan', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }


    public function hapus_program($id) {
        $del = $this->db->delete('program_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_renaksi($id) {
        $del = $this->db->delete('renaksi_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_sub_renaksi($id) {
        $del = $this->db->delete('sub_renaksi_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_r_anggaran($id) {
        $del = $this->db->delete('r_anggaran_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_kodering($id) {
        $del = $this->db->delete('anggaran_kodering', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_kodering_subkeg($id) {
        $del = $this->db->delete('anggaran_kodering_sub_kegiatan', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_koor($id) {
        $del = $this->db->delete('koor_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function hapus_ketua($id) {
        $del = $this->db->delete('ketua_tot', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function save_program($id_user, $id_tim, $sasaran, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12) {
        $data = array(
                        'id_user'    => $id_user,
                        'kd_tim'    => $id_tim,
                        'sasaran_program'          => $sasaran,
                        'indikator_program'       => $indikator,
                        'target_tahun'       => $target_tahun,
                        'satuan'          => $satuan,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12
                     );
        
        $save = $this->db->insert('program_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_program($id,$id_user, $id_tim, $sasaran, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12) {
        $data = array(
                        'id_user'    => $id_user,
                        'kd_tim'    => $id_tim,
                        'sasaran_program'          => $sasaran,
                        'indikator_program'       => $indikator,
                        'target_tahun'       => $target_tahun,
                        'satuan'          => $satuan,
                        't1'          => $t1,
                        't2'          => $t2,
                        't3'          => $t3,
                        't4'          => $t4,
                        't5'          => $t5,
                        't6'          => $t6,
                        't7'          => $t7,
                        't8'          => $t8,
                        't9'          => $t9,
                        't10'          => $t10,
                        't11'          => $t11,
                        't12'          => $t12,
                        'r1'          => $r1,
                        'r2'          => $r2,
                        'r3'          => $r3,
                        'r4'          => $r4,
                        'r5'          => $r5,
                        'r6'          => $r6,
                        'r7'          => $r7,
                        'r8'          => $r8,
                        'r9'          => $r9,
                        'r10'          => $r10,
                        'r11'          => $r11,
                        'r12'          => $r12
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('program_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_r_anggaran($program_id, $kegiatan, $tanggal, $r_anggaran, $keterangan) {
        $data = array(
                        'program_id'    => $program_id,
                        'kegiatan'          => $kegiatan,
                        'tanggal'       => $tanggal,
                        'realisasi_anggaran'       => $r_anggaran,
                        'keterangan'          => $keterangan

                     );
        
        $save = $this->db->insert('r_anggaran_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_renaksi($id_user, $program_id, $renaksi, $pic, $r_anggaran, $target_aktivitas, $satuan, $tgl_rencana, $tgl_realisasi, $keterangan) {
        $data = array(
                        'id_user'    => $id_user,
                        'program_id'    => $program_id,
                        'sasaran_renaksi'          => $renaksi,
                        'pic'       => $pic,
                        'r_anggaran'       => $r_anggaran,
                        'target_aktivitas'          => $target_aktivitas,
                        'satuan'          => $satuan,
                        'tgl_rencana'          => $tgl_rencana,
                        'tgl_realisasi'          => $tgl_realisasi,
                        'keterangan'          => $keterangan
                     );
        // var_dump($data); die();
        $save = $this->db->insert('renaksi_tot', $data);
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_renaksi($id, $id_user, $program_id, $renaksi, $pic, $r_anggaran, $target_aktivitas, $satuan, $tgl_rencana, $tgl_realisasi, $keterangan) {
        $data = array(
                        'id_user'    => $id_user,
                        'program_id'    => $program_id,
                        'sasaran_renaksi'          => $renaksi,
                        'pic'       => $pic,
                        'r_anggaran'       => $r_anggaran,
                        'target_aktivitas'          => $target_aktivitas,
                        'satuan'          => $satuan,
                        'tgl_rencana'          => $tgl_rencana,
                        'tgl_realisasi'          => $tgl_realisasi,
                        'keterangan'          => $keterangan
                     );
       $this->db->where('id', $id);
        $save = $this->db->update('renaksi_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function save_sub_renaksi($renaksi_id, $sub_renaksi, $pic, $r_anggaran, $sub_t1, $sub_t2, $sub_t3, $sub_t4, $sub_t5, $sub_t6, $sub_t7, $sub_t8, $sub_t9, $sub_t10, $sub_t11, $sub_t12, $sub_r1, $sub_r2, $sub_r3, $sub_r4, $sub_r5, $sub_r6, $sub_r7, $sub_r8, $sub_r9, $sub_r10, $sub_r11, $sub_r12, $keterangan) {
        $data = array(
                        'renaksi_id'    => $renaksi_id,
                        'sub_renaksi'          => $sub_renaksi,
                        'pic'       => $pic,
                        'r_anggaran'       => $r_anggaran,
                        't1'          => $sub_t1,
                        't2'          => $sub_t2,
                        't3'          => $sub_t3,
                        't4'          => $sub_t4,
                        't5'          => $sub_t5,
                        't6'          => $sub_t6,
                        't7'          => $sub_t7,
                        't8'          => $sub_t8,
                        't9'          => $sub_t9,
                        't10'          => $sub_t10,
                        't11'          => $sub_t11,
                        't12'          => $sub_t12,
                        'r1'          => $sub_r1,
                        'r2'          => $sub_r2,
                        'r3'          => $sub_r3,
                        'r4'          => $sub_r4,
                        'r5'          => $sub_r5,
                        'r6'          => $sub_r6,
                        'r7'          => $sub_r7,
                        'r8'          => $sub_r8,
                        'r9'          => $sub_r9,
                        'r10'          => $sub_r10,
                        'r11'          => $sub_r11,
                        'r12'          => $sub_r12,
                        'keterangan'          => $keterangan
                     );
        
        $save = $this->db->insert('sub_renaksi_tot', $data);
        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    // public function update_renaksi($id, $id_tim, $aktivitas, $indikator, $target_tahun, $satuan, $t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12) {
    //     $data = array(
    //                     'kd_tim'    => $id_tim,
    //                     'sasaran_renaksi'          => $aktivitas,
    //                     'indikator_renaksi'       => $indikator,
    //                     'target_tahun'       => $target_tahun,
    //                     'satuan'          => $satuan,
    //                     't1'          => $t1,
    //                     't2'          => $t2,
    //                     't3'          => $t3,
    //                     't4'          => $t4,
    //                     't5'          => $t5,
    //                     't6'          => $t6,
    //                     't7'          => $t7,
    //                     't8'          => $t8,
    //                     't9'          => $t9,
    //                     't10'          => $t10,
    //                     't11'          => $t11,
    //                     't12'          => $t12,
    //                     'r1'          => $r1,
    //                     'r2'          => $r2,
    //                     'r3'          => $r3,
    //                     'r4'          => $r4,
    //                     'r5'          => $r5,
    //                     'r6'          => $r6,
    //                     'r7'          => $r7,
    //                     'r8'          => $r8,
    //                     'r9'          => $r9,
    //                     'r10'          => $r10,
    //                     'r11'          => $r11,
    //                     'r12'          => $r12
    //                  );
    //     $this->db->where('id', $id);
    //     $save = $this->db->update('renaksi_tot', $data);

    //     if ($save) {
    //         $return = true;
    //     } else {
    //         $return = false;
    //     }

    //     return $return;
    // }

    public function update_sub_renaksi($renaksi_id, $sub_renaksi, $pic, $r_anggaran, $sub_t1, $sub_t2, $sub_t3, $sub_t4, $sub_t5, $sub_t6, $sub_t7, $sub_t8, $sub_t9, $sub_t10, $sub_t11, $sub_t12, $sub_r1, $sub_r2, $sub_r3, $sub_r4, $sub_r5, $sub_r6, $sub_r7, $sub_r8, $sub_r9, $sub_r10, $sub_r11, $sub_r12, $keterangan) {
        $data = array(
                        'sub_renaksi'          => $sub_renaksi,
                        'pic'       => $pic,
                        'r_anggaran'       => $r_anggaran,
                        't1'          => $sub_t1,
                        't2'          => $sub_t2,
                        't3'          => $sub_t3,
                        't4'          => $sub_t4,
                        't5'          => $sub_t5,
                        't6'          => $sub_t6,
                        't7'          => $sub_t7,
                        't8'          => $sub_t8,
                        't9'          => $sub_t9,
                        't10'          => $sub_t10,
                        't11'          => $sub_t11,
                        't12'          => $sub_t12,
                        'r1'          => $sub_r1,
                        'r2'          => $sub_r2,
                        'r3'          => $sub_r3,
                        'r4'          => $sub_r4,
                        'r5'          => $sub_r5,
                        'r6'          => $sub_r6,
                        'r7'          => $sub_r7,
                        'r8'          => $sub_r8,
                        'r9'          => $sub_r9,
                        'r10'          => $sub_r10,
                        'r11'          => $sub_r11,
                        'r12'          => $sub_r12,
                        'keterangan'          => $keterangan
                     );
        $this->db->where('id', $renaksi_id);
        $save = $this->db->update('sub_renaksi_tot', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }


}
