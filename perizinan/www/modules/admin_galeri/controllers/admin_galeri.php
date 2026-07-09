<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Anto
 */
class Admin_galeri extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmgaleri = new tmgaleri();
         $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login) {
            redirect('admin');
        }
        if ($peran != 'Administrator'){
            redirect('admin');
        }
    }

    function index() {
        $data['isi'] = 'isi';
        $data['title'] = 'Mengelola Galeri';
        $data['judul'] = 'Mengelola Galeri';

        $data['list'] = $this->tmgaleri->get();
        $this->load->view('template_admin', $data);
    }

    function tambah() {
        $data['isi'] = 'form';
        $data['title'] = 'Tambah File Galeri';
        $data['judul'] = 'Tambah File Galeri';
        $data['id'] = '';
        $data['file'] = '';
        $data['keterangan'] = '';
        $data['error'] = "";
        $data['status'] = "1";
        $data['action'] = 'save';
        $this->load->view('template_admin', $data);
    }

    function save() {
        $data['isi'] = 'form';
        $data['title'] = 'Tambah Berita Baru';
        $data['judul'] = 'Tambah Berita Baru';
        $data['id'] = '';
        $data['file'] = '';
        $data['action'] = 'save';

        $data['keterangan'] = $this->input->post('keterangan');
        $tanggal = date("Y-m-d H:i:s");


        $uploads = $_FILES['xfile']['name'];
        if (!empty($uploads)) {
            $config['overwrite'] = false;
            $config['upload_path'] = './uploads/galeri/';
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field = 'xfile';
            if (!$this->upload->do_upload($field)) {
                $x = array('<p>', '</p>');
                $error = str_replace($x, '', $this->upload->display_errors());
                $data['error'] = $error;
                $this->load->view('template_admin', $data);
            } else {
                $uploaded = $this->upload->data();
                $file = $uploaded['file_name'];

                $data_user = array(
                    'D_GALLERY' => $tanggal,
                    'N_ALAMAT_GALLERY' => $file,
                    'N_KETERANGAN_GALLERY' => $this->input->post('keterangan'),
                    'C_STATUS_LINK' => $this->input->post('status')
                );
                $this->tmgaleri->insert($data_user);
                redirect('admin_galeri');
            }
        } else {
            $data['error'] = "File Galeri Belum Terpilih";
            $this->load->view('template_admin', $data);
        }
    }

    function edit($id=NULL) {
        $dt = $this->tmgaleri->where("C_GALLERY = $id")->get();
        $data['isi'] = 'form';
        $data['title'] = 'Tambah Berita Baru';
        $data['judul'] = 'Tambah Berita Baru';
        $data['id'] = $id;
        $data['file'] = $dt->N_ALAMAT_GALLERY;
        $data['keterangan'] = $dt->N_KETERANGAN_GALLERY;
        $data['error'] = "";
        $data['status'] = $dt->C_STATUS_LINK;
        $data['action'] = 'update';
        $this->load->view('template_admin', $data);
    }

    function update() {
        $data['isi'] = 'form';
        $data['title'] = 'Tambah Berita Baru';
        $data['judul'] = 'Tambah Berita Baru';
        $data['id'] = $this->input->post('id');
        $data['file'] = $this->input->post('file_uploaded');
        $data['action'] = 'update';

        $data['keterangan'] = $this->input->post('keterangan');
        $tanggal = date("Y-m-d H:i:s");


        $uploads = $_FILES['xfile']['name'];
        if (!empty($uploads)) {
            $config['overwrite'] = false;
            $config['upload_path'] = './uploads/galeri/';
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field = 'xfile';
            if (!$this->upload->do_upload($field)) {
                $x = array('<p>', '</p>');
                $error = str_replace($x, '', $this->upload->display_errors());
                $data['error'] = $error;
                $this->load->view('template_admin', $data);
            } else {
                $uploaded = $this->upload->data();
                $file = $uploaded['file_name'];
                $data_user = array(
                    'D_GALLERY' => $tanggal,
                    'N_ALAMAT_GALLERY' => $file,
                    'N_KETERANGAN_GALLERY' => $this->input->post('keterangan'),
                    'C_STATUS_LINK' => $this->input->post('status')
                );
                 $this->tmgaleri->update($data['id'], $data_user);
                redirect('admin_galeri');
            }
        } else {
      
            $data_user = array(
                'D_GALLERY' => $tanggal,
                'N_ALAMAT_GALLERY' =>  $data['file'] ,
                'N_KETERANGAN_GALLERY' => $this->input->post('keterangan'),
                'C_STATUS_LINK' => $this->input->post('status')
            );
            $this->tmgaleri->update($data['id'], $data_user);
            redirect('admin_galeri');
        }
    }

    function delete($id) {
        $this->tmgaleri->delete($id);
        redirect('admin_galeri');
    }

}

?>
