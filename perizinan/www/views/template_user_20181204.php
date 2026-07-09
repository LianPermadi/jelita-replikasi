<?php 
    $base_url=base_url().'assets/';
    ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $base_url."2016/images/logo-jabar.png";?>">
    <title><?php echo $title; ?></title>
    <?php
    $base_url=base_url().'assets/userassets/';
    $this->load->view('parsing/set_js_base_pendaftaran');
    $this->load->view('parsing/load_css_js_user');
    $username	= $this->session->userdata("username");
    ?>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><span>DPMPTSP</span> - <?php echo $username; ?></a>
          <ul class="user-menu">
            <li class="dropdown pull-right" style="margin-right:10px;margin-left:10px">
              <?php echo anchor('main/login/logout', '<span class="glyphicon glyphicon-log-out"></span> Logout ') ?>
            </li>
            <li class="dropdown pull-right">
              <?php echo anchor('main/user/reset', '<span class="glyphicon glyphicon-log-out"></span> Ganti Password') ?>
            </li>
          </ul>
        </div>
      </div><!-- /.container-fluid -->
    </nav>
    	
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
      <ul class="nav menu">
        <li <?php if($this->uri->segment(3)==""){echo 'class="active"';}?> ><?php echo anchor('main/user/', '<span class="glyphicon glyphicon-dashboard"></span> Status Proses') ?></li>
        <li <?php if($this->uri->segment(3)=="datapemohon"){echo 'class="active"';}?> ><?php echo anchor("main/user/datapemohon", "<span class='glyphicon glyphicon-user'></span> Data Pemohon") ?></li>
        <li <?php if($this->uri->segment(3)=="dokumenpemohon" || $this->uri->segment(3)=="ubahdokumenpemohon"){echo 'class="active"';}?> ><?php echo anchor("main/user/dokumenpemohon", "<span class='glyphicon glyphicon-list'></span> Dokumen Pemohon") ?></li>
        <li <?php if($this->uri->segment(3)=="permohonan" || $this->uri->segment(2)=="permohonan"){echo 'class="active"';}?> ><?php echo anchor('main/user/permohonan', '<span class="glyphicon glyphicon-list-alt"></span> Permohonan Perizinan</a>') ?></li>
        <li <?php if($this->uri->segment(3)=="history"){echo 'class="active"';}?> ><?php echo anchor('main/user/history', '<span class="glyphicon glyphicon-list-alt"></span> History Permohonan</a>') ?></li>
        <li <?php if($this->uri->segment(2)=="formulir"){echo 'class="active"';}?> ><?php echo anchor('main/formulir/step1', '<span class="glyphicon glyphicon-list-alt"></span> Download Formulir</a>') ?></li>
      </ul>
      <!--<div class="attribution">Copyright © 2012 Kemkominfo <br> BPPT Provinsi Jawa Barat</div>-->
      <div class="attribution">Copyright © 2015 DPMPTSP Provinsi Jawa Barat</div>
    </div><!--/.sidebar-->
    
    <!-- Main Content -->	
    <?php $this->load->view($load); ?>
    <!-- END Main Content -->	
    
    <script>
      jQuery(document).ready(function() {
        UIModals.init();
      });
      
      $('#calendar').datepicker({
      });
      
      !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
            $(this).find('em:first').toggleClass("glyphicon-minus");      
        }); 
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
      }(window.jQuery);
      
      $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
      })
      $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
      })
    </script>	
  </body>
</html>
