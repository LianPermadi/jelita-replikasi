<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('m_api'); // Ganti 'Your_model' dengan nama model Anda
    
    }

    public function index($token = NULL)
    {
        // Mengambil token dari parameter URL
        // $token = $this->input->get('token');

        // Validasi token
        if ($token == 'FgBcoIszpj') {
            // // Token valid, lakukan sesuatu di sini

            // // Contoh: Kirim respon dalam format JSON
            // $response = array(
            //     'status' => 'success',
            //     'message' => 'Token valid'
            // );
            // // Atur tipe konten sebagai JSON
            // header('Content-Type: application/json');
            // // Mengirim respons dalam format JSON
            // echo json_encode($response);
            

            // Set header untuk menetapkan tipe konten sebagai JSON
            header('Content-Type: application/json');
            // Panggil metode get_data_from_database() dari model
            $data = $this->m_api->get_data_from_database();
            // var_dump($data);die();

            // Kirim respons JSON
            // $data = str_replace('null', '', $data);
            echo json_encode($data);
            // echo $data;
            // echo json_decode($data);
            // var_dump($data);

        } else {
            // Token tidak valid
            $response = array(
                'status' => 'error',
                'message' => 'Invalid token'
            );
            // Atur tipe konten sebagai JSON
            header('Content-Type: application/json');
            // Mengirim respons dalam format JSON
            echo json_encode($response);
        }
    }
}

?>
