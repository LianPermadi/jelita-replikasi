<!DOCTYPE html>
<html lang="en">

<head>
<?php 
    $base_url=base_url().'assets/';
    ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="<?php // echo $base_url."2016/images/logo-jabar.png";?>"> -->
  <!-- <link rel="icon" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/images/icon/Logo_Jabar_Clr.png"> -->
  <link rel="icon" href="<?php echo $base_url."2016/images/lkc1.png";?>">
  <title>DPMPTSP</title>
  
  
  <!-- jquery -->
  <script src="<?php echo $base_url.'2016/js/jquery-1.11.0.js';?>"></script>
   
  <!-- bootstrap -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/libs/bootstrap-3.3.4/css/bootstrap.min.css';?>">
  <script src="<?php echo $base_url.'2016/libs/bootstrap-3.3.4/js/bootstrap.min.js';?>"></script>
  <!-- one page scroll -->
  <script type="text/javascript" src="<?php echo $base_url.'2016/libs/onepage-scroll/jquery.onepage-scroll.min.js';?>"></script>
  <link href='<?php echo $base_url.'2016/css/onepage-scroll.css';?>' rel='stylesheet' type='text/css'>
  <!-- flag -->
  <link href='<?php echo $base_url.'2016/css/flag-icon.css';?>' rel='stylesheet' type='text/css'>
  
  
  <script src="<?php echo $base_url.'2016/libs/modernizr/modernizr.js';?>"></script> <!-- Modernizr -->
  <script src="<?php echo $base_url.'2016/js/scriptSubMenu.js';?>"></script> <!-- SCript Sub Menu -->

  <!-- highcharts -->
  <script src="<?php echo $base_url.'2016/libs/highcharts/highcharts.js';?>"></script>
  <script src="<?php echo $base_url.'2016/libs/highcharts/modules/exporting.js';?>"></script>
  
  <!-- font-awesome -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/libs/font-awesome/css/font-awesome.css';?>">
  
  <!-- css -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/css/reset.css';?>"> <!-- css reset -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/css/style.css';?>"> <!-- resource style -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/css/custom.css';?>"> <!-- custom css -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/css/stylesSubMenu.css';?>"> <!-- CSS sub Menu -->
  <link rel="stylesheet" href="<?php echo $base_url.'2016/css/progress-tracker.css';?>"> 


<?php
        $base_url=base_url().'assets/';
        $this->load->view('parsing/set_js_base');
        $this->load->view('parsing/load_css_js');
        echo $this->lib_load_css_js->load_js($base_url,"js/default/","default.js");
        
        $tmbg=new Tmbg();
        $get=$tmbg->where("link_status = 1")->get();
        
        $template_name=$get->link_css;
        $template = "css/".$template_name."/";        
        //echo $template;
        $load_css_js = NULL;
        //$load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"");
        //$load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"");
        echo $load_css_js;
        ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>    
    </head>

<body  style="height:100%">

<?PHP 
$this->load->view('parsing/header');
//$this->load->view('parsing/main_menu');
    ?>

<style type="text/css">
  #fixedbutton {
    float:right;
      position: sticky;
      position: -webkit-sticky;
      position: -moz-sticky;
      position: -ms-sticky;
      position: -o-sticky;
      bottom: 0px; 
      padding: 20px;
  }

  #fixedbutton:hover {
  transform: scale(1.2);
}
</style>

 <div class="container" style="margin-top:100px;margin-bottom:10px;min-height:60%;
        height: auto !important;
        height: 100%;">
<div class="row">
    
<div class="col-md-3">
    
    <?php 
    $active = "style='color: rgb(0, 0, 0);
    background: rgba(255, 165, 0, 0.168627);'";
    
    ?>  

    <div id="cssmenu">
    <ul id="ul87">
	 <!-- <li class="268" ><a <?php echo $this->uri->segment(2)=="bws"?$active:"";?> id="link268" href="<?php echo site_url();?>main/bws"><span>Wistle Blowing<span></span></span></a></li> disable sementara WBS -->
      <li class="269" ><a <?php echo $this->uri->segment(2)=="pengaduan"?$active:"";?> id="link269" href="<?php echo site_url();?>main/pengaduan"><span>Pengaduan Online<span></span></span></a></li>
      <!--<li class="268"><a <?php //echo $this->uri->segment(2)=="jenis_perizinan"?$active:"";?> id="link268" href="<?php //echo site_url();?>main/jenis_perizinan"><span>Daftar Jenis Perijinan<span></span></span></a></li>-->
      <!-- <li class="268"><a href="http://dpmptsp.jabarprov.go.id/web/pages/detail/254-daftar-jenis-perizinan/87/87/301"><span>Daftar Jenis Perijinan<span></span></span></a></li> -->
      <li class="268"><a href="<?php echo site_url();?>main/jenis_perizinan"><span>Daftar Jenis Perijinan<span></span></span></a></li>

      <li class="270"><a <?php echo $this->uri->segment(2)=="pendaftaranbaru"?$active:"";?> id="link270" href="<?php echo site_url();?>main/pendaftaranbaru/perizinanonline"><span>Perizinan Online<span></span></span></a></li>
      <li class="271"><a <?php echo $this->uri->segment(2)==""?$active:"";?> id="link271" href="<?php echo site_url();?>main"><span>Cek Status Izin<span></span></span></a></li>
      <li class="271"><a id="link272" href="<?php echo site_url();?>main/cek_kend"><span>Cek Nomor Kendaraan<span></span></span></a></li>
      <li class="267"><a id="link267" href="https://oss.go.id"><span>OSS ONLINE<span></span></span></a></li>
     
    </ul>    
    
  
  </div>
  
      <img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/web/themes/default/images/menu_kiri.png" class="img-responsive hidden-xs hidden-sm" style="margin-bottom:15px;">

    </div>

    <div class="col-md-9">
        
     <?php
        $this->load->view($isi);
    ?>
  
    </div>

</div>
</div>
 
 <footer id="footer" style="position:relative">
      <?php $this->load->view('parsing/footer'); ?>

      </footer>

    </body>
</html>
