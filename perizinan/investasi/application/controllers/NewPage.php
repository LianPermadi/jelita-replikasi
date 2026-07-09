<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewPage extends CI_Controller {

    public function index()
    {
        $this->load->model('homepage');
        $this->load->model('EconomyGraphic_model');
        $this->load->model('EconomyStatistic_model');
        $this->load->library('session');
        $this->load->library('language_swicth');
        $this->load->helper('url');
        $this->load->helper('language'); // Memuat helper language
        // $this->lang->load('custom', 'indonesian');
        // $this->load->helper('language'); // Memuat helper language
        // $this->lang->load('front', 'english'); // Memuat file bahasa

        // Mendapatkan nilai locale dari session
        $lang_locale = $this->session->userdata('locale');
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;

            $homePage = $this->homepage->get_by(0);

        } elseif($lang_locale === NULL) {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

            $homePage = $this->homepage->get_by();
        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

            $homePage = $this->homepage->get_by(1);
        }
        // var_dump($homePage);die();
        // $value_landing = $this->homepage->get_by_v2();
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;

            $value_landing = $this->homepage->get_by_v2(0);

        } elseif($lang_locale === NULL) {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

            $value_landing = $this->homepage->get_by_v2();
        } elseif($lang_locale === 'EN') {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

            $value_landing = $this->homepage->get_by_v2(1);
        }

        // var_dump($value_landing);die();

        $graphic = $this->EconomyGraphic_model->get_last_5();
        $stats = $this->EconomyStatistic_model->get_first();
    
        $date = [];
        $value = [];
    
        foreach ($graphic as $item) {
            array_push($date, $item->date);
            array_push($value, $item->value);
        }
    
        $data = array(
            'stats' => $stats,
            'date' => $date,
            'value' => $value,
            'language_data' => $language_data,
            'homePage' => $homePage,
            'value_landing' =>$value_landing
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/welcome-new', $data);
        $this->load->view('layout/footer', $data);  

    }
    
}
