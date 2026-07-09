<?php
// application/controllers/Skm.php

defined('BASEPATH') or exit('No direct script access allowed');

class Skm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Helpers & Libraries pengganti incLibrary*.php lama
        $this->load->helper(['url', 'form']);
        $this->load->library(['session']);
        $this->load->model(['Skm_model', 'Statistik_model']);

        // Jika ada menu/foto/terms dari helper lama, mapping ke helper baru:
        $this->load->helper('skm_helper'); // berisi function: menu_atas(), menu_utama(), foto(), tampil_custom_tabel()
    }

    /**
     * Halaman default: Statistik (grafik)
     */
    public function index()
    {
    $data['title']   = 'Statistik SKM';
    $data['content'] = $this->Skm_model->get_statistik_content(); // HTML utuh
    $this->load->view('skm/desain_statistik', $data);
    }

    /**
     * Tampilan form Add (SurveiAdd.php lama)
     */
    public function add()
    {
        $this->_handlePostActions(); // menangani submit ins/upd jika dipost ke endpoint yang sama

        $data['content']    = $this->Skm_model->get_form_add(); // return HTML string atau array komponen
        $data['gambar']     = foto();
        $data['terms']      = tampil_custom_tabel('nama_tc', 'skm_tc', '');
        $data['menu_atas']  = menu_atas();
        $data['title']      = 'Tambah Survei';

        $this->load->view('skm/desain_skm_add', $data);
    }

    /**
     * Tampilan form Add1 (SurveiAdd1.php lama)
     */
    public function add1()
    {
        $this->_handlePostActions();

        $data['content']    = $this->Skm_model->get_form_add1();
        $data['menu_utama'] = menu_utama();
        $data['terms']      = tampil_custom_tabel('nama_tc', 'skm_tc', '');
        $data['menu_atas']  = menu_atas();
        $data['title']      = 'Tambah Survei (Mode 1)';

        $this->load->view('skm/desain3', $data);
    }

    /**
     * Pencarian (VendorBarangAdd1.php lama) — disesuaikan untuk SKM
     */
    public function search()
    {
        $this->_handlePostActions();

        $keyword           = $this->input->get('q', true);
        $data['content']   = $this->Skm_model->search_view($keyword);
        $data['menu_utama']= menu_utama();
        $data['terms']     = tampil_custom_tabel('nama_tc', 'skm_tc', '');
        $data['menu_atas'] = menu_atas();
        $data['title']     = 'Pencarian Survei';

        $this->load->view('skm/desain2', $data);
    }

    /**
     * Edit (SurveiEdit.php lama)
     */
    public function edit()
    {
        $this->_handlePostActions();

        $id                = $this->input->get('id');
        $data['content']   = $this->Skm_model->get_form_edit($id);
        $data['menu_utama']= menu_utama();
        $data['terms']     = tampil_custom_tabel('nama_tc', 'skm_tc', '');
        $data['menu_atas'] = menu_atas();
        $data['title']     = 'Edit Survei';

        $this->load->view('skm/desain3', $data);
    }

    /**
     * Detail list (VendorBarangPenawaranList.php lama) — disesuaikan untuk SKM
     */
    public function detail()
    {
        $id                = $this->input->get('id');
        $data['content']   = $this->Skm_model->get_detail_list($id);
        $data['menu_utama']= menu_utama();
        $data['terms']     = tampil_custom_tabel('nama_tc', 'skm_tc', '');
        $data['menu_atas'] = menu_atas();
        $data['title']     = 'Detail Penawaran';

        $this->load->view('skm/desain2', $data);
    }

    /**
     * Delete (VendorBarangDel.php lama)
     */
    public function delete()
    {
        $id = $this->input->get('id');
        if ($id) {
            $this->Skm_model->delete_by_id($id);
            $this->session->set_flashdata('msg', 'Data berhasil dihapus.');
        }
        redirect('skm');
    }

    /**
     * Handler untuk aksi POST lama: ins, ins1, upd
     * - menggantikan switch($sQuery) pada skrip lama
     */
    private function _handlePostActions()
    {
        $submit = $this->input->post('submit');
        if (!$submit) return;

        $qry = $this->input->post('qry');
        switch ($qry) {
            case 'ins':
                // SurveiIns.php -> doInsert_fnc()
                if ($this->Skm_model->insert()) {
                    $this->session->set_flashdata('msg', 'Data berhasil disimpan.');
                } else {
                    $this->session->set_flashdata('err', 'Gagal menyimpan data.');
                }
                redirect('skm/add');
                break;
            case 'ins1':
                // SurveiIns1.php -> doInsert_fnc()
                if ($this->Skm_model->insert_variant()) {
                    $this->session->set_flashdata('msg', 'Data (varian) berhasil disimpan.');
                } else {
                    $this->session->set_flashdata('err', 'Gagal menyimpan data (varian).');
                }
                redirect('skm/add1');
                break;
            case 'upd':
                // SurveiUpd.php -> doUpdate_fnc()
                $id = $this->input->post('id');
                if ($this->Skm_model->update($id)) {
                    $this->session->set_flashdata('msg', 'Data berhasil diperbarui.');
                } else {
                    $this->session->set_flashdata('err', 'Gagal memperbarui data.');
                }
                redirect('skm/edit?id=' . urlencode($id));
                break;
            default:
                // no-op
                break;
        }
    }
}