<?php
function post_clean($key) {
    $CI =& get_instance();

    // load library 'security' secara paksa dari core (khusus CI2)
    if (!isset($CI->security)) {
        require_once(BASEPATH . 'codeigniter/Security.php');
        $CI->security = new CI_Security();
    }

    return $CI->security->xss_clean($CI->input->post($key));
}