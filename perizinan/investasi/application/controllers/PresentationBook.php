<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PresentationBook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Publikasi_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('language');
        $this->load->helper('security');
    }

    public function index() {
        // Fetch the banner
        $banner = $this->Banner_model->get_by_menu('presentation-book');
        $lang_locale = $this->session->userdata('locale');

        // Fetch all publications ordered by created_at descending
        $publikasi = $this->Publikasi_model->get_all_ordered_by_date();
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;


        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

        }
        $data = array(
            'language_data' => $language_data,
            'banner' => $banner,
            'publikasi' => $publikasi
        );
        // Pass data to the view
        
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_presentation_book', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    public function show($slug) {
        // Fetch the publication by its slug from the database
        $publikasi = $this->Publikasi_model->get_by_slug($slug);
        // var_dump($publikasi);die();
        // Check if the publication exists
        if (!$publikasi) {
            show_404(); // If the publication doesn't exist, show a 404 page
        }
        $lang_locale = $this->session->userdata('locale');

        // Pass the publication data to the view
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;


        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

        }
        $data = array(
            'language_data' => $language_data,
            'publikasi' => $publikasi
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_presentasion_book_detail', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    
}
?>
