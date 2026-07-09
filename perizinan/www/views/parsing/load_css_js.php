<?php
$base_url = base_url().'assets/';
//plugin
$load_css_js=NULL;
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/","jquery-1.7.1.js");
//$load_css_js.=$this->lib_load_css_js->load_css($base_url,"css/default/","superfish.css");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/superfish/","hoverIntent.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/superfish/","superfish.js");

$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/jqui/ui/","jquery.ui.core.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/jqui/ui/","jquery.ui.widget.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/jqui/ui/","jquery.ui.datepicker.js");

$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/tiny_mce/","tiny_mce.js");

$load_css_js.=$this->lib_load_css_js->load_css($base_url,"js/datatables/css/","demo_table_jui.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"js/datatables/themes/smoothness/","jquery-ui-1.8.4.custom.css");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/datatables/js/","jquery.dataTables.js");

////new validate
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/validated/","jquery.validationEngine-en.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/validated/","jquery.validationEngine.js");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"js/validated/","validationEngine.jquery.css");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"js/validated/","setvalidate.js");
//default design
echo $load_css_js;
?>