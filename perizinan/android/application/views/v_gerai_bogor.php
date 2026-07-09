
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>DPMPTSP Provinsi Kalimantan Utara</title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

  <!-- CSS  -->
  <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo">
        <img src="<?php echo base_url(); ?>assets/img/bpmpt.png" class="logo"/>
      </a>
      <ul class="right hide-on-med-and-down">
        <li><a href="<?php echo base_url(); ?>index.php">Beranda</a></li>
        <li><a href="<?php echo base_url(); ?>ceksyarat">Cek Persyaratan</a></li>
        <li class="active"><a href="<?php echo base_url(); ?>cekmohon">Cek Permohonan</a></li>
        <li class="active"><a href="<?php echo base_url(); ?>login_form">Login</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <div class="row">
          <div class="col s12">
            <div class="card">
              <div class="card-image">
                <img src="<?php echo base_url(); ?>assets/img/preview.jpg">
                <img class="card-title-image logo-side-nav" src="<?php echo base_url(); ?>assets/img/kaltara.png"/>
                <span class="card-title">
                    BPMPT
                </span>
                <span class="card-title-description">
                  Provinsi Kalimantan Utara
                </span>
              </div>
            </div>
          </div>
        </div>
        <li><a href="<?php echo base_url(); ?>index.php"><i class="material-icons">store</i> Beranda</a></li>
        <li><a href="<?php echo base_url(); ?>ceksyarat"><i class="material-icons">list</i> Cek Persyaratan</a></li>
        <li><a href="<?php echo base_url(); ?>cekmohon"><i class="material-icons">thumbs_up_down</i> Cek Permohonan</a></li>
        <li class="no-padding">
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header"><i class="material-icons" style="color: #444;">place</i>Gerai Layanan</a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="<?php echo base_url(); ?>gerai/bandung">Bandung</a></li>
                  <li><a href="<?php echo base_url(); ?>gerai/bogor">Bogor</a></li>
                  <li><a href="<?php echo base_url(); ?>gerai/cirebon">Cirebon</a></li>
                  <li><a href="<?php echo base_url(); ?>gerai/garut">Garut</a></li>
                  <li><a href="<?php echo base_url(); ?>gerai/purwakarta">Purwakarta</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <h4 class="header center">Gerai Layanan <br /> Bandung</h4>
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container" style="margin-top: 30px;">
    <div class="section">

      <!--   Icon Section   -->

      <div class="row">
        <div class="col s12">
          <div class="card">
            <div class="card-image">
              <img src="<?php echo base_url(); ?>assets/img/bogor.png">
              <span class="card-title gerai-title">Gerai Layanan Bogor</span>
              <span class="card-title gerai-description">Jl. Ir. H. Juanda Nomor 4, Bogor</span>
            </div>
            <div class="card-content">
              Jenis Layanan Perizinan
              <ol>
                <li>Surat Keputusan Izin Trayek Angkutan Kota Dalam Provinsi (AKDP).</li>
                <li>Kartu Pengawasan Izin Trayek Angkutan Kota Dalam Provinsi (KP).</li>
                <li>Izin Serah Pakai Tanah (ISPT).</li>
                <li>Surat Izin Pemanfaatan Tanah Pemerintah Provinsi (SIPTPP) Sempadan Sungai.</li>
                <li>Surat Izin Pengambilan dan Pemanfaatan Air (SIPPA) Permukaan.</li>
              </ol>
            </div>
            <!-- <div class="card-action">
              <a href="#">This is a link</a>
            </div> -->
          </div>
        </div>
      </div>


    </div>
  </div>

  <footer class="page-footer teal">
    <!-- <div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">Tentang BPMPT</h5>
          <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Provinsi Kalimantan Utara berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div> -->
    <div class="footer-copyright">
      <div class="container">
      2017 © DPMPTSP Provinsi Kalimantan Utara
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>

  </body>
</html>
