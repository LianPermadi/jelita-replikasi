<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/* Description of webservice class
 * @author  AgusN  1.0
 * Edit PBS 25/4/2017
 */
class Chatgptapi extends CI_Controller {
  public function __construct() {
    parent::__construct();
        // $this->api_key = $this->config->item('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');
        $this->api_key = $this->config->item('openai_api_key');
        $this->load->model('openai_model');
  }

  public function index() {
        $this->load->view('chatgpt_form');
  }

    public function get_response() {
        $prompt = $this->input->post('prompt');
        if (!$prompt) {
            show_error('Prompt is required');
        }

        $response = $this->openai_model->call_openai_api($prompt);

        if (isset($response['error'])) {
            $data['response'] = $response['error'];
        } elseif (isset($response['choices'][0]['message']['content'])) {
            $data['response'] = $response['choices'][0]['message']['content'];
        } else {
            $data['response'] = 'Error: Unable to get response from OpenAI API';
        }

        $this->load->view('chatgpt_response', $data); // Load view from settings module
    }
}