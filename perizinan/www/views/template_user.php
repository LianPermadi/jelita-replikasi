<?php 
    $base_url=base_url().'assets/';
    $base_urls=base_url().'assets/';
    ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $base_url."2016/images/lkc1.png";?>">
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
  <style type="text/css">
    #pageloader
    {
      background: rgba( 255, 255, 255, 0.8 );
      display: none;
      height: 100%;
      position: fixed;
      width: 100%;
      z-index: 9999;
    }

    #pageloader img
    {
      left: 50%;
      margin-left: -32px;
      margin-top: -32px;
      position: absolute;
      top: 50%;
    }
  </style>
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900' rel='stylesheet' type='text/css'>
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&key=AIzaSyA4ViLjNIDHrK3RnRjhLffu1JvXiCaIrUE&v=3&amp;sensor=false"></script>
  <script>
    var map;
    google.maps.event.addDomListener(window, "load", function () {

      var map = new google.maps.Map(document.getElementById("map_div"), {
        center: new google.maps.LatLng(-0.8610, 134.0622),
        zoom: 15,
        draggable:true,
        styles:
            [ { "featureType": "poi", "elementType": "labels.text", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.business", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "stylers": [ { "visibility": "off" } ] } ]
      });

                    
      var infoWindow = new google.maps.InfoWindow();

                        
      function createMarker(options, html) {
        var marker = new google.maps.Marker(options);
        if (html) {
          google.maps.event.addListener(marker, "click", function () {
            infoWindow.setContent(html);
            infoWindow.open(options.map, this);
          });
        }
        return marker;
      }
                        
      var marker1 = createMarker({
        position: new google.maps.LatLng(-0.8610, 134.0622),
        draggable:true,
        map: map
      });
              
                            
      marker1.addListener('click', function (event) { 
        document.getElementById("maps_latitude").value = event.latLng.lat(); 
        document.getElementById("maps_longitude").value = event.latLng.lng(); 
                            
        alert( document.getElementById("maps_latitude").value+" ,"+ document.getElementById("maps_longitude").value) 
      });
                          
                         
    });
  </script>
  <script>
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
  </script>
  </head>
  
  <body>
    <div id="pageloader">
   <img src="<?php echo base_url(). 'assets/ajax-loader.gif' ?>" alt="Harap Tunggu..." />
   </div>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          	 <?php 
              $db_backoffice = $this->load->database('otherdb', TRUE);
              $backoffice = $db_backoffice->database;
              $sql = "SELECT * FROM $backoffice.settings WHERE name = 'app_name'";
              $nama = $this->db->query($sql)->first_row();
            ?>
          <a class="navbar-brand" href="#"><span><?php echo $nama->value; ?></span> - <?php echo $username; ?></a>
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
    	
    
          	 <?php 
              $db_backoffice = $this->load->database('otherdb', TRUE);
              $backoffice = $db_backoffice->database;
              $sql = "SELECT * FROM $backoffice.settings WHERE name = 'app_right'";
              $app_right = $this->db->query($sql)->first_row();
            ?>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
      <ul class="nav menu">
        <li <?php if($this->uri->segment(3)==""){echo 'class="active"';}?> ><?php echo anchor('main/user/', '<span class="glyphicon glyphicon-dashboard"></span> Status Proses') ?></li>
        <li <?php if($this->uri->segment(3)=="datapemohon"){echo 'class="active"';}?> ><?php echo anchor("main/user/datapemohon", "<span class='glyphicon glyphicon-user'></span> Data Pemohon") ?></li>
        <li <?php if($this->uri->segment(3)=="dokumenpemohon" || $this->uri->segment(3)=="ubahdokumenpemohon"){echo 'class="active"';}?> ><?php echo anchor("main/user/dokumenpemohon", "<span class='glyphicon glyphicon-list'></span> Dokumen Pemohon") ?></li>
        <li <?php if($this->uri->segment(3)=="permohonan" || $this->uri->segment(2)=="permohonan"){echo 'class="active"';}?> ><?php echo anchor('main/user/permohonan', '<span class="glyphicon glyphicon-list-alt"></span> Permohonan Perizinan / Cetak Mandiri</a>') ?></li>
        <li <?php if($this->uri->segment(3)=="history"){echo 'class="active"';}?> ><?php echo anchor('main/user/history', '<span class="glyphicon glyphicon-list-alt"></span> History Permohonan</a>') ?></li>
        <li <?php if($this->uri->segment(2)=="formulir"){echo 'class="active"';}?> ><?php echo anchor('main/formulir/step1', '<span class="glyphicon glyphicon-list-alt"></span> Download Formulir</a>') ?></li>
      </ul>
      <!--<div class="attribution">Copyright © 2012 Kemkominfo <br> BPPT Provinsi Kalimantan Selatan</div>-->
      <div class="attribution">Copyright © <?php echo date('Y').' '.$app_right->value; ?></div>
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
