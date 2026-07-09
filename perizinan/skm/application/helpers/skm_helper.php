<?php
// application/helpers/skm_helper.php

defined('BASEPATH') or exit('No direct script access allowed');

function menu_atas()
{
    // TODO: render HTML menu atas
    return '<nav class="menu-atas">Menu Atas</nav>';
}

function menu_utama()
{
    return '<nav class="menu-utama">Menu Utama</nav>';
}

function foto()
{
    // TODO: jika perlu generate url foto
    return base_url('assets/img/default.png');
}

function tampil_custom_tabel($kolom, $tabel, $where)
{
    $CI = &get_instance();
    $builder = $CI->db->select($kolom)->from($tabel);
    if (!empty($where)) $builder->where($where);
    $rows = $builder->get()->result();

    // Kembalikan HTML sederhana <option> untuk contoh (seperti "terms")
    $html = '';
    foreach ($rows as $r) {
        $val = htmlentities($r->$kolom, ENT_QUOTES, 'UTF-8');
        $html .= "<option value=\"{$val}\">{$val}</option>";
    }
    return $html;
}