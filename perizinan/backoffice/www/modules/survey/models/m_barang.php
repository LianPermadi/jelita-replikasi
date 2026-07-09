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

class M_barang extends Model {
    public function get_data() {
            $sql = "SELECT * FROM list_barang  
                    ORDER BY list_barang.date DESC";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_pengajuan() {
            $sql = "SELECT * FROM barang_list_user  
                    ORDER BY barang_list_user.date DESC";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_user() {
            $sql = "SELECT * FROM list_barang  
                    ORDER BY list_barang.date DESC";
                $result = $this->db->query($sql)->result();
        return $result;
    }


    public function get_barang() {
            $sql = "SELECT * 
                FROM list_barang";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_barang_id($id) {
            $sql = "SELECT * 
                FROM list_barang WHERE id = '$id'";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_user() {
            $sql = "SELECT * 
                FROM tmpegawai";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_pegawai_user($id_user) {
            $sql = "SELECT * 
                FROM tmpegawai_user INNER JOIN tmpegawai ON tmpegawai_user.tmpegawai_id = tmpegawai.id WHERE user_id = $id_user";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_pegawai_user_n_pegawai($id_user) {
        $jumlah = $this->db->select('tmpegawai_id')
                ->from('tmpegawai_user')
                ->where('user_id', $id_user)
                ->get()->row();

        if (!empty($jumlah->tmpegawai_id)) {
            $data = $jumlah->tmpegawai_id;
        }
        return $data;
    }
    
    public function save_data($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan) {
        $data = array(
                        'nama_barang'   => $barang,
                        'jumlah'        => $jumlah,
                        'merk'          => $merk,
                        'satuan'        => $satuan,
                        'date'          => $date,
                        'penerima'      => $id_user,
                        'simpan'        => $simpan
                     );
        $save = $this->db->insert('list_barang', $data);
        return $result;
    }

    public function save_log($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan, $nama_user) {
        $data = array(
                        'log'           => '<h2>Barang masuk</h2>'.'Nama Barang : '.$barang.'<br>'.'Jumlah Barang : '.$jumlah.'<br>'.'Merk : '.$merk.'<br>'.'<b>Penginput Barang : '.$nama_user.'</b>',
                        'date'          => $date,
                        'status'        => '1'
                     );
        $save = $this->db->insert('barang_log', $data);
        return $result;
    }

    public function save_order($id_user, $id, $jumlah, $hasil) {
        $data = array(
                        'id_user'        => $id_user,
                        'id_barang'      => $id,
                        'jumlah_barang'         => $jumlah
                     );
        $save = $this->db->insert('permintaan', $data);
        $data1 = array(
                    'jumlah' => $hasil
                     );
        $this->db->where('id', $id);
        $save1 = $this->db->update('list_barang', $data1);
        $sql = "SELECT * FROM tmpegawai_user INNER JOIN tmpegawai ON tmpegawai_user.tmpegawai_id = tmpegawai.id WHERE user_id = $id_user";
                $result = $this->db->query($sql)->result();
        return $result;
        return $result;
    }

    public function get_checkout() {
      $id_user      = $this->session->userdata('id_auth');
        $sql        = "SELECT * FROM permintaan INNER JOIN list_barang ON list_barang.id = permintaan.id_barang WHERE id_user LIKE '$id_user'";
        $result     = $this->db->query($sql)->result();
        return $result;
    }

    public function get_permintaan() {
      $id_user      = $this->session->userdata('id_auth');
            $sql = "SELECT * FROM permintaan WHERE id_user LIKE '$id_user'";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    Public function get_jumlah_awal($id){
        $sql = "SELECT jumlah FROM list_barang WHERE id = $id";
        $jumlah = $this->db->select('jumlah')
                ->from('list_barang')
                ->where('id', $id)
                ->get()->row();

        if (!empty($jumlah->jumlah)) {
            $data = $jumlah->jumlah;
        }
        return $data;
        $result = $this->db->query($sql)->result();
    }

    public function hapus_checkout($id, $id_barang, $hasil){
        $data1 = array(
            'jumlah' => $hasil
        );
        $this->db->where('id', $id_barang);
        $save1 = $this->db->update('list_barang', $data1);
        $up = $this->db->delete('permintaan', array('no_id' => $id));
    }

    public function save_checkout($pemberi, $barang, $penerima, $status) {
        $data = array(
            'nama_barang'       => $barang,
            'pemberi_barang'    => $pemberi,
            'penerima_barang'   => $penerima,
            'status'            => $status,
            'date'              => date('Y-m-d G:i:s')
        );
        $save = $this->db->insert('barang_master', $data);

        $id_user      = $this->session->userdata('id_auth');
        $up = $this->db->delete('permintaan', array('id_user' => $id_user));
    }

    public function get_data_master(){
        $id_user      = $this->session->userdata('id_auth');
            $sql = "SELECT * FROM `barang_master` ORDER BY barang_master.date DESC";
            $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_user_master(){
        $id_user      = $this->session->userdata('id_auth');
            $sql = "SELECT * FROM `barang_list_user` ORDER BY barang_list_user.date DESC";
            $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_data_barang_nama_barang($id){
        $data = " - ";
        $pegawai = $this->db->select('nama_barang')
                     ->from('list_barang')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->nama_barang)) {
            $data = $pegawai->nama_barang;
        }
        return $data;
    }

    public function get_data_user_n_pegawai($id){
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

    public function get_pemberi_barang($id){
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

    public function get_penerima_barang($id){
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

    public function get_log(){
        $id_user      = $this->session->userdata('id_auth');
            $sql = "SELECT * FROM `barang_log`  
ORDER BY `barang_log`.`date`  DESC";
                $result = $this->db->query($sql)->result();
        return $result;
    }

    // 20 februari 2023

    public function get_update_barang($id, $hasil, $text, $jumlah2, $barang, $merk, $penginput, $date){
        $data1 = array(
            'jumlah' => $hasil,
            'tambah' => $text,
            'date'   => $date
        );
        $this->db->where('id', $id);
        $save1 = $this->db->update('list_barang', $data1);

        $data = array(
                        'log'           => '<h3>Tambah Barang Yang sudah ada</h3>'.'Nama Barang : '.$barang.'<br>'.'Jumlah Barang : '.$jumlah2.'<br>'.'Merk : '.$merk.'<br>'.'<b>Penginput Barang : '.$penginput.'</b>',
                        'date'          => $date,
                        'status'        => '1'
                     );
        $save = $this->db->insert('barang_log', $data);
    }
}