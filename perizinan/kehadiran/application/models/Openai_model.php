<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Openai_model extends CI_Model  {

    private $api_key;

    public function __construct() {
        parent::__construct();
        // $this->api_key = $this->config->item('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');
        $this->api_key = $this->config->item('openai_api_key');     

        // Debugging statement
        if (!$this->api_key) {
            show_error('OpenAI API key is not set');
        }
    }

    public function call_openai_api($prompt) {
        $url = 'https://api.openai.com/v1/chat/completions';

        $data = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => array(
                array(
                    'role' => 'user',
                    'content' => $prompt
                )
            ),
            'max_tokens' => 100,
            'temperature' => 0.7
        );

        
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->api_key
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = 'Curl error: ' . curl_error($ch);
            log_message('error', $error_msg);
            curl_close($ch);
            return array('error' => $error_msg);
        }

        if ($http_code != 200) {
            $error_msg = 'HTTP error: ' . $http_code . ' Response: ' . $response;
            log_message('error', $error_msg);
            curl_close($ch);
            return array('error' => $error_msg);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}