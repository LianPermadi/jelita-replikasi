<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xml_parsing_win
 *
 * @author Nuryanto
 */
class Xml_parsing_win {
    //put your code here
    function element_set($element_name, $xml, $content_only = false) {
        if ($xml == false) {
            return false;
        }
        $found = preg_match_all('#<' . $element_name . '(?:\s+[^>]+)?>' .
                '(.*?)</' . $element_name . '>#s', $xml, $matches, PREG_PATTERN_ORDER);
        if ($found != false) {
            if ($content_only) {
                return $matches[1];  
            } else {
                return $matches[0];  
            }
        }
        return false;
    }

    function value_in($element_name, $xml, $content_only = true) {
        if ($xml == false) {
            return false;
        }
        $found = preg_match('#<' . $element_name . '(?:\s+[^>]+)?>(.*?)' .
                '</' . $element_name . '>#s', $xml, $matches);
        if ($found != false) {
            if ($content_only) {
                return $matches[1];  
            } else {
                return $matches[0];  
            }
        }
        return false;
    }   

     function postWaSms($n_hp = null, $n_pesan = null, $campaign = null)
  {
    // $settings = new settings();
    // $settings->where('name', 'smsGateway')->get();
    // $statsms = $settings->status;
    // if ($statsms == '1') {
      $receiver = $n_hp;
      $message = $n_pesan;
      $url = 'http://103.122.5.111/new/public/messaging/request/T8eDNwF8nw';

      // Prepare data array for JSON
      $data = [
        'sender' => 'DPMPTSP JBR',
        'msisdn' => $receiver,
        'message' => $message,
        "campaign" => $campaign
      ];

      // Encode data array to JSON
      $json_data = json_encode($data);

      // Initialize cURL session
      $ch = curl_init();

      // Set cURL options
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute cURL session
      $response = curl_exec($ch);

      // Close cURL session
      curl_close($ch);

      // Check for errors and handle response
    //   var_dump($response);die();
      if ($response === false) {
        echo "Error: " . curl_error($ch);
        die;
      } else {
        $json = json_decode($response);
        if (isset($json->status) && $json->status == "200") {
          $result = TRUE;
          return $result;
        } else {
          $result = FALSE;
          echo "Ada Yang Error Kirim SMS: " . $json->message . " " . $json->status;
          return $result;
          // die;
        }
      }
    // }
    return;
  }
    
}

?>
