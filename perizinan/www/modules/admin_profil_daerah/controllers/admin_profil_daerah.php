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
class Admin_profil_daerah extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminformasi = new Tminformasi();

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

        $dt = $this->tminformasi->where("id_informasi = 1")->get();


        $data['id'] = 1;
        $data['judul_informasi'] = $dt->judul_informasi;
        $data['isi_informasi'] = $dt->isi_informasi;


        $data['isi'] = 'form';
        $data['title'] = 'Data Profil Daerah';
        $data['judul'] = 'Data Profil Daerah';
        $this->load->view('template_admin', $data);
    }

    function save() {
        $data_user = array(
            'judul_informasi' => $this->input->post('judul_informasi'),
            'isi_informasi' => $this->input->post('isi_informasi')
        );

        $id = 1;

        $this->tminformasi->update($id, $data_user);
        // kembalikan ke halaman manajemen user
        redirect('admin_profil_daerah');
    }

}

?>
