<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* Description of welcome @author PBS 2017 */
class cekpt extends MY_Controller {
  
  function __construct() {
    parent::__construct();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
  }
  
  function index($varOK=NULL) {
    return redirect('backoffice/assets/file_mohon_sartek/PT_'.$varOK.'.pdf');
	}
}
?>