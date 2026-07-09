<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('MenuAtas')) {
    function MenuAtas() {
        // kembalikan HTML navbar/menu atas
        return '<nav>/* menu atas */</nav>';
    }
}

if (!function_exists('MenuUtama')) {
    function MenuUtama() {
        // kembalikan HTML menu utama
        return '<aside>/* menu utama */</aside>';
    }
}

if (!function_exists('foto')) {
    function foto() {
        // render gambar header atau logo
        return '<img src="'.base_url('assets/img/header.png').'" alt="header">';
    }
}
