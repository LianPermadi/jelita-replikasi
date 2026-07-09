<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Survey Kepuasan Masyarakat DPMPTSP Prov. Jabar.">
    <meta name="author" content="DPMPTSP Prov. Jabar">
	<title><?= html_escape(isset($title) ? $title : 'SKM .:: DPMPTSP PROVINSI JAWA BARAT ::.') ?></title>


    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="<?=base_url()?>assets/theme_skm/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/theme_skm/css/menu.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/theme_skm/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/theme_skm/css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="<?=base_url()?>assets/theme_skm/css/custom.css" rel="stylesheet">
	
	<!-- MODERNIZR MENU -->
	<script src="<?=base_url()?>assets/theme_skm/js/modernizr.js"></script>

</head>

<body>
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<!-- /Preload -->
	
	<div id="loader_form">
		<div data-loader="circle-side-2"></div>
	</div>
	<!-- /loader_form -->
	
<header class="site-header">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-3">
        <a href="<?=base_url()?>assets/">
          <img src="<?=base_url()?>assets/img/logo12.png" alt="Logo" height="35">
        </a>
      </div>

      <div class="col-9 d-flex justify-content-end align-items-center gap-3">
        <div id="social">
          <ul class="m-0 p-0 d-flex gap-2 list-unstyled">
            <li><a href="#0"><i class="icon-facebook"></i></a></li>
            <li><a href="#0"><i class="icon-twitter"></i></a></li>
            <li><a href="#0"><i class="icon-google"></i></a></li>
            <li><a href="#0"><i class="icon-linkedin"></i></a></li>
          </ul>
        </div>

        <!-- TRIGGER -->
		<!-- <a href="#0" id="navTrigger" class="cd-nav-trigger" aria-expanded="false" aria-controls="main-nav">
		Menu <span class="cd-icon"></span>
		</a>

		<nav id="main-nav" aria-hidden="true">
		<ul class="cd-primary-nav">
			<li><a href="<?php //base_url() ?>/" class="animated_link">Home</a></li>
			<li><a href="<?php //base_url()?>survey/add" class="animated_link">Form SKM</a></li>
			<li><a href="<?php //base_url()?>/" class="animated_link">Login</a></li>
		</ul>
		</nav> -->
<!-- Trigger -->
<a href="#0" id="navTrigger" class="cd-nav-trigger" aria-expanded="false" aria-controls="main-nav">
  Menu <span class="cd-icon"></span>
</a>

<!-- Overlay + Panel -->
<nav id="main-nav" aria-hidden="true">
  <div class="nav-panel" role="dialog" aria-modal="true">
    <button type="button" class="nav-close" aria-label="Tutup">×</button>

    <ul class="nav-menu">
      <li><a href="<?=base_url()?>">Home</a></li>
      <li><a href="<?=base_url()?>survey/add">Form SKM</a></li>
      <li><a href="<?=base_url()?>">Login</a></li>
    </ul>
  </div>
</nav>
      </div>
    </div>
  </div>
</header>

	<main class="container py-4">
		<?php if (empty($content)): ?>
			<p>Belum ada data statistik.</p>
		<?php else: ?>
			<?= $content ?>
		<?php endif; ?>
	</main>

	
	<footer class="clearfix">
		<div class="container">
			<p>© 2019 SKM .:: DPMPTSP PROVINSI JAWA BARAT ::.</p>
			
		</div>
	</footer>
	<!-- end footer-->

	<div class="cd-overlay-nav">
		<span></span>
	</div>
	<!-- /cd-overlay-nav -->

	<div class="cd-overlay-content">
		<span></span>
	</div>
	<!-- /cd-overlay-content -->
	
	<!-- COMMON SCRIPTS -->
	<script src="<?=base_url()?>assets/theme_skm/js/jquery-3.2.1.min.js"></script>
    <script src="<?=base_url()?>assets/theme_skm/js/common_scripts.min.js"></script>
	<script src="<?=base_url()?>assets/theme_skm/js/velocity.min.js"></script>
	<script src="<?=base_url()?>assets/theme_skm/js/functions.js"></script>
	<script src="<?=base_url()?>assets/js/script.js"></script>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="<?=base_url()?>assets/theme_skm/assets/validate.js"></script>
			
</body>
</html>