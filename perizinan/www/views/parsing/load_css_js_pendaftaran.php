<?php
$base_url = base_url().'assets/pendaftaran/';
//plugin
$load_css_js=NULL;

$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","flexslider.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","line-icons.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","elegant-icons.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","lightbox.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","bootstrap.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","theme-aquatica.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"front/css/","me.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/font-awesome/css/","font-awesome.min.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/datepicker/css/","datepicker.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/DataTables/media/css/","DT_bootstrap.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/select2/","select2.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/fonts/","style.css");

$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","modernizr-2.6.2-respond-1.1.0.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","jquery.plugin.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","bootstrap.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","jquery.flexslider-min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","smooth-scroll.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","skrollr.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","spectragram.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","scrollReveal.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","isotope.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","twitterFetcher_v10_min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","lightbox.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","jquery.countdown.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-validation/dist/","jquery.validate.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-maskmoney/","jquery.maskMoney.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/bootstrap-datepicker/js/","bootstrap-datepicker.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/select2/","select2.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/DataTables/media/js/","jquery.dataTables.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/DataTables/media/js/","DT_bootstrap.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","scripts.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","me.js");
//default design
echo $load_css_js;
?>