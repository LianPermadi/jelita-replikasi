<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
  
    public function index()
    {
        $this->load->model('Homepage');
        $this->load->model('EconomyGraphic_model');
        $this->load->model('EconomyStatistic_model');
        $this->load->library('session');
        $this->load->library('language_swicth');
        $this->load->helper('url');
        $this->load->helper('language');

        $lang_locale = $this->session->userdata('locale');

        if ($lang_locale === 'id') {
            $this->lang->load('frontv2', 'indonesia');
            $language_data = $this->lang->language;

            $homePage = $this->Homepage->get_by(0);
        } else {
            $this->lang->load('frontv2', 'english');
            $language_data = $this->lang->language;

            $homePage = $this->Homepage->get_by(1);
        }

        $graphic = $this->EconomyGraphic_model->get_last_5();
        $stats = $this->EconomyStatistic_model->get_first();

        // Inisialisasi default biar gak error
        $date = [];
        $value = [];

        if (!empty($graphic)) {
            foreach ($graphic as $item) {
                $date[] = $item->date;
                $value[] = $item->value;
            }
        }
        var_dump($homePage);die();

        // Cek data kosong untuk view
        $data = array(
            'stats' => !empty($stats) ? $stats : null,
            'date' => !empty($date) ? $date : [],
            'value' => !empty($value) ? $value : [],
            'language_data' => !empty($language_data) ? $language_data : [],
            'homePage' => !empty($homePage) ? $homePage : null
        );
        $this->load->view('newpage/welcome-new', $data);
    }
}
?>
