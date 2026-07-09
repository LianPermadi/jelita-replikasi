<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investmentop extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model'); // Memuat model Banner
        $this->load->helper('url');
        $this->load->model('Investasi_model');
        $this->load->model('WestJavaSectorManagement_model');
        $this->load->library('session');
        $this->load->library('language_swicth');
        $this->load->helper('url');
        $this->load->helper('language'); // Memuat helper language
        $this->load->model('homepage');
        $this->load->model('EconomyGraphic_model');
        $this->load->model('EconomyStatistic_model');
        // $this->lang->load('custom', 'indonesian');
        // $this->load->helper('language'); // Memuat helper language
        // $this->lang->load('front', 'english'); // Memuat file bahasa

        // Mendapatkan nilai locale dari session
       
    }
    public function home() {
        $lang = $this->lang->language;
    
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
    
        // Load the Investasi_model
        $this->load->model('Investasi_model');
    
        // Get sector from input
        $sector = $this->input->get('sector');
        // Get investment data
        // var_dump($lang, $sector);die();
        $investasi = $this->Investasi_model->get_investasi($lang, $sector);
        
        // Calculate total count of investment opportunities
        $investasi_total = count($investasi);
    
        // Perform pagination
        $perPage = 9;
        $currentPage = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset = ($currentPage - 1) * $perPage;

        // dummy data
        $lang = 'id';
        // var_dump($lang, $sector, $perPage, $offset);die();
        $investasi = $this->Investasi_model->get_investasi_paginated($lang, $sector, $perPage, $offset);
    
        // Calculate total number of pages
        $totalPages = ceil($investasi_total / $perPage);
    
        // Make sure current page doesn't exceed total pages
        $currentPage = min($totalPages, $currentPage);
    
        // Calculate last page
        $lastPage = $totalPages;
    
        // Calculate next page URL
        $nextPageUrl = ($currentPage < $totalPages) ? site_url('Investmentop/home?page=' . ($currentPage + 1)) : null;
    
        // Calculate previous page URL
        $prevPageUrl = ($currentPage > 1) ? site_url('Investmentop/home?page=' . ($currentPage - 1)) : null;
    
        // Get sectors
        $sector = $this->db->from('westjavasectormanagement')
                           ->where('isBahasa', ($lang === 'id' ? 0 : 1))
                           ->where_not_in('slug', ($lang === 'id' ? 'wjis-indonesia' : 'wjis-en'))
                           ->order_by('title', 'asc')
                           ->get()
                           ->result();
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
        // Load the view with data
        $data = array(
            'investasi' => $investasi,
            'sector' => $sector,
            'language_data' => $language_data,
            'homePage' => $homePage,
            'investasi_total' => $investasi_total,
            'pagination' => array(
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl // Include previous page URL in pagination data 
            ),
            'value_landing' =>$value_landing
        );
        // var_dump($data);die();
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_investment_op', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    
    
    public function map()
    {
        $lang = $this->session->userdata('locale');
        $lang_locale = $this->session->userdata('locale');
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

      
        if ($lang === 'id') {

            if ($this->input->get('sector')) {
                $investasi = $this->db->where('isBahasa', 0)
                // ->where('fk_sector !=', 2)
                // ->where('fk_sector !=', 3)
                ->where('status_content =', 1)
                ->where('fk_sector', $this->input->get('sector'))
                ->order_by('judul_investasi', 'asc')
                ->get('investasi')
                ->result();
                var_dump($investasi);die();
                
                // $this->db->where('fk_sector', $this->input->get('sector'));
            }else{
                $investasi = $this->db->where('isBahasa', 0)
                // ->where('fk_sector !=', 2)
                // ->where('fk_sector !=', 3)
                ->where('status_content =', 1)
                ->order_by('judul_investasi', 'asc')
                ->get('investasi')
                ->result();
            }
            
            // var_dump($investasi);die();
                                
            
            $sector = $this->db->where('isBahasa', 0)
                            ->where('slug !=', 'wjis-indonesia')
                            ->order_by('title', 'asc')
                            ->get('westjavasectormanagement')
                            ->result();
        } else {

            // $investasi = $this->db->where('isBahasa', 1)
            //                     ->where('fk_sector !=', 2)
            //                     ->where('fk_sector !=', 3)
            //                     ->order_by('judul_investasi', 'asc')
            //                     ->get('investasi')
            //                     ->result();
            if ($this->input->get('sector')) {
                $investasi = $this->db->where('isBahasa', 1)
                // ->where('fk_sector !=', 2)
                // ->where('fk_sector !=', 3)
                ->where('status_content =', 1)
                ->where('fk_sector', $this->input->get('sector'))
                ->order_by('judul_investasi', 'asc')
                ->get('investasi')
                ->result();
                // var_dump($investasi);die();
                
                // $this->db->where('fk_sector', $this->input->get('sector'));
            }else{
                $investasi = $this->db->where('isBahasa', 0)
                // ->where('fk_sector !=', 2)
                // ->where('fk_sector !=', 3)
                ->where('status_content =', 1)
                ->order_by('judul_investasi', 'asc')
                ->get('investasi')
                ->result();
            }
            
            $sector = $this->db->where('isBahasa', 1)
                            ->where('slug !=', 'wjis-en')
                            ->order_by('title', 'asc')
                            ->get('westjavasectormanagement')
                            ->result();
        }
        $graphic = $this->EconomyGraphic_model->get_last_5();
        $stats = $this->EconomyStatistic_model->get_first();
    
        $date = [];
        $value = [];
            // var_dump($graphic);die();
    
        foreach ($graphic as $item) {
            array_push($date, $item->date);
            array_push($value, $item->value);
        }
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
        $data = array(
            'investasi' => $investasi,
            'sector' => $sector,
            'language_data' => $language_data,
            'date' => $date,
            'value' => $value,
            'homePage' => $homePage,
            'value_landing' =>$value_landing
        );

        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_investment_op_map', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    public function show($id) {
        // Ambil data investasi berdasarkan ID
        $investasi = $this->Investasi_model->get_investasi_by_id($id);

        // Rekam view
        $this->Investasi_model->record_view($id);

        $lang = $this->session->userdata('locale');
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

        $graphic = $this->EconomyGraphic_model->get_last_5();
        $stats = $this->EconomyStatistic_model->get_first();
    
        $date = [];
        $value = [];
    
        foreach ($graphic as $item) {
            array_push($date, $item->date);
            array_push($value, $item->value);
        }
        // var_dump($investasi);die();
        $data = array(
            'investasi' => $investasi,
            // 'sector' => $sector,
            'language_data' => $language_data,
            'date' => $date,
            'value' => $value,
            'homePage' => $homePage
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_investment_op_detail', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
    public function show_map($id) {
        // Ambil data investasi berdasarkan ID
        $investasi = $this->Investasi_model->get_investasi_by_id($id);

        // Rekam view
        $this->Investasi_model->record_view($id);

        $lang = $this->session->userdata('locale');
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

        $graphic = $this->EconomyGraphic_model->get_last_5();
        $stats = $this->EconomyStatistic_model->get_first();
    
        $date = [];
        $value = [];
    
        foreach ($graphic as $item) {
            array_push($date, $item->date);
            array_push($value, $item->value);
        }
        // var_dump($investasi);die();
        $data = array(
            'investasi' => $investasi,
            // 'sector' => $sector,
            'language_data' => $language_data,
            'date' => $date,
            'value' => $value,
            'homePage' => $homePage
        );
        $this->load->view('layout/header', $data);
        $this->load->view('newpage/v_investment_op_detail', $data);
        $this->load->view('newpage/v_speak_to_us', $data);
        $this->load->view('layout/footer', $data);  
    }
}
