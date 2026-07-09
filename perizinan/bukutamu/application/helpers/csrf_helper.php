<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function csrf_token()
{
    $CI =& get_instance();

    // Buat token jika belum ada
    if (!$CI->session->userdata('csrf_token')) {
        $CI->session->set_userdata('csrf_token', md5(uniqid(rand(), TRUE)));
    }

    return $CI->session->userdata('csrf_token');
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '" />';
}

function validate_csrf()
{
    $CI =& get_instance();
    $posted = $CI->input->post('csrf_token');
    $session = $CI->session->userdata('csrf_token');

    return $posted && $session && $posted === $session;
}
