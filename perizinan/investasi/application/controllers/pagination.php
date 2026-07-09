<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pagination extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary models, libraries, etc.
        $this->load->helper('url'); // Load URL Helper for generating URLs
    }

    public function index() {
        $this->load->view('your_view');
    }

    // Assuming you have a function to handle pagination
    public function pagination_example() {
        // Calculate current page
        $currentPage = $this->input->get('page') ? $this->input->get('page') : 1;

        // Calculate next page
        $nextPage = $currentPage + 1;

        // Assuming you have a base URL set in your config file
        // If not, you can use site_url() function with your controller/method
        $baseUrl = base_url();

        // Constructing the next page URL
        $nextPageUrl = $baseUrl . 'pagination/pagination_example?page=' . $nextPage;

        // Pass the URL to your view
        $data['next_page_url'] = $nextPageUrl;

        // Load your view with the data
        $this->load->view('your_view', $data);
    }

}
