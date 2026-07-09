<?php 
class Api extends MY_Controller {
     function __construct() {
        parent::__construct();

        $this->tm_pengaduan = new Tm_pengaduan();
        $this->tmwcm=new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $this->load->model('api_model');
        // Load library 'security' untuk pengaturan keamanan
        // $this->load->library('security');
     }

    public function hash() {
        // Call the function to generate a strong password
        $strongPassword = $this->generateStrongPassword();
        echo "Strong Password: " . $strongPassword;
    }

public function get_data_api() {
    // Mendapatkan data dari model
    $token = "sOCVaW0mGG1R";
    $confirm = $this->input->get('token');
    $id = $this->input->get('id');
    $a = $this->input->get('a');
    $b = $this->input->get('b');
    var_dump($id);
    echo '<br/>';
    var_dump($confirm);
    echo '<br/>';
    var_dump($token);
    echo '<br/>';
    var_dump($token == $confirm);die();
    // $data = $this->Api_model->get_data_from_database();
    if($token == $confirm) {
        $data = $this->api_model->get_data_from_database();

        // Set header untuk response berupa JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Jika token tidak valid, kirim respons 404
        $this->output->set_status_header(404);
        echo "404 Not Found";
    }
}

    private function generateStrongPassword($length = 12) {
        // List of characters that could be used in the password
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_+=';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $max)];
        }
        return $password;
    }
}