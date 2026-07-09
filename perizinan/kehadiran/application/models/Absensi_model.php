<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
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

	public function save($kegiatan, $nama, $gender, $instansi, $email, $handphone, $kabupaten, $jabatan)
	{
        $data = array(
                        'kegiatan'  => $kegiatan,
                        'nama'      => $nama,
                        'gender'    => $gender,
                        'instansi'  => $instansi,
                        'jabatan'  => $jabatan,
                        'email'     => $email,
                        'handphone' => $handphone,
                        'kabupaten' => $kabupaten
                     );
        $save = $this->db->insert('absensi_mpp', $data);

        if ($save) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
	}

    public function delete($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('absensi_mpp');

        if ($delete) {
            return true;
        } else {
            return false;
        }
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