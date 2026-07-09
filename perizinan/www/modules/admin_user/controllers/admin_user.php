<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Admin_user extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->tmuser = new tmuser();
        $login = $this->session->userdata('login');
        $peran = $this->session->userdata('n_otoritas');
        if (!$login) {
            redirect('admin');
        }
        if ($peran != 'Administrator') {
            redirect('admin');
        }
    }

    function index() {
        $data['isi'] = 'isi';
        $data['title'] = 'Mengelola User';
        $data['judul'] = 'Mengelola User';
        $data['list'] = $this->tmuser->get();

        $this->load->view('template_admin', $data);
    }

    function tambah($error = null) {
        $data['id'] = '';
        $data['c_user'] = '';
        $data['c_password'] = '';
        $data['n_otoritas'] = '';
        $data['c_dep'] = '';
        $data['n_user'] = '';
        $data['email'] = '';
        $data['C_KATEGORI'] = '';
        $data['id'] = '';

        $data['error'] = $error;
        $data['isi'] = 'form';
        $data['title'] = 'Membuat User Baru';
        $data['judul'] = 'Membuat User Baru';


        $this->load->view('template_admin', $data);
    }

    function edit($id = null, $error = null) {
        $dt = $this->tmuser->where("id = '$id'")->get();

        $data['id'] = $dt->id;
        $data['c_user'] = $dt->c_user;
        $data['c_password'] = $dt->c_password;
        $data['n_otoritas'] = $dt->n_otoritas;
        $data['c_dep'] = $dt->c_dep;
        $data['n_user'] = $dt->n_user;
        $data['email'] = $dt->email;
        $data['C_KATEGORI'] = $dt->C_KATEGORI;

        $data['error'] = $error;
        $data['isi'] = 'form';
        $data['title'] = 'Mengedit User';
        $data['judul'] = 'Mengedit User';


        $this->load->view('template_admin', $data);
    }

    function reset_password($id = null, $error = null) {
        $dt = $this->tmuser->where("id = '$id'")->get();

        $data['id'] = $dt->id;
        $data['c_user'] = $dt->c_user;
        $data['c_password'] = $dt->c_password;

        $data['error'] = $error;
        $data['isi'] = 'form_password';
        $data['title'] = 'Reset Password User';
        $data['judul'] = 'Reset Password User';


        $this->load->view('template_admin', $data);
    }

    function delete($id) {

        $this->tmuser->delete($id);
        redirect('admin_user');
    }
function save() {
        $si_user = $this->input->post('user');

        $id = $this->input->post('id');

        $jumlah_dt = $this->tmuser->where("c_user = '$si_user' and id!= '$id'")->count();

        if ($jumlah_dt >= 1) {
            if ($id == "")
                $this->tambah("ERROR,,, <br/> Nama User " . $this->input->post('user') . ", Telah Ada");
            else
                $this->edit($id, "ERROR,,,<br/>Nama User " . $this->input->post('user') . ", Telah Ada");
        }
        else {
            if ($id == ""){
                $data_user = array(
                    'c_user' => $this->input->post('user'),
                   // 'c_password' => MD5($this->input->post('password')),
                    'c_password' =>password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'n_otoritas' => $this->input->post('n_otoritas'),
                    'c_dep' => $this->input->post('bagian'),
                    'n_user' => 'Administrator',
                    'email' => $this->input->post('email'),
                    'C_KATEGORI' => '',
                );                
                $this->tmuser->insert($data_user);
            }
            else{
                $data_user = array(
                    'c_user' => $this->input->post('user'),
                    'n_otoritas' => $this->input->post('n_otoritas'),
                    'c_dep' => $this->input->post('bagian'),
                    'n_user' => 'Administrator',
                    'email' => $this->input->post('email'),
                    'C_KATEGORI' => '',
                );                
                $this->tmuser->update($data_user, $id);
            }    

            redirect('admin_user');
        }
    }
    function save_old() {
        $si_user = $this->input->post('user');

        $id = $this->input->post('id');

        $jumlah_dt = $this->tmuser->where("c_user = '$si_user' and id!= '$id'")->count();

        if ($jumlah_dt >= 1) {
            if ($id == "")
                $this->tambah("ERROR,,, <br/> Nama User " . $this->input->post('user') . ", Telah Ada");
            else
                $this->edit($id, "ERROR,,,<br/>Nama User " . $this->input->post('user') . ", Telah Ada");
        }
        else {
            if ($id == ""){
                $data_user = array(
                    'c_user' => $this->input->post('user'),
                    'c_password' => MD5($this->input->post('password')),
                    'n_otoritas' => $this->input->post('n_otoritas'),
                    'c_dep' => $this->input->post('bagian'),
                    'n_user' => 'Administrator',
                    'email' => $this->input->post('email'),
                    'C_KATEGORI' => '',
                );                
                $this->tmuser->insert($data_user);
            }
            else{
                $data_user = array(
                    'c_user' => $this->input->post('user'),
                    'n_otoritas' => $this->input->post('n_otoritas'),
                    'c_dep' => $this->input->post('bagian'),
                    'n_user' => 'Administrator',
                    'email' => $this->input->post('email'),
                    'C_KATEGORI' => '',
                );                
                $this->tmuser->update($data_user, $id);
            }    

            redirect('admin_user');
        }
    }
 function save_password() {
        $id = $this->input->post('id');

        $data_user = array(
            //'c_password' => MD5($this->input->post('password')),
            'c_password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        );
        $this->tmuser->update($data_user, $id);

        redirect('admin_user');
    }
    function save_password_old() {
        $id = $this->input->post('id');

        $data_user = array(
            'c_password' => MD5($this->input->post('password')),
        );
        $this->tmuser->update($data_user, $id);

        redirect('admin_user');
    }

}

?>
