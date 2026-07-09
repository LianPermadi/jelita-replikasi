<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
				<a class="navbar-brand" href="#"><span>BPMPT</span> - Upload Formulir</a>
				<ul class="user-menu">
					<li class="dropdown pull-right" style="margin-right:10px;margin-left:10px">
						<?php echo anchor('main/upload_formulir/logout', '<span class="glyphicon glyphicon-log-out"></span> Logout ') ?>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
		
	<?php /*
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="active"><?php echo anchor('main/user/', '<span class="glyphicon glyphicon-dashboard"></span> Status Proses') ?></li>
			<li><?php echo anchor("main/user/datapemohon", "<span class='glyphicon glyphicon-user'></span> Data Pemohon") ?></li>
			
			<li><?php echo anchor("main/user/dokumenpemohon", "<span class='glyphicon glyphicon-list'></span> Dokumen Pemohon") ?></li>
			<li><?php echo anchor('main/user/permohonan', '<span class="glyphicon glyphicon-list-alt"></span> Permohonan Perizinan</a>') ?></li>
		</ul>
		<!--<div class="attribution">Copyright © 2012 Kemkominfo <br> BPPT Provinsi Jawa Barat</div>-->
		<div class="attribution">Copyright © 2015 BPMPT Provinsi Jawa Barat</div>
	</div><!--/.sidebar-->
	*/ ?>
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
