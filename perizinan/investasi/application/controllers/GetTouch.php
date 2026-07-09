<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetTouch extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model'); // Memuat model Banner
        $this->load->model('User_model'); // Memuat model User
        $this->load->model('homepage');
        $this->load->model('EconomyGraphic_model');
        $this->load->model('EconomyStatistic_model');
        $this->load->library('session');
        $this->load->library('language_swicth');
        $this->load->helper('url');
        $this->load->helper('language'); // Memuat helper language
        $this->load->helper('form');

        // $this->lang->load('custom', 'indonesian');
        // $this->load->helper('language'); // Memuat helper language
        // $this->lang->load('front', 'english'); // Memuat file bahasa

        // Mendapatkan nilai locale dari session
       
    }
    public function home()
    {
        $banner = $this->Banner_model->get_banner_by_menu('contact'); // Mendapatkan banner dengan menu 'contact'
    
        $countries = $this->Banner_model->get_all(); // Mendapatkan semua negara
        $lang_locale = $this->session->userdata('locale');
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;

            $homePage = $this->homepage->get_by(0);

        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

            $homePage = $this->homepage->get_by(1);
        }
        $data = array(
            'banner' => $banner,
            'homePage' => $homePage,
            'language_data' => $language_data,
            'countries' => $countries
        );

        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_get_in_touch', $data);
        $this->load->view('layout/footer', $data);  // Memuat tampilan dengan data yang dibutuhkan
    }

    // Tambahkan fungsi lainnya sesuai kebutuhan seperti create, edit, delete, dll.
}
