<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_model extends CI_Model
{	
	private $_table = "euis_bukutamu";
	public $nama;
	public $email;
	public $instansi;
	public $keperluan;
	public $waktu;
	public $esselon;
	public $lokasi;
	public $bidang;
	public $solusi;
	public $telepon;

	 
    public function get_namampp() {
        $sql = "SELECT * from trkabupaten WHERE kd_prov = '12'";
        $result = $this->db->query($sql)->result(); 

        return $result;
    }

    public function get_kegiatan($idkegiatan) {
        $sql = "SELECT * from ruangan_pemakai WHERE id = ?";
        $result = $this->db->query($sql, $idkegiatan)->first_row();

        return $result;
    }

	public function save($email, $nama, $nik, $domisili, $whatsapp, $group_umk, $jenis_usaha, $nib, $layanan, $persetujuan, $signed)
	{
        $data = array(
            'email' => $email,
            'nama' => $nama,
            'nik' => $nik,
            'domisili' => $domisili,
            'no_wa' => $whatsapp,
            'grup_bina' => $group_umk,
            'j_usaha' => $jenis_usaha,
            'konfirm_nib' => $nib,
            'layanan' => $layanan,
            'hadir' => $persetujuan,
            'kabupaten' => $kabupaten,
            'ttd' => $signed
            // Add more fields as needed
        );

        $this->db->insert('daftar.registrasi', $data);

        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : 0;

	}

    
    public function save_data($nama, $nik, $email, $telephone, $domisili, $layanan, $nib, $jenis_usaha, $tempat_usaha, $modal_usaha, $luas_lahan, $jumlah_tenaga, $pendapatan, $kablain, $signed, $persetujuan) {
        // Insert data into the database
        
        $data = array(
            'nama' => $nama,
            'nik' => $nik,
            'email' => $email,
            'no_wa' => $telephone,
            'domisili' => $domisili,
            'layanan' => $layanan, // Assuming $layanan is an array
            'konfirm_nib' => $nib,
            'j_usaha' => $jenis_usaha,
            'tempat_usaha' => $tempat_usaha,
            'modal_usaha' => $modal_usaha,
            'luas_lahan' => $luas_lahan,
            'jumlah_tenaga' => $jumlah_tenaga,
            'pendapatan' => $pendapatan,
            'lokasi' => $kablain,
            'ttd' => $signed,
            'hadir' => $persetujuan
        );

        $this->db->insert('daftar.registrasi', $data);
        
        // Return the ID of the inserted record
        return $this->db->insert_id();
    }
    
	 
    public function save_konfirm($nama, $instansi, $email, $handphone, $kabupaten)
    {
        $data = array(
                        'nama'      => $nama,
                        'instansi'  => $instansi,
                        'email'     => $email,
                        'handphone' => $handphone,
                        'kabupaten' => $kabupaten
                     );
        $save = $this->db->insert('konfirmasi_mpp', $data);

        if ($save) {
            return true;
        } else {
            return false;
        }
    }

}