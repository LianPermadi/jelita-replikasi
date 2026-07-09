<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author DPMPTSP
 * Created : 22 Jul 2023
 *
 */

class M_mobil extends Model
{
    public function get_data($kat=null){
    	if($kat == null){
        $sql = "SELECT * FROM mobil  
                ORDER BY mobil.status DESC";
      }else{
      	$sql = "SELECT * FROM mobil WHERE kategori = '".$kat."' ORDER BY mobil.status DESC";
      }
      $result = $this->db->query($sql)->result();
      return $result;
    }
 

    public function get_data_struktural() {
            $sql = "SELECT * FROM `struktural`";
            $result = $this->db->query($sql)->result();
            return $result;
    }

    public function get_data_list_peminjaman($id, $tgla = NULL, $tglb = NULL)
    {
        // $sql = "SELECT * FROM peminjaman_mobil WHERE mobil LIKE $id ORDER BY tanggal_pinjam DESC LIMIT 100";
        if(!empty($tgla)){
            $tanggal = "AND `tanggal_pinjam` BETWEEN '$tgla 00:00:00' AND '$tglb 23:59:50'";
        }else{
            $tanggal = '';
        }
        $sql = "SELECT *
                FROM `peminjaman_mobil`
                WHERE `mobil` LIKE '$id'".$tanggal."
                ORDER BY `tanggal_pinjam` DESC;";
        // var_dump($sql);die();
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_list_peminjaman_pengawas($id)
    {
        $date = date('Y-m-d');
        $tanggal = date('Y-m-d', strtotime($date . ' -1 day'));
        $tanggalSetelah = date('Y-m-d', strtotime($date . ' +1 month'));
        // var_dump($date.' - '. $tanggalSetelah);die();
        $sql = "SELECT *  FROM `peminjaman_mobil` WHERE `tanggal_pinjam` BETWEEN '$tanggal 23:50:00' AND '$tanggalSetelah 23:59:59' OR  `tanggal_kembali` BETWEEN '$tanggal 23:59:00' AND '$tanggalSetelah 23:59:59' AND mobil = $id";
        // var_dump($sql);die();
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_list_peminjaman_pengawas2($id)
    {
        $date = date('Y-m-d');
        $tanggal = date('Y-m-d', strtotime($date . ' -1 day'));
        $tanggalSetelah = date('Y-m-d', strtotime($date . ' +1 week'));
        // var_dump($tanggal);die();
        // $sql = "SELECT * FROM `peminjaman_mobil` 
        // WHERE `tanggal_pinjam` 
        // BETWEEN '$tanggal 23:50:00' 
        // AND '$tanggalSetelah 23:59:59' OR `tanggal_kembali` 
        // BETWEEN '$tanggal 23:59:00' 
        // AND '$tanggalSetelah 23:59:59' AND mobil LIKE $id
        // ORDER BY `peminjaman_mobil`.`tanggal_pinjam`  ASC LIMIT 1";
        $sql= "SELECT *  FROM `peminjaman_mobil` WHERE `tanggal_pinjam` BETWEEN '$tanggal 00:00:00.000000' AND '$tanggalSetelah 23:59:59.000000' AND mobil = $id ORDER BY `tanggal_pinjam` ASC LIMIT 1";
        // var_dump($sql);die();
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_peminjaman($tgla = NULL, $tglb = NULL, $button = NULL)
    {
        $sql = "SELECT peminjaman_mobil.*, mobil.nama_mobil, mobil.kategori, mobil.plat 
                FROM peminjaman_mobil 
                INNER JOIN mobil ON mobil.id = peminjaman_mobil.mobil 
                WHERE peminjaman_mobil.tanggal BETWEEN '$tgla' AND '$tglb'";
        if($button == NULL){
            $sql .= " AND mobil.kategori = 'mobil'";
        }
        $sql .= " ORDER BY peminjaman_mobil.tanggal DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_peminjaman_laptop($tgla = NULL, $tglb = NULL)
    {
        $sql = "SELECT peminjaman_mobil.*, mobil.nama_mobil, mobil.kategori, mobil.plat 
                FROM peminjaman_mobil 
                INNER JOIN mobil ON mobil.id = peminjaman_mobil.mobil 
                WHERE peminjaman_mobil.tanggal BETWEEN '$tgla' AND '$tglb'
                AND mobil.kategori = 'laptop'
                ORDER BY peminjaman_mobil.tanggal DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_peminjaman_cek($id)
    {
        // $sql = "SELECT * FROM peminjaman_mobil ORDER BY tanggal DESC";
        $sql = "SELECT peminjaman_mobil.*, mobil.nama_mobil, mobil.kategori, mobil.plat FROM peminjaman_mobil INNER JOIN mobil ON mobil.id = peminjaman_mobil.mobil WHERE id LIKE '$id' ORDER BY tanggal DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_bidang()
    {
        // $sql = "SELECT * FROM `euis_cal_bidang`";
        $year = date('Y');
        $sql = "SELECT * FROM `ketua_tot` WHERE `thn_anggaran` = $year";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function pengawas()
    {
        $sql = "SELECT * FROM mobil ORDER BY kondisi DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function pengawas_mobil()
    {
        $sql = "SELECT * FROM pengawas_mobil ORDER BY id DESC";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_peminjaman_mobil($id = null)
    {
        // Awal query
        $sql = "SELECT * FROM peminjaman_mobil";

        // Cek apakah $id tidak kosong
        if (!empty($id)) {
            // Gunakan LIKE dengan wildcard + escape
            $id = $this->db->escape_like_str($id);
            $sql .= " WHERE peminjam LIKE '%$id%'";
        }

        // Tambahkan order
        $sql .= " ORDER BY status DESC";

        // Eksekusi query
        $result = $this->db->query($sql)->result();
        return $result;
    }


    public function get_pegawai_user($id_user)
    {
        $this->db->select('*');
        $this->db->from('tmpegawai_user');
        $this->db->join('tmpegawai', 'tmpegawai_user.tmpegawai_id = tmpegawai.id');
        $this->db->where('user_id', $id_user);
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_id_mobil_persuratan($id_mobil)
    {
        $jumlah = $this->db->select('id')
            ->from('persuratan')
            ->where('id_mobil', $id_mobil)
            ->get()->row();

        if (!empty($jumlah->id)) {
            $data = $jumlah->id;
        return $data;
        }
    }
    
    public function del_tim_mobil($id_mobil) { //, $user_id, $ket

        $up = $this->db->delete('peminjaman_mobil', array('id' => $id_mobil));
        // var_dump($up);die();

        if ($up) {
                return true;
        } else {
                 return false;
        }
    }

    public function reject($id_mobil) { //, $user_id, $ket


        $data = array(
            'status' => '10'
        );
        $this->db->where('id', $id_mobil);
        $save = $this->db->update('peminjaman_mobil', $data);
        // var_dump($up);die();

        if ($up) {
                return true;
        } else {
                 return false;
        }
    }

    public function delete_surat($id) {
        $jumlah = $this->db->select('id_mobil')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah->id)) {
            $data = $jumlah->id;
        }
        $up = $this->db->delete('persuratan_log', array('persuratan_id' => $data));
        $up_mobil = $this->db->delete('peminjaman_mobil', array('id' => $id));

        if ($up) {
            $del = $this->db->delete('persuratan', array('id' => $data));
            if ($del) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_id_mobil_persuratan_ess3($id_mobil)
    {
        $jumlah = $this->db->select('ess3')
            ->from('persuratan')
            ->where('id_mobil', $id_mobil)
            ->get()->row();

        if (!empty($jumlah->ess3)) {
            $data = $jumlah->ess3;
        return $data;
        }
    }

    // public function test_id_mobil($id)
    // {
    //     $jumlah = $this->db->select('id')
    //         ->from('persuratan')
    //         ->where('id_mobil', $id)
    //         ->get()->row();

    //     if (!empty($jumlah->id)) {
    //         $data = $jumlah->id;
    //     return $data;
    //     }
    // }

    public function get_id_surat($id_mobil)
    {
        $jumlah = $this->db->select('approve')
            ->from('persuratan')
            ->where('id', $id_mobil)
            ->get()->row();

        if (!empty($jumlah->id)) {
            $data = $jumlah->id;
        return $data;
        }
    }

  function id_peminjaman_mobil($id) {
$query = $this->db->select('id_mobil')
    ->from('persuratan')
    ->where('id', $id)
    ->get();
// var_dump($query);die();
if ($query && $query->num_rows() > 0) {
    $row = $query->row_array(); // Mengambil baris hasil query sebagai array
    if (!empty($row['id_mobil'])) {
        $ambileselon = $row['id_mobil'];
    }
} else {
    $ambileselon = '-';
}

return $ambileselon;

  }

  function data_surat($id) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select("*");
    // $otherdb->from("persuratan");
    // $otherdb->where("id", $id);
    // $surat = $otherdb->get()->row();

    // return $surat;

    $jumlah = $this->db->select('*')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah)) {
            $data = $jumlah;
        return $data;
        }
  }

    public function save_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $foto, $nama_file, $ketegori_jenis, $harga,$jumlah){
        $data = array(
            'nama_mobil' => $nama_mobil,
            'kategori' => $ketegori_jenis,
            'plat' => $plat,
            'tahun' => $tahun,
            'jenis' => $jenis,
            'bahan_bakar' => $kategori,
            'kapasitas' => $kapasitas,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'status' => $status,
            'kondisi' => $kondisi,
            'date' => $date,
            'foto' => $nama_file
        );
        $save = $this->db->insert('mobil', $data);
        return $save;
    }

    public function insert_laptop($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver){
        $data = array(
            'mobil' => $id,
            'peminjam' => $idpegawai,
            'tanggal' => date('Y-m-d H:i:s'),
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'tujuan' => $tujuan,
            'bagian' => $bagian,
            'driver' => $driver,
            'status' => '2'
        );
        $save = $this->db->insert('peminjaman_mobil', $data);
        $id_baru = $this->db->insert_id();
        // var_dump($id_baru);die();

        $data = array(
            'peminjam' => $idpegawai,
            'status' => $status,
            'kondisi' => '4'
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('mobil', $data);
        return $id_baru;
    }

    public function get_data_id($id){
        $sql = "SELECT * FROM mobil  
        WHERE id = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function koor_tot_id(){
        $sql = "SELECT * FROM koor_tot";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function tmpegawai(){
        $sql = "SELECT * FROM tmpegawai WHERE e_mail LIKE '%@%'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_id_pengawas($id){
        $sql = "SELECT * FROM pengawas_mobil  
        WHERE id = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_peminjaman_id($id){
        $sql = "SELECT * FROM peminjaman_mobil  
        WHERE id = $id";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_id_pengampu($id)
    {
        $jumlah = $this->db->select('pengampu')
            ->from('koor_tot')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah->pengampu)) {
            $data = $jumlah->pengampu;
        return $data;
        }
    }

    public function get_tim_pengampu($id){
        if($id == ' - '){
            $id = 0;
        }
        // Prepare the SQL query with a placeholder for the parameter
        $sql = "SELECT * FROM nama_tot WHERE pengampu LIKE $id";

        // Execute the query with query bindings
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function edit_data($nama_mobil, $plat, $tahun, $date, $kategori, $status, $kondisi, $jenis, $kapasitas, $id, $oldfoto, $on_off ,$tim, $ketegori_jenis, $harga, $jumlah,$tanggal_pinjam, $tanggal_kembali, $peminjam_laptop = NULL){
        $data = array(
            'nama_mobil' => $nama_mobil,
            'kategori' => $ketegori_jenis,
            'plat' => $plat,
            'tahun' => $tahun,
            'jenis' => $jenis,
            'bahan_bakar' => $kategori,
            'kapasitas' => $kapasitas,
            'status' => $status,
            'kondisi' => $kondisi,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'date' => $date,
            'foto' => $oldfoto,
            'on_off' => $on_off,
            'tot' => $tim,
            'peminjam_laptop' => $peminjam_laptop,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali
        );

        $this->db->where('id', $id);
        $save = $this->db->update('mobil', $data);

        return $save;
    }

    public function get_datasurat($id) {
        $surat = $this->db->select('*')
                     ->from('persuratan')
                     ->where('id', $id)
                     ->get()->row();

        return $surat;
    }

    public function get_idmobil($id)
    {
        $data = " - ";
        $idmobil = $this->db->select('id_mobil')
            ->from('persuratan')
            ->where('id', $id)
            ->get()->row();

        if (!empty($idmobil->id_mobil)) {
            $data = $idmobil->id_mobil;
        }
        return $data;
    }
    
    public function get_approve_mobil($id, $status){
        $data = array(
            'status' => $status
        );
        $this->db->where('id', $id);
        $save = $this->db->update('peminjaman_mobil', $data);
        return $save;
    }

    public function update_path($id, $fileBaru) {
        $data = array(
                        'path' => $fileBaru
                     );

        $this->db->where('id', $id);
        $up = $this->db->update('persuratan', $data);

        if ($up) {
            return true;
        } else {
            return false;
        }
    }

    public function update_ess_3($update,$idpegawai,$id_pengolah){
        $data = array(
            'ess3' => $idpegawai
        );
        $this->db->where('id', $update);
        $save = $this->db->update('persuratan', $data);
        return $save;
    }

    public function get_reject_mobil($id, $status){
        $data = array(
            'status' => $status
        );
        $this->db->where('id', $id);
        $save = $this->db->update('peminjaman_mobil', $data);
        return $save;
    }

    public function get_mobilkeluar($id, $mobil_indit){
        $data = array(
            'pengawas' => 1,
            'id_pengawas' => $mobil_indit
        );
        $this->db->where('id', $id);
        $save = $this->db->update('mobil', $data);
        return $save;
    }

    public function get_mobil_kembali($id, $id_pengawas, $fuel,$keterangan_berangkat,$catatan_berangkat, $kondisi, $catatan_kondisi, $kelengkapan, $catatan_kelengkapan, $foto_bensin){
        $data1 = array(
            'tanggal_kembali' => date('Y-m-d G:i:s'),
            'foto_bensin_Kembali' => $foto_bensin,
            'keterangan_kembali' => $keterangan_berangkat,
            'bensin_kembali' => $fuel,
            'catatan_kembali' => $catatan_berangkat,
            'kondisi_kembali' => $kondisi,
            'catatan_kondisi_kembali' => $catatan_kondisi,
            'kelengkapan_kembali' => $catatan_kelengkapan
        );
        $this->db->where('id', $id_pengawas);
        $save1 = $this->db->update('pengawas_mobil', $data1);
        if($save1){
            $data = array(
                'pengawas' => 0
            );
            $this->db->where('id', $id);
            $save = $this->db->update('mobil', $data);
            if($save){
                $return = TRUE;
            }else{
                $return = FALSE;
            }
        }else{
            $return = FALSE;
        }
        return $return;
    }

    public function get_hapus_mobil($id)
    {
        $this->db->delete('mobil', array('id' => $id));
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

    public function get_id_pegawai($id_user)
    {
        $jumlah = $this->db->select('user_id')
            ->from('tmpegawai_user')
            ->where('tmpegawai_id', $id_user)
            ->get()->row();

        if (!empty($jumlah->user_id)) {
            $data = $jumlah->user_id;
        return $data;
        }
    }

    public function get_no_telp($id_user)
    {
        $jumlah = $this->db->select('no_hp')
            ->from('user')
            ->where('id', $id_user)
            ->get()->row();

        if (!empty($jumlah->no_hp)) {
            $data = $jumlah->no_hp;
        return $data;
        }
    }

    public function get_file_foto($id)
    {
        $jumlah = $this->db->select('foto')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah->foto)) {
            $data = $jumlah->foto;
        return $data;
        }
    }

    public function get_koor_id($id)
    {
        $data = 'Tidak ada';
        $jumlah = $this->db->select('nama_tim')
            ->from('koor_tot')
            ->where('id', $id)
            ->get()->row();

        if (!empty($jumlah->nama_tim)) {
            $data = $jumlah->nama_tim;
        }
        if($data == '-' || $data == NULL || $data == ''){

            $jumlah = $this->db->select('id_pegawai')->from('koor_tot')->where('id', $id)->get()->row();
            if (!empty($jumlah->id_pegawai)) {
                $data = $jumlah->id_pegawai;
            }
            $data = $this->get_nama_user($data);
        }
        return $data;
    }

    public function get_pengampu_id($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('pengampu')
            ->from('koor_tot')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->pengampu)) {
            $data = $pegawai->pengampu;
        }
        return $data;
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

    public function get_unitkerja($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_unitkerja')
            ->from('trunitkerja')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_unitkerja)) {
            $data = $pegawai->n_unitkerja;
        }
        return $data;
    }

    public function get_nama_unit($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('unitkerja_id')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->unitkerja_id)) {
            $data = $pegawai->unitkerja_id;
        }
        return $data;
    }

    public function get_nama_jabatan($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('n_jabatan')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->n_jabatan)) {
            $data = $pegawai->n_jabatan;
        }
        return $data;
    }

    public function get_penerima_nip($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('nip')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->nip)) {
            $data = $pegawai->nip;
        }
        return $data;
    }

    public function get_penerima_nik($id)
    {
        $data = " - ";
        $pegawai = $this->db->select('nik')
            ->from('tmpegawai')
            ->where('id', $id)
            ->get()->row();

        if (!empty($pegawai->nik)) {
            $data = $pegawai->nik;
        }
        return $data;
    }

    public function get_nama_mobil_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('nama_mobil')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->nama_mobil)) {
            $data = $mobil->nama_mobil;
        }
        return $data;
    }

    public function get_platnomor_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('plat')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->plat)) {
            $data = $mobil->plat;
        }
        return $data;
    }

    public function kapasitas($id)
    {
        $data = " - ";
        $mobil = $this->db->select('kapasitas')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->plat)) {
            $data = $mobil->plat;
        }
        return $data;
    }

    public function get_bahan_bakar_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('bahan_bakar')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->bahan_bakar)) {
            $data = $mobil->bahan_bakar;
        }
        return $data;
    }

    public function get_jenis_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('jenis')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->jenis)) {
            $data = $mobil->jenis;
        }
        return $data;
    }

    public function get_kapasitas_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('kapasitas')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->kapasitas)) {
            $data = $mobil->kapasitas;
        }
        return $data;
    }

    public function get_kondisi_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('kondisi')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->kondisi)) {
            $data = $mobil->kondisi;
        }
        return $data;
    }

    public function get_peminjam_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('peminjam')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->peminjam)) {
            $data = $mobil->peminjam;
        }
        return $data;
    }
    public function get_tahun_id($id)
    {
        $data = " - ";
        $mobil = $this->db->select('tahun')
            ->from('mobil')
            ->where('id', $id)
            ->get()->row();

        if (!empty($mobil->tahun)) {
            $data = $mobil->tahun;
        }
        return $data;
    }
    // chat

    public function get_all_cars() {
        return $this->db->get('mobil')->result();
    }

    public function get_car_by_id($car_id) {
        return $this->db->get_where('mobil', array('id' => $car_id))->row();
    }

    public function create_booking($booking_data) {
        $this->db->insert('bookings', $booking_data);
        return $this->db->insert_id();
    }

    public function geus_indit($id, $myString, $tujuan, $keterangan_berangkat, $file, $fuel, $catatan_berangkat, $kondisi, $catatan_kondisi, $kelengkapan, $catatan_kelengkapan,  $id_peminjam) {
        $data = array(
            'mobil' => $id,
            'penumpang' => $myString,
            'tanggal_berangkat' => date('Y-m-d G:i:s'),
            'tanggal_kembali' => NULL,
            'tujuan' => $tujuan,
            'foto_bensin_awal' => $file,
            'foto_bensin_kembali' => NULL,
            'keterangan_pergi' => $keterangan_berangkat,
            'keterangan_kembali' => NULL,
            'bensin' => $fuel,
            'catatan_berangkat' => $catatan_berangkat,
            'kondisi' => $kondisi,
            'catatan_kondisi' => $catatan_kondisi,
            'kelengkapan' => $kelengkapan,
            'catatan_kelengkapan' => $catatan_kelengkapan,
            'id_peminjaman' => $id_peminjam
        );
        $simpan = $this->db->insert('pengawas_mobil', $data);
        $id_input = $this->db->insert_id();
        return $id_input;
    }

    public function pinjam_mobil($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver,$jam_pinjam,$jam_kembali){
        $data = array(
            'mobil' => $id,
            'peminjam' => $idpegawai,
            'tanggal' => date('Y-m-d H:i:s'),
            'tanggal_pinjam' => $tanggal_pinjam.' '.$jam_pinjam,
            'tanggal_kembali' => $tanggal_kembali.' '.$jam_kembali,
            'tujuan' => $tujuan,
            'bagian' => $bagian,
            'driver' => $driver,
            'status' => '10'
        );
        $save = $this->db->insert('peminjaman_mobil', $data);
        $id_baru = $this->db->insert_id();
        // var_dump($id_baru);die();

        $data = array(
            'peminjam' => $idpegawai,
            'status' => $status
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('mobil', $data);
        return $id_baru;
    }

    public function edit_pinjam_mobil($status, $tanggal_pinjam, $tanggal_kembali, $idpegawai, $id, $tujuan, $bagian, $driver,$jam_pinjam,$jam_kembali){
        $data = array(
            // 'mobil' => $id,
            'peminjam' => $idpegawai,
            'tanggal' => date('Y-m-d H:i:s'),
            'tanggal_pinjam' => $tanggal_pinjam.' '.$jam_pinjam,
            'tanggal_kembali' => $tanggal_kembali.' '.$jam_kembali,
            'tujuan' => $tujuan,
            'bagian' => $bagian,
            'driver' => $driver
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('peminjaman_mobil', $data);

        $data = array(
            'peminjam' => $idpegawai,
            'status' => $status
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('mobil', $data);
        return $save1;
    }

    public function kembali_mobil($id, $status){
      $data = array('status' => $status);
      $this->db->where('id', $id);
      $save = $this->db->update('peminjaman_mobil', $data);
    //   $sql = "SELECT *
    //           FROM peminjaman_mobil
    //           WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun";
    //   $result = $this->db->query($sql)->result();
      return $save;
    }

    public function kembali_laptop($id, $status){
      $data = array('status' => $status);
      $this->db->where('id', $id);
      $save = $this->db->update('peminjaman_mobil', $data);
       
      $mobil = $this->db->select('mobil')->from('peminjaman_mobil')->where('id', $id)->get()->row();
      if(!empty($mobil->mobil)) {
        $id_mobil = $mobil->mobil;
        $data = array('kondisi' => '1');
        $this->db->where('id', $id_mobil);
        $save1 = $this->db->update('mobil', $data);  
      }
      return $save;
    }

    public function get_mobil_master($id){
      $sql = "SELECT * FROM `peminjaman_mobil` WHERE `id` LIKE '$id'";
      // var_dump($sql);die();
      $result = $this->db->query($sql)->result();
      return $result;
    }

    public function get_laporan_excel($bulan, $tahun){
      $sql = "SELECT *
              FROM peminjaman_mobil
              WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun";
              // var_dump($sql);die();s
      $result = $this->db->query($sql)->result();
      return $result;
    }
}


