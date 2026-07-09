<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Artikel_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('language');
        $this->load->helper('security');
    }
    public function index()
    {
        

        // Mendapatkan nilai locale dari session
        $lang_locale = $this->session->userdata('locale');
        
        // Load banner
        $banner = $this->Banner_model->get_by_menu('news');

        // Define the per page limit
        $per_page = 9;
        // Get the current page from the URL, default is 1
        $current_page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($current_page - 1) * $per_page;

        if ($lang_locale === 'id') {
            $this->lang->load('frontv2', 'indonesian');
            $news = $this->Artikel_model->get_by_lang_type('id', $per_page, $offset);
        } else {
            $this->lang->load('frontv2', 'english');
            $news = $this->Artikel_model->get_by_lang_type('en', $per_page, $offset);
        }

        // Calculate total number of pages
        $total_news = $this->Artikel_model->count_by_lang_type($lang_locale === 'id' ? 'id' : 'en');
        $last_page = ceil($total_news / $per_page);

        // Generate pagination URLs
        $prev_page_url = $current_page > 1 ? site_url('news/index?page=' . ($current_page - 1)) : null;
        $next_page_url = $current_page < $last_page ? site_url('news/index?page=' . ($current_page + 1)) : null;
        $lang_locale = $this->session->userdata('locale');
        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;


        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

        }
        $data = array(
            'news' => $news,
            'language_data' => $language_data,
            'banner' => $banner,
            'current_page' => $current_page,
            'last_page' => $last_page,
            'prev_page_url' => $prev_page_url,
            'next_page_url' => $next_page_url
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_news', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    public function show($slug)
    {
        $news = $this->Artikel_model->get_by_slug($slug);
        // var_dump($news);die();

        if (!$news) {
            show_404(); // If the news item doesn't exist, show a 404 page
        }
        $lang_locale = $this->session->userdata('locale');

        if ($lang_locale === 'id') {
            $this->lang->load('frontv2' ,'indonesia');
            $language_data = $this->lang->language;


        } else {
            $this->lang->load('frontv2' ,'english');
            $language_data = $this->lang->language;

        }
        $data = array(
            'news' => $news,
            'language_data' => $language_data
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_new_detail', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
}
?>
