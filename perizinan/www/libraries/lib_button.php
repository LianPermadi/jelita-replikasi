<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lib_button
 *
 * @author Obi
 */
class lib_button {

    function tambah_data($url=NUll, $id_load=NULL) {
        $but = '<button id="tambah_data" onclick="get_free_url(' . "'$url'" . ', ' . "'$id_load'" . ')"><table><tr><td><img src="' . base_url() . 'assets/css/default/icon/plus-white.png"></td><td valign="center">Tambah Data</td></tr></table></button>';
        return $but;
    }

    function simpan_data($link=NUll) {
        $but = '<button id="tambah_data" type="submit"><table class="table"><tr><td><img src="' . base_url() . 'assets/css/default/icon/save.png"></td><td valign="center">Simpan</td></tr></table></button>';
        return $but;
    }

    function reset_data($link=NUll) {
        $but = '<button id="tambah_data" type="reset"><table class="table"><tr><td><img src="' . base_url() . 'assets/css/default/icon/reset.png"></td><td valign="center">Reset</td></tr></table></button>';
        return $but;
    }

    function menu_utama($link=NUll) {
        $but = '<button id="tambah_data" onclick="link(\'menu_utama\')"><table class="table"><tr><td><img src="' . base_url() . 'assets/css/default/icon/computer.png" width=20></td><td valign="center">Menu Utama</td></tr></table></button>';
        return $but;
    }

    function close_data($id_close=NUll) {
        $but = '<button id="tambah_data" onclick="tutup(' . "'$id_close'" . ')"><table class="table"><tr><td><img src="' . base_url() . 'assets/css/default/icon/close.png"></td><td valign="center"> Tutup </td></tr></table></button>';
        return $but;
    }

    function login($link=NUll) {
        $but = '<button id="tambah_data" type="submit"><table class="table"><tr><td><img src="' . base_url() . 'assets/css/images/login.gif" width=20></td><td valign="center">Login</td></tr></table></button>';
        return $but;
    }

    function delete_icon($url=NUll, $id_load=NULL) {
        $btn = '<img src="' . base_url() . 'assets/css/default/icon/cross.png' . '"title="Delete Data">';
        return $btn;
    }

    function edit_icon($url=NUll, $id_load=NULL) {
        $btn = '<img src="' . base_url() . 'assets/css/default/icon/detail.png' . '" title="Ubah Data">';
        return $btn;
    }

    function detail_icon($url=NUll, $id_load=NULL) {
        $btn = '<img src="' . base_url() . 'assets/css/default/icon/lihat.gif' . '">';
        return $btn;
    }
    
    function reset_pass($url=NUll, $id_load=NULL) {
        $btn = '<img src="' . base_url() . 'assets/css/default/icon/reset.png' . '" title="Reset Password">';
        return $btn;
    }    
    function ubah_notifikasi_header($icon="detail.png",$title="") {
        $btn = '<img src="' . base_url() . 'assets/css/default/icon/'.$icon.'" title="'.$title.'">';
        return $btn;
    }

}

?>
