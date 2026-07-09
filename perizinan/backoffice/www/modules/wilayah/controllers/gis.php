<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Jenis Kegiatan class
 *
 * @author Muhammad Rizky 
 * Created : 08 Okt 2010
 *
 */

class Gis extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       
            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '5') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        // if ($this->session->userdata('username') != 'nirwan') {
        //     echo "Sedang Dalam Pengembangan, Nirwan.";die;
        // }
        
        $data['list']  = $this->sql();
        
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                
                $(document).ready(function() {
                        oTable = $('#kegiatan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Data Konfigurasi Kategori GIS";
        $this->template->build('gis_list', $this->session_info);
    }

    public function create() {
        $data['save_method'] = "save";
        $data['id'] = "";
        $data['nama']  = "";
        $data['warna']  = "";
        $js_date = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);
        
        $this->load->vars($data);
        
        $this->session_info['page_name'] = "Tambah Kategori GIS";
        $this->template->build('gis_edit', $this->session_info);
    }

    public function save() {
        $nama = $this->input->post('nama_gis');
        $warna = $this->input->post('warna_gis');
        $data = array(
                'nama' => $nama,
                'warna' => $warna
        );

        $insert = $this->db->insert('survei_perijinan_point_kategori', $data);

        if ($insert) {
            $this->session->set_flashdata('sukses', "Berhasil Menambah Data.");
            redirect('wilayah/gis');
        } else {
            $this->session->set_flashdata('gagal', "Gagal Menambah Data : ".$this->db->_error_message());
            redirect('wilayah/gis');
        }
    }

    public function edit($id_edit = NULL) {
        $sql = "select * FROM survei_perijinan_point_kategori WHERE kode = ?";
        $query = $this->db->query($sql, $id_edit);
        $row = $query->row();

        if (isset($row))
        {
            $data['id']     = $row->kode;
            $data['nama']   = $row->nama;
            $data['warna']  = $row->warna;
        }

        $js_date = "
                $(document).ready(function() {
                $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);
        $data['save_method'] = "update";
        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Kategori GIS";
        $this->template->build('gis_edit', $this->session_info);
    }

    public function update() {
        $id     = $this->input->post('id');
        $nama   = $this->input->post('nama_gis');
        $warna  = $this->input->post('warna_gis');

        $this->db->set('nama', $nama);
        $this->db->set('warna', $warna);
        $this->db->where('kode', $id);
        $updt = $this->db->update('survei_perijinan_point_kategori');

        if ($updt) {
            $this->session->set_flashdata('sukses', "Berhasil Mengubah Data.");
            redirect('wilayah/gis');
        } else {
            $this->session->set_flashdata('gagal', "Gagal Mengubah Data : ".$this->db->_error_message());
            redirect('wilayah/gis');
        }
    }

    public function delete($id = NULL) {
        $this->db->where('kode', $id);
        $hapus = $this->db->delete('survei_perijinan_point_kategori');

        if($hapus) {
            $this->session->set_flashdata('sukses', "Berhasil Menghapus Data.");
            redirect('wilayah/gis');
        } else {
            $this->session->set_flashdata('gagal', "Gagal Menghapus Data : ".$this->db->_error_message());
            redirect('wilayah/gis');
        }
    }

    public function list_point($id) {
        // if ($this->session->userdata('username') != 'nirwan') {
        //     echo "Sedang Dalam Pengembangan, Nirwan.";die;
        // }

        $data['id']    = $id;
        $data['list']  = $this->sql_point($id);
        
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                
                $(document).ready(function() {
                        oTable = $('#kegiatan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Data Konfigurasi Point GIS";
        $this->template->build('gis_point_list', $this->session_info);
    }

    public function create_point($id) {
        $data['save_method']    = "save_point";
        $data['id']             = $id;
        $data['kode']           = "";
        $data['judul']          = "";
        $data['lat_point']      = "";
        $data['lon_point']      = "";
        $js_date = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);
        
        $this->load->vars($data);
        
        $this->session_info['page_name'] = "Tambah Kategori GIS";
        $this->template->build('gis_point_edit', $this->session_info);
    }

    public function save_point() {
        $id = $this->input->post('id');
        $judul = $this->input->post('judul');
        $lat = $this->input->post('lat_point');
        $lon = $this->input->post('lon_point');
        $data = array(
                'judul' => $judul,
                'kategori_id' => $id,
                'lat_point' => $lat,
                'lon_point' => $lon,
                'petugas_id' => $this->session->userdata('id_auth'),
                'tgl_buat' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('survei_perijinan_point', $data);

        if ($insert) {
            $this->session->set_flashdata('sukses', "Berhasil Menambah Data.");
            redirect('wilayah/gis/list_point/'.$id);
        } else {
            $this->session->set_flashdata('gagal', "Gagal Menambah Data : ".$this->db->_error_message());
            redirect('wilayah/gis/list_point/'.$id);
        }
    }

    public function edit_point($id, $id_back = NULL) {
        $sql = "select * FROM survei_perijinan_point WHERE kode = ?";
        $query = $this->db->query($sql, $id);
        $row = $query->row();

        if (isset($row))
        {
            $data['kode']       = $row->kode;
            $data['judul']      = $row->judul;
            $data['lat_point']  = $row->lat_point;
            $data['lon_point']  = $row->lon_point;
        }


        $data['save_method']    = "update_point";
        $data['id']             = $id_back;
        $data['kode']           = $id;

        $js_date = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);
        
        $this->load->vars($data);
        
        $this->session_info['page_name'] = "Tambah Kategori GIS";
        $this->template->build('gis_point_edit', $this->session_info);
    }

    public function update_point() {
        $id = $this->input->post('id');
        $kode = $this->input->post('kode');
        $judul = $this->input->post('judul');
        $lat = $this->input->post('lat_point');
        $lon = $this->input->post('lon_point');

        $this->db->set('judul', $judul);
        $this->db->set('lat_point', $lat);
        $this->db->set('lon_point', $lon);
        $this->db->set('tgl_ubah', date("Y-m-d H:i:s"));
        $this->db->where('kode', $kode);
        $updt = $this->db->update('survei_perijinan_point');

        if ($updt) {
            $this->session->set_flashdata('sukses', "Berhasil Mengubah Data.");
            redirect('wilayah/gis/list_point/'.$id);
        } else {
            $this->session->set_flashdata('gagal', "Gagal Mengubah Data : ".$this->db->_error_message());
            redirect('wilayah/gis/list_point/'.$id);
        }
    }

    public function delete_point($id = NULL, $id_back = NULL) {
        $this->db->where('kode', $id);
        $hapus = $this->db->delete('survei_perijinan_point');

        if($hapus) {
            $this->session->set_flashdata('sukses', "Berhasil Menghapus Data.");
            redirect('wilayah/gis/list_point/'.$id_back);
        } else {
            $this->session->set_flashdata('gagal', "Gagal Menghapus Data : ".$this->db->_error_message());
            redirect('wilayah/gis/list_point/'.$id_back);
        }
    }

    public function sql()
    {
        $query = "select * FROM survei_perijinan_point_kategori";
        $hasil = $this->db->query($query);
       return $hasil->result();
    }

    public function sql_point($id)
    {
        $query = "select * FROM survei_perijinan_point WHERE kategori_id = ?";
        $hasil = $this->db->query($query, $id);
       return $hasil->result();
    }

}

// This is the end of holiday class
