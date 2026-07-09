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
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/css/","main.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/css/","main-responsive.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/iCheck/skins/","all.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/plugins/perfect-scrollbar/src/","perfect-scrollbar.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/css/","theme_light.css");
$load_css_js.=$this->lib_load_css_js->load_css($base_url,"back/css/","print.css");

$load_css_js.=$this->lib_load_css_js->load_js($base_url,"front/js/","modernizr-2.6.2-respond-1.1.0.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-ui/","jquery-ui-1.10.2.custom.min.js");
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
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/bootstrap-hover-dropdown/","bootstrap-hover-dropdown.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-validation/dist/","jquery.validate.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/blockUI/","jquery.blockUI.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/perfect-scrollbar/src/","perfect-scrollbar.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/select2/","select2.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/perfect-scrollbar/src/","jquery.mousewheel.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/iCheck/","jquery.icheck.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/less/","less-1.5.0.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-cookie/","jquery.cookie.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/bootstrap-colorpalette/js/","bootstrap-colorpalette.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/js/","main.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/plugins/jquery-validation/dist/","jquery.validate.min.js");
$load_css_js.=$this->lib_load_css_js->load_js($base_url,"back/js/","login.js");
//default design
echo $load_css_js;
?>