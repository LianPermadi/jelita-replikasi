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
  <link rel="icon" href="<?php echo $base_url."2016/images/logo-jabar.png";?>">
  
  <title>DPMPTSP Jawa Barat</title>
  
  
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
        $load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"");
        $load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"");
        echo $load_css_js;
        ?>


        
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
      <li class="269" ><a <?php echo $this->uri->segment(2)=="pengaduan"?$active:"";?> id="link269" href="<?php echo site_url();?>main/pengaduan"><span>Pengaduan Online<span></span></span></a></li>
      <li class="268"><a <?php echo $this->uri->segment(2)=="jenis_perizinan"?$active:"";?> id="link268" href="<?php echo site_url();?>main/jenis_perizinan"><span>Daftar Jenis Perijinan<span></span></span></a></li>
      <!--<li class="268"><a href ="http://dpmptsp.jabarprov.go.id/web/pages/detail/254-daftar-jenis-perizinan/87/87/301"><span>Daftar Jenis Perijinan<span></span></span></a></li>-->
      <li class="270"><a <?php echo $this->uri->segment(2)=="pendaftaranbaru"?$active:"";?> id="link270" href="<?php echo site_url();?>main/pendaftaranbaru"><span>Perijinan Online<span></span></span></a></li>
      <li class="271"><a <?php echo $this->uri->segment(2)==""?$active:"";?> id="link271" href="<?php echo site_url();?>main"><span>Cek Status Ijin<span></span></span></a></li>
      <li class="267"><a id="link267" href="../../web/index.php/pages/detail/271-oss-online-online-single-submission/87/87/267"><span>OSS ONLINE<span></span></span></a></li>
      <li class="217"><a id="link217" href="../../web/index.php/pages/detail/176-lkpm-online/87/87/217"><span>LKPM ONLINE<span></span></span></a></li>
      <li class="230"><a id="link230" href="../../web/index.php/pages/detail/188-sipid-online/87/87/230"><span>SIPID ONLINE<span></span></span></a></li>
     
    </ul>    
    
  
  </div>
  
      <img src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/menu_kiri.png" class="img-responsive hidden-xs hidden-sm" style="margin-bottom:15px;">

    </div>

    <div class="col-md-9">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/dt/css/dt/jquery.dataTables.min.css">
  	<script src="<?php echo $base_url;?>/dt/js/dt/jquery-1.12.0.min.js"></script>
  	<script src="<?php echo $base_url;?>/dt/js/dt/jquery.dataTables.min.js"></script>
      <?php
          // var_dump($isi);die();
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
