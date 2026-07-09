<?php
$base_url = base_url().'assets/userassets/';
//plugin
$load_css_js=NULL;

$load_css_js.=$this->lib_load_css_js->load_css($base_url,"css/","bootstrap.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"css/","datepicker.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"css/","bootstrap-table.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"css/","styles.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"plugins/select/css/","bootstrap-select.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"plugins/bootstrap-modal/css/","bootstrap-modal-bs3patch.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"plugins/bootstrap-modal/css/","bootstrap-modal.css");

$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","jquery-1.11.1.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","bootstrap.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","chart.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","chart-data.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","easypiechart.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","easypiechart-data.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","bootstrap-datepicker.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","bootstrap-table.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","ui-modals.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"plugins/select/js/","bootstrap-select.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"plugins/bootstrap-modal/js/","bootstrap-modal.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"plugins/bootstrap-modal/js/","bootstrap-modalmanager.js");
//default design
echo $load_css_js;
?>