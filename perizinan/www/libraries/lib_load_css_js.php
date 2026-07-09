<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lib_load_css_js
 *
 * @author Obi
 */
class Lib_load_css_js {
    //put your code here
    function load_css($base, $url, $nama_css){
        $css='<link rel="stylesheet" type="text/css" href="'.$base.$url.$nama_css.'" media="screen">
            ';
        return $css;
    }

    function load_js($base, $url, $nama_js){
        $js='<script type="text/javascript" src="'.$base.$url.$nama_js.'"></script>
            ';
        return $js;

    }
}
?>
