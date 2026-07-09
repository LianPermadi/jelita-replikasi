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
class Admin_download extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmdownload = new tmdownload();
        $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');

        if (!$login){
            redirect('admin');
        }
        if ($peran != 'Administrator'){
            redirect('admin');
        }
    }

    function index() {
        $data['isi'] = 'isi';
        $data['title'] = 'Mengelola Download';
        $data['judul'] = 'Mengelola Download';


        $data['list'] = $this->tmdownload->get();
        $this->load->view('template_admin', $data);
    }

    function tambah() {
        $data['id'] = '';
        $data['error'] = "";
        $data['status'] = '';
        $data['keterangan'] = '';
        $data['file'] = '';

        $data['action'] = 'save';
        $data['isi'] = 'form';
        $data['title'] = 'Tambah Data Download';
        $data['judul'] = 'Tambah Data Download';
        $this->load->view('template_admin', $data);
    }

    function delete($id) {
        $this->tmdownload->delete($id);
        redirect('admin_download');
    }

    function save() {
        $data['id'] = '';
         $data['action'] = 'save';
         $data['isi'] = 'form';
        $data['status'] = $this->input->post("status");
        $data['keterangan'] = $this->input->post('keterangan');
        $data['file'] = '';
         $data['title'] = 'Tambah Data Download';
        $data['judul'] = 'Tambah Data Download';

        $uploads = $_FILES['xfile']['name'];
        if (!empty($uploads)) {
            $config['overwrite'] = false;
            $config['upload_path'] = './uploads/admin_upload/';
            $config['allowed_types'] = '*';
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
                    'D_DOWNLOAD' => date("Y-m-d H:i:s"),
                    'N_ALAMAT_DOWNLOAD' => $file,
                    'N_KETERANGAN_DOWNLOAD' => $this->input->post('keterangan'),
                    'C_STATUS_LINK' => $this->input->post('status')
                );
                $this->tmdownload->insert($data_user);
                redirect('admin_download');
            }
        } else {
            $error = "Berkas File Belum Terisi";
            $data['error'] = $error;
            $this->load->view('template_admin', $data);
        }
    }

    function edit($id=NULL) {
        $dt = $this->tmdownload->where("C_DOWNLOAD = $id")->get();
        $data['id'] = $id;
        $data['error'] = "";

        $data['action'] = 'update';
        $data['status'] = $dt->C_STATUS_LINK;
        $data['keterangan'] = $dt->N_KETERANGAN_DOWNLOAD;
        $data['file'] = $dt->N_ALAMAT_DOWNLOAD;


        $data['isi'] = 'form';
        $data['title'] = 'Ubah Data Download';
        $data['judul'] = 'Ubah Data Download';

        $this->load->view('template_admin', $data);
    }

    function update() {
        $data['isi'] = 'form';
        $data['id'] = $this->input->post("id");
        $data['status'] = $this->input->post("status");
        $data['keterangan'] = $this->input->post('keterangan');
        $data['file'] = $this->input->post('file_uploaded');
        $data['action'] = 'update';
        $data['title'] = 'Ubah Data Download';
        $data['judul'] = 'Ubah Data Download';

        $uploads = $_FILES['xfile']['name'];
        if (!empty($uploads)) {
            $config['overwrite'] = false;
            $config['upload_path'] = './uploads/admin_upload/';
            $config['allowed_types'] = '*';
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
                    'D_DOWNLOAD' => date("Y-m-d H:i:s"),
                    'N_ALAMAT_DOWNLOAD' => $file,
                    'N_KETERANGAN_DOWNLOAD' => $this->input->post('keterangan'),
                    'C_STATUS_LINK' => $this->input->post('status')
                );
                $this->tmdownload->update($data['id'], $data_user);
                redirect('admin_download');
            }
        } else {
            $data_user = array(
                'D_DOWNLOAD' => date("Y-m-d H:i:s"),
                'N_ALAMAT_DOWNLOAD' => $data['file'],
                'N_KETERANGAN_DOWNLOAD' => $this->input->post('keterangan'),
                'C_STATUS_LINK' => $this->input->post('status')
            );
            $this->tmdownload->update($data['id'], $data_user);
            redirect('admin_download');
        }
    }

}

?>
