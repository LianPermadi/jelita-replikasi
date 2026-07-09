<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author nirwan
 * Created : 08 Apr 2021
 *
 */

class M_permintaan extends Model {
    public function get_data($tgla = NULL, $tglb = NULL) {
        $result = array();
        $sql = "SELECT * 
            FROM laptop_master";

        $sql_backup = "SELECT * 
            FROM permintaan_barang
            WHERE (DATE(tgl_req) BETWEEN ? AND ?) 
            ORDER BY tgl_req DESC";

            $result = $this->db->query($sql, array($tgla, $tglb))->result();

        return $result;
    }

    public function get_master() {
        $result = array();
        $sql = "SELECT * FROM laptop_master";

        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_barang() {
        $sql = "SELECT id, nama_barang, kategori, jumlah, satuan 
                FROM barang_master"; 
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_datapakai($id) {
        $barang = $this->db->select('*')
                     ->from('permintaan_barang')
                     ->where('id', $id)
                     ->get()->row();

        return $barang;
    }

    public function get_datamaster($id) {
        $barang = $this->db->select('*')
                     ->from('barang_master')
                     ->where('id', $id)
                     ->get()->row();

        return $barang;
    }

    public function get_absensi($id) {
        $absensi = $this->db->select('*')
                     ->from('absensi_mpp')
                     ->where('kegiatan', $id)
                     ->get()->result();

        return $absensi;
    }

    public function get_nama($id) {
        $data = " - ";
        $barang = $this->db->select('label_laptop')
                     ->from('laptop_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($barang->label_laptop)) {
            $data = $barang->label_laptop;
        }
        return $data;
    }

        public function get_jenis($id) {
        $data = " - ";
        $barang = $this->db->select('jenis_laptop')
                     ->from('laptop_master')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($barang->jenis_laptop)) {
            $data = $barang->jenis_laptop;
        }
        return $data;
    }
    
    public function get_laptop($id) {
        $sql = "SELECT * FROM laptop_master WHERE id = $id";
        // var_dump($sql);die(); 
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function get_data_cetak_excel($tgla = 0, $tglb = 0, $iduser = NULL, $admin = NULL) {
        if ($admin == 1) {
            $sql = "SELECT * 
                FROM permintaan_barang 
                WHERE (DATE(tanggal) BETWEEN ? AND ?)
                ORDER BY tanggal DESC";

                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                FROM permintaan_barang 
                WHERE (DATE(tanggal) BETWEEN ? AND ?) AND user_id = ?
                ORDER BY tanggal DESC";

                $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }

        return $result;
    }

    public function get_seksi($nomor) {
        switch ($nomor) {
            case '1':
                $data = "DATIN (Evaluasi dan Pelaporan)";
                break;
            case '2':
                $data = "BANGPROM (Fasilitasi)";
                break;
            case '3':
                $data = "PENGENDALIAN (Pemantauan dan Pembinaan)";
                break;
            case '4':
                $data = "PENGENDALIAN (Pengawasan)";
                break;
            case '5':
                $data = "PENGENDALIAN (Pengaduan dan Advokasi)";
                break;
            case '6':
                $data = "DATIN (Pengembangan Sistem Informasi)";
                break;
            case '7':
                $data = "BANGPROM (Pengembangan dan Kebijakan)";
                break;
            case '8':
                $data = "DATIN (Pengolahan data)";
                break;
            case '9':
                $data = "BANGPROM (Promosi dan Kerjasama)";
                break;
            case '10':
                $data = "ESDA (Sektor Ekonomi dan Parawisata)";
                break;
            case '11':
                $data = "ESDA (Sektor Kehutanan lingkungan hidup energi dan sumber daya mineral)";
                break;
            case '12':
                $data = "INSOS (Sektor Pendidikan, Kesehatan dan Sosial)";
                break;
            case '13':
                $data = "INSOS (Sektor Perhubungan Komunikasi dan Informatika)";
                break;
            case '14':
                $data = "ESDA (Sektor Pertanian, Perikanan dan Tenaga Kerja)";
                break;
            case '15':
                $data = "INSOS (Sektor Pertanahan Pekerjaan Umum dan Penataan Ruang)";
                break;
            case '16':
                $data = "Sub Bagian Keuangan dan Aset";
                break;
            case '17':
                $data = "Sub Bagian Kepegawaian, Umum dan Kehumasan";
                break;
            case '18':
                $data = "SEKRETARIAT (Perencanaan dan Pelaporan)";
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
                $data = "Not Ready";
                break;
            case '1':
                $data = "Ready";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }

    public function status_booking($id_barang, $tanggal, $waktu_awal, $waktu_akhir) {
        $result = array();
        $sql = "SELECT * 
            FROM permintaan_barang 
            WHERE id_barang = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql, array($id_barang, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_booking($id, $id_barang, $tanggal, $waktu_awal, $waktu_akhir) {
        $result = array();
        $sql = "SELECT * 
            FROM permintaan_barang 
            WHERE id = ? AND id_barang = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql, array($id, $id_barang, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function penyelenggara($seksi, $tanggal, $waktu_awal, $waktu_akhir) {
        $result = array();
        $sql = "SELECT * 
            FROM permintaan_barang 
            WHERE seksi = ? AND DATE(tanggal) = ? AND ((waktu_awal BETWEEN ? AND ?) OR (waktu_akhir BETWEEN ? AND ?))";

        // $waktu_awal = date("H:i:s", strtotime($waktu_awal) + 1);
        // $waktu_akhir = date("H:i:s", strtotime($waktu_akhir) - 1);

        $result = $this->db->query($sql, array($seksi, $tanggal, $waktu_awal, $waktu_akhir, $waktu_awal, $waktu_akhir))->row();
     
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function save_pakai($id_barang, $iduser, $seksi, $kegiatan, $acara, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $keterangan) {
        $data = array(
                        'id_barang'  => $id_barang,
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
        $save = $this->db->insert('permintaan_barang', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function update_pakai($id, $id_barang, $seksi, $kegiatan, $acara, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $keterangan) {
        $data = array(
                        'id_barang'  => $id_barang,
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
        $this->db->where('id', $id);
        $save = $this->db->update('permintaan_barang', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_pakai($id) {
        $del = $this->db->delete('permintaan_barang', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function save_master($nama_barang, $lantai, $kapasitas, $fasilitas, $status) {
        $data = array(
                        'nama_barang'    => $nama_barang,
                        'lantai'          => $lantai,
                        'kapasitas'       => $kapasitas,
                        'fasilitas'       => $fasilitas,
                        'status'          => $status
                     );
        $save = $this->db->insert('barang_master', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_master($id, $nama_barang, $lantai, $kapasitas, $fasilitas, $status) {
        $data = array(
                        'nama_barang'    => $nama_barang,
                        'lantai'          => $lantai,
                        'kapasitas'       => $kapasitas,
                        'fasilitas'       => $fasilitas,
                        'status'          => $status
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('barang_master', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function update_notulen($id, $notulen) {
        $data = array(
                        'notulen'       => $notulen
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('permintaan_barang', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function hapus_master($id) {
        $del = $this->db->delete('barang_master', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
    }

    public function get_n_user($id) {
        $data = " - ";
        $pegawai = $this->db->select('oriname')
                     ->from('user')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->oriname)) {
            $data = $pegawai->oriname;
        }
        
        return $data;
    }

        public function get_user($id) {
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


    public function get_ruang($nomor) {
        switch ($nomor) {
            case '1':
                $data = "Ruang Rapat Melati (Lantai 1 Gedung B)";
                break;
            // case '2':
            //     $data = "BANGPROM (Fasilitasi)";
            //     break;
            case '3':
                $data = "Ruang Rapat Teratai (Lantai 1 Gedung B)";
                break;
            case '4':
                $data = "Aula Besar (Lantai 1 Gedung B)";
                break;
            case '5':
                $data = "Ruang Rapat Anggrek (Lantai 2 Gedung A)";
                break;
            case '6':
                $data = "Ruang Rapat Seruni (Lantai 2 Gedung A)";
                break;
            case '7':
                $data = "Ruang Rapat Anyelir (Lantai 3 Gedung JIH)";
                break;
            case '8':
                $data = "Ruang Rapat Alamanda (Lantai 3 Gedung JIH)";
                break;
            case '9':
                $data = "Ruang Rapat Bougenville (Lantai 3 Gedung JIH)";
                break;
            case '10':
                $data = "Ruang Rapat Kemuning (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '11':
                $data = "Ruang Rapat Soka (Aula Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '12':
                $data = "Ruang Rapat Kenangan (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '13':
                $data = "Ruang Rapat Cempaka (Lantai 2 (Atas Masjid) Gedung C)";
                break;
            case '14':
                $data = "Ruang Rapat Mawar (Lantai 6 Gedung B)";
                break;
            case '15':
                $data = "Auditorium (Lantai 4 Gedung JIH)";
                break;
            case '16':
                $data = "Ruang Lavender (Lantai 4 Gedung A)";
                break;
            case '17':
                $data = "Zoom Tempat Masing-masing";
                break;
            case '18':
                $data = "Pamoyanan (Lantai 2)";
                break;
            case '19':
                $data = "Sekretariat PPN (Lantai 2 Gedung JIH)";
                break;
            default:
                $data = " - ";
                break;
        }
        return $data;
    }
}
