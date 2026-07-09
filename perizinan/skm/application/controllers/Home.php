<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_survey_ipak");
        $this->load->model("Bukutamu_model");

        $this->load->library('form_validation');
      //  $this->load->model("user_model");
		//if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
    }
    public function index($info = null)
    {   

        //  $data['list2'] = $this->M_survey->get_sektor2();
        // $data['namampp'] = $this->Bukutamu_model->get_namampp();
        // $this->load->view("index", $data);
        $data['namampp'] = $this->Bukutamu_model->get_namampp();

        // var_dump($data['namampp']);die();
        $this->load->view("form_survey", $data);
    }
    public function cek_nib(){
        $nib = $this->input->post('nib');
        $carinib = $this->M_survey->get_nib($nib);
    
        // Periksa apakah $carinib tidak kosong dan mengambil NIB
        if (!empty($carinib) && isset($carinib[0]->nib)) {
            // Ambil NIB dari objek
            $nib_value = $carinib[0]->nib;
    
            // Simpan NIB ke dalam session
            $this->session->set_userdata('nib', $nib_value);
            
            $this->session->set_flashdata('success', 'NIB ditemukan, Anda bisa mengisi form.');
            $data['namampp'] = $this->Bukutamu_model->get_namampp();
            $this->load->view("index", $data);
        } else {
            $data['notif'] = "Mohon Maaf, Sedang Perbaikan Sistem<br>Proses Permohonan Izin Online melalui JELITA Jabar Kami Tutup<br>";
            $this->session->set_flashdata('error', 'Mohon Maaf NIB Tidak Ditemukan, Cek Kembali Nomor Induk Berusaha Anda');
    
            $data['namampp'] = $this->Bukutamu_model->get_namampp();
            $this->load->view("index", $data);
        }
    }
    
   
    public function add()
    {
        $data = array(
            'p_nama'              => $this->input->post('p_nama'),
            'n_telp'              => $this->input->post('n_telp'),
            'email'               => $this->input->post('email'),
            'jenis_kelamin'       => $this->input->post('jenis_kelamin'),
            'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir'),
            'pekerjaan'           => $this->input->post('pekerjaan'),
            'Pekerjaan_lainnya'   => $this->input->post('Pekerjaan_lainnya'),
            'sektor_layanan'      => $this->input->post('sektor_layanan'),
            'PK_pertanyaan_1'     => $this->input->post('PK_pertanyaan_1'),
            'PK_pertanyaan_2'     => $this->input->post('PK_pertanyaan_2'),
            'PK_pertanyaan_3'     => $this->input->post('PK_pertanyaan_3'),
            'PK_pertanyaan_4'     => $this->input->post('PK_pertanyaan_4'),
            'PK_pertanyaan_5'     => $this->input->post('PK_pertanyaan_5'),
            'PK_pertanyaan_6'     => $this->input->post('PK_pertanyaan_6'),
            'PK_pertanyaan_7'     => $this->input->post('PK_pertanyaan_7'),
            'PK_pertanyaan_8'     => $this->input->post('PK_pertanyaan_8'),
            'PK_pertanyaan_9'     => $this->input->post('PK_pertanyaan_9'),
            'PK_pertanyaan_10'    => $this->input->post('PK_pertanyaan_10')
        );

         if ($this->M_survey_ipak->insert_survey($data)) {
                $this->session->set_flashdata('success', 'Survey berhasil disimpan, Terima Kasih Sudah mengisi Survey');
                redirect('/'); // Redirect setelah berhasil
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan, coba lagi.');
                redirect('/');
            }
    }
    
    
    public function Form_pengisian_survey($info = null)
    {   

        $data['namampp'] = $this->Bukutamu_model->get_namampp();
        $this->load->view("form_survey", $data);
    }


}
